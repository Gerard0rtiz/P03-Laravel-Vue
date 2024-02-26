<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date_open',
        'date_close'
    ];
}
<<<<<<< HEAD
=======

>>>>>>> 962a4ad8f6ae4bd8a7f551e57bb2078fb8bafcb9
