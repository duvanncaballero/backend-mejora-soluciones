<?php

namespace App\Models\Factura;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'factura_id',
        'articulo',
        'valor_unitario',
        'valor_impuesto',
        'cantidad',
        'valor_total'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'factura_id',
        'created_at',
        'updated_at',
    ];

    public function factura()
    {
        return $this->hasMany(Factura::class,'factura_id','id');
    }
}
