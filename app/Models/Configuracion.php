<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuraciones';
    protected $fillable = ['clave', 'valor'];

    public static function obtener($clave)
    {
        return optional(self::where('clave', $clave)->first())->valor ?? '';
    }

    public static function getDatosEmpresa()
    {
        return [
            'nombre'     => self::obtener('nombre_empresa'),
            'nit'        => self::obtener('nit_empresa'),
            'direccion'  => self::obtener('direccion_empresa'),
            'telefono'   => self::obtener('telefono_empresa'),
            'mensaje'    => self::obtener('mensaje_factura'),
        ];
    }
}
