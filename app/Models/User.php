<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    public function proyectos(){
        return $this->belongsToMany(Proyecto::class, 'user_proyectos', 'idUser', 'idProyecto');
    }

    public function tecnologias()
    {
        return $this->belongsToMany(Tecnologia::class, 'tecnologia_user', 'idUser', 'idTecnologia')->withPivot('nivel')->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user', 'idUser', 'idSkill')->withPivot('nivel')->withTimestamps();
    }

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }
}
