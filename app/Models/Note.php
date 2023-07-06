<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{
    protected $table="notes";
    protected $fillable=[
        'dossier_id','numNote','givenAmount','establishNote','created_at'
    ];

    /**
     * @return HasMany
     */
    public function honoraires(): HasMany
    {
        return $this->hasMany(Honoraire::class, 'note_id');
    }

    /**
     * @return HasMany
     */
    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class, 'note_id');
    }

    /**
     * @return HasMany
     */
    public function transition(): HasMany
    {
        return $this->hasMany(Transition::class, 'note_id');
    }


    /**
     * @return BelongsTo
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }
    use HasFactory;
}
