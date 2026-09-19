<?php

namespace App\Http\Controllers;

use App\Models\AiQuestion;
use App\Models\KnowledgeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentAiController extends Controller
{
    // =========================================
    // AI ASSISTANT PAGE
    // =========================================

    public function index()
    {
        return view('student.ai');
    }


    // =========================================
    // AI QUESTION HISTORY
    // =========================================

    public function history()
    {
        $questions = AiQuestion::with(
            'knowledgeArticle'
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'student.ai-history',
            compact('questions')
        );
    }


    // =========================================
    // ASK AI
    // =========================================

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'question' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $question = trim(
            $validated['question']
        );

        $normalizedQuestion =
            $this->normalizeText($question);


        // =========================================
        // GET SEARCH WORDS
        // =========================================

        $keywords = $this->extractKeywords(
            $normalizedQuestion
        );


        // =========================================
        // ADD SYNONYMS
        // =========================================

        $keywords = $this->expandSynonyms(
            $keywords
        );


        // =========================================
        // GET ACTIVE KNOWLEDGE ARTICLES
        // =========================================

        $articles = KnowledgeArticle::with(
            'category'
        )
            ->where('status', true)
            ->get();


        // =========================================
        // SCORE ARTICLES
        // =========================================

        $results = $articles
            ->map(
                function ($article) use (
                    $keywords,
                    $normalizedQuestion
                ) {

                    $score = 0;

                    $title = $this->normalizeText(
                        $article->title ?? ''
                    );

                    $content = $this->normalizeText(
                        $article->content ?? ''
                    );

                    $articleKeywords =
                        $this->normalizeText(
                            $article->keywords ?? ''
                        );


                    // =========================================
                    // EXACT QUESTION MATCH
                    // =========================================

                    if (
                        $normalizedQuestion !== ''
                        &&
                        Str::contains(
                            $title,
                            $normalizedQuestion
                        )
                    ) {
                        $score += 25;
                    }


                    // =========================================
                    // WORD MATCHING
                    // =========================================

                    foreach ($keywords as $keyword) {

                        // Title has highest importance
                        if (
                            Str::contains(
                                $title,
                                $keyword
                            )
                        ) {
                            $score += 6;
                        }


                        // Knowledge keywords
                        if (
                            Str::contains(
                                $articleKeywords,
                                $keyword
                            )
                        ) {
                            $score += 5;
                        }


                        // Content
                        if (
                            Str::contains(
                                $content,
                                $keyword
                            )
                        ) {
                            $score += 2;
                        }
                    }


                    // =========================================
                    // BONUS FOR MULTIPLE MATCHES
                    // =========================================

                    $matchedWords = 0;

                    foreach ($keywords as $keyword) {

                        if (
                            Str::contains(
                                $title . ' '
                                . $articleKeywords
                                . ' '
                                . $content,
                                $keyword
                            )
                        ) {
                            $matchedWords++;
                        }
                    }


                    if ($matchedWords >= 3) {

                        $score += 5;

                    } elseif ($matchedWords >= 2) {

                        $score += 2;
                    }


                    return [
                        'article' => $article,
                        'score' => $score,
                    ];

                }
            )
            ->sortByDesc('score')
            ->values();


        // =========================================
        // BEST RESULT
        // =========================================

        $bestResult = $results->first();


        // Minimum score required before
        // trusting a knowledge article.

        $minimumScore = 4;


        // =========================================
        // ANSWER FOUND
        // =========================================

        if (
            $bestResult
            &&
            $bestResult['score'] >= $minimumScore
        ) {

            $article =
                $bestResult['article'];

            $matchScore =
                $bestResult['score'];


            // =========================================
            // CONFIDENCE
            // =========================================

            [
                $confidenceLabel,
                $confidencePercent
            ] = $this->calculateConfidence(
                $matchScore
            );


            // =========================================
            // FRIENDLIER ANSWER
            // =========================================

            $answer =
                "I found information that should help.\n\n"
                . $article->content;


            // =========================================
            // RELATED ARTICLES
            // =========================================

            $relatedArticles = $results
                ->filter(
                    function ($result) use (
                        $article,
                        $minimumScore
                    ) {

                        return
                            $result['score']
                                >= $minimumScore
                            &&
                            $result['article']->id
                                !== $article->id;

                    }
                )
                ->take(3)
                ->pluck('article');


            // =========================================
            // SAVE QUESTION
            // =========================================

            AiQuestion::create([
                'user_id' =>
                    auth()->id(),

                'knowledge_article_id' =>
                    $article->id,

                'question' =>
                    $question,

                'answer' =>
                    $answer,

                'match_score' =>
                    $matchScore,

                'found_answer' =>
                    true,
            ]);

        }

        // =========================================
        // NO RELIABLE ANSWER
        // =========================================

        else {

            $article = null;

            $matchScore = 0;

            $confidenceLabel = 'No Match';

            $confidencePercent = 0;

            $relatedArticles =
                collect();


            $answer =
                "I couldn't find a reliable answer "
                . "for that question in the university "
                . "knowledge base.\n\n"
                . "Try asking the question using different "
                . "words, check the FAQs, or create a "
                . "support ticket so a staff member can help.";


            AiQuestion::create([
                'user_id' =>
                    auth()->id(),

                'knowledge_article_id' =>
                    null,

                'question' =>
                    $question,

                'answer' =>
                    $answer,

                'match_score' =>
                    0,

                'found_answer' =>
                    false,
            ]);
        }


        return view(
            'student.ai',
            compact(
                'question',
                'answer',
                'article',
                'relatedArticles',
                'confidenceLabel',
                'confidencePercent',
                'matchScore'
            )
        );
    }


    // =========================================
    // NORMALIZE TEXT
    // =========================================

    private function normalizeText(
        string $text
    ): string {

        $text = Str::lower($text);

        $text = preg_replace(
            '/[^a-z0-9\s]/',
            ' ',
            $text
        );

        $text = preg_replace(
            '/\s+/',
            ' ',
            $text
        );

        return trim($text);
    }


    // =========================================
    // EXTRACT IMPORTANT WORDS
    // =========================================

    private function extractKeywords(
        string $question
    ) {

        $stopWords = [
            'a',
            'an',
            'the',
            'is',
            'are',
            'am',
            'i',
            'my',
            'me',
            'we',
            'our',
            'you',
            'your',
            'how',
            'what',
            'where',
            'when',
            'why',
            'who',
            'can',
            'could',
            'would',
            'should',
            'do',
            'does',
            'did',
            'to',
            'for',
            'of',
            'in',
            'on',
            'at',
            'and',
            'or',
            'please',
            'help',
            'with',
            'about',
            'from',
        ];


        $words = preg_split(
            '/\s+/',
            $question
        );


        return collect($words)
            ->filter(
                function ($word) use (
                    $stopWords
                ) {

                    return
                        strlen($word) >= 2
                        &&
                        !in_array(
                            $word,
                            $stopWords
                        );

                }
            )
            ->unique()
            ->values();
    }


    // =========================================
    // SYNONYM SUPPORT
    // =========================================

    private function expandSynonyms(
        $keywords
    ) {

        $synonyms = [

            'password' => [
                'login',
                'account',
                'reset',
                'forgot',
            ],

            'login' => [
                'password',
                'account',
                'signin',
            ],

            'exam' => [
                'examination',
                'timetable',
                'results',
            ],

            'examination' => [
                'exam',
                'timetable',
                'results',
            ],

            'fee' => [
                'payment',
                'payments',
                'fees',
            ],

            'payment' => [
                'fee',
                'fees',
                'receipt',
                'accounts',
            ],

            'register' => [
                'registration',
                'enrol',
                'enrollment',
            ],

            'registration' => [
                'register',
                'enrol',
                'semester',
            ],

            'wifi' => [
                'internet',
                'network',
                'connection',
            ],

            'internet' => [
                'wifi',
                'network',
                'connection',
            ],

            'library' => [
                'books',
                'book',
                'borrow',
            ],

        ];


        $expanded = collect(
            $keywords
        );


        foreach ($keywords as $keyword) {

            if (
                isset(
                    $synonyms[$keyword]
                )
            ) {

                foreach (
                    $synonyms[$keyword]
                    as $synonym
                ) {

                    $expanded->push(
                        $synonym
                    );
                }
            }
        }


        return $expanded
            ->unique()
            ->values();
    }


    // =========================================
    // CONFIDENCE CALCULATION
    // =========================================

    private function calculateConfidence(
        int $score
    ): array {

        if ($score >= 20) {

            return [
                'High',
                95
            ];
        }


        if ($score >= 12) {

            return [
                'High',
                85
            ];
        }


        if ($score >= 8) {

            return [
                'Medium',
                70
            ];
        }


        if ($score >= 4) {

            return [
                'Low',
                55
            ];
        }


        return [
            'No Match',
            0
        ];
    }
}