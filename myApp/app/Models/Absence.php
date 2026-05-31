<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    protected $fillable = [
        'stagiaire_id',
        'status',
        'seance',
        'date',
        'startWeek',
        'justification',
        'chemin',
        'medecin',
    ];

    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id', 'cef');
    }
}
