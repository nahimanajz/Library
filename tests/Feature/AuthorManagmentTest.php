<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagmentTest extends TestCase
{
    use RefreshDatabase;
   /** @test */
   public function an_author_can_be_created()
     {
     // $this->withoutExceptionHandling();   
        $this->post('/authors', $this->data());
       
       $author= Author::all();
       
       $this->assertCount(1, $author);
       $this->assertInstanceOf(Carbon::class, $author->first()->dob);
      // $this->assertEquals('05/04/1997', $author->first()->dob->format('Y/d/m')); 
    }
   /** @test */
    public function a_name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name'=> '']));
        $response->assertSessionHasErrors();
    }
   /** @test */

    public function a_dob_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['dob'=> '']));
        $response->assertSessionHasErrors();
    }
    private function data() 
    {
        return [
            'name' => 'Author Name',
            'dob' => '05/04/1997'
        ];
    }
}
