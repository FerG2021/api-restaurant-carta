<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'state',
        'qr',
    ];

    // funciones publicas
    public function obtenerObjDatos(): array
    {
        return [
            'name' => $this->name,
            'state' => $this->state,
            'qr' => $this->qr,
        ];
    }

}
