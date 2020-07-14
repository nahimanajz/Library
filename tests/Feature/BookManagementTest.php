<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;
use App\Author;
class BookManagementTest extends TestCase
{
    use RefreshDatabase;    
    /** @test */ 
    
    public function a_book_can_be_added_to_a_library(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/book',$this->data());
        $book = Book::first();
        $this->assertCount(1, Book::all()); //check if book is not exist 
        $response->assertRedirect('/book/'. $book->id);    
    }
    /** @test */ 
    public function a_title_is_required() {
        $response = $this->post('/book',array_merge($this->data(),['title'=> '']));
        $response->assertSessionHasErrors('title');
    }
    /** @test */
    public function an_author_is_required(){
        $response = $this->post('/book',array_merge($this->data(),["author_id"=> '']));
        $response->assertSessionHasErrors('author_id');    
    }
    /** @test */
    public function a_book_can_be_updated(){
        $this->post('/book',$this->data());
        $book = Book::first();
        $response = $this->put($book->path(), [
            'title' => 'New title',
            'author_id' => 5
        ]);
        
        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);   
        $response->assertRedirect($book->fresh()->path());
    }
    /** @test */
    public function a_book_can_be_deleted(){
        $this->withoutExceptionHandling();

        $book = factory('App\Book')->create($this->data());
        $book = Book::first();
        $this->assertCount(1 ,Book::all());

        $response = $this->delete('/book/'.$book->id);
        
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }
    
   /** @test */
   public function a_new_author_is_automatically_added() {
       $this->withoutExceptionHandling();
    $this->post('/book', $this->data());
    $book = Book::first();
    $author =  Author::first();

    $this->assertCount(1, Book::all());
    $this->assertEquals($author->id, $book->author_id);


    }
    private function data(){
        return [
            'title'=> 'New title',
            'author_id'=> 'Janvier'
        ];
    }

}
