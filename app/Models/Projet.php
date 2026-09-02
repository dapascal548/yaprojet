<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'client',
        'description',
        'date_debut',
        'date_fin_prevue',
        'date_fin_reelle',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devis()
    {
        return $this->hasOne(Devis::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function getTotalRevenusAttribute()
    {
        return $this->devis ? $this->devis->montant_total : 0;
    }

    public function getTotalDepensesAttribute()
    {
        return $this->depenses->where('statut_validation', 'validee')->sum('montant');
    }

    public function getResultatAttribute()
    {
        return $this->total_revenus - $this->total_depenses;
    }
}
