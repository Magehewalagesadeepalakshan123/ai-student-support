<?php

namespace App\Http\Controllers;

use App\Models\AiQuestion;
use App\Models\KnowledgeArticle;
use App\Services\OpenAiService;
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
    // AI HISTORY
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

    public function ask(
        Request $request,
        OpenAiService $openAi
    ) {

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
            $this->normalizeText(
                $question
            );


        // =========================================
        // EXTRACT SEARCH WORDS
        // =========================================

        $keywords =
            $this->extractKeywords(
                $normalizedQuestion
            );


        // =========================================
        // ADD SYNONYMS
        // =========================================

        $keywords =
            $this->expandSynonyms(
                $keywords
            );


        // =========================================
        // ACTIVE KNOWLEDGE ARTICLES
        // =========================================

        $articles =
            KnowledgeArticle::with(
                'category'
            )
                ->where(
                    'status',
                    true
                )
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


                    $title =
                        $this->normalizeText(
                            $article->title ?? ''
                        );


                    $content =
                        $this->normalizeText(
                            $article->content ?? ''
                        );


                    $articleKeywords =
                        $this->normalizeText(
                            $article->keywords ?? ''
                        );


                    // Exact phrase in title

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


                    $matchedWords = 0;


                    foreach (
                        $keywords
                        as $keyword
                    ) {

                        $matched = false;


                        // Title

                        if (
                            Str::contains(
                                $title,
                                $keyword
                            )
                        ) {

                            $score += 6;

                            $matched = true;
                        }


                        // Admin keywords

                        if (
                            Str::contains(
                                $articleKeywords,
                                $keyword
                            )
                        ) {

                            $score += 5;

                            $matched = true;
                        }


                        // Article content

                        if (
                            Str::contains(
                                $content,
                                $keyword
                            )
                        ) {

                            $score += 2;

                            $matched = true;
                        }


                        if ($matched) {
                            $matchedWords++;
                        }
                    }


                    // Multiple word bonus

                    if ($matchedWords >= 3) {

                        $score += 5;

                    } elseif (
                        $matchedWords >= 2
                    ) {

                        $score += 2;
                    }


                    return [

                        'article' =>
                            $article,

                        'score' =>
                            $score,

                    ];
                }
            )
            ->sortByDesc('score')
            ->values();


        // =========================================
        // BEST RESULT
        // =========================================

        $bestResult =
            $results->first();


        $minimumScore = 4;


        // =========================================
        // RELIABLE ARTICLE FOUND
        // =========================================

        if (
            $bestResult
            &&
            $bestResult['score']
                >= $minimumScore
        ) {

            $article =
                $bestResult['article'];


            $matchScore =
                $bestResult['score'];


            [
                $confidenceLabel,
                $confidencePercent
            ] =
                $this->calculateConfidence(
                    $matchScore
                );


            // =========================================
            // SELECT TRUSTED CONTEXT
            // =========================================

            $contextResults = $results
                ->filter(
                    function ($result) use (
                        $minimumScore
                    ) {

                        return
                            $result['score']
                            >= $minimumScore;
                    }
                )
                ->take(3);


            // =========================================
            // BUILD CONTEXT FOR GENERATIVE AI
            // =========================================

            $context = $contextResults
                ->map(
                    function ($result) {

                        $item =
                            $result['article'];


                        $category =
                            $item->category?->name
                            ?? 'General';


                        return
                            "ARTICLE TITLE: "
                            . $item->title
                            . "\n"
                            . "CATEGORY: "
                            . $category
                            . "\n"
                            . "CONTENT:\n"
                            . $item->content;
                    }
                )
                ->implode(
                    "\n\n--------------------\n\n"
                );


            // =========================================
            // CALL GENERATIVE AI
            // =========================================

            $generatedAnswer =
                $openAi
                    ->generateGroundedAnswer(
                        $question,
                        $context
                    );


            // =========================================
            // FALLBACK
            // =========================================

            if (
                !empty(
                    $generatedAnswer
                )
            ) {

                $answer =
                    $generatedAnswer;

            } else {

                // If API key is missing,
                // API is offline, etc.

                $answer =
                    $article->content;
            }


            // =========================================
            // RELATED ARTICLES
            // =========================================

            $relatedArticles =
                $contextResults
                    ->pluck('article')
                    ->filter(
                        function ($item) use (
                            $article
                        ) {

                            return
                                $item->id
                                !== $article->id;
                        }
                    )
                    ->values();


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
        // NO TRUSTED INFORMATION FOUND
        // =========================================

        else {

            $article = null;

            $matchScore = 0;

            $confidenceLabel =
                'No Match';

            $confidencePercent = 0;

            $relatedArticles =
                collect();


            // IMPORTANT:
            // We do NOT call the generative AI here.
            // This prevents invented university answers.

            $answer =
                "I couldn't find reliable information "
                . "about that question in the university "
                . "knowledge base.\n\n"
                . "Please check the FAQs or create a "
                . "support ticket so a staff member "
                . "can assist you.";


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

        $text =
            Str::lower($text);


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
    // IMPORTANT WORDS
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
    // SYNONYMS
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
                'book',
                'books',
                'borrow',
            ],

        ];


        $expanded =
            collect($keywords);


        foreach (
            $keywords as $keyword
        ) {

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
    // CONFIDENCE
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