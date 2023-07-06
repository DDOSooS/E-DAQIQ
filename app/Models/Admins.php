<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Admins extends Model
{
    // Specify the table name if different from "users"
    protected $table = 'admins';
    use HasFactory ;
}
