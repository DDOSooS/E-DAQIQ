<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientsHistorique extends Clients
{
    protected  $table='client_historiques';
    protected $fillable=[
        'client_id','membreId','description','created_at'
    ];
    /**
     * une historique depond a un seule client
     */
    public function client():BelongsTo{
        return $this->belongsTo(Clients::class);
    }
    use HasFactory;
}
