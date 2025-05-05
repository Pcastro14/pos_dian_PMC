<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'total',
        'fecha',
        'metodo_pago_id',
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles() {
        return $this->hasMany(FacturaDetalle::class);
    }

    public function metodoPago() {
        return $this->belongsTo(MetodoPago::class);
    }
}
