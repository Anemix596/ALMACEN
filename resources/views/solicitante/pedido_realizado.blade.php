@extends('layouts.default')

@section('title', 'Lista de Pedidos Realizados')

@push('css')

<link href="{{ asset('/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/gritter/css/jquery.gritter.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/smartwizard/dist/css/smart_wizard.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/@danielfarrell/bootstrap-combobox/css/bootstrap-combobox.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/tag-it/css/jquery.tagit.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css')}}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css')}}" rel="stylesheet" />


@endpush

@section('content')
    
    
    <h1 class="page-header">Lista de Pedidos Realizados </h1>
        
    <div class="col-xl-12">
        <div>
            <form class="form-horizontal" id="filtrar" data-parsley-validate="true" name="demo-form">
                <div class="col-md-9">
                    <h4 class="panel-title">Filtrar por Estado</h4>
                    <div class="checkbox checkbox-css">
                        <input type="checkbox" name="ped_pendiente" id="ped_pendiente" value="1" onchange="pendientes(this.value);"/>
                        <label for="ped_pendiente">Pedidos Pendientes</label>
                    </div>
                    <div class="checkbox checkbox-css is-valid">
                        <input type="checkbox" name="ped_aprobado" id="ped_aprobado" value="2" onchange="aprobados(this.value);"/>
                        <label for="ped_aprobado">Pedidos Aprobados</label>
                    </div>
                    <div class="checkbox checkbox-css is-invalid">
                        <input type="checkbox" name="ped_rechazado" id="ped_rechazado" value="3" onchange="rechazados(this.value);"/>
                        <label for="ped_rechazado">Pedidos Rechazados</label>
                    </div>
                </div>
            </form>
        </div>
        <br>
        
        <div class="panel panel-inverse">
            
            <div class="panel-heading">
                <h4 class="panel-title">LISTA DE PEDIDOS REALIZADOS</h4>
            </div>
            
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="lista" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">Nº</th>
                                <th class="text-nowrap">Nº PEDIDO</th>
                                <th class="text-nowrap">FECHA PEDIDO</th>
                                <th class="text-nowrap">UNIDAD</th>
                                <th class="text-nowrap">RESPONSABLE</th>
                                <th class="text-nowrap">MOTIVO</th>
                                <th class="text-nowrap">ESTADO</th>
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; ACCIONES &nbsp; &nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
                
        <div class="modal" id="modal-without-animation" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Vista de Artículos del Pedido</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="lista2" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Nº</th>
                                        <th class="text-nowrap">ARTICULO</th>
                                        <th class="text-nowrap">UNIDAD DE MEDIDA</th>
                                        <th class="text-nowrap">DESCRIPCIÓN</th>
                                        <th class="text-nowrap">CANTIDAD PEDIDA</th>
                                        <th class="text-nowrap">ARCHIVO</th>
                                        <th class="text-nowrap">ESTADO</th>
                                        <th width="1%" class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
       
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        
    <div class="modal fade" id="modal-alert" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 70% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Anular Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger m-b-0">
                        <h3 style="text-align: center"><i class="fa fa-info-circle"></i> Alerta de Anulación de Artículo</h3>
                        <p>¿Está seguro de Anular el Artículo para este Pedido? 
                            <br> Si está seguro de anular presione el botón de Anular.</p>
                        <form action="{{ route('eliminar.pedido') }}" id="eliminar" method="POST">
                            
                            @csrf
                            <input type="hidden" id="pid" name="pid" value="">
                            
                            <dl class="row">
                                <dt class="text-inverse text-right col-4 text-truncate">Nº de Pedido:</dt>
                                <dd class="col-8 text-truncate"><label id="pno_pedido"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Fecha de Pedido:</dt>
                                <dd class="col-8 text-truncate"><label id="pfecha_pedido"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Unidad Solicitante:</dt>
                                <dd class="col-8 text-truncate"><label id="punidad"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Superior Responsable: </dt>
                                <dd class="col-8 text-truncate"><label id="presponsable"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Para emplearse en: </dt>
                                <dd class="col-8 text-truncate"><label cla id="pmotivo"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Artículo:  </dt>
                                <dd class="col-8 text-truncate"><label id="particulo"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Unidad de Medida:  </dt>
                                <dd class="col-8 text-truncate"><label id="punidad_medida"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Descripción Específica:  </dt>
                                <dd class="col-8 text-truncate"><label id="pdescripcion"></label></dd>
                                <dt class="text-inverse text-right col-4 text-truncate">Cantidad Pedida:  </dt>
                                <dd class="col-8 text-truncate"><label id="pcantidad"></label></dd>
                                
                            </dl>
                            <button type="submit" class="btn btn-danger">Anular</button>  
                        </form>
                    </div>
                    
                    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
                    
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cancelar</a>
                    
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modal-alert2" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 50% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Archivo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger m-b-0">
                        <h3 style="text-align: center"><i class="fa fa-info-circle"></i> Alerta de Eliminación de Archivo</h3>
                        <p>¿Está seguro de Eliminar el Archivo? 
                            <br>No se podrá recuperar el archivo
                            <br> Si está seguro de eliminar presione el botón de Eliminar.</p>
                        <form action="{{ route('eliminar.archivo') }}" id="eliminar_archivo" method="POST">
                            
                            @csrf
                            <input type="hidden" id="idp" name="idp" value="">
                            
                            <button type="submit" class="btn btn-danger">Eliminar</button>  
                        </form>
                    </div>
                                        
                    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
                    
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cancelar</a>
                    
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modal-dialog2" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 70% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                                        
                    <div class="panel-body">
                        <form class="form-horizontal" id="editar" data-parsley-validate="true" name="demo-form" enctype="multipart/form-data">
                           @csrf
                            <input type="hidden" id="id" name="id"/>
                            <dl class="row">
                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">&nbsp; Información Principal</legend>
                                    <dt class="text-inverse text-right col-4 text-truncate">Nº de Pedido: </dt>
                                    <dd class="col-8 text-truncate"><label id="cadno_pedido"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Fecha de Pedido: </dt>
                                    <dd class="col-8 text-truncate"><label id="cadfecha_pedido"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Unidad Solicitante: </dt>
                                    <dd class="col-8 text-truncate"><label id="cadunidad"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Superior Responsable: </dt>
                                    <dd class="col-8 text-truncate"><label id="cadresponsable"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Para emplearse en:  </dt>
                                    <dd class="col-8 text-truncate"><label id="cadmotivo"></label></dd>
                            </dl>
                            <div class="row">
                                
                                <div class="col-xl-8 offset-xl-2">
                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Información de Pedido</legend>
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Categoría <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="categoriap3" name="categoriap3" data-parsley-group="step-2" class="default-select2 form-control categoriap3" data-size="10" data-live-search="true" onchange="mostrar_articulo3(this.value);" required>
                                                 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Artículo <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="articulo3" name="articulo3" data-parsley-group="step-2" class="default-select2 form-control articulo" data-size="10" data-live-search="true" onchange="valor_unidad_medida3(this.value);" required>
                                                 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <div class="col-lg-9 col-xl-6">
        
                                            <div class="form-group row m-b-10">
                                                <label class="col-lg-3 text-lg-right col-form-label"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <td><a href="#modal-dialog3" class="btn btn-sm btn-success" data-toggle="modal" onclick="setTimeout(funciones2, 1000);">Agregar Artículo</a></td>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Unidad de Medida <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="hidden" id="unidad_medida4" name="unidad_medida4" value="" class="formulario1"/>
                                            <input type="text" id="unidad_medida3" name="unidad_medida3" placeholder="MEDICIÓN" data-parsley-group="step-2" data-parsley-required="true" class="form-control" disabled/>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Descripción Específica <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <textarea class="form-control formulario1" id="descripcion3" name="descripcion3" pattern="^[A-Za-z]([A-Za-z]|[0-9]|\.| )*" rows="3" minlength="1" maxlength="250" placeholder="CANTIDAD MÁXIMO DE CARACTERES: 250" data-parsley-group="step-2" data-size="10" data-live-search="true" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required></textarea>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Cantidad Pedida <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" id="cantidad3" name="cantidad3" placeholder="INGRESE CANTIDAD QUE DESEA SOLICITAR" data-parsley-group="step-2" data-parsley-required="true" class="form-control formulario1" onkeypress="return solo_numeros(event)" required/>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Actualizar Archivo :</label>
                                        
                                        <div class="col-lg-9 col-xl-3">
                                            <input type="file" name="archivo3" id="archivo3" accept=".pdf">
                                        </div>
                                    </div>
                                
                                    
                                </div>
                                
                            </div>
                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    

                    
                    <div class="modal fade" id="modal-dialog3" role="dialog" style="overflow-y: scroll">
                        <div class="modal-dialog" style="max-width: 50% !important;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Agregar Artículo</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        <form action="{{ route('insertar.articulo2') }}" id="enviara2" method="POST" name="" class="form-control-with-bg">
                                            @csrf

                                            <input type="hidden" id="id_cat3" name="id_cat3" value="0">
                                            <input type="hidden" id="id_cat4" name="id_cat4" value="0">
                                            <input type="hidden" id="id_art3" name="id_art3" value="0">
                                            <input type="hidden" id="unid3" name="unid3" value="">
                                            <input type="hidden" id="unid4" name="unid4" value="">
                                            
                                            <div class="panel-body">
                                                
                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-4 col-sm-4 col-form-label">Categoría: <span class="text-danger">*</span></label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <select id="categoria3" name="categoria3" class="default-select2 form-control" data-live-search="true" data-size="10" required>
                                                                                                            
                                                        </select>
                                                    </div>
                                                    
                                                </div>

                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-4 col-sm-4 col-form-label">Artículo: <span class="text-danger">*</span></label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <input class="form-control formulario2" type="text" id="articuloa3" name="articuloa3" pattern="^[A-Za-z]([A-Za-z]|[0-9]|\.| )*"  data-parsley-type="text" placeholder="INGRESE NUEVO ARTÍCULO" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-4 col-sm-4 col-form-label">Unidad de Medida: </label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <select id="unidad_pieza3" name="unidad_pieza3" class="default-select2 form-control" data-size="10" data-live-search="true" required>
                                                                                                                
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-4 col-sm-4 col-form-label">Partida: </label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <select id="partida3" name="partida3" class="default-select2 form-control" data-size="10" data-live-search="true" required>
                                                                                                                
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row m-b-0">
                                                    <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                                    <div class="col-md-8 col-sm-8">
                                                        <button type="submit" class="btn btn-success" >Agregar</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    
                    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-without-animation10" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 70% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Motivo del Rechazo del Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="mostrar_rechazo">
                        <div class="form-group row m-b-10">
                            <label class="col-lg-3 text-lg-right col-form-label">Motivo de Rechazo <span class="text-danger">*</span></label>
                            <div class="col-lg-9 col-xl-6">
                                <textarea class="form-control formulario1" id="rechazo" name="rechazo" pattern="^[A-Za-z]([A-Za-z]|[0-9]|\.| )*" rows="2" minlength="1" maxlength="250" placeholder="CANTIDAD MÁXIMO DE CARACTERES: 250" data-size="10" data-live-search="true" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                </div>
            </div>
        </div>
    </div>
 
@endsection

@push('scripts')

<script>
    function validarTexting(){
        var errorMsg = "Por favor Respete el Formato";
        var textarea = this;
        var pattern = new RegExp($(textarea).attr('pattern'));
        $.each($(this).val().split("\n"), function(){
            var hasError = !this.match(pattern);
            if(typeof textarea.setCustomValidity === 'function'){
                textarea.setCustomValidity(hasError ? errorMsg : '');
            }else{
                $(textarea).toggleClass('error', !!hasError);
                $(textarea).toggleClass('ok', !hasError);
                if(hasError){
                    $(textarea).attr('title', errorMsg);
                }else{
                    $(textarea).removeAttr('title');
                }
            }
            return !hasError;
        });
    }
</script>

<script>
    function mostrar_ppresupuesto(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.presupuesto') }}',
            data:$(this).serialize(),
            success:function(presupuesto){
                $('#partida3').html(presupuesto);
            }
            
        });
    }
</script>

<script>
    function motivo_rechazo(dato){
        $.ajax({
            type:'POST',
            url:"{{ route('recuperar.observacion.pedido') }}",
            data:{ _token: '{{ csrf_token ()}}', no:dato},
            success:function(obs){
                $('#rechazo').html(obs);
            }
            
        });
    }
</script>

<script>
    function mostrar_articulo3(dato){
        $('#id_cat4').val(dato);
        $.ajax({
            type:'POST',
            url:"{{ route('recuperar.articulo.valor') }}",
            data:{ _token: '{{ csrf_token ()}}', id:dato},
            success:function(articulo){
                $('#articulo3').html(articulo);
            }
            
        });
    }
</script>


<script>
    function imprimir_pedido(pedido){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.pedido') }}',
            data:{ _token: '{{ csrf_token ()}}', no_pedido:pedido},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>


<script>
    let valor1=0, valor2=0, valor3=0;
    function pendientes(dato){
        let dp = dato;
        if(ped_pendiente.checked) valor1=dp;
        else valor1=0;
        filtrar(valor1, valor2, valor3);
    }

    function aprobados(dato){
        let dp = dato;
        if(ped_aprobado.checked) valor2=dp;
        else valor2=0;
        filtrar(valor1, valor2, valor3);
    }

    function rechazados(dato){
        let dp = dato;
        if(ped_rechazado.checked) valor3=dp;
        else valor3=0;
        filtrar(valor1, valor2, valor3);
    }
</script>


<script>

    $(function(){
        $('#editar').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('actualizar.pedido')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#modal-dialog2').modal('hide');
                        $('#lista2').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Se ha actualizado el Pedido"});
                    }
                    else if(html == 2){
                        swal({ icon: "warning", title: "Inserte una cantidad mayor a 0"});
                    }
                    else if(html == 0){
                        swal({ icon: "error", title: "No se pudo realizar el registro, verifique que los datos sean correctos"});
                    }
                    else if(html == 3){
                        swal({ icon: "warning", title: "Ya existe un Artículo con la misma Descripción en el Pedido"});
                    }
                    else if(html == 4){
                        swal({ icon: "warning", title: "La Descripción debe empezar con una Letra del Abecedario"});
                    }
                    else{swal({ icon: "error", title: "Vuelva a Iniciar Sesión"});}
                });
        });
    });
</script>


<script>
    function editar(dato){
        let id=dato;
        $.ajax({
            type:'POST',
            url:"{{ route('ver.editar.pedido') }}",
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                document.getElementById("id").value = html[0];
                document.getElementById("cadunidad").innerHTML = html[1];
                document.getElementById("cadresponsable").innerHTML = html[2]+" "+html[3]+" "+html[4]+" "+html[5];
                document.getElementById("cadmotivo").innerHTML = html[6];
                document.getElementById("unidad_medida3").value = html[11];
                document.getElementById("unidad_medida4").value = html[15];
                document.getElementById("descripcion3").value = html[8];
                document.getElementById("cantidad3").value = html[9];
                document.getElementById("cadno_pedido").innerHTML = html[18];
                const fecha_ped = html[14], fecha_p=fecha_ped.split(" ");
                const fecha = fecha_p[0].split("-");
                document.getElementById("cadfecha_pedido").innerHTML = fecha[2]+"/"+fecha[1]+"/"+fecha[0];
                $('#id_cat3').val(html[20]);
                $('#id_cat4').val(html[20]);
                $('#id_art3').val(html[7]);
                $('#unid3').val(html[11]);
                $('#unid4').val(html[15]);
                let id_categoria = html[20];
                let id_partida = html[21];
                if(id_categoria==0){
                    $('#cat_clas').text('Clasificador');
                    $.ajax({
                        type:'POST',
                        url:"{{ route('ver.editar.pedido.part') }}",
                        data:{ _token: '{{ csrf_token ()}}', id:html[22], idp:id_partida},
                        success:function(categoria){
                            $('#categoriap3').html(categoria);
                        }
                        
                    });
                }
                if(id_categoria != 0){
                    $('#cat_clas').text('Categoría');
                    $.ajax({
                        type:'POST',
                        url:"{{ route('ver.editar.pedido.categoria') }}",
                        data:{ _token: '{{ csrf_token ()}}', id_categoria:id_categoria},
                        success:function(categoria){
                            $('#categoriap3').html(categoria);
                        }
                        
                    });
                    
                }

                let id_articulo = html[7];
                $.ajax({
                    type:'POST',
                    url:"{{ route('ver.editar.pedido.articulo') }}",
                    data:{ _token: '{{ csrf_token ()}}', id_articulo:id_articulo, id_categoria:id_categoria},
                    success:function(articulo){
                        $('#articulo3').html(articulo);
                    }
                    
                });
                
                $('#archivo3').val('');

            }
            
        });
    }
</script>


<script>
    function eliminar(dato){
        let id=dato;
        
        $.ajax({
            type:'POST',
            url:'{{ route('ver.editar.pedido') }}',
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                document.getElementById("pid").value = html[0];
                document.getElementById("punidad").innerHTML = html[1];
                document.getElementById("presponsable").innerHTML = html[2] + " " + html[3] + " " + html[4] + " " + html[5];
                document.getElementById("pmotivo").innerHTML = html[6];
                document.getElementById("particulo").innerHTML = html[17];
                document.getElementById("punidad_medida").innerHTML = html[11];
                document.getElementById("pdescripcion").innerHTML = html[8];
                document.getElementById("pcantidad").innerHTML = html[9];
                document.getElementById("pfecha_pedido").innerHTML = html[14];
                document.getElementById("pno_pedido").innerHTML = html[18];
                const fecha_ped = html[14], fecha_p=fecha_ped.split(" ");
                const fecha = fecha_p[0].split("-");
                document.getElementById("pfecha_pedido").innerHTML = fecha[2]+"/"+fecha[1]+"/"+fecha[0];
            }
            
        });
    }
</script>


<script>
    function eliminar_archivo(dato){
        let id=dato;
        
        $.ajax({
            type:'POST',
            url:'{{ route('ver.editar.pedido') }}',
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                document.getElementById("idp").value = html[0];
            }
            
        });
    }
</script>


<script>
    $(document).on("submit" ,"#eliminar", function(e){
        $.ajaxSetup({
            header: $('meta[name="_token"]').attr('content')
        });
        e.preventDefault(e);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            datatype: 'html',
            success: function(html){
                if(html == 1){
                    $('#modal-alert').modal('hide');
                    swal({ icon: "success", title: "Se ha anulado el pedido"});
                    $('#lista2').DataTable().ajax.reload();
                    $('#lista').DataTable().ajax.reload();
                }
                else{
                    swal({ icon: "error", title: "Error, no se pudo deshabilitar"});
                }
                
            }
        });
    });
</script>


<script>
    $(document).on("submit" ,"#eliminar_archivo", function(e){
        $.ajaxSetup({
            header: $('meta[name="_token"]').attr('content')
        });
        e.preventDefault(e);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            datatype: 'html',
            success: function(html){
                if(html == 1){
                    $('#modal-alert2').modal('hide');
                    swal({ icon: "success", title: "Se ha eliminado el archivo"});
                    
                    $('#lista2').DataTable().ajax.reload();
                }
                else{
                    swal({ icon: "error", title: "Error, no se pudo eliminar"});
                }
                
            }
        });
    });
</script>


<script>
    $(document).ready( function () {
        $('#lista').DataTable({
            pageLength:25,
            "ajax": {
                url: "{{route('ver.lista.pedido')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'fecha_pedido' , name: 'fecha_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'responsable' , name: 'responsable'},
                        {data: 'motivo' , name: 'motivo'},
                        {data: 'estadoc' , 
                            render: function(name){
                                name: 'estadoc';
                                const fecha = name, fech=fecha.split("/");
                                const estado = fech[0];
                                const p = fech[1];
                                var pe = parseInt(p);
                                if(estado=="PENDIENTE"){
                                    return '<abbr title="Pedido Pendiente"><button class="btn btn-warning"><i class="fab fa-product-hunt"></i></button>&nbsp;</abbr>';
                                }
                                if(estado=="APROBADO"){
                                    return '<abbr title="Pedido Aprobado"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(estado=="RECHAZADO"){
                                    return '<abbr title="Pedido Rechazado - Presione para ver el Motivo del Rechazo"><button onclick="motivo_rechazo('+pe+')" class="btn btn-danger" data-toggle="modal" data-target="#modal-without-animation10"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
                                }
                            }
                        },
                        {data: 'boton', name: 'boton'}
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista").DataTable().clear().draw();
            },
            dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            language: {
                "url": "{{asset('assets')}}/plugins/datatables.net/spanish.json"
            },
            responsive: false,
            serverSide: false,
            processing: true,
            buttons: [
            { extend: 'copy', text: 'Copiar', className: 'btn-sm' },
            { extend: 'csv', className: 'btn-sm' },
            { extend: 'pdf', className: 'btn-sm' },
            { extend: 'print', text: 'Imprimir', className: 'btn-sm' }
            ],
            columnDefs: [
            { orderable: false, targets: 7 }
            ],
        });
        
    });
</script>


<script>
    function ver(dato){
        $('#lista2'). DataTable().clear().destroy();
        let no=dato;
        $('#lista2').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data:'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'unidad_medida' , name: 'unidad_medida'},
                        {data: 'descripcion' , name: 'descripcion'},
                        {data: 'cantidad' , name: 'cantidad'},
                        {data: 'archivo' , 
                            render: function(name){
                                name: 'archivo';
                                if(name!="VACIO"){
                                    return '<abbr title="Ver Archivo"><a href="'+name+'" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;</abbr>';
                                }
                                else return "";
                            }
                        },
                        {data: 'est_art' , 
                            render: function(name){
                                name: 'est_art';
                                if(name=="PENDIENTE"){
                                    return '<abbr title="Artículo Pendiente"><button class="btn btn-warning"><i class="fab fa-product-hunt"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="APROBADO"){
                                    return '<abbr title="Artículo Aprobado"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="RECHAZADO"){
                                    return '<abbr title="Artículo Rechazado"><button class="btn btn-danger"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
                                }
                            }
                        },
                        {data: 'boton', name: 'boton'}
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista2").DataTable().clear().draw();
            },
            dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            language: {
                "url": "{{asset('assets')}}/plugins/datatables.net/spanish.json"
            },
            responsive: false,
            serverSide: false,
            processing: true,
            buttons: [
            { extend: 'copy', text: 'Copiar', className: 'btn-sm' },
            { extend: 'csv', className: 'btn-sm' },
            { extend: 'pdf', className: 'btn-sm' },
            { extend: 'print', text: 'Imprimir', className: 'btn-sm' }
            ],
            columnDefs: [
            { orderable: false, targets: 5 }
            ],
        });
        
    }
    
</script>


<script>
    function filtrar(dato1, dato2, dato3){
        $('#lista'). DataTable().clear().destroy();
        let est_ped1=dato1;
        let est_ped2=dato2;
        let est_ped3=dato3;
        $('#lista').DataTable({
            pageLength:25,
            "ajax": {
                type:'POST',
                url:'{{ route('lista.pedido.valor.solicitante') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2, est_ped3:est_ped3}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'fecha_pedido' , name: 'fecha_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'responsable' , name: 'responsable'},
                        {data: 'motivo' , name: 'motivo'},
                        {data: 'estadoc' , 
                            render: function(name){
                                name: 'estadoc';
                                const fecha = name, fech=fecha.split("/");
                                const estado = fech[0];
                                const p = fech[1];
                                var pe = parseInt(p);
                                if(estado=="PENDIENTE"){
                                    return '<abbr title="Pedido Pendiente"><button class="btn btn-warning"><i class="fab fa-product-hunt"></i></button>&nbsp;</abbr>';
                                }
                                if(estado=="APROBADO"){
                                    return '<abbr title="Pedido Aprobado"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(estado=="RECHAZADO"){
                                    return '<abbr title="Pedido Rechazado - Presione para ver el Motivo del Rechazo"><button onclick="motivo_rechazo('+pe+')" class="btn btn-danger" data-toggle="modal" data-target="#modal-without-animation10"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
                                }
                            }
                        },
                        {data: 'boton', name: 'boton'}
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista").DataTable().clear().draw();
            },
            dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            language: {
                "url": "{{asset('assets')}}/plugins/datatables.net/spanish.json"
            },
            responsive: false,
            serverSide: false,
            processing: true,
            buttons: [
            { extend: 'copy', text: 'Copiar', className: 'btn-sm' },
            { extend: 'csv', className: 'btn-sm' },
            { extend: 'pdf', className: 'btn-sm' },
            { extend: 'print', text: 'Imprimir', className: 'btn-sm' }
            ],
            columnDefs: [
            { orderable: false, targets: 5 }
            ],
        });
        
    }
    
</script>


<script>
    function funciones2(){
        
        mostrar_categoria2();
        mostrar_unidad_pieza2();
        mostrar_ppresupuesto();
        
    }

    function mostrar_categoria2(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.categoria') }}',
            data:$(this).serialize(),
            success:function(categoria){
                $('#categoria3').html(categoria);
            }
            
        });
    }

    function mostrar_unidad_pieza2(){
        $.ajax({
            type:'GET',
            url:'{{ route('listar.unidad.medida') }}',
            data:$(this).serialize(),
            success:function(unidad_pieza){
                $('#unidad_pieza3').html(unidad_pieza);
            }
            
        });
    }
</script>


<script>
    function convertirEnMayusculas(e){
        e.value = e.value.toUpperCase();
    }
</script>

<script>
    $(document).on("submit" ,"#enviara2", function(e){
        $.ajaxSetup({
            header: $('meta[name="_token"]').attr('content')
        });
        e.preventDefault(e);
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            datatype: 'html',
            success: function(html){
                if(html == 1){

                    let dato = parseInt($('#id_cat3').val());
                    let dato2 = parseInt($('#id_cat4').val());
                    let dato3 = parseInt($('#id_art3').val());
                    if(dato != dato2){
                        $.ajax({
                            type:'POST',
                            url:"{{ route('recuperar.articulo.valor') }}",
                            data:{ _token: '{{ csrf_token ()}}', id:dato2},
                            success:function(articulo){
                                $('#articulo3').html(articulo);
                                document.getElementById('unidad_medida3').value = '';
                                document.getElementById('unidad_medida4').value = '';
                            }
                        });
                    }
                    if(dato == dato2){
                        $.ajax({
                            type:'POST',
                            url:"{{ route('ver.editar.pedido.articulo') }}",
                            data:{ _token: '{{ csrf_token ()}}', id_articulo:dato3, id_categoria:dato},
                            success:function(articulo){
                                $('#articulo3').html(articulo);
                                $('#unidad_medida3').val($('#unid3').val());
                                $('#unidad_medida4').val($('#unid4').val());
                            }
                            
                        });
                    }
                    swal({ icon: "success", title: "Se ha registrado un nuevo artículo"});
                    funciones2();
                    document.getElementById('articuloa3').value = '';
                    
                    
                }
                else if(html == 2){
                    swal({ icon: "warning", title: "El artículo ya existe"});

                }
                else if(html == 3){
                    swal({ icon: "warning", title: "Introduzca el nombre del artículo"});

                }
                else{
                    swal({ icon: "error", title: "No se pudo realizar el registro, verifique que los datos sean correctos"});
                }
                
            }
        });

        
        
    });
</script>


<script>
    function valor_unidad_medida3(id){
        let id_articulo = id;
        $.ajax({
            type:'POST',
            url:'{{ route('recuperar.unidad.medida') }}',
            data:{ _token: '{{ csrf_token ()}}', id_articulo:id_articulo},
            success:function(html){
                $('#unidad_medida4').val(html[0]);
                $('#unidad_medida3').val(html[1]);
            }
            
        });
    }
</script>


<script>
    function solo_letras (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num=" abcdefghijklmnñopqrstuvwxyz";
        especiales="8-37-38-46-164";
        teclado_especial=false;
        for (var i in especiales) {
            if (key==especiales[i]) {
                teclado_especial=true;break;
            }
        }
        if (letras_num.indexOf(teclado)==-1 && !teclado_especial) {
            return false;
        }
    }
    function solo_numeros (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num="1234567890";
        especiales="8-37-38-46-164";
        teclado_especial=false;
        for (var i in especiales) {
            if (key==especiales[i]) {
                teclado_especial=true;break;
            }
        }
        if (letras_num.indexOf(teclado)==-1 && !teclado_especial) {
            return false;
        }
    }

    function solo_numeros_precio (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num="1234567890.,";
        especiales="8-37-38-46-164";
        teclado_especial=false;
        for (var i in especiales) {
            if (key==especiales[i]) {
                teclado_especial=true;break;
            }
        }
        if (letras_num.indexOf(teclado)==-1 && !teclado_especial) {
            return false;
        }
    }

    function solo_letras_numeros (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num=" abcdefghijklmnñopqrstuvwxyz.1234567890";
        especiales="8-37-38-46-164";
        teclado_especial=false;
        for (var i in especiales) {
            if (key==especiales[i]) {
                teclado_especial=true;break;
            }
        }
        if (letras_num.indexOf(teclado)==-1 && !teclado_especial) {
            return false;
        }
    }

    function solo_letras_numeros_correo (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num=" abcdefghijklmnñopqrstuvwxyz.1234567890@-";
        especiales="8-37-38-46-164";
        teclado_especial=false;
        for (var i in especiales) {
            if (key==especiales[i]) {
                teclado_especial=true;break;
            }
        }
        if (letras_num.indexOf(teclado)==-1 && !teclado_especial) {
            return false;
        }
    }

    function solo_letras_numeros_direccion (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num=" abcdefghijklmnñopqrstuvwxyz.,1234567890-/";
        especiales="8-37-38-46-164";
        teclado_especial=false;
        for (var i in especiales) {
            if (key==especiales[i]) {
                teclado_especial=true;break;
            }
        }
        if (letras_num.indexOf(teclado)==-1 && !teclado_especial) {
            return false;
        }
    }
</script>

<script src="{{ asset('/assets/plugins/parsleyjs/dist/parsley.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/highlight.js/highlight.min.js')}}"></script>
<script src="{{ asset('/assets/js/demo/render.highlight.js')}}"></script>
<script src="{{ asset('/assets/plugins/parsleyjs/dist/parsley.js')}}"></script>
<script src="{{ asset('/assets/plugins/smartwizard/dist/js/jquery.smartWizard.js')}}"></script>
<script src="{{ asset('/assets/js/demo/form-wizards-validation.demo.js')}}"></script>
<script src="{{ asset('/assets/plugins/gritter/js/jquery.gritter.js')}}"></script>
<script src="{{ asset('/assets/plugins/sweetalert/dist/sweetalert.min.js')}}"></script>
<script src="{{ asset('/assets/js/demo/ui-modal-notification.demo.js')}}"></script>
<script src="{{ asset('/assets/plugins/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/@danielfarrell/bootstrap-combobox/js/bootstrap-combobox.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/tag-it/js/tag-it.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-show-password/dist/bootstrap-show-password.js')}}"></script>
<script src="{{ asset('/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js')}}"></script>
<script src="{{ asset('/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js')}}"></script>
<script src="{{ asset('/assets/plugins/clipboard/dist/clipboard.min.js')}}"></script>
<script src="{{ asset('/assets/js/demo/form-plugins.demo.js')}}"></script>
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/assets/js/demo/table-manage-responsive.demo.js')}}"></script>


@endpush