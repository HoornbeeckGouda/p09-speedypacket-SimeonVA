<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pakket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pakketten';

    protected $fillable = [
        'qr_code',
        'track_and_trace',
        'ontvanger_id',
        'product_id',  
        'status',
        'verwachte_leverdatum'
    ];

    protected $casts = [
        'verwachte_leverdatum' => 'date',
    ];

    public function ontvanger()
    {
        return $this->belongsTo(User::class, 'ontvanger_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
