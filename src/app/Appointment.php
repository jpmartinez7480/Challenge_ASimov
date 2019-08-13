<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model{


    protected $fillable = [
        'fullname','email','phone','rut','playlist','day','turn'
    ];

    protected $hidden = [];

}