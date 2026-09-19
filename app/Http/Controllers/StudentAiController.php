<?php

namespace App\Http\Controllers;

use App\Models\AiQuestion;
use App\Models\KnowledgeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentAiController extends Controller
{
    // =========================================
    // AI PAGE
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
    // PROCESS QUESTION
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
            Str::lower($question);


        // Words that are not useful
        // when searching knowledge articles.

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
            'how',
            'what',
            'where',
            'when',
            'why',
            'can',
            'could',
            'do',
            'does',
            'to',
            'for',
            'of',
            'in',
            'on',
            'and',
            'or',
            'please',
            'help',
            'with',
        ];


        $cleanQuestion = preg_replace(
            '/[^a-zA-Z0-9\s]/',
            ' ',
            $normalizedQuestion
        );


        $words = preg_split(
            '/\s+/',
            $cleanQuestion
        );


        $keywords = collect($words)
            ->filter(
                function ($word) use ($stopWords) {

                    return strlen($word) >= 2
                        && !in_array(
                            $word,
                            $stopWords
                        );

                }
            )
            ->unique()
            ->values();


        // Active Knowledge Base articles

        $articles = KnowledgeArticle::with(
            'category'
        )
            ->where('status', true)
            ->get();


        // Calculate relevance score

        $results = $articles
            ->map(
                function ($article) use (
                    $keywords,
                    $normalizedQuestion
                ) {

                    $score = 0;


                    $title = Str::lower(
                        $article->title ?? ''
                    );


                    $content = Str::lower(
                        $article->content ?? ''
                    );


                    $articleKeywords =
                        Str::lower(
                            $article->keywords ?? ''
                        );


                    // Exact question phrase

                    if (
                        $normalizedQuestion !== ''
                        &&
                        Str::contains(
                            $title,
                            $normalizedQuestion
                        )
                    ) {
                        $score += 20;
                    }


                    foreach (
                        $keywords as $keyword
                    ) {

                        // Title = strongest

                        if (
                            Str::contains(
                                $title,
                                $keyword
                            )
                        ) {
                            $score += 5;
                        }


                        // Keywords field

                        if (
                            Str::contains(
                                $articleKeywords,
                                $keyword
                            )
                        ) {
                            $score += 4;
                        }


                        // Article content

                        if (
                            Str::contains(
                                $content,
                                $keyword
                            )
                        ) {
                            $score += 1;
                        }
                    }


                    return [
                        'article' => $article,
                        'score' => $score,
                    ];

                }
            )
            ->sortByDesc('score')
            ->values();


        $bestResult = $results->first();


        // =========================================
        // ANSWER FOUND
        // =========================================

        if (
            $bestResult
            &&
            $bestResult['score'] > 0
        ) {

            $article =
                $bestResult['article'];

            $matchScore =
                $bestResult['score'];

            $answer =
                $article->content;


            $relatedArticles = $results
                ->filter(
                    function ($result) use (
                        $article
                    ) {

                        return
                            $result['score'] > 0
                            &&
                            $result['article']->id
                                !== $article->id;

                    }
                )
                ->take(3)
                ->pluck('article');


            // Save question history

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
        // NO ANSWER FOUND
        // =========================================

        else {

            $article = null;

            $matchScore = 0;

            $relatedArticles =
                collect();


            $answer =
                "I couldn't find a suitable answer "
                . "in the knowledge base. "
                . "Try asking using different words, "
                . "check the FAQs, or create a "
                . "support ticket.";


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
                'relatedArticles'
            )
        );
    }
}