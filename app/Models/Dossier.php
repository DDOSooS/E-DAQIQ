<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dossier extends Model
{
    protected $table="dossier";
    protected $fillable=[
        'client_id','member_id','nature_id','votreReference','typeJuridiction','villeJuridiction','sectionJuridiction',
        'jugeRapporteur','etatProcedurale','dateEtatProcedurale','numDecision','dateDecision','numJuridiction','status'
    ];

    /**
     * @return HasMany
     */
    public function Pieces(): HasMany
    {
        return $this->hasMany(Piece::class, 'dossier_id');
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    /**
     * @return HasMany
     */
    public function note(): HasMany
    {
        return $this->hasMany(Note::class, 'dossier_id');
    }
    use HasFactory;
}
