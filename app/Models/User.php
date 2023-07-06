<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User  extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the table name if different from "users"
    protected $table = 'users';

    //child tables


    // The attributes that are mass assignable.
    protected $fillable = [
        'name','lastname', 'email', 'password','phone','type','adresse','original_password'
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
         'password','remember_token',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //membre

    /**
     * @return HasOne
     */
    public function member()
    {
        return $this->hasOne(Membres::class, 'user_id');
    }
    use HasFactory;
}
