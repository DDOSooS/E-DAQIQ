<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabinet extends Model
{
    protected  $table='cabinet';
    protected $fillable = [
        'nom','dateCreation'
    ];

    // une cabinet peut avoire plusier membre use

    /**
     * @return HasMany
     */
    public function membres(): HasMany
    {
        return $this->hasMany(Membres::class);
    }
    public function clients(): HasMany
    {
        return $this->hasMany(Clients::class,'cabinet_id');
    }
    use HasFactory;
}
