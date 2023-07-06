<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NatureFrais extends Model
{
    protected $table='natureFrais';
    protected $fillable=['titleFrais'];

    /**
     * Insert default records into the 'type' table.
     *
     * @return void
     */
    public static function insertDefaultRecords()
    {
        $defaultRecords = [
            ['titleFrais' => 'Huissier'],
            ['titleFrais' => 'Vignette'],
            ['titleFrais' => 'Taxe Judiciaire'],
            ['titleFrais' => 'Déplacement'],
        ];

        self::query()->insert($defaultRecords);
    }

    /**
     * @return HasMany
     */
    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class, 'nature_id');
    }

    use HasFactory;
}
