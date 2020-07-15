<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use App\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookCheckoutTest extends TestCase {
    use RefreshDatabase;
    /** @test */
    public function a_book_can_checked_out_by_a_signed_in_user(){
        $this->withoutExceptionHandling();
        
        $book = factory(Book::class)->create();
        $this->actingAs($user = factory(User::class)->create())
                ->post('/checkout/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }
    /** @test */
    public function only_signed_user_can_check_out_a_book(){
        //$this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $this->post('/checkout/' . $book->id)
            ->assertRedirect('/login');
        $this->assertCount(0, Reservation::all());
    }
    /** @test */
    public function only_real_book_can_be_checked_out(){
        $book = factory(Book::class)->create();
        $this->actingAs($user = factory(User::class)->create())
                ->post('/checkout/123')
                ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
    /** @test */
    public function a_book_can_be_checked_in_by_a_signed_user(){
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
                ->post('/checkout/' . $book->id);
        
        $this->actingAs($user)
             ->post('/checkin/' . $book->id);        

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
//        $this->assertEquals(now(), Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }
     /** @test */
     public function only_signed_user_can_check_in_a_book(){
       // $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $this->actingAs(factory(User::class)->create())
            ->post('/checkout/' . $book->id);
        
        Auth::logout();

        $this->post('/checkin/' . $book->id)
            ->assertRedirect('/login');
        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
    }
    /**   @test */ 
     public function a_404_is_thrown_if_a_book_is_not_checked_out_first(){
       $book =  factory(Book::class)->create();
       $user =  factory(User::class)->create();
       $this->actingAs($user)
       ->post('/checkin/'.$book->id)
            ->assertStatus(404);
    }
    
}
