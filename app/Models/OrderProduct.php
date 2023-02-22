<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_order',
        'id_product',
        'detail',
    ];

    // funciones publicas
    public function obtenerObjDatos(): array
    {
        return [
            'id_order' => $this->id_order,
            'id_product' => $this->id_product,
            'detail' => $this->detail,
        ];
    }
}
