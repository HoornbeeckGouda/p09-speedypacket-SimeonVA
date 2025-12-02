<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'producten';

    protected $fillable = [
        'naam',
        'beschrijving',
        'prijs',
        'afbeelding',
        'categorie', 
    ];


    protected $casts = [
        'prijs' => 'decimal:2'
    ];

    public function pakketten()
    {
        return $this->hasMany(Pakket::class);
    }
}
