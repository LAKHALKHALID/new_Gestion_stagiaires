<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bac extends Model
{
    protected $table = 'bacs';

    protected $fillable = [
        'stagiaire_id',
        'cne',
        'type_retrait',
        'motif',
        'piece_justification',
        'date_retrait',
        'date_retour',
        'is_returned'
    ];

    public function stagiaire():BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id', 'cef');
    }
}
