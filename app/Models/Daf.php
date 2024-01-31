<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Daf extends Model
{
    use HasFactory;

    public static function listar_pedidos_pendientes_daf(){
        $query=DB::select("SELECT * FROM listar_pedidos_pendientes_daf()");
        return $query;
    }

    public static function listar_pedidos_articulos_pendientes_daf($no_pedido){
        $query=DB::select("SELECT * FROM listar_pedidos_articulos_pendientes_daf('$no_pedido')");
        return $query;
    }

    public static function actualizar_articulos_daf($usuario, $cantidad, $estado, $id){
        $query=DB::select("SELECT actualizar_articulos_daf('$usuario', '$cantidad', '$estado', '$id')");
        return $query;
    }

    public static function listar_pedidos_valor_daf($valor1, $valor2, $valor3){
        $query=DB::select("SELECT * FROM listar_pedidos_valor_daf('$valor1', '$valor2', '$valor3')");
        return $query;
    }

    public static function verificar_articulo_pedido_aprobado($no_pedido){
        $query=DB::select("SELECT * FROM verificar_articulo_pedido_aprobado('$no_pedido')");
        return $query;
    }

    public static function verificar_articulo_pedido_aprobado_rechazado($no_pedido){
        $query=DB::select("SELECT * FROM verificar_articulo_pedido_aprobado_rechazado('$no_pedido')");
        return $query;
    }

    public static function actualizar_articulos_daf_rechazo($usuario, $no_pedido){
        $query=DB::select("SELECT actualizar_articulos_daf_rechazo('$usuario', '$no_pedido')");
        return $query;
    }

    public static function listar_solicitud_daf(){
        $query=DB::select("SELECT * FROM listar_solicitud_daf()");
        return $query;
    }

    public static function actualizar_observacion_rechazo($no_pedido, $observacion, $usuario){
        $query=DB::select("SELECT actualizar_observacion_rechazo('$no_pedido', '$observacion', '$usuario')");
        return $query;
    }

    public static function actualizar_estado_pedido($no_pedido, $valor, $usuario){
        $query=DB::select("SELECT actualizar_estado_pedido('$no_pedido', '$valor', '$usuario')");
        return $query;
    }

    public static function listar_solicitud_articulos($no_pedido){
        $query=DB::select("SELECT * FROM listar_solicitud_articulos('$no_pedido')");
        return $query;
    }

    public static function actualizar_estaprob_solicitud($usuario, $estado, $id){
        $query=DB::select("SELECT actualizar_estaprob_solicitud('$usuario', '$estado', '$id')");
        return $query;
    }

    public static function listar_solicitud_valor_daf($valor1, $valor2, $valor3){
        $query=DB::select("SELECT * FROM listar_solicitud_valor_daf('$valor1', '$valor2', '$valor3')");
        return $query;
    }
    
}
