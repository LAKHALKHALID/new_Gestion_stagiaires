<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'stagiaire_id',
        'note',
        'motif',
    ];

    public function stagiaire():BelongsTo{
        return $this->belongsTo(Stagiaire::class,'stagiaire_id','cef');
    }
}
