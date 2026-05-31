<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deperdition extends Model
{
    protected $fillable = [
        'stagiaire_id',
        'raison_deperdition',
        'raison_retour',
        'date_deperdition',
        'date_retour',
    ];

    // Relationship with stagiaire
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id', 'cef');
    }
    
}
