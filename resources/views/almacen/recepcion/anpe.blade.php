@extends('layouts.default')

@section('title', 'Almacen')

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
    
    
    <h1 class="page-header">Lista de Órdenes Generados</h1>
    <h4>Apoyo Nacional a la Producción y Empleo (ANPE)</h4>
    
    
    <div class="col-xl-12">
        <div>
            <form class="form-horizontal" id="filtrar" data-parsley-validate="true" name="demo-form">
                <div class="col-md-9">
                    <h4 class="panel-title">Filtrar por Estado</h4>
                    <div class="checkbox checkbox-css">
                        <input type="checkbox" name="ped_pendiente" id="ped_pendiente" value="1" onchange="pendientes(this.value);"/>
                        <label for="ped_pendiente">Nota de Recepción Pendientes de Órdenes</label>
                    </div>
                    <div class="checkbox checkbox-css is-valid">
                        <input type="checkbox" name="ped_aprobado" id="ped_aprobado" value="2" onchange="aprobados(this.value);"/>
                        <label for="ped_aprobado">Nota de Recepción Generados de Órdenes</label>
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
                                <th class="text-nowrap">Nº ORDEN / Nº CONTRATO</th>
                                <th class="text-nowrap">UNIDAD SOLICITANTE</th>
                                <th class="text-nowrap">PROVEEDOR</th>
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </th>
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
                        <h4 class="modal-title">Vista de Artículos para Recepción</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="guardar_datos" method="POST">
                        @csrf
                        <div class="form-group row">

                            <label class="col-lg-4 col-form-label">Proveedor</label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" name="proveedor" id="proveedor" placeholder="Ingrese Número de Factura" data-parsley-required="true" required disabled/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Factura</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" type="text" id="factura" name="factura" placeholder="Ingrese Número de Factura" maxlength="15" data-parsley-required="true" onkeypress="return solo_numeros(event)" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Fecha de la Factura</label>
                            <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fecha_fac" id="fecha_fac" autocomplete="off" required/>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="aceptar">Generar Nota de Recepción</button>
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
                        <h4 class="modal-title">Actualizar Datos de Recepción</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="editar_datos" method="POST">
                        @csrf
                        <input type="hidden" name="recepcion" id="recepcion" value="">
                        <div class="form-group row">

                            <label class="col-lg-4 col-form-label">Proveedor</label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" name="proveedore" id="proveedore" placeholder="Proveedor Ganador" data-parsley-required="true" required disabled/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Factura</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" type="text" id="facturae" name="facturae" placeholder="Ingrese Número de Factura" maxlength="15" data-parsley-required="true" onkeypress="return solo_numeros(event)" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Fecha de la Factura</label>
                            <div class="input-group date" id="datepicker-disabled-past" data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fecha_face" id="fecha_face" autocomplete="off" required/>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="editar">Actualizar Nota de Recepción</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="modal-without-animation3" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Finalizar Nota de Recepción</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('finalizar.recepcion') }}" id="finalizar_rec" method="POST">
                           @csrf
                            <input type="hidden" id="ordenf" name="ordenf" value="">
                            <div class="alert alert-danger m-b-0">
                                <h5><i class="fa fa-info-circle"></i> <b>¿Desea Finalizar los cambios de Nota de Recepción del Nº Orden / Nº Contrato <label id="ordenv"></label> ?</b></h5>
                                <p>Los cambios serán guardados, ningún dato podrá ser modificado.
                                    <br><br>
                                    Si está seguro de <b>Finalizar la Nota de Recepción</b> presioner el botón de <b>Finalizar</b>
                                </p>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-danger" id="finalizar">Finalizar</button>
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

    $(document).on("submit" ,"#finalizar_rec", function(e){
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
                    $('#modal-without-animation3').modal('hide');
                    swal({ icon: "success", title: "Finalización de Nota de Recepción Correcta"});
                    
                }
                else{
                    swal({ icon: "error", title: "Ha ocurrido un error"});
                }
                
            }
        });

        
        
    });
</script>

<script>
    function ver3(dato, dato2){
        $('#ordenf').val(dato);
        $('#ordenv').text(dato2);
    }
</script>


<script>
    function imprimir_nota_recepcion(dato){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.recepcion.almacen') }}',
            data:{ _token: '{{ csrf_token ()}}', orden:dato},
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
        $('#guardar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('guardar.datos.recepcion.almacen')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Nota de Recepción Generada"});
                        $('#modal-without-animation').modal('hide');
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
                    url:"{{route('editar.datos.recepcion')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Nota de Recepción Actualizada"});
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
            pageLength:25,
            "ajax": {
                url: "{{route('listar.todo.orden.anpe.almacen')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'valor_ord', name: 'valor_ord'},
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
        $('#factura').val('');
        $('#fecha_fac').val('');

        $.ajax({
            type:'POST',
            url:'{{ route('listar.articulo.orden.almacen2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                $('#proveedor').val(html[0])
                const f = html[4], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                $('#datepicker-default').datepicker('setStartDate', fec);
                $('#datepicker-default').datepicker('setEndDate', html[5]);
            }
            
        });
        $('#lista2').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:"{{ route('listar.articulo.orden.almacen') }}",
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
    function ver2(dato){
        $('#lista3').DataTable().clear().destroy();
        let no=dato;
        $('#editar').show();
        $.ajax({
            type:'POST',
            url:'{{ route('listar.articulo.orden.almacen2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                $('#proveedore').val(html[0])
                $('#fecha_face').val(fec)
                $('#facturae').val(html[2])
                $('#recepcion').val(html[3])
                const f2 = html[4], fe2=f2.split("-");
                const fec2 = fe2[2]+"-"+fe2[1]+"-"+fe2[0];
                $('#datepicker-disabled-past').datepicker('setStartDate', fec2);
                $('#datepicker-disabled-past').datepicker('setEndDate', html[5]);
            }
            
        });

        $('#lista3').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:"{{ route('listar.articulo.orden.almacen') }}",
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
            ],
        });
        
    }
    
</script>


<script>
    function ver4(dato){
        $('#lista3').DataTable().clear().destroy();
        let no=dato;
        $('#editar').hide();
        $.ajax({
            type:'POST',
            url:'{{ route('listar.articulo.orden.almacen2') }}',
            data:{ _token: '{{ csrf_token ()}}', no:no},
            success:function(html){
                const f = html[1], fe=f.split("-");
                const fec = fe[2]+"-"+fe[1]+"-"+fe[0];
                $('#proveedore').val(html[0])
                $('#fecha_face').val(fec)
                $('#facturae').val(html[2])
                $('#recepcion').val(html[3])
                const f2 = html[4], fe2=f2.split("-");
                const fec2 = fe2[2]+"-"+fe2[1]+"-"+fe2[0];
                $('#datepicker-disabled-past').datepicker('setStartDate', fec2);
                $('#datepicker-disabled-past').datepicker('setEndDate', html[5]);
            }
            
        });

        $('#lista3').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:"{{ route('listar.articulo.orden.almacen') }}",
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
            pageLength:25,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.todo.orden.anpe.almacen.valor') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'valor_ord', name: 'valor_ord'},
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