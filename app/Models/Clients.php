<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clients extends Model

{
    protected  $table='clients';
    protected $childTypes = [
        'ClientsPhysique' => ClientsPhysique::class,
        'ClientsSociete' => ClientsSociete::class,
    ];

    protected $fillable=[
        'reference','ice','adresse','telephone','cabinet-id','member-id'
    ];
    /*
     * un client appartient a une seule Cabinet
     */
    /**
     * @return BelongsTo
     */
    public function cabinet():BelongsTo{
      return  $this->belongsTo(Cabinet::class,'cabinet_id');
    }

    /**
     * each client has one client type
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ClientsPhysique(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ClientsPhysique::class, 'client_id');
    }


    public function dossier(): HasMany
    {
        return $this->hasMany(Dossier::class, 'client_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * client de type societe data
     */
    public function ClientsSociete(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ClientsSociete::class, 'client_id');
    }

    /**
     * un client peut avoire plusieur historique
     * @return HasMany
     */
    public function ClientsHistorique():HasMany{

        return $this->hasMany(ClientsHistorique::class);

    }

    /**
     * @return BelongsToMany
     */
    public function adversaires(): BelongsToMany
    {
        return $this->belongsToMany(Adversaire::class, 'client_adversaire');
    }

    use HasFactory;
}
