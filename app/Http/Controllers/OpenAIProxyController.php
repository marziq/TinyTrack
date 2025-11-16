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

        $payload = [
            'model' => $request->input('model', 'deepseek/deepseek-r1-distill-llama-70b:free'),
            'messages' => $request->input('messages'),
        ];

        $resp = Http::withToken($apiKey)
            ->post($this->base . '/chat/completions', $payload);

        if ($resp->failed()) {
            return response()->json(['error' => 'AI request failed', 'details' => $resp->body()], 500);
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

        $payload = [
            'model' => $request->input('model', 'deepseek/deepseek-r1-distill-llama-70b:free'),
            'messages' => $request->input('messages'),
        ];

        $resp = Http::withToken($apiKey)
            ->post($this->base . '/chat/completions', $payload);

        if ($resp->failed()) {
            return response()->json(['error' => 'AI request failed', 'details' => $resp->body()], 500);
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
            'model' => $request->input('model', 'deepseek/deepseek-r1-distill-llama-70b:free'),
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert pediatric assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ];

        $resp = Http::withToken($apiKey)
            ->post($this->base . '/chat/completions', $payload);

        if ($resp->failed()) {
            return response()->json(['error' => 'AI request failed', 'details' => $resp->body()], 500);
        }

        return response()->json($resp->json());
    }
}
