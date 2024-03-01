<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imputaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        'fechaImputacion',
        'horasRealizadas',
        'descripcion'
    ];
}
