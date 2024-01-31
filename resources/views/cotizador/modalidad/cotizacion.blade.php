@extends('layouts.default')

@section('title', 'Cotizadores')

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
    
    
    <h1 class="page-header">Lista de Pedidos para su Cotización</h1>
    <h4>Contratación Menor</h4>
        
    <div class="col-xl-12">
        <div>
            <form class="form-horizontal" id="filtrar" data-parsley-validate="true" name="demo-form">
                <div class="col-md-9">
                    <h4 class="panel-title">Filtrar por Estado</h4>
                    <div class="checkbox checkbox-css">
                        <input type="checkbox" name="ped_pendiente" id="ped_pendiente" value="1" onchange="pendientes(this.value);"/>
                        <label for="ped_pendiente">Pedidos Pendientes de Cotización</label>
                    </div>
                    <div class="checkbox checkbox-css is-valid">
                        <input type="checkbox" name="ped_aprobado" id="ped_aprobado" value="2" onchange="aprobados(this.value);"/>
                        <label for="ped_aprobado">Pedidos Cotizados</label>
                    </div>
                </div>
            </form>
        </div>
        <br>
        
        <div class="panel panel-inverse">
            
            <div class="panel-heading">
                <h4 class="panel-title">LISTA DE PEDIDOS PARA SU COTIZACIÓN</h4>
            </div>
            
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="lista" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">Nº</th>
                                <th class="text-nowrap">Nº PEDIDO</th>
                                <th class="text-nowrap">UNIDAD ADMINISTRATIVA</th>
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </th>
                                <th class="text-nowrap">CUADRO COMPARATIVO</th>
                                <th class="text-nowrap">&nbsp; &nbsp; &nbsp; ORDEN DE COMPRA &nbsp; &nbsp; &nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        
        
        <div class="modal" id="modal-without-animation2" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        
                        <form id="guardar_datos_cotizacion" method="POST">
                           @csrf
                           <input type="hidden" value="A" id="estado" name="estado">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Fecha de Cotización</label>
                                <div class="input-group date" id="datepicker-disabled-past" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fecha_cot" id="fecha_cot" required/>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">Proveedor</label>
                                <div class="col-lg-8">
                                    <select name="proveedor" id="proveedor" class="default-select2 form-control" required></select>
                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Validez de la Oferta (días)</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="oferta" name="oferta" placeholder="Validez de la Oferta en Días" data-parsley-required="true" onkeypress="return solo_numeros_precio(event)" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Tiempo de Entrega en Oficinas UATF (días)</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="tiempo" name="tiempo" placeholder="Tiempo de Entrega en Días" data-parsley-required="true" onkeypress="return solo_numeros_precio(event)" required/>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="lista3" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">PRECIO TOTAL</th>
                                            <th class="text-nowrap">CUMPLIMIENTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="guardar_cotizacion" name="guardar" value="A" onclick="valor(this.value)">Guardar y Continuar Cotización</button> 
                                <button class="btn btn-danger float-right" id="rechazar_cotizacion" name="rechazar" value="R" onclick="valor(this.value)">Guardar y Terminar Cotización</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="modal-without-animation3" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo2"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="editar_datos_cotizacion" method="POST">
                           @csrf
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Fecha de Cotización</label>
                                <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fecha_cote" id="fecha_cote" required/>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label">Proveedor</label>
                                <div class="col-lg-8">
                                    <select name="proveedore" id="proveedore" class="default-select2 form-control" required></select>
                            
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Validez de la Oferta (días)</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="ofertae" name="ofertae" placeholder="Validez de la Oferta en Días" data-parsley-required="true" onkeypress="return solo_numeros(event)" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Tiempo de Entrega en Oficinas UATF (días)</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="tiempoe" name="tiempoe" placeholder="Tiempo de Entrega en Días" data-parsley-required="true" onkeypress="return solo_numeros(event)" required/>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="lista4" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">PRECIO TOTAL</th>
                                            <th class="text-nowrap">CUMPLIMIENTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="editar_cotizacion" name="editar">Actualizar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="modal-without-animation4" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Vista de Órdenes Generados</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="ver_orden" method="POST">
                           @csrf
                            <div class="table-responsive">
                                <table id="lista5" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">FECHA</th>
                                            <th class="text-nowrap">Nº DE ORDEN</th>
                                            <th class="text-nowrap">PROVEEDOR</th>
                                            <th class="text-nowrap">TIEMPO ENTREGA</th>
                                            <th class="text-nowrap">TOTAL</th>
                                            <th class="text-nowrap"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="modal-without-animation6" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Artículos en la Orden Respectiva</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="table-responsive">
                            <table id="lista6" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Nº</th>
                                        <th class="text-nowrap">CANTIDAD</th>
                                        <th class="text-nowrap">UNIDAD</th>
                                        <th class="text-nowrap">ARTICULO</th>
                                        <th class="text-nowrap">PRECIO UNITARIO</th>
                                        <th class="text-nowrap">IMPORTE</th>
                                        <th class="text-nowrap"></th>
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

        <div class="modal" id="modal-without-animation7" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cuadro Comparativo de Precios</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="lista7" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Nº</th>
                                        <th class="text-nowrap">DETALLE</th>
                                        <th class="text-nowrap">CANTIDAD</th>
                                        <th class="text-nowrap"></th>
                                        <th class="text-nowrap">CUMPLE</th>
                                        <th class="text-nowrap"></th>
                                        <th class="text-nowrap">CUMPLE</th>
                                        <th class="text-nowrap"></th>
                                        <th class="text-nowrap">CUMPLE</th>
                                        <th class="text-nowrap"></th>
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

        <div class="modal" id="modal-without-animation8" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo_cont"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        
                        <form id="guardar_datos_contrato" method="POST">
                            @csrf
                            <input type="hidden" value="" id="fecha_cont2" name="fecha_cont2">
                            <input type="hidden" name="orden_cont" id="orden_cont">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Fecha de Contrato <span class="text-danger">*</span> :</label>
                                <div class="input-group date" id="datepicker-disabled-past2" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fecha_cont" id="fecha_cont" required/>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group row">
 
                                <label class="col-lg-4 col-form-label">Proveedor <span class="text-danger">*</span> :</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="prov_cont" name="prov_cont" placeholder="NOMBRE DEL PROVEEDOR" data-parsley-required="true" required disabled/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Nº de Contrato <span class="text-danger">*</span> :</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" pattern="^[0-9]{4}/[0-9]{4}$" id="contrato" name="contrato" placeholder="INGRESE EL Nº DE CONTRATO" data-parsley-required="true" maxlength="9" onkeypress="return solo_numeros_contrato(event)" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Tiempo de Entrega en Oficinas UATF (días) <span class="text-danger">*</span> :</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="tiempo_cont" name="tiempo_cont" placeholder="TIEMPO DE ENTREGA EN DÍAS" data-parsley-required="true" onkeypress="return solo_numeros(event)" required disabled/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Monto Adjudicado (Bs.) <span class="text-danger">*</span> :</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="monto_cont" name="monto_cont" placeholder="IMPORTE TOTAL DE LA COMPRA" data-parsley-required="true" required disabled/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Adjuntar Archivo <span class="text-danger">*</span> :</label>
                                <div class="col-md-8 col-sm-8">
                                    <input type="file" name="archivo" id="archivo" accept=".pdf" required>
                                </div>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="guardar_contrato" name="guardar_cont">Guardar Contrato</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modal-without-animation9" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Anular Contrato</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="alert alert-danger m-b-0">
                            <h3 style="text-align: center"><i class="fa fa-info-circle"></i> Alerta de Anulación del Contrato</h3>
                            <p>¿Está seguro de Anular el Contrato para este Orden? 
                                <br> Si está seguro de anular presione el botón de Anular.</p>
                            <form action="{{ route('eliminar.contrato') }}" id="eliminar_cont" method="POST">
                                
                                @csrf
                                <input type="hidden" id="no_conte" name="no_conte" value="">
                                
                                <dl class="row">
                                    <dt class="text-inverse text-right col-4 text-truncate">Nº de Orden:</dt>
                                    <dd class="col-8 text-truncate"><label id="pno_orden"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Fecha de Orden:</dt>
                                    <dd class="col-8 text-truncate"><label id="pfecha_orden"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Nº de Contrato:</dt>
                                    <dd class="col-8 text-truncate"><label id="pno_cont"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Fecha de Contrato:</dt>
                                    <dd class="col-8 text-truncate"><label id="pfecha_cont"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Proveedor:</dt>
                                    <dd class="col-8 text-truncate"><label id="pproveedor"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Tiempo de Entrega:</dt>
                                    <dd class="col-8 text-truncate"><label id="ptiempo"></label></dd>
                                    <dt class="text-inverse text-right col-4 text-truncate">Monto Adjudicado (Bs.): </dt>
                                    <dd class="col-8 text-truncate"><label id="pmonto"></label></dd>
                                    
                                </dl>
                                <button type="submit" class="btn btn-danger">Anular</button>  
                            </form>
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
    
 
@endsection

@push('scripts')

<script>
    function valor(valor){
        $('#estado').val(valor);
    }
</script>


<script>
    function imprimir_orden(dato, dato2){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.orden.cotizador') }}',
            data:{ _token: '{{ csrf_token ()}}', pedido:dato, valor:dato2},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>


<script>
    function imprimir_cuadro_comparativo(dato, dato2){
        
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.cuadro.cotizador') }}',
            data:{ _token: '{{ csrf_token ()}}', pedido:dato, solic:dato2},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>


<script>
    let valor1=0, valor2=0;
    function pendientes(dato){
        let dp = dato;
        if(ped_pendiente.checked) valor1=dp;
        else valor1=0;
        filtrar(valor1, valor2);
    }

    function aprobados(dato){
        let dp = dato;
        if(ped_aprobado.checked) valor2=dp;
        else valor2=0;
        filtrar(valor1, valor2);
    }
</script>


<script>
    function filtrar(dato1, dato2){
        $('#lista'). DataTable().clear().destroy();
        let est_ped1=dato1;
        let est_ped2=dato2;
        $('#lista').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('lista.pedido.proveedor.cotizador.valor') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'boton', name: 'boton'},
                        {data: 'val2' , 
                            render: function(name){
                                name: 'val2';
                                const estado = name, est=estado.split("/");
                                const v = est[0];
                                const p = est[1];
                                var pe = parseInt(p);
                                const s = est[2];
                                if(v == 1){
                                    return '<abbr title="Ver Cuadro Comparativo"><button onclick="cuadro('+pe+','+s+')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation7"><i class="far fa-eye"></i></button>&nbsp;</abbr> <abbr title="Ver PDF Cuadro Comparativo"><button onclick="imprimir_cuadro_comparativo('+pe+','+s+')" class="btn btn-info"><i class="fas fa-file-pdf"></i></button>&nbsp;</abbr>';
                                }
                                else return '';
                            }
                        },
                        {data: 'val' , 
                            render: function(name){
                                name: 'val';
                                const estado = name, est=estado.split("/");
                                const v = est[0];
                                const p = est[1];
                                var pe = parseInt(p);
                                const o = est[2];
                                let html='';
                                if(v == 1){
                                    html+='<abbr title="Ver Órdenes"><button onclick="observar('+pe+')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation4"><i class="far fa-eye"></i></button>&nbsp;</abbr>';
                                    for (let i = 1; i <= o; i++) {
                                        html+='<abbr title="Ver Orden de Compra Nº/Contrato '+i+'"><button onclick="imprimir_orden('+pe+','+i+')" class="btn btn-info"><i class="fas fa-file-pdf"></i></button>&nbsp;</abbr>';
                                    }
                                    return html;
                                }
                                else return '';
                            }
                        }
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
            { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function cuadro(dato, dato2){
        
        let no=dato;
        let id_sol = dato2;
        $.ajax({
            type:'POST',
            url:'{{ route('cuadro.proveedor2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol},
            success:function(html){
                
                cuadro2(no, id_sol, html[0], html[1], html[2]);
            }
        });
    }
    
</script>


<script>
    function cuadro2(dato, dato2, prov1, prov2, prov3){
        $('#lista7').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        $('#lista7').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('cuadro.proveedor') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol}
            },
            
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'precio2', name:'precio2'},
                        {data: 'cumple2', name:'cumple2'},
                        {data: 'precio', name:'precio'},
                        {data: 'cumple', name:'cumple'},
                        {data: 'precio3', name:'precio3'},
                        {data: 'cumple3', name:'cumple3'},
                        {data: 'boton', name:'boton'},
                        
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista7").DataTable().clear().draw();
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
                { targets: 3, title: prov2 },
                { targets: 5, title: prov1 },
                { targets: 7, title: prov3 },
                { orderable: false, targets: 9, visible: false }
            ],
        });
        
    }
    
</script>


<script>
    function mostrar_proveedor(dato){
        let id=dato;
        $.ajax({
            type:'POST',
            url:'{{ route('recuperar.proveedor') }}',
            data:{ _token: '{{ csrf_token ()}}', id:id},
            success:function(html){
                $('#proveedor').html(html);
            }
            
        });
    }
</script>


<script>
    $(function(){

        $('#guardar_datos_cotizacion').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos_cotizacion"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('guardar.datos.cotizacion')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        if(html[1] == 1) {
                            $('#modal-without-animation2').modal('hide');
                            swal({ icon: "success", title: "Registro de Primera Cotización Correcta"});
                            
                            ver3(html[2])
                            $('#titulo').text("Llenar Datos de la Segunda Cotización");
                            $('#modal-without-animation2').modal('show');
                        }
                        if(html[1] == 2) {
                            $('#modal-without-animation2').modal('hide');
                            swal({ icon: "success", title: "Registro de Segunda Cotización Correcta"});
                            
                            ver3(html[2])
                            $('#titulo').text("Llenar Datos de la Tercera Cotización");
                            $('#modal-without-animation2').modal('show');
                        }
                        if(html[1] == 3) {
                            $('#modal-without-animation2').modal('hide');
                            swal({ icon: "success", title: "Registro de Tercera Cotización Correcta"});
                        }
                    }
                    else if(html[0] == 5){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-without-animation2').modal('hide');
                        swal({ icon: "success", title: "Registro de Cotizaciones"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });

        $('#editar_datos_cotizacion').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar_datos_cotizacion"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('editar.datos.cotizacion')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-without-animation3').modal('hide');
                        swal({ icon: "success", title: "Actualización Correcta"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });
</script>


<script>
    $(function(){

        $('#guardar_datos_contrato').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos_contrato"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('guardar.datos.contrato')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista5').DataTable().ajax.reload();
                        $('#modal-without-animation8').modal('hide');
                        swal({ icon: "success", title: "Registro de Contrato Correcto"});
                        $('#tiempo_cont').val('');
                        $('#prov_cont').val('');
                        $('#monto_cont').val(" Bs.");
                        $('#fecha_cont').val('');
                        $('#fecha_cont2').val('');
                        $('#orden_cont').val('');
                        $('#contrato').val('');
                        $('#archivo').val('');
                    }
                    else if(html == 3){
                        swal({ icon: "warning", title: "Debe subir el Contrato Digitalizado"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });
</script>


<script>
    $(document).ready( function () {
        $('#lista').DataTable({
            "ajax": {
                url: "{{route('lista.pedido.proveedor.cotizador')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'boton', name: 'boton'},
                        {data: 'val2' , 
                            render: function(name){
                                name: 'val2';
                                const estado = name, est=estado.split("/");
                                const v = est[0];
                                const p = est[1];
                                var pe = parseInt(p);
                                const s = est[2];
                                if(v == 1){
                                    return '<abbr title="Ver Cuadro Comparativo"><button onclick="cuadro('+pe+','+s+')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation7"><i class="far fa-eye"></i></button>&nbsp;</abbr> <abbr title="Ver PDF Cuadro Comparativo"><button onclick="imprimir_cuadro_comparativo('+pe+','+s+')" class="btn btn-info"><i class="fas fa-file-pdf"></i></button>&nbsp;</abbr>';
                                }
                                else return '';
                            }
                        },
                        {data: 'val' , 
                            render: function(name){
                                name: 'val';
                                const estado = name, est=estado.split("/");
                                const v = est[0];
                                const p = est[1];
                                var pe = parseInt(p);
                                const o = est[2];
                                let html='';
                                if(v == 1){
                                    html+='<abbr title="Ver Órdenes"><button onclick="observar('+pe+')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation4"><i class="far fa-eye"></i></button>&nbsp;</abbr>';
                                    for (let i = 1; i <= o; i++) {
                                        html+='<abbr title="Ver Orden de Compra Nº/Contrato '+i+'"><button onclick="('+pe+','+i+')" class="btn btn-info"><i class="fas fa-file-pdf"></i></button>&nbsp;</abbr>';
                                    }
                                    return html;
                                }
                                else return '';
                            }
                        }
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
            { orderable: false, targets: 4 }
            ],
        });
        
    });
</script>


<script>
    function ver(dato){
        $('#lista2').DataTable().clear().destroy();
        let no=dato;
        let i=0;
        $('#aceptar').show();
        $('#lista2').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.pendiente.cotizador') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'boton', name:'boton'},
                        {data: 'archivo' , 
                            render: function(name){
                                name: 'archivo';
                                if(name!="VACIO"){
                                    return '<abbr title="Ver Archivo"><a href="'+name+'" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;</abbr>';
                                }
                                else return "";
                            }
                        },
                        
                        
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function ver2(dato){
        $('#lista2').DataTable().clear().destroy();
        let no=dato;
        let i=0;
        $('#aceptar').hide();
        $('#lista2').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.pendiente.cotizador') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'boton', name:'boton'},
                        {data: 'archivo' , 
                            render: function(name){
                                name: 'archivo';
                                if(name!="VACIO"){
                                    return '<abbr title="Ver Archivo"><a href="'+name+'" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;</abbr>';
                                }
                                else return "";
                            }
                        },
                        
                        
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function ver3(dato){
        $('#lista3').DataTable().clear().destroy();
        let no=dato;
        let i=0;
        $('#fecha_cot').val('');
        $.ajax({
            type:'POST',
            url:'{{ route('listar.pedido.articulo.proveedor.cotizador2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                const f = html[2], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                $('#datepicker-disabled-past').datepicker('setStartDate', fec);
                $('#datepicker-disabled-past').datepicker('setEndDate', html[3]);
                if (html[4] == 0) {
                    $('#titulo').text("Llenar Datos de la Primera Cotización");
                    $('#rechazar_cotizacion').show();
                }
                if (html[4] == 1) {
                    $('#titulo').text("Llenar Datos de la Segunda Cotización");
                    $('#rechazar_cotizacion').show();
                }
                if (html[4] == 2) {
                    $('#titulo').text("Llenar Datos de la Tercera Cotización");
                    $('#rechazar_cotizacion').hide();
                }
                mostrar_proveedor(html[5]);
                $('#oferta').val('');
                $('#tiempo').val('');
            }
            
        });
        $('#lista3').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.proveedor.cotizador') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'val' , 
                            render: function(name){
                                name: 'val';
                                return '<select name="cumple[]" id="cumple" class="default-select2 form-control" required><option value="" disabled selected>Seleccione una Opción</option><option value="SI">SI</option><option value="NO">NO</option></select>';
                            }
                        },
                        
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista3").DataTable().clear().draw();
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function editar(dato, dato2, dato3){
        $('#lista4').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let valor = dato3;
        let i=0;
        $("#editar_cotizacion").show();
        if(valor == 1){
            $('#titulo2').text("Actualizar Datos de la Primera Cotización");
        }
        if(valor == 2){
            $('#titulo2').text("Actualizar Datos de la Segunda Cotización");
        }
        if(valor == 3){
            $('#titulo2').text("Actualizar Datos de la Tercera Cotización");
        }
        $.ajax({
            type:'POST',
            url:'{{ route('editar.proveedor2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol, valor:valor},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                const g = html[0], ge=g.split("-");
                const gec = ge[2]+"-"+ge[1]+"-"+ge[0];
                $('#datepicker-default').datepicker('setStartDate', fec);
                $('#datepicker-default').datepicker('setEndDate', html[3]);
                $('#fecha_cote').val(gec);
                $('#ofertae').val(html[4]);
                $('#tiempoe').val(html[5]);

                let id_proveedor = html[2];
                $.ajax({
                    type:'POST',
                    url:'{{ route('recuperar.proveedor2') }}',
                    data:{ _token: '{{ csrf_token ()}}', id:id_proveedor, id_sol:id_sol},
                    success:function(html2){
                        $('#proveedore').html(html2);
                    }
                    
                });
            }
            
        });

        $('#lista4').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('editar.proveedor') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol, valor:valor}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'cumple' , 
                            render: function(name){
                                name: 'cumple';
                                if (name == "SI") {
                                    return '<select name="cumplee[]" id="cumplee" class="default-select2 form-control" required><option value="SI">SI</option><option value="NO">NO</option></select>';
                                }
                                else{
                                    return '<select name="cumplee[]" id="cumplee" class="default-select2 form-control" required><option value="NO">NO</option><option value="SI">SI</option></select>';
                                }
                            }
                        },
                        
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista4").DataTable().clear().draw();
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function editar2(dato, dato2, dato3){
        $('#lista4').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let valor = dato3;
        let i=0;
        $("#editar_cotizacion").hide();
        if(valor == 1){
            $('#titulo2').text("Actualizar Datos de la Primera Cotización");
        }
        if(valor == 2){
            $('#titulo2').text("Actualizar Datos de la Segunda Cotización");
        }
        if(valor == 3){
            $('#titulo2').text("Actualizar Datos de la Tercera Cotización");
        }
        $.ajax({
            type:'POST',
            url:'{{ route('editar.proveedor2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol, valor:valor},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                const g = html[0], ge=g.split("-");
                const gec = ge[2]+"-"+ge[1]+"-"+ge[0];
                $('#datepicker-default').datepicker('setStartDate', fec);
                $('#datepicker-default').datepicker('setEndDate', html[3]);
                $('#fecha_cote').val(gec);
                $('#ofertae').val(html[4]);
                $('#tiempoe').val(html[5]);

                let id_proveedor = html[2];
                $.ajax({
                    type:'POST',
                    url:'{{ route('recuperar.proveedor2') }}',
                    data:{ _token: '{{ csrf_token ()}}', id:id_proveedor, id_sol:id_sol},
                    success:function(html2){
                        $('#proveedore').html(html2);
                    }
                    
                });
            }
            
        });

        $('#lista4').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('editar.proveedor') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol, valor:valor}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'cumple' , 
                            render: function(name){
                                name: 'cumple';
                                if (name == "SI") {
                                    return '<select name="cumplee[]" id="cumplee" class="default-select2 form-control" required><option value="SI">SI</option><option value="NO">NO</option></select>';
                                }
                                else{
                                    return '<select name="cumplee[]" id="cumplee" class="default-select2 form-control" required><option value="NO">NO</option><option value="SI">SI</option></select>';
                                }
                            }
                        },
                        
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista4").DataTable().clear().draw();
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function observar(dato){
        
        $('#lista5').DataTable().clear().destroy();
        let no=dato;
        $('#lista5').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.orden') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'fecha'  , name: 'fecha'},
                        {data: 'orden' , name: 'orden'},
                        {data: 'proveedor' , name: 'proveedor'},
                        {data: 'tiempo' , name: 'tiempo'},
                        {data: 'total' , name: 'total'},
                        {data: 'boton', name:'boton'},
                        
                        
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista5").DataTable().clear().draw();
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
    function ver_articulos(dato){
        $('#lista6').DataTable().clear().destroy();
        let no=dato;
        $('#lista6').DataTable({
            
            "ajax": {
                type:'POST',
                url:"{{ route('listar.articulo.orden') }}",
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'cantidad'  , name: 'cantidad'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'precio'  , name: 'precio'},
                        {data: 'importe' , name: 'importe'},
                        {data: 'boton', name:'boton'},
            ],
            error: function(jqXHR, textStatus, errorThrown){
                $("#lista6").DataTable().clear().draw();
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
                { targets: 6, visible: false},
                { orderable: false, targets: 3 }
            ],
        });
        
    }
    
</script>


<script>
    function ver_contrato(dato){
        let no = dato;
        $('#guardar_contrato').show();
        $.ajax({
            type:'POST',
            url:'{{ route('editar.orden.contrato') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                if(html[6] != null && html[7] != null){
                    $('#titulo_cont').text('Actualizar Contrato');
                    const f = html[0], fe=f.split("-");
                    const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                    const fi = html[6], fei=fi.split("-");
                    const feci = fei[2]+"-"+fei[1]+"-"+fei[0];
                    $('#datepicker-disabled-past2').datepicker('setStartDate', fec);
                    $('#datepicker-disabled-past2').datepicker('setEndDate', html[3]);
                    $('#tiempo_cont').val(html[1]);
                    $('#prov_cont').val(html[2]);
                    $('#monto_cont').val(html[4] + " Bs.");
                    $('#fecha_cont').val(feci);
                    $('#fecha_cont2').val(html[0]);
                    $('#orden_cont').val(html[5]);
                    $('#contrato').val(html[7]);
                    $('#archivo').val('');
                }
                if(html[6] == null && html[7] == null){
                    $('#titulo_cont').text('Generar Contrato');
                    const f = html[0], fe=f.split("-");
                    const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                    $('#datepicker-disabled-past2').datepicker('setStartDate', fec);
                    $('#datepicker-disabled-past2').datepicker('setEndDate', html[3]);
                    $('#tiempo_cont').val(html[1]);
                    $('#prov_cont').val(html[2]);
                    $('#monto_cont').val(html[4] + " Bs.");
                    $('#fecha_cont2').val(html[0]);
                    $('#orden_cont').val(html[5]);
                    $('#contrato').val('');
                    $('#archivo').val('');
                }
                
            }
            
        });
    }
    
</script>


<script>
    function ver_contrato3(dato){
        let no = dato;
        $('#guardar_contrato').hide();
        $.ajax({
            type:'POST',
            url:'{{ route('editar.orden.contrato') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                if(html[6] != null && html[7] != null){
                    $('#titulo_cont').text('Actualizar Contrato');
                    const f = html[0], fe=f.split("-");
                    const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                    const fi = html[6], fei=fi.split("-");
                    const feci = fei[2]+"-"+fei[1]+"-"+fei[0];
                    $('#datepicker-disabled-past2').datepicker('setStartDate', fec);
                    $('#datepicker-disabled-past2').datepicker('setEndDate', html[3]);
                    $('#tiempo_cont').val(html[1]);
                    $('#prov_cont').val(html[2]);
                    $('#monto_cont').val(html[4] + " Bs.");
                    $('#fecha_cont').val(feci);
                    $('#fecha_cont2').val(html[0]);
                    $('#orden_cont').val(html[5]);
                    $('#contrato').val(html[7]);
                    $('#archivo').val('');
                }
                
            }
            
        });
    }
    
</script>

<script>
    function ver_contrato2(dato){
        let no = dato;
        $.ajax({
            type:'POST',
            url:'{{ route('editar.orden.contrato') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                if(html[6] != null && html[7] != null){
                    const fi = html[0], fei=fi.split("-");
                    const feci = fei[2]+"-"+fei[1]+"-"+fei[0];
                    $('#ptiempo').text(html[1] + " días");
                    $('#pno_orden').text(html[5]);
                    $('#pfecha_orden').text(feci);
                    $('#pproveedor').text(html[2]);
                    $('#pmonto').text(html[4] + " Bs.");
                    $('#pfecha_cont').text(html[6]);
                    $('#pno_cont').text(html[7]);
                    $('#no_conte').val(html[7]);
                }
                
            }
            
        });
    }
    
</script>

<script>
    $(document).on("submit" ,"#eliminar_cont", function(e){
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
                    $('#lista5').DataTable().ajax.reload();
                    $('#modal-without-animation9').modal('hide');
                    swal({ icon: "success", title: "Se ha anulado el pedido"});
                }
                else{
                    swal({ icon: "error", title: "Error, no se pudo anular"});
                }
                
            }
        });
    });
</script>


<script>
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

    function solo_numeros_contrato (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num="1234567890/";
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
        letras_num="1234567890.";
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