<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    use HasFactory;

    protected $table = 'leveranciers';

    protected $fillable = [
        'naam',
        'contactpersoon',
        'telefoon',
        'email',
        'adres',
        'postcode',
        'plaats',
    ];

    public function pakketten()
    {
        return $this->hasMany(Pakket::class);
    }

    public function producten()
    {
        return $this->hasMany(Product::class);
    }
}