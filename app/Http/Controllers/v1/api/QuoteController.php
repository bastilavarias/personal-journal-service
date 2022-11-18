<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\SaveQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(SaveQuoteRequest $request)
    {
        $quotes = $request->input('quotes');
        foreach ($quotes as $value) {
            Quote::create([
                'content' => $value['text'],
                'author' => $value['author'],
            ]);
        }

        return customResponse()
            ->data([])
            ->message('Quotes was successfully saved.')
            ->success()
            ->generate();
    }

    public function show()
    {
        $id = rand(1, 100);
        $quote = Quote::find($id);

        return customResponse()
            ->data($quote)
            ->message('You have successfully get featured quote.')
            ->success()
            ->generate();
    }
}
