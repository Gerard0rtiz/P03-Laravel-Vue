<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichaje extends Model
{
    use HasFactory;
    protected $fillable = [
        'idUser',
        'fechaFichaje',
        'horaEntrada',
        'horaSalida'
    ];
}
