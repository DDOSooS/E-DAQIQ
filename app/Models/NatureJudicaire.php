<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureJudicaire extends Model
{
    protected $table='nature_juridiction';
    protected $fillable=[
        'typeTtribunal','typeDossier','codeTypeDossier'
    ];
    use HasFactory;
}
