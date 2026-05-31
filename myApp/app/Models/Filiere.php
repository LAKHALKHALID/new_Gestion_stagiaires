<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filiere extends Model
{
    protected $table = 'filieres';

    protected $primaryKey = 'code_f';
    public $incrementing = false;   // because PK is string
    protected $keyType = 'string';

    protected $fillable = [
        'code_f',
        'niveau',
        'mode_formation',
        'description',
        'secteur',
        'nom_filiere_francais',
        'nom_filiere_arabe',
    ];

    public function groupes():HasMany{
        return $this->hasMany(Groupe::class, 'filiere_id', 'code_f');
    }

    public function stagiaires():BelongsToMany{
        return $this->belongsToMany(Stagiaire::class ,'filiere_stagiaire','filiere_id', 'stagiaire_id','code_f','cef');
    }
}
