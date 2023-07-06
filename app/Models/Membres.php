<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Parental\HasParent;

class Membres extends Model
{
    protected $table = 'members';
    protected $fillable=[
      'typeMembre','user_id','cabinet_id'
    ];

    /**
     * un membre apartient a une seule cabinet
     */
    public function cabinet():BelongsTo{
        return $this->belongsTo(Cabinet::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
