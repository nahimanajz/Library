<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;    
    /** @test */ 
    
    public function a_book_can_be_added_to_a_library(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/book',[
            'title' => 'cool book title',
            'author' => 'cool book author'
        ]);
        $book = Book::first();
        $this->assertCount(1, Book::all()); //check if book is not exist 
        $response->assertRedirect('/book/'. $book->id);    
    }
    /** @test */ 
    public function a_title_is_required() {
        $response = $this->post('/book',[
            'title' => '',
            'author' => 'cool book author'
        ]);
        $response->assertSessionHasErrors('title');
    }
    /** @test */
    public function an_author_is_required(){
        $response = $this->post('/book',[
            'title' => 'cool title',
            'author'=>''
        ]);
        $response->assertSessionHasErrors('author');    
    }
    /** @test */
    public function a_book_can_be_updated(){
        $this->post('/book',[
            'title' => 'New title',
            'author' => 'New Author'
        ]);
        $book = Book::first();
        $response = $this->put($book->path(), [
            'title' => 'New title',
            'author' => 'New Author'
        ]);
        
        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);   
        $response->assertRedirect($book->fresh()->path());
    }
    /** @test */
    public function a_book_can_be_deleted(){
        $this->withoutExceptionHandling();

        $this->post('books',[
            'title' => 'Cool title',
            'body' => 'Victor'
        ]);
        $book = Book::first();
        
        $this->assertCount(1 ,Book::all());

        $response = $this->delete('/book/'.$book->id);
        
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }
}
