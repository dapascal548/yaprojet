<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieDepense extends Model
{
    use HasFactory;

    protected $table = 'categories_depense';

    protected $fillable = [
        'nom',
    ];

    public function depenses()
    {
        return $this->hasMany(Depense::class, 'categorie_id');
    }
}
