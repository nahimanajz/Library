<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Author extends Model
{
    protected $guarded = [];
    protected $dates = ['dob']; //telling carbon to conver this field into dates

    public function setDobAttribute($attribute) {
        $this->attributes['dob'] = Carbon::parse($attribute); 
    }
    
}
