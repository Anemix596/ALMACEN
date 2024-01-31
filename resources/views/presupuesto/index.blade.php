@extends('layouts.default')

@section('title', 'Asignación del Presupuesto')

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
    
    
    <h1 class="page-header">Lista de Solicitud de Pedidos</h1>
        
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
                <h4 class="panel-title">LISTA DE SOLICITUD DE PEDIDOS</h4>
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
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
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
                        <form id="pedido_rechazado" method="POST">
                            <input type="hidden" id="no_rechazo" name="no_rechazo" value="">
                            
                            <div id="mostrar_rechazo">
                                <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Motivo de Rechazo <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea class="form-control formulario1" id="rechazo" name="rechazo" rows="2" minlength="1" maxlength="250" placeholder="CANTIDAD MÁXIMO DE CARACTERES: 250" data-size="10" data-live-search="true" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required></textarea>
                                    </div>
                                </div>
                                <div>
                                    <a onclick="anular_pedido_articulo()" id="anular_pedido" name="anular_pedido" class="btn btn-danger" style="color: white"><abbr title="Anular el Pedido rechazando todos los Artículos"><i class="fas fa-times-circle">Anular Pedido</i></abbr></a>
                                </div>
                            </div>
                        </form>
                        
                        <br>
                        <div class="table-responsive">
                            <table id="lista2" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Nº</th>
                                        <th class="text-nowrap">ARTICULO</th>
                                        <th class="text-nowrap">UNIDAD DE MEDIDA</th>
                                        <th class="text-nowrap">DESCRIPCIÓN</th>
                                        <th class="text-nowrap">CANTIDAD PEDIDA</th>
                                        <th class="text-nowrap">CODIGO PRESUPUESTARIO</th>
                                        <th class="text-nowrap">ARCHIVO</th>
                                        <th class="text-nowrap">ESTADO</th>
                                        <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; </th>
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
    

    
    <div class="modal fade" id="modal-dialog5" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 70% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fuente de Financiamiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    
                    <div class="panel-body">
                        <form class="form-horizontal" id="enviarf" data-parsley-validate="true" name="demo-form">
                           @csrf
                            <input type="hidden" id="no_pedidof" name="no_pedidof"/>
                            <div class="row">
                                
                                <div class="col-xl-12 offset-xl-0">
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Fuente de Financiamiento <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="row row-space-12">
                                                <div class="col-5">
                                                    <select id="fuente" name="fuente" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" onchange="valor_fuente(this.value);" required>
                                                                                                    
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="col-lg-3 text-lg-right col-form-label">Órgano Financiador<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-5">
                                                    <select id="organo" name="organo" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" onchange="valor_organo(this.value);" required>
                                                                                                    
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Estructura Programática <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-12 col-xl-9">
                                            <div class="row row-space-9">
                                                <div class="col-8">
                                                    <input type="hidden" id="fuente_fnto" name="fuente_fnto" required/>
                                                    <input type="text" id="fuente_fnto2" name="fuente_fnto2" placeholder="FINANCIMIENTO" data-parsley-group="step-2" data-parsley-required="true" class="form-control formulario1" required disabled/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <br><br>
                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Asignar Fuente de Financiamiento</button>
                                </div>
                            </div>
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

    
    <div class="modal fade" id="modal-dialog6" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 70% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actualizar Fuente de Financiamiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    
                    <div class="panel-body">
                        <form class="form-horizontal" id="editarf" data-parsley-validate="true" name="demo-form">
                           @csrf
                            <input type="hidden" id="no_pedidofe" name="no_pedidofe"/>
                            <div class="row">
                                
                                <div class="col-xl-12 offset-xl-0">
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Fuente de Financiamiento <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="row row-space-12">
                                                <div class="col-5">
                                                    <select id="efuente" name="efuente" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" onchange="valor_efuente(this.value);" required>
                                                                                                    
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="col-lg-3 text-lg-right col-form-label">Órgano Financiador<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-5">
                                                    <select id="eorgano" name="eorgano" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" onchange="valor_eorgano(this.value);" required>
                                                                                                    
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Estructura Programática <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-12 col-xl-9">
                                            <div class="row row-space-9">
                                                <div class="col-8">
                                                    <input type="hidden" id="efuente_fnto" name="efuente_fnto" required/>
                                                    <input type="text" id="efuente_fnto2" name="efuente_fnto2" placeholder="FINANCIMIENTO" data-parsley-group="step-2" data-parsley-required="true" class="form-control formulario1" required disabled/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <br><br>
                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Actualizar Fuente de Financiamiento</button>
                                </div>
                            </div>
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
        <div class="modal-dialog" style="max-width: 40% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalles del Artículo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    
                    <div class="panel-body">
                        <form class="form-horizontal" id="enviar" data-parsley-validate="true" name="demo-form">
                           @csrf
                            <input type="hidden" id="id" name="id"/>
                            <input type="hidden" id="no_pedido" name="no_pedido"/>
                            <input type="hidden" id="cant_ped" name="cant_ped"/>
                            <div class="row">
                                <div class="col-xl-12 offset-xl-0">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Estado <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="estado" name="estado" onchange="mostrar_si_aprobado(this.value);" class="default-select2 form-control cargo" data-size="10" data-live-search="true" data-parsley-group="step-1" data-style="btn-info" required>
                                                <option value="" selected disabled>Seleccione una Opción</option>
                                                <option value="A">APROBADO</option>
                                                <option value="B">RECHAZADO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                
                                <div class="col-xl-12 offset-xl-0" id="aprobado" style="display: none">
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Clasificación Presupuestaria <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="presupuesto" name="presupuesto" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" required>
                                                                                                    
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Cantidad Aprobada <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" id="cantidad" name="cantidad" placeholder="INGRESE CANTIDAD APROBADA" data-parsley-group="step-2" data-parsley-required="true" class="form-control formulario1" onkeypress="return solo_numeros(event)" required/>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <br><br>
                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Asignar Presupuesto</button>
                                </div>
                            </div>
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

    
    <div class="modal fade" id="modal-dialog3" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 40% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actualizar Detalles del Artículo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    
                    <div class="panel-body">
                        <form class="form-horizontal" id="editar" data-parsley-validate="true" name="demo-form">
                           @csrf
                            <input type="hidden" id="eid" name="eid"/>
                            <input type="hidden" id="eno_pedido" name="eno_pedido"/>
                            <input type="hidden" id="ecant_ped" name="ecant_ped"/>
                            <div class="row">
                                <div class="col-xl-12 offset-xl-0">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Estado <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="eestado" name="eestado" onchange="mostrar_si_eaprobado(this.value);" class="default-select2 form-control cargo" data-size="10" data-live-search="true" data-parsley-group="step-1" data-style="btn-info" required>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                
                                <div class="col-xl-12 offset-xl-0" id="eaprobado" style="display: none">
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Clasificación Presupuestaria <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="epresupuesto" name="epresupuesto" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" required>
                                                                                                    
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Cantidad Aprobada <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" id="ecantidad" name="ecantidad" placeholder="INGRESE CANTIDAD APROBADA" data-parsley-group="step-2" data-parsley-required="true" class="form-control formulario1" onkeypress="return solo_numeros(event)" required/>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <br><br>
                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Asignar Presupuesto</button>
                                </div>
                            </div>
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

    
    <div class="modal fade" id="modal-dialog4" role="dialog" style="overflow-y: scroll">
        <div class="modal-dialog" style="max-width: 40% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actualizar Detalles del Artículo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    
                    <div class="panel-body">
                        <form class="form-horizontal" id="editar_estado" data-parsley-validate="true" name="demo-form">
                           @csrf
                            <input type="hidden" id="pid" name="pid"/>
                            <input type="hidden" id="pno_pedido" name="pno_pedido"/>
                            <input type="hidden" id="pcant_ped" name="pcant_ped"/>
                            <div class="row">
                                <div class="col-xl-12 offset-xl-0">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Estado <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="pestado" name="pestado" onchange="mostrar_si_paprobado(this.value);" class="default-select2 form-control cargo" data-size="10" data-live-search="true" data-parsley-group="step-1" data-style="btn-info" required>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                
                                <div class="col-xl-12 offset-xl-0" id="paprobado" style="display: none">
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Clasificación Presupuestaria <span class="text-danger">*</span> :</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select id="ppresupuesto" name="ppresupuesto" class="default-select2 form-control" data-parsley-group="step-1" data-size="10" data-live-search="true" required>
                                                                                                    
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label">Cantidad Aprobada <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" id="pcantidad" name="pcantidad" placeholder="INGRESE CANTIDAD APROBADA" data-parsley-group="step-2" data-parsley-required="true" class="form-control formulario1" onkeypress="return solo_numeros(event)" required/>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <br><br>
                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <button type="submit" class="btn btn-primary">Actualizar Presupuesto</button>
                                </div>
                            </div>
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
 
@endsection

@push('scripts')

<script>
    function anular_pedido_articulo(){
        let dato = $('#no_rechazo').val();
        let dato2 = $('#rechazo').val();
        $.ajax({
            type:'POST',
            url:"{{route('anular.pedido.presupuesto')}}",
            data:{ _token: '{{ csrf_token ()}}', no:dato, obs:dato2},
            success:function(html){
                if(html == 1){
                    $('#modal-without-animation').modal('hide');
                    $('#lista').DataTable().ajax.reload();
                    swal({ icon: "success", title: "Se ha rechazado el Pedido"});
                }
                else if(html == 2) swal({ icon: "warning", title: "Debe llenar el Motivo de Rechazo del Pedido"});
                else if(html == 3) swal({ icon: "warning", title: "El Motivo del Rechazo debe empezar con una Letra del Abecedario"});
                else{swal({ icon: "error", title: "Ha ocurrido un error"});}
            }
            
        });
    }
</script>


<script>
    function imprimir_pedido(dato){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.pedido.presupuesto') }}',
            data:{ _token: '{{ csrf_token ()}}', no_pedido:dato},
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
    function mostrar_si_aprobado(dato){
        let opcion = dato;
        if (opcion == "A") {
            $('#aprobado').show();
        }
        else{
            $('#aprobado').hide();
        }
        
    }

    function mostrar_si_eaprobado(dato){
        let opcion = dato;
        if (opcion == "A") {
            $('#eaprobado').show();
        }
        else{
            $('#eaprobado').hide();
        }
        
    }

    function mostrar_si_paprobado(dato){
        let opcion = dato;
        if (opcion == "A") {
            $('#paprobado').show();
            mostrar_ppresupuesto();
            let valor = $('#pcant_ped').val();
            $('#pcantidad').val(valor);
        }
        else{
            $('#paprobado').hide();
        }
        
    }
</script>


<script>
    function mostrar_organo(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.organo') }}',
            data:$(this).serialize(),
            success:function(organo){
                $('#organo').html(organo);
            }
            
        });
    }

    function mostrar_fuente(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.fuente') }}',
            data:$(this).serialize(),
            success:function(fuente){
                $('#fuente').html(fuente);
            }
            
        });
    }

    function mostrar_presupuesto(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.presupuesto') }}',
            data:$(this).serialize(),
            success:function(presupuesto){
                $('#presupuesto').html(presupuesto);
            }
            
        });
    }
</script>


<script>
    function mostrar_porgano(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.organo') }}',
            data:$(this).serialize(),
            success:function(organo){
                $('#porgano').html(organo);
            }
            
        });
    }

    function mostrar_pfuente(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.fuente') }}',
            data:$(this).serialize(),
            success:function(fuente){
                $('#pfuente').html(fuente);
            }
            
        });
    }

    function mostrar_ppresupuesto(){
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.presupuesto') }}',
            data:$(this).serialize(),
            success:function(presupuesto){
                $('#ppresupuesto').html(presupuesto);
            }
            
        });
    }
</script>


<script>
    let f, o;
    function valor_fuente(dato){
        let id_fuente = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('valor.fuente') }}',
            data:{ _token: '{{ csrf_token ()}}', id_fuente:id_fuente},
            success:function(html){
                f=html[1];
                const fue = $('#fuente_fnto').val(), fec=fue.split("/");
                const cad = $('#fuente_fnto').val();
                const newcad = cad.replace(fec[0], f);
                $('#fuente_fnto').val(newcad);
                $('#fuente_fnto2').val(newcad);
            }
            
        });
    }

    function valor_organo(dato){
        let id_organo = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('valor.organo') }}',
            data:{ _token: '{{ csrf_token ()}}', id_organo:id_organo},
            success:function(html){
                o = html[1];
                const fue = $('#fuente_fnto').val(), fec=fue.split("/");
                
                const cad = $('#fuente_fnto').val();
                const newcad = cad.replace(fec[1], o);
                $('#fuente_fnto').val(newcad);
                $('#fuente_fnto2').val(newcad);
            }
            
        });
    }
</script>

<script>
    let ef, eo;
    function valor_efuente(dato){
        let id_fuente = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('valor.fuente') }}',
            data:{ _token: '{{ csrf_token ()}}', id_fuente:id_fuente},
            success:function(html){
                ef=html[1];
                const fue = $('#efuente_fnto').val(), fec=fue.split("/");
                
                const cad = $('#efuente_fnto').val();
                const newcad = cad.replace(fec[0], ef);
                $('#efuente_fnto').val(newcad);
                $('#efuente_fnto2').val(newcad);
            }
            
        });
    }

    function valor_eorgano(dato){
        let id_organo = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('valor.organo') }}',
            data:{ _token: '{{ csrf_token ()}}', id_organo:id_organo},
            success:function(html){
                eo = html[1];
                const fue = $('#efuente_fnto').val(), fec=fue.split("/");
                
                const cad = $('#efuente_fnto').val();
                const newcad = cad.replace(fec[1], eo);
                $('#efuente_fnto').val(newcad);
                $('#efuente_fnto2').val(newcad);
            }
            
        });
    }
</script>

<script>
    let pf, po;
    function valor_pfuente(dato){
        let id_fuente = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('valor.fuente') }}',
            data:{ _token: '{{ csrf_token ()}}', id_fuente:id_fuente},
            success:function(html){
                pf=html[1];
                verificarp(pf, po);
            }
            
        });
    }

    function valor_porgano(dato){
        let id_organo = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('valor.organo') }}',
            data:{ _token: '{{ csrf_token ()}}', id_organo:id_organo},
            success:function(html){
                po = html[1];
                verificarp(pf, po);
            }
            
        });
    }

    function verificarp(pf, po){
        if(pf!=null && po!=null){
            $('#pfuente_fnto').val(pf+"/"+po);
            $('#pfuente_fnto2').val(pf+"/"+po);
        }
    }
</script>


<script>
    $(function(){
        $('#enviar').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("enviar"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('asignar.presupuesto.articulo')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista2').DataTable().ajax.reload();
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog2').modal('hide');
                        swal({ icon: "success", title: "Se ha registrado el Presupuesto"});
                    }
                    else if(html == 4){
                        $('#lista2').DataTable().ajax.reload();
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog2').modal('hide');
                        swal({ icon: "warning", title: "Llene el Motivo de Rechazo del Pedido"});
                    }
                    else if(html == 0){
                        swal({ icon: "warning", title: "La cantidad debe ser menor o igual a la cantidad pedida y distinto de 0"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });

    $(function(){
        $('#editar').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('editar.presupuesto.articulo')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista2').DataTable().ajax.reload();
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog3').modal('hide');
                        swal({ icon: "success", title: "Se ha actualizado el Presupuesto"});
                    }
                    else if(html == 4){
                        $('#lista2').DataTable().ajax.reload();
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog3').modal('hide');
                        swal({ icon: "warning", title: "Llene el Motivo de Rechazo del Pedido"});
                    }
                    else if(html == 0){
                        swal({ icon: "warning", title: "La cantidad debe ser menor o igual a la cantidad pedida y distinto de 0"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });

    $(function(){
        $('#editar_estado').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar_estado"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('editar.estado.presupuesto.articulo')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista2').DataTable().ajax.reload();
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog4').modal('hide');
                        swal({ icon: "success", title: "Se ha actualizado el Presupuesto"});
                    }
                    else if(html == 4){
                        $('#lista2').DataTable().ajax.reload();
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog4').modal('hide');
                        swal({ icon: "warning", title: "Llene el Motivo de Rechazo del Pedido"});
                    }
                    else if(html == 0){
                        swal({ icon: "warning", title: "La cantidad debe ser menor o igual a la cantidad pedida y distinto de 0"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });
</script>


<script>
    $(function(){
        $('#enviarf').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("enviarf"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('asignar.fuente.fnto.pedido')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog5').modal('hide');
                        swal({ icon: "success", title: "Se ha registrado la Fuente de Financiamiento"});
                        ver(html[1]);
                        $('#modal-without-animation').modal('show');
                    }
                    if(html[0] != 1){swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });

    $(function(){
        $('#editarf').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editarf"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('editar.fuente.fnto.pedido')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-dialog6').modal('hide');
                        swal({ icon: "success", title: "Se ha actualizado la Fuente de Financiamiento"});
                        ver(html[1]);
                        $('#modal-without-animation').modal('show');
                    }
                    if(html[0] != 1){swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });
</script>


<script>
    function enviar(dato){
        let id=dato;
        $('#presupuesto').empty();
        $('#id').val('');
        $('#no_pedido').val('');
        $('#cant_ped').val('');
        $('#cantidad').val('');
        $.ajax({
            type:'POST',
            url:"{{ route('ver.editar.pedido') }}",
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                document.getElementById("id").value = html[0];
                document.getElementById("no_pedido").value = html[18];
                document.getElementById("cant_ped").value = html[9];
                document.getElementById("cantidad").value = html[9];
                let id_presupuesto = html[21];
                $.ajax({
                    type:'POST',
                    url:"{{ route('ver.listar.pedido.presupuesto') }}",
                    data:{ _token: '{{ csrf_token ()}}', id_presupuesto:id_presupuesto},
                    success:function(presupuesto){
                        $('#presupuesto').html(presupuesto);
                    }
                    
                });
            }
            
        });
    }
</script>


<script>
    function enviarf(dato){
        let no_ped=dato;
        $.ajax({
            type:'POST',
            url:"{{ route('ver.editar.fuente.fnto.pedido') }}",
            data:{ _token: '{{ csrf_token ()}}', no:no_ped},
            success:function(html){
                mostrar_fuente();
                mostrar_organo();
                document.getElementById("no_pedidof").value = html[1];
                $('#fuente_fnto').val("XX/YYY");
                $('#fuente_fnto2').val("XX/YYY");
                
            }
            
        });
    }
</script>


<script>
    function editar(dato){
        let id=dato;
        $.ajax({
            type:'POST',
            url:"{{ route('ver.editar.pedido.presupuesto') }}",
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                document.getElementById("eid").value = html[0];
                document.getElementById("eno_pedido").value = html[8];
                let estado = html[1];
                if (estado == "A") {
                    $('#eaprobado').show();
                    $('#eestado').empty();
                    $('#eestado').append('<option value="A">APROBADO</option><option value="B">RECHAZADO</option>');
                    document.getElementById("ecant_ped").value = html[6];
                    document.getElementById("ecantidad").value = html[7];

                    let id_presupuesto = html[5];
                    $.ajax({
                        type:'POST',
                        url:"{{ route('ver.listar.pedido.presupuesto') }}",
                        data:{ _token: '{{ csrf_token ()}}', id_presupuesto:id_presupuesto},
                        success:function(presupuesto){
                            $('#epresupuesto').html(presupuesto);
                        }
                        
                    });
                } 
                
            }
            
        });
    }
</script>


<script>
    function editarf(dato){
        let no=dato;
        $.ajax({
            type:'POST',
            url:"{{ route('ver.editar.fuente.fnto.pedido') }}",
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                document.getElementById("no_pedidofe").value = html[1];
                document.getElementById("efuente_fnto").value = html[0];
                document.getElementById("efuente_fnto2").value = html[0];
                let id_fuente = html[2];
                $.ajax({
                    type:'POST',
                    url:"{{ route('ver.editar.pedido.fuente') }}",
                    data:{ _token: '{{ csrf_token ()}}', id_fuente:id_fuente},
                    success:function(fuente){
                        $('#efuente').html(fuente);
                    }
                    
                });

                let id_organo = html[3];
                $.ajax({
                    type:'POST',
                    url:"{{ route('ver.editar.pedido.organo') }}",
                    data:{ _token: '{{ csrf_token ()}}', id_organo:id_organo},
                    success:function(organo){
                        $('#eorgano').html(organo);
                    }
                    
                });
                
            }
            
        });
    }
</script>


<script>
    function editar_estado(dato){
        let id=dato;
        $.ajax({
            type:'POST',
            url:"{{ route('ver.editar.pedido.presupuesto') }}",
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                document.getElementById("pid").value = html[0];
                document.getElementById("pno_pedido").value = html[8];
                document.getElementById("pcant_ped").value = html[6];
                let estado = html[1];
                
                if(estado == "B"){
                    $('#pestado').empty();
                    $('#pestado').append('<option value="B">RECHAZADO</option><option value="A">APROBADO</option>');
                    $('#paprobado').hide();
                }
                
            }
            
        });
    }
</script>


<script>
    $(document).ready( function () {
        $('#lista').DataTable({
            "ajax": {
                url: "{{route('ver.lista.pedido.pendiente')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'fecha_pedido' , name: 'fecha_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'responsable' , name: 'responsable'},
                        {data: 'motivo' , name: 'motivo'},
                        {data: 'estado' , 
                            render: function(name){
                                name: 'estado';
                                if(name=="PENDIENTE"){
                                    return '<abbr title="Pedido Pendiente"><button class="btn btn-warning"><i class="fab fa-product-hunt"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="APROBADO"){
                                    return '<abbr title="Pedido Aprobado"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="RECHAZADO"){
                                    return '<abbr title="Pedido Rechazado"><button class="btn btn-danger"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
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
        $('#rechazo').val('');
        $.ajax({
            type:'POST',
            url:"{{ route('listar.pedido.articulo.pendiente.observacion') }}",
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                $('#no_rechazo').val(html[1]);
                if(html[0] != ""){
                    $('#rechazo').val(html[0]);
                }
                if(html[2] == "PENDIENTE" || html[2] == "RECHAZADO"){
                    $('#mostrar_rechazo').show();
                }
                else{
                    $('#mostrar_rechazo').hide();
                }
                
            }
            
        });
        $('#lista2').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.pendiente') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data:'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'unidad_medida' , name: 'unidad_medida'},
                        {data: 'descripcion' , name: 'descripcion'},
                        {data: 'cantidad' , name: 'cantidad'},
                        {data: 'cod_presup' , name: 'cod_presup'},
                        {data: 'archivo' , 
                            render: function(name){
                                name: 'archivo';
                                if(name!="VACIO"){
                                    return '<abbr title="Ver Archivo"><a href="'+name+'" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;</abbr>';
                                }
                                else return "";
                            }
                        },
                        {data: 'estado_articulo' , 
                            render: function(name){
                                name: 'estado_articulo';
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
            { orderable: false, targets: 6 }
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
            
            "ajax": {
                type:'POST',
                url:'{{ route('lista.pedido.pendiente.valor') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2, est_ped3:est_ped3}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'fecha_pedido' , name: 'fecha_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'responsable' , name: 'responsable'},
                        {data: 'motivo' , name: 'motivo'},
                        {data: 'estado' , 
                            render: function(name){
                                name: 'estado';
                                if(name=="PENDIENTE"){
                                    return '<abbr title="Pedido Pendiente"><button class="btn btn-warning"><i class="fab fa-product-hunt"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="APROBADO"){
                                    return '<abbr title="Pedido Aprobado"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="RECHAZADO"){
                                    return '<abbr title="Pedido Rechazado"><button class="btn btn-danger"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
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
    function convertirEnMayusculas(e){
        e.value = e.value.toUpperCase();
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