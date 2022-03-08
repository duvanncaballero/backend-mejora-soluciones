<?php

namespace App\Models\Factura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'prefijo',
        'consecutivo',
        'fecha',
        'hora',
        'nit_emisor',
        'emisor',
        'nit_cliente',
        'cliente',
        'total',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'fecha'     => 'date:Y-M-d',
        'hora'      => 'date:h:m A',
    ];    

    public function detalle()
    {
        return $this->hasMany(DetalleFactura::class);
    }
}
