<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierHistorique extends Model
{
    protected $table="dossier_historique";
    protected $fillable=[
        'dossier_id','member_id','description'];
    use HasFactory;
}
