<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $table = 'devis';

    protected $fillable = [
        'projet_id',
        'main_oeuvre',
        'materiel',
        'transport',
        'autres_couts',
    ];

    protected $casts = [
        'main_oeuvre' => 'encrypted',
        'materiel' => 'encrypted',
        'transport' => 'encrypted',
        'autres_couts' => 'encrypted',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function getMontantTotalAttribute()
    {
        return (float)$this->main_oeuvre + (float)$this->materiel + (float)$this->transport + (float)$this->autres_couts;
    }
}
