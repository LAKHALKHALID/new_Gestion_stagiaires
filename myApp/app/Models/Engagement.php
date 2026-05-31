<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Engagement extends Model
{
    protected $fillable = [
        'motif',
        'stagiaire_id',
        'date',
    ];

    public function stagiaire(): BelongsTo{
        return $this->belongsTo(Stagiaire::class,'stagiaire_id','cef');
    }
}
