<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Presupuesto extends Model
{
    use HasFactory;

    public static function listar_pedidos_pendientes(){
        $query=DB::select("SELECT * FROM listar_pedidos_pendientes()");
        return $query;
    }

    public static function listar_pedidos_articulos_pendientes($no_pedido){
        $query=DB::select("SELECT * FROM listar_pedidos_articulos_pendientes('$no_pedido')");
        return $query;
    }

    public static function actualizar_observacion_rechazo($no_pedido, $observacion, $usuario){
        $query=DB::select("SELECT actualizar_observacion_rechazo('$no_pedido', '$observacion', '$usuario')");
        return $query;
    }

    public static function listar_organo(){
        $query=DB::select("SELECT * FROM listar_organo()");
        return $query;
    }

    public static function listar_fuente(){
        $query=DB::select("SELECT * FROM listar_fuente()");
        return $query;
    }

    public static function listar_presupuesto(){
        $query=DB::select("SELECT * FROM listar_presupuesto()");
        return $query;
    }

    public static function buscar_fuente($id){
        $query=DB::select("SELECT * FROM buscar_fuente('$id')");
        return $query;
    }

    public static function obtener_cod_presup($id){
        $query=DB::select("SELECT * FROM obtener_cod_presup('$id')");
        return $query;
    }

    public static function fuente_organo($id_fuente, $id_organo){
        $query=DB::select("SELECT * FROM fuente_organo('$id_fuente', '$id_organo')");
        return $query;
    }

    public static function buscar_organo($id){
        $query=DB::select("SELECT * FROM buscar_organo('$id')");
        return $query;
    }

    public static function buscar_presupuesto($id){
        $query=DB::select("SELECT * FROM buscar_presupuesto('$id')");
        return $query;
    }

    public static function actualizar_pedido_presupuesto_aprobado($usuario, $cant_aprobada, $presupuesto, $id_pedido){
        $query=DB::select("SELECT actualizar_pedido_presupuesto_aprobado('$usuario', '$cant_aprobada', '$presupuesto', '$id_pedido')");
        return $query;
    }

    public static function actualizar_pedido_presupuesto_rechazado($usuario, $id_pedido){
        $query=DB::select("SELECT actualizar_pedido_presupuesto_rechazado('$usuario', '$id_pedido')");
        return $query;
    }

    public static function buscar_pedido_articulo($id){
        $query=DB::select("SELECT * FROM buscar_pedido_articulo('$id')");
        return $query;
    }

    public static function verificar_cantidad_articulo_pedido($no_pedido){
        $query=DB::select("SELECT verificar_cantidad_articulo_pedido('$no_pedido')");
        return $query;
    }

    public static function verificar_articulo_pedido_codificado($no_pedido){
        $query=DB::select("SELECT verificar_articulo_pedido_codificado('$no_pedido')");
        return $query;
    }

    public static function verificar_articulo_pedido_codificado_aprobado($no_pedido){
        $query=DB::select("SELECT verificar_articulo_pedido_codificado_aprobado('$no_pedido')");
        return $query;
    }

    public static function verificar_articulo_pedido_codificado_rechazado($no_pedido){
        $query=DB::select("SELECT verificar_articulo_pedido_codificado_rechazado('$no_pedido')");
        return $query;
    }

    public static function actualizar_estado_pedido($no_pedido, $valor, $usuario){
        $query=DB::select("SELECT actualizar_estado_pedido('$no_pedido', '$valor', '$usuario')");
        return $query;
    }

    public static function buscar_fuentefnto_pedido($no_pedido){
        $query=DB::select("SELECT * FROM buscar_fuentefnto_pedido('$no_pedido')");
        return $query;
    }

    public static function actualizar_fuente_fnto($no_pedido, $fuente, $organo, $fuente_fnto, $usuario){
        $query=DB::select("SELECT actualizar_fuente_fnto('$no_pedido', '$fuente', '$organo', '$fuente_fnto', '$usuario')");
        return $query;
    }

    public static function listar_pedidos_valor($valor1, $valor2, $valor3){
        $query=DB::select("SELECT * FROM listar_pedidos_valor('$valor1', '$valor2', '$valor3')");
        return $query;
    }

    public static function actualizar_estado_aprobado($no_pedido, $usuario){
        $query=DB::select("SELECT actualizar_estado_aprobado('$no_pedido', '$usuario')");
        return $query;
    }

}
