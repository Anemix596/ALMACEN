<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Solicitante;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;

class PresupuestoController extends Controller
{

    public function ver_lista_pedido_pendiente(){
        $vector = Array();
        $bandera = 1;
        $consulta = Presupuesto::listar_pedidos_pendientes();
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $fecha = explode("-", $val->fecha_pedido);
                $vector[] = array(
                    "valor" => '3',
                    "numero" => $bandera,
                    "no_pedido" => $val->no_pedido,
                    "fecha_pedido" => $fecha[2]."/".$fecha[1]."/".$fecha[0],
                    "unidad" => $val->unidad_solicitante,
                    "responsable" => $val->grado." ".$val->nombres." ".$val->apell_pat." ".$val->apell_mat,
                    "motivo" => $val->motivo,
                    "estado" => ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO")),
                    "usuario" =>$val->usuario,
                    "observacion" => ($val->obs != "A"?"HABILITADO":"ANULADO"),
                    "fuente_fnto" => ($val->fuente_fnto != null?"ASIGNADO":"NO ASIGNADO"),
                    "estado_aprob" => ($val->estado_aprob == "P"?"PENDIENTE":($val->estado_aprob == "A"?"APROBADO":"RECHAZADO")),
                    
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function ver_lista_pedido_articulo_pendiente(){
        $vector = Array();
        $bandera = 1;
        $no_pedido = $_POST['no'];
        $consulta = Presupuesto::listar_pedidos_articulos_pendientes($no_pedido);
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $presup = Presupuesto::obtener_cod_presup($val->id);
                foreach($presup as $val2){
                    $codigo = $val2->cod_presup;
                }
                $vector[] = array(
                    "valor" => '4',
                    "numero" => $bandera,
                    "id" => $val->id,
                    "fecha_pedido" => $val->fecha_pedido,
                    "unidad" => $val->unidad_solicitante,
                    "responsable" => $val->grado." ".$val->nombres." ".$val->apell_pat." ".$val->apell_mat,
                    "motivo" => $val->motivo,
                    "articulo" => $val->articulo,
                    "unidad_medida" => $val->unidad_medida,
                    "descripcion" => $val->descripcion,
                    "cantidad" => $val->cantidad,
                    "estado" => ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO")),
                    "usuario" =>$val->usuario,
                    "archivo" => ($val->archivo!=null?$val->archivo:"VACIO"),
                    "observacion" => ($val->obs != "A"?"HABILITADO":"ANULADO"),
                    "no_pedido" => $val->no_pedido,
                    "estado_cod" => ($val->estado_cod == "C"?"CODIFICADO":"PENDIENTE"),
                    "estado_articulo" =>($val->estado_art == "P"?"PENDIENTE":($val->estado_art == "A"?"APROBADO":"RECHAZADO")),
                    "cod_presup" => $codigo,
                );
                $bandera++;
            }
            return Datatables::of($vector)->addColumn('boton', 'botones.btn_buscar')->rawColumns(['boton'])->toJson(); 
            
        }
        return Datatables::of($vector)->toJson();
        
    }

    public function ver_lista_pedido_articulo_pendiente_observacion(){
        $vector = Array();
        $no_pedido = $_POST['no'];
        $consulta = Presupuesto::listar_pedidos_articulos_pendientes($no_pedido);
        if(count($consulta) > 0){
            foreach($consulta as $val){
                $vector[0] = $val->motivo_rechazo;
                $vector[1] = $val->no_pedido;
                $vector[2] = ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO"));
            }
        }
        return $vector;
        
    }

    public function recuperar_organo(){
        $lista = Presupuesto::listar_organo();
        $html = '';
        if(count($lista)>0){
            $html.="<option value='' disabled selected>".'Seleccionar Organo'."</option>";
            foreach($lista as $val){
                $html.="<option value='$val->id'>".$val->codigo." ".$val->descrip."</option>";
            }
        }
        return $html;
    }

    public function recuperar_fuente(){
        $lista = Presupuesto::listar_fuente();
        $html = '';
        if(count($lista)>0){
            $html.="<option value='' disabled selected>".'Seleccionar Fuente'."</option>";
            foreach($lista as $val){
                $html.="<option value='$val->id'>".$val->codigo." ".$val->descrip."</option>";
            }
        }
        return $html;
    }

    public function recuperar_presupuesto(){
        $lista = Presupuesto::listar_presupuesto();
        $html = '';
        if(count($lista)>0){
            $html.="<option value='' disabled selected>".'Seleccionar Presupuesto'."</option>";
            foreach($lista as $val){
                $html.="<option value='$val->id'>".$val->codigo." ".$val->descrip."</option>";
            }
        }
        return $html;
    }

    public function valor_fuente(){
        $id = $_POST['id_fuente'];
        $lista = Presupuesto::buscar_fuente($id);
        $vector = array();
        foreach($lista as $val){
            $vector[0] = $val->id;
            $vector[1] = $val->codigo;
            $vector[2] = $val->descrip;
            $vector[3] = $val->sigla;
            $vector[4] = $val->gestion;
            $vector[5] = $val->estado;
        }
        return $vector;
    }

    public function valor_organo(){
        $id = $_POST['id_organo'];
        $lista = Presupuesto::buscar_organo($id);
        $vector = array();
        foreach($lista as $val){
            $vector[0] = $val->id;
            $vector[1] = $val->codigo;
            $vector[2] = $val->descrip;
            $vector[3] = $val->tipo_org;
            $vector[4] = $val->sigla;
            $vector[5] = $val->gestion;
            $vector[6] = $val->estado;
        }
        return $vector;
    }

    public function valor_presupuesto(){
        $id = $_POST['id_presupuesto'];
        $lista = Presupuesto::buscar_presupuesto($id);
        $vector = array();
        foreach($lista as $val){
            $vector[0] = $val->id;
            $vector[1] = $val->codigo;
            $vector[2] = $val->descrip;
            $vector[3] = $val->desc_larga;
            $vector[4] = $val->cod_soe;
            $vector[5] = $val->gestion;
            $vector[6] = $val->estado;
        }
        return $vector;
    }

    public function asignar_presupuesto_articulo(){
        $estado = $_POST['estado'];
        $id = $_POST['id'];
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedido'];
            $contar = Presupuesto::verificar_cantidad_articulo_pedido($no_pedido);
            foreach($contar as $val){
                $total = $val->verificar_cantidad_articulo_pedido;
            }
            if($contar){
                if ($estado == "A") {
                    $cant_pedida = $_POST['cant_ped'];
                    $cantidad = $_POST['cantidad'];
                    $presupuesto = $_POST['presupuesto'];
                    
                    if($cantidad <= $cant_pedida && $cantidad != 0){
                        $actualizar = Presupuesto::actualizar_pedido_presupuesto_aprobado($usuario, $cantidad, $presupuesto, $id);
                        if($actualizar){
                            $codificar = Presupuesto::verificar_articulo_pedido_codificado($no_pedido);
                            if($codificar){
                                foreach($codificar as $val){
                                    $total_cod = $val->verificar_articulo_pedido_codificado;
                                }

                                if($total == $total_cod){
                                    $aprobado = Presupuesto::verificar_articulo_pedido_codificado_aprobado($no_pedido);
                                    $rechazado = Presupuesto::verificar_articulo_pedido_codificado_rechazado($no_pedido);
                                    foreach($aprobado as $val){
                                        $aprob = $val->verificar_articulo_pedido_codificado_aprobado;
                                    }
                                    foreach($rechazado as $val){
                                        $rech = $val->verificar_articulo_pedido_codificado_rechazado;
                                    }
                                    
                                    if($rech == 0){
                                        if($aprob > 0 && $total_cod == $aprob){
                                            $valor = 1;
                                            $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                            return 1;
                                        }
                                        else{
                                            $valor = 3;
                                            $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                            if($total == $rech){
                                                $rechazar = Presupuesto::actualizar_estado_aprobado($no_pedido, $usuario);
                                            }
                                            return 1;
                                        }
                                    }
                                    else return 1;
                                }
                                else return 1;
                            }
                        }
                        else{
                            return 2;
                        }
                    }
                    else{
                        return 0;;
                    }
                } 

                if($estado == "B") {
                    $actualizar = Presupuesto::actualizar_pedido_presupuesto_rechazado($usuario, $id);
                    if($actualizar){
                        $codificar = Presupuesto::verificar_articulo_pedido_codificado($no_pedido);
                        if($codificar){
                            foreach($codificar as $val){
                                $total_cod = $val->verificar_articulo_pedido_codificado;
                            }
                            if($total > 0){
                                $aprobado = Presupuesto::verificar_articulo_pedido_codificado_aprobado($no_pedido);
                                $rechazado = Presupuesto::verificar_articulo_pedido_codificado_rechazado($no_pedido);
                                foreach($aprobado as $val){
                                    $aprob = $val->verificar_articulo_pedido_codificado_aprobado;
                                }
                                foreach($rechazado as $val){
                                    $rech = $val->verificar_articulo_pedido_codificado_rechazado;
                                }

                                if($rech > 0){
                                    $valor = 2;
                                    return 4;
                                    
                                }
                                else{
                                    $valor = 1;
                                    $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                    return 1;
                                }
                            }
                            else return 4;
                        }
                    }
                    else{
                        return 2;
                    }
                }
            }
            else return 2;
        }
        
    }

    public function editar_presupuesto_articulo(){
        $estado = $_POST['eestado'];
        $id = $_POST['eid'];
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['eno_pedido'];
            $contar = Presupuesto::verificar_cantidad_articulo_pedido($no_pedido);
            
            if($contar){
                foreach($contar as $val){
                    $total = $val->verificar_cantidad_articulo_pedido;
                }
                if ($estado == "A") {
                    $cant_pedida = $_POST['ecant_ped'];
                    $cantidad = $_POST['ecantidad'];
                    $presupuesto = $_POST['epresupuesto'];
                    
                    if($cantidad <= $cant_pedida && $cantidad != 0){
                        $actualizar = Presupuesto::actualizar_pedido_presupuesto_aprobado($usuario, $cantidad, $presupuesto, $id);
                        if($actualizar){
                            $codificar = Presupuesto::verificar_articulo_pedido_codificado($no_pedido);
                            if($codificar){
                                foreach($codificar as $val){
                                    $total_cod = $val->verificar_articulo_pedido_codificado;
                                }
                                if($total == $total_cod){
                                    $aprobado = Presupuesto::verificar_articulo_pedido_codificado_aprobado($no_pedido);
                                    $rechazado = Presupuesto::verificar_articulo_pedido_codificado_rechazado($no_pedido);
                                    foreach($aprobado as $val){
                                        $aprob = $val->verificar_articulo_pedido_codificado_aprobado;
                                    }
                                    foreach($rechazado as $val){
                                        $rech = $val->verificar_articulo_pedido_codificado_rechazado;
                                    }
                                    
                                    if($rech == 0){
                                        if($aprob > 0 && $total_cod == $aprob){
                                            $valor = 1;
                                            $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                            return 1;
                                        }
                                        else{
                                            $valor = 3;
                                            $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                            if($total == $rech){
                                                $rechazar = Presupuesto::actualizar_estado_aprobado($no_pedido, $usuario);
                                            }
                                            return 1;
                                        }
                                    }
                                    else return 1;
                                }
                                else return 1;
                            }
                        }
                        else{
                            return 2;
                        }
                    }
                    else{
                        return 0;;
                    }
                } 

                if($estado == "B") {
                    $actualizar = Presupuesto::actualizar_pedido_presupuesto_rechazado($usuario, $id);
                    if($actualizar){
                        $codificar = Presupuesto::verificar_articulo_pedido_codificado($no_pedido);
                        if($codificar){
                            foreach($codificar as $val){
                                $total_cod = $val->verificar_articulo_pedido_codificado;
                            }
                            if($total > 0){
                                $aprobado = Presupuesto::verificar_articulo_pedido_codificado_aprobado($no_pedido);
                                $rechazado = Presupuesto::verificar_articulo_pedido_codificado_rechazado($no_pedido);
                                foreach($aprobado as $val){
                                    $aprob = $val->verificar_articulo_pedido_codificado_aprobado;
                                }
                                foreach($rechazado as $val){
                                    $rech = $val->verificar_articulo_pedido_codificado_rechazado;
                                }

                                if($rech > 0){
                                    $valor = 3;
                                    $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                    
                                    return 4;
                                    
                                }
                                else{
                                    $valor = 1;
                                    $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                    return 1;
                                }
                            }
                            else return 4;
                        }
                    }
                    else{
                        return 2;
                    }
                }
            }
            else return 2;
        }
        
    }

    public function editar_estado_presupuesto_articulo(){
        $estado = $_POST['pestado'];
        $id = $_POST['pid'];
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['pno_pedido'];
            $contar = Presupuesto::verificar_cantidad_articulo_pedido($no_pedido);
            foreach($contar as $val){
                $total = $val->verificar_cantidad_articulo_pedido;
            }
            if($contar){
                if ($estado == "A") {
                    $cant_pedida = $_POST['pcant_ped'];
                    $cantidad = $_POST['pcantidad'];
                    $presupuesto = $_POST['ppresupuesto'];
                    
                    if($cantidad <= $cant_pedida){
                        $actualizar = Presupuesto::actualizar_pedido_presupuesto_aprobado($usuario, $cantidad, $presupuesto, $id);
                        if($actualizar){
                            $codificar = Presupuesto::verificar_articulo_pedido_codificado($no_pedido);
                            if($codificar){
                                foreach($codificar as $val){
                                    $total_cod = $val->verificar_articulo_pedido_codificado;
                                }
                                if($total == $total_cod){
                                    $aprobado = Presupuesto::verificar_articulo_pedido_codificado_aprobado($no_pedido);
                                    $rechazado = Presupuesto::verificar_articulo_pedido_codificado_rechazado($no_pedido);
                                    foreach($aprobado as $val){
                                        $aprob = $val->verificar_articulo_pedido_codificado_aprobado;
                                    }
                                    foreach($rechazado as $val){
                                        $rech = $val->verificar_articulo_pedido_codificado_rechazado;
                                    }
                                    
                                    if($aprob > 0 && $total_cod == $aprob){
                                        $valor = 1;
                                        $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                        return 1;
                                    }
                                    else{
                                        $valor = 3;
                                        $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                        if($total == $rech){
                                            $rechazar = Presupuesto::actualizar_estado_aprobado($no_pedido, $usuario);
                                        }
                                        return 1;
                                    }
                                }
                                else return 1;
                            }
                        }
                        else{
                            return 2;
                        }
                    }
                    else{
                        return 0;;
                    }
                } 

                if($estado == "B") {
                    $actualizar = Presupuesto::actualizar_pedido_presupuesto_rechazado($usuario, $id);
                    if($actualizar){
                        $codificar = Presupuesto::verificar_articulo_pedido_codificado($no_pedido);
                        if($codificar){
                            foreach($codificar as $val){
                                $total_cod = $val->verificar_articulo_pedido_codificado;
                            }
                            if($total > 0){
                                $aprobado = Presupuesto::verificar_articulo_pedido_codificado_aprobado($no_pedido);
                                $rechazado = Presupuesto::verificar_articulo_pedido_codificado_rechazado($no_pedido);
                                foreach($aprobado as $val){
                                    $aprob = $val->verificar_articulo_pedido_codificado_aprobado;
                                }
                                foreach($rechazado as $val){
                                    $rech = $val->verificar_articulo_pedido_codificado_rechazado;
                                }

                                if($rech > 0){
                                    $valor = 3;
                                    $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                    
                                    return 4;
                                    
                                }
                                else{
                                    $valor = 1;
                                    $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                                    return 1;
                                }
                            }
                            else return 4;
                        }
                    }
                    else{
                        return 2;
                    }
                }
            }
            else return 2;
        }
        
    }

    public function anular_pedido_presupuesto(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no'];
            $observacion = $_POST['obs'];
            if(!ctype_alpha(substr($observacion, 0, 1))){
                return 3;
            }
            if($observacion != ''){
                $actualizar = Presupuesto::actualizar_observacion_rechazo($no_pedido, $observacion, $usuario);
                $valor = 2;
                $act_estado = Presupuesto::actualizar_estado_pedido($no_pedido, $valor, $usuario);
                return 1;
            }
            else return 2;
        }
        
    }

    public function ver_editar_pedido_presupuesto(){
        $id = $_POST['id'];
        $lista = Presupuesto::buscar_pedido_articulo($id);
        $vector = array();
        foreach($lista as $val){
            $vector[0] = $val->id;
            $vector[1] = $val->estado;
            $vector[2] = $val->fuente;
            $vector[3] = $val->organo;
            $vector[4] = $val->fuente_fnto;
            $vector[5] = $val->presupuesto;
            $vector[6] = $val->cant_ped;
            $vector[7] = $val->cant_aprob;
            $vector[8] = $val->no_pedido;
        }
        return $vector;
    }

    public function ver_editar_pedido_fuente(){
        $lista = Presupuesto::listar_fuente();
        $id_fuente = $_POST['id_fuente'];
        $html = '';
        if(count($lista)>0){
            foreach($lista as $val){
                if ($val->id == $id_fuente) {
                    $html.="<option value='".$val->id."'>".$val->codigo." ".$val->descrip."</option>";
                }
                
            }

            foreach($lista as $val){
                if ($val->id != $id_fuente) {
                    $html.="<option value='".$val->id."'>".$val->codigo." ".$val->descrip."</option>";
                }
                
            }
        }
        return $html;
    }

    public function ver_editar_pedido_organo(){
        $lista = Presupuesto::listar_organo();
        $id_organo = $_POST['id_organo'];
        $html = '';
        if(count($lista)>0){
            foreach($lista as $val){
                if ($val->id == $id_organo) {
                    $html.="<option value='".$val->id."'>".$val->codigo." ".$val->descrip."</option>";
                }
                
            }

            foreach($lista as $val){
                if ($val->id != $id_organo) {
                    $html.="<option value='".$val->id."'>".$val->codigo." ".$val->descrip."</option>";
                }
                
            }
        }
        return $html;
    }

    public function ver_listar_pedido_presupuesto(){
        $lista = Presupuesto::listar_presupuesto();
        $id_presupuesto = $_POST['id_presupuesto'];
        $html = '';
        if(count($lista)>0){
            foreach($lista as $val){
                if ($val->id == $id_presupuesto) {
                    $html.="<option value='".$val->id."'>".$val->codigo." ".$val->descrip."</option>";
                }
                
            }

            foreach($lista as $val){
                if ($val->id != $id_presupuesto) {
                    $html.="<option value='".$val->id."'>".$val->codigo." ".$val->descrip."</option>";
                }
                
            }
        }
        return $html;
    }

    public function ver_editar_fuente_fnto_pedido(){
        $no = $_POST['no'];
        $lista = Presupuesto::buscar_fuentefnto_pedido($no);
        $vector = array();
        foreach($lista as $val){
            $vector[0] = $val->fuente_fnto;
            $vector[1] = $val->no_pedido;
            $vector[2] = $val->fuente;
            $vector[3] = $val->organo;
        }
        return $vector;
    }

    public function asignar_fuente_fnto_pedido(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedidof'];
            $fuente = $_POST['fuente'];
            $organo = $_POST['organo'];
            $consulta = Presupuesto::fuente_organo($fuente, $organo);
            foreach($consulta as $val){
                $fuente_fnto = $val->fuente_organo;
            }

            $actualizar = Presupuesto::actualizar_fuente_fnto($no_pedido, $fuente, $organo, $fuente_fnto, $usuario);
            if($actualizar){
                return [1, $no_pedido];
            }
            else return 0;
        }
        
    }

    public function editar_fuente_fnto_pedido(){
        $usuario = session('id');
        if(!empty($usuario)){
            $no_pedido = $_POST['no_pedidofe'];
            $fuente = $_POST['efuente'];
            $organo = $_POST['eorgano'];
            $consulta = Presupuesto::fuente_organo($fuente, $organo);
            foreach($consulta as $val){
                $fuente_fnto = $val->fuente_organo;
            }
            $actualizar = Presupuesto::actualizar_fuente_fnto($no_pedido, $fuente, $organo, $fuente_fnto, $usuario);
            if($actualizar){
                return [1, $no_pedido];
            }
            else return 0;
        }
        
    }

    public function lista_pedido_pendiente_valor(){
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
            $consulta = Presupuesto::listar_pedidos_valor($valor1, $valor2, $valor3);
            if(count($consulta) > 0){
                foreach($consulta as $val){
                    $fecha = explode("-", $val->fecha_pedido);
                    $vector[] = array(
                        "valor" => '3',
                        "numero" => $bandera,
                        "no_pedido" => $val->no_pedido,
                        "fecha_pedido" => $fecha[2]."/".$fecha[1]."/".$fecha[0],
                        "unidad" => $val->unidad_solicitante,
                        "responsable" => $val->grado." ".$val->nombres." ".$val->apell_pat." ".$val->apell_mat,
                        "motivo" => $val->motivo,
                        "estado" => ($val->estado == "P"?"PENDIENTE":($val->estado == "A"?"APROBADO":"RECHAZADO")),
                        "usuario" =>$val->usuario,
                        "observacion" => ($val->obs != "A"?"HABILITADO":"ANULADO"),
                        "fuente_fnto" => ($val->fuente_fnto != null?"ASIGNADO":"NO ASIGNADO"),
                        "estado_aprob" => ($val->estado_aprob == "P"?"PENDIENTE":($val->estado_aprob == "A"?"APROBADO":"RECHAZADO")),
                        
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

}
