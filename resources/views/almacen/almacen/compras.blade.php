@extends('layouts.default')

@section('title', 'Compras')

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
    
    
    <h1 class="page-header">Lista de Compras</h1>
    
    
    <div class="col-xl-12">
        <div>
            <form class="form-horizontal" id="filtrar" data-parsley-validate="true" name="demo-form">
                <div class="col-md-9">
                    <h4 class="panel-title">Filtrar por Estado</h4>
                    <div class="checkbox checkbox-css">
                        <input type="checkbox" name="ped_pendiente" id="ped_pendiente" value="1" onchange="pendientes(this.value);"/>
                        <label for="ped_pendiente">Compras Pendientes</label>
                    </div>
                    <div class="checkbox checkbox-css is-valid">
                        <input type="checkbox" name="ped_aprobado" id="ped_aprobado" value="2" onchange="aprobados(this.value);"/>
                        <label for="ped_aprobado">Compras Aceptadas</label>
                    </div>
                </div>
            </form>
        </div>
        <br>
        
        <div class="panel panel-inverse">
            
            <div class="panel-heading">
                <h4 class="panel-title">LISTA DE COMPRAS</h4>
            </div>
            
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="lista" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">Nº</th>
                                <th class="text-nowrap">Nº RECEPCIÓN</th>
                                <th class="text-nowrap">UNIDAD SOLICITANTE</th>
                                <th class="text-nowrap">PROVEEDOR</th>
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </th>
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
                        <h4 class="modal-title">Vista de Artículos de la Compra</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                        @csrf
                        
                        <div class="row row-space-10">
                            
                            <div class="col-md-6">
                                <div class="form-group m-b-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Nº de Pedido</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-11">
                                                    <label for="" class="form-control" name="pedido" id="pedido"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-b-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Factura</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-11">
                                                    <label for="" class="form-control" id="factura" name="factura"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Nº de Orden</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-11">
                                                    <label for="" class="form-control" id="orden" name="orden"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-b-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Proveedor</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-11">
                                                    <label for="" class="form-control" id="proveedor" name="proveedor"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="table-responsive">
                                <table id="lista2" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">PRECIO</th>
                                            <th class="text-nowrap">IMPORTE</th>
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

        <div class="modal" id="modal-without-animation_reg" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Registrar Ingreso</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="guardar_datos" method="POST">
                        @csrf
                            <div class="row row-space-10">
                                <input type="hidden" name="idr" id="idr">
                                <div class="col-md-6">
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Fecha</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fechar" id="fechar" required/>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Nº de Pedido</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" name="pedidor" id="pedidor"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Factura</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" id="facturar" name="facturar"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Tipo de Movimiento</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <select id="mov" name="mov" class="default-select2 form-control" data-size="10" data-live-search="true" required>
                                                                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Nº de Orden</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" id="ordenr" name="ordenr"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Proveedor</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" id="proveedorr" name="proveedorr"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="lista3" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">PRECIO</th>
                                            <th class="text-nowrap">IMPORTE</th>
                                            <th class="text-nowrap">FECHA DE VENC.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="aceptar">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="modal-without-animation2" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Actualizar Ingreso</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="editar_datos" method="POST">
                        @csrf
                            <div class="row row-space-10">
                                <input type="hidden" name="ida" id="ida">
                                <div class="col-md-6">
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Fecha</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <div class="input-group date" id="datepicker-disabled-past" data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fechaa" id="fechaa" required/>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Nº de Pedido</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" name="pedidoa" id="pedidoa"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Factura</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" id="facturaa" name="facturaa"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Tipo de Movimiento</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <select id="mova" name="mova" class="default-select2 form-control" data-size="10" data-live-search="true" required>
                                                                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Nº de Orden</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" id="ordena" name="ordena"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Proveedor</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <label for="" class="form-control" id="proveedora" name="proveedora"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="lista4" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">PRECIO</th>
                                            <th class="text-nowrap">IMPORTE</th>
                                            <th class="text-nowrap">FECHA DE VENC.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="editar">Actualizar Ingreso</button>
                            </div>
                        </form>
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
    $(function(){
        $('#guardar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('guardar.datos.ingreso')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Registro de Ingreso Correcto"});
                        $('#modal-without-animation_reg').modal('hide');
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });

        $('#editar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar_datos"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('editar.datos.ingreso')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Ingreso Actualizado"});
                        $('#modal-without-animation2').modal('hide');
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
                url: "{{route('listar.recepcion')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_recep', name: 'no_recep'},
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'proveedor', name: 'proveedor'},
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
            { orderable: false, targets: 4 }
            ],
        });
        
    });
</script>


<script>
    function ver(dato){
        $('#lista2').DataTable().clear().destroy();
        let no=dato;
        $.ajax({
            type:'POST',
            url:'{{ route('listar.articulo.recepcion2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                $('#pedido').html(html[0]);
                $('#orden').html(html[1]);
                $('#factura').html(html[5]);
                $('#proveedor').html(html[4]);
            }
            
        });
        $('#lista2').DataTable({
            
            "ajax": {
                type:'POST',
                url:"{{ route('listar.articulo.recepcion') }}",
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'cantidad'  , name: 'cantidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'precio'  , name: 'precio'},
                        {data: 'boton', name:'boton'},
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
            ],
        });
        
    }
</script>

<script>
    function registrar(dato){
        $('#lista3').DataTable().clear().destroy();
        $('#fechar').val('');
        let no=dato;
        $.ajax({
            type:'POST',
            url:'{{ route('listar.articulo.recepcion2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                $('#pedidor').html(html[0]);
                $('#ordenr').html(html[1]);
                $('#facturar').html(html[5]);
                $('#proveedorr').html(html[4]);
                $('#idr').val(no);

                $.ajax({
                    type:'GET',
                    url:'{{ route('recuperar.movimiento') }}',
                    data:$(this).serialize(),
                    success:function(categoria){
                        
                        $('#mov').html(categoria);
                    }
                    
                });
            }
            
        });
        $('#lista3').DataTable({
            
            "ajax": {
                type:'POST',
                url:"{{ route('listar.articulo.recepcion3') }}",
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'cantidad'  , name: 'cantidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'precio'  , name: 'precio'},
                        {data: 'importe'  , name: 'importe'},
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
                { orderable: false, targets: 6 }
            ],
        });
        
    }
    
    function actualizar(dato){
        $('#lista4').DataTable().clear().destroy();
        $('#editar').hide();
        let no=dato;
        $.ajax({
            type:'POST',
            url:'{{ route('listar.articulo.ingreso') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                const fecha_ped = html[6], fecha_p=fecha_ped.split(" ");
                const fecha = fecha_p[0].split("-");
                $('#fechaa').val(fecha[2]+"-"+fecha[1]+"-"+fecha[0]);
                $('#pedidoa').html(html[0]);
                $('#ordena').html(html[1]);
                $('#facturaa').html(html[5]);
                $('#proveedora').html(html[4]);
                $('#ida').val(no);

                if(html[8] == "PENDIENTE")
                    $('#editar').show();
                else $('#editar').hide();

                $.ajax({
                    type:'POST',
                    url:'{{ route('recuperar.movimiento2') }}',
                    data:{ _token: '{{ csrf_token ()}}', id:html[7]},
                    success:function(categoria){
                        
                        $('#mova').html(categoria);
                    }
                    
                });
            }
            
        });
        $('#lista4').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.articulo.ingreso2') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'cantidad'  , name: 'cantidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'precio'  , name: 'precio'},
                        {data: 'importe'  , name: 'importe'},
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
            { orderable: false, targets: 6 }
            ],
        });
        
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
                url:'{{ route('listar.ingreso.valor') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_recep', name: 'no_recep'},
                        {data: 'unidad' , name: 'unidad'},
                        {data: 'proveedor', name: 'proveedor'},
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
            { orderable: false, targets: 4 }
            ],
        });
        
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