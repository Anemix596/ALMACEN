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
    <h4>Compra Directa</h4>
        
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
                                <th class="text-nowrap" data-orderable="false"> ACCIONES </th>
                                <th class="text-nowrap"> ORDEN DE COMPRA</th>
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
                        <h4 class="modal-title" id="titulo">Seleccionar Items para el Llenado de Datos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="guardar_datos" method="POST">
                           @csrf
                            <div class="table-responsive">
                                <table id="lista3" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">COMPRA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <a onclick="recuperar_datos()" class="btn btn-pink float-right" data-toggle="modal" data-target="#modal-without-animation3" href="#" id="llenar_datos" name="llenar_datos" style="display: none">Llenar Datos</a>
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
                        <h4 class="modal-title" id="titulo2">Llenar Datos de los Ítems</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="descargar_datos" method="POST">
                           @csrf
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
                            <div class="table-responsive">
                                <table id="lista4" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">PRECIO TOTAL (Bs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="guardar" name="guardar">Guardar Datos</button>
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
                                            <th class="text-nowrap">TOTAL</th>
                                            <th class="text-nowrap"> &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; </th>
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

        <div class="modal fade" id="modal-dialog" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Proveedor</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <form action="{{ route('insertar.proveedor') }}" id="enviarp" method="POST" name="" class="form-control-with-bg">
                                @csrf
    
                                <input type="hidden" id="id_cat3" name="id_cat3" value="0">
                                
                                <div class="panel-body">
                                    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label">Nombre: <span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control formulario2" type="text" id="provg" name="provg"  data-parsley-type="text" placeholder="INGRESE NUEVO PROVEEDOR" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required/>
                                        </div>
                                        
                                    </div>
    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label">Nombre Comercial: <span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control formulario2" type="text" id="provc" name="provc"  data-parsley-type="text" placeholder="INGRESE NOMBRE COMERCIAL DEL PROVEEDOR" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required/>
                                        </div>
                                    </div>
    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label">NIT: </label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control formulario2" type="text" id="provn" name="provn"  data-parsley-type="text" placeholder="INGRESE NIT DEL PROVEEDOR" onkeypress="return solo_numeros(event)" required/>
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
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-dialog2" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Proveedor</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <form action="{{ route('insertar.proveedor2') }}" id="enviarp2" method="POST" name="" class="form-control-with-bg">
                                @csrf
    
                                <input type="hidden" id="id_cat4" name="id_cat4" value="0">
                                
                                <div class="panel-body">
                                    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label">Nombre: <span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control formulario2" type="text" id="provg2" name="provg2"  data-parsley-type="text" placeholder="INGRESE NUEVO PROVEEDOR" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required/>
                                        </div>
                                        
                                    </div>
    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label">Nombre Comercial: <span class="text-danger">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control formulario2" type="text" id="provc2" name="provc2"  data-parsley-type="text" placeholder="INGRESE NOMBRE COMERCIAL DEL PROVEEDOR" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required/>
                                        </div>
                                    </div>
    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label">NIT: </label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control formulario2" type="text" id="provn2" name="provn2"  data-parsley-type="text" placeholder="INGRESE NIT DEL PROVEEDOR" onkeypress="return solo_numeros(event)" required/>
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
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
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

    
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    
 
@endsection

@push('scripts')

<script>
    $(function(){
        $('#descargar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("descargar_datos"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('guardar.datos.compra.descargar')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        $('#lista3').DataTable().ajax.reload();
                        $('#llenar_datos').hide();
                        swal({ icon: "success", title: "Se ha Guardado Correctamente"});
                        $('#modal-without-animation').modal('hide');
                        $('#modal-without-animation3').modal('hide');
                    }
                    else if(html[0] == 2){
                        swal({ icon: "warning", title: "UFV de Fecha No Encontrada"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });
</script>

<script>
    function recuperar_datos(){
        $('#fecha_cot').val('');
        $('#proveedor').empty();
        var formData = new FormData(document.getElementById("guardar_datos"));
                
        formData.append("dato", "valor");
        $.ajax({
            url:"{{route('recuperar.datos.almacenados.compra')}}",
            type:"POST",
            datatype: "html",
            data: formData,
            cache:false,
            contentType:false,
            processData:false
        }).done(function(html){
            if(html[0] == 1){
                recuperar_datos_almacenados(html[1], html[2], html[3], html[4]);
            }
            else{}
        });

    }

    function recuperar_datos_almacenados(dato, dato2, dato3, dato4){
        $('#lista4').DataTable().clear().destroy();
        let no=dato;
        let sol = dato2;
        let datos = dato3;
        let cant = dato4;
        $('#fecha_cot').val('');
        $.ajax({
            type:'POST',
            url:'{{ route('listar.pedido.articulo.anpe.cotizador2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                const f = html[2], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                $('#datepicker-disabled-past').datepicker('setStartDate', fec);
                $('#datepicker-disabled-past').datepicker('setEndDate', html[3]);
                mostrar_proveedor(html[5]);
            }
            
        });
        $('#lista4').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('recuperar.datos.almacenados.compra2') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, sol:sol, dato: datos, cant: dato4}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad' , name: 'cantidad'},
                        {data: 'boton', name:'boton'},
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
            ],
        });
        
    }
</script>

<script>
    $('#modal-without-animation2').on('show.bs.modal', function () {
        verificarCheckboxes();
    });

    function verificarCheckboxes(){
        var total = false;
        var checkboxes = document.querySelectorAll('.modal-body input[name="compra[]"]');
        checkboxes.forEach(function (checkbox) {
            if(checkbox.checked){
                total = true;
                return;
            }
        });
        if(total){
            document.getElementById('llenar_datos').style.display = 'block';
        }
        else{
            document.getElementById('llenar_datos').style.display = 'none';
        }
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
                    $('#lista').DataTable().ajax.reload();
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
    $(document).on("submit" ,"#enviarp", function(e){
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
                    $('#modal-dialog').modal('hide');
                    swal({ icon: "success", title: "Se ha registrado un nuevo proveedor"});
                    setTimeout(funciones, 1000);
                    document.getElementById('provg').value = '';
                    document.getElementById('provc').value = '';
                    document.getElementById('provn').value = '';
                    
                }
                else if(html == 2){
                    swal({ icon: "warning", title: "El proveedor ya existe"});

                }
                else if(html == 3){
                    swal({ icon: "warning", title: "Debe llenar todos los campos"});

                }
                else{
                    swal({ icon: "error", title: "No se pudo realizar el registro, verifique que los datos sean correctos"});
                }
                
            }
        });

        
        
    });

    $(document).on("submit" ,"#enviarp2", function(e){
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
                    $('#modal-dialog2').modal('hide');
                    swal({ icon: "success", title: "Se ha registrado un nuevo proveedor"});
                    setTimeout(funciones2, 1000);
                    document.getElementById('provg2').value = '';
                    document.getElementById('provc2').value = '';
                    document.getElementById('provn2').value = '';
                    
                }
                else if(html == 2){
                    swal({ icon: "warning", title: "El proveedor ya existe"});

                }
                else if(html == 3){
                    swal({ icon: "warning", title: "Debe llenar todos los campos"});

                }
                else{
                    swal({ icon: "error", title: "No se pudo realizar el registro, verifique que los datos sean correctos"});
                }
                
            }
        });

        
        
    });
</script>

<script>
    function funciones(){
        let dato = parseInt($('#id_cat3').val());
        $.ajax({
                type:'POST',
                url:"{{ route('recuperar.proveedor.valor') }}",
                data:{ _token: '{{ csrf_token ()}}', id:dato},
                success:function(articulo){
                    $('#proveedore2').html(articulo);
                }
            });
    }

    function funciones2(){
        let dato = parseInt($('#id_cat4').val());
        $.ajax({
                type:'POST',
                url:"{{ route('recuperar.proveedor.valor') }}",
                data:{ _token: '{{ csrf_token ()}}', id:dato},
                success:function(articulo){
                    $('#proveedore2o').html(articulo);
                }
            });
    }
</script>

<script>
    function convertirEnMayusculas(e){
        e.value = e.value.toUpperCase();
    }

    function solo_letras_numeros (e) {
        key=e.keyCode || e.which;
        teclado=String.fromCharCode(key).toLowerCase();
        letras_num=" abcdefghijklmnñopqrstuvwxyz.-1234567890";
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
</script>


<script>
    function imprimir_orden(dato, dato2){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.orden.compra') }}',
            data:{ _token: '{{ csrf_token ()}}', orden:dato, pedido: dato2},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>

<script>
    function ver_contrato(dato){
        let no = dato;
        $('#guardar_contrato').show();
        $.ajax({
            type:'POST',
            url:'{{ route('editar.orden.contrato.prov') }}',
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
            url:'{{ route('editar.orden.contrato.prov') }}',
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
            url:'{{ route('editar.orden.contrato.prov') }}',
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
            pageLength:25,
            "ajax": {
                type:'POST',
                url:'{{ route('lista.pedido.compra.cotizador.valor') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'boton', name: 'boton'},
                        {data: 'no_pedido', render: function(name){
                                name: 'no_pedido';
                                let html='';
                                html+='<abbr title="Ver Órdenes"><button onclick="observar('+name+')" class="btn btn-indigo" data-toggle="modal" data-target="#modal-without-animation4"><i class="far fa-eye"></i></button>&nbsp;</abbr>';
                                
                                return html;
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
            ]
        });
        
    }
    
</script>


<script>
    function mostrar_proveedor(dato){
        let id=dato;
        $.ajax({
            type:'GET',
            url:'{{ route('recuperar.proveedor.anpe2') }}',
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
                    url:"{{route('guardar.datos.anpe')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-without-animation2').modal('hide');
                        $('#archivo').val('');
                        swal({ icon: "success", title: "Registro de Cotización Correcta"});
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
                    url:"{{route('editar.datos.anpe')}}",
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
                        $('#archivoe').val('');
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });

        $('#guardar_datos_orden').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos_orden"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('guardar.datos.licitacion.orden')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 4){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-without-animation4').modal('hide');
                        swal({ icon: "success", title: "Registro de Orden Correcta"});
                    }
                    else if(html == 3){
                        swal({ icon: "warning", title: "Debe subir el Archivo Correspondiente"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });

        $('#editar_datos_orden').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar_datos_orden"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('editar.datos.licitacion.orden')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 4){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-without-animation5').modal('hide');
                        swal({ icon: "success", title: "Actualización de Orden Correcta"});
                    }
                    else if(html == 3){
                        swal({ icon: "warning", title: "Debe subir el Archivo Correspondiente"});
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });
</script>

<script>
    function observar(dato){
        
        $('#lista5').DataTable().clear().destroy();
        let no=dato;
        $('#lista5').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.orden.compra') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'fecha'  , name: 'fecha'},
                        {data: 'orden' , name: 'orden'},
                        {data: 'proveedor' , name: 'proveedor'},
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

    function ver_articulos(dato){
        $('#lista6').DataTable().clear().destroy();
        let no=dato;
        $('#lista6').DataTable({
            pageLength:50,
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
    $(document).ready( function () {
        $('#lista').DataTable({
            pageLength:25,
            "ajax": {
                url: "{{route('lista.pedido.compra.cotizador')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'boton', name: 'boton'},
                        {data: 'no_pedido', render: function(name){
                                name: 'no_pedido';
                                let html='';
                                html+='<abbr title="Ver Órdenes"><button onclick="observar('+name+')" class="btn btn-info" data-toggle="modal" data-target="#modal-without-animation4"><i class="far fa-eye"></i></button>&nbsp;</abbr>';
                                
                                return html;
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
            ],
        });
        
    });
</script>

<script>
    function ver3(dato){
        $('#lista3').DataTable().clear().destroy();
        let no=dato;
        
        $('#lista3').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.compra.cotizador') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        
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
    function editar(dato, dato2){
        $('#lista4').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let i=0;
        $("#editar_cotizacion").show();
        $.ajax({
            type:'POST',
            url:'{{ route('editar.anpe2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol},
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
                    url:'{{ route('recuperar.proveedor.anpe') }}',
                    data:{ _token: '{{ csrf_token ()}}', id:id_proveedor},
                    success:function(html2){
                        $('#proveedore').html(html2);
                    }
                    
                });
                $('#archivoe').val('');
            }
            
        });

        $('#lista4').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('editar.anpe') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol}
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
    function editar2(dato, dato2){
        $('#lista4').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let i=0;
        $("#editar_cotizacion").hide();
        $.ajax({
            type:'POST',
            url:'{{ route('editar.anpe2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol},
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
                    url:'{{ route('recuperar.proveedor.anpe') }}',
                    data:{ _token: '{{ csrf_token ()}}', id:id_proveedor},
                    success:function(html2){
                        $('#proveedore').html(html2);
                    }
                    
                });
                $('#archivoe').val('');
            }
            
        });

        $('#lista4').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('editar.anpe') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol}
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
    function orden(dato, dato2){
        $('#lista5').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let i=0;
        $("#editar_anpe").show();
        $.ajax({
            type:'POST',
            url:'{{ route('editar.anpe.orden2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                const g = html[0], ge=g.split("-");
                const gec = ge[2]+"-"+ge[1]+"-"+ge[0];
                $('#datepicker-default2').datepicker('setStartDate', fec);
                $('#datepicker-default2').datepicker('setEndDate', html[3]);
                $('#ofertae2').val(html[4]);
                $('#tiempoe2').val(html[5]);
                $('#ofertae2d').val(html[4]);
                $('#tiempoe2d').val(html[5]);

                $('#proveedore2').val(html[6]);
                $('#proveedore2d').val(html[6]);
                $('#montoe2').val(html[7]);
                $('#archivoe2').val('');
            }
            
        });

        $('#lista5').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('editar.licitacion.orden') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'cumple' , name:'cumple'},
                        
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function orden2(dato, dato2){
        $('#lista6').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let i=0;
        $("#modificar_anpe").show();
        $.ajax({
            type:'POST',
            url:'{{ route('modificar.anpe.orden2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                const g = html[7], ge=g.split("-");
                const gec = ge[2]+"-"+ge[1]+"-"+ge[0];
                $('#datepicker-default2o').datepicker('setStartDate', fec);
                $('#datepicker-default2o').datepicker('setEndDate', html[3]);
                $('#fecha_cote2o').val(gec);
                $('#contratoe2o').val(html[8]);
                $('#ofertae2o').val(html[4]);
                $('#tiempoe2o').val(html[5]);
                $('#ofertae2od').val(html[4]);
                $('#tiempoe2od').val(html[5]);

                $('#proveedore2o').val(html[9]);
                $('#proveedore2od').val(html[9]);
                $('#montoe2o').val(html[10]);
                $('#archivoe2o').val('');
            }
            
        });

        $('#lista6').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('modificar.licitacion.orden') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'cumple' , name:'cumple'},
                        
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
</script>


<script>
    function orden3(dato, dato2){
        $('#lista6').DataTable().clear().destroy();
        let no=dato;
        let id_sol = dato2;
        let i=0;
        $("#modificar_anpe").hide();
        $.ajax({
            type:'POST',
            url:'{{ route('modificar.anpe.orden2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                const g = html[7], ge=g.split("-");
                const gec = ge[2]+"-"+ge[1]+"-"+ge[0];
                $('#datepicker-default2o').datepicker('setStartDate', fec);
                $('#datepicker-default2o').datepicker('setEndDate', html[3]);
                $('#fecha_cote2o').val(gec);
                $('#contratoe2o').val(html[8]);
                $('#ofertae2o').val(html[4]);
                $('#tiempoe2o').val(html[5]);
                $('#ofertae2od').val(html[4]);
                $('#tiempoe2od').val(html[5]);

                $('#proveedore2o').val(html[9]);
                $('#proveedore2od').val(html[9]);
                $('#montoe2o').val(html[10]);
                $('#archivoe2o').val('');
            }
            
        });

        $('#lista6').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('modificar.licitacion.orden') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, id:id_sol}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'cumple' , name:'cumple'},
                        
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
                { orderable: false, targets: 4 }
            ],
        });
        
    }
    
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