<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table='type';
    protected $fillable=[
        'typeHonoraire',
    ];
    /**
     * Insert default records into the 'type' table.
     *
     * @return void
     */
    public static function insertDefaultRecords()
    {
        $defaultRecords = [
            ['typeHonoraire' => 'TPI'],
            ['typeHonoraire' => 'Appel'],
            ['typeHonoraire' => 'Cassation'],
            ['typeHonoraire' => 'Ordonnance'],
            ['typeHonoraire' => 'Appel Après Cassation'],
            ['typeHonoraire' => 'Plainte'],
            ['typeHonoraire' => 'Consultation'],
        ];

        self::query()->insert($defaultRecords);
    }

    /**
     * Define the relationship with the Honoraire model.
     *
     * @return HasMany
     */
    public function honoraires(): HasMany
    {
        return $this->hasMany(Honoraire::class, 'type_id');
    }

    use HasFactory;
}
