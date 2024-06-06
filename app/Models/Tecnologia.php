<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    public function users(){
        return $this->belongsToMany(User::class, 'tecnologia_users', 'idTecnologia', 'idUser');
    }

    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
}
