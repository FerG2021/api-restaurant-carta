<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_category',
        'name',
        'description',
        'price',
        'stock',
        'uuid',
        'image',
    ];

    // funciones publicas
    public function obtenerObjDatos(): array
    {
        return [
            'id_category' => $this->id_category,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'uuid' => $this->uid,
            'image' => $this->image,
        ];
    }
}
