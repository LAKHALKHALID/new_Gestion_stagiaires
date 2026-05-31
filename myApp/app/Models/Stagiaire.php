<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stagiaire extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cef',
        'cin',
        'nom_francais',
        'prenom_francais',
        'nom_arabe',
        'prenom_arabe',
        'nom_annee_scolaire',
        'date_naissance',
        'lieu_naissance',
        'mode_formation',
        'niveau_formation',
        'type_formation',
        'annee_etude',
        'date_demarrage_formation',
        'tel',
        'note',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('selecte_by_nom_annee_scolaire', function ($builder) {
            // If the admin selected a year, use it. Otherwise, use '2025/2026' as default.
            $year = session('selected_annee', '2025/2026');

            $builder->where('nom_annee_scolaire', $year);
        });
    }

    protected $primaryKey = 'cef';
    public $incrementing = false;
    protected $keyType = 'string';

    public function filieres():BelongsToMany{
        return $this->belongsToMany(Filiere::class,'filiere_stagiaire','stagiaire_id','filiere_id','cef','code_f');
    }

    public function groupes():BelongsToMany{
        return $this->belongsToMany(Groupe::class,'stagiaire_groupe', 'stagiaire_id','groupe_id','cef','code_g');
    }

    public function absences():HasMany{
        return $this->hasMany(Absence::class,'stagiaire_id','cef');
    }

    public function comportements():HasMany{
        return $this->hasMany(Comportement::class,'stagiaire_id','cef');
    }

    public function transactions():HasMany{
        return $this->hasMany(Transaction::class,'stagiaire_id','cef');
    }

    public function bac():HasOne{
        return $this->hasOne(Bac::class,'stagiaire_id','cef');
    }

    public function deperditions()
    {
        return $this->hasMany(Deperdition::class, 'stagiaire_id', 'cef');
    }

    public function engagements():HasMany{
        return $this->hasMany(Engagement::class,'stagiaire_id','cef');
    }
}
