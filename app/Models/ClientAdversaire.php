<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class ClientAdversaire extends Model
{
    protected $table="client_adversaire";
    protected $fillable=[
        'client_id','adversaire_id'
    ];
    use HasFactory;
}
