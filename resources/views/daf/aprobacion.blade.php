@extends('layouts.default')

@section('title', 'Aprobación de DAF')

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
    
    
    <h1 class="page-header">Lista de Pedidos para su Compra</h1>
        
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
                <h4 class="panel-title">LISTA DE PEDIDOS PARA SU COMPRA</h4>
            </div>
            
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="lista" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">Nº</th>
                                <th class="text-nowrap">Nº PEDIDO</th>
                                <th class="text-nowrap">UNIDAD ADMINISTRATIVA</th>
                                <th class="text-nowrap">ESTADO</th>
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; </th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        

        
        <div class="modal" id="modal-without-animation" role="dialog" style="overflow-y: scroll">
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Vista de Artículos del Pedido</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="guardar_datos" method="POST">
                           @csrf
                           <input type="hidden" value="A" id="estado" name="estado">
                            <div class="table-responsive">
                                <table id="lista2" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">ARCHIVO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="float-right">
                                <button class="btn btn-success" id="guardar" name="guardar" value="A" onclick="valor(this.value)">Aprobar</button>
                                &nbsp;
                                <button class="btn btn-danger" id="rechazar" name="rechazar" value="R" onclick="valor(this.value)">Rechazar</button>    
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
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Artículos del Pedido</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="editar_datos" method="POST">
                           @csrf
                           <input type="hidden" value="R" id="eestado" name="eestado">
                            <div class="table-responsive">
                                <table id="lista3" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">UNIDAD</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD</th>
                                            <th class="text-nowrap">ARCHIVO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-danger float-right" id="actualiza">Rechazar</button>
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
    function imprimir_solicitud(dato){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.solicitud.daf') }}',
            data:{ _token: '{{ csrf_token ()}}', no_pedido:dato},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>

<script>
    function valor(valor){
        $('#estado').val(valor);
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
        $('#guardar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('aprobar.pedido.daf')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html == 1){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Se ha aprobado el Pedido"});
                        $('#modal-without-animation').modal('hide');
                    }
                    else if(html == 2){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Se ha rechazado el Pedido"});
                        $('#modal-without-animation').modal('hide');
                    }
                    else{swal({ icon: "error", title: "Ha ocurrido un error"});}
                });
        });
    });

    $(function(){
        $('#editar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("editar_datos"));
                
                formData.append("dato", "valor");
                $.ajax({
                    url:"{{route('rechazar.pedido.daf')}}",
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
                        swal({ icon: "success", title: "Se ha rechazado el pedido para la compra"});
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
                url: "{{route('listar.solicitud.daf')}}",
                type: 'GET'
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
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
                { orderable: false, targets: 3 },
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
        $('#guardar').show();
        $('#rechazar').show();
        $('#lista2').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.solicitud.articulo') }}',
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
            
            ],
        });
        
    }
    
</script>


<script>
    function editar(dato){
        $('#lista3').DataTable().clear().destroy();
        let no=dato;
        let i=0;
        $('#lista3').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.solicitud.articulo') }}',
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
    function ver2(dato){
        $('#lista2').DataTable().clear().destroy();
        let no=dato;
        $('#guardar').hide();
        $('#rechazar').hide();
        $('#lista2').DataTable({
            pageLength:50,
            "ajax": {
                type:'POST',
                url:'{{ route('listar.solicitud.articulo') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'unidad'  , name: 'unidad'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad', name:'cantidad'},
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
                url:'{{ route('lista.solicitud.valor.daf') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2, est_ped3:est_ped3}
            },
            columns: [
                        {data:'numero'  , name: 'numero'}, 
                        {data: 'no_pedido' , name: 'no_pedido'}, 
                        {data: 'unidad' , name: 'unidad'},
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
                { orderable: false, targets: 3 },
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