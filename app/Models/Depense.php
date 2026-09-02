<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'user_id',
        'categorie_id',
        'montant',
        'date',
        'description',
        'justificatif',
        'statut_validation',
    ];

    protected $casts = [
        'montant' => 'encrypted',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(CategorieDepense::class, 'categorie_id');
    }
}
