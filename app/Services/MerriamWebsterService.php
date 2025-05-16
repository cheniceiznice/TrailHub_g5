<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MerriamWebsterService
{
    public function lookup($word)
    {
        $base = env('MW_API_BASE');
        $key = env('MW_API_KEY');

        $response = Http::get("{$base}{$word}?key={$key}");

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Unable to fetch definition',
            'status' => $response->status()
        ];
    }
}
