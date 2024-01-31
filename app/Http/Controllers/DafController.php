<?php

namespace App\Http\Controllers;

use App\Models\Daf;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class DafController extends Controller
{

    public function vista_aprobacion(){
        return view('daf.aprobacion');
    }

    public function lista_pedido_pendiente(){
        $vector = Array();
        $bandera = 1;
        $consulta = Daf::listar_pedidos_pendientes_daf();
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $vector[] = array(
                    "valor" => '5',
                    "numero" => $bandera,
                    "no_pedido" => $val->no_pedido,
                    "unidad" => $val->unidad_solicitante,
                    "estado" => ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO")),
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function lista_pedido_articulo_pendiente(){
        $vector = Array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $consulta = Daf::listar_pedidos_articulos_pendientes_daf($no_pedido);
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $cad1 = ($val->estado_art_aprob == "P"?"PENDIENTE":($val->estado_art_aprob == "A"?"APROBADO":"RECHAZADO"));
                $cad2 = ($val->estado_asign == "P"?"PENDIENTE":($val->estado_asign == "A"?"APROBADO":"RECHAZADO"));
                $vector[] = array(
                    "valor" => '6',
                    "val" => '',
                    "numero" => $bandera,
                    "id" => $val->id,
                    "unidad" => $val->unidad_solicitante,
                    "articulo" => $val->articulo." - ".$val->descripcion,
                    "cantidad" => $val->cantidad,
                    "cant_aprob" => $val->cant_aprob,
                    "estado" => ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO")),
                    "no_pedido" => $val->no_pedido,
                    "archivo" => ($val->archivo != null?$val->archivo:"VACIO"),
                    "estado_cod" => ($val->estado_cod == "C"?"CODIFICADO":"PENDIENTE"),
                    "estado_articulo" =>($val->estado_art == "P"?"PENDIENTE":($val->estado_art == "A"?"APROBADO":"RECHAZADO")),
                    "estado_art_aprob" =>($val->estado_art_aprob == "P"?"PENDIENTE":($val->estado_art_aprob == "A"?"APROBADO":"RECHAZADO")),
                    "estado_asign" => ($val->estado_asign == "P"?"PENDIENTE":"ASIGNADO"),
                    "estado2" => $cad1."/".$cad2,
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function lista_pedido_articulo_pendiente_observacion(){
        $vector = Array();
        $no_pedido = $_POST['no'];
        $consulta = Daf::listar_pedidos_articulos_pendientes_daf($no_pedido);
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $vector[0] = $val->no_pedido;
                $vector[1] = $val->motivo_rechazo;
                $vector[2] = ($val->estado_asign == "P"?"PENDIENTE":"ASIGNADO");
            }
        }
        return $vector;
        
    }

    public function lista_pedido_valor_daf(){
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $valor3 = $_POST['est_ped3'];
        $usuario = session('usuario');
        if(!empty($usuario)){
            if($valor1 == 0 && $valor2 == 0 && $valor3 == 0) $valor1='P';
            if($valor1 == 1) $valor1 = 'P';
            if($valor2 == 2) $valor2 = 'A';
            if($valor3 == 3) $valor3 = 'R';
            $vector = Array();
            $bandera = 1;
            $consulta = Daf::listar_pedidos_valor_daf($valor1, $valor2, $valor3);
            if(count($consulta) > 0){
                foreach($consulta as $val){
                    $vector[] = array(
                        "valor" => '5',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "estado" => ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO")),
                        "estado_asign" => ($val->estado_asign == "P"?"PENDIENTE":"ASIGNADO"),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
                
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function guardar_datos_daf(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedido'];
            $i=0;
            
            $cantidad = $_POST['cant_aprob'];
            foreach($cantidad as $val){
                $dato[0][$i] = $val;
                $i ++;
            }

            $i=0;
            $valor = $_POST['valor'];
            foreach($valor as $val){
                $dato[1][$i] = $val;
                $i ++;
            }

            $i=0;
            $id = $_POST['valor_id'];
            foreach($id as $val){
                $dato[2][$i] = $val;
                $i ++;
            }

            $i=0;
            $cant_ped = $_POST['valor_id2'];
            foreach($cant_ped as $val){
                $dato[3][$i] = $val;
                $i ++;
            }
            for ($k=0; $k < $i; $k++) { 
                if($dato[0][$k] > $dato[3][$k] || $dato[0][$k] == 0){
                    return [2, $k+1];
                }
            }

            $cont = 0;
            for ($j=0; $j < $i; $j++) { 
                if($dato[1][$j] != "A")
                    $cont ++;
            }
            if($cont == $i) return 4;

            for ($j=0; $j < $i; $j++) { 
                $actualizar = Daf::actualizar_articulos_daf($usuario, $dato[0][$j], $dato[1][$j], $dato[2][$j]);
            }

            $can_aprob = Daf::verificar_articulo_pedido_aprobado($no_pedido);
            $can_rech = Daf::verificar_articulo_pedido_aprobado_rechazado($no_pedido);
            foreach($can_aprob as $val){
                $cant_aprob = $val->verificar_articulo_pedido_aprobado;
            }
            foreach($can_rech as $val){
                $cant_rech = $val->verificar_articulo_pedido_aprobado_rechazado;
            }
            if($cant_aprob == $cant_rech){
                $actualiza = Daf::actualizar_articulos_daf_rechazo($usuario, $no_pedido);
            }
            return 1;
        }
    }

    public function editar_datos_daf(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['eno_pedido'];
            $i=0;
            
            $cantidad = $_POST['ecant_aprob'];
            foreach($cantidad as $val){
                $dato[0][$i] = $val;
                $i ++;
            }

            $i=0;
            $valor = $_POST['evalor'];
            foreach($valor as $val){
                $dato[1][$i] = $val;
                $i ++;
            }

            $i=0;
            $id = $_POST['evalor_id'];
            foreach($id as $val){
                $dato[2][$i] = $val;
                $i ++;
            }

            $i=0;
            $cant_ped = $_POST['evalor_id2'];
            foreach($cant_ped as $val){
                $dato[3][$i] = $val;
                $i ++;
            }
            for ($k=0; $k < $i; $k++) { 
                if($dato[0][$k] > $dato[3][$k] || $dato[0][$k] == 0){
                    return [2, $k+1];
                }
            }

            $cont = 0;
            for ($j=0; $j < $i; $j++) { 
                if($dato[1][$j] != "A")
                    $cont ++;
            }
            if($cont == $i) return 4;
            
            for ($j=0; $j < $i; $j++) { 
                $actualizar = Daf::actualizar_articulos_daf($usuario, $dato[0][$j], $dato[1][$j], $dato[2][$j]);
            }

            $can_aprob = Daf::verificar_articulo_pedido_aprobado($no_pedido);
            $can_rech = Daf::verificar_articulo_pedido_aprobado_rechazado($no_pedido);
            foreach($can_aprob as $val){
                $cant_aprob = $val->verificar_articulo_pedido_aprobado;
            }
            foreach($can_rech as $val){
                $cant_rech = $val->verificar_articulo_pedido_aprobado_rechazado;
            }
            if($cant_aprob == $cant_rech){
                $actualiza = Daf::actualizar_articulos_daf_rechazo($usuario, $no_pedido);
            }
            return 1;
        }
    }

    public function listar_solicitud(){
        $vector = Array();
        $bandera = 1;
        $consulta = Daf::listar_solicitud_daf();
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $vector[] = array(
                    "valor" => '11',
                    "numero" => $bandera,
                    "no_pedido" => $val->no_pedido,
                    "unidad" => $val->unidad_solicitante,
                    "estado" => ($val->estado_aprob == "P"?"PENDIENTE":($val->estado_aprob == "A"?"APROBADO":"RECHAZADO")),
                    "estado_cot" => ($val->estado_cot == "P"?"PENDIENTE":"APROBADO"),
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function lista_solicitud_articulo(){
        $vector = Array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $consulta = Daf::listar_solicitud_articulos($no_pedido);
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $vector[] = array(
                    "valor" => '12',
                    "numero" => $bandera,
                    "no_pedido" => $val->no_pedido,
                    "articulo" => $val->articulo." - ".$val->descrip,
                    "cantidad" => $val->cant_aprob,
                    "id" => $val->id,
                    "archivo" => ($val->archivo != null?$val->archivo:"VACIO"),
                    "unidad" => $val->unidad,
                    "estado" => ($val->estado_aprob == "P"?"PENDIENTE":"APROBADO"),
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function aprobar_pedido(){
        $usuario = session('id');
        if(!empty($usuario)){
            $id = $_POST['valor_id'];
            $estado = $_POST['estado'];
            $actualizar = Daf::actualizar_estaprob_solicitud($usuario, $estado, $id);
            if($estado == "A") return 1;
            if($estado == "B") return 2;
        }
    }

    public function rechazar_pedido(){
        $usuario = session('id');
        if(!empty($usuario)){
            $id = $_POST['evalor_id'];
            $estado = $_POST['eestado'];
            $actualizar = Daf::actualizar_estaprob_solicitud($usuario, $estado, $id);
            return 1;
        }
    }

    public function lista_solicitud_valor_daf(){
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $valor3 = $_POST['est_ped3'];
        $usuario = session('usuario');
        if(!empty($usuario)){
            if($valor1 == 0 && $valor2 == 0 && $valor3 == 0) $valor1='P';
            if($valor1 == 1) $valor1 = 'P';
            if($valor2 == 2) $valor2 = 'A';
            if($valor3 == 3) $valor3 = 'R';
            $vector = Array();
            $bandera = 1;
            $consulta = Daf::listar_solicitud_valor_daf($valor1, $valor2, $valor3);
            if(count($consulta) > 0){
                foreach($consulta as $val){
                    $vector[] = array(
                        "valor" => '11',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "estado" => ($val->estado_aprob == "P"?"PENDIENTE":($val->estado_aprob == "A"?"APROBADO":"RECHAZADO")),
                        "estado_cot" => ($val->estado_cot == "P"?"PENDIENTE":"APROBADO"),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
                
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function ver_imprimir_pedido(){
        $usuario = session('usuario');
        $html = "";
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedido'];
            $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Apresupuesto.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=".$no_pedido;
            return $html;
        }
    }

    public function ver_imprimir_solicitud(){
        $usuario = session('usuario');
        $html = "";
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedido'];
            $html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Asolicitud_compra.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=".$no_pedido;
            return $html;
        }
    } 

    public function anular_pedido_daf(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no'];
            $observacion = $_POST['obs'];
            if(!ctype_alpha(substr($observacion, 0, 1))){
                return 3;
            }
            if($observacion != ''){
                $actualizar = Daf::actualizar_observacion_rechazo($no_pedido, $observacion, $usuario);
                if($actualizar){
                    return 1;
                }
                return 0;
            }
            else return 2;
        }
        
    }
    
}
