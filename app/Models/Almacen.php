<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Almacen extends Model
{
    use HasFactory;

    public static function listar_pedidos_pendientes_almacen()
    {
        $query = DB::select("SELECT * FROM listar_pedidos_pendientes_almacen()");
        return $query;
    }

    public static function listar_pedidos_articulos_pendientes_almacen($no_pedido)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_articulos_pendientes_almacen('$no_pedido')");
        return $query;
    }

    public static function listar_pedidos_articulos_rechazados_almacen($no_pedido)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_articulos_rechazados_almacen('$no_pedido')");
        return $query;
    }

    public static function actualizar_articulos_almacen($usuario, $id_pedido, $estado, $cant_aprob, $cant_aprob_ant)
    {
        $query = DB::select("SELECT * FROM actualizar_articulos_almacen('$usuario', '$id_pedido', '$estado', '$cant_aprob', '$cant_aprob_ant')");
        return $query;
    }

    public static function verificar_articulo_aprobado_almacen($no_pedido)
    {
        $query = DB::select("SELECT * FROM verificar_articulo_aprobado_almacen('$no_pedido')");
        return $query;
    }

    public static function actualizar_pedido_almacen($usuario, $no_pedido, $valor)
    {
        $query = DB::select("SELECT * FROM actualizar_pedido_almacen('$usuario', '$no_pedido', '$valor')");
        return $query;
    }

    public static function listar_pedidos_valor_almacen($valor1, $valor2, $valor3, $valor4)
    {
        $query = DB::select("SELECT * FROM listar_pedidos_valor_almacen('$valor1', '$valor2', '$valor3', '$valor4')");
        return $query;
    }

    public static function listar_pedido_almacen($no_pedido)
    {
        $query = DB::select("SELECT * FROM listar_pedido_almacen('$no_pedido')");
        return $query;
    }

    public static function listar_articulo_almacen($no_pedido)
    {
        $query = DB::select("SELECT * FROM listar_articulo_almacen('$no_pedido')");
        return $query;
    }

    public static function recuperar_ultima_solicitud()
    {
        $query = DB::select("SELECT * FROM recuperar_ultima_solicitud()");
        return $query;
    }

    public static function listar_todos_solicitud()
    {
        $query = DB::select("SELECT * FROM listar_todos_solicitud()");
        return $query;
    }

    public static function recuperar_no_solicitud($id)
    {
        $query = DB::select("SELECT * FROM recuperar_no_solicitud('$id')");
        return $query;
    }

    public static function insertar_solicitud($programa, $pedido, $resp_almacen)
    {
        $query = DB::select("SELECT insertar_solicitud('$programa', '$pedido', '$resp_almacen')");
        return $query;
    }

    public static function insertar_solicitud_det($id_solicitud, $articulo, $motivo, $cantidad)
    {
        $query = DB::select("SELECT insertar_solicitud_det('$id_solicitud', '$articulo', '$motivo', '$cantidad')");
        return $query;
    }

    public static function actualizar_solicitud($no_solicitud, $id)
    {
        $query = DB::select("SELECT actualizar_solicitud('$no_solicitud', '$id')");
        return $query;
    }

    public static function actualizar_solicitud_det($estado, $id)
    {
        $query = DB::select("SELECT actualizar_solicitud_det('$estado', '$id')");
        return $query;
    }

    public static function listar_solicitud_almacen($no_pedido)
    {
        $query = DB::select("SELECT * FROM listar_solicitud_almacen('$no_pedido')");
        return $query;
    }

    public static function verificar_articulo_solicitud($id_pedido, $descrip, $cantidad, $cant_sol)
    {
        $query = DB::select("SELECT * FROM verificar_articulo_solicitud('$id_pedido', '$descrip', '$cantidad', '$cant_sol')");
        return $query;
    }

    public static function buscar_pedido_almacen($id_pedido)
    {
        $query = DB::select("SELECT * FROM buscar_pedido_almacen('$id_pedido')");
        return $query;
    }

    public static function cantidad_pendientes_almacen($no_solicitud)
    {
        $query = DB::select("SELECT * FROM cantidad_pendientes_almacen('$no_solicitud')");
        return $query;
    }

    public static function actualizar_estado_solicitud($no_solicitud, $id, $valor)
    {
        $query = DB::select("SELECT actualizar_estado_solicitud('$no_solicitud', '$id', '$valor')");
        return $query;
    }

    public static function listar_orden_almacen()
    {
        $query = DB::select("SELECT * FROM listar_orden_almacen()");
        return $query;
    }

    public static function listar_orden_almacen2()
    {
        $query = DB::select("SELECT * FROM listar_orden_almacen2()");
        return $query;
    }

    public static function listar_orden_almacen3()
    {
        $query = DB::select("SELECT * FROM listar_orden_almacen3()");
        return $query;
    }

    public static function listar_orden_almacen4()
    {
        $query = DB::select("SELECT * FROM listar_orden_almacen4()");
        return $query;
    }

    public static function ver_articulos_orden_almacen($no_orden)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_almacen('$no_orden')");
        return $query;
    }

    public static function ver_articulos_orden_almacen2($no_orden)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_almacen2('$no_orden')");
        return $query;
    }

    public static function ver_articulos_orden_cotizador3($no_orden)
    {
        $query = DB::select("SELECT * FROM ver_articulos_orden_cotizador3('$no_orden')");
        return $query;
    }

    public static function listar_orden_recepcion_almacen($no_orden)
    {
        $query = DB::select("SELECT * FROM listar_orden_recepcion_almacen('$no_orden')");
        return $query;
    }

    public static function verificar_solicitud($programa, $pedido)
    {
        $query = DB::select("SELECT * FROM verificar_solicitud('$programa', '$pedido')");
        return $query;
    }

    public static function listar_recepcion_pendientes()
    {
        $query = DB::select("SELECT * FROM listar_recepcion_pendientes()");
        return $query;
    }

    public static function ver_articulos_recepcion($no_recep)
    {
        $query = DB::select("SELECT * FROM ver_articulos_recepcion('$no_recep')");
        return $query;
    }

    public static function listar_ingreso()
    {
        $query = DB::select("SELECT * FROM listar_ingreso()");
        return $query;
    }

    public static function listar_ufvs($fecha)
    {
        $query = DB::select("SELECT * FROM listar_ufvs('$fecha')");
        return $query;
    }

    public static function recuperar_tipo_concepto($tipo, $descrip)
    {
        $query = DB::select("SELECT * FROM recuperar_tipo_concepto('$tipo', '$descrip')");
        return $query;
    }

    public static function listar_trn_alm($tipo)
    {
        $query = DB::select("SELECT * FROM listar_trn_alm('$tipo')");
        return $query;
    }

    public static function registrar_ingreso($tipo_mov, $pedido, $recepcion, $id_concepto, $orden, $total, $fecha, $id_ufv, $motivo, $usuario, $estado)
    {
        $query = DB::select("SELECT * FROM registrar_ingreso('$tipo_mov', '$pedido', '$recepcion', '$id_concepto', '$orden', '$total', '$fecha', '$id_ufv', '$motivo', '$usuario', '$estado')");
        return $query;
    }

    public static function registrar_articulo_det($articulo, $cantidad, $precio, $lote, $fecha_ven, $recepcion, $tipo, $gestion, $id_ingreso, $cant_disp)
    {
        $query = DB::select("SELECT * FROM registrar_articulo_det('$articulo', '$cantidad', '$precio', '$lote', '$fecha_ven', '$recepcion', '$tipo', '$gestion', '$id_ingreso', '$cant_disp')");
        return $query;
    }

    public static function buscar_articulo_det($articulo, $tipo_mov)
    {
        $query = DB::select("SELECT * FROM buscar_articulo_det('$articulo', '$tipo_mov')");
        return $query;
    }

    public static function registrar_ingreso_det($ingreso_id, $articulo, $cantidad, $precio, $lote, $saldo)
    {
        $query = DB::select("SELECT * FROM registrar_ingreso_det('$ingreso_id', '$articulo', '$cantidad', '$precio', '$lote', '$saldo')");
        return $query;
    }

    public static function verificar_ingreso($recepcion)
    {
        $query = DB::select("SELECT * FROM verificar_ingreso('$recepcion')");
        return $query;
    }

    public static function verificar_ingreso_stock($pedido)
    {
        $query = DB::select("SELECT * FROM verificar_ingreso_stock('$pedido')");
        return $query;
    }

    public static function ver_articulos_ingreso($no_recep)
    {
        $query = DB::select("SELECT * FROM ver_articulos_ingreso('$no_recep')");
        return $query;
    }

    public static function actualizar_ingreso($id_trnalm, $tipo_mov, $cpto_id, $orden, $fecha_transac, $id_ufv, $usuario)
    {
        $query = DB::select("SELECT * FROM actualizar_ingreso('$id_trnalm', '$tipo_mov', '$cpto_id', '$orden', '$fecha_transac', '$id_ufv', '$usuario')");
        return $query;
    }

    public static function actualizar_articulo_det($id, $fecha_vmto, $tipo_mov, $gestion, $lote)
    {
        $query = DB::select("SELECT * FROM actualizar_articulo_det('$id', '$fecha_vmto', '$tipo_mov', '$gestion', '$lote')");
        return $query;
    }

    public static function actualizar_ingreso_det($id, $lote)
    {
        $query = DB::select("SELECT * FROM actualizar_ingreso_det('$id', '$lote')");
        return $query;
    }

    public static function listar_ingresos_pendientes($descripcion)
    {
        $query = DB::select("SELECT * FROM listar_ingresos_pendientes('$descripcion')");
        return $query;
    }

    public static function buscar_trn_alm($id)
    {
        $query = DB::select("SELECT * FROM buscar_trn_alm('$id')");
        return $query;
    }

    public static function buscar_trn_almd($id)
    {
        $query = DB::select("SELECT * FROM buscar_trn_almd('$id')");
        return $query;
    }

    public static function actualizar_articulo_det_salida($id, $cant, $ide)
    {
        $query = DB::select("SELECT * FROM actualizar_articulo_det_salida('$id', '$cant', '$ide')");
        return $query;
    }

    public static function ver_articulos_salida($no_recep)
    {
        $query = DB::select("SELECT * FROM ver_articulos_salida('$no_recep')");
        return $query;
    }

    public static function listar_tipo_mov()
    {
        $query = DB::select("SELECT * FROM listar_tipo_mov()");
        return $query;
    }

    public static function cant_dispponible_articulo_det($id_articulo)
    {
        $query = DB::select("SELECT * FROM cant_dispponible_articulo_det('$id_articulo')");
        return $query;
    }

    public static function buscar_lotes_articulo_det($id_articulo)
    {
        $query = DB::select("SELECT * FROM buscar_lotes_articulo_det('$id_articulo')");
        return $query;
    }

    public static function actualizar_articulo_det_stock($id, $cant)
    {
        $query = DB::select("SELECT * FROM actualizar_articulo_det_stock('$id', '$cant')");
        return $query;
    }

    public static function actualizar_total_trnalm($id, $total)
    {
        $query = DB::select("SELECT * FROM actualizar_total_trnalm('$id', '$total')");
        return $query;
    }

    public static function listar_gestion_articulo_det()
    {
        $query = DB::select("SELECT * FROM listar_gestion_articulo_det()");
        return $query;
    }

    public static function obtener_datos_cierre($fecha_inicio, $fecha_fin)
    {
        $query = DB::select("SELECT * FROM obtener_datos_cierre('$fecha_inicio', '$fecha_fin')");
        return $query;
    }

    public static function registrar_cierre($articulo_id, $cant, $precio_act, $fecha_ufv_ini, $fecha_ufv_fin, $fact, $gestion, $fecha_cierre, $user_id, $id_trnalm, $id_articulo_det, $articulo_act_id)
    {
        $query = DB::select("SELECT * FROM registrar_cierre('$articulo_id', '$cant', '$precio_act', '$fecha_ufv_ini', '$fecha_ufv_fin', '$fact', '$gestion', '$fecha_cierre', '$user_id', '$id_trnalm', '$id_articulo_det', '$articulo_act_id')");
        return $query;
    }
}
