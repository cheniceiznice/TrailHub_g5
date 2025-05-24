<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MyleBookService  // Update service name
{
    public function lookup($word)
    {
        $base = env('MYLE_BOOK_API_BASE');
        $key = env('MYLE_BOOK_API_KEY');

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
