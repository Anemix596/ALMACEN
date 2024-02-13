<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class BienController extends Controller
{
    
    public function lista_pedido_pendiente(){
        $vector = Array();
        $bandera = 1;
        $consulta = Bien::listar_pedidos_pendientes_bien();
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $vector[] = array(
                    "valor" => '7',
                    "numero" => $bandera,
                    "no_pedido" => $val->no_pedido,
                    "unidad" => $val->unidad_solicitante,
                    "estado" => ($val->est_asign == "P"?"PENDIENTE":"ASIGNADO"),
                    "est_almacen" => ($val->est_almacen == "P"?"PENDIENTE":($val->est_almacen == "A"?"ASIGNADO":"RECHAZADO")),
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function lista_pedido_articulo_pendiente(){
        $variable = self::listar_cotizadores();
        $vector = Array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $consulta = Bien::listar_pedidos_articulos_pendientes_bien($no_pedido);
        if(count($consulta) > 0){
            foreach($consulta as $val){
                if($val->resp_asig != null){
                    $variable2 = self::ver_editar_cotizador($val->resp_asig);
                }
                else $variable2 = "";
                
                $vector[] = array(
                    "valor" => '8',
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
                    "estado_asign" =>($val->estado_asign == "P"?"PENDIENTE":"ASIGNADO"),
                    "lista_cot" => $variable,
                    "editar_cot" => $variable2,
                    "resp_asig" => $val->resp_asig,
                    "estado_asig" => $val->estado_asig,
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function lista_pedido_valor_bien(){
        $valor1 = $_POST['est_ped1'];
        $valor2 = $_POST['est_ped2'];
        $usuario = session('usuario');
        if(!empty($usuario)){
            if($valor1 == 0 && $valor2 == 0) $valor1='P';
            if($valor1 == 1) $valor1 = 'P';
            if($valor2 == 2) $valor2 = 'A';
            $vector = Array();
            $bandera = 1;
            $consulta = Bien::listar_pedidos_valor_bien($valor1, $valor2);
            if(count($consulta) > 0){
                foreach($consulta as $val){
                    $vector[] = array(
                        "valor" => '7',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "unidad" => $val->unidad_solicitante,
                        "estado" => ($val->est_asign == "P"?"PENDIENTE":"ASIGNADO"),
                        "est_almacen" => ($val->est_almacen == "P"?"PENDIENTE":($val->est_almacen == "A"?"ASIGNADO":"RECHAZADO")),
                    );
                    $bandera++;
                }
                return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
                
            }
            return Datatables::of($vector)->toJson();
        }
    }

    public function listar_cotizadores(){
        $lista = Bien::listar_cotizadores();
        $html = '';
        if(count($lista)>0){
            $html.="<option value='' disabled selected>".'Seleccionar Cotizador'."</option>";
            foreach($lista as $val){
                $html.="<option value='$val->ida'>".$val->gradoa." ".$val->nombresa." ".$val->apell_pata." ".$val->apell_mata."</option>";
            }
        }
        return $html;
    }

    public function guardar_datos_bien(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedido'];
            $i=0;
            $cantidad = $_POST['valor'];
            foreach($cantidad as $val){
                $dato[0][$i] = $val;
                $i ++;
            }

            $i=0;
            $cantidad = $_POST['valor_id'];
            foreach($cantidad as $val){
                $dato[1][$i] = $val;
                $i ++;
            }
            
            for ($j=0; $j < $i; $j++) { 
                $consulta = Bien::actualizar_articulos_bien($dato[0][$j], $dato[1][$j]);
            }
            
            $can_aprob = Bien::verificar_articulo_pedido_bien($no_pedido);
            $can_asig = Bien::verificar_articulo_pedido_asignado_bien($no_pedido);
            foreach ($can_aprob as $val) {
                $cant_aprob = $val->verificar_articulo_pedido_bien;
            }
            foreach ($can_asig as $val) {
                $cant_asig = $val->verificar_articulo_pedido_asignado_bien;
            }

            if($cant_aprob == $cant_asig){
                $act = Bien::actualizar_pedido_bien($usuario, $no_pedido);
            }
            return 1;
        }
    }

    public function editar_datos_bien(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['eno_pedido'];

            $i=0;
            $cantidad2 = $_POST['evalor'];
            foreach($cantidad2 as $val){
                $dato[0][$i] = $val;
                $i ++;
            }

            $i=0;
            $cantidad3 = $_POST['evalor_id'];
            foreach($cantidad3 as $val){
                $dato[1][$i] = $val;
                $i ++;
            }
            for ($j=0; $j < $i; $j++) { 
                $consulta = Bien::actualizar_articulos_bien($dato[0][$j], $dato[1][$j]);
            }
            
            $can_aprob = Bien::verificar_articulo_pedido_bien($no_pedido);
            $can_asig = Bien::verificar_articulo_pedido_asignado_bien($no_pedido);
            foreach ($can_aprob as $val) {
                $cant_aprob = $val->verificar_articulo_pedido_bien;
            }
            foreach ($can_asig as $val) {
                $cant_asig = $val->verificar_articulo_pedido_asignado_bien;
            }

            if($cant_aprob == $cant_asig){
                $act = Bien::actualizar_pedido_bien($usuario, $no_pedido);
            }
            return 1;
        }
    }

    public function ver_editar_cotizador($id){
        $lista = Bien::listar_cotizadores();
        $id_cotizador = $id;
        $html = '';
        if(count($lista)>0){
            foreach($lista as $val){
                if ($val->ida == $id_cotizador) {
                    $html.="<option value='$val->ida'>".$val->gradoa." ".$val->nombresa." ".$val->apell_pata." ".$val->apell_mata."</option>";
                }
                
            }

            foreach($lista as $val){
                if ($val->ida != $id_cotizador) {
                    $html.="<option value='$val->ida'>".$val->gradoa." ".$val->nombresa." ".$val->apell_pata." ".$val->apell_mata."</option>";
                }
                
            }
        }
        return $html;
    }

    public function ver_imprimir_pedido(){
        $usuario = session('usuario');
        $html = "";
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedido'];
            /*$html = "http://localhost:8081/pentaho/api/repos/%3Apublic%3ASteel%20Wheels%3AReports%3Apresupuesto.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=".$no_pedido;*/
            $html = "https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3Apresupuesto.prpt/generatedContent?userid=user&password=password&output-target=pageable%2Fpdf&no_pedidoe=".$no_pedido;
           
            /*https://repped.uatf.edu.bo/pentaho/api/repos/%3Apublic%3Apedidos%3A*/
            return $html;
        }
    }

}
