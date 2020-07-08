<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;    
    /** @test */ 
    
    public function a_book_can_be_added_to_a_library(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/book',[
            'title' => 'cool book title',
            'author' => 'cool book author'
        ]);
        $response->assertOk();       
        $this->assertCount(1, Book::all()); //check if book is not exist 

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
        $this->withoutExceptionHandling();
        
        $this->post('/book',[
            'title' => 'cool title',
            'author' => 'janvier'
        ]);
        $book = Book::first();
        $response = $this->patch('/book/'.$book->id,[
            'title' => 'New title',
            'author' => 'New Author'
        ]);
        
        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);   
    }
}
