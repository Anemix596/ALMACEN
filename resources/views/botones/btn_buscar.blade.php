@switch($valor)
    
    @case(1) 
        <div class="form-inline">
            <abbr title="Mostrar Artículos">
                <button onclick="ver('{{$no_pedido}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-without-animation">
                    <i class="far fa-eye"></i>
                </button>&nbsp;
            </abbr>
            @if ($observacion == "HABILITADO")
                <abbr title="Ver PDF Pedido de Materiales">
                    <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
        </div>
        @break
    @case(2) 
        <div class="form-inline">
            @if ($estado == "PENDIENTE" && $observacion == "HABILITADO" && $cant_codif == 0)
                @if ($archivo != "VACIO")
                    <abbr title="Eliminar Archivo">
                        <button onclick="eliminar_archivo('{{$id}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-alert2">
                        <i class="fas fa-file-pdf"></i> &nbsp;<i class="fas fa-trash"></i>
                    </button>&nbsp;</abbr>
                @endif
                <abbr title="Editar Pedido">
                    <button onclick="editar('{{$id}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-dialog2">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
                
                <abbr title="Eliminar Pedido">
                    <button onclick="eliminar('{{$id}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-alert">
                        <i class="fas fa-trash"></i>
                    </button>&nbsp;
                </abbr>
            @endif
        </div>
        @break
    
    @case(3) 
        <div class="form-inline">
          @if ($estado == "PENDIENTE")
                @if ($fuente_fnto == "NO ASIGNADO")
                <abbr title="Asignar Fuente de Financimiento">
                    <button onclick="enviarf('{{$no_pedido}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-dialog5">
                        <i class="far fa-money-bill-alt"></i>
                    </button>&nbsp;
                </abbr>
                @endif

                @if ($fuente_fnto == "ASIGNADO")
                <abbr title="Editar Fuente de Financimiento">
                    <button onclick="editarf('{{$no_pedido}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-dialog6">
                        <i class="far fa-money-bill-alt"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Mostrar Artículos">
                    <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Ver PDF Pedido de Materiales">
                    <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
                @endif

          @endif

            @if ($estado != "PENDIENTE")
            <abbr title="Mostrar Artículos">
                <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                    <i class="far fa-eye"></i>
                </button>&nbsp;
            </abbr>
            <abbr title="Ver PDF Pedido de Materiales">
                <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                    <i class="fas fa-file-pdf"></i>
                </button>&nbsp;
            </abbr>
            @endif
        </div>
        @break
    @case(4) 
        <div class="form-inline">
            @if ($estado == "PENDIENTE" && $observacion == "HABILITADO")
               @if ($estado_articulo == "PENDIENTE")
                <abbr title="Asignar Presupuesto al Artículo">
                    <button onclick="enviar('{{$id}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-dialog2">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
               @endif
               @if ($estado_articulo == "APROBADO")
                <abbr title="Editar Presupuesto del Artículo">
                    <button onclick="editar('{{$id}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-dialog3">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
               @endif
               @if ($estado_articulo == "RECHAZADO")
                <abbr title="Cambiar Estado del Artículo">
                    <button onclick="editar_estado('{{$id}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-dialog4">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
               @endif
            @endif
        </div>
        @break
    
    @case(5) 
        <div class="form-inline">
           
           @if ($estado == "PENDIENTE")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            @if ($estado == "RECHAZADO")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver2('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            @if ($estado == "APROBADO")
                <abbr title="Mostrar Artículos">
                    <button onclick="editar('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            <abbr title="Ver PDF Pedido de Materiales">
                <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                    <i class="fas fa-file-pdf"></i>
                </button>&nbsp;
            </abbr>
        </div>
        @break
    @case(6) 
        <div class="form-inline">
           @if ($estado_art_aprob == "PENDIENTE")
            <input type="text" size="5" name="cant_aprob[]" value="{{$cant_aprob}}" onkeypress="return solo_numeros(event)" required>
            <input type="hidden" size="1" name="valor_id[]" value="{{$id}}" required>
            <input type="hidden" name="valor_id2[]" value="{{$cantidad}}" required>
            <input type="hidden" name="no_pedido" value="{{$no_pedido}}" required>
           @endif

           @if ($estado_art_aprob != "PENDIENTE")
            <input type="text" size="5" name="ecant_aprob[]" value="{{$cant_aprob}}" onkeypress="return solo_numeros(event)" required>
            <input type="hidden" size="1" name="evalor_id[]" value="{{$id}}" required>
            <input type="hidden" name="evalor_id2[]" value="{{$cantidad}}" required>
            <input type="hidden" name="eno_pedido" value="{{$no_pedido}}" required>
           @endif
        </div>
        @break
    
    @case(7) 
        <div class="form-inline">
          @if ($est_almacen == "PENDIENTE")
                @if ($estado == "PENDIENTE")
                    <abbr title="Mostrar Artículos">
                        <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                            <i class="far fa-eye"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
                @if ($estado == "ASIGNADO")
                    <abbr title="Mostrar Artículos">
                        <button onclick="editar('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                            <i class="far fa-eye"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
          @endif

         @if ($est_almacen != "PENDIENTE")
            <abbr title="Mostrar Artículos">
                <button onclick="ver3('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                    <i class="far fa-eye"></i>
                </button>&nbsp;
            </abbr>
         @endif
            
            <abbr title="Ver PDF Pedido de Maeriales">
                <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                    <i class="fas fa-file-pdf"></i>
                </button>&nbsp;
            </abbr>
        </div>
        @break
    @case(8) 
        <div class="form-inline">
           @if ($estado_asign == "PENDIENTE")
            <input type="hidden" name="no_pedido" value="{{$no_pedido}}" required>
            <input type="hidden" name="valor_id[]" value="{{$id}}" required>
            <select id="valor" name="valor[]" class="form-control" data-size="10" data-live-search="true" required>
                @php
                echo $lista_cot;
                @endphp                                                                           
            </select>
           @endif

           @if ($estado_asign == "ASIGNADO")
            <input type="hidden" name="eno_pedido" value="{{$no_pedido}}" required>
            <input type="hidden" name="evalor_id[]" value="{{$id}}" required>
            <select id="evalor" name="evalor[]" class="form-control" data-size="10" data-live-search="true">
                @php
                    echo $editar_cot;
                @endphp                                                                           
            </select>
           @endif
        </div>
        @break
    
    @case(9) 
        <div class="form-inline">
            @if ($estado == "PENDIENTE")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Ver PDF Pedido de Materiales">
                    <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            @if ($estado == "ASIGNADO")
                <abbr title="Mostrar Artículos">
                    <button onclick="editar('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Ver PDF Pedido de Materiales">
                    <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Ver PDF Solicitud de Compra">
                    <button onclick="imprimir_solicitud('{{$no_pedido}}')" class="btn btn-danger" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            @if ($estado == "RECHAZADO")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver2('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Ver PDF Pedido de Materiales">
                    <button onclick="imprimir_pedido('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
        </div>
        @break
    @case(10) 
        <div class="form-inline">
            @if ($estado_alm == "PENDIENTE")
            <input type="hidden" size="1" name="valor_id[]" value="{{$id}}" required>
            <input type="hidden" name="no_pedido" value="{{$no_pedido}}" required>
            <input type="hidden" name="id_pedido" value="{{$id_pedido}}" required>
            <input type="hidden" name="motivo" value="{{$motivo}}" required>
            <input type="hidden" name="responsable" value="{{$responsable}}" required>
            <input type="hidden" name="cant[]" value="{{$cantidad}}" required>
            <input type="hidden" name="cant_disp[]" value="{{$disponible}}" required>
            <input type="hidden" name="cant_apro[]" value="{{$cant_aprob}}" required>
            <input type="hidden" name="articulo[]" value="{{$articulo}}" required>
            <input type="hidden" name="id_articulo[]" value="{{$id_articulo}}" required>
            <input type="text" size="3" name="cantidad[]" value="{{$cant_aprob}}" required>
            {{-- <label for="">{{$cant_aprob}}</label> --}}
            @endif

            @if ($estado_alm != "PENDIENTE")
            <input type="hidden" size="1" name="evalor_id[]" value="{{$id}}" required>
            <input type="hidden" name="eno_pedido" value="{{$no_pedido}}" required>
            <input type="hidden" name="eid_pedido" value="{{$id_pedido}}" required>
            <input type="hidden" name="emotivo" value="{{$motivo}}" required>
            <input type="hidden" name="eresponsable" value="{{$responsable}}" required>
            <input type="hidden" name="ecant[]" value="{{$cantidad}}" required>
            <input type="hidden" name="edescrip[]" value="{{$descrip}}" required>
            <input type="hidden" name="ecant_ped[]" value="{{$cantidad}}" required>
            <input type="hidden" name="ecant_apro[]" value="{{$cant_aprob}}" required>
            <input type="hidden" name="ecant_disp[]" value="{{$disponible}}" required>
            <input type="hidden" name="earticulo[]" value="{{$articulo}}" required>
            <input type="hidden" name="eid_articulo[]" value="{{$id_articulo}}" required>
            <label for="">{{$cant_aprob}}</label>
            @endif
        </div>
        @break
    
    @case(11) 
        <div class="form-inline">
           @if ($estado_cot == "PENDIENTE")
                 @if ($estado == "PENDIENTE")
                    <abbr title="Mostrar Artículos">
                        <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                            <i class="far fa-eye"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
                @if ($estado == "APROBADO")
                    <abbr title="Mostrar Artículos">
                        <button onclick="editar('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                            <i class="far fa-eye"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
           @endif

           @if ($estado_cot == "APROBADO")
                @if ($estado == "APROBADO")
                    <abbr title="Mostrar Artículos">
                        <button onclick="ver2('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                            <i class="far fa-eye"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
           @endif
           

           <abbr title="Ver PDF Solicitud de Compra">
                <button onclick="imprimir_solicitud('{{$no_pedido}}')" class="btn btn-danger" data-toggle="modal" data-target="">
                    <i class="fas fa-file-pdf"></i>
                </button>&nbsp;
            </abbr>
        </div>
        @break
    @case(12) 
        <div class="form-inline">
            @if ($estado == "PENDIENTE")
                <input type="hidden" name="valor_id" value="{{$id}}" required>
                <label for="">{{$cantidad}}</label>
            @endif
            
            @if ($estado == "APROBADO")
                <input type="hidden" name="evalor_id" value="{{$id}}" required>
                <label for="">{{$cantidad}}</label>
            @endif
            
        </div>
        @break
    @case(13) 
        <div class="form-inline">
            @if ($estado == "PENDIENTE")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            @if ($estado == "EDICION")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver3('{{$no_pedido}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
                
                <abbr title="Ver PDF Solicitud de Cotización">
                    <button onclick="imprimir_solicitud_cotizacion('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            @if ($estado == "APROBADO")
                <abbr title="Mostrar Artículos">
                    <button onclick="ver2('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
                
                <abbr title="Ver PDF Solicitud de Cotización">
                    <button onclick="imprimir_solicitud_cotizacion('{{$no_pedido}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            
        </div>
        @break
    @case(14) 
        <div class="form-inline">
            <input type="hidden" name="no_solicitud" id="no_solicitud" value="{{$no_solicitud}}">
            <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{$id_solicitud}}">
            <input type="hidden" name="id_sol_det[]" id="id_sol_det" value="{{$id}}">
            <input type="hidden" name="id_articulo[]" id="id_articulo" value="{{$id_articulo}}">
            <label for="">{{$cantidad}}</label>
        </div>
        @break
    @case(15) 
        <div class="form-inline">
               @if ($cantidad < 3)
                <abbr title="Mostrar Artículos">
                    <button onclick="ver3('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
               @endif
               @if ($cantidad == 3)
                   @if ($est_gen == "PENDIENTE")
                        <abbr title="Editar Primera Cotización">
                            <button onclick="editar('{{$no_pedido}}', '{{$id_solicitud}}', 1)" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>

                        <abbr title="Editar Segunda Cotización">
                            <button onclick="editar('{{$no_pedido}}', '{{$id_solicitud}}', 2)" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>

                        <abbr title="Editar Tercera Cotización">
                            <button onclick="editar('{{$no_pedido}}', '{{$id_solicitud}}', 3)" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>
                   @endif

                   @if ($est_gen != "PENDIENTE")
                        <abbr title="Ver Primera Cotización">
                            <button onclick="editar2('{{$no_pedido}}', '{{$id_solicitud}}', 1)" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>

                        <abbr title="Ver Segunda Cotización">
                            <button onclick="editar2('{{$no_pedido}}', '{{$id_solicitud}}', 2)" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>

                        <abbr title="Ver Tercera Cotización">
                            <button onclick="editar2('{{$no_pedido}}', '{{$id_solicitud}}', 3)" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>
                   @endif
               @endif
        </div>
        @break
    @case(16) 
        <div class="form-inline">
            <input type="hidden" name="no_pedido" id="no_pedido" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2" id="fecha2" value="{{$fecha2}}">
            <input type="hidden" name="id_sol_det[]" id="id_sol_det" value="{{$id}}">
            <input type="hidden" name="id_cot[]" id="id_cot" value="{{$id_cot}}">
            <input type="hidden" name="cantidad[]" id="cantidad" value="{{$cantidad}}">
            <input type="hidden" name="id_articulo[]" id="id_articulo" value="{{$id_articulo}}">
            <input type="text" name="preciou[]" id="preciou" value="0.00" onkeypress="return solo_numeros_precio(event)" required>
        </div>
        @break
    @case(17) 
        <div class="form-inline">
            <input type="hidden" name="no_pedidoe" id="no_pedidoe" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitude" id="id_solicitude" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2e" id="fecha2e" value="{{$fecha}}">
            <input type="hidden" name="id_sol_dete[]" id="id_sol_dete" value="{{$id}}">
            <input type="hidden" name="id_cote[]" id="id_cote" value="{{$id_cot}}">
            <input type="hidden" name="cantidade[]" id="cantidade" value="{{$cantidad}}">
            <input type="text" name="precioue[]" id="precioue" value="{{$precio}}" onkeypress="return solo_numeros_precio(event)">
        </div>
        @break
    @case(18) 
        <div class="form-inline">
            <abbr title="Mostrar Artículos">
                <a onclick="ver_articulos('{{$orden}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation6" href="#"><i class="far fa-eye"></i></a>&nbsp;
            </abbr>

           @if ($estado != "APROBADO")
                @if ($tiempo > 15)
                    @if ($archivo == "VACIO")
                        <abbr title="Generar Contrato">
                            <a onclick="ver_contrato('{{$orden}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-without-animation8" href="#"><i class="far fa-list-alt"></i></a>&nbsp;
                        </abbr>
                    @endif
                    @if ($archivo != "VACIO")
                        <abbr title="Actualizar Contrato">
                            <a onclick="ver_contrato('{{$orden}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation8" href="#"><i class="far fa-list-alt"></i></a>&nbsp;
                        </abbr>
                        <abbr title="Anular Contrato">
                            <a onclick="ver_contrato2('{{$orden}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-without-animation9" href="#"><i class="far fa-list-alt"></i></a>&nbsp;
                        </abbr>
                        <abbr title="Ver PDF Contrato Digitalizado">
                            <a href="{{$archivo}}" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;
                        </abbr>
                    @endif
                @endif
           @endif

           @if ($estado == "APROBADO")
                @if ($tiempo > 15)
                    @if ($archivo != "VACIO")
                        <abbr title="Actualizar Contrato">
                            <a onclick="ver_contrato3('{{$orden}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation8" href="#"><i class="far fa-list-alt"></i></a>&nbsp;
                        </abbr>
                        <abbr title="Ver PDF Contrato Digitalizado">
                            <a href="{{$archivo}}" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;
                        </abbr>
                    @endif
                @endif
           @endif
        </div>
        @break
    @case(19) 
        <div class="form-inline">
            <label for="">{{$importe}}</label>
            <input type="hidden" name="id_solicitud" value="{{$id_solicitud}}">
            <input type="hidden" name="id_prov" value="{{$id_prov}}">
            <input type="hidden" name="id_soldet[]" value="{{$id_soldet}}">
            <input type="hidden" name="orden" value="{{$orden}}">
        </div>
        @break
    @case(20) 
        <div class="form-inline">
        </div>
        @break
    @case(21) 
        <div class="form-inline">
           @if ($estado == "PENDIENTE")
                <abbr title="Mostrar Artículos de la Orden">
                    <button onclick="ver('{{$orden}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
           @endif

          @if ($estado_rec == "PENDIENTE")
                @if ($estado == "APROBADO")
                    <abbr title="Mostrar Artículos de la Orden">
                        <button onclick="ver2('{{$orden}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation2">
                            <i class="far fa-edit"></i>
                        </button>&nbsp;
                    </abbr>

                    <abbr title="Ver PDF Nota de Recepción">
                        <button onclick="imprimir_nota_recepcion('{{$orden}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                            <i class="fas fa-file-pdf"></i>
                        </button>&nbsp;
                    </abbr>

                    <abbr title="Finalizar Nota de Recepción">
                        <button onclick="ver3('{{$orden}}', '{{$valor_ord}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-without-animation3">
                            <i class="far fa-edit"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
          @endif

          @if ($estado_rec == "APROBADO")
                @if ($estado == "APROBADO")
                    <abbr title="Mostrar Artículos de la Orden">
                        <button onclick="ver4('{{$orden}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                            <i class="far fa-edit"></i>
                        </button>&nbsp;
                    </abbr>

                    <abbr title="Ver PDF Nota de Recepción">
                        <button onclick="imprimir_nota_recepcion('{{$orden}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                            <i class="fas fa-file-pdf"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
          @endif
           
        </div>
        @break
    @case(22) 
        <div class="form-inline">
            @if ($estado == "PENDIENTE")
                <abbr title="Mostrar Artículos de la Orden">
                    <button onclick="ver('{{$orden}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
           @endif

          @if ($estado_rec == "PENDIENTE")
            @if ($estado == "APROBADO")
                <abbr title="Mostrar Artículos de la Orden">
                    <button onclick="ver2('{{$orden}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
                
                <abbr title="Ver PDF Nota de Recepción">
                    <button onclick="imprimir_nota_recepcion('{{$orden}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>

                <abbr title="Finalizar Nota de Recepción">
                    <button onclick="ver3('{{$orden}}', '{{$valor_ord}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-without-animation3">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
            @endif
          @endif

          @if ($estado_rec == "APROBADO")
            @if ($estado == "APROBADO")
                <abbr title="Mostrar Artículos de la Orden">
                    <button onclick="ver4('{{$orden}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-edit"></i>
                    </button>&nbsp;
                </abbr>
                
                <abbr title="Ver PDF Nota de Recepción">
                    <button onclick="imprimir_nota_recepcion('{{$orden}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                        <i class="fas fa-file-pdf"></i>
                    </button>&nbsp;
                </abbr>
            @endif
          @endif
        </div>
        @break
    @case(23) 
        <div class="form-inline">
            <label for="">{{$importe}}</label>
            <input type="hidden" name="id_solicitud" value="{{$id_solicitud}}">
            <input type="hidden" name="id_prov" value="{{$id_prov}}">
            <input type="hidden" name="id_soldet[]" value="{{$id_soldet}}">
            <input type="hidden" name="orden" value="{{$orden}}">
        </div>
        @break
    @case(24) 
        <div class="form-inline">
               @if ($cantidad < 1)
                <abbr title="Mostrar Artículos">
                    <button onclick="ver3('{{$no_pedido}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
               @endif
               @if ($cantidad == 1)
                   @if ($est_gen == "PENDIENTE")
                        <abbr title="Editar Cotización">
                            <button onclick="editar('{{$no_pedido}}', '{{$id_solicitud}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>
                   @endif

                   @if ($est_gen != "PENDIENTE")
                        <abbr title="Ver Cotización">
                            <button onclick="editar2('{{$no_pedido}}', '{{$id_solicitud}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation3">
                                <i class="far fa-edit"></i>
                            </button>&nbsp;
                        </abbr>
                   @endif
                   @if ($archivo != "VACIO")
                    <abbr title="Ver PDF Cotización del Proveedor">
                        <a href="{{$archivo}}" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;
                    </abbr>
                   @endif
               @endif
        </div>
        @break
    @case(25) 
        <div class="form-inline">
            <input type="hidden" name="no_pedido" id="no_pedido" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2" id="fecha2" value="{{$fecha2}}">
            <input type="hidden" name="id_sol_det[]" id="id_sol_det" value="{{$id}}">
            <input type="hidden" name="id_cot[]" id="id_cot" value="{{$id_cot}}">
            <input type="hidden" name="id_articulo[]" id="id_articulo" value="{{$id_articulo}}">
            <input type="hidden" name="cantidad[]" id="cantidad" value="{{$cantidad}}">
            <input type="text" name="preciou[]" id="preciou" value="0.00" onkeypress="return solo_numeros_precio(event)" required>
        </div>
        @break
    @case(26) 
        <div class="form-inline">
            <input type="hidden" name="no_pedidoe" id="no_pedidoe" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitude" id="id_solicitude" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2e" id="fecha2e" value="{{$fecha}}">
            <input type="hidden" name="id_sol_dete[]" id="id_sol_dete" value="{{$id}}">
            <input type="hidden" name="id_cote[]" id="id_cote" value="{{$id_cot}}">
            <input type="hidden" name="cantidade[]" id="cantidade" value="{{$cantidad}}">
            <input type="text" name="precioue[]" id="precioue" value="{{$precio}}" onkeypress="return solo_numeros_precio(event)">
        </div>
        @break
    @case(27) 
        <div class="form-inline">
            <input type="hidden" name="id_ordene" id="id_ordene" value="{{$id_ord}}">
            <input type="hidden" name="no_ordene" id="no_ordene" value="{{$no_ord}}">
            <input type="hidden" name="no_pedidoe" id="no_pedidoe" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitude" id="id_solicitude" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2e" id="fecha2e" value="{{$fecha}}">
            <input type="hidden" name="id_sol_dete[]" id="id_sol_dete" value="{{$id}}">
            <input type="hidden" name="id_cote[]" id="id_cote" value="{{$id_cot}}">
            <input type="hidden" name="cantidadee[]" id="cantidadee" value="{{$cantidad}}">
            <input type="text" name="precioue[]" id="precioue" value="{{$precio}}" onkeypress="return solo_numeros_precio(event)">
        </div>
        @break
    @case(28) 
        <div class="form-inline">
            <input type="hidden" name="no_pedidoe" id="no_pedidoe" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitude" id="id_solicitude" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2e" id="fecha2e" value="{{$fecha}}">
            <input type="hidden" name="id_sol_dete[]" id="id_sol_dete" value="{{$id}}">
            <input type="hidden" name="id_cote[]" id="id_cote" value="{{$id_cot}}">
            <input type="hidden" name="precioue[]" id="precioue" value="{{$precio}}">
            <input type="hidden" name="cumplee[]" id="cumplee" value="{{$cumple}}">
            <label for="">{{$precio}}</label>
        </div>
        @break
    @case(29) 
        <div class="form-inline">
            <input type="hidden" name="id_ordene" id="id_ordene" value="{{$id_ord}}">
            <input type="hidden" name="no_ordene" id="no_ordene" value="{{$no_ord}}">
            <input type="hidden" name="no_pedidoe" id="no_pedidoe" value="{{$no_pedi}}">
            <input type="hidden" name="id_solicitude" id="id_solicitude" value="{{$id_solicitud}}">
            <input type="hidden" name="fecha2e" id="fecha2e" value="{{$fecha}}">
            <input type="hidden" name="id_sol_dete[]" id="id_sol_dete" value="{{$id}}">
            <input type="hidden" name="id_cote[]" id="id_cote" value="{{$id_cot}}">
            <input type="hidden" name="precioue[]" id="precioue" value="{{$precio}}" onkeypress="return solo_numeros_precio(event)">
            <input type="hidden" name="cumplee[]" id="cumplee" value="{{$cumple}}">
            <label for="">{{$precio}}</label>
        </div>
        @break
    @case(30) 
        <div class="form-inline">
           @if ($estado == "PENDIENTE")
                <abbr title="Mostrar Artículos de la Orden">
                    <button onclick="ver('{{$valor_ord}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                        <i class="far fa-eye"></i>
                    </button>&nbsp;
                </abbr>
           @endif

          @if ($estado_rec == "PENDIENTE")
                @if ($estado == "APROBADO")
                    <abbr title="Mostrar Artículos de la Orden">
                        <button onclick="ver2('{{$valor_ord}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation2">
                            <i class="far fa-edit"></i>
                        </button>&nbsp;
                    </abbr>

                    <abbr title="Ver PDF Nota de Recepción">
                        <button onclick="imprimir_nota_recepcion('{{$valor_ord}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                            <i class="fas fa-file-pdf"></i>
                        </button>&nbsp;
                    </abbr>

                    <abbr title="Finalizar Nota de Recepción">
                        <button onclick="ver3('{{$orden}}', '{{$valor_ord}}')" class="btn btn-danger" data-toggle="modal" data-target="#modal-without-animation3">
                            <i class="far fa-edit"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
          @endif

          @if ($estado_rec == "APROBADO")
                @if ($estado == "APROBADO")
                    <abbr title="Ver Recepción">
                        <button onclick="ver4('{{$valor_ord}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                            <i class="far fa-edit"></i>
                        </button>&nbsp;
                    </abbr>

                    <abbr title="Ver PDF Nota de Recepción">
                        <button onclick="imprimir_nota_recepcion('{{$valor_ord}}')" class="btn btn-primary" data-toggle="modal" data-target="">
                            <i class="fas fa-file-pdf"></i>
                        </button>&nbsp;
                    </abbr>
                @endif
          @endif
           
        </div>
        @break
    @case(31) 
        <div class="form-inline">
            <abbr title="Ver Artículos">
                <button onclick="ver('{{$no_recep}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                    <i class="far fa-eye"></i>
                </button>&nbsp;
            </abbr>

            @if ($estado == "VACIO")
                <abbr title="Registrar Ingreso">
                    <button onclick="registrar('{{$no_recep}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-without-animation_reg">
                        <i class="fas fa-registered"></i>
                    </button>&nbsp;
                </abbr>
            @endif

            @if ($estado != "VACIO")
                <abbr title="Actualizar Ingreso">
                    <button onclick="actualizar('{{$no_recep}}')" class="btn btn-warning" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="fas fa-edit"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            
        </div>
        @break
    @case(32) 
        <div class="form-inline">
            <label for="">{{$importe}}</label>
        </div>
        @break
    @case(33) 
        <div class="form-inline">
            <input type="hidden" name="precior[]" value="{{$precio}}">
            <input type="hidden" name="cantidadr[]" value="{{$cantidad}}">
            <input type="hidden" name="id_articulor[]" value="{{$ida}}">
            <input type="hidden" name="id_recep_detr[]" value="{{$id_recep_det}}">
            <input type="hidden" name="id_recepr" value="{{$id_recep}}">
            <input type="date" class="form-control" placeholder="Seleccione una Fecha" name="fecha_art[]"/>
        </div>
        @break
    @case(34) 
        <div class="form-inline">
            <input type="hidden" name="precioa[]" value="{{$precio}}">
            <input type="hidden" name="cantidada[]" value="{{$cantidad}}">
            <input type="hidden" name="id_articuloa[]" value="{{$ida}}">
            <input type="hidden" name="id_recep_deta[]" value="{{$id_recep_det}}">
            <input type="hidden" name="id_recepa" value="{{$id_recep}}">
            <input type="date" class="form-control" name="fecha_arta[]" value="{{$fecha_vmto}}"/>
            <input type="hidden" name="id_trn_alma" value="{{$id_trn_alm}}">
            <input type="hidden" name="id_trn_almda[]" value="{{$id_trn_almd}}">
            <input type="hidden" name="id_arti_deta[]" value="{{$id_arti_det}}">
        </div>
        @break
    @case(35)
        <div class="form-inline">
            <abbr title="Ver Artículos">
                <button onclick="ver('{{$no_recep}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation">
                    <i class="far fa-eye"></i>
                </button>&nbsp;
            </abbr>

            @if ($estado == "PENDIENTE")
                <abbr title="Registrar Ingreso">
                    <button onclick="actualizar('{{$no_recep}}')" class="btn btn-success" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="fas fa-registered"></i>
                    </button>&nbsp;
                </abbr>
            @endif

            @if ($estado != "PENDIENTE")
                <abbr title="Registrar Ingreso">
                    <button onclick="actualizar2('{{$no_recep}}')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation2">
                        <i class="fas fa-info"></i>
                    </button>&nbsp;
                </abbr>
            @endif
            
        </div>
        @break
    @case(36) 
        <div class="form-inline">
            <input type="hidden" name="precioa[]" value="{{$precio}}">
            <input type="hidden" name="cantidada[]" value="{{$cantidad}}">
            <input type="hidden" name="id_articuloa[]" value="{{$ida}}">
            <input type="hidden" name="id_recep_deta[]" value="{{$id_recep_det}}">
            <input type="hidden" name="id_recepa" value="{{$id_recep}}">
            <label for="">{{$fecha_vmto}}</label>
            <input type="hidden" name="id_trn_alma" value="{{$id_trn_alm}}">
            <input type="hidden" name="id_trn_almda[]" value="{{$id_trn_almd}}">
            <input type="hidden" name="id_arti_deta[]" value="{{$id_arti_det}}">
        </div>
        @break
    @case(37) 
        <div class="form-inline">
            <label for="">{{$cant_disp}}</label>
        </div>
        @break
        
    @default
        
@endswitch
