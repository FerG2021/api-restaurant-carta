<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'rating',
        'description',
    ];

    // funciones publicas
    public function obtenerObjDatos(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'rating' => $this->rating,
            'description' => $this->description,
        ];
    }
}
