<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function users(){
        return $this->belongsToMany(User::class, 'skill_user', 'idSkill', 'idUser')->withPivot('nivel');
    }

    use HasFactory;
    protected $fillable = [
        'nombre'
    ];
}
