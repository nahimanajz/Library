<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Exception;
class Book extends Model
{
    protected $guarded = [];

    public function path(){
        return '/book/'.$this->id;
    }
    public function checkout($user){
        $this->reservations()->create([
          'user_id' => $user->id,
          'checked_out_at' => now()  
        ]);
    }
    public function checkin($user){
       $reservation = $this->reservations()->where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();
            if(is_null($reservation)){
                throw new \Exception();
            }
        $reservation->update([
            'checked_in_at' => now()
        ]);     
    }
    public function setAuthorIDAttribute($author){
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name'=> $author
        ])->id;
    }
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

}
