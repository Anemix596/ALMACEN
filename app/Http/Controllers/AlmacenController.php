<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Cotizador;
use App\Models\Solicitante;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class AlmacenController extends Controller
{

    function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

    public function lista_pedido_pendiente()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $consulta = Almacen::listar_pedidos_pendientes_almacen();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '9',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "estado" => ($val->estado_alma == "P" ? "PENDIENTE" : ($val->estado_alma == "A" ? "ASIGNADO" : "RECHAZADO")),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_articulo_pendiente()
    {
        $vector = array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_pedidos_articulos_pendientes_almacen($no_pedido);
            $consulta2 = Almacen::listar_solicitud_almacen($no_pedido);

            if (count($consulta2) > 0) {
                foreach ($consulta2 as $val) {
                    $cad3 = ($val->estado_aprob == "P" ? "PENDIENTE" : ($val->estado_aprob == "A" ? "APROBADO" : "RECHAZADO"));
                }
            } else $cad3 = "PENDIENTE";
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $cad1 = ($val->estado_asign == "P" ? "PENDIENTE" : ($val->estado_asign == "A" ? "ASIGNADO" : "RECHAZADO"));
                    $cad2 = ($val->estado_alm == "P" ? "PENDIENTE" : ($val->estado_alm == "A" ? "ASIGNADO" : ($val->estado_alm == "B" ? "RECHAZADO" : "ELIMINADO")));

                    $disp = Almacen::cant_dispponible_articulo_det($val->id_articulo);
                    foreach ($disp as $val2) {
                        $disponibilidad = ($val2->cant_dispponible_articulo_det != 0 || $val2->cant_dispponible_articulo_det != null ? $val2->cant_dispponible_articulo_det : 0);
                    }

                    $vector[] = array(
                        "valor" => '10',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->id,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "descrip" => $val->descripcion,
                        "cantidad" => $val->cantidad,
                        "cant_aprob" => $val->cant_aprob,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "no_pedido" => $val->no_pedido,
                        "id_pedido" => $val->id_pedido,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "estado_cod" => ($val->estado_cod == "C" ? "CODIFICADO" : "PENDIENTE"),
                        "estado_articulo" => ($val->estado_art == "P" ? "PENDIENTE" : ($val->estado_art == "A" ? "APROBADO" : "RECHAZADO")),
                        "estado_art_aprob" => ($val->estado_art_aprob == "P" ? "PENDIENTE" : ($val->estado_art_aprob == "A" ? "APROBADO" : "RECHAZADO")),
                        "estado_asign" => ($val->estado_asign == "P" ? "PENDIENTE" : ($val->estado_asign == "A" ? "ASIGNADO" : "RECHAZADO")),
                        "estado_alm" => ($val->estado_alm == "P" ? "PENDIENTE" : ($val->estado_alm == "A" ? "ASIGNADO" : "RECHAZADO")),
                        "estado2" => $cad1 . "/" . $cad2 . "/" . $cad3,
                        "disponible" => $disponibilidad,
                        "id_articulo" => $val->id_articulo,
                        "responsable" => $val->responsable,
                        "motivo" => $val->motivo,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_articulo_pendiente2()
    {
        $vector = array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_pedidos_articulos_rechazados_almacen($no_pedido);
            $consulta2 = Almacen::listar_solicitud_almacen($no_pedido);
            if (count($consulta2) > 0) {
                foreach ($consulta2 as $val) {
                    $cad3 = ($val->estado_aprob == "P" ? "PENDIENTE" : ($val->estado_aprob == "A" ? "APROBADO" : "RECHAZADO"));
                }
            } else $cad3 = "PENDIENTE";
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $cad1 = ($val->estado_asign == "P" ? "PENDIENTE" : ($val->estado_asign == "A" ? "ASIGNADO" : "RECHAZADO"));
                    $cad2 = ($val->estado_alm == "P" ? "PENDIENTE" : ($val->estado_alm == "A" ? "ASIGNADO" : ($val->estado_alm == "B" ? "RECHAZADO" : "ELIMINADO")));
                    $disp = Almacen::cant_dispponible_articulo_det($val->id_articulo);
                    foreach ($disp as $val2) {
                        $disponibilidad = ($val2->cant_dispponible_articulo_det != 0 || $val2->cant_dispponible_articulo_det != null ? $val2->cant_dispponible_articulo_det : 0);
                    }

                    $vector[] = array(
                        "valor" => '10',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->id,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "descrip" => $val->descripcion,
                        "cantidad" => $val->cantidad,
                        "cant_aprob" => $val->cant_aprob,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "no_pedido" => $val->no_pedido,
                        "id_pedido" => $val->id_pedido,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "estado_cod" => ($val->estado_cod == "C" ? "CODIFICADO" : "PENDIENTE"),
                        "estado_articulo" => ($val->estado_art == "P" ? "PENDIENTE" : ($val->estado_art == "A" ? "APROBADO" : "RECHAZADO")),
                        "estado_art_aprob" => ($val->estado_art_aprob == "P" ? "PENDIENTE" : ($val->estado_art_aprob == "A" ? "APROBADO" : "RECHAZADO")),
                        "estado_asign" => ($val->estado_asign == "P" ? "PENDIENTE" : ($val->estado_asign == "A" ? "ASIGNADO" : "RECHAZADO")),
                        "estado_alm" => ($val->estado_alm == "P" ? "PENDIENTE" : ($val->estado_alm == "A" ? "ASIGNADO" : "RECHAZADO")),
                        "estado2" => $cad1 . "/" . $cad2 . "/" . $cad3,
                        "motivo" => $val->motivo,
                        "disponible" => $disponibilidad,
                        "id_articulo" => $val->id_articulo,
                        "responsable" => $val->responsable,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_datos_almacen()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $no_pedido = $_POST['no_pedido'];
            $responsable = $_POST['responsable'];
            $i = 0;
            $id = $_POST['valor_id'];
            foreach ($id as $val) {
                $dato[0][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['valor'];
            foreach ($id as $val) {
                $dato[1][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cantidad'];
            foreach ($id as $val) {
                $dato[2][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['valor2'];
            foreach ($id as $val) {
                $dato[3][$i] = $val;
                $i++;
            }

            for ($j = 0; $j < $i; $j++) {
                if ($dato[3][$j] == 'B') {
                    $dato[4][$j] = 'X';
                } else {
                    $dato[4][$j] = $dato[1][$j];
                }
            }

            $i = 0;
            $id = $_POST['cant'];
            foreach ($id as $val) {
                $dato[5][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cant_apro'];
            foreach ($id as $val) {
                $dato[6][$i] = $val;
                $i++;
            }

            for ($j = 0; $j < $i; $j++) {
                if ($dato[2][$j] <= 0 || $dato[2][$j] > $dato[5][$j])
                    return [3, $j + 1];
            }

            $cont = 0;
            for ($j = 0; $j < $i; $j++) {
                if ($dato[1][$j] == "B") {
                    $cont++;
                }
            }
            if ($cont > 0) return 2;

            for ($j = 0; $j < $i; $j++) {
                if ($dato[3][$j] == 'B') {
                    $dato[2][$j] = 0;
                } else {
                    $dato[2][$j] = $dato[2][$j];
                }
            }

            for ($j = 0; $j < $i; $j++) {
                $actualizar = Almacen::actualizar_articulos_almacen($usuario, $dato[0][$j], $dato[4][$j], $dato[2][$j], $dato[6][$j]);
            }

            $can_aprob = Almacen::verificar_articulo_aprobado_almacen($no_pedido);
            foreach ($can_aprob as $val) {
                $cant_aprob = $val->verificar_articulo_aprobado_almacen;
            }

            if ($cant_aprob > 0) {
                $valor = 1;
                $actualiza = Almacen::actualizar_pedido_almacen($usuario, $no_pedido, $valor, $responsable);
            } else {
                $valor = 2;
                $actualiza = Almacen::actualizar_pedido_almacen($usuario, $no_pedido, $valor, $responsable);
            }



            $recuperar = Almacen::listar_pedido_almacen($no_pedido);
            if (count($recuperar) > 0) {
                foreach ($recuperar as $val) {
                    $programa = $val->programa;
                    $pedido = $val->ida;
                    $resp_almacen = $val->resp_alm;
                    $est_almacen = $val->estado_alma;
                }
            }

            if ($est_almacen == "A") {
                $seleccionar = Almacen::listar_todos_solicitud();
                if (empty($seleccionar)) {
                    $ban = 1;
                } else {
                    $ban = 0;
                }

                $verificar = Almacen::verificar_solicitud($programa, $pedido);
                if (empty($verificar)) {
                    $insertar = Almacen::insertar_solicitud($programa, $pedido, $resp_almacen);
                    if ($insertar) {
                        if ($ban == 1) {
                            $rec = Almacen::recuperar_ultima_solicitud();
                            if (count($rec) > 0) {
                                foreach ($rec as $val) {
                                    $id = $val->id;
                                }
                            }
                            $dato[0] = 1;
                            $no_solicitud = self::zero_fill($dato[0], 5);
                            $act = Almacen::actualizar_solicitud($no_solicitud, $id);

                            $recuperar2 = Almacen::listar_articulo_almacen($no_pedido);
                            if (count($recuperar2) > 0) {
                                foreach ($recuperar2 as $val) {
                                    $insertar2 = Almacen::insertar_solicitud_det($id, $val->art_id, $val->motivo, $val->cantidad);
                                }
                            }
                        } else {
                            $rec = Almacen::recuperar_ultima_solicitud();
                            if (count($rec) > 0) {
                                foreach ($rec as $val) {
                                    $id = $val->id;
                                }
                            }

                            $rec2 = Almacen::recuperar_no_solicitud($id - 1);
                            if (count($rec2) > 0) {
                                foreach ($rec2 as $val) {
                                    $vector[0] = $val->no_solic;
                                }
                            }

                            $vector[1] = (int)$vector[0];
                            $vector[1]++;
                            $dato[0] = $vector[1];

                            $no_solicitud = self::zero_fill($dato[0], 5);
                            $act = Almacen::actualizar_solicitud($no_solicitud, $id);

                            $recuperar2 = Almacen::listar_articulo_almacen($no_pedido);
                            if (count($recuperar2) > 0) {
                                foreach ($recuperar2 as $val) {
                                    $insertar2 = Almacen::insertar_solicitud_det($id, $val->art_id, $val->motivo, $val->cantidad);
                                }
                            }
                        }
                    }
                }
            }
            return 1;
        }
    }

    public function editar_datos_almacen()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $no_pedido = $_POST['eno_pedido'];
            $i = 0;
            $id = $_POST['evalor_id'];
            foreach ($id as $val) {
                $dato[0][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['evalor'];
            foreach ($id as $val) {
                $dato[1][$i] = $val;
                $i++;
            }

            $i = 0;
            $id2 = $_POST['edescrip'];
            foreach ($id2 as $val) {
                $dato[2][$i] = $val;
                $i++;
            }

            $i = 0;
            $id3 = $_POST['ecant_ped'];
            foreach ($id3 as $val) {
                $dato[3][$i] = $val;
                $i++;
            }

            $i = 0;
            $id3 = $_POST['ecant_apro'];
            foreach ($id3 as $val) {
                $dato[4][$i] = $val;
                $i++;
            }

            for ($j = 0; $j < $i; $j++) {
                $actualizar = Almacen::actualizar_articulos_almacen($usuario, $dato[0][$j], $dato[1][$j]);
            }

            $can_aprob = Almacen::verificar_articulo_aprobado_almacen($no_pedido);
            foreach ($can_aprob as $val) {
                $cant_aprob = $val->verificar_articulo_aprobado_almacen;
            }

            if ($cant_aprob > 0) {
                $valor = 1;
                $actualiza = Almacen::actualizar_pedido_almacen($usuario, $no_pedido, $valor);
            } else {
                $valor = 2;
                $actualiza = Almacen::actualizar_pedido_almacen($usuario, $no_pedido, $valor);
            }

            $lista = Almacen::listar_solicitud_almacen($no_pedido);
            foreach ($lista as $val) {
                $id_pedido = $val->idb;
                $no_solicitud = $val->no_solicitud;
            }

            for ($j = 0; $j < $i; $j++) {
                $verificar = Almacen::verificar_articulo_solicitud($id_pedido, $dato[2][$j], $dato[4][$j], $dato[3][$j]);
                foreach ($verificar as $val) {
                    $id_ped = $val->id_sol;
                }
                if (!empty($verificar)) {
                    $actualiza = Almacen::actualizar_solicitud_det($dato[1][$j], $id_ped);
                } else {
                    if ($dato[1][$j] == "A") {
                        $buscar = Almacen::buscar_pedido_almacen($dato[0][$j]);
                        foreach ($buscar as $val) {
                            $articulo = $val->articulo_id;
                            $motivo = $val->descrip_espec;
                            $cantidad = $val->cant_apro;
                        }

                        $insertar2 = Almacen::insertar_solicitud_det($id_pedido, $articulo, $motivo, $cantidad);
                    }
                }
            }

            $can_alm = Almacen::cantidad_pendientes_almacen($no_solicitud);
            foreach ($can_alm as $val) {
                $cant_alm = $val->cantidad_pendientes_almacen;
            }

            if ($cant_alm > 0) {
                $valor = 1;
                $act = Almacen::actualizar_estado_solicitud($no_solicitud, $id_pedido, $valor);
            } else {
                $valor = 2;
                $act = Almacen::actualizar_estado_solicitud($no_solicitud, $id_pedido, $valor);
            }
            return 1;
        }
    }

    public function lista_pedido_valor_almacen()
    {
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $valor3 = $_POST['est_ped3'];
        $valor4 = $_POST['est_ped4'];
        $usuario = session('usuario');
        if (!empty($usuario)) {
            if ($valor1 == 0 && $valor2 == 0 && $valor3 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';
            if ($valor3 == 3) $valor3 = 'R';
            if ($valor4 == 4) $valor4 = 'E';
            $vector = array();
            $bandera = 1;
            $consulta = Almacen::listar_pedidos_valor_almacen($valor1, $valor2, $valor3, $valor4);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '9',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "estado" => ($val->estado_alma == "P" ? "PENDIENTE" : ($val->estado_alma == "A" ? "ASIGNADO" : "RECHAZADO")),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function recepcion_orden()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.recepcion.menor');
        }
    }

    public function listar_todo_orden()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_orden_almacen();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_orden);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    if ($val->estado_gen == "P") {
                        $vector[] = array(
                            "valor" => '22',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_todo_orden_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_orden_almacen();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "P") {
                            $vector[] = array(
                                "valor" => '22',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "A") {
                            $vector[] = array(
                                "valor" => '22',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '22',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_orden()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_orden_almacen($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '23',
                        "val" => '',
                        "numero" => $bandera,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "precio" => $val->precio,
                        "cantidad" => $val->cantidad,
                        "unidad" => $val->unidad,
                        "importe" => $val->importe,
                        "id_solicitud" => $val->id_solicitud,
                        "id_prov" => $val->id_prov,
                        "id_soldet" => $val->id_soldet,
                        "orden" => $val->orden,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_orden2()
    {
        date_default_timezone_set("America/La_Paz");
        $vector = array();
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_orden_almacen($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $ban = 0;
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_cotizacion_recepcion($val->id_solicitud, $val->resp_cot);
                        if (count($consulta2) > 0) {
                            foreach ($consulta2 as $val2) {
                                $vector[4] = $val2->fecha_cotizacion;
                                $vector[5] = date('d-m-Y');
                            }
                            $ban = 1;
                        }
                    }
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_prov_nacional_recepcion($val->id_solicitud, $val->resp_cot);
                        if (count($consulta2) > 0) {
                            foreach ($consulta2 as $val2) {
                                $vector[4] = $val2->fecha_cotizacion;
                                $vector[5] = date('d-m-Y');
                            }
                            $ban = 1;
                        }
                    }
                    $vector[0] = $val->proveedor;
                }
            }

            $consulta = Almacen::listar_orden_recepcion_almacen($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[1] = $val->fecha_fact;
                    $vector[2] = $val->nro_fact;
                    $vector[3] = $val->no_recep;
                }
            }
            return $vector;
        }
    }

    public function guardar_datos_recepcion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $factura = $_POST['factura'];
            $fecha_fac = $_POST['fecha_fac'];
            $no_orden = $_POST['orden'];
            $id_solicitud = $_POST['id_solicitud'];
            $id_prov = $_POST['id_prov'];
            $id_sol_det = $_POST['id_soldet'];
            $i = 0;
            foreach ($id_sol_det as $val) {
                $dat[$i] = $val;
                $i++;
            }

            $seleccionar = Cotizador::listar_todos_recepcion();
            if (empty($seleccionar)) $ban = 1;
            else $ban = 0;


            for ($j = 0; $j < $i; $j++) {
                $actualizar = Cotizador::actualizar_estado_cotizacion($no_orden, $id_solicitud, $id_prov, $dat[$j]);
            }

            $consulta = Almacen::ver_articulos_orden_almacen($no_orden);
            foreach ($consulta as $val) {
                $verificar = Cotizador::verificar_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                if (empty($verificar)) {
                    $insertar = Cotizador::insertar_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                    if ($insertar) {
                        if ($ban == 1) {
                            $ban = 0;
                            $rec = Cotizador::recuperar_ultima_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                            foreach ($rec as $val2) {
                                $id = $val2->id;
                            }

                            $dato[0] = 1;
                            $no_recepcion = self::zero_fill($dato[0], 5);
                            $act = Cotizador::actualizar_recepcion($no_recepcion, $id);

                            $insertar2 = Cotizador::insertar_recepcion_det($id, $val->ida, $val->importe, $val->id_unidad, $val->cant_orden);
                        } else {
                            $rec = Cotizador::recuperar_ultima_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                            foreach ($rec as $val2) {
                                $id = $val2->id;
                            }

                            $rec2 = Cotizador::recuperar_no_recepcion($id - 1);
                            if (count($rec2) > 0) {
                                foreach ($rec2 as $val2) {
                                    $vector[0] = $val2->no_recep;
                                }
                            }

                            $vector[1] = (int)$vector[0];
                            $vector[1]++;
                            $dato[0] = $vector[1];

                            $no_recepcion = self::zero_fill($dato[0], 5);
                            $act = Cotizador::actualizar_recepcion($no_recepcion, $id);

                            $insertar2 = Cotizador::insertar_recepcion_det($id, $val->ida, $val->importe, $val->id_unidad, $val->cant_orden);
                        }
                    } else return 0;
                } else {
                    foreach ($verificar as $val10) {
                        $id = $val10->id;
                    }

                    $insertar2 = Cotizador::insertar_recepcion_det($id, $val->ida, $val->importe, $val->id_unidad, $val->cant_orden);
                }
            }
            return 1;
        }
    }

    public function ver_imprimir_pedido()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['no_pedido'];
            /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Apresupuesto.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=" . $no_pedido;*/
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Apresupuesto.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=" . $no_pedido;

            return $html;
        }
    }

    public function ver_imprimir_solicitud()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['no_pedido'];
            /* $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Asolicitud_compra.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=" . $no_pedido;*/
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Asolicitud_compra.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=" . $no_pedido;


            return $html;
        }
    }

    public function ver_imprimir_recepcion()
    {
        $usuario = session('id');
        $html = "";
        if (!empty($usuario)) {
            $no_orden = $_POST['orden'];
            $consulta = Cotizador::verificar_contrato_orden($no_orden);
            foreach ($consulta as $val) {
                $contrato = ($val->no_cont == null ? "VACIO" : $val->no_cont);
            }
            if ($contrato == "VACIO") {
                /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Anota_recepcion_almacen.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_ordene=" . $no_orden;*/
                $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Anota_recepcion_almacen.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_ordene=" . $no_orden;
            } else {
                /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Anota_recepcion_almacen_contrato.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_ordene=" . $no_orden;*/
                $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Anota_recepcion_almacen_contrato.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_ordene=" . $no_orden;
            }
            return $html;
        }
    }

    public function ver_imprimir_recepcion2()
    {
        $usuario = session('id');
        $html = "";
        if (!empty($usuario)) {
            $no_orden = $_POST['orden'];
            /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Anota_recepcion_almacen_contrato_lic_exc.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_ordene=" . $no_orden;*/
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Anota_recepcion_almacen_contrato_lic_exc.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_ordene=" . $no_orden;
            return $html;
        }
    }

    public function recepcion_orden_excepcion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.recepcion.excepcion');
        }
    }

    public function recepcion_orden_licitacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.recepcion.licitacion');
        }
    }

    public function recepcion_orden_anpe()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.recepcion.anpe');
        }
    }

    public function listar_todo_orden_excepcion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_orden_almacen4();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_orden);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    if ($val->estado_gen == "P") {
                        $vector[] = array(
                            "valor" => '30',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_todo_orden_excepcion_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_orden_almacen4();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "P") {
                            $vector[] = array(
                                "valor" => '30',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen4();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "A") {
                            $vector[] = array(
                                "valor" => '30',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen4();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '30',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_orden_licitacion()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_orden_almacen2($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '19',
                        "val" => '',
                        "numero" => $bandera,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "precio" => $val->precio,
                        "cantidad" => $val->cantidad,
                        "unidad" => $val->unidad,
                        "importe" => $val->importe,
                        "id_solicitud" => $val->id_solicitud,
                        "id_prov" => $val->id_prov,
                        "id_soldet" => $val->id_soldet,
                        "orden" => $no_orden,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_orden_licitacion2()
    {
        date_default_timezone_set("America/La_Paz");
        $vector = array();
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_orden_almacen2($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $ban = 0;
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_cotizacion_recepcion($val->id_solicitud, $val->resp_cot);
                        if (count($consulta2) > 0) {
                            foreach ($consulta2 as $val2) {
                                $vector[4] = $val2->fecha_cotizacion;
                                $vector[5] = date('d-m-Y');
                            }
                            $ban = 1;
                        }
                    }
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_prov_nacional_recepcion($val->id_solicitud, $val->resp_cot);
                        if (count($consulta2) > 0) {
                            foreach ($consulta2 as $val2) {
                                $vector[4] = $val2->fecha_cotizacion;
                                $vector[5] = date('d-m-Y');
                            }
                            $ban = 1;
                        }
                    }
                    $vector[0] = $val->proveedor;
                }
            }

            $consulta = Cotizador::listar_orden_recepcion2($no_orden, $val->resp_cot);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[1] = $val->fecha_fact;
                    $vector[2] = $val->nro_fact;
                    $vector[3] = $val->no_recep;
                }
            }
            return $vector;
        }
    }

    public function guardar_datos_recepcion_licitacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $factura = $_POST['factura'];
            $fecha_fac = $_POST['fecha_fac'];
            $no_orden = $_POST['orden'];
            $id_solicitud = $_POST['id_solicitud'];
            $id_prov = $_POST['id_prov'];
            $id_sol_det = $_POST['id_soldet'];
            $i = 0;
            foreach ($id_sol_det as $val) {
                $dat[$i] = $val;
                $i++;
            }

            $seleccionar = Cotizador::listar_todos_recepcion();
            if (empty($seleccionar)) $ban = 1;
            else $ban = 0;


            for ($j = 0; $j < $i; $j++) {
                $actualizar = Cotizador::actualizar_estado_cotizacion2($no_orden, $id_solicitud, $id_prov, $dat[$j]);
            }

            $consulta = Almacen::ver_articulos_orden_cotizador3($no_orden);
            foreach ($consulta as $val) {
                $verificar = Cotizador::verificar_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                if (empty($verificar)) {
                    $insertar = Cotizador::insertar_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                    if ($insertar) {
                        if ($ban == 1) {
                            $ban = 0;
                            $rec = Cotizador::recuperar_ultima_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                            foreach ($rec as $val2) {
                                $id = $val2->id;
                            }

                            $dato[0] = 1;
                            $no_recepcion = self::zero_fill($dato[0], 5);
                            $act = Cotizador::actualizar_recepcion($no_recepcion, $id);

                            $insertar2 = Cotizador::insertar_recepcion_det($id, $val->ida, $val->importe, $val->id_unidad, $val->cant_orden);
                        } else {
                            $rec = Cotizador::recuperar_ultima_recepcion($val->id_pedido, $val->id_solicitud, $val->id_orden, $factura, $fecha_fac, $val->total, $val->id_prov, $val->resp_cot, $val->resp_almacen, $val->id_funcionario);
                            foreach ($rec as $val2) {
                                $id = $val2->id;
                            }

                            $rec2 = Cotizador::recuperar_no_recepcion($id - 1);
                            if (count($rec2) > 0) {
                                foreach ($rec2 as $val2) {
                                    $vector[0] = $val2->no_recep;
                                }
                            }

                            $vector[1] = (int)$vector[0];
                            $vector[1]++;
                            $dato[0] = $vector[1];

                            $no_recepcion = self::zero_fill($dato[0], 5);
                            $act = Cotizador::actualizar_recepcion($no_recepcion, $id);

                            $insertar2 = Cotizador::insertar_recepcion_det($id, $val->ida, $val->importe, $val->id_unidad, $val->cant_orden);
                        }
                    } else return 0;
                } else {
                    foreach ($verificar as $val10) {
                        $id = $val10->id;
                    }

                    $insertar2 = Cotizador::insertar_recepcion_det($id, $val->ida, $val->importe, $val->id_unidad, $val->cant_orden);
                }
            }
            return 1;
        }
    }

    public function listar_todo_orden_licitacion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_orden_almacen3();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_orden);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    if ($val->estado_gen == "P") {
                        $vector[] = array(
                            "valor" => '30',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_todo_orden_licitacion_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_orden_almacen3();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "P") {
                            $vector[] = array(
                                "valor" => '30',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen3();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "A") {
                            $vector[] = array(
                                "valor" => '30',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen3();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '30',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_todo_orden_anpe()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_orden_almacen2();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_orden);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    if ($val->estado_gen == "P") {
                        $vector[] = array(
                            "valor" => '21',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_todo_orden_anpe_valor()
    {

        $vector = array();
        $bandera = 1;
        $usuario = session('id');

        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_orden_almacen2();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "P") {
                            $vector[] = array(
                                "valor" => '21',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen2();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "A") {
                            $vector[] = array(
                                "valor" => '21',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen2();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '21',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_compras()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.almacen.compras');
        }
    }

    public function ingresos()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.almacen.ingresos');
        }
    }

    public function salidas()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.almacen.salidas');
        }
    }

    public function listar_recepcion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_recepcion_pendientes();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    if ($val->id_trn == null) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '31',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "no_recep" => $val->no_recep,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->id_trn == null ? "VACIO" : $val->id_trn),
                            "est_salida" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_recepcion()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_recepcion($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '32',
                        "val" => '',
                        "numero" => $bandera,
                        "ida" => $val->ida,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "precio" => $val->precio,
                        "cantidad" => $val->cantidad,
                        "unidad" => $val->unidad,
                        "importe" => $val->importe,
                        "id_solicitud" => $val->id_solicitud,
                        "id_prov" => $val->id_prov,
                        "id_soldet" => $val->id_soldet,
                        "pedido" => $val->no_pedido,
                        "orden" => $val->orden,
                        "solicitud" => $val->solic,
                        "recepcion" => $val->recep,
                        "id_recep_det" => $val->id_recep_det,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_recepcion2()
    {
        $vector = array();
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_recepcion($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->no_pedido;
                    $vector[1] = $val->orden;
                    $vector[2] = $val->solic;
                    $vector[3] = $val->recep;
                    $vector[4] = $val->proveedor;
                    $vector[5] = $val->no_fact;
                }
            }
            return $vector;
        }
    }

    public function listar_articulo_recepcion3()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_recepcion($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '33',
                        "val" => '',
                        "numero" => $bandera,
                        "ida" => $val->ida,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "precio" => $val->precio,
                        "cantidad" => $val->cantidad,
                        "unidad" => $val->unidad,
                        "importe" => $val->importe,
                        "id_solicitud" => $val->id_solicitud,
                        "id_prov" => $val->id_prov,
                        "id_soldet" => $val->id_soldet,
                        "pedido" => $val->no_pedido,
                        "orden" => $val->orden,
                        "solicitud" => $val->solic,
                        "recepcion" => $val->recep,
                        "id_recep_det" => $val->id_recep_det,
                        "id_recep" => $val->id_recepcion,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function recuperar_movimiento()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Almacen::listar_ingreso();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Tipo de Movimiento' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function guardar_datos_ingreso()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $tipo_mov = $_POST['mov'];
            $fech = $_POST['fechar'];
            $fecha = explode("-", $fech);
            $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            $recepcion = $_POST['idr'];
            $obtener = Almacen::listar_ufvs($fecha);
            $gestion = date('Y');
            if (count($obtener) > 0) {
                foreach ($obtener as $val) {
                    $id_ufv = $val->id;

                    $obtener_concepto = Almacen::recuperar_tipo_concepto($tipo_mov, "COMPRA");
                    if (count($obtener_concepto) > 0) {
                        foreach ($obtener_concepto as $val) {
                            $id_concepto = $val->idb;
                            $descripcion = $val->descripa;

                            $obtener_orden = Almacen::listar_trn_alm($tipo_mov);
                            if (count($obtener_orden) > 0) {
                                foreach ($obtener_orden as $val) {
                                    $orden = $val->orden;
                                    $orden++;
                                }
                            } else $orden = 1;

                            $lista = Almacen::ver_articulos_recepcion($recepcion);
                            if (count($lista) > 0) {
                                foreach ($lista as $val2) {
                                    $id_recepcion = $_POST['id_recepr'];
                                    $dato = array();
                                    $i = 0;
                                    $id = $_POST['id_recep_detr'];
                                    foreach ($id as $val) {
                                        $dato[0][$i] = $val;
                                        $i++;
                                    }

                                    $i = 0;
                                    $id = $_POST['id_articulor'];
                                    foreach ($id as $val) {
                                        $dato[1][$i] = $val;
                                        $i++;
                                    }

                                    $i = 0;
                                    $id = $_POST['cantidadr'];
                                    foreach ($id as $val) {
                                        $dato[2][$i] = $val;
                                        $i++;
                                    }

                                    $i = 0;
                                    $id = $_POST['precior'];
                                    foreach ($id as $val) {
                                        $dato[3][$i] = $val;
                                        $i++;
                                    }

                                    $anio = date("Y");

                                    $i = 0;
                                    $id = $_POST['fecha_art'];
                                    foreach ($id as $val) {
                                        $dato[4][$i] = ($val == "" ? $anio . "-12-31" : $val);
                                        $i++;
                                    }

                                    $verificar = Almacen::verificar_ingreso($id_recepcion);
                                    if (empty($verificar)) {
                                        $registrar = Almacen::registrar_ingreso($tipo_mov, $val2->id_pedido, $val2->id_recepcion, $id_concepto, $orden, $val2->total, $fecha, $id_ufv, $val2->motivo, $usuario, "P");
                                        if (count($registrar) > 0) {
                                            foreach ($registrar as $val) {
                                                $id_ingreso = $val->registrar_ingreso;
                                            }

                                            for ($j = 0; $j < $i; $j++) {
                                                $ban = 0;
                                                $buscar_articulo = Almacen::buscar_articulo_det($dato[1][$j], $tipo_mov);
                                                if (count($buscar_articulo) > 0) {
                                                    foreach ($buscar_articulo as $val) {
                                                        $lote = $val->lote;
                                                        $lote++;
                                                        $ban = 1;
                                                    }
                                                } else {
                                                    $lote = 1;
                                                    $ban = 1;
                                                }

                                                if ($ban == 1) {
                                                    if ($descripcion == "INGRESOS STOCK") { //Descripcion de la base de datos
                                                        $registrar_articulo_det = Almacen::registrar_articulo_det($dato[1][$j], $dato[2][$j], $dato[3][$j], $lote, $dato[4][$j], $id_recepcion, $tipo_mov, $gestion, $id_ingreso, $dato[2][$j]);
                                                        if ($registrar_articulo_det) {
                                                            $registrar_ingreso_det = Almacen::registrar_ingreso_det($id_ingreso, $dato[1][$j], $dato[2][$j], $dato[3][$j], $lote, $dato[2][$j]);
                                                        }
                                                    } else if ($descripcion == "INGRESO INMEDIATO") {
                                                        $registrar_articulo_det = Almacen::registrar_articulo_det($dato[1][$j], $dato[2][$j], $dato[3][$j], 1, $dato[4][$j], $id_recepcion, $tipo_mov, $gestion, $id_ingreso, $dato[2][$j]);
                                                        if ($registrar_articulo_det) {
                                                            $registrar_ingreso_det = Almacen::registrar_ingreso_det($id_ingreso, $dato[1][$j], $dato[2][$j], $dato[3][$j], 1, $dato[2][$j]);
                                                        }
                                                    } else return 0;
                                                }
                                            }

                                            return 1;
                                        }
                                    } else return 1;
                                }
                            } else return 0;
                        }
                    }
                }
            }
        }
    }

    public function listar_ingreso_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_recepcion_pendientes();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        if ($val->id_trn == null) {
                            $fecha_co = explode("-", $val->fecha_orden);
                            $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                            $vector[] = array(
                                "valor" => '31',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "no_recep" => $val->no_recep,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->id_trn == null ? "VACIO" : $val->id_trn),
                                "est_salida" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_recepcion_pendientes();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        if ($val->id_trn != null) {
                            $fecha_co = explode("-", $val->fecha_orden);
                            $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                            $vector[] = array(
                                "valor" => '31',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "no_recep" => $val->no_recep,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->id_trn == null ? "VACIO" : $val->id_trn),
                                "est_salida" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_recepcion_pendientes();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '31',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "no_recep" => $val->no_recep,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->id_trn == null ? "VACIO" : $val->id_trn),
                            "est_salida" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_ingreso()
    {
        $vector = array();
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_ingreso($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->no_pedido;
                    $vector[1] = $val->orden;
                    $vector[2] = $val->solic;
                    $vector[3] = $val->recep;
                    $vector[4] = $val->proveedor;
                    $vector[5] = $val->no_fact;
                    $vector[6] = $val->fecha_transac;
                    $vector[7] = $val->tipo_mov;
                    $vector[8] = ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO");
                    $vector[10] = $val->glosa;
                    $vector[11] = $val->id_trn_alm;

                    $id = $vector[7];
                    $lista = Almacen::listar_tipo_mov();
                    if (count($lista) > 0) {
                        foreach ($lista as $val) {
                            if ($id == $val->id)
                                $vector[9] = $val->descrip;
                        }
                    }
                }
            }
            return $vector;
        }
    }

    public function listar_articulo_ingreso2()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_ingreso($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '34',
                        "val" => '',
                        "numero" => $bandera,
                        "ida" => $val->ida,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "precio" => $val->precio,
                        "cantidad" => $val->cantidad,
                        "unidad" => $val->unidad,
                        "importe" => $val->importe,
                        "id_solicitud" => $val->id_solicitud,
                        "id_prov" => $val->id_prov,
                        "id_soldet" => $val->id_soldet,
                        "pedido" => $val->no_pedido,
                        "orden" => $val->orden,
                        "solicitud" => $val->solic,
                        "recepcion" => $val->recep,
                        "id_recep_det" => $val->id_recep_det,
                        "id_recep" => $val->id_recepcion,
                        "id_trn_alm" => $val->id_trn_alm,
                        "id_trn_almd" => $val->id_trn_almd,
                        "id_arti_det" => $val->id_arti_det,
                        "fecha_vmto" => $val->fecha_vmto,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function recuperar_movimiento2()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = $_POST['id'];
            $lista = Almacen::listar_ingreso();
            $html = '';
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($id == $val->id)
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
                foreach ($lista as $val) {
                    if ($id != $val->id)
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function editar_datos_ingreso()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id_trnalm = $_POST['id_trn_alma'];
            $tipo_mov = $_POST['mova'];
            $fech = $_POST['fechaa'];
            $fecha = explode("-", $fech);
            $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            $obtener = Almacen::listar_ufvs($fecha);
            $gestion = date('Y');
            if (count($obtener) > 0) {
                foreach ($obtener as $val) {
                    $id_ufv = $val->id;

                    $obtener_concepto = Almacen::recuperar_tipo_concepto($tipo_mov, "COMPRA");
                    if (count($obtener_concepto) > 0) {
                        foreach ($obtener_concepto as $val) {
                            $id_concepto = $val->idb;
                            $descripcion = $val->descripa;

                            $obtener_orden = Almacen::listar_trn_alm($tipo_mov);
                            if (count($obtener_orden) > 0) {
                                foreach ($obtener_orden as $val) {
                                    $orden = $val->orden;
                                    $orden++;
                                }
                            } else $orden = 1;

                            $dato = array();
                            $i = 0;
                            $id = $_POST['id_recep_deta'];
                            foreach ($id as $val) {
                                $dato[0][$i] = $val;
                                $i++;
                            }

                            $i = 0;
                            $id = $_POST['id_articuloa'];
                            foreach ($id as $val) {
                                $dato[1][$i] = $val;
                                $i++;
                            }

                            $i = 0;
                            $id = $_POST['cantidada'];
                            foreach ($id as $val) {
                                $dato[2][$i] = $val;
                                $i++;
                            }

                            $i = 0;
                            $id = $_POST['precioa'];
                            foreach ($id as $val) {
                                $dato[3][$i] = $val;
                                $i++;
                            }

                            $anio = date("Y");

                            $i = 0;
                            $id = $_POST['fecha_arta'];
                            foreach ($id as $val) {
                                $dato[4][$i] = ($val == "" ? $anio . "-12-31" : $val);
                                $i++;
                            }

                            $i = 0;
                            $id = $_POST['id_trn_almda'];
                            foreach ($id as $val) {
                                $dato[5][$i] = $val;
                                $i++;
                            }

                            $i = 0;
                            $id = $_POST['id_arti_deta'];
                            foreach ($id as $val) {
                                $dato[6][$i] = $val;
                                $i++;
                            }


                            $actualizar_ing = Almacen::actualizar_ingreso($id_trnalm, $tipo_mov, $id_concepto, $orden, $fecha, $id_ufv, $usuario);
                            if ($actualizar_ing) {
                                for ($j = 0; $j < $i; $j++) {
                                    $ban = 0;
                                    $buscar_articulo = Almacen::buscar_articulo_det($dato[1][$j], $tipo_mov);
                                    if (count($buscar_articulo) > 0) {
                                        foreach ($buscar_articulo as $val) {
                                            $lote = $val->lote;
                                            $lote++;
                                            $ban = 1;
                                        }
                                    } else {
                                        $lote = 1;
                                        $ban = 1;
                                    }

                                    if ($ban == 1) {
                                        if ($descripcion == "INGRESOS STOCK") { //Descripcion de la base de datos
                                            $actualizar_art_det = Almacen::actualizar_articulo_det($dato[6][$j], $dato[4][$j], $tipo_mov, $gestion, $lote);
                                            if ($actualizar_art_det) {
                                                $actualizar_ing_det = Almacen::actualizar_ingreso_det($dato[5][$j], $lote);
                                            }
                                        } else if ($descripcion == "INGRESO INMEDIATO") {
                                            $actualizar_art_det = Almacen::actualizar_articulo_det($dato[6][$j], $dato[4][$j], $tipo_mov, $gestion, 1);
                                            if ($actualizar_art_det) {
                                                $actualizar_ing_det = Almacen::actualizar_ingreso_det($dato[5][$j], 1);
                                            }
                                        } else return 0;
                                    }
                                }
                                return 1;
                            } else return 0;
                        }
                    }
                }
            }
        }
    }

    public function ingreso_stock()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.almacen.ingreso_stock');
        }
    }

    public function ingreso_inmediato()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.almacen.ingreso_inmediato');
        }
    }

    public function listar_ingreso_stock()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $descripcion = "INGRESOS STOCK";
            $consulta = Almacen::listar_ingresos_pendientes($descripcion);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    if ($val->est_salida == "P") {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '35',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "no_recep" => $val->no_recep,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_articulo_ingreso3()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_ingreso($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_vmto);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    $vector[] = array(
                        "valor" => '36',
                        "val" => '',
                        "numero" => $bandera,
                        "ida" => $val->ida,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "precio" => $val->precio,
                        "cantidad" => $val->cantidad,
                        "unidad" => $val->unidad,
                        "importe" => $val->importe,
                        "id_solicitud" => $val->id_solicitud,
                        "id_prov" => $val->id_prov,
                        "id_soldet" => $val->id_soldet,
                        "pedido" => $val->no_pedido,
                        "orden" => $val->orden,
                        "solicitud" => $val->solic,
                        "recepcion" => $val->recep,
                        "id_recep_det" => $val->id_recep_det,
                        "id_recep" => $val->id_recepcion,
                        "id_trn_alm" => $val->id_trn_alm,
                        "id_trn_almd" => $val->id_trn_almd,
                        "id_arti_det" => $val->id_arti_det,
                        "fecha_vmto" => $fecha_cot,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_salida_inmediato()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id_trn = $_POST['id_trn_alma'];
            $glosa = $_POST['glosaa'];
            $tipo_mov = 11; // Hace referencia a la tabla tipo_mov con id=11, descrip=salida inmediato

            $obtener_concepto = Almacen::recuperar_tipo_concepto($tipo_mov, "CONSUMO");
            if (count($obtener_concepto) > 0) {
                foreach ($obtener_concepto as $val) {
                    $id_concepto = $val->idb;
                    $descripcion = $val->descripa;

                    $obtener_orden = Almacen::listar_trn_alm($tipo_mov);
                    if (count($obtener_orden) > 0) {
                        foreach ($obtener_orden as $val) {
                            $orden = $val->orden;
                            $orden++;
                        }
                    } else $orden = 1;

                    $dato = array();

                    $i = 0;
                    $id = $_POST['id_trn_almda'];
                    foreach ($id as $val) {
                        $dato[5][$i] = $val;
                        $i++;
                    }

                    $i = 0;
                    $id = $_POST['id_arti_deta'];
                    foreach ($id as $val) {
                        $dato[6][$i] = $val;
                        $i++;
                    }

                    $buscar = Almacen::buscar_trn_alm($id_trn);
                    if (count($buscar) > 0) {
                        foreach ($buscar as $val) {
                            $registrar = Almacen::registrar_ingreso($tipo_mov, $val->pedido_id, $val->recepcion_id, $id_concepto, $orden, $val->total, $val->fecha_transac, $val->ufv_id, $glosa, $usuario, "A");
                            if (count($registrar) > 0) {
                                foreach ($registrar as $val3) {
                                    $id_ingreso = $val3->registrar_ingreso;
                                }

                                for ($j = 0; $j < $i; $j++) {
                                    $buscar2 = Almacen::buscar_trn_almd($dato[5][$j]);
                                    if (count($buscar2) > 0) {
                                        foreach ($buscar2 as $val2) {
                                            $registrar_ingreso_det = Almacen::registrar_ingreso_det($id_ingreso, $val2->articulo_id, $val2->cant, $val2->precio, $val2->lote, 0);
                                            if ($registrar_ingreso_det) {
                                                $buscar3 = Almacen::actualizar_articulo_det_salida($dato[6][$j], 0, $id_trn);
                                            }
                                        }
                                    }
                                }
                                return 1;
                            } else return 0;
                        }
                    } else return 0;
                }
            } else return 0;
        }
    }

    public function listar_articulo_salida()
    {
        $vector = array();
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::ver_articulos_salida($no_orden);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->no_pedido;
                    $vector[1] = $val->orden;
                    $vector[2] = $val->solic;
                    $vector[3] = $val->recep;
                    $vector[4] = $val->proveedor;
                    $vector[5] = $val->no_fact;
                    $vector[6] = $val->fecha_transac;
                    $vector[7] = $val->tipo_mov;
                    $vector[8] = ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO");
                    $vector[10] = $val->glosa;
                    $vector[11] = $val->id_trn_alm;

                    $id = $vector[7];
                    $lista = Almacen::listar_tipo_mov();
                    if (count($lista) > 0) {
                        foreach ($lista as $val) {
                            if ($id == $val->id)
                                $vector[9] = $val->descrip;
                        }
                    }
                }
            }
            return $vector;
        }
    }

    public function listar_salida_stock_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            $descripcion = "INGRESOS STOCK";
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_ingresos_pendientes($descripcion);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        if ($val->est_salida == "P") {
                            $fecha_co = explode("-", $val->fecha_orden);
                            $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                            $vector[] = array(
                                "valor" => '35',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "no_recep" => $val->no_recep,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_ingresos_pendientes($descripcion);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        if ($val->est_salida == "A") {
                            $fecha_co = explode("-", $val->fecha_orden);
                            $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                            $vector[] = array(
                                "valor" => '35',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "no_recep" => $val->no_recep,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_ingresos_pendientes($descripcion);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '35',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "no_recep" => $val->no_recep,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_ingreso_inmediato()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $descripcion = "INGRESO INMEDIATO";
            $consulta = Almacen::listar_ingresos_pendientes($descripcion);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    if ($val->est_salida == "P") {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '35',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "no_recep" => $val->no_recep,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_salida_inmediato_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            $descripcion = "INGRESO INMEDIATO";
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_ingresos_pendientes($descripcion);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        if ($val->est_salida == "P") {
                            $fecha_co = explode("-", $val->fecha_orden);
                            $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                            $vector[] = array(
                                "valor" => '35',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "no_recep" => $val->no_recep,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_ingresos_pendientes($descripcion);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        if ($val->est_salida == "A") {
                            $fecha_co = explode("-", $val->fecha_orden);
                            $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                            $vector[] = array(
                                "valor" => '35',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "no_recep" => $val->no_recep,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_ingresos_pendientes($descripcion);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '35',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "no_recep" => $val->no_recep,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->est_salida == "P" ? "PENDIENTE" : "ACEPTADO")
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_salida_stock()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
        }
    }

    public function recuperar_datos_almacenados()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $dato = array();
            $datos = array();
            $no_pedido = $_POST['no_pedido'];
            $responsable = $_POST['responsable'];
            $motivo = $_POST['motivo'];
            $i = 0;
            $id = $_POST['valor_id'];
            foreach ($id as $val) {
                $dato[0][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['valor'];
            foreach ($id as $val) {
                $dato[1][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cant'];
            foreach ($id as $val) {
                $dato[2][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cantidad'];
            foreach ($id as $val) {
                $dato[3][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cant_disp'];
            foreach ($id as $val) {
                $dato[4][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['id_articulo'];
            foreach ($id as $val) {
                $dato[5][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['articulo'];
            foreach ($id as $val) {
                $dato[6][$i] = $val;
                $i++;
            }

            $l = 0;
            for ($j = 0; $j < $i; $j++) {
                if ($dato[1][$j] == "B") {
                    $l++;
                }
            }

            if ($l == 0) return [5];

            for ($j = 0; $j < $i; $j++) {
                if ($dato[1][$j] == "B") {
                    if ($dato[3][$j] > $dato[4][$j] || $dato[3][$j] == 0 || $dato[4][$j] == 0)
                        return [3, $j + 1];
                }
            }


            $k = 0;
            for ($j = 0; $j < $i; $j++) {
                if ($dato[1][$j] == "B") {
                    $datos[0][$k] = $dato[6][$j];
                    $datos[1][$k] = $dato[2][$j];
                    $datos[2][$k] = $dato[3][$j];
                    $datos[3][$k] = $dato[4][$j];
                    $datos[4][$k] = $dato[5][$j];
                    $k++;
                }
            }

            return [4, $no_pedido, $datos, $k, $responsable, $motivo];
        }
    }

    public function recuperar_datos_almacenados2()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $cant = $_POST['cant'];
            if ($cant > 0) {
                $dato = $_POST['dato'];
                for ($i = 0; $i < $cant; $i++) {
                    $vector[] = array(
                        "valor" => '37',
                        "numero" => $bandera,
                        "articulo" => $dato[0][$i],
                        "cantidad" => $dato[1][$i],
                        "cant_aprob" => $dato[2][$i],
                        "cant_disp" => $dato[3][$i],
                        "id_articulo" => $dato[4][$i],
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }

            return Datatables::of($vector)->toJson();
        }
    }

    public function recuperar_superior_responsable()
    {
        $usuario = session('id');
        $id = $_POST['id'];

        if (!empty($usuario)) {
            $lista = Solicitante::listar_funcionarios($id);
            //$lista = Solicitante::listar_funcionarios2($id);
            //return $lista;
            $html = '';
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($id == $val->id)
                        $html .= "<option value='$val->id'>" . $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat . "</option>";
                }
                foreach ($lista as $val) {
                    if ($id != $val->id)
                        $html .= "<option value='$val->id'>" . $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat . "</option>";
                }
            }
            return $html;
        }
    }

    public function guardar_datos_almacen_descargar()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $no_pedido = $_POST['no_pedido'];
            $responsable = $_POST['responsable'];
            $i = 0;
            $id = $_POST['valor_id'];
            foreach ($id as $val) {
                $dato[0][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['valor'];
            foreach ($id as $val) {
                $dato[1][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cant_apro'];
            foreach ($id as $val) {
                $dato[2][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['id_articulo'];
            foreach ($id as $val) {
                $dato[3][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['cantidad'];
            foreach ($id as $val) {
                $dato[5][$i] = $val;
                $i++;
            }

            $i = 0;
            $id = $_POST['valor2'];
            foreach ($id as $val) {
                $dato[6][$i] = $val;
                $i++;
            }

            for ($j = 0; $j < $i; $j++) {
                if ($dato[6][$j] == 'B') {
                    $dato[7][$j] = 'X';
                    $dato[5][$j] = 0;
                } else {
                    $dato[7][$j] = $dato[1][$j];
                    $dato[5][$j] = $dato[5][$j];
                }
            }

            for ($j = 0; $j < $i; $j++) {
                $actualizar = Almacen::actualizar_articulos_almacen($usuario, $dato[0][$j], $dato[7][$j], $dato[5][$j], $dato[2][$j]);
            }

            $can_aprob = Almacen::verificar_articulo_aprobado_almacen($no_pedido);
            foreach ($can_aprob as $val) {
                $cant_aprob = $val->verificar_articulo_aprobado_almacen;
            }

            if ($cant_aprob > 0) {
                $valor = 1;
                $actualiza = Almacen::actualizar_pedido_almacen($usuario, $no_pedido, $valor, $responsable);
            } else {
                $valor = 2;
                $actualiza = Almacen::actualizar_pedido_almacen($usuario, $no_pedido, $valor, $responsable);
            }



            $recuperar = Almacen::listar_pedido_almacen($no_pedido);
            if (count($recuperar) > 0) {
                foreach ($recuperar as $val) {
                    $programa = $val->programa;
                    $pedido = $val->ida;
                    $resp_almacen = $val->resp_alm;
                    $est_almacen = $val->estado_alma;
                }
            }

            $bandera = 0;

            if ($est_almacen == "A") {
                $bandera = 1;
                $seleccionar = Almacen::listar_todos_solicitud();
                if (empty($seleccionar)) {
                    $ban = 1;
                } else {
                    $ban = 0;
                }

                $verificar = Almacen::verificar_solicitud($programa, $pedido);
                if (empty($verificar)) {
                    $insertar = Almacen::insertar_solicitud($programa, $pedido, $resp_almacen);
                    if ($insertar) {
                        if ($ban == 1) {
                            $rec = Almacen::recuperar_ultima_solicitud();
                            if (count($rec) > 0) {
                                foreach ($rec as $val) {
                                    $id = $val->id;
                                }
                            }
                            $dato[0] = 1;
                            $no_solicitud = self::zero_fill($dato[0], 5);
                            $act = Almacen::actualizar_solicitud($no_solicitud, $id);

                            $recuperar2 = Almacen::listar_articulo_almacen($no_pedido);
                            if (count($recuperar2) > 0) {
                                foreach ($recuperar2 as $val) {
                                    $insertar2 = Almacen::insertar_solicitud_det($id, $val->art_id, $val->motivo, $val->cantidad);
                                }
                            }
                        } else {
                            $rec = Almacen::recuperar_ultima_solicitud();
                            if (count($rec) > 0) {
                                foreach ($rec as $val) {
                                    $id = $val->id;
                                }
                            }

                            $rec2 = Almacen::recuperar_no_solicitud($id - 1);
                            if (count($rec2) > 0) {
                                foreach ($rec2 as $val) {
                                    $vector[0] = $val->no_solic;
                                }
                            }

                            $vector[1] = (int)$vector[0];
                            $vector[1]++;
                            $dato[0] = $vector[1];

                            $no_solicitud = self::zero_fill($dato[0], 5);
                            $act = Almacen::actualizar_solicitud($no_solicitud, $id);

                            $recuperar2 = Almacen::listar_articulo_almacen($no_pedido);
                            if (count($recuperar2) > 0) {
                                foreach ($recuperar2 as $val) {
                                    $insertar2 = Almacen::insertar_solicitud_det($id, $val->art_id, $val->motivo, $val->cantidad);
                                }
                            }
                        }
                    }
                }
            }

            if ($est_almacen == "R") {
                $bandera = 1;
            }

            if ($bandera == 1) {
                $tipo_mov = 9; //id de tipo_mov=SALIDA STOCK
                $fech = $_POST['fechar'];
                $fecha = explode("-", $fech);
                $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $pedido = $_POST['id_pedido'];
                $recepcion = 0;
                $obtener = Almacen::listar_ufvs($fecha);
                $gestion = date('Y');
                $glosa = $_POST['glosa'];
                if (count($obtener) > 0) {
                    foreach ($obtener as $val) {
                        $id_ufv = $val->id;

                        $obtener_concepto = Almacen::recuperar_tipo_concepto($tipo_mov, "CONSUMO");
                        if (count($obtener_concepto) > 0) {
                            foreach ($obtener_concepto as $val) {
                                $id_concepto = $val->idb;
                                $descripcion = $val->descripa;

                                $obtener_orden = Almacen::listar_trn_alm($tipo_mov);
                                if (count($obtener_orden) > 0) {
                                    foreach ($obtener_orden as $val) {
                                        $orden = $val->orden;
                                        $orden++;
                                    }
                                } else $orden = 1;

                                $verificar = Almacen::verificar_ingreso_stock($pedido);
                                if (empty($verificar)) {
                                    //descargo
                                    for ($j = 0; $j < $i; $j++) {
                                        if ($dato[7][$j] == "B") {
                                            $tabla = array();
                                            $k = 0;
                                            $cant_disponible = Almacen::cant_dispponible_articulo_det($dato[3][$j]);
                                            foreach ($cant_disponible as $val) {
                                                $cantidad_disp_total = $val->cant_dispponible_articulo_det;
                                            }
                                            $buscar_lotes = Almacen::buscar_lotes_articulo_det($dato[3][$j]);
                                            if (count($buscar_lotes) > 0) {
                                                foreach ($buscar_lotes as $val) {
                                                    $tabla[$k][0] = $val->id;
                                                    $tabla[$k][1] = $val->cant_dispo;
                                                    $tabla[$k][2] = $val->precio;
                                                    $tabla[$k][3] = $val->lote;
                                                    $tabla[$k][4] = $dato[2][$j];
                                                    $tabla[$k][5] = $dato[3][$j];
                                                    $k++;
                                                }
                                            }

                                            $l = 0;
                                            $tot = 0;
                                            $cant_ped = $dato[5][$j];
                                            do {
                                                if ($tabla[$l][1] <= $cant_ped) {
                                                    $act_id[$l] = $tabla[$l][0];
                                                    $cantidad_pedida[$l] = $tabla[$l][4];
                                                    $act_cant_disp[$l] = 0;
                                                    $precio[$l] = $tabla[$l][2] * $tabla[$l][1];
                                                    $articulo_id[$l] = $tabla[$l][5];
                                                    $lote[$l] = $tabla[$l][3];
                                                    $precio_unitario[$l] = $tabla[$l][2];
                                                    $saldo[$l] = 0; //$cantidad_disp_total - $tabla[$l][1];
                                                    $cantidad_disp_total = $saldo[$l];
                                                    $cant_reg[$l] = $tabla[$l][1];
                                                    $cant_ped -= $tabla[$l][1];
                                                    $tot += $precio[$l];
                                                    $to[$j] = $tot;
                                                    $l++;
                                                } else {
                                                    $act_id[$l] = $tabla[$l][0];
                                                    $cantidad_pedida[$l] = $tabla[$l][4];
                                                    $act_cant_disp[$l] = $tabla[$l][1] - $cant_ped;
                                                    $precio[$l] = $tabla[$l][2] * abs($act_cant_disp[$l] - $tabla[$l][1]);
                                                    $articulo_id[$l] = $tabla[$l][5];
                                                    $lote[$l] = $tabla[$l][3];
                                                    $precio_unitario[$l] = $tabla[$l][2];
                                                    $saldo[$l] = $tabla[$l][1] - $cant_ped; //$cantidad_disp_total - abs($act_cant_disp[$l] - $tabla[$l][1]);
                                                    $cantidad_disp_total = $saldo[$l];
                                                    $cant_reg[$l] = $cant_ped;
                                                    $cant_ped = 0;
                                                    $tot += $precio[$l];
                                                    $to[$j] = $tot;
                                                    $l++;
                                                }
                                            } while ($cant_ped > 0);
                                            $total = array_sum($to);


                                            for ($n = 0; $n < $l; $n++) {
                                                $verificar = Almacen::verificar_ingreso_stock($pedido);
                                                if (empty($verificar)) {
                                                    $registrar = Almacen::registrar_ingreso($tipo_mov, $pedido, $recepcion, $id_concepto, $orden, $total, $fecha, $id_ufv, $glosa, $usuario, "P");
                                                    if (count($registrar) > 0) {
                                                        foreach ($registrar as $val) {
                                                            $id_ingreso = $val->registrar_ingreso;
                                                        }

                                                        $actualizar_ingreso = Almacen::actualizar_articulo_det_stock($act_id[$n], $act_cant_disp[$n]);
                                                        if ($actualizar_ingreso) {
                                                            $registrar_ingreso_det = Almacen::registrar_ingreso_det($id_ingreso, $articulo_id[$n], $cant_reg[$n], $precio_unitario[$n], $lote[$n], $saldo[$n]);
                                                        }
                                                    }
                                                } else {
                                                    foreach ($verificar as $val) {
                                                        $id_ingreso = $val->id;
                                                    }
                                                    $actualizar_total_trn = Almacen::actualizar_total_trnalm($id_ingreso, $total);


                                                    $actualizar_ingreso = Almacen::actualizar_articulo_det_stock($act_id[$n], $act_cant_disp[$n]);
                                                    if ($actualizar_ingreso) {
                                                        $registrar_ingreso_det = Almacen::registrar_ingreso_det($id_ingreso, $articulo_id[$n], $cant_reg[$n], $precio_unitario[$n], $lote[$n], $saldo[$n]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    return 1;
                                } else return 1;
                            }
                        }
                    }
                } else return 2;
            }

            return 1;
        }
    }

    public function resumen_inventario()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            return view('almacen.almacen.inventario');
        }
    }

    public function recuperar_gestion_inventario()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Almacen::listar_gestion_articulo_det();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Año de Reporte de Inventario' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->gestione'>Resumen de Movimientos " . $val->gestione . "</option>";
                }
            }
            return $html;
        }
    }

    public function ver_imprimir_inventario()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            $gestion = $_POST['anio'];

            /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Arep_resum_mov.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&gestione=" . $gestion;*/
            // $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3AInventario.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&gestione=" . $gestion;
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Arep_resum_mov.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&gestione=" . $gestion;


            return $html;
        }
    }

    public function inventario()
    {
        $usuario = session('usuario');
        $report = "";
        if (!empty($usuario)) {
            /*$report = 'http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Arep_inventario_almacen.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf';*/
            $report = 'https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Arep_inventario_almacen.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf';


            return view('reportes.index')->with('report', $report);
        }
    }

    public function kardex_articulo()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            return view('almacen.almacen.articulo');
        }
    }

    public function imprimir_kardex_articulo()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            $articulo = $_POST['articulo'];
            $fecha_inicio = $_POST['fechai'];
            $fecha_final = $_POST['fechaf'];
            $fecha_co = explode("-", $fecha_inicio);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];
            $fecha_inicio = $fecha_cot;
            $fecha_co = explode("-", $fecha_final);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];
            $fecha_final = $fecha_cot;
            /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3AKardex_Articulo.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&id_articuloe=" . $articulo . "&fechaie=" . $fecha_inicio . "&fechafe=" . $fecha_final;*/
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3AKardex_Articulo.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&id_articuloe=" . $articulo . "&fechaie=" . $fecha_inicio . "&fechafe=" . $fecha_final;


            return $html;
        }
    }

    public function cierre()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            return view('almacen.almacen.cierre');
        }
    }

    public function cierre_almacen()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha_inicio = $_POST['fechai'];
            $fecha_final = $_POST['fechaf'];
            $fecha_co = explode("-", $fecha_inicio);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];
            $fecha_inicio = $fecha_cot;
            $fecha_co = explode("-", $fecha_final);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];
            $fecha_final = $fecha_cot;
            /* $fecha_inicio = '2023-01-01';
            $fecha_final = '2023-12-31', por el momento se recupera el valor de de ufv de la fecha seleccionada */
            $dato = array();
            $valor = (!empty($_POST['factor']) ? $_POST['factor'] : 0);
            if ($fecha_inicio < $fecha_final) {
                $i = 0;
                $obtener = Almacen::obtener_datos_cierre($fecha_inicio, $fecha_final);
                if (count($obtener) > 0) {
                    foreach ($obtener as $val) {
                        $dato[$i][0] = $val->id_trne;
                        $dato[$i][1] = $val->articulo_ide;
                        $dato[$i][2] = $val->lotee;
                        $dato[$i][3] = $val->cant_dispoe;
                        $dato[$i][4] = $val->fecha_ingresoe;
                        $dato[$i][5] = $val->precioe;
                        $dato[$i][6] = $val->id_articulo_det;

                        if ($valor == 1) {
                            $ufv = Almacen::listar_ufvs($fecha_final);
                            if (count($ufv) > 0) {
                                foreach ($ufv as $val2) {
                                    $ufv_final = $val2->val_ufv;
                                }
                            } else return 3;
                            $ufv = Almacen::listar_ufvs($val->fecha_ingresoe);
                            if (count($ufv) > 0) {
                                foreach ($ufv as $val2) {
                                    $ufv_inicial = $val2->val_ufv;
                                }
                            } else return 3;
                            $factor = ($ufv_final / $ufv_inicial) - 1;
                            $dato[$i][7] = $val->precioe + $factor;
                        } else {
                            $factor = 0;
                            $dato[$i][7] = $val->precioe;
                        }

                        $dato[$i][8] = $factor;
                        $dato[$i][9] = ($val->cant_dispoe * $dato[$i][7]);
                        $i++;
                    }
                } else return 4;

                $fecha_transac = date('Y') . '-01-01'; //de la gestion actual -> 2023-01-01
                $ufv = Almacen::listar_ufvs($fecha_transac);
                if (count($ufv) > 0) {
                    foreach ($ufv as $val2) {
                        $ufv_id = $val2->id;
                    }
                }

                $total = 0;
                for ($j = 0; $j < $i; $j++) {
                    $total += $dato[$j][9];
                }

                $l = 0;
                $registrar = Almacen::registrar_ingreso(8, 0, 0, 17, 1, $total, $fecha_transac, $ufv_id, "CIERRE DE GESTION " . date('Y') - 1, $usuario, "P");
                if (count($registrar) > 0) {
                    foreach ($registrar as $val) {
                        $id_trn = $val->registrar_ingreso;

                        for ($k = 0; $k < $i; $k++) {
                            $registrar_articulo_det = Almacen::registrar_articulo_det($dato[$k][1], $dato[$k][3], $dato[$k][7], $dato[$k][2], date('Y') . '-12-31', 0, 8, date('Y',), $id_trn, $dato[$k][3]); //la fecha de ingreso se inserta en la base de datos
                            if (count($registrar_articulo_det) > 0) {
                                foreach ($registrar_articulo_det as $val2) {
                                    $id_articulo_det = $val2->registrar_articulo_det;
                                }
                                $registrar_ingreso_det = Almacen::registrar_ingreso_det($id_trn, $dato[$k][1], $dato[$k][3], $dato[$k][7], $dato[$k][2], $dato[$k][3]);
                                if ($registrar_ingreso_det) {
                                    $registrar_cierre = Almacen::registrar_cierre($dato[$k][1], $dato[$k][3], $dato[$k][7], $dato[$k][4], date('Y') - 1 . '-12-31', $dato[$k][8], date('Y'), date('Y') . '-01-01', $usuario, $id_trn, $id_articulo_det, $dato[$k][6]);
                                    if ($registrar_cierre) {
                                        /* $actualizar = Almacen::baja_cierre_articulo($dato[$k][6]); */
                                        $l++;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($l == count($obtener)) {
                    return 1;
                } else return 5;
            } else return 2;
        }
    }

    public function vista_cierre()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.almacen.reporte_cierre');
        }
    }

    public function recuperar_gestion_cierre()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Almacen::listar_gestion_articulo_det();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Año de Reporte de Cierre' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->gestione'>Cierre Anual " . $val->gestione . "</option>";
                }
            }
            return $html;
        }
    }

    public function ver_imprimir_cierre()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            $gestion = $_POST['anio'];
            /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3ACierre.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&gestione=" . $gestion; //para prueba $gestion-1*/
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3ACierre.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&gestione=" . $gestion; //para prueba $gestion-1
            /*https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3A*/
            return $html;
        }
    }

    public function recepcion_orden_compra()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('almacen.recepcion.compra');
        }
    }

    public function listar_todo_orden_compra()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Almacen::listar_orden_almacen5();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_orden);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    if ($val->estado_gen == "P") {
                        $vector[] = array(
                            "valor" => '30',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_todo_orden_compra_valor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Almacen::listar_orden_almacen5();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "P") {
                            $vector[] = array(
                                "valor" => '30',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen5();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        if ($val->estado_gen == "A") {
                            $vector[] = array(
                                "valor" => '30',
                                "val" => '',
                                "numero" => $bandera,
                                "fecha" => $fecha_cot,
                                "orden" => $val->orden,
                                "unidad" => $val->unidad_solicitante,
                                "proveedor" => $val->proveedor,
                                "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                                "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                                "valor_ord" => $val->valor,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Almacen::listar_orden_almacen5();
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $fecha_co = explode("-", $val->fecha_orden);
                        $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                        $vector[] = array(
                            "valor" => '30',
                            "val" => '',
                            "numero" => $bandera,
                            "fecha" => $fecha_cot,
                            "orden" => $val->orden,
                            "unidad" => $val->unidad_solicitante,
                            "proveedor" => $val->proveedor,
                            "estado" => ($val->estado_gen == "P" ? "PENDIENTE" : "APROBADO"),
                            "estado_rec" => ($val->estado_rec == "P" ? "PENDIENTE" : "APROBADO"),
                            "valor_ord" => $val->valor,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }
}
