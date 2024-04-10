<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imputacion extends Model
{
    use HasFactory;

    protected $table = 'imputaciones';
    protected $fillable = [
        'idUser',
        'idProyecto',
        'fechaImputacion',
        'horasRealizadas',
        'descripcion'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
