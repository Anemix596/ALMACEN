<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Cotizador extends Model
{
    use HasFactory;

    public static function proveedor_aleatorio($id)
    {
        $query = DB::select("SELECT * FROM proveedor_aleatorio('$id')");
        return $query;
    }

    public static function listar_pedidos_pendientes_cotizador($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_cotizador('$usuario')");
        return $query;
    }

    public static function listar_pedidos_pendientes_cotizador2($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_cotizador2('$usuario')");
        return $query;
    }

    public static function listar_pedidos_pendientes_cotizador3($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_cotizador3('$usuario')");
        return $query;
    }

    public static function listar_pedidos_pendientes_cotizador4($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_cotizador4('$usuario')");
        return $query;
    }

    public static function listar_pedidos_pendientes_cotizador5($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_cotizador5('$usuario')");
        return $query;
    }

    public static function listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_articulos_pendientes_cotizador('$no_pedido', $usuario)");
        return $query;
    }

    public static function cantidad_solicitud_cotizador2($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM cantidad_solicitud_cotizador2('$no_pedido', $usuario)");
        return $query;
    }

    public static function cantidad_solicitud_cotizador($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM cantidad_solicitud_cotizador('$no_pedido', $usuario)");
        return $query;
    }

    public static function actualizar_cotizador($no_solicitud, $estado, $usuario, $modalidad)
    {
        $query = DB::select("SELECT actualizar_cotizador('$no_solicitud', '$estado', '$usuario', '$modalidad')");
        return $query;
    }

    public static function actualizar_estado_prov_nacional($id_cotizacion, $valor)
    {
        $query = DB::select("SELECT actualizar_estado_prov_nacional('$id_cotizacion', '$valor')");
        return $query;
    }

    public static function listar_pedidos_proveedor_cotizador($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_proveedor_cotizador('$usuario')");
        return $query;
    }

    public static function insertar_cotizacion($id_solicitud, $id_sol_det, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT insertar_cotizacion('$id_solicitud', '$id_sol_det', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function insertar_prov_nacional($id_solicitud, $id_sol_det, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT insertar_prov_nacional('$id_solicitud', '$id_sol_det', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function listar_cotizacion($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_cotizacion('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function listar_prov_nacional($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_prov_nacional('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function listar_prov_nacional3($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_prov_nacional3('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function cantidad_prov_nacional($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM cantidad_prov_nacional('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function listar_proveedor()
    {
        $query = DB::select("SELECT * FROM listar_proveedor()");
        return $query;
    }

    public static function listar_modalidad()
    {
        $query = DB::select("SELECT * FROM listar_modalidad()");
        return $query;
    }

    public static function tipo_modalidad($solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM tipo_modalidad('$solicitud', '$usuario')");
        return $query;
    }

    public static function actualizar_cotizacion($fecha_cotizacion, $proveedor, $precio, $cumplimiento, $id, $oferta, $tiempo)
    {
        $query = DB::select("SELECT actualizar_cotizacion('$fecha_cotizacion', '$proveedor', '$precio', '$cumplimiento', '$id', '$oferta', '$tiempo')");
        return $query;
    }

    public static function actualizar_cotizacion_mod1($id_solicitud, $id_soldet, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT actualizar_cotizacion_mod1('$id_solicitud', '$id_soldet', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function actualizar_cotizacion_mod2($id_solicitud, $id_soldet, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT actualizar_cotizacion_mod2('$id_solicitud', '$id_soldet', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function actualizar_cotizacion_mod3($id_solicitud, $id_soldet, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT actualizar_cotizacion_mod3('$id_solicitud', '$id_soldet', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function actualizar_prov_nacional($fecha_cotizacion, $proveedor, $precio, $cumplimiento, $id, $oferta, $tiempo)
    {
        $query = DB::select("SELECT actualizar_prov_nacional('$fecha_cotizacion', '$proveedor', '$precio', '$cumplimiento', '$id', '$oferta', '$tiempo')");
        return $query;
    }

    public static function actualizar_prov_nacional2($fecha_cotizacion, $proveedor, $precio, $cumplimiento, $id, $oferta, $tiempo, $archivo)
    {
        $query = DB::select("SELECT actualizar_prov_nacional2('$fecha_cotizacion', '$proveedor', '$precio', '$cumplimiento', '$id', '$oferta', '$tiempo', '$archivo')");
        return $query;
    }

    public static function cantidad_cotizacion($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM cantidad_cotizacion('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function obtener_proveedor($id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM obtener_proveedor('$id_solicitud', '$usuario')");
        return $query;
    }

    public static function obtener_datos_cotizacion($id_solicitud, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM obtener_datos_cotizacion('$id_solicitud', '$usuario', '$valor')");
        return $query;
    }

    public static function obtener_datos_prov_nacional($id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM obtener_datos_prov_nacional('$id_solicitud', '$usuario')");
        return $query;
    }

    public static function obtener_datos_prov_nacional2($id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM obtener_datos_prov_nacional2('$id_solicitud', '$usuario')");
        return $query;
    }

    public static function obtener_datos_prov_nacional_orden($id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM obtener_datos_prov_nacional_orden('$id_solicitud', '$usuario')");
        return $query;
    }

    public static function listar_cotizacion2($no_pedido, $id_prov, $id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_cotizacion2('$no_pedido', '$id_prov', '$id_solicitud', '$usuario')");
        return $query;
    }

    public static function listar_prov_nacional2($no_pedido, $id_prov, $id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_prov_nacional2('$no_pedido', '$id_prov', '$id_solicitud', '$usuario')");
        return $query;
    }

    public static function listar_prov_nacional_orden($no_pedido, $id_prov, $id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_prov_nacional_orden('$no_pedido', '$id_prov', '$id_solicitud', '$usuario')");
        return $query;
    }

    public static function obtener_proveedor_orden($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM obtener_proveedor_orden('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function recuperar_datos_orden($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM recuperar_datos_orden('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function recuperar_ultima_orden($id_sol, $id_prov, $id_cot, $usuario)
    {
        $query = DB::select("SELECT * FROM recuperar_ultima_orden('$id_sol', '$id_prov', '$id_cot', '$usuario')");
        return $query;
    }

    public static function insertar_orden($id_sol, $id_prov, $id_cot, $usuario)
    {
        $query = DB::select("SELECT insertar_orden('$id_sol', '$id_prov', '$id_cot', '$usuario')");
        return $query;
    }

    public static function insertar_orden2($id_sol, $id_prov, $id_cot, $usuario, $fecha_cont, $no_cont, $archivo)
    {
        $query = DB::select("SELECT insertar_orden2('$id_sol', '$id_prov', '$id_cot', '$usuario', '$fecha_cont', '$no_cont', '$archivo')");
        return $query;
    }

    public static function actualizar_orden($orden, $id)
    {
        $query = DB::select("SELECT actualizar_orden('$orden', '$id')");
        return $query;
    }

    public static function recuperar_no_orden()
    {
        $query = DB::select("SELECT * FROM recuperar_no_orden()");
        return $query;
    }

    public static function anular_contrato($contrato)
    {
        $query = DB::select("SELECT * FROM anular_contrato('$contrato')");
        return $query;
    }

    public static function verificar_orden($solicitud, $proveedor, $usuario)
    {
        $query = DB::select("SELECT * FROM verificar_orden('$solicitud', '$proveedor', '$usuario')");
        return $query;
    }

    public static function verificar_cotizacion($id_solicitud, $id_sol_det, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT * FROM verificar_cotizacion('$id_solicitud', '$id_sol_det', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function verificar_prov_nacional($id_solicitud, $id_sol_det, $id_articulo, $usuario)
    {
        $query = DB::select("SELECT * FROM verificar_prov_nacional('$id_solicitud', '$id_sol_det', '$id_articulo', '$usuario')");
        return $query;
    }

    public static function recuperar_datos_cotizacion($id_solicitud, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM recuperar_datos_cotizacion('$id_solicitud', '$usuario', '$valor')");
        return $query;
    }

    public static function recuperar_datos_prov_nacional($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM recuperar_datos_prov_nacional('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function recuperar_datos_prov_nacional4($id_solicitud, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM recuperar_datos_prov_nacional4('$id_solicitud', '$usuario', '$valor')");
        return $query;
    }

    public static function recuperar_datos_prov_nacional2($id_solicitud, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM recuperar_datos_prov_nacional2('$id_solicitud', '$usuario', '$valor')");
        return $query;
    }

    public static function recuperar_datos_prov_nacional3($id_solicitud, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM recuperar_datos_prov_nacional3('$id_solicitud', '$usuario', '$valor')");
        return $query;
    }

    public static function listar_todos_orden()
    {
        $query = DB::select("SELECT * FROM listar_todos_orden()");
        return $query;
    }

    public static function insertar_orden_det($id_orden, $id_soldet, $cantidad, $precio, $id_articulo)
    {
        $query = DB::select("SELECT insertar_orden_det('$id_orden', '$id_soldet', '$cantidad', '$precio', '$id_articulo')");
        return $query;
    }

    public static function actualizar_total_orden($id)
    {
        $query = DB::select("SELECT actualizar_total_orden('$id')");
        return $query;
    }

    public static function listar_orden_cotizador($pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_orden_cotizador('$pedido', '$usuario')");
        return $query;
    }

    public static function cantidad_listar_orden_cotizador($pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM cantidad_listar_orden_cotizador('$pedido', '$usuario')");
        return $query;
    }

    public static function cantidad_orden_cotizador($pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM cantidad_orden_cotizador('$pedido', '$usuario')");
        return $query;
    }

    public static function actualizar_estado_orden($id_solicitud, $id_proveedor, $usuario, $valor)
    {
        $query = DB::select("SELECT actualizar_estado_orden('$id_solicitud', '$id_proveedor', '$usuario', '$valor')");
        return $query;
    }

    public static function actualizar_estado_orden2($id_orden, $no_orden, $usuario)
    {
        $query = DB::select("SELECT actualizar_estado_orden2('$id_orden', '$no_orden', '$usuario')");
        return $query;
    }

    public static function actualizar_estado_orden3($id_orden, $no_cont, $usuario)
    {
        $query = DB::select("SELECT actualizar_estado_orden3('$id_orden', '$no_cont', '$usuario')");
        return $query;
    }

    public static function ver_orden_cotizador($pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM ver_orden_cotizador('$pedido', '$usuario')");
        return $query;
    }

    public static function ver_articulos_orden_cotizador($orden, $usuario)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_cotizador('$orden', '$usuario')");
        return $query;
    }

    public static function ver_articulos_orden_cotizador2($contrato, $usuario)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_cotizador2('$contrato', '$usuario')");
        return $query;
    }

    public static function ver_articulos_orden_cotizador_contrato($orden, $usuario)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_cotizador_contrato('$orden', '$usuario')");
        return $query;
    }

    public static function listar_cotizacion3($no_pedido, $id_prov, $id_solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_cotizacion3('$no_pedido', '$id_prov', '$id_solicitud', '$usuario')");
        return $query;
    }

    public static function listar_todo_orden($usuario)
    {
        $query = DB::select("SELECT * FROM listar_todo_orden('$usuario')");
        return $query;
    }

    public static function listar_todo_orden_anpe($usuario)
    {
        $query = DB::select("SELECT * FROM listar_todo_orden_anpe('$usuario')");
        return $query;
    }

    public static function listar_todo_orden_licitacion($usuario)
    {
        $query = DB::select("SELECT * FROM listar_todo_orden_licitacion('$usuario')");
        return $query;
    }

    public static function listar_todo_orden_excepcion($usuario)
    {
        $query = DB::select("SELECT * FROM listar_todo_orden_excepcion('$usuario')");
        return $query;
    }

    public static function datos_cotizacion_id($id)
    {
        $query = DB::select("SELECT * FROM datos_cotizacion_id('$id')");
        return $query;
    }

    public static function monto_total_prov_nacional($proveedor, $solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM monto_total_prov_nacional('$proveedor', '$solicitud', '$usuario')");
        return $query;
    }

    public static function buscar_proveedor($id)
    {
        $query = DB::select("SELECT * FROM buscar_proveedor('$id')");
        return $query;
    }

    public static function estado_cotizacion($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_cotizacion('$no_pedido', '$usuario')");
        return $query;
    }

    public static function estado_cotizacion2($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_cotizacion2('$no_pedido', '$usuario')");
        return $query;
    }

    public static function estado_prov_nacional($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_prov_nacional('$no_pedido', '$usuario')");
        return $query;
    }

    public static function estado_prov_nacional2($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_prov_nacional2('$no_pedido', '$usuario')");
        return $query;
    }

    public static function estado_prov_nacional3($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_prov_nacional3('$no_pedido', '$usuario')");
        return $query;
    }

    public static function estado_prov_nacional4($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_prov_nacional4('$no_pedido', '$usuario')");
        return $query;
    }

    public static function actualizar_estado_cotizacion($no_orden, $id_solicitud, $id_prov, $id_soldet)
    {
        $query = DB::select("SELECT * FROM actualizar_estado_cotizacion('$no_orden', '$id_solicitud', '$id_prov', '$id_soldet')");
        return $query;
    }

    public static function actualizar_estado_cotizacion2($no_cont, $id_solicitud, $id_prov, $id_soldet)
    {
        $query = DB::select("SELECT * FROM actualizar_estado_cotizacion2('$no_cont', '$id_solicitud', '$id_prov', '$id_soldet')");
        return $query;
    }

    public static function listar_todos_recepcion()
    {
        $query = DB::select("SELECT * FROM listar_todos_recepcion()");
        return $query;
    }

    public static function insertar_recepcion($id_pedido, $id_solicitud, $id_orden, $factura, $fecha_fac, $total, $id_prov, $resp_cot, $almacen, $funcionario)
    {
        $query = DB::select("SELECT insertar_recepcion('$id_pedido', '$id_solicitud', '$id_orden', '$factura', '$fecha_fac', '$total', '$id_prov', '$resp_cot', '$almacen', '$funcionario')");
        return $query;
    }

    public static function verificar_recepcion($id_pedido, $id_solicitud, $id_orden, $factura, $fecha_fac, $total, $id_prov, $resp_cot, $almacen, $funcionario)
    {
        $query = DB::select("SELECT * FROM verificar_recepcion('$id_pedido', '$id_solicitud', '$id_orden', '$factura', '$fecha_fac', '$total', '$id_prov', '$resp_cot', '$almacen', '$funcionario')");
        return $query;
    }

    public static function recuperar_ultima_recepcion($id_pedido, $id_solicitud, $id_orden, $factura, $fecha_fac, $total, $id_prov, $resp_cot, $almacen, $funcionario)
    {
        $query = DB::select("SELECT * FROM recuperar_ultima_recepcion('$id_pedido', '$id_solicitud', '$id_orden', '$factura', '$fecha_fac', '$total', '$id_prov', '$resp_cot', '$almacen', '$funcionario')");
        return $query;
    }

    public static function actualizar_recepcion($recepcion, $id)
    {
        $query = DB::select("SELECT actualizar_recepcion('$recepcion', '$id')");
        return $query;
    }

    public static function actualizar_contrato($orden, $fecha, $no, $archivo)
    {
        $query = DB::select("SELECT actualizar_contrato('$orden', '$fecha', '$no', '$archivo')");
        return $query;
    }

    public static function recuperar_no_recepcion($id)
    {
        $query = DB::select("SELECT * FROM recuperar_no_recepcion('$id')");
        return $query;
    }

    public static function insertar_recepcion_det($id_recep, $articulo, $importe, $unidad, $cantidad)
    {
        $query = DB::select("SELECT insertar_recepcion_det('$id_recep', '$articulo', '$importe', '$unidad', '$cantidad')");
        return $query;
    }

    public static function listar_orden_recepcion($orden, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_orden_recepcion('$orden', '$usuario')");
        return $query;
    }

    public static function listar_orden_recepcion2($contrato, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_orden_recepcion2('$contrato', '$usuario')");
        return $query;
    }

    public static function actualizar_datos_recepcion($factura, $fecha_fac, $recepcion)
    {
        $query = DB::select("SELECT actualizar_datos_recepcion('$factura', '$fecha_fac', '$recepcion')");
        return $query;
    }

    public static function listar_cotizacion_recepcion($solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_cotizacion_recepcion('$solicitud', '$usuario')");
        return $query;
    }

    public static function listar_prov_nacional_recepcion($solicitud, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_prov_nacional_recepcion('$solicitud', '$usuario')");
        return $query;
    }

    public static function orden_cotizador_valor($pedido, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM orden_cotizador_valor('$pedido', '$usuario', '$valor')");
        return $query;
    }

    public static function contrato_cotizador_valor($pedido, $usuario, $valor)
    {
        $query = DB::select("SELECT * FROM contrato_cotizador_valor('$pedido', '$usuario', '$valor')");
        return $query;
    }

    public static function verificar_proveedor($nombre, $nombre_comercial)
    {
        $query = DB::select("SELECT * FROM verificar_proveedor('$nombre', '$nombre_comercial')");
        return $query;
    }

    public static function insertar_proveedor($nombre, $nombre_comercial, $nit)
    {
        $query = DB::select("SELECT insertar_proveedor('$nombre', '$nombre_comercial', '$nit')");
        return $query;
    }

    public static function finalizar_recepcion($no_orden, $usuario)
    {
        $query = DB::select("SELECT finalizar_recepcion('$no_orden', '$usuario')");
        return $query;
    }

    public static function finalizar_recepcion2($no_orden, $usuario)
    {
        $query = DB::select("SELECT finalizar_recepcion2('$no_orden', '$usuario')");
        return $query;
    }

    public static function ver_articulos_orden_cotizador_contrato2($orden, $usuario)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_cotizador_contrato2('$orden', '$usuario')");
        return $query;
    }

    public static function verificar_contrato_orden($orden)
    {
        $query = DB::select("SELECT * FROM verificar_contrato_orden('$orden')");
        return $query;
    }

    public static function listar_pedidos_pendientes_cotizador6($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_cotizador6('$usuario')");
        return $query;
    }

    public static function estado_prov_nacional_compra($no_pedido, $usuario)
    {
        $query = DB::select("SELECT * FROM estado_prov_nacional_compra('$no_pedido', '$usuario')");
        return $query;
    }

    public static function listar_prov_nacional_compra($id_solicitud, $id_sol_det, $usuario)
    {
        $query = DB::select("SELECT * FROM listar_prov_nacional_compra('$id_solicitud', '$id_sol_det', '$usuario')");
        return $query;
    }

    public static function listar_pedido_orden_compra($usuario)
    {
        $query = DB::select("SELECT * FROM listar_pedido_orden_compra('$usuario')");
        return $query;
    }
}
