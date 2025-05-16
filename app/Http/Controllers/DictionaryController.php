<?php

namespace App\Http\Controllers;

use App\Services\MerriamWebsterService;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    protected $dictionary;

    public function __construct(MerriamWebsterService $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    public function define(Request $request)
    {
        $word = $request->input('word', 'example');
        $data = $this->dictionary->lookup($word);

        return response()->json($data);
    }
}
