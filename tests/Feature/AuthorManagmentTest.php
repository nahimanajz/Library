<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagmentTest extends TestCase
{
    use RefreshDatabase;
   /** @test */
   public function an_author_can_be_created(){
    $this->withoutExceptionHandling();   
    $this->post('/author',[
           'name' => 'Author Name',
           'dob' => '05/04/1997'
       ]);
       
       $author= Author::all();
       
       $this->assertCount(1, $author);
       $this->assertInstanceOf(Carbon::class, $author->first()->dob);
       $this->assertEquals('05/04/1997', $author->first()->dob->format('Y/d/m')); 
    }
}
