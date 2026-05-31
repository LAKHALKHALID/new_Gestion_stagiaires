<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Groupe extends Model
{
    protected $table = 'groupes';

    protected $primaryKey = 'code_g';
    public $incrementing = false;   // because PK is string
    protected $keyType = 'string';

    protected $fillable = [
        'code_g',
        'nom_g',
        'filiere_id',
        'description',
        'capacite',
    ];

    public function filiere():BelongsTo{
        return $this->belongsTo(Filiere::class,'filiere_id','code_f');
    }

    public function stagiaires():BelongsToMany{
        return $this->belongsToMany(Stagiaire::class,'stagiaire_groupe','groupe_id','stagiaire_id','code_g','cef');
    }
}
