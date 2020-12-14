<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_author_can_be_created()
    {
       $this->withoutExceptionHandling();
       
       $response = $this->post('/authors', [
           'name' => 'Kent Beck',
           'dob' => '1961-01-31',
       ]);

       $this->assertCount(1, Author::all());
       $response->assertRedirect('/authors');
    }

    public function test_a_dob_should_be_formatted()
    {
        $response = $this->post('/authors', [
            'id' => 1,
            'name' => 'Kent Beck',
            'dob' => '1961-01-31',
        ]);

        $this->assertInstanceOf(Carbon::class, Author::find(1)->dob);
        $this->assertEquals('31-01-1961', Author::find(1)->dob->format('d-m-Y'));
    }

    public function test_an_author_name_is_required()
    {
        $response = $this->post('/authors', [
            'id' => 1,
            'name' => '',
            'dob' => '1961-01-31',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_an_author_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/authors', [
            'id' => 1,
            'name' => 'Kent Beck',
            'dob' => '1961-01-31',
        ]);

        $response = $this->put('/authors/1', [
            'name' => 'New name',
            'dob' => '1999-01-31',
        ]);   

        $this->assertEquals('New name', Author::find(1)->name);
        $this->assertEquals('31-01-1999', Author::find(1)->dob->format('d-m-Y'));
        $response->assertRedirect('/authors/1');
    }

    public function test_an_author_can_be_updated_and_author_name_is_required()
    {
        $this->post('/authors', [
            'id' => 1,
            'name' => 'Kent Beck',
            'dob' => '1961-01-31',
        ]);

        $response = $this->put('/authors/1', [
            'name' => '',
            'dob' => '1999-01-31',
        ]);   

        $response->assertSessionHasErrors('name');
    }

    public function test_an_author_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/authors', [
            'id' => 1,
            'name' => 'Kent Beck',
            'dob' => '1961-01-31',
        ]);

        $response = $this->delete('/authors/1');

        $this->assertCount(0, Author::all());    
        $response->assertRedirect('/authors');

    }
}
