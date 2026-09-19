<?php

namespace App\Http\Controllers;

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
    // PROCESS STUDENT QUESTION
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

        $question = trim($validated['question']);

        // Convert question to lowercase
        $normalizedQuestion = Str::lower($question);

        // Remove common words that are not useful for searching
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

        // Split the question into words
        $words = preg_split(
            '/\s+/',
            preg_replace(
                '/[^a-zA-Z0-9\s]/',
                ' ',
                $normalizedQuestion
            )
        );

        // Remove empty and common words
        $keywords = collect($words)
            ->filter(function ($word) use ($stopWords) {

                return strlen($word) >= 2
                    && !in_array($word, $stopWords);

            })
            ->unique()
            ->values();


        // Get active knowledge articles
        $articles = KnowledgeArticle::with('category')
            ->where('status', true)
            ->get();


        // Calculate score for every article
        $results = $articles->map(function ($article) use (
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

            $articleKeywords = Str::lower(
                $article->keywords ?? ''
            );


            // Exact phrase match in title
            if (
                $normalizedQuestion !== ''
                && Str::contains(
                    $title,
                    $normalizedQuestion
                )
            ) {
                $score += 20;
            }


            foreach ($keywords as $keyword) {

                // Title matches are strongest
                if (Str::contains($title, $keyword)) {
                    $score += 5;
                }

                // Keyword field matches are also strong
                if (
                    Str::contains(
                        $articleKeywords,
                        $keyword
                    )
                ) {
                    $score += 4;
                }

                // Content match
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

        })
        ->sortByDesc('score')
        ->values();


        // Best matching article
        $bestResult = $results->first();


        if (
            $bestResult
            && $bestResult['score'] > 0
        ) {

            $article = $bestResult['article'];

            $answer = $article->content;


            // Get a few other possible matches
            $relatedArticles = $results
                ->filter(function ($result) use ($article) {

                    return $result['score'] > 0
                        && $result['article']->id
                            !== $article->id;

                })
                ->take(3)
                ->pluck('article');

        } else {

            $article = null;

            $relatedArticles = collect();

            $answer =
                "I couldn't find a suitable answer in the knowledge base. "
                . "You can try asking the question using different words, "
                . "check the FAQs, or create a support ticket.";

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