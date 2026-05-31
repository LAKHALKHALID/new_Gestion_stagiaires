<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comportement extends Model
{
    protected $fillable = [
        'stagiaire_id',
        'sanction',
        'autorite_dec',
        'date',
        'miseEnGarde',
        'motife',
    ];

    public function stagiaire():BelongsTo{
        return $this->belongsTo(Stagiaire::class,'stagiaire_id','cef');
    }
}
