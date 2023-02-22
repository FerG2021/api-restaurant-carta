<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_table',
        'client_name',
        'price',
        'state',
    ];

    // funciones publicas
    public function obtenerObjDatos(): array
    {
        return [
            'id_table' => $this->id_table,
            'client_name' => $this->client_name,
            'price' => $this->price,
            'state' => $this->state,
        ];
    }
}
