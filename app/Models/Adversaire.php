<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adversaire extends Model
{
    protected $table="adversaire";
    protected $fillable=[
        'nom','prenom','adresse1','adresse2','adresse3'
    ];

    public function clients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Clients::class, 'client_adversaire');
    }

    use HasFactory;
}
