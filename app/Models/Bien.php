<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Bien extends Model
{
    use HasFactory;

    public static function listar_pedidos_pendientes_bien(){
        $query=DB::select("SELECT * FROM listar_pedidos_pendientes_bien()");
        return $query;
    }

    public static function listar_pedidos_articulos_pendientes_bien($no_pedido){
        $query=DB::select("SELECT * FROM listar_pedidos_articulos_pendientes_bien('$no_pedido')");
        return $query;
    }

    public static function listar_pedidos_valor_bien($valor1, $valor2){
        $query=DB::select("SELECT * FROM listar_pedidos_valor_bien('$valor1', '$valor2')");
        return $query;
    }

    public static function listar_cotizadores(){
        $query=DB::select("SELECT * FROM listar_cotizadores()");
        return $query;
    }

    public static function actualizar_articulos_bien($responsable, $id){
        $query=DB::select("SELECT actualizar_articulos_bien('$responsable', '$id')");
        return $query;
    }

    public static function verificar_articulo_pedido_asignado_bien($no_pedido){
        $query=DB::select("SELECT * FROM verificar_articulo_pedido_asignado_bien('$no_pedido')");
        return $query;
    }

    public static function verificar_articulo_pedido_bien($no_pedido){
        $query=DB::select("SELECT * FROM verificar_articulo_pedido_bien('$no_pedido')");
        return $query;
    }

    public static function actualizar_pedido_bien($usuario, $no_pedido){
        $query=DB::select("SELECT actualizar_pedido_bien('$usuario', '$no_pedido')");
        return $query;
    }

}
