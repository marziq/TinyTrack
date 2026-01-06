<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenAIProxyController extends Controller
{
    protected $base;

    public function __construct()
    {
        $this->base = rtrim(config('services.openrouter.base_uri', 'https://openrouter.ai/api/v1'), '/');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
            'model' => 'nullable|string',
        ]);

        $apiKey = config('services.openrouter.key');

        // prefer server-configured model to avoid clients forcing disallowed/public/free models
        $model = config('services.openrouter.default_model') ?: $request->input('model', 'openai/gpt-oss-120b:free');

        $payload = [
            'model' => $model,
            'messages' => $request->input('messages'),
        ];

        $resp = Http::withToken($apiKey)
            ->post($this->base . '/chat/completions', $payload);

        if ($resp->failed()) {
            // try to decode JSON details for clearer client feedback
            $bodyJson = $resp->json();
            \Log::error('OpenRouter API error', ['status' => $resp->status(), 'body' => $resp->body()]);

            $openrouterMessage = null;
            if (is_array($bodyJson) && isset($bodyJson['error']['message'])) {
                $openrouterMessage = $bodyJson['error']['message'];
            }

            return response()->json([
                'error' => [
                    'message' => $openrouterMessage ?: 'AI request failed',
                    'details' => $bodyJson ?: $resp->body(),
                ]
            ], $resp->status());
        }

        return response()->json($resp->json());
    }

    public function summarize(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
            'model' => 'nullable|string',
        ]);

        $apiKey = config('services.openrouter.key');

        $model = config('services.openrouter.default_model') ?: $request->input('model', 'openai/gpt-oss-120b:free');

        $payload = [
            'model' => $model,
            'messages' => $request->input('messages'),
        ];

        $resp = Http::withToken($apiKey)
            ->post($this->base . '/chat/completions', $payload);

        if ($resp->failed()) {
            $bodyJson = $resp->json();
            \Log::error('OpenRouter API error (summarize)', ['status' => $resp->status(), 'body' => $resp->body()]);
            $openrouterMessage = is_array($bodyJson) && isset($bodyJson['error']['message']) ? $bodyJson['error']['message'] : null;
            return response()->json([
                'error' => [
                    'message' => $openrouterMessage ?: 'AI request failed',
                    'details' => $bodyJson ?: $resp->body(),
                ]
            ], $resp->status());
        }

        return response()->json($resp->json());
    }

    public function recommendation(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'age' => 'required',
            'gender' => 'nullable|string',
            'model' => 'nullable|string',
        ]);

        $apiKey = config('services.openrouter.key');

        $prompt = "A {$request->age} month old {$request->gender} baby has the following growth status:\n{$request->status}. What should the parent do? Give a short, practical, and empathetic recommendation.";

        $payload = [
            'model' => config('services.openrouter.default_model') ?: $request->input('model', 'openai/gpt-oss-120b:free'),
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert pediatric assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ];

        $resp = Http::withToken($apiKey)
            ->post($this->base . '/chat/completions', $payload);

        if ($resp->failed()) {
            $bodyJson = $resp->json();
            \Log::error('OpenRouter API error (recommendation)', ['status' => $resp->status(), 'body' => $resp->body()]);
            $openrouterMessage = is_array($bodyJson) && isset($bodyJson['error']['message']) ? $bodyJson['error']['message'] : null;
            return response()->json([
                'error' => [
                    'message' => $openrouterMessage ?: 'AI request failed',
                    'details' => $bodyJson ?: $resp->body(),
                ]
            ], $resp->status());
        }

        return response()->json($resp->json());
    }
}
