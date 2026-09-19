<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class OpenAiService
{
    public function generateGroundedAnswer(
        string $question,
        string $context
    ): ?string {

        $apiKey = config(
            'services.openai.key'
        );

        $model = config(
            'services.openai.model',
            'gpt-5.6-luna'
        );


        // No API key?
        // Return null so the system can use
        // the normal Knowledge Base answer.

        if (empty($apiKey)) {
            return null;
        }


        try {

            $response = Http::withToken(
                $apiKey
            )
                ->acceptJson()
                ->timeout(30)
                ->post(
                    'https://api.openai.com/v1/responses',
                    [

                        'model' => $model,


                        'instructions' =>
                            'You are an AI Student Support Assistant. '
                            . 'Answer the student using ONLY the '
                            . 'trusted university knowledge-base '
                            . 'context provided to you. '
                            . 'Do not invent university rules, dates, '
                            . 'fees, procedures, contacts, or policies. '
                            . 'If the supplied context does not contain '
                            . 'enough information, clearly say that the '
                            . 'information is not available and suggest '
                            . 'creating a support ticket. '
                            . 'Use clear, friendly and concise language.',


                        'input' =>
                            "STUDENT QUESTION:\n"
                            . $question
                            . "\n\n"
                            . "TRUSTED KNOWLEDGE BASE CONTEXT:\n"
                            . $context,


                        'max_output_tokens' => 400,

                    ]
                );


            if (!$response->successful()) {

                Log::warning(
                    'OpenAI API request failed.',
                    [
                        'status' =>
                            $response->status()
                    ]
                );

                return null;
            }


            $data = $response->json();


            // Find generated text inside
            // the Responses API output.

            foreach (
                $data['output'] ?? []
                as $output
            ) {

                if (
                    ($output['type'] ?? null)
                    !== 'message'
                ) {
                    continue;
                }


                foreach (
                    $output['content'] ?? []
                    as $content
                ) {

                    if (
                        ($content['type'] ?? null)
                        === 'output_text'
                        &&
                        !empty($content['text'])
                    ) {

                        return trim(
                            $content['text']
                        );
                    }
                }
            }


            return null;

        } catch (Throwable $e) {

            Log::warning(
                'OpenAI service error.',
                [
                    'message' =>
                        $e->getMessage()
                ]
            );

            return null;
        }
    }
}