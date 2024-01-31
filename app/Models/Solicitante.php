<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Solicitante extends Model
{
    use HasFactory;

    public static function listar_unidad_solicitante(){
        $query=DB::select("SELECT * FROM listar_unidad_solicitante()");
        return $query;
    }

    public static function listar_grupo_presup(){
        $query=DB::select("SELECT * FROM listar_grupo_presup()");
        return $query;
    }

    public static function listar_part(){
        $query=DB::select("SELECT * FROM listar_part()");
        return $query;
    }

    public static function extraer_id_pedido($id){
        $query=DB::select("SELECT * FROM extraer_id_pedido('$id')");
        return $query;
    }

    public static function extraer_datos_pedido($id){
        $query=DB::select("SELECT * FROM extraer_datos_pedido('$id')");
        return $query;
    }

    public static function buscar_unidad_solicitante($id){
        $query=DB::select("SELECT * FROM buscar_unidad_solicitante('$id')");
        return $query;
    }

    public static function listar_funcionarios(){
        $query=DB::select("SELECT * FROM listar_funcionarios()");
        return $query;
    }

    public static function listar_articulo(){
        $query=DB::select("SELECT * FROM listar_articulo()");
        return $query;
    }

    public static function listar_pedido($no_pedido){
        $query=DB::select("SELECT * FROM listar_pedido('$no_pedido')");
        return $query;
    }

    public static function listar_articulo_categoria($id){
        $query=DB::select("SELECT * FROM listar_articulo_categoria('$id')");
        return $query;
    }

    public static function listar_articulo_part($id){
        $query=DB::select("SELECT * FROM listar_articulo_part('$id')");
        return $query;
    }

    public static function buscar_unidad_articulo($id){
        $query=DB::select("SELECT * FROM buscar_unidad_articulo('$id')");
        return $query;
    }

    public static function listar_categoria(){
        $query=DB::select("SELECT * FROM listar_categoria()");
        return $query;
    }

    public static function listar_part_presup($id){
        $query=DB::select("SELECT * FROM listar_part_presup('$id')");
        return $query;
    }

    public static function listar_unidad_medida(){
        $query=DB::select("SELECT * FROM listar_unidad_medida()");
        return $query;
    }
    
    public static function verificar_articulo($descrip){
        $query=DB::select("SELECT * FROM verificar_articulo('$descrip')");
        return $query;
    }

    public static function insertar_articulo($descrip, $categoria, $unidad_pieza, $partida){
        $query=DB::select("SELECT insertar_articulo('$descrip', '$categoria', '$unidad_pieza', '$partida')");
        return $query;
    }

    public static function listar_pedidos_realizados($usuario, $fecha_inicio, $fecha_final){
        $query=DB::select("SELECT * FROM listar_pedidos_realizados('$usuario', '$fecha_inicio', '$fecha_final')");
        return $query;
    }

    public static function insertar_pedido($unidad, $motivo, $estruc_prog, $responsable, $usuario){
        $query=DB::select("SELECT insertar_pedido('$unidad', '$motivo', '$estruc_prog', '$responsable', '$usuario')");
        return $query;
    }

    public static function recuperar_pedido_insertado($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final){
        $query=DB::select("SELECT * FROM recuperar_pedido('$unidad', '$motivo', '$estruc_prog', '$responsable', '$usuario', '$fecha_inicio', '$fecha_final')");
        return $query;
    }
    
    public static function recuperar_pedido_insertado2($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final){
        $query=DB::select("SELECT * FROM recuperar_pedido2('$unidad', '$motivo', '$estruc_prog', '$responsable', '$usuario', '$fecha_inicio', '$fecha_final')");
        return $query;
    }

    public static function recuperar_id_pedido(){
        $query=DB::select("SELECT * FROM recuperar_ultimo_nopedido()");
        return $query;
    }
    
    public static function actualizar_pedido($no_pedido, $id){
        $query=DB::select("SELECT actualizar_pedido('$no_pedido', '$id')");
        return $query;
    }

    public static function insertar_pedido_det($id, $articulo, $descripcion, $cant_ped, $unidad_medida){
        $query=DB::select("SELECT insertar_pedido_det('$id', '$articulo', '$descripcion', '$cant_ped', '$unidad_medida')");
        return $query;
    }

    public static function actualizar_pedidodet_archivo($archivo, $id){
        $query=DB::select("SELECT actualizar_pedidodet_archivo('$archivo', '$id')");
        return $query;
    }

    public static function actualizar_presup_pedido($presup, $id){
        $query=DB::select("SELECT actualizar_presup_pedido('$presup', '$id')");
        return $query;
    }

    public static function actualizar_presup_pedido2($presup, $id){
        $query=DB::select("SELECT actualizar_presup_pedido2('$presup', '$id')");
        return $query;
    }

    public static function buscar_grupo_presup($id){
        $query=DB::select("SELECT * FROM buscar_grupo_presup('$id')");
        return $query;
    }

    public static function verificar_pedido($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final){
        $query=DB::select("SELECT * FROM verificar_pedido('$unidad', '$motivo', '$estruc_prog', '$responsable', '$usuario', '$fecha_inicio', '$fecha_final')");
        return $query;
    }

    public static function verificar_pedido_articulo($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final, $articulo, $descripcion){
        $query=DB::select("SELECT * FROM verificar_pedido_articulo('$unidad', '$motivo', '$estruc_prog', '$responsable', '$usuario', '$fecha_inicio', '$fecha_final', '$articulo', '$descripcion')");
        return $query;
    }

    public static function buscar_pedido($id){
        $query=DB::select("SELECT * FROM buscar_pedido('$id')");
        return $query;
    }

    public static function actualizar_datos_pedido($articulo, $descripcion, $cantidad, $unidad_medida, $archivo, $id, $usuario){
        $query=DB::select("SELECT actualizar_datos_pedido('$articulo', '$descripcion', '$cantidad', '$unidad_medida', '$archivo', '$id', '$usuario')");
        return $query;
    }

    public static function eliminar_pedido($id, $usuario){
        $query=DB::select("SELECT eliminar_pedido('$id', '$usuario')");
        return $query;
    }

    public static function eliminar_archivo($id, $usuario){
        $query=DB::select("SELECT eliminar_archivo('$id', '$usuario')");
        return $query;
    }

    public static function listar_pedidos($usuario){
        $query=DB::select("SELECT * FROM listar_pedidos('$usuario')");
        return $query;
    }

    public static function listar_pedidos_anulados($usuario){
        $query=DB::select("SELECT * FROM listar_pedidos_anulados('$usuario')");
        return $query;
    }

    public static function listar_pedidos_articulos($usuario, $no_pedido){
        $query=DB::select("SELECT * FROM listar_pedidos_articulos('$usuario', '$no_pedido')");
        return $query;
    }

    public static function listar_pedidos_articulos_anulados($usuario, $no_pedido){
        $query=DB::select("SELECT * FROM listar_pedidos_articulos_anulados('$usuario', '$no_pedido')");
        return $query;
    }

    public static function cantidad_codificados($no_pedido){
        $query=DB::select("SELECT * FROM cantidad_codificados('$no_pedido')");
        return $query;
    }

    public static function actualizar_pedido_organo($id, $organo){
        $query=DB::select("SELECT actualizar_pedido_organo('$id', '$organo')");
        return $query;
    }

    public static function listar_pedidos_valor_solicitante($alias, $valor1, $valor2, $valor3){
        $query=DB::select("SELECT * FROM listar_pedidos_valor_solicitante('$alias', '$valor1', '$valor2', '$valor3')");
        return $query;
    }

    public static function listar_todos_pedidos(){
        $query=DB::select("SELECT * FROM listar_todos_pedidos()");
        return $query;
    }

}
