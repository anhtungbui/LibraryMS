<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_new_book_can_be_created()
    {
        $response = $this->post('/books', [
            'title' => 'Introduction to TDD',
            'author' => 'Anh Tung Bui',
            ]);

        $response->assertStatus(200);
        $this->assertCount(1, Book::all());
    }

    public function test_a_book_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Anh Tung Bui',
            ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_a_book_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Introduction to TDD',
            'author' => '',
            ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated()
    {
        $this->post('/books', [
            'id' => 1,
            'title' => 'Introduction to TDD',
            'author' => 'Anh Tung Bui',
        ]);

        $response = $this->put('/books/1', [
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
        $response->assertRedirect('/books/1');
    }

    public function test_a_book_can_be_updated_and_the_book_title_is_required()
    {
        $this->post('/books', [
            'id' => 1,
            'title' => 'Introduction to TDD',
            'author' => 'Anh Tung Bui',
        ]);

        $response = $this->put('/books/1', [
            'title' => '',
            'author' => 'New author'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_a_book_can_be_updated_and_the_book_author_is_required()
    {
        $this->post('/books', [
            'id' => 1,
            'title' => 'Introduction to TDD',
            'author' => 'Anh Tung Bui',
        ]);

        $response = $this->put('/books/1', [
            'title' => 'New title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_deleted()
    {
        $this->post('/books', [
            'id' => 1,
            'title' => 'Introduction to TDD',
            'author' => 'Anh Tung Bui',
        ]);

        $response = $this->delete('/books/1');

        // $response->assertOK();
        $this->assertCount(0, Book::all());
        // $this->assertNull(Book::find(1));   
        $response->assertRedirect('/books');
    }

}
