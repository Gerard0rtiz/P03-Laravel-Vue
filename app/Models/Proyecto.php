<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    public function users(){
        return $this->belongsToMany(User::class, 'user_proyectos', 'idProyecto', 'idUser');
    }

    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
        'idUser'
    ];
}