<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        Author::create($validated);

        return redirect('/authors');
    }

    public function update(Request $request, Author $author)
    {
        $validated = $this->validateRequest($request);

        $author->update($validated);

        return redirect('/authors/' . $author->id);
    }

    public function destroy(Request $request, Author $author)
    {
        $author->delete();

        return redirect('/authors/');
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'dob' => '',
        ]);
    }
}
