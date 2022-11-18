<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Journal\JournalStoreEntryRequest;
use App\Http\Requests\Journal\JournalUpdateEntryRequest;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    public function store(JournalStoreEntryRequest $request)
    {
        $title = $request->input('title');
        $entry = Journal::create([
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'content' => $request->input('content'),
        ]);

        return customResponse()
            ->data($entry)
            ->message('Journal entry today was created.')
            ->success()
            ->generate();
    }

    public function index(Request $request)
    {
        $sortBy = $request->sort_by ? $request->sort_by : 'created_at';
        $orderBy = $request->order_by ? $request->order_by : 'desc';
        $page = $request->page ? intval($request->page) : 1;
        $perPage = $request->per_page ? intval($request->per_page) : 10;
        $query = Journal::query();
        $query->orderBy($sortBy, $orderBy);
        $entries = $query->paginate($perPage, ['*'], 'page', $page);

        return customResponse()
            ->data($entries)
            ->message('You have successfully get journal entries.')
            ->success()
            ->generate();
    }

    public function show($slug)
    {
        $entry = Journal::where('slug', $slug)->first();
        if (empty($entry)) {
            return customResponse()
                ->data(null)
                ->message('You have successfully get specific journal entry.')
                ->success()
                ->generate();
        }

        return customResponse()
            ->data($entry)
            ->message('You have successfully get specific journal entry.')
            ->success()
            ->generate();
    }

    public function update(JournalUpdateEntryRequest $request, Journal $entry)
    {
        $entry = $entry->update(['content' => $request->input('content')]);

        return customResponse()
            ->data($entry)
            ->message('Journal entry was updated.')
            ->success()
            ->generate();
    }
}
