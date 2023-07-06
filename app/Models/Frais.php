<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Frais extends Model
{
    protected $table='frais';
    protected $fillable=[
      'note_id','nature_id','detail','amountInWord','amountInFigure',
    ];

    /**
     * @return BelongsTo
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'note_id');
    }

    /**
     * @return BelongsTo
     */
    public function natureFrais(): BelongsTo
    {
        return $this->belongsTo(NatureFrais::class, 'nature_id');
    }
    use HasFactory;
}
