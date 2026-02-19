<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'isbn',
        'copias_totales',
        'copias_disponibles',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}