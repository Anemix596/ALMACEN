<?php

namespace App\Http\Controllers;

use App\Models\Solicitante;
use App\Models\Presupuesto;

use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

class SolicitanteController extends Controller
{

    function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

    public function pedidos_realizados()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('solicitante.pedido_realizado');
        }
    }

    public function pedidos_anulados()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('solicitante.pedido_anulado');
        }
    }

    public function pedidos_aprobados()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            return view('solicitante.pedido_aprobado');
        }
    }

    public function recuperar_unidad_solicitante()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $ci = session('ci');
            $lista = Solicitante::listar_unidad_solicitante($ci);
            $html = '';
            $html2 = '';
            if (count($lista) > 0) {
                
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    $html2 = $val->id;
                }
            }
            return [$html, $html2];
        }
    }

    public function estructura_programatica()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = $_POST['id_unidad'];
            $lista = Solicitante::buscar_unidad_solicitante($id);
            $vector = array();
            foreach ($lista as $val) {
                $vector[0] = $val->id;
                $vector[1] = $val->prog;
                $vector[2] = $val->proy;
                $vector[3] = $val->activ;
                $vector[4] = $val->descrip;
                $vector[5] = $val->codigo;
                $vector[6] = $val->sissin;
                $vector[7] = $val->uniejec_id;
                $vector[8] = $val->gestion;
                $vector[9] = $val->estado;
            }
            return $vector;
        }
    }

    public function recuperar_superior_responsable()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = $_POST['id'];
            $lista = Solicitante::listar_funcionarios($id);
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Responsable' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->grado . ' ' . $val->nombres . ' ' . $val->apell_pat . ' ' . $val->apell_mat . "</option>";
                }
            }
            return $html;
        }
    }

    public function recuperar_articulo()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Solicitante::listar_articulo();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Articulo' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function recuperar_articulo_valor()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = 1;//$_POST['id'];
            $lista = Solicitante::listar_articulo_categoria($id);
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Articulo' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            } else {
                $lista = Solicitante::listar_articulo_part($id);
                if (count($lista) > 0) {
                    $html .= "<option value='' disabled selected>" . 'Seleccionar Articulo' . "</option>";
                    foreach ($lista as $val) {
                        $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                    }
                }
            }
            return $html;
        }
    }

    public function recuperar_articulo_valor2()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = 1;//$_POST['id'];
            $lista = Solicitante::listar_articulo_part($id);
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Articulo' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function recuperar_unidad_medida()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = $_POST['id_articulo'];
            $lista = Solicitante::buscar_unidad_articulo($id);
            $vector = array();
            foreach ($lista as $val) {
                $vector[0] = $val->ida;
                $vector[1] = $val->descripa;
                $vector[2] = $val->abreva;
                $vector[3] = $val->estadoa;
                $vector[4] = $val->idb;
                $vector[5] = $val->descripb;
                $vector[6] = $val->categ_idb;
                $vector[7] = $val->unid_idb;
                $vector[8] = $val->estadob;
            }
            return $vector;
        }
    }

    public function recuperar_categoria()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Solicitante::listar_categoria();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Categoria' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function listar_unidad_medida()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Solicitante::listar_unidad_medida();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Unidad de Medida' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function insertar_articulo()
    {
        $categoria = $_POST['categoria'];
        $descrip = strtoupper($_POST['articuloa']);
        $unidad_pieza = $_POST['unidad_pieza'];
        $usuario = session('usuario');
        $partida = $_POST['partida'];

        if (!empty($usuario)) {
            if ($descrip != '') {
                if ($categoria != null) {
                    if ($unidad_pieza != null) {
                        $verificar = Solicitante::verificar_articulo($descrip);
                        if (empty($verificar)) {
                            $insertar = Solicitante::insertar_articulo($descrip, $categoria, $unidad_pieza, $partida);
                            if ($insertar) {
                                return 1;
                            } else return 0;
                        } else return 2;
                    } else return 0;
                } else return 0;
            } else return 3;
        } else return 0;
    }

    public function insertar_articulo2()
    {

        $categoria = $_POST['categoria3'];
        $descrip = strtoupper($_POST['articuloa3']);
        $unidad_pieza = $_POST['unidad_pieza3'];
        $usuario = session('usuario');
        $partida = $_POST['partida3'];

        if (!empty($usuario)) {
            if ($descrip != '') {
                if ($categoria != null) {
                    if ($unidad_pieza != null) {
                        $verificar = Solicitante::verificar_articulo($descrip);
                        if (empty($verificar)) {
                            $insertar = Solicitante::insertar_articulo($descrip, $categoria, $unidad_pieza, $partida);
                            if ($insertar) {
                                return 1;
                            } else return 0;
                        } else return 2;
                    } else return 0;
                } else return 0;
            } else return 3;
        } else return 0;
    }

    public function ver_lista_pedido_realizado()
    {
        date_default_timezone_set("America/La_Paz");
        $usuario = session('id');
        if (!empty($usuario)) {
            $fecha = date('Y-m-d');
            $fecha_inicio = $fecha . " 00:00:00";
            $fecha_final = $fecha . " 23:59:59";
            $vector = array();
            $bandera = 1;
            $usuario = session('usuario');
            $consulta = Solicitante::listar_pedidos_realizados($usuario, $fecha_inicio, $fecha_final);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Solicitante::cantidad_codificados($val->no_pedido);
                    foreach ($consulta2 as $val2) {
                        $cant_codif = $val2->cantidad_codificados;
                    }
                    $estad = ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO"));
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "cant_codif" => $cant_codif,
                        "no_pedido" => $val->no_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat,
                        "motivo" => $val->motivo,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "usuario" => $val->usuario,
                        "observacion" => ($val->obs != "A" ? "HABILITADO" : "ANULADO"),
                        "estado_codif" => ($val->estado_codif == "P" ? "PENDIENTE" : ($val->estado_codif == "A" ? "APROBADO" : "RECHAZADO")),
                        "estadoc" => $estad . "/" . $val->no_pedido,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_lista_pedido_articulo()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $no_pedido = $_POST['no'];
            $usuario = session('usuario');
            $consulta = Solicitante::listar_pedidos_articulos($usuario, $no_pedido);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Solicitante::cantidad_codificados($val->no_pedido);
                    foreach ($consulta2 as $val2) {
                        $cant_codif = $val2->cantidad_codificados;
                    }
                    $vector[] = array(
                        "valor" => '2',
                        "numero" => $bandera,
                        "id" => $val->id,
                        "cant_codif" => $cant_codif,
                        "fecha_pedido" => $val->fecha_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat,
                        "motivo" => $val->motivo,
                        "articulo" => $val->articulo,
                        "unidad_medida" => $val->unidad_medida,
                        "descripcion" => $val->descripcion,
                        "cantidad" => $val->cantidad,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "usuario" => $val->usuario,
                        "archivo" => ($val->archivo != null ? $val->archivo : "VACIO"),
                        "observacion" => ($val->obs != "A" ? "HABILITADO" : "ANULADO"),
                        "no_pedido" => $val->no_pedido,
                        "est_art" => ($val->est_art == "A" ? "APROBADO" : ($val->est_art == "R" ? "RECHAZADO" : "PENDIENTE")),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }


    public function insertar_pedido_archivo()
    {
        date_default_timezone_set("America/La_Paz");
        $unidad = $_POST['unidad'];
        $estruc_prog = $_POST['estruc_prog2'];
        $responsable = $_POST['responsable'];
        $motivo = strtoupper($_POST['emplearse']);
        $articulo = $_POST['articulo'];
        $unidad_medida = $_POST['unidad_medida2'];
        $descripcion = strtoupper($_POST['descripcion']);
        if ($_POST['cantidad'] == 0) return 2;
        $cant_ped = $_POST['cantidad'];
        $usuario = session('id');


        $fecha = date('Y-m-d');
        $fechaA = date('Ymd');
        $fechaB = date('His');
        $cadena_nom = $fechaA . $fechaB . $usuario;
        $fecha_inicio = $fecha . " 00:00:00";
        $fecha_final = $fecha . " 23:59:59";

        if (!empty($usuario)) {
            $seleccionar = Solicitante::listar_todos_pedidos();
            if (empty($seleccionar)) {
                $ban = 1;
            } else {
                $ban = 0;
            }
            $verificar = Solicitante::verificar_pedido($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final);
            if (!empty($verificar)) {
                foreach ($verificar as $val) {
                    $valor_ped = $val->id;
                }
                /* $valor_ped2 = 0;
                $verificar_articulo = Solicitante::verificar_pedido_articulo($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final, $articulo, $descripcion);
                if (!empty($verificar_articulo)) {
                    foreach ($verificar_articulo as $val) {
                        $valor_ped2 = $val->ida;
                    }
                }
                dd($valor_ped, $valor_ped2); */

                /* $valor_ped2 = 0;
                $verificar_articulo = Solicitante::verificar_pedido_articulo($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final, $articulo, $descripcion);
                if (!empty($verificar_articulo)) {
                    foreach ($verificar_articulo as $val) {
                        $valor_ped2 = $val->ida;
                    }
                }
                dd($valor_ped, $valor_ped2); */
                
                //if ($valor_ped != $valor_ped2) {
                    $recuperar = Solicitante::recuperar_pedido_insertado($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final);
                    if ($recuperar) {
                        $recuperar2 = Solicitante::recuperar_pedido_insertado2($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final);
                        if ($recuperar2) {
                            foreach ($verificar as $val) {
                                $pedido[0] = $val->id;
                                $pedido[1] = $val->no_pedido;
                            }
                            foreach ($recuperar as $val) {
                                $dato[0] = $val->id;
                            }
                            foreach ($recuperar2 as $val) {
                                $valor[0] = $val->id;
                            }
                            if ($dato[0] == 1) {
                                $vector[0] = $dato[0];
                                $no_pedido = self::zero_fill($dato[0], 5);
                                $insertar3 = Solicitante::actualizar_pedido($no_pedido, $vector[0]);
                                if ($insertar3) {
                                    $insertar4 = Solicitante::insertar_pedido_det($vector[0], $articulo, $descripcion, $cant_ped, $unidad_medida);
                                    if ($insertar4) {
                                        $archivo = "";
                                        if ($_FILES) {
                                            foreach ($_FILES as $file) {
                                                if ($file["error"] == UPLOAD_ERR_OK) {
                                                    move_uploaded_file($file["tmp_name"], "./recursos/doc/" . $cadena_nom . $file["name"]);
                                                    $nombre_rb = "recursos/doc/";
                                                    $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                                                    copy($file["tmp_name"], $nombre_rb . $archivo);
                                                }
                                            }
                                        }
                                        if ($archivo != "") {
                                            $actualizar = Solicitante::actualizar_pedidodet_archivo($archivo, $vector[0]);
                                        }
                                        return 1;
                                    } else return 0;
                                } else return 0;
                            }
                            $vector[0] = $valor[0];
                            $no_pedido = $pedido[1];
                            $insertar3 = Solicitante::actualizar_pedido($no_pedido, $vector[0]);
                            if ($insertar3) {
                                $insertar4 = Solicitante::insertar_pedido_det($vector[0], $articulo, $descripcion, $cant_ped, $unidad_medida);
                                if ($insertar4) {
                                    $archivo = "";
                                    if ($_FILES) {
                                        foreach ($_FILES as $file) {
                                            if ($file["error"] == UPLOAD_ERR_OK) {
                                                move_uploaded_file($file["tmp_name"], "./recursos/doc/" . $cadena_nom . ".pdf");
                                                $nombre_rb = "recursos/doc/";
                                                $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                                            }
                                        }
                                    }
                                    if ($archivo != "") {
                                        $actualizar = Solicitante::actualizar_pedidodet_archivo($archivo, $vector[0]);
                                    }
                                    return 1;
                                } else return 0;
                            } else return 0;
                        } else return 0;
                    } else return 0;
                //} else return 3;
            } else {
                $insertar = Solicitante::insertar_pedido($unidad, $motivo, $estruc_prog, $responsable, $usuario);
                if ($insertar) {
                    $recuperar = Solicitante::recuperar_pedido_insertado($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final);
                    if ($recuperar) {
                        $recuperar2 = Solicitante::recuperar_pedido_insertado2($unidad, $motivo, $estruc_prog, $responsable, $usuario, $fecha_inicio, $fecha_final);
                        if ($recuperar2) {
                            foreach ($recuperar as $val) {
                                $dato[0] = $val->id;
                                $dato[1] = $val->no_pedido;
                            }
                            foreach ($recuperar2 as $val) {
                                $valor[0] = $val->id;
                            }
                            if ($dato[1] == null && $ban == 1) {
                                $dato[1] = 1;
                                $vector[0] = $dato[0];
                                $no_pedido = self::zero_fill($dato[1], 5);
                                $insertar3 = Solicitante::actualizar_pedido($no_pedido, $vector[0]);
                                if ($insertar3) {
                                    $insertar4 = Solicitante::insertar_pedido_det($vector[0], $articulo, $descripcion, $cant_ped, $unidad_medida);
                                    if ($insertar4) {
                                        $archivo = "";
                                        if ($_FILES) {
                                            foreach ($_FILES as $file) {
                                                if ($file["error"] == UPLOAD_ERR_OK) {
                                                    move_uploaded_file($file["tmp_name"], "./recursos/doc/" . $cadena_nom . ".pdf");
                                                    $nombre_rb = "recursos/doc/";
                                                    $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                                                    copy($file["tmp_name"], $nombre_rb . $archivo);
                                                }
                                            }
                                        }

                                        if ($archivo != "") {
                                            $actualizar = Solicitante::actualizar_pedidodet_archivo($archivo, $vector[0]);
                                        }
                                        return 1;
                                    } else return 0;
                                } else return 0;
                            }

                            $insertar2 = Solicitante::recuperar_id_pedido();
                            if ($insertar2) {
                                $vector[0] = $valor[0];
                                foreach ($insertar2 as $val) {

                                    $vector[1] = $val->no_pedido;
                                    $vector[2] = (int)$vector[1];
                                    $vector[2]++;
                                }
                                $no_pedido = self::zero_fill($vector[2], 5);
                                $insertar3 = Solicitante::actualizar_pedido($no_pedido, $vector[0]);
                                if ($insertar3) {
                                    $insertar4 = Solicitante::insertar_pedido_det($vector[0], $articulo, $descripcion, $cant_ped, $unidad_medida);
                                    if ($insertar4) {
                                        $archivo = "";
                                        if ($_FILES) {
                                            foreach ($_FILES as $file) {
                                                if ($file["error"] == UPLOAD_ERR_OK) {
                                                    move_uploaded_file($file["tmp_name"], "./recursos/doc/" . $cadena_nom . ".pdf");
                                                    $nombre_rb = "recursos/doc/";
                                                    $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                                                }
                                            }
                                        }
                                        if ($archivo != "") {
                                            $actualizar = Solicitante::actualizar_pedidodet_archivo($archivo, $vector[0]);
                                        }
                                        return 1;
                                    } else return 0;
                                } else return 0;
                            }
                        } else return 0;
                    } else return 0;
                } else return 0;
            }
        } else return 0;
    }

    public function ver_editar_pedido()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id = $_POST['id'];
            $lista = Solicitante::buscar_pedido($id);
            $vector = array();
            foreach ($lista as $val) {
                $vector[0] = $val->id;
                $vector[1] = $val->unidad_solicitante;
                $vector[2] = $val->grado;
                $vector[3] = $val->nombres;
                $vector[4] = $val->apell_pat;
                $vector[5] = $val->apell_mat;
                $vector[6] = $val->motivo;
                $vector[7] = $val->articulo;
                $vector[8] = $val->descripcion;
                $vector[9] = $val->cantidad;
                $vector[10] = $val->archivo;
                $vector[11] = $val->unidad_medida;
                $vector[12] = $val->responsable;
                $vector[13] = $val->estruc_prog;
                $vector[14] = $val->fecha_pedido;
                $vector[15] = $val->unidad_id;
                $vector[16] = $val->programa_id;
                $vector[17] = $val->nombre_articulo;
                $vector[18] = $val->no_pedido;
                $vector[20] = $val->categoria;
                $vector[21] = $val->part_id;

                $lista2 = Solicitante::buscar_grupo_presup($vector[21]);
                foreach ($lista2 as $val2) {
                    $vector[22] = $val2->grupo_id;
                }
            }
            return $vector;
        }
    }

    public function ver_editar_pedido_articulo()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $id_categoria = $_POST['id_categoria'];
            $id_articulo = $_POST['id_articulo'];
            $lista = Solicitante::listar_articulo_categoria($id_categoria);
            $html = '';
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id_articulo) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }

                foreach ($lista as $val) {
                    if ($val->id != $id_articulo) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }
            }
            return $html;
        }
    }

    public function ver_editar_pedido_categoria()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $lista = Solicitante::listar_categoria();
            $id_articulo = $_POST['id_categoria'];
            $html = '';
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id_articulo) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }

                foreach ($lista as $val) {
                    if ($val->id != $id_articulo) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }
            }
            return $html;
        }
    }

    public function actualizar_pedido()
    {
        date_default_timezone_set("America/La_Paz");
        $articulo = $_POST['articulo3'];
        $unidad_medida = $_POST['unidad_medida4'];
        $descripcion = strtoupper($_POST['descripcion3']);

        if ($_POST['cantidad3'] == 0) return 2;

        $cantidad = $_POST['cantidad3'];
        $id = $_POST['id'];
        $usuario = session('id');


        $fechaA = date('Ymd');
        $fechaB = date('His');
        $cadena_nom = $fechaA . $fechaB . $usuario;
        $archivo = "";
        if ($_FILES) {
            foreach ($_FILES as $file) {
                if ($file["error"] == UPLOAD_ERR_OK) {
                    move_uploaded_file($file["tmp_name"], "./recursos/doc/" . $cadena_nom . ".pdf");
                    $nombre_rb = "recursos/doc/";
                    $archivo .= $nombre_rb . $cadena_nom . ".pdf";
                }
            }
        }
        if (!empty($usuario)) {
            $verificar = Solicitante::extraer_id_pedido($id);
            foreach ($verificar as $val) {
                $id_pedido = $val->pedido_id;
            }
            $verificar2 = Solicitante::extraer_datos_pedido($id_pedido);
            foreach ($verificar2 as $val) {
                if ($articulo == $val->articulob && $descripcion == $val->descripcionb && $id != $val->idb)
                    return 3;
            }
            $actualizar = Solicitante::actualizar_datos_pedido($articulo, $descripcion, $cantidad, $unidad_medida, $archivo, $id, $usuario);
            if ($actualizar) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function eliminar_pedido()
    {
        $id = $_POST['pid'];
        $usuario = session('id');

        if (!empty($usuario)) {
            $actualizar = Solicitante::eliminar_pedido($id, $usuario);
            if ($actualizar) {
                return 1;
            } else return 0;
        }
    }

    public function eliminar_archivo()
    {
        $id = $_POST['idp'];
        $usuario = session('id');

        if (!empty($usuario)) {
            $actualizar = Solicitante::eliminar_archivo($id, $usuario);
            if ($actualizar) {
                return 1;
            } else return 0;
        }
    }

    public function ver_lista_pedido()
    {

        $vector = array();
        $bandera = 1;
        $usuario = session('usuario');
        if (!empty($usuario)) {
            $consulta = Solicitante::listar_pedidos($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Solicitante::cantidad_codificados($val->no_pedido);
                    foreach ($consulta2 as $val2) {
                        $cant_codif = $val2->cantidad_codificados;
                    }
                    $fecha = explode("-", $val->fecha_pedido);
                    $estad = ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO"));
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "cant_codif" => $cant_codif,
                        "no_pedido" => $val->no_pedido,
                        "fecha_pedido" => $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0],
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat,
                        "motivo" => $val->motivo,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "usuario" => $val->usuario,
                        "observacion" => ($val->obs != "A" ? "HABILITADO" : "ANULADO"),
                        "estado_codif" => ($val->estado_codif == "P" ? "PENDIENTE" : ($val->estado_codif == "A" ? "APROBADO" : "RECHAZADO")),
                        "estadoc" => $estad . "/" . $val->no_pedido,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_lista_pedido_anulado()
    {
        $vector = array();
        $bandera = 1;
        $usuario = session('usuario');
        if (!empty($usuario)) {
            $consulta = Solicitante::listar_pedidos_anulados($usuario);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Solicitante::cantidad_codificados($val->no_pedido);
                    foreach ($consulta2 as $val2) {
                        $cant_codif = $val2->cantidad_codificados;
                    }
                    $fecha = explode("-", $val->fecha_pedido);
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "cant_codif" => $cant_codif,
                        "fecha_pedido" => $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0],
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat,
                        "motivo" => $val->motivo,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "usuario" => $val->usuario,
                        "observacion" => ($val->obs != "A" ? "HABILITADO" : "ANULADO"),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_lista_pedido_articulo_anulado()
    {
        $vector = array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $usuario = session('usuario');
        if (!empty($usuario)) {
            $consulta = Solicitante::listar_pedidos_articulos_anulados($usuario, $no_pedido);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $consulta2 = Solicitante::cantidad_codificados($val->no_pedido);
                    foreach ($consulta2 as $val2) {
                        $cant_codif = $val2->cantidad_codificados;
                    }
                    $vector[] = array(
                        "valor" => '2',
                        "numero" => $bandera,
                        "id" => $val->id,
                        "cant_codif" => $cant_codif,
                        "fecha_pedido" => $val->fecha_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat,
                        "motivo" => $val->motivo,
                        "articulo" => $val->articulo,
                        "unidad_medida" => $val->unidad_medida,
                        "descripcion" => $val->descripcion,
                        "cantidad" => $val->cantidad,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "usuario" => $val->usuario,
                        "archivo" => $val->archivo,
                        "observacion" => ($val->obs != "A" ? "HABILITADO" : "ANULADO"),
                        "no_pedido" => $val->no_pedido,
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_pedido_valor_solicitante()
    {
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $valor3 = $_POST['est_ped3'];
        $usuario = session('usuario');
        if (!empty($usuario)) {
            if ($valor1 == 0 && $valor2 == 0 && $valor3 == 0) $valor1 = 'P';
            if ($valor1 == 1) $valor1 = 'P';
            if ($valor2 == 2) $valor2 = 'A';
            if ($valor3 == 3) $valor3 = 'R';
            $vector = array();
            $bandera = 1;
            $consulta = Solicitante::listar_pedidos_valor_solicitante($usuario, $valor1, $valor2, $valor3);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $fecha = explode("-", $val->fecha_pedido);
                    $estad = ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO"));
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "fecha_pedido" => $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0],
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado . " " . $val->nombres . " " . $val->apell_pat . " " . $val->apell_mat,
                        "motivo" => $val->motivo,
                        "estado" => ($val->estado == "P" ? "PENDIENTE" : ($val->estado == "A" ? "APROBADO" : "RECHAZADO")),
                        "usuario" => $val->usuario,
                        "observacion" => ($val->obs != "A" ? "HABILITADO" : "ANULADO"),
                        "fuente_fnto" => ($val->fuente_fnto != null ? "ASIGNADO" : "NO ASIGNADO"),
                        "estadoc" => $estad . "/" . $val->no_pedido,

                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson();
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_imprimir_pedido()
    {
        $usuario = session('usuario');
        $html = "";
        if (!empty($usuario)) {
            $no_pedido = $_POST['no_pedido'];
            /* $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Asolicitante.prpt/generatedContent?userid=usuario&password=uatf&output-target=pageable%2Fpdf&aliase=" . $usuario . "&no_pedidoe=" . $no_pedido; */
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Asolicitante.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&aliase=" . $usuario . "&no_pedidoe=" . $no_pedido;
            return $html;
        }
    }

    public function recuperar_observacion_pedido()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            $no = $_POST['no'];
            $no = self::zero_fill($no, 5);
            $lista = Solicitante::listar_pedido($no);
            $vector = array();
            foreach ($lista as $val) {
                $vector[0] = $val->observacion;
            }
            return $vector;
        }
    }

    public function vista_suministros()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            return view('solicitante.index_suministros');
        }
    }

    public function vista_activos()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            return view('solicitante.index');
        }
    }

    public function lista_activos()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            return view('solicitante.items_activos');
        }
    }

    public function ver_lista_activos()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $consulta = Solicitante::ver_lista_activos();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "codigo" => $val->cod_mat,
                        "partida" => $val->partida,
                        "descripcion" => $val->descrip,
                        "unidad" => $val->unidad,
                    );
                    $bandera++;
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function lista_suministros()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            return view('solicitante.items_suministros');
        }
    }

    public function ver_lista_suministros()
    {
        $usuario = session('id');
        if (!empty($usuario)) {
            $vector = array();
            $bandera = 1;
            $consulta = Solicitante::ver_lista_suministros();
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "codigo" => $val->cod_mat,
                        "partida" => $val->partida,
                        "descripcion" => $val->descrip,
                        "unidad" => $val->unidad,
                    );
                    $bandera++;
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_lista_suministros_valor()
    {
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $usuario = session('usuario');
        if (!empty($usuario)) {
            if ($valor1 == 0 && $valor2 == 0) $valor1 = 'C';
            if ($valor1 == 1) $valor1 = 'C';
            if ($valor2 == 2) $valor2 = 'S';
            $vector = array();
            $bandera = 1;
            $consulta = Solicitante::ver_lista_suministros_valor($valor1, $valor2);
            if (count($consulta) > 0) {
                foreach ($consulta as $val) {
                    $vector[] = array(
                        "valor" => '1',
                        "numero" => $bandera,
                        "codigo" => $val->cod_mat,
                        "partida" => $val->partida,
                        "descripcion" => $val->descrip,
                        "unidad" => $val->unidad,

                    );
                    $bandera++;
                }
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function recuperar_part_presup()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            $lista = Solicitante::listar_part();
            $html = '';
            if (count($lista) > 0) {
                $html .= "<option value='' disabled selected>" . 'Seleccionar Clasificador' . "</option>";
                foreach ($lista as $val) {
                    $html .= "<option value='$val->id'>" . $val->descrip . "</option>";
                }
            }
            return $html;
        }
    }

    public function listar_grupo_part()
    {
        $usuario = session('usuario');
        if (!empty($usuario)) {
            $id_articulo = $_POST['idp'];
            $id_grupo = $_POST['id'];
            $lista = Solicitante::listar_part_presup($id_grupo);
            $html = '';
            if (count($lista) > 0) {
                foreach ($lista as $val) {
                    if ($val->id == $id_articulo) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }

                foreach ($lista as $val) {
                    if ($val->id != $id_articulo) {
                        $html .= "<option value='" . $val->id . "'>" . $val->descrip . "</option>";
                    }
                }
            }
            return $html;
        }
    }
}
