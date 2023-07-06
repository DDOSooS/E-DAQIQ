<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsSociete extends Clients
{
    protected $table='client_societes';
    protected $fillable=[
        'rc','nomSte','gerant','seige'
    ];
    use HasFactory;
}
