<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Book::create($this->validateRequest($request));
    }

    public function show(Book $book)
    {
        //
    }

    public function edit(Book $book)
    {
        //
    }

    public function update(Request $request, Book $book)
    {
        $book->update($this->validateRequest($request));
    }

    public function destroy(Book $book)
    {
        $book->delete();
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }
}
