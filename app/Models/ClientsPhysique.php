<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsPhysique extends Clients
{
    protected $table='client_physiques';
    protected $fillable=[
        'cin','nom','prenom',
    ];
    use HasFactory;
}
