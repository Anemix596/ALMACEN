<?php

namespace App\Http\Controllers;

use App\Models\Cotizador;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class CotizadorController extends Controller
{

    function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

    public function obtener_datos_anpe_orden($dato, $dato2)
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $no_pedido = $dato;
            $id_solicitud = $dato2;
            $obtener = Cotizador::obtener_datos_prov_nacional2($id_solicitud, $usuario);
            if (count($obtener) > 0) {
                foreach ($obtener as $val) {
                    $proveedor = $val->id_prova;
                }
                $consulta = Cotizador::listar_prov_nacional_orden($no_pedido, $proveedor, $id_solicitud, $usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $vector[0] = $val->fecha_cot;
                        $vector[1] = $val->fecha;
                        $vector[2] = $proveedor;
                        $vector[3] = date('d-m-Y');
                        $vector[4] = ($val->oferta == null ? '' : $val->oferta);
                        $vector[5] = ($val->tiempo == null ? '' : $val->tiempo);
                        $vector[6] = $val->no_ord;
                        $vector[7] = ($val->est_orden == "A" ? "APROBADO" : "PENDIENTE");
                        $vector[8] = ($val->archi_orden == null ? "VACIO" : $val->archi_orden);
                    }
                }
            }

            return $vector;
        }
    }

    public function lista_pedido_pendiente()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_pendientes_cotizador($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                    foreach ($consulta2 as $val2) {
                        $obten = $val2->cantidad_solicitud_cotizador2;
                    }
                    $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                    foreach ($consulta2 as $val2) {
                        $obten2 = $val2->cantidad_solicitud_cotizador;
                    }
                    if ($obten != $obten2 && $obten > 0) {
                        if ($obten == $obten2) $c = "APROBADO";
                        else $c = "PENDIENTE";
                        $vector[] = array(
                            "valor" => '13',
                            "val" => '',
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "estado" => $c,
                        );
                        $bandera++;
                    }
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
            $consulta = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '14',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "id_articulo" => $val->id_articulo,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
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
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Cotizador::tipo_modalidad($val->no_solicitud, $usuario);
                    if (count($consulta2) > 0) {
                        foreach ($consulta2 as $val2) {
                            $tipo = $val2->tipo_mod;
                        }
                    }
                }
            }
            return $tipo;
        }
    }

    public function lista_pedido_valor()
    {
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $usuario = session('id');
        if (!empty($usuario)) {
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';
            $vector = array();
            $bandera = 1;
            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten = $val2->cantidad_solicitud_cotizador2;
                        }
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten2 = $val2->cantidad_solicitud_cotizador;
                        }
                        if ($obten != $obten2 && $obten > 0) {
                            if ($obten == $obten2) {

                                $valor = 0;
                                $consulta7 = Cotizador::estado_cotizacion2($val->no_pedido, $usuario);
                                $consulta8 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                                $esta = array();
                                $i = 0;
                                if (count($consulta7) > 0) {
                                    foreach ($consulta7 as $val7) {
                                        $esta[$i] = $val7->estado;
                                        $i++;
                                    }
                                    $valor = 1;
                                }
                                if (count($consulta8) > 0) {
                                    foreach ($consulta8 as $val8) {
                                        $esta[$i] = $val8->estado;
                                        $i++;
                                    }
                                    $valor = 1;
                                }
                                if ($valor == 0) $esta[0] = "P";
                                if (in_array("A", $esta)) $c = "APROBADO";
                                else $c = "EDICION";
                            } else $c = "PENDIENTE";
                            $vector[] = array(
                                "valor" => '13',
                                "val" => '',
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "estado" => $c,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            if ($valor1 != 'P' && $valor2 == 'A') {
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten = $val2->cantidad_solicitud_cotizador2;
                        }
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten2 = $val2->cantidad_solicitud_cotizador;
                        }
                        if ($obten == $obten2 && $obten > 0) {
                            if ($obten == $obten2) {

                                $valor = 0;
                                $consulta7 = Cotizador::estado_cotizacion2($val->no_pedido, $usuario);
                                $consulta8 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                                $esta = array();
                                $i = 0;
                                if (count($consulta7) > 0) {
                                    foreach ($consulta7 as $val7) {
                                        $esta[$i] = $val7->estado;
                                        $i++;
                                    }
                                    $valor = 1;
                                }
                                if (count($consulta8) > 0) {
                                    foreach ($consulta8 as $val8) {
                                        $esta[$i] = $val8->estado;
                                        $i++;
                                    }
                                    $valor = 1;
                                }
                                if ($valor == 0) $esta[0] = "P";
                                if (in_array("A", $esta)) $c = "APROBADO";
                                else $c = "EDICION";
                            } else $c = "PENDIENTE";
                            $vector[] = array(
                                "valor" => '13',
                                "val" => '',
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "estado" => $c,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            if ($valor1 == 'P' && $valor2 == 'A') {
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten = $val2->cantidad_solicitud_cotizador2;
                        }
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten2 = $val2->cantidad_solicitud_cotizador;
                        }
                        if ($obten > 0) {
                            if ($obten == $obten2) {

                                $valor = 0;
                                $consulta7 = Cotizador::estado_cotizacion2($val->no_pedido, $usuario);
                                $consulta8 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                                $esta = array();
                                $i = 0;
                                if (count($consulta7) > 0) {
                                    foreach ($consulta7 as $val7) {
                                        $esta[$i] = $val7->estado;
                                        $i++;
                                    }
                                    $valor = 1;
                                }
                                if (count($consulta8) > 0) {
                                    foreach ($consulta8 as $val8) {
                                        $esta[$i] = $val8->estado;
                                        $i++;
                                    }
                                    $valor = 1;
                                }
                                if ($valor == 0) $esta[0] = "P";
                                if (in_array("A", $esta)) $c = "APROBADO";
                                else $c = "EDICION";
                            } else $c = "PENDIENTE";
                            $vector[] = array(
                                "valor" => '13',
                                "val" => '',
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "estado" => $c,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_datos()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $estado = $_POST['valor'];
            $no_solicitud = $_POST['no_solicitud'];
            $modalidad = $_POST['modalidad'];
            $actualiza = Cotizador::actualizar_cotizador($no_solicitud, $estado, $usuario, $modalidad);
            if ($actualiza) {
                $id_solicitud = $_POST['id_solicitud'];
                $id_sol_det = $_POST['id_sol_det'];
                $j = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$j] = $val;
                    $j++;
                }
                $id_sol_det = $_POST['id_articulo'];
                $j = 0;
                foreach ($id_sol_det as $val) {
                    $dato[1][$j] = $val;
                    $j++;
                }


                if ($modalidad == 1) {
                    for ($i = 0; $i < 3; $i++) {
                        for ($k = 0; $k < $j; $k++) {
                            $verificar = Cotizador::verificar_cotizacion($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                            if (count($verificar) < 3) {
                                $insertar = Cotizador::insertar_cotizacion($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                            }
                        }
                    }
                }
                if ($modalidad == 2 || $modalidad == 3 || $modalidad == 4) {
                    for ($k = 0; $k < $j; $k++) {
                        $verificar = Cotizador::verificar_prov_nacional($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                        if (empty($verificar)) {
                            $insertar = Cotizador::insertar_prov_nacional($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                        }
                    }
                }

                return 1;
            }
            return 0;
        }
    }

    public function editar_datos()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $estado = $_POST['evalor'];
            $no_solicitud = $_POST['no_solicitud'];
            $mod = $_POST['emod'];
            $modalidad = $_POST['emodalidad'];
            $actualiza = Cotizador::actualizar_cotizador($no_solicitud, $estado, $usuario, $modalidad);
            if ($actualiza) {
                $id_solicitud = $_POST['id_solicitud'];
                $id_sol_det = $_POST['id_sol_det'];
                $j = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$j] = $val;
                    $j++;
                }
                $id_sol_det = $_POST['id_articulo'];
                $j = 0;
                foreach ($id_sol_det as $val) {
                    $dato[1][$j] = $val;
                    $j++;
                }

                if ($mod != $modalidad && $mod == 1) {
                    $ban = 1;
                    for ($i = 0; $i < 3; $i++) {
                        for ($k = 0; $k < $j; $k++) {
                            $insertar = Cotizador::actualizar_cotizacion_mod1($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                        }
                    }

                    for ($k = 0; $k < $j; $k++) {
                        $verificar = Cotizador::verificar_prov_nacional($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                        if (empty($verificar)) {
                            $insertar = Cotizador::insertar_prov_nacional($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                        }
                    }
                }

                if ($mod != $modalidad && ($mod == 2 || $mod == 3 || $mod == 4) && ($modalidad == 2 || $modalidad == 3 || $modalidad == 4)) {
                    $ban = 1;
                    for ($k = 0; $k < $j; $k++) {
                        $insertar = Cotizador::actualizar_cotizacion_mod3($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                    }
                }

                if ($mod != $modalidad && ($mod == 2 || $mod == 3 || $mod == 4) && $modalidad == 1) {
                    $ban = 1;
                    for ($k = 0; $k < $j; $k++) {
                        $insertar = Cotizador::actualizar_cotizacion_mod2($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                    }

                    for ($i = 0; $i < 3; $i++) {
                        for ($k = 0; $k < $j; $k++) {
                            $verificar = Cotizador::verificar_cotizacion($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                            if (count($verificar) < 3) {
                                $insertar = Cotizador::insertar_cotizacion($id_solicitud, $dato[0][$k], $dato[1][$k], $usuario);
                            }
                        }
                    }
                }

                return 1;
            }
            return 0;
        }
    }

    public function proveedor_cotizacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.modalidad.cotizacion');
        }
    }

    public function lista_pedido_proveedor()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_pendientes_cotizador2($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                    foreach ($consulta5 as $val5) {
                        $consulta6 = Cotizador::cantidad_cotizacion($val5->id_solicitud, $val5->ide, $usuario);
                        $solicitud = $val5->id_solicitud;
                        foreach ($consulta6 as $val6) {
                            $cant = $val6->cantidad_cotizacion;
                        }
                    }

                    if ($cant == 3) $c2 = 1;
                    else $c2 = 0;

                    if ($cant < 3) {
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten = $val2->cantidad_solicitud_cotizador2;
                        }
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten2 = $val2->cantidad_solicitud_cotizador;
                        }
                        if ($obten == $obten2 && $obten > 0) {
                            if ($obten == $obten2) $c = "APROBADO";
                            else $c = "PENDIENTE";
                            $consulta7 = Cotizador::estado_cotizacion($val->no_pedido, $usuario);
                            $i = 0;
                            if (count($consulta7) > 0) {
                                foreach ($consulta7 as $val7) {
                                    $esta[$i] = $val7->estado;
                                    $i++;
                                }
                            } else $esta[0] = "P";
                            if (in_array("A", $esta)) $est = "APROBADO";
                            else $est = "PENDIENTE";
                            $vector[] = array(
                                "valor" => '15',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "/" . $val->no_pedido . "/" . $solicitud,
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "estado" => $c,
                                "est_gen" => $est,
                            );
                            $bandera++;
                        }
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_proveedor_valor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $vector = array();
                $bandera = 1;
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador2($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_cotizacion($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_cotizacion;
                            }
                        }

                        if ($cant == 3) $c2 = 1;
                        else $c2 = 0;

                        if ($cant < 3) {
                            $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                            foreach ($consulta2 as $val2) {
                                $obten = $val2->cantidad_solicitud_cotizador2;
                            }
                            $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                            foreach ($consulta2 as $val2) {
                                $obten2 = $val2->cantidad_solicitud_cotizador;
                            }
                            if ($obten == $obten2 && $obten > 0) {
                                if ($obten == $obten2) $c = "APROBADO";
                                else $c = "PENDIENTE";
                                $consulta7 = Cotizador::estado_cotizacion($val->no_pedido, $usuario);
                                $i = 0;
                                $esta = array();
                                if (count($consulta7) > 0) {
                                    foreach ($consulta7 as $val7) {
                                        $esta[$i] = $val7->estado;
                                        $i++;
                                    }
                                } else $esta[0] = "P";
                                if (in_array("A", $esta)) $est = "APROBADO";
                                else $est = "PENDIENTE";
                                $vector[] = array(
                                    "valor" => '15',
                                    "val" => $c2 . "/" . $val->no_pedido,
                                    "val2" => $c2 . "/" . $val->no_pedido . "/" . $solicitud,
                                    "numero" => $bandera,
                                    "no_pedido" => $val->no_pedido,
                                    "unidad" => $val->unidad_solicitante,
                                    "cantidad" => $cant,
                                    "id_solicitud" => $solicitud,
                                    "estado" => $c,
                                    "est_gen" => $est,
                                );
                                $bandera++;
                            }
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            if ($valor1 != 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador2($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_cotizacion($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_cotizacion;
                            }
                        }

                        if ($cant == 3) $c2 = 1;
                        else $c2 = 0;

                        if ($cant == 3) {
                            $consulta10 = Cotizador::cantidad_listar_orden_cotizador($val->no_pedido, $usuario);
                            foreach ($consulta10 as $val10) {
                                $cant_orden = $val10->cantidad_listar_orden_cotizador;
                            }

                            $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                            foreach ($consulta2 as $val2) {
                                $obten = $val2->cantidad_solicitud_cotizador2;
                            }
                            $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                            foreach ($consulta2 as $val2) {
                                $obten2 = $val2->cantidad_solicitud_cotizador;
                            }
                            if ($obten == $obten2 && $obten > 0) {
                                if ($obten == $obten2) $c = "APROBADO";
                                else $c = "PENDIENTE";
                                $consulta7 = Cotizador::estado_cotizacion($val->no_pedido, $usuario);
                                $i = 0;
                                $esta = array();
                                foreach ($consulta7 as $val7) {
                                    $esta[$i] = $val7->estado;
                                    $i++;
                                }
                                if (in_array("A", $esta)) $est = "APROBADO";
                                else $est = "PENDIENTE";
                                $vector[] = array(
                                    "valor" => '15',
                                    "val" => $c2 . "/" . $val->no_pedido . "/" . $cant_orden,
                                    "val2" => $c2 . "/" . $val->no_pedido . "/" . $solicitud,
                                    "numero" => $bandera,
                                    "no_pedido" => $val->no_pedido,
                                    "unidad" => $val->unidad_solicitante,
                                    "cantidad" => $cant,
                                    "id_solicitud" => $solicitud,
                                    "estado" => $c,
                                    "est_gen" => $est,
                                );
                                $bandera++;
                            }
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador2($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_cotizacion($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_cotizacion;
                            }
                        }

                        if ($cant == 3) $c2 = 1;
                        else $c2 = 0;

                        $consulta10 = Cotizador::cantidad_listar_orden_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta10 as $val10) {
                            $cant_orden = $val10->cantidad_listar_orden_cotizador;
                        }

                        $consulta2 = Cotizador::cantidad_solicitud_cotizador2($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten = $val2->cantidad_solicitud_cotizador2;
                        }
                        $consulta2 = Cotizador::cantidad_solicitud_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta2 as $val2) {
                            $obten2 = $val2->cantidad_solicitud_cotizador;
                        }
                        if ($obten == $obten2 && $obten > 0) {
                            if ($obten == $obten2) $c = "APROBADO";
                            else $c = "PENDIENTE";
                            $consulta7 = Cotizador::estado_cotizacion($val->no_pedido, $usuario);
                            $i = 0;
                            $esta = array();
                            if (count($consulta7) > 0) {
                                foreach ($consulta7 as $val7) {
                                    $esta[$i] = $val7->estado;
                                    $i++;
                                }
                            } else $esta[0] = "P";
                            if (in_array("A", $esta)) $est = "APROBADO";
                            else $est = "PENDIENTE";
                            $vector[] = array(
                                "valor" => '15',
                                "val" => $c2 . "/" . $val->no_pedido . "/" . $cant_orden,
                                "val2" => $c2 . "/" . $val->no_pedido . "/" . $solicitud,
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "estado" => $c,
                                "est_gen" => $est,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_articulo_proveedor()
    {
        $vector = array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Cotizador::listar_cotizacion($val->id_solicitud, $val->ide, $usuario);
                    if (count($consulta2) > 0) {
                        foreach ($consulta2 as $val2) {
                            $fecha = $val2->fechaa;
                            $id_cot = $val2->ida;
                            $fecha2 = $val2->fech;
                        }
                        $vector[] = array(
                            "valor" => '16',
                            "val" => '',
                            "numero" => $bandera,
                            "id" => $val->ide,
                            "unidad" => $val->unidad_solicitante,
                            "id_articulo" => $val->id_articulo,
                            "articulo" => $val->articulo . " - " . $val->descripcion,
                            "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                            "no_solicitud" => $val->no_solicitud,
                            "id_solicitud" => $val->id_solicitud,
                            "cantidad" => $val->cant_aprob,
                            "unidad" => $val->unidad,
                            "id_cot" => $id_cot,
                            "fecha" => $fecha,
                            "fecha2" => $fecha2,
                            "no_pedi" => $val->no_pedido,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_articulo_proveedor2()
    {
        date_default_timezone_set("America/La_Paz");
        $vector = array();
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Cotizador::listar_cotizacion($val->id_solicitud, $val->ide, $usuario);
                    $consulta3 = Cotizador::cantidad_cotizacion($val->id_solicitud, $val->ide, $usuario);
                    foreach ($consulta2 as $val2) {
                        $vector[0] = $val2->ida;
                        $vector[1] = $val2->fechaa;
                        $vector[2] = $val2->fech;
                        $vector[3] = date('d-m-Y');
                        $vector[5] = $val2->id_sola;
                    }
                    foreach ($consulta3 as $val3) {
                        $vector[4] = $val3->cantidad_cotizacion;
                    }
                }
            }
            return $vector;
        }
    }

    public function guardar_datos_cotizacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $estado = $_POST['estado'];
            if ($estado == "A") {
                $fecha = $_POST['fecha2'];
                $fecha_cot = $_POST['fecha_cot'];
                $no_pedido = $_POST['no_pedido'];
                $fecha_co = explode("-", $fecha_cot);
                $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

                if ($fecha_cot >= $fecha) {
                    $id_proveedor = $_POST['proveedor'];
                    $oferta = $_POST['oferta'];
                    $tiempo = $_POST['tiempo'];
                    $id_solicitud = $_POST['id_solicitud'];
                    $id_sol_det = $_POST['id_sol_det'];
                    $i = 0;
                    foreach ($id_sol_det as $val) {
                        $dato[0][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['id_cot'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[1][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['preciou'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[2][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['cumple'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[3][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['cantidad'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[4][$i] = $val;
                        $i++;
                    }

                    for ($j = 0; $j < $i; $j++) {
                        $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                    }


                    for ($j = 0; $j < $i; $j++) {
                        $actualizar = Cotizador::actualizar_cotizacion($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo);
                        $cantidad = Cotizador::cantidad_cotizacion($id_solicitud, $dato[0][$j], $usuario);
                    }
                    foreach ($cantidad as $val) {
                        $cant = $val->cantidad_cotizacion;
                    }

                    if ($cant == 3) {
                        $k = 0;
                        $prov = Cotizador::obtener_proveedor($id_solicitud, $usuario);
                        foreach ($prov as $val) {
                            $list[$k] = $val->idp;
                            $k++;
                        }

                        $k = 0;
                        for ($j = 0; $j < $i; $j++) {

                            $dat = Cotizador::recuperar_datos_cotizacion($id_solicitud, $dato[0][$j], $usuario);

                            if (count($dat) > 0) {
                                foreach ($dat as $val) {
                                    $recu[0][$k] = $val->id;
                                    $recu[1][$k] = $val->id_prov;
                                    $recu[2][$k] = $val->id_sol;
                                    $recu[3][$k] = $val->id_soldet;
                                    $recu[4][$k] = $val->preciou;
                                    $recu[5][$k] = $val->cantidad;
                                    $recu[6][$k] = $val->id_art;
                                    $k++;
                                }
                            }
                        }

                        $seleccionar = Cotizador::listar_todos_orden();
                        if (empty($seleccionar)) {
                            $ban = 1;
                        } else {
                            $ban = 0;
                        }

                        for ($m = 0; $m < $k; $m++) {
                            $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                            if (empty($verificar)) {
                                $insertar = Cotizador::insertar_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if ($insertar) {
                                    if ($ban == 1) {
                                        $ban = 0;
                                        $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }
                                        $dato[0] = 1;
                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    } else {
                                        $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }

                                        $rec2 = Cotizador::recuperar_no_orden();
                                        if (count($rec2) > 0) {
                                            foreach ($rec2 as $val) {
                                                $vector[0] = $val->no_orden;
                                            }
                                        }

                                        $vector[1] = (int)$vector[0];
                                        $vector[1]++;
                                        $dato[0] = $vector[1];

                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    }
                                } else return 0;
                            } else {
                                foreach ($verificar as $val) {
                                    $id = $val->id;
                                }

                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        }
                    }


                    if ($cant == 1) return [1, 1, $no_pedido];
                    if ($cant == 2) return [1, 2, $no_pedido];
                    if ($cant == 3) return [1, 3, $no_pedido];
                } else return 0;
            }
            if ($estado == "R") {
                $fecha = $_POST['fecha2'];
                $fecha_cot = $_POST['fecha_cot'];
                $no_pedido = $_POST['no_pedido'];
                $fecha_co = explode("-", $fecha_cot);
                $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

                if ($fecha_cot >= $fecha) {
                    $id_proveedor = $_POST['proveedor'];
                    $oferta = $_POST['oferta'];
                    $tiempo = $_POST['tiempo'];
                    $id_solicitud = $_POST['id_solicitud'];
                    $id_sol_det = $_POST['id_sol_det'];
                    $i = 0;
                    foreach ($id_sol_det as $val) {
                        $dato[0][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['id_cot'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[1][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['preciou'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[2][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['cumple'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[3][$i] = $val;
                        $i++;
                    }

                    $id_cot = $_POST['cantidad'];
                    $i = 0;
                    foreach ($id_cot as $val) {
                        $dato[4][$i] = $val;
                        $i++;
                    }

                    for ($j = 0; $j < $i; $j++) {
                        $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                    }


                    for ($j = 0; $j < $i; $j++) {
                        $actualizar = Cotizador::actualizar_cotizacion($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo);
                        $cantidad = Cotizador::cantidad_cotizacion($id_solicitud, $dato[0][$j], $usuario);
                    }
                    foreach ($cantidad as $val) {
                        $cant = $val->cantidad_cotizacion;
                    }

                    if ($cant == 1) {
                        for ($j = 0; $j < 2; $j++) {
                            $consulta_proveedor = Cotizador::proveedor_aleatorio($id_proveedor);
                            foreach ($consulta_proveedor as $val) {
                                $id_proveedor = $val->proveedor_aleatorio;
                            }
                            $consultar = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
                            if (count($consultar) > 0) {
                                foreach ($consultar as $valr) {
                                    $consultar2 = Cotizador::listar_cotizacion($valr->id_solicitud, $valr->ide, $usuario);
                                    foreach ($consultar2 as $valr2) {
                                        $cot = $valr2->ida;

                                        $dato[2] = 0;
                                        $dato[3] = "NO";
                                        $actualizar = Cotizador::actualizar_cotizacion($fecha_cot, $id_proveedor, $dato[2], $dato[3], $cot, $oferta, $tiempo);
                                        $canti = Cotizador::cantidad_cotizacion($valr->id_solicitud, $valr->ide, $usuario);
                                        foreach ($canti as $valr3) {
                                            $cantid = $valr3->cantidad_cotizacion;
                                        }
                                    }
                                }
                            }
                        }
                    } else if ($cant == 2) {
                        for ($j = 0; $j < 1; $j++) {
                            $consulta_proveedor = Cotizador::proveedor_aleatorio($id_proveedor);
                            foreach ($consulta_proveedor as $val) {
                                $id_proveedor = $val->proveedor_aleatorio;
                            }
                            $consultar = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
                            if (count($consultar) > 0) {
                                foreach ($consultar as $valr) {
                                    $consultar2 = Cotizador::listar_cotizacion($valr->id_solicitud, $valr->ide, $usuario);
                                    foreach ($consultar2 as $valr2) {
                                        $cot = $valr2->ida;

                                        $dato[2] = 0;
                                        $dato[3] = "NO";
                                        $actualizar = Cotizador::actualizar_cotizacion($fecha_cot, $id_proveedor, $dato[2], $dato[3], $cot, $oferta, $tiempo);
                                        $canti = Cotizador::cantidad_cotizacion($valr->id_solicitud, $valr->ide, $usuario);
                                        foreach ($canti as $valr3) {
                                            $cantid = $valr3->cantidad_cotizacion;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                    }

                    if ($cantid == 3) {
                        $k = 0;
                        $prov = Cotizador::obtener_proveedor($id_solicitud, $usuario);
                        foreach ($prov as $val) {
                            $list[$k] = $val->idp;
                            $k++;
                        }

                        $k = 0;
                        for ($j = 0; $j < $i; $j++) {

                            $dat = Cotizador::recuperar_datos_cotizacion($id_solicitud, $dato[0][$j], $usuario);

                            if (count($dat) > 0) {
                                foreach ($dat as $val) {
                                    $recu[0][$k] = $val->id;
                                    $recu[1][$k] = $val->id_prov;
                                    $recu[2][$k] = $val->id_sol;
                                    $recu[3][$k] = $val->id_soldet;
                                    $recu[4][$k] = $val->preciou;
                                    $recu[5][$k] = $val->cantidad;
                                    $recu[6][$k] = $val->id_art;
                                    $k++;
                                }
                            }
                        }

                        $seleccionar = Cotizador::listar_todos_orden();
                        if (empty($seleccionar)) {
                            $ban = 1;
                        } else {
                            $ban = 0;
                        }

                        for ($m = 0; $m < $k; $m++) {
                            $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                            if (empty($verificar)) {
                                $insertar = Cotizador::insertar_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if ($insertar) {
                                    if ($ban == 1) {
                                        $ban = 0;
                                        $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }
                                        $dato[0] = 1;
                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    } else {
                                        $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }

                                        $rec2 = Cotizador::recuperar_no_orden();
                                        if (count($rec2) > 0) {
                                            foreach ($rec2 as $val) {
                                                $vector[0] = $val->no_orden;
                                            }
                                        }

                                        $vector[1] = (int)$vector[0];
                                        $vector[1]++;
                                        $dato[0] = $vector[1];

                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    }
                                } else return 0;
                            } else {
                                foreach ($verificar as $val) {
                                    $id = $val->id;
                                }

                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        }
                    }

                    return 5;
                } else return 0;
            }
        }
    }

    public function recuperar_proveedor()
    {
        $id = $_POST['id'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Cotizador::listar_proveedor();
            $html = '';
            $consulta = Cotizador::obtener_proveedor($id, $usuario);
            $vector = array();
            if (count($consulta) > 0) {
                $i = 0;
                foreach ($consulta as $val2) {
                    $vector[$i] = $val2->idp;
                    $i++;
                }
            }
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Proveedor' . "</option>";
                foreach ($lista as $val) {
                    if (!in_array($val->id, $vector)) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }
            }

            return $html;
        }
    }

    public function editar_proveedor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $id_solicitud = $_POST['id'];
            $valor = $_POST['valor'];
            $obtener = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, $valor);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }

            $consulta = Cotizador::listar_cotizacion2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '17',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio" => $val->precio * $val->cant_aprob,
                        "no_pedi" => $val->no_pedido,
                        "cumple" => $val->cumplimiento,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function editar_proveedor2()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $no_pedido = $_POST['no'];
            $id_solicitud = $_POST['id'];
            $valor = $_POST['valor'];
            $obtener = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, $valor);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }
            $consulta = Cotizador::listar_cotizacion2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->fecha_cot;
                    $vector[1] = $val->fecha;
                    $vector[2] = $proveedor;
                    $vector[3] = date('d-m-Y');
                    $vector[4] = ($val->oferta == null ? '' : $val->oferta);
                    $vector[5] = ($val->tiempo == null ? '' : $val->tiempo);
                }
            }
            return $vector;
        }
    }

    public function recuperar_proveedor2()
    {
        $lista = Cotizador::listar_proveedor();
        $html = '';
        $id = $_POST['id'];
        $id_sol = $_POST['id_sol'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $cont = 1;
            $consulta = Cotizador::obtener_proveedor($id_sol, $usuario);
            $vector = array();
            if (count($consulta) > 0) {
                $i = 0;
                foreach ($consulta as $val2) {
                    $vector[$i] = $val2->idp;
                    $i++;
                }
            }
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id && $cont == 1) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                        $cont = 0;
                    }
                }

                foreach ($lista as $val) {
                    if (!in_array($val->id, $vector)) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }
            }

            return $html;
        }
    }

    public function editar_datos_cotizacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2e'];
            $fecha_cot = $_POST['fecha_cote'];
            $no_pedido = $_POST['no_pedidoe'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha) {
                $id_proveedor = $_POST['proveedore'];
                $oferta = $_POST['ofertae'];
                $tiempo = $_POST['tiempoe'];
                $id_solicitud = $_POST['id_solicitude'];
                $id_sol_det = $_POST['id_sol_dete'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cote'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['precioue'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumplee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cantidade'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[4][$i] = $val;
                    $i++;
                }

                for ($j = 0; $j < $i; $j++) {
                    $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                }

                $k = 0;
                $prov = Cotizador::obtener_proveedor($id_solicitud, $usuario);
                foreach ($prov as $val) {
                    $list2[$k] = $val->idp;
                    $k++;
                }

                $valor = 1;
                for ($j = 0; $j < $k; $j++) {
                    $actu = Cotizador::actualizar_estado_orden($id_solicitud, $list2[$j], $usuario, $valor);
                }

                for ($j = 0; $j < $i; $j++) {
                    $actualizar = Cotizador::actualizar_cotizacion($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo);
                }

                $k = 0;
                $prov = Cotizador::obtener_proveedor($id_solicitud, $usuario);
                foreach ($prov as $val) {
                    $list[$k] = $val->idp;
                    $k++;
                }

                $k = 0;
                for ($j = 0; $j < $i; $j++) {

                    $dat = Cotizador::recuperar_datos_cotizacion($id_solicitud, $dato[0][$j], $usuario);

                    if (count($dat) > 0) {
                        foreach ($dat as $val) {
                            $recu[0][$k] = $val->id;
                            $recu[1][$k] = $val->id_prov;
                            $recu[2][$k] = $val->id_sol;
                            $recu[3][$k] = $val->id_soldet;
                            $recu[4][$k] = $val->preciou;
                            $recu[5][$k] = $val->cantidad;
                            $recu[6][$k] = $val->id_art;
                            $k++;
                        }
                    }
                }

                $seleccionar = Cotizador::listar_todos_orden();
                if (empty($seleccionar)) {
                    $ban = 1;
                } else {
                    $ban = 0;
                }

                for ($m = 0; $m < $k; $m++) {
                    $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                    if (empty($verificar)) {
                        $insertar = Cotizador::insertar_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                        if ($insertar) {
                            if ($ban == 1) {
                                $ban = 0;
                                $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if (count($rec) > 0) {
                                    foreach ($rec as $val) {
                                        $id = $val->id;
                                    }
                                }
                                $dato[0] = 1;
                                $no_orden = self::zero_fill($dato[0], 5);
                                $act = Cotizador::actualizar_orden($no_orden, $id);

                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            } else {
                                $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if (count($rec) > 0) {
                                    foreach ($rec as $val) {
                                        $id = $val->id;
                                    }
                                }

                                $rec2 = Cotizador::recuperar_no_orden();
                                if (count($rec2) > 0) {
                                    foreach ($rec2 as $val) {
                                        $vector[0] = $val->no_orden;
                                    }
                                }

                                $vector[1] = (int)$vector[0];
                                $vector[1]++;
                                $dato[0] = $vector[1];

                                $no_orden = self::zero_fill($dato[0], 5);
                                $act = Cotizador::actualizar_orden($no_orden, $id);

                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        } else return 0;
                    } else {

                        foreach ($verificar as $val) {
                            $id = $val->id;
                        }

                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                        $act_orden = Cotizador::actualizar_total_orden($id);
                    }
                }

                return 1;
            } else return 0;
        }
    }

    public function listar_orden()
    {
        $vector = array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $no_pedido = self::zero_fill($no_pedido, 5);
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::ver_orden_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha_co = explode("-", $val->fecha_orden);
                    $fecha_cot = $fecha_co[2] . "/" . $fecha_co[1] . "/" . $fecha_co[0];
                    $consulta2 = Cotizador::datos_cotizacion_id($val->id_cot);
                    $tiempo = "";
                    foreach ($consulta2 as $val2) {
                        $tiempo = $val2->tiempo;
                    }
                    $vector[] = array(
                        "valor" => '18',
                        "val" => '',
                        "numero" => $bandera,
                        "fecha" => $fecha_cot,
                        "orden" => $val->orden,
                        "proveedor" => $val->proveedor,
                        "total" => $val->total,
                        "tiempo" => $tiempo,
                        "archivo" => ($val->archivo_cont != null ? $val->archivo_cont : "VACIO"),
                        "estado" => ($val->estado_orden == "A" ? "APROBADO" : "PENDIENTE"),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
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
            $consulta = Cotizador::ver_articulos_orden_cotizador($no_orden, $usuario);
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
            $consulta = Cotizador::ver_articulos_orden_cotizador($no_orden, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $ban = 0;
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_cotizacion_recepcion($val->id_solicitud, $usuario);
                        if (count($consulta2) > 0) {
                            foreach ($consulta2 as $val2) {
                                $vector[4] = $val2->fecha_cotizacion;
                                $vector[5] = date('d-m-Y');
                            }
                            $ban = 1;
                        }
                    }
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_prov_nacional_recepcion($val->id_solicitud, $usuario);
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

            $consulta = Cotizador::listar_orden_recepcion($no_orden, $usuario);
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

    public function cuadro_proveedor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, 1);
            $i = 0;
            if (count($obtener) > 0) {
                foreach ($obtener as $val) {
                    $proveedor[$i] = $val->id_prova;
                    $i++;
                }
            }
            $obtener = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, 2);
            if (count($obtener) > 0) {
                foreach ($obtener as $val) {
                    $proveedor[$i] = $val->id_prova;
                    $i++;
                }
            }
            $obtener = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, 3);
            if (count($obtener) > 0) {
                foreach ($obtener as $val) {
                    $proveedor[$i] = $val->id_prova;
                    $i++;
                }
            }

            $consulta = Cotizador::listar_cotizacion3($no_pedido, $proveedor[0], $id_solicitud, $usuario);
            $consulta2 = Cotizador::listar_cotizacion3($no_pedido, $proveedor[1], $id_solicitud, $usuario);
            $consulta3 = Cotizador::listar_cotizacion3($no_pedido, $proveedor[2], $id_solicitud, $usuario);
            if (count($consulta2) > 0) {
                $i = 0;
                foreach ($consulta2 as $val2) {
                    $dato[0][$i] = $val2->precio;
                    $dato[1][$i] = $val2->cumplimiento;
                    $i++;
                }
            }
            if (count($consulta3) > 0) {
                $i = 0;
                foreach ($consulta3 as $val3) {
                    $dato[2][$i] = $val3->precio;
                    $dato[3][$i] = $val3->cumplimiento;
                    $i++;
                }
            }
            if (count($consulta) > 0) {
                $j = 0;
                foreach ($consulta as $val) {
                    $precio2 = $dato[0][$j];
                    $cumple2 = $dato[1][$j];
                    $precio3 = $dato[2][$j];
                    $cumple3 = $dato[3][$j];
                    $j++;

                    $vector[] = array(
                        "valor" => '20',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio2" => $val->precio,
                        "cumple2" => $val->cumplimiento,
                        "precio" => $precio2,
                        "cumple" => $cumple2,
                        "precio3" => $precio3,
                        "cumple3" => $cumple3,
                        "no_pedi" => $val->no_pedido,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }

            return Datatables::of($vector)->toJson();
        }
    }

    public function cuadro_proveedor2()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $dato = array();
            $proveedor = array();
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener1 = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, 1);
            $obtener2 = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, 2);
            $obtener3 = Cotizador::obtener_datos_cotizacion($id_solicitud, $usuario, 3);
            $i = 0;
            if (count($obtener1) > 0) {
                foreach ($obtener1 as $val) {
                    $proveedor[$i] = $val->id_prova;
                    $i++;
                }
            }
            if (count($obtener2) > 0) {
                foreach ($obtener2 as $val) {
                    $proveedor[$i] = $val->id_prova;
                    $i++;
                }
            }
            if (count($obtener3) > 0) {
                foreach ($obtener3 as $val) {
                    $proveedor[$i] = $val->id_prova;
                    $i++;
                }
            }

            $consulta = Cotizador::listar_cotizacion3($no_pedido, $proveedor[0], $id_solicitud, $usuario);
            $consulta2 = Cotizador::listar_cotizacion3($no_pedido, $proveedor[1], $id_solicitud, $usuario);
            $consulta3 = Cotizador::listar_cotizacion3($no_pedido, $proveedor[2], $id_solicitud, $usuario);
            if (count($consulta2) > 0) {
                foreach ($consulta2 as $val2) {
                    $dato[0] = $val2->proveedor;
                }
            }
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $dato[1] = $val->proveedor;
                }
            }
            if (count($consulta3) > 0) {
                foreach ($consulta3 as $val3) {
                    $dato[2] = $val3->proveedor;
                }
            }

            return $dato;
        }
    }

    public function recepcion_orden()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.recepcion.recepcion');
        }
    }

    public function listar_todo_orden()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_todo_orden($usuario);
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
                $consulta = Cotizador::listar_todo_orden($usuario);
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
                $consulta = Cotizador::listar_todo_orden($usuario);
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
                $consulta = Cotizador::listar_todo_orden($usuario);
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

            $consulta = Cotizador::ver_articulos_orden_cotizador($no_orden, $usuario);
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

    public function editar_datos_recepcion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $factura = $_POST['facturae'];
            $fecha_fac = $_POST['fecha_face'];
            $recepcion = $_POST['recepcion'];
            $actualizar = Cotizador::actualizar_datos_recepcion($factura, $fecha_fac, $recepcion);
            if ($actualizar) return 1;
            else return 0;
        }
    }

    public function ver_imprimir_solicitud_cotizacion()
    {
        $usuario = session('id');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['no_pedido'];
            $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Apedido_cotizacion.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=" . $no_pedido . "&usuarioe=" . $usuario;
            return $html;
        }
    }

    public function ver_imprimir_cuadro()
    {
        $usuario = session('id');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['pedido'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $no_orden = $_POST['solic'];
            $no_orden = self::zero_fill($no_orden, 5);
            $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Acuadro_comparacion.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&pedidoe=" . $no_pedido . "&usuarioe=" . $usuario . "&solicitude=" . $no_orden;
            return $html;
        }
    }

    public function ver_imprimir_orden()
    {
        $usuario = session('id');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['pedido'];
            $valor = $_POST['valor'];
            $valor--;
            $no_pedido = self::zero_fill($no_pedido, 5);
            $consulta = Cotizador::orden_cotizador_valor($no_pedido, $usuario, $valor);
            if (!empty($consulta)) {
                foreach ($consulta as $val) {
                    $no_orden = $val->no_orden;
                }
                $consulta2 = Cotizador::verificar_contrato_orden($no_orden);
                foreach ($consulta2 as $val2) {
                    $no_contrato = ($val2->no_cont == null ? "VACIO" : $val2->no_cont);
                    $archivo = $val2->archivo;
                }
                if ($no_contrato == "VACIO") {
                    $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Aorden_compra.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=" . $no_pedido . "&usuarioe=" . $usuario . "&no_ordene=" . $no_orden;
                    return $html;
                } else {
                    $html = $archivo;
                    return $html;
                }
            }
            return $html;
        }
    }

    public function ver_imprimir_orden2()
    {
        $usuario = session('id');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['pedido'];
            $valor = $_POST['valor'];
            $valor--;
            $no_pedido = self::zero_fill($no_pedido, 5);
            $consulta = Cotizador::contrato_cotizador_valor($no_pedido, $usuario, $valor);
            if (!empty($consulta)) {
                foreach ($consulta as $val) {
                    $archivo = $val->documento;
                }
                $html = $archivo;
                return $html;
            }
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
                $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Anota_recepcion.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&usuarioe=" . $usuario . "&no_ordene=" . $no_orden;
            } else {
                $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Anota_recepcion_contrato.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&usuarioe=" . $usuario . "&no_ordene=" . $no_orden;
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
            $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Anota_recepcion_contrato_lic_exc.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&usuarioe=" . $usuario . "&no_ordene=" . $no_orden;
            return $html;
        }
    }

    public function recuperar_modalidad()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Cotizador::listar_modalidad();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Modalidad' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function mostrar_modalidad()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = $_POST['id'];
            $lista = Cotizador::listar_modalidad();
            $html = '';
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }

                foreach ($lista as $val) {
                    if ($val->id != $id) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }
            }
            return $html;
        }
    }


    public function proveedor_anpe()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.modalidad.anpe');
        }
    }

    public function lista_pedido_anpe()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_pendientes_cotizador3($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $esta2 = array();
                    $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                    $i = 0;
                    $c3 = 0;
                    if (count($consulta9) > 0) {
                        foreach ($consulta9 as $val9) {
                            $esta2[$i] = $val9->estado;
                            $i++;
                        }
                    } else $esta2[0] = "P";
                    if (in_array("A", $esta2)) {
                        $c3 = 1;
                    }

                    $esta4 = array();
                    $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                    $i = 0;
                    if (count($consulta10) > 0) {
                        foreach ($consulta10 as $val10) {
                            $esta4[$i] = $val10->estado;
                            $i++;
                        }
                    } else $esta4[0] = "P";
                    if (in_array("A", $esta4)) {
                        $c3 = 2;
                    }

                    $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                    $i = 0;
                    $esta = array();
                    if (count($consulta7) > 0) {
                        foreach ($consulta7 as $val7) {
                            $esta[$i] = $val7->estado;
                            $i++;
                        }
                    } else $esta[0] = "P";
                    if (in_array("A", $esta)) {
                        $est = "APROBADO";
                    } else {
                        $est = "PENDIENTE";
                    }

                    $esta5 = array();
                    $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                    $i = 0;
                    if (count($consulta7) > 0) {
                        foreach ($consulta7 as $val7) {
                            $esta5[$i] = $val7->estado;
                            $i++;
                        }
                    } else $esta5[0] = "P";
                    if (in_array("A", $esta5)) {
                        $c3 = 3;
                    }

                    $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                    foreach ($consulta5 as $val5) {
                        $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                        $solicitud = $val5->id_solicitud;
                        foreach ($consulta6 as $val6) {
                            $cant = $val6->cantidad_prov_nacional;
                        }

                        $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                        if (count($consulta8) > 0) {
                            foreach ($consulta8 as $val8) {
                                $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                            }
                        } else $archivo_prov = "VACIO";
                    }

                    if ($cant == 1) $c2 = 1;
                    else $c2 = 0;

                    if ($cant < 1) {
                        $valores = array();
                        $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                        if (empty($valores)) {
                            $valores[5] = "";
                            $valores[6] = "";
                            $valores[7] = "";
                            $valores[8] = "";
                        }
                        $vector[] = array(
                            "valor" => '24',
                            "val" => $c2 . "/" . $val->no_pedido,
                            "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "cantidad" => $cant,
                            "id_solicitud" => $solicitud,
                            "est_gen" => $est,
                            "archivo" => $archivo_prov,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_articulo_anpe()
    {
        $vector = array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Cotizador::listar_prov_nacional($val->id_solicitud, $val->ide, $usuario);
                    if (count($consulta2) > 0) {
                        foreach ($consulta2 as $val2) {
                            $fecha = $val2->fechaa;
                            $id_cot = $val2->ida;
                            $fecha2 = $val2->fech;
                        }
                        $vector[] = array(
                            "valor" => '25',
                            "val" => '',
                            "numero" => $bandera,
                            "id" => $val->ide,
                            "unidad" => $val->unidad_solicitante,
                            "id_articulo" => $val->id_articulo,
                            "articulo" => $val->articulo . " - " . $val->descripcion,
                            "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                            "no_solicitud" => $val->no_solicitud,
                            "id_solicitud" => $val->id_solicitud,
                            "cantidad" => $val->cant_aprob,
                            "unidad" => $val->unidad,
                            "id_cot" => $id_cot,
                            "fecha" => $fecha,
                            "fecha2" => $fecha2,
                            "no_pedi" => $val->no_pedido,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_articulo_anpe2()
    {
        date_default_timezone_set("America/La_Paz");
        $vector = array();
        $no_pedido = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_articulos_pendientes_cotizador($no_pedido, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Cotizador::listar_prov_nacional($val->id_solicitud, $val->ide, $usuario);
                    foreach ($consulta2 as $val2) {
                        $vector[0] = $val2->ida;
                        $vector[1] = $val2->fechaa;
                        $vector[2] = $val2->fech;
                        $vector[3] = date('d-m-Y');
                        $vector[5] = $val2->id_sola;
                    }
                }
            }
            return $vector;
        }
    }

    public function guardar_datos_anpe()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2'];
            $fecha_cot = $_POST['fecha_cot'];
            $no_pedido = $_POST['no_pedido'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha) {
                $fechaA = date('Ymd');
                $fechaB = date('His');
                $cadena_nom = $fechaA . $fechaB . $usuario;
                $archivo = "";
                if ($_FILES) {
                    foreach ($_FILES as $file) {
                        if ($file["error"] == UPLOAD_ERR_OK) {
                            move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                            $nombre_rb = "recursos/doc_prov/";
                            $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                        }
                    }
                }

                $id_proveedor = $_POST['proveedor'];
                $oferta = $_POST['oferta'];
                $tiempo = $_POST['tiempo'];
                $id_solicitud = $_POST['id_solicitud'];
                $id_sol_det = $_POST['id_sol_det'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cot'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['preciou'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumple'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cantidad'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[4][$i] = $val;
                    $i++;
                }

                for ($j = 0; $j < $i; $j++) {
                    $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                }


                for ($j = 0; $j < $i; $j++) {
                    $actualizar = Cotizador::actualizar_prov_nacional2($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo, $archivo);
                }

                return 1;
            } else return 0;
        }
    }

    public function editar_anpe()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }

            $consulta = Cotizador::listar_prov_nacional2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '26',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio" => $val->precio * $val->cant_aprob,
                        "no_pedi" => $val->no_pedido,
                        "cumple" => $val->cumplimiento,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function editar_anpe2()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $no_pedido = $_POST['no'];
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }
            $consulta = Cotizador::listar_prov_nacional2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->fecha_cot;
                    $vector[1] = $val->fecha;
                    $vector[2] = $proveedor;
                    $vector[3] = date('d-m-Y');
                    $vector[4] = ($val->oferta == null ? '' : $val->oferta);
                    $vector[5] = ($val->tiempo == null ? '' : $val->tiempo);
                }
            }
            return $vector;
        }
    }

    public function editar_datos_anpe()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2e'];
            $fecha_cot = $_POST['fecha_cote'];
            $no_pedido = $_POST['no_pedidoe'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];


            if ($fecha_cot >= $fecha) {
                $fechaA = date('Ymd');
                $fechaB = date('His');
                $cadena_nom = $fechaA . $fechaB . $usuario;
                $archivo = "";
                if ($_FILES) {
                    foreach ($_FILES as $file) {
                        if ($file["error"] == UPLOAD_ERR_OK) {
                            move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                            $nombre_rb = "recursos/doc_prov/";
                            $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                        }
                    }
                }
                $id_proveedor = $_POST['proveedore'];
                $oferta = $_POST['ofertae'];
                $tiempo = $_POST['tiempoe'];
                $id_solicitud = $_POST['id_solicitude'];
                $id_sol_det = $_POST['id_sol_dete'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cote'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['precioue'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumplee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cantidade'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[4][$i] = $val;
                    $i++;
                }

                for ($j = 0; $j < $i; $j++) {
                    $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                }

                for ($j = 0; $j < $i; $j++) {
                    $actualizar = Cotizador::actualizar_prov_nacional2($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo, $archivo);
                }

                return 1;
            } else return 0;
        }
    }

    public function editar_anpe_orden()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional_orden($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }

            $consulta = Cotizador::listar_prov_nacional2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '26',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio" => $val->precio * $val->cant_aprob,
                        "no_pedi" => $val->no_pedido,
                        "cumple" => $val->cumplimiento,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function editar_anpe_orden2()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional_orden($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }
            $consulta = Cotizador::listar_prov_nacional2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->fecha_cot;
                    $vector[1] = $val->fecha;
                    $vector[2] = $proveedor;
                    $vector[3] = date('d-m-Y');
                    $vector[4] = ($val->oferta == null ? '' : $val->oferta);
                    $vector[5] = ($val->tiempo == null ? '' : $val->tiempo);
                }

                $consulta2 = Cotizador::buscar_proveedor($vector[2]);
                foreach ($consulta2 as $val2) {
                    $vector[6] = $val2->descrip_g;
                }
                $vector[7] = 0;

                $consulta3 = Cotizador::monto_total_prov_nacional($proveedor, $id_solicitud, $usuario);
                foreach ($consulta3 as $val3) {
                    $vector[7] += $val3->suma;
                }
            }
            return $vector;
        }
    }

    public function guardar_datos_anpe_orden()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2e'];
            $fecha_cot = $_POST['fecha_cote2'];
            $no_pedido = $_POST['no_pedidoe'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha) {

                $id_proveedor = $_POST['proveedore2'];
                $id_proveedor2 = $_POST['id_prov'];
                $oferta = $_POST['ofertae2'];
                $tiempo = $_POST['tiempoe2'];
                $id_solicitud = $_POST['id_solicitude'];
                $id_sol_det = $_POST['id_sol_dete'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cote'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['precioue'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumplee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cantidade'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[4][$i] = $val;
                    $i++;
                }

                for ($j = 0; $j < $i; $j++) {
                    $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                }

                if ($id_proveedor == $id_proveedor2) {
                    $fechaA = date('Ymd');
                    $fechaB = date('His');
                    $cadena_nom = $fechaA . $fechaB . $usuario;
                    $archivo = "";
                    if ($_FILES) {
                        foreach ($_FILES as $file) {
                            if ($file["error"] == UPLOAD_ERR_OK) {
                                move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                                $nombre_rb = "recursos/doc_prov/";
                                $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                            }
                        }
                    }

                    if ($archivo == "") {
                        for ($j = 0; $j < $i; $j++) {
                            $actualizar = Cotizador::actualizar_prov_nacional($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo);
                        }
                    } else {
                        for ($j = 0; $j < $i; $j++) {
                            $actualizar = Cotizador::actualizar_prov_nacional2($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo, $archivo);
                        }
                    }

                    $k = 0;
                    for ($j = 0; $j < $i; $j++) {
                        $dat = Cotizador::recuperar_datos_prov_nacional($id_solicitud, $dato[0][$j], $usuario);

                        if (count($dat) > 0) {
                            foreach ($dat as $val) {
                                $recu[0][$k] = $val->id;
                                $recu[1][$k] = $val->id_prov;
                                $recu[2][$k] = $val->id_sol;
                                $recu[3][$k] = $val->id_soldet;
                                $recu[4][$k] = $val->preciou;
                                $recu[5][$k] = $val->cantidad;
                                $recu[6][$k] = $val->id_art;
                                $k++;
                            }
                        }
                    }

                    $seleccionar = Cotizador::listar_todos_orden();
                    if (empty($seleccionar)) {
                        $ban = 1;
                    } else {
                        $ban = 0;
                    }

                    for ($m = 0; $m < $k; $m++) {
                        $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recu[0][$m], "A");
                    }

                    for ($m = 0; $m < $k; $m++) {
                        $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                        if (empty($verificar)) {
                            $insertar = Cotizador::insertar_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                            if ($insertar) {
                                if ($ban == 1) {
                                    $ban = 0;
                                    $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                    if (count($rec) > 0) {
                                        foreach ($rec as $val) {
                                            $id = $val->id;
                                        }
                                    }
                                    $dato[0] = 1;
                                    $no_orden = self::zero_fill($dato[0], 5);
                                    $act = Cotizador::actualizar_orden($no_orden, $id);

                                    $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                    $act_orden = Cotizador::actualizar_total_orden($id);
                                } else {
                                    $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                    if (count($rec) > 0) {
                                        foreach ($rec as $val) {
                                            $id = $val->id;
                                        }
                                    }

                                    $rec2 = Cotizador::recuperar_no_orden();
                                    if (count($rec2) > 0) {
                                        foreach ($rec2 as $val) {
                                            $vector[0] = $val->no_orden;
                                        }
                                    }

                                    $vector[1] = (int)$vector[0];
                                    $vector[1]++;
                                    $dato[0] = $vector[1];

                                    $no_orden = self::zero_fill($dato[0], 5);
                                    $act = Cotizador::actualizar_orden($no_orden, $id);

                                    $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                    $act_orden = Cotizador::actualizar_total_orden($id);
                                }
                            } else return 0;
                        } else {
                            foreach ($verificar as $val) {
                                $id = $val->id;
                            }

                            $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                            $act_orden = Cotizador::actualizar_total_orden($id);
                        }
                    }
                    return 4;
                }
                if ($id_proveedor != $id_proveedor2) {
                    $fechaA = date('Ymd');
                    $fechaB = date('His');
                    $cadena_nom = $fechaA . $fechaB . $usuario;
                    $archivo = "";
                    if ($_FILES) {
                        foreach ($_FILES as $file) {
                            if ($file["error"] == UPLOAD_ERR_OK) {
                                move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                                $nombre_rb = "recursos/doc_prov/";
                                $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                            }
                        }
                    }

                    if ($archivo == "") return 3;

                    $recu = array();
                    $k = 0;
                    $val_recu = 0;
                    for ($j = 0; $j < $i; $j++) {
                        $dat = Cotizador::recuperar_datos_prov_nacional($id_solicitud, $dato[0][$j], $usuario);
                        if (count($dat) > 0) {
                            foreach ($dat as $val) {
                                $recupe[0][$k] = $val->id;
                                $recu[0][$k] = $val->id;
                                $recu[1][$k] = $val->id_prov;
                                $recu[2][$k] = $val->id_sol;
                                $recu[3][$k] = $val->id_soldet;
                                $recu[4][$k] = $val->preciou;
                                $recu[5][$k] = $val->cantidad;
                                $recu[6][$k] = $val->id_art;
                                $k++;
                            }
                        }
                        $val_recu = 1;
                    }

                    if ($val_recu == 1) {
                        $val_act = 0;
                        for ($e = 0; $e < $k; $e++) {
                            $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recupe[0][$e], "R");
                            $val_act = 1;
                        }

                        if ($val_act == 1) {
                            $val_ins = 0;
                            for ($m = 0; $m < $k; $m++) {
                                $insertar_pn = Cotizador::insertar_prov_nacional($recu[2][$m], $recu[3][$m], $recu[6][$m], $usuario);
                                $val_ins = 1;
                            }

                            if ($val_ins == 1) {
                                $k = 0;
                                $recue = array();
                                $val_recue = 0;
                                for ($j = 0; $j < $i; $j++) {
                                    $dat = Cotizador::recuperar_datos_prov_nacional2($id_solicitud, $dato[0][$j], $usuario);

                                    if (count($dat) > 0) {
                                        foreach ($dat as $val) {
                                            $recue[0][$k] = $val->id;
                                            $k++;
                                        }
                                        $val_recue = 1;
                                    }
                                }

                                if ($val_recue == 1) {
                                    $val_act = 0;
                                    for ($u = 0; $u < $k; $u++) {
                                        $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recue[0][$u], "A");
                                        $val_act = 1;
                                    }

                                    if ($val_act) {
                                        $val_act2 = 0;
                                        for ($j = 0; $j < $i; $j++) {
                                            $actualizar_pn = Cotizador::actualizar_prov_nacional2($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $recue[0][$j], $oferta, $tiempo, $archivo);
                                            $val_act2 = 1;
                                        }
                                    } else return 0;
                                } else return 0;
                            } else return 0;
                        } else return 0;
                    } else return 0;

                    if ($val_act2 == 1) {

                        $k = 0;
                        $recues = array();
                        for ($j = 0; $j < $i; $j++) {
                            $dat = Cotizador::recuperar_datos_prov_nacional3($id_solicitud, $dato[0][$j], $usuario);

                            if (count($dat) > 0) {
                                foreach ($dat as $val) {
                                    $recues[0][$k] = $val->id;
                                    $recues[1][$k] = $val->id_prov;
                                    $recues[2][$k] = $val->id_sol;
                                    $recues[3][$k] = $val->id_soldet;
                                    $recues[4][$k] = $val->preciou;
                                    $recues[5][$k] = $val->cantidad;
                                    $recues[6][$k] = $val->id_art;
                                    $k++;
                                }
                            }
                        }

                        $seleccionar = Cotizador::listar_todos_orden();
                        if (empty($seleccionar)) {
                            $ban = 1;
                        } else {
                            $ban = 0;
                        }

                        for ($m = 0; $m < $k; $m++) {
                            $verificar = Cotizador::verificar_orden($recues[2][$m], $recues[1][$m], $usuario);
                            if (empty($verificar)) {
                                $insertar = Cotizador::insertar_orden($recues[2][$m], $recues[1][$m], $recues[0][$m], $usuario);
                                if ($insertar) {
                                    if ($ban == 1) {
                                        $ban = 0;
                                        $rec = Cotizador::recuperar_ultima_orden($recues[2][$m], $recues[1][$m], $recues[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }
                                        $dato[0] = 1;
                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recues[3][$m], $recues[5][$m], $recues[4][$m], $recues[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    } else {
                                        $rec = Cotizador::recuperar_ultima_orden($recues[2][$m], $recues[1][$m], $recues[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }

                                        $rec2 = Cotizador::recuperar_no_orden();
                                        if (count($rec2) > 0) {
                                            foreach ($rec2 as $val) {
                                                $vector[0] = $val->no_orden;
                                            }
                                        }

                                        $vector[1] = (int)$vector[0];
                                        $vector[1]++;
                                        $dato[0] = $vector[1];

                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recues[3][$m], $recues[5][$m], $recues[4][$m], $recues[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    }
                                } else return 0;
                            } else {
                                foreach ($verificar as $val) {
                                    $id = $val->id;
                                }

                                $insertar2 = Cotizador::insertar_orden_det($id, $recues[3][$m], $recues[5][$m], $recues[4][$m], $recues[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        }

                        return 4;
                    } else return 0;
                }
            } else return 0;
        }
    }

    public function recuperar_proveedor_anpe()
    {
        $lista = Cotizador::listar_proveedor();
        $html = '';
        $id = $_POST['id'];
        $usuario = session('id');
        if (!empty($usuario)) {
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }

                foreach ($lista as $val) {
                    if ($val->id != $id) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }
            }

            return $html;
        }
    }

    public function recuperar_proveedor_anpe2()
    {
        $lista = Cotizador::listar_proveedor();
        $html = '';
        $usuario = session('id');
        if (!empty($usuario)) {
            $html .= "<option value='' disabled selected>" . 'Seleccionar Proveedor' . "</option>";
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }

            return $html;
        }
    }

    public function modificar_anpe_orden()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional2($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }

            $consulta = Cotizador::listar_prov_nacional_orden($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '27',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio" => $val->precio * $val->cant_aprob,
                        "no_pedi" => $val->no_pedido,
                        "cumple" => $val->cumplimiento,
                        "id_ord" => $val->id_orden,
                        "no_ord" => $val->no_ord,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function modificar_anpe_orden2()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional2($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }
            $consulta = Cotizador::listar_prov_nacional_orden($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->fecha_cot;
                    $vector[1] = $val->fecha;
                    $vector[2] = $proveedor;
                    $vector[3] = date('d-m-Y');
                    $vector[4] = ($val->oferta == null ? '' : $val->oferta);
                    $vector[5] = ($val->tiempo == null ? '' : $val->tiempo);
                    $vector[6] = $val->no_ord;
                    $vector[7] = $val->fecha_cont_orden;
                    $vector[8] = $val->no_cont_orden;
                }

                $consulta2 = Cotizador::buscar_proveedor($vector[2]);
                foreach ($consulta2 as $val2) {
                    $vector[9] = $val2->descrip_g;
                }

                $vector[10] = 0;

                $consulta3 = Cotizador::monto_total_prov_nacional($proveedor, $id_solicitud, $usuario);
                foreach ($consulta3 as $val3) {
                    $vector[10] += $val3->suma;
                }
            }
            return $vector;
        }
    }

    public function editar_datos_anpe_orden()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2e'];
            $fecha_cot = $_POST['fecha_cote2o'];
            $no_pedido = $_POST['no_pedidoe'];
            $id_orden = $_POST['id_ordene'];
            $no_orden = $_POST['no_ordene'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha) {

                $id_proveedor = $_POST['proveedore2o'];
                $id_proveedor2 = $_POST['id_provo'];
                $oferta = $_POST['ofertae2o'];
                $tiempo = $_POST['tiempoe2o'];
                $id_solicitud = $_POST['id_solicitude'];
                $id_sol_det = $_POST['id_sol_dete'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cote'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['precioue'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumplee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cantidadee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[4][$i] = $val;
                    $i++;
                }

                for ($j = 0; $j < $i; $j++) {
                    $dato[2][$j] = round($dato[2][$j] / $dato[4][$j], 2);
                }

                if ($id_proveedor == $id_proveedor2) {
                    $actualizar = Cotizador::actualizar_estado_orden2($id_orden, $no_orden, $usuario);
                    $fechaA = date('Ymd');
                    $fechaB = date('His');
                    $cadena_nom = $fechaA . $fechaB . $usuario;
                    $archivo = "";
                    if ($_FILES) {
                        foreach ($_FILES as $file) {
                            if ($file["error"] == UPLOAD_ERR_OK) {
                                move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                                $nombre_rb = "recursos/doc_prov/";
                                $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                            }
                        }
                    }

                    if ($archivo == "") {
                        for ($j = 0; $j < $i; $j++) {
                            $actualizar = Cotizador::actualizar_prov_nacional($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo);
                        }
                    } else {
                        for ($j = 0; $j < $i; $j++) {
                            $actualizar = Cotizador::actualizar_prov_nacional2($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $dato[1][$j], $oferta, $tiempo, $archivo);
                        }
                    }

                    $k = 0;
                    $recu = array();
                    for ($j = 0; $j < $i; $j++) {
                        $dat = Cotizador::recuperar_datos_prov_nacional4($id_solicitud, $dato[0][$j], $usuario);

                        if (count($dat) > 0) {
                            foreach ($dat as $val) {
                                $recu[0][$k] = $val->id;
                                $recu[1][$k] = $val->id_prov;
                                $recu[2][$k] = $val->id_sol;
                                $recu[3][$k] = $val->id_soldet;
                                $recu[4][$k] = $val->preciou;
                                $recu[5][$k] = $val->cantidad;
                                $recu[6][$k] = $val->id_art;
                                $k++;
                            }
                        }
                    }

                    $seleccionar = Cotizador::listar_todos_orden();
                    if (empty($seleccionar)) {
                        $ban = 1;
                    } else {
                        $ban = 0;
                    }

                    for ($m = 0; $m < $k; $m++) {
                        $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recu[0][$m], "A");
                    }

                    for ($m = 0; $m < $k; $m++) {
                        $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                        if (empty($verificar)) {
                            $insertar = Cotizador::insertar_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                            if ($insertar) {
                                if ($ban == 1) {
                                    $ban = 0;
                                    $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                    if (count($rec) > 0) {
                                        foreach ($rec as $val) {
                                            $id = $val->id;
                                        }
                                    }
                                    $dato[0] = 1;
                                    $no_orden = self::zero_fill($dato[0], 5);
                                    $act = Cotizador::actualizar_orden($no_orden, $id);

                                    $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                    $act_orden = Cotizador::actualizar_total_orden($id);
                                } else {
                                    $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                    if (count($rec) > 0) {
                                        foreach ($rec as $val) {
                                            $id = $val->id;
                                        }
                                    }

                                    $rec2 = Cotizador::recuperar_no_orden();
                                    if (count($rec2) > 0) {
                                        foreach ($rec2 as $val) {
                                            $vector[0] = $val->no_orden;
                                        }
                                    }

                                    $vector[1] = (int)$vector[0];
                                    $vector[1]++;
                                    $dato[0] = $vector[1];

                                    $no_orden = self::zero_fill($dato[0], 5);
                                    $act = Cotizador::actualizar_orden($no_orden, $id);

                                    $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                    $act_orden = Cotizador::actualizar_total_orden($id);
                                }
                            } else return 0;
                        } else {
                            foreach ($verificar as $val) {
                                $id = $val->id;
                            }

                            $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                            $act_orden = Cotizador::actualizar_total_orden($id);
                        }
                    }
                    return 4;
                }
                if ($id_proveedor != $id_proveedor2) {
                    $fechaA = date('Ymd');
                    $fechaB = date('His');
                    $cadena_nom = $fechaA . $fechaB . $usuario;
                    $archivo = "";
                    if ($_FILES) {
                        foreach ($_FILES as $file) {
                            if ($file["error"] == UPLOAD_ERR_OK) {
                                move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                                $nombre_rb = "recursos/doc_prov/";
                                $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                            }
                        }
                    }

                    if ($archivo == "") return 3;

                    $actualizar = Cotizador::actualizar_estado_orden2($id_orden, $no_orden, $usuario);
                    $recupe = array();
                    $recu = array();
                    $k = 0;
                    $val_recu = 0;
                    for ($j = 0; $j < $i; $j++) {
                        $dat = Cotizador::recuperar_datos_prov_nacional3($id_solicitud, $dato[0][$j], $usuario);
                        if (count($dat) > 0) {
                            foreach ($dat as $val) {
                                $recupe[0][$k] = $val->id;
                                $recu[0][$k] = $val->id;
                                $recu[1][$k] = $val->id_prov;
                                $recu[2][$k] = $val->id_sol;
                                $recu[3][$k] = $val->id_soldet;
                                $recu[4][$k] = $val->preciou;
                                $recu[5][$k] = $val->cantidad;
                                $recu[6][$k] = $val->id_art;
                                $k++;
                            }
                        }
                        $val_recu = 1;
                    }

                    if ($val_recu == 1) {
                        $val_act = 0;
                        for ($e = 0; $e < $k; $e++) {
                            $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recupe[0][$e], "R");
                            $val_act = 1;
                        }

                        if ($val_act == 1) {
                            $val_ins = 0;
                            for ($m = 0; $m < $k; $m++) {
                                $insertar_pn = Cotizador::insertar_prov_nacional($recu[2][$m], $recu[3][$m], $recu[6][$m], $usuario);
                                $val_ins = 1;
                            }

                            if ($val_ins == 1) {
                                $k = 0;
                                $recue = array();
                                $val_recue = 0;
                                for ($j = 0; $j < $i; $j++) {
                                    $dat = Cotizador::recuperar_datos_prov_nacional2($id_solicitud, $dato[0][$j], $usuario);

                                    if (count($dat) > 0) {
                                        foreach ($dat as $val) {
                                            $recue[0][$k] = $val->id;
                                            $k++;
                                        }
                                        $val_recue = 1;
                                    }
                                }

                                if ($val_recue == 1) {
                                    $val_act = 0;
                                    for ($u = 0; $u < $k; $u++) {
                                        $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recue[0][$u], "A");
                                        $val_act = 1;
                                    }

                                    if ($val_act) {
                                        $val_act2 = 0;
                                        for ($j = 0; $j < $i; $j++) {
                                            $actualizar_pn = Cotizador::actualizar_prov_nacional2($fecha_cot, $id_proveedor, $dato[2][$j], $dato[3][$j], $recue[0][$j], $oferta, $tiempo, $archivo);
                                            $val_act2 = 1;
                                        }
                                    } else return 0;
                                } else return 0;
                            } else return 0;
                        } else return 0;
                    } else return 0;

                    if ($val_act2 == 1) {

                        $k = 0;
                        $recues = array();
                        for ($j = 0; $j < $i; $j++) {
                            $dat = Cotizador::recuperar_datos_prov_nacional3($id_solicitud, $dato[0][$j], $usuario);

                            if (count($dat) > 0) {
                                foreach ($dat as $val) {
                                    $recues[0][$k] = $val->id;
                                    $recues[1][$k] = $val->id_prov;
                                    $recues[2][$k] = $val->id_sol;
                                    $recues[3][$k] = $val->id_soldet;
                                    $recues[4][$k] = $val->preciou;
                                    $recues[5][$k] = $val->cantidad;
                                    $recues[6][$k] = $val->id_art;
                                    $k++;
                                }
                            }
                        }

                        $seleccionar = Cotizador::listar_todos_orden();
                        if (empty($seleccionar)) {
                            $ban = 1;
                        } else {
                            $ban = 0;
                        }

                        for ($m = 0; $m < $k; $m++) {
                            $verificar = Cotizador::verificar_orden($recues[2][$m], $recues[1][$m], $usuario);
                            if (empty($verificar)) {
                                $insertar = Cotizador::insertar_orden($recues[2][$m], $recues[1][$m], $recues[0][$m], $usuario);
                                if ($insertar) {
                                    if ($ban == 1) {
                                        $ban = 0;
                                        $rec = Cotizador::recuperar_ultima_orden($recues[2][$m], $recues[1][$m], $recues[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }
                                        $dato[0] = 1;
                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recues[3][$m], $recues[5][$m], $recues[4][$m], $recues[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    } else {
                                        $rec = Cotizador::recuperar_ultima_orden($recues[2][$m], $recues[1][$m], $recues[0][$m], $usuario);
                                        if (count($rec) > 0) {
                                            foreach ($rec as $val) {
                                                $id = $val->id;
                                            }
                                        }

                                        $rec2 = Cotizador::recuperar_no_orden();
                                        if (count($rec2) > 0) {
                                            foreach ($rec2 as $val) {
                                                $vector[0] = $val->no_orden;
                                            }
                                        }

                                        $vector[1] = (int)$vector[0];
                                        $vector[1]++;
                                        $dato[0] = $vector[1];

                                        $no_orden = self::zero_fill($dato[0], 5);
                                        $act = Cotizador::actualizar_orden($no_orden, $id);

                                        $insertar2 = Cotizador::insertar_orden_det($id, $recues[3][$m], $recues[5][$m], $recues[4][$m], $recues[6][$m]);

                                        $act_orden = Cotizador::actualizar_total_orden($id);
                                    }
                                } else return 0;
                            } else {
                                foreach ($verificar as $val) {
                                    $id = $val->id;
                                }

                                $insertar2 = Cotizador::insertar_orden_det($id, $recues[3][$m], $recues[5][$m], $recues[4][$m], $recues[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        }

                        return 4;
                    } else return 0;
                }
            } else return 0;
        }
    }

    public function lista_pedido_anpe_valor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador3($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;

                        if ($cant < 1) {
                            $valores = array();
                            $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                            if (empty($valores)) {
                                $valores[5] = "";
                                $valores[6] = "";
                                $valores[7] = "";
                                $valores[8] = "";
                            }
                            $vector[] = array(
                                "valor" => '24',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "est_gen" => $est,
                                "archivo" => $archivo_prov,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador3($usuario);

                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;

                        if ($cant == 1) {
                            $valores = array();
                            $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                            if (empty($valores)) {
                                $valores[5] = "";
                                $valores[6] = "";
                                $valores[7] = "";
                                $valores[8] = "";
                            }
                            $vector[] = array(
                                "valor" => '24',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "est_gen" => $est,
                                "archivo" => $archivo_prov,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador3($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;
                        $valores = array();
                        $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                        if (empty($valores)) {
                            $valores[5] = "";
                            $valores[6] = "";
                            $valores[7] = "";
                            $valores[8] = "";
                        }
                        $vector[] = array(
                            "valor" => '24',
                            "val" => $c2 . "/" . $val->no_pedido,
                            "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "cantidad" => $cant,
                            "id_solicitud" => $solicitud,
                            "est_gen" => $est,
                            "archivo" => $archivo_prov,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function insertar_proveedor2()
    {
        $nombre = strtoupper($_POST['provg']);
        $nombre_comercial = strtoupper($_POST['provc']);
        $nit = strtoupper($_POST['provn']);
        $usuario = session('usuario');


        if (!empty($usuario)) {
            if ($nombre != '' || $nombre_comercial != '' || $nit != '') {
                $verificar = Cotizador::verificar_proveedor($nombre, $nombre_comercial);
                if (empty($verificar)) {
                    $insertar = Cotizador::insertar_proveedor($nombre, $nombre_comercial, $nit);
                    if ($insertar) {
                        return 1;
                    } else return 0;
                } else return 2;
            } else return 3;
        } else return 0;
    }

    public function insertar_proveedor()
    {
        $nombre = strtoupper($_POST['provg2']);
        $nombre_comercial = strtoupper($_POST['provc2']);
        $nit = strtoupper($_POST['provn2']);
        $usuario = session('usuario');


        if (!empty($usuario)) {
            if ($nombre != '' || $nombre_comercial != '' || $nit != '') {
                $verificar = Cotizador::verificar_proveedor($nombre, $nombre_comercial);
                if (empty($verificar)) {
                    $insertar = Cotizador::insertar_proveedor($nombre, $nombre_comercial, $nit);
                    if ($insertar) {
                        return 1;
                    } else return 0;
                } else return 2;
            } else return 3;
        } else return 0;
    }

    public function recuperar_proveedor_valor()
    {
        $lista = Cotizador::listar_proveedor();
        $html = '';
        $id = $_POST['id'];
        $usuario = session('id');
        if (!empty($usuario)) {
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }
                foreach ($lista as $val) {
                    if ($val->id != $id) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }
            }

            return $html;
        }
    }

    public function finalizar_recepcion()
    {
        $no_orden = $_POST['ordenf'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $finalizar = Cotizador::finalizar_recepcion($no_orden, $usuario);
            if ($finalizar) {
                return 1;
            } else return 0;
        }
    }


    public function proveedor_licitacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.modalidad.licitacion');
        }
    }

    public function lista_pedido_licitacion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_pendientes_cotizador4($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $esta2 = array();
                    $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                    $i = 0;
                    $c3 = 0;
                    if (count($consulta9) > 0) {
                        foreach ($consulta9 as $val9) {
                            $esta2[$i] = $val9->estado;
                            $i++;
                        }
                    } else $esta2[0] = "P";
                    if (in_array("A", $esta2)) {
                        $c3 = 1;
                    }

                    $esta4 = array();
                    $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                    $i = 0;
                    if (count($consulta10) > 0) {
                        foreach ($consulta10 as $val10) {
                            $esta4[$i] = $val10->estado;
                            $i++;
                        }
                    } else $esta4[0] = "P";
                    if (in_array("A", $esta4)) {
                        $c3 = 2;
                    }

                    $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                    $i = 0;
                    $esta = array();
                    if (count($consulta7) > 0) {
                        foreach ($consulta7 as $val7) {
                            $esta[$i] = $val7->estado;
                            $i++;
                        }
                    } else $esta[0] = "P";
                    if (in_array("A", $esta)) {
                        $est = "APROBADO";
                    } else {
                        $est = "PENDIENTE";
                    }

                    $esta5 = array();
                    $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                    $i = 0;
                    if (count($consulta7) > 0) {
                        foreach ($consulta7 as $val7) {
                            $esta5[$i] = $val7->estado;
                            $i++;
                        }
                    } else $esta5[0] = "P";
                    if (in_array("A", $esta5)) {
                        $c3 = 3;
                    }

                    $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                    foreach ($consulta5 as $val5) {
                        $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                        $solicitud = $val5->id_solicitud;
                        foreach ($consulta6 as $val6) {
                            $cant = $val6->cantidad_prov_nacional;
                        }

                        $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                        if (count($consulta8) > 0) {
                            foreach ($consulta8 as $val8) {
                                $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                            }
                        } else $archivo_prov = "VACIO";
                    }

                    if ($cant == 1) $c2 = 1;
                    else $c2 = 0;

                    if ($cant < 1) {
                        $valores = array();
                        $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                        if (empty($valores)) {
                            $valores[5] = "";
                            $valores[6] = "";
                            $valores[7] = "";
                            $valores[8] = "";
                        }
                        $vector[] = array(
                            "valor" => '24',
                            "val" => $c2 . "/" . $val->no_pedido,
                            "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "cantidad" => $cant,
                            "id_solicitud" => $solicitud,
                            "est_gen" => $est,
                            "archivo" => $archivo_prov,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_licitacion_valor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador4($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;

                        if ($cant < 1) {
                            $valores = array();
                            $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                            if (empty($valores)) {
                                $valores[5] = "";
                                $valores[6] = "";
                                $valores[7] = "";
                                $valores[8] = "";
                            }
                            $vector[] = array(
                                "valor" => '24',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "est_gen" => $est,
                                "archivo" => $archivo_prov,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador4($usuario);

                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;

                        if ($cant == 1) {
                            $valores = array();
                            $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                            if (empty($valores)) {
                                $valores[5] = "";
                                $valores[6] = "";
                                $valores[7] = "";
                                $valores[8] = "";
                            }
                            $vector[] = array(
                                "valor" => '24',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "est_gen" => $est,
                                "archivo" => $archivo_prov,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador4($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;
                        $valores = array();
                        $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                        if (empty($valores)) {
                            $valores[5] = "";
                            $valores[6] = "";
                            $valores[7] = "";
                            $valores[8] = "";
                        }
                        $vector[] = array(
                            "valor" => '24',
                            "val" => $c2 . "/" . $val->no_pedido,
                            "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "cantidad" => $cant,
                            "id_solicitud" => $solicitud,
                            "est_gen" => $est,
                            "archivo" => $archivo_prov,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function proveedor_excepcion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.modalidad.excepcion');
        }
    }

    public function lista_pedido_excepcion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_pedidos_pendientes_cotizador5($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $esta2 = array();
                    $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                    $i = 0;
                    $c3 = 0;
                    if (count($consulta9) > 0) {
                        foreach ($consulta9 as $val9) {
                            $esta2[$i] = $val9->estado;
                            $i++;
                        }
                    } else $esta2[0] = "P";
                    if (in_array("A", $esta2)) {
                        $c3 = 1;
                    }

                    $esta4 = array();
                    $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                    $i = 0;
                    if (count($consulta10) > 0) {
                        foreach ($consulta10 as $val10) {
                            $esta4[$i] = $val10->estado;
                            $i++;
                        }
                    } else $esta4[0] = "P";
                    if (in_array("A", $esta4)) {
                        $c3 = 2;
                    }

                    $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                    $i = 0;
                    $esta = array();
                    if (count($consulta7) > 0) {
                        foreach ($consulta7 as $val7) {
                            $esta[$i] = $val7->estado;
                            $i++;
                        }
                    } else $esta[0] = "P";
                    if (in_array("A", $esta)) {
                        $est = "APROBADO";
                    } else {
                        $est = "PENDIENTE";
                    }

                    $esta5 = array();
                    $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                    $i = 0;
                    if (count($consulta7) > 0) {
                        foreach ($consulta7 as $val7) {
                            $esta5[$i] = $val7->estado;
                            $i++;
                        }
                    } else $esta5[0] = "P";
                    if (in_array("A", $esta5)) {
                        $c3 = 3;
                    }

                    $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                    foreach ($consulta5 as $val5) {
                        $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                        $solicitud = $val5->id_solicitud;
                        foreach ($consulta6 as $val6) {
                            $cant = $val6->cantidad_prov_nacional;
                        }

                        $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                        if (count($consulta8) > 0) {
                            foreach ($consulta8 as $val8) {
                                $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                            }
                        } else $archivo_prov = "VACIO";
                    }

                    if ($cant == 1) $c2 = 1;
                    else $c2 = 0;

                    if ($cant < 1) {
                        $valores = array();
                        $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                        if (empty($valores)) {
                            $valores[5] = "";
                            $valores[6] = "";
                            $valores[7] = "";
                            $valores[8] = "";
                        }
                        $vector[] = array(
                            "valor" => '24',
                            "val" => $c2 . "/" . $val->no_pedido,
                            "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "cantidad" => $cant,
                            "id_solicitud" => $solicitud,
                            "est_gen" => $est,
                            "archivo" => $archivo_prov,
                        );
                        $bandera++;
                    }
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_excepcion_valor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $valor1 = $_POST['est_ped1'];
            $valor2 = $_POST['est_ped2'];
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';

            if (($valor1 == 'P' && $valor2 != 'A') || ($valor1 != 'P' && $valor2 != 'A')) {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador5($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;

                        if ($cant < 1) {
                            $valores = array();
                            $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                            if (empty($valores)) {
                                $valores[5] = "";
                                $valores[6] = "";
                                $valores[7] = "";
                                $valores[8] = "";
                            }
                            $vector[] = array(
                                "valor" => '24',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "est_gen" => $est,
                                "archivo" => $archivo_prov,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 != 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador5($usuario);

                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;

                        if ($cant == 1) {
                            $valores = array();
                            $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                            if (empty($valores)) {
                                $valores[5] = "";
                                $valores[6] = "";
                                $valores[7] = "";
                                $valores[8] = "";
                            }
                            $vector[] = array(
                                "valor" => '24',
                                "val" => $c2 . "/" . $val->no_pedido,
                                "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                                "numero" => $bandera,
                                "no_pedido" => $val->no_pedido,
                                "unidad" => $val->unidad_solicitante,
                                "cantidad" => $cant,
                                "id_solicitud" => $solicitud,
                                "est_gen" => $est,
                                "archivo" => $archivo_prov,
                            );
                            $bandera++;
                        }
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }

            if ($valor1 == 'P' && $valor2 == 'A') {
                $vector = array();
                $bandera = 1;
                $usuario = session('id');
                $consulta = Cotizador::listar_pedidos_pendientes_cotizador5($usuario);
                if (count($consulta) > 0) {
                    foreach ($consulta as $val) {
                        $esta2 = array();
                        $consulta9 = Cotizador::estado_prov_nacional($val->no_pedido, $usuario);
                        $i = 0;
                        $c3 = 0;
                        if (count($consulta9) > 0) {
                            foreach ($consulta9 as $val9) {
                                $esta2[$i] = $val9->estado;
                                $i++;
                            }
                        } else $esta2[0] = "P";
                        if (in_array("A", $esta2)) {
                            $c3 = 1;
                        }

                        $esta4 = array();
                        $consulta10 = Cotizador::estado_prov_nacional3($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta10) > 0) {
                            foreach ($consulta10 as $val10) {
                                $esta4[$i] = $val10->estado;
                                $i++;
                            }
                        } else $esta4[0] = "P";
                        if (in_array("A", $esta4)) {
                            $c3 = 2;
                        }

                        $consulta7 = Cotizador::estado_prov_nacional2($val->no_pedido, $usuario);
                        $i = 0;
                        $esta = array();
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta[0] = "P";
                        if (in_array("A", $esta)) {
                            $est = "APROBADO";
                        } else {
                            $est = "PENDIENTE";
                        }

                        $esta5 = array();
                        $consulta7 = Cotizador::estado_prov_nacional4($val->no_pedido, $usuario);
                        $i = 0;
                        if (count($consulta7) > 0) {
                            foreach ($consulta7 as $val7) {
                                $esta5[$i] = $val7->estado;
                                $i++;
                            }
                        } else $esta5[0] = "P";
                        if (in_array("A", $esta5)) {
                            $c3 = 3;
                        }

                        $consulta5 = Cotizador::listar_pedidos_articulos_pendientes_cotizador($val->no_pedido, $usuario);
                        foreach ($consulta5 as $val5) {
                            $consulta6 = Cotizador::cantidad_prov_nacional($val5->id_solicitud, $val5->ide, $usuario);
                            $solicitud = $val5->id_solicitud;
                            foreach ($consulta6 as $val6) {
                                $cant = $val6->cantidad_prov_nacional;
                            }

                            $consulta8 = Cotizador::listar_prov_nacional3($val5->id_solicitud, $val5->ide, $usuario);
                            if (count($consulta8) > 0) {
                                foreach ($consulta8 as $val8) {
                                    $archivo_prov = ($val8->archi != null ? $val8->archi : "VACIO");
                                }
                            } else $archivo_prov = "VACIO";
                        }

                        if ($cant == 1) $c2 = 1;
                        else $c2 = 0;
                        $valores = array();
                        $valores = self::obtener_datos_anpe_orden($val->no_pedido, $solicitud);
                        if (empty($valores)) {
                            $valores[5] = "";
                            $valores[6] = "";
                            $valores[7] = "";
                            $valores[8] = "";
                        }
                        $vector[] = array(
                            "valor" => '24',
                            "val" => $c2 . "/" . $val->no_pedido,
                            "val2" => $c2 . "-" . $val->no_pedido . "-" . $solicitud . "-" . $c3 . "-" . $valores[5] . "-" . $valores[6] . "-" . $valores[7] . "-" . $valores[8],
                            "numero" => $bandera,
                            "no_pedido" => $val->no_pedido,
                            "unidad" => $val->unidad_solicitante,
                            "cantidad" => $cant,
                            "id_solicitud" => $solicitud,
                            "est_gen" => $est,
                            "archivo" => $archivo_prov,
                        );
                        $bandera++;
                    }
                    return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_datos_contrato()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $orden = $_POST['orden_cont'];
            $fecha = $_POST['fecha_cont'];
            $fecha2 = $_POST['fecha_cont2'];
            $contrato = $_POST['contrato'];
            $usuario = session('id');
            $fecha_cot = $_POST['fecha_cont'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha2) {
                $fechaA = date('Ymd');
                $fechaB = date('His');
                $cadena_nom = $fechaA . $fechaB . $usuario;
                $archivo = "";
                if ($_FILES) {
                    foreach ($_FILES as $file) {
                        if ($file["error"] == UPLOAD_ERR_OK) {
                            move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                            $nombre_rb = "recursos/doc_prov/";
                            $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                        }
                    }
                }

                if ($archivo == "") return 3;

                $actualizar = Cotizador::actualizar_contrato($orden, $fecha_cot, $contrato, $archivo);
                if ($actualizar) {
                    return 1;
                } else return 0;
            } else return 0;
        }
    }

    public function editar_datos_contrato()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $orden = $_POST['orden_conte'];
            $fecha = $_POST['fecha_conte'];
            $fecha2 = $_POST['fecha_cont2e'];
            $contrato = $_POST['contratoe'];
            $usuario = session('id');
            $fecha_cot = $_POST['fecha_conte'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha2) {
                $fechaA = date('Ymd');
                $fechaB = date('His');
                $cadena_nom = $fechaA . $fechaB . $usuario;
                $archivo = "";
                if ($_FILES) {
                    foreach ($_FILES as $file) {
                        if ($file["error"] == UPLOAD_ERR_OK) {
                            move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                            $nombre_rb = "recursos/doc_prov/";
                            $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                        }
                    }
                }

                if ($archivo == "") return 3;

                $actualizar = Cotizador::actualizar_contrato($orden, $fecha_cot, $contrato, $archivo);
                if ($actualizar) {
                    return 1;
                } else return 0;
            } else return 0;
        }
    }

    public function editar_orden_contrato()
    {
        date_default_timezone_set("America/La_Paz");
        $vector = array();
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::ver_articulos_orden_cotizador_contrato($no_orden, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->fecha_cot;
                    $vector[1] = $val->tiempo_cot;
                    $vector[2] = $val->descrip_g;
                    $vector[3] = date('d-m-Y');
                    $vector[4] = $val->total;
                    $vector[5] = $val->orden;
                    $vector[6] = $val->fecha_cont;
                    $vector[7] = $val->no_cont;
                    $vector[8] = $val->archivo;
                }
            }
            return $vector;
        }
    }

    public function eliminar_contrato()
    {
        $no_contrato = $_POST['no_conte'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $anular = Cotizador::anular_contrato($no_contrato);
            if ($anular) {
                return 1;
            } else return 0;
        }
    }

    public function editar_orden_contrato_prov()
    {
        date_default_timezone_set("America/La_Paz");
        $vector = array();
        $no_orden = $_POST['no'];
        $no_orden = self::zero_fill($no_orden, 5);
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::ver_articulos_orden_cotizador_contrato2($no_orden, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[0] = $val->fecha_cot;
                    $vector[1] = $val->tiempo_cot;
                    $vector[2] = $val->descrip_g;
                    $vector[3] = date('d-m-Y');
                    $vector[4] = $val->total;
                    $vector[5] = $val->orden;
                    $vector[6] = $val->fecha_cont;
                    $vector[7] = $val->no_cont;
                    $vector[8] = $val->archivo;
                }
            }
            return $vector;
        }
    }

    public function recepcion_anpe()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.recepcion.anpe');
        }
    }

    public function recepcion_licitacion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.recepcion.licitacion');
        }
    }

    public function recepcion_excepcion()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('cotizador.recepcion.excepcion');
        }
    }

    public function listar_todo_orden_anpe()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_todo_orden_anpe($usuario);
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

    public function listar_todo_orden_licitacion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_todo_orden_licitacion($usuario);
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

    public function listar_todo_orden_excepcion()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::listar_todo_orden_excepcion($usuario);
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
                $consulta = Cotizador::listar_todo_orden_anpe($usuario);
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
                $consulta = Cotizador::listar_todo_orden_anpe($usuario);
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
                $consulta = Cotizador::listar_todo_orden_anpe($usuario);
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
                $consulta = Cotizador::listar_todo_orden_licitacion($usuario);
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
                $consulta = Cotizador::listar_todo_orden_licitacion($usuario);
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
                $consulta = Cotizador::listar_todo_orden_licitacion($usuario);
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
                $consulta = Cotizador::listar_todo_orden_excepcion($usuario);
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
                $consulta = Cotizador::listar_todo_orden_excepcion($usuario);
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
                $consulta = Cotizador::listar_todo_orden_excepcion($usuario);
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

    public function editar_licitacion_orden()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional_orden($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }

            $consulta = Cotizador::listar_prov_nacional2($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '28',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio" => $val->precio * $val->cant_aprob,
                        "no_pedi" => $val->no_pedido,
                        "cumple" => $val->cumplimiento,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_datos_licitacion_orden()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2e'];
            $fecha_cot = $_POST['fecha_cote2'];
            $contrato = $_POST['contratoe2'];
            $no_pedido = $_POST['no_pedidoe'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha) {

                $id_proveedor = $_POST['proveedore2'];
                $id_proveedor2 = $_POST['id_prov'];
                $oferta = $_POST['ofertae2'];
                $tiempo = $_POST['tiempoe2'];
                $id_solicitud = $_POST['id_solicitude'];
                $id_sol_det = $_POST['id_sol_dete'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cote'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['precioue'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumplee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }


                $fechaA = date('Ymd');
                $fechaB = date('His');
                $cadena_nom = $fechaA . $fechaB . $usuario;
                $archivo = "";
                if ($_FILES) {
                    foreach ($_FILES as $file) {
                        if ($file["error"] == UPLOAD_ERR_OK) {
                            move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                            $nombre_rb = "recursos/doc_prov/";
                            $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                        }
                    }
                }

                if ($archivo == "") return 3;

                $k = 0;
                for ($j = 0; $j < $i; $j++) {
                    $dat = Cotizador::recuperar_datos_prov_nacional($id_solicitud, $dato[0][$j], $usuario);

                    if (count($dat) > 0) {
                        foreach ($dat as $val) {
                            $recu[0][$k] = $val->id;
                            $recu[1][$k] = $val->id_prov;
                            $recu[2][$k] = $val->id_sol;
                            $recu[3][$k] = $val->id_soldet;
                            $recu[4][$k] = $val->preciou;
                            $recu[5][$k] = $val->cantidad;
                            $recu[6][$k] = $val->id_art;
                            $k++;
                        }
                    }
                }


                $seleccionar = Cotizador::listar_todos_orden();
                if (empty($seleccionar)) {
                    $ban = 1;
                } else {
                    $ban = 0;
                }

                for ($m = 0; $m < $k; $m++) {
                    $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recu[0][$m], "A");
                }

                for ($m = 0; $m < $k; $m++) {
                    $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                    if (empty($verificar)) {
                        $insertar = Cotizador::insertar_orden2($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario, $fecha_cot, $contrato, $archivo);
                        if ($insertar) {
                            if ($ban == 1) {
                                $ban = 0;
                                $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if (count($rec) > 0) {
                                    foreach ($rec as $val) {
                                        $id = $val->id;
                                    }
                                }

                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                if ($insertar2) {
                                    $act_orden = Cotizador::actualizar_total_orden($id);
                                }
                            } else {
                                $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if (count($rec) > 0) {
                                    foreach ($rec as $val) {
                                        $id = $val->id;
                                    }
                                }


                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        } else return 0;
                    } else {
                        foreach ($verificar as $val) {
                            $id = $val->id;
                        }

                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                        $act_orden = Cotizador::actualizar_total_orden($id);
                    }
                }
                return 4;
            } else return 0;
        }
    }

    public function modificar_licitacion_orden()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $no_pedido = self::zero_fill($no_pedido, 5);
            $id_solicitud = $_POST['id'];
            $obtener = Cotizador::obtener_datos_prov_nacional2($id_solicitud, $usuario);
            foreach ($obtener as $val) {
                $proveedor = $val->id_prova;
            }

            $consulta = Cotizador::listar_prov_nacional_orden($no_pedido, $proveedor, $id_solicitud, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '29',
                        "val" => '',
                        "numero" => $bandera,
                        "id" => $val->ide,
                        "unidad" => $val->unidad_solicitante,
                        "articulo" => $val->articulo . " - " . $val->descripcion,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "no_solicitud" => $val->no_solicitud,
                        "id_solicitud" => $val->id_solicitud,
                        "cantidad" => $val->cant_aprob,
                        "unidad" => $val->unidad,
                        "id_cot" => $val->id_cot,
                        "fecha_cot" => $val->fecha_cot,
                        "fecha" => $val->fecha,
                        "precio" => $val->precio* $val->cant_aprob,
                        "no_pedi" => $val->no_pedido,
                        "cumple" => $val->cumplimiento,
                        "id_ord" => $val->id_orden,
                        "no_ord" => $val->no_cont_orden,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function editar_datos_licitacion_orden()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = $_POST['fecha2e'];
            $fecha_cot = $_POST['fecha_cote2o'];
            $contrato = $_POST['contratoe2o'];
            $no_pedido = $_POST['no_pedidoe'];
            $id_orden = $_POST['id_ordene'];
            $no_orden = $_POST['no_ordene'];
            $fecha_co = explode("-", $fecha_cot);
            $fecha_cot = $fecha_co[2] . "-" . $fecha_co[1] . "-" . $fecha_co[0];

            if ($fecha_cot >= $fecha) {

                $id_proveedor = $_POST['proveedore2o'];
                $id_proveedor2 = $_POST['id_provo'];
                $oferta = $_POST['ofertae2o'];
                $tiempo = $_POST['tiempoe2o'];
                $id_solicitud = $_POST['id_solicitude'];
                $id_sol_det = $_POST['id_sol_dete'];
                $i = 0;
                foreach ($id_sol_det as $val) {
                    $dato[0][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['id_cote'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[1][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['precioue'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[2][$i] = $val;
                    $i++;
                }

                $id_cot = $_POST['cumplee'];
                $i = 0;
                foreach ($id_cot as $val) {
                    $dato[3][$i] = $val;
                    $i++;
                }


                $actualizar = Cotizador::actualizar_estado_orden3($id_orden, $contrato, $usuario);
                $fechaA = date('Ymd');
                $fechaB = date('His');
                $cadena_nom = $fechaA . $fechaB . $usuario;
                $archivo = "";
                if ($_FILES) {
                    foreach ($_FILES as $file) {
                        if ($file["error"] == UPLOAD_ERR_OK) {
                            move_uploaded_file($file["tmp_name"], "./recursos/doc_prov/" . $cadena_nom . ".pdf");
                            $nombre_rb = "recursos/doc_prov/";
                            $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                        }
                    }
                }

                if ($archivo == "") return 3;

                $k = 0;
                $recu = array();
                for ($j = 0; $j < $i; $j++) {
                    $dat = Cotizador::recuperar_datos_prov_nacional4($id_solicitud, $dato[0][$j], $usuario);

                    if (count($dat) > 0) {
                        foreach ($dat as $val) {
                            $recu[0][$k] = $val->id;
                            $recu[1][$k] = $val->id_prov;
                            $recu[2][$k] = $val->id_sol;
                            $recu[3][$k] = $val->id_soldet;
                            $recu[4][$k] = $val->preciou;
                            $recu[5][$k] = $val->cantidad;
                            $recu[6][$k] = $val->id_art;
                            $k++;
                        }
                    }
                }


                $seleccionar = Cotizador::listar_todos_orden();
                if (empty($seleccionar)) {
                    $ban = 1;
                } else {
                    $ban = 0;
                }

                for ($m = 0; $m < $k; $m++) {
                    $actualizar_pn = Cotizador::actualizar_estado_prov_nacional($recu[0][$m], "A");
                }


                for ($m = 0; $m < $k; $m++) {
                    $verificar = Cotizador::verificar_orden($recu[2][$m], $recu[1][$m], $usuario);
                    if (empty($verificar)) {
                        $insertar = Cotizador::insertar_orden2($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario, $fecha_cot, $contrato, $archivo);
                        if ($insertar) {
                            if ($ban == 1) {
                                $ban = 0;
                                $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if (count($rec) > 0) {
                                    foreach ($rec as $val) {
                                        $id = $val->id;
                                    }
                                }

                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                if ($insertar2) {
                                    $act_orden = Cotizador::actualizar_total_orden($id);
                                }
                            } else {
                                $rec = Cotizador::recuperar_ultima_orden($recu[2][$m], $recu[1][$m], $recu[0][$m], $usuario);
                                if (count($rec) > 0) {
                                    foreach ($rec as $val) {
                                        $id = $val->id;
                                    }
                                }


                                $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                                $act_orden = Cotizador::actualizar_total_orden($id);
                            }
                        } else return 0;
                    } else {
                        foreach ($verificar as $val) {
                            $id = $val->id;
                        }

                        $insertar2 = Cotizador::insertar_orden_det($id, $recu[3][$m], $recu[5][$m], $recu[4][$m], $recu[6][$m]);

                        $act_orden = Cotizador::actualizar_total_orden($id);
                    }
                }
                return 4;
            } else return 0;
        }
    }

    public function listar_articulo_orden_licitacion()
    {
        $vector = array();
        $bandera = 1;
        $no_orden = $_POST['no'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $consulta = Cotizador::ver_articulos_orden_cotizador2($no_orden, $usuario);
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
                        "orden" => $val->orden,
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
            $consulta = Cotizador::ver_articulos_orden_cotizador2($no_orden, $usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $ban = 0;
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_cotizacion_recepcion($val->id_solicitud, $usuario);
                        if (count($consulta2) > 0) {
                            foreach ($consulta2 as $val2) {
                                $vector[4] = $val2->fecha_cotizacion;
                                $vector[5] = date('d-m-Y');
                            }
                            $ban = 1;
                        }
                    }
                    if ($ban == 0) {
                        $consulta2 = Cotizador::listar_prov_nacional_recepcion($val->id_solicitud, $usuario);
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

            $consulta = Cotizador::listar_orden_recepcion2($no_orden, $usuario);
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

            $consulta = Cotizador::ver_articulos_orden_cotizador2($no_orden, $usuario);
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

    public function finalizar_recepcion_licitacion()
    {
        $no_orden = $_POST['ordenf'];
        $usuario = session('id');
        if (!empty($usuario)) {
            $finalizar = Cotizador::finalizar_recepcion2($no_orden, $usuario);
            if ($finalizar) {
                return 1;
            } else return 0;
        }
    }
}
