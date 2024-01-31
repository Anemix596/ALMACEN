@extends('layouts.default')

@section('title', 'Sección de Almacenes')

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
                        <label for="ped_aprobado">Pedidos Aprobados para Compra</label>
                    </div>
                    <div class="checkbox checkbox-css is-invalid">
                        <input type="checkbox" name="ped_rechazado" id="ped_rechazado" value="3" onchange="rechazados(this.value);"/>
                        <label for="ped_rechazado">Pedidos Aprobados encontrados en Almacén</label>
                    </div>
                    <div class="checkbox checkbox-css">
                        <input type="checkbox" name="ped_eliminado" id="ped_eliminado" value="4" onchange="eliminados(this.value);"/>
                        <label for="ped_eliminado">Pedidos Eliminados</label>
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
                                <th class="text-nowrap">UNIDAD ADMINISTRATIVA</th>
                                <th class="text-nowrap">ESTADO</th>
                                <th class="text-nowrap" data-orderable="false"> &nbsp; &nbsp; &nbsp; &nbsp; ACCIONES &nbsp; &nbsp; &nbsp; &nbsp; </th>
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
                           
                            <div class="table-responsive">
                                <table id="lista2" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANT. SOLIC.</th>
                                            <th class="text-nowrap">CANT. APROB.</th>
                                            <th class="text-nowrap">CANT. DISP.</th>
                                            <th class="text-nowrap">ARCHIVO</th>
                                            <th class="text-nowrap" data-orderable="false"> ACCIONES </th>
                                            <th class="text-nowrap" data-orderable="false"> ELIMINAR </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="float-right">
                                <a onclick="recuperar_datos()" href="#" class="btn btn-pink" data-toggle="modal" data-target="#modal-without-animation3" href="#" id="descargo" name="descargo">Descargo</a>
                                
                                <button class="btn btn-success" id="guardar" name="guardar">Guardar</button>
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
                           
                            <div class="table-responsive">
                                <table id="lista3" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANTIDAD SOLICITADA</th>
                                            <th class="text-nowrap">CANTIDAD APROBADA</th>
                                            <th class="text-nowrap">ARCHIVO</th>
                                            <th class="text-nowrap" data-orderable="false"> ACCIONES </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="actualiza">Actualizar</button>
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
            <div class="modal-dialog" style="max-width: 60% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Descargo de Artículos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="descargar_datos" method="POST">
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
                                                            <input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fechar" id="fecha" required/>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-b-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Resp. de Entrega</label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <select id="responsable" name="responsable" class="default-select2 form-control" data-size="10" data-live-search="true" required>
                                                                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-b-10">
                                    <label class="col-lg-3 text-lg-right col-form-label">Glosa <span class="text-danger">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea class="form-control" id="glosa" name="glosa" rows="2" minlength="1" maxlength="250" placeholder="CANTIDAD MÁXIMO DE CARACTERES: 250" data-size="10" data-live-search="true" onkeyup="convertirEnMayusculas(this)" onkeypress="return solo_letras_numeros(event)" required></textarea>
                                    </div>
                                </div>
                            <div class="table-responsive">
                                <table id="lista4" class="table table-striped table-bordered table-td-valign-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%">Nº</th>
                                            <th class="text-nowrap">ARTICULO (DESCRIPCION)</th>
                                            <th class="text-nowrap">CANT. SOLIC.</th>
                                            <th class="text-nowrap">CANT. APROB.</th>
                                            <th class="text-nowrap">CANT. DISP.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                                <button class="btn btn-success float-right" id="descargar">Guardar</button>
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
    $(function(){
        $('#descargar_datos').on("submit", function(e){
            e.preventDefault();
                var f=$(this);
                var formData = new FormData(document.getElementById("guardar_datos"));
                var formData2 = new FormData(document.getElementById("descargar_datos"));
                
                for (let [key, value] of formData2.entries()) {
                    formData.append(key, value);
                }
                $.ajax({
                    url:"{{route('guardar.datos.almacen.descargar')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
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
        $('#responsable').empty();
        $('#glosa').val('');
        $('#fecha').val('');
        var formData = new FormData(document.getElementById("guardar_datos"));
                
        formData.append("dato", "valor");
        $.ajax({
            url:"{{route('recuperar.datos.almacenados')}}",
            type:"POST",
            datatype: "html",
            data: formData,
            cache:false,
            contentType:false,
            processData:false
        }).done(function(html){
            if(html[0] == 3){
                $('#modal-without-animation3').modal('hide');
                swal({ icon: "error", title: "La cantidad de la fila "+html[1]+" debe ser menor o igual a la cantidad disponible para descargar"});
            }
            else if(html[0] == 5){
                $('#modal-without-animation3').modal('hide');
                swal({ icon: "warning", title: "No hay artículos seleccionados para descargar"});
            }
            else if(html[0] == 4){
                recuperar_datos_almacenados(html[1], html[2], html[3]);
                $('#glosa').val(html[5]);
                $.ajax({
                    type:'POST',
                    url:'{{ route('recuperar.responsable.pedido') }}',
                    data:{ _token: '{{ csrf_token ()}}', id:html[4]},
                    success:function(responsable){
                        $('#responsable').html(responsable);
                    }
                    
                });
            }
            else{}
        });

    }


    function recuperar_datos_almacenados(dato, dato2, dato3){
        $('#lista4').DataTable().clear().destroy();
        let no=dato;
        let i=0;
        $('#lista4').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('recuperar.datos.almacenados2') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no, dato:dato2, cant:dato3}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad' , name: 'cantidad'},
                        {data: 'cant_aprob' , name: 'cant_aprob'},
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
    function imprimir_pedido(dato){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.pedido.almacen') }}',
            data:{ _token: '{{ csrf_token ()}}', no_pedido:dato},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>


<script>
    function imprimir_solicitud(dato){
        $.ajax({
            type:'POST',
            url:'{{ route('ver.imprimir.solicitud.almacen') }}',
            data:{ _token: '{{ csrf_token ()}}', no_pedido:dato},
            success:function(html){
                window.open(html, '_blank');
            }
            
        });
    }
</script>


<script>
    function presionar(boton){
        let x = document.getElementById(boton.id);
        if(boton.classList[1] == 'btn-danger'){
            boton.style.color = 'White';
            boton.classList.remove('btn-danger');
            boton.classList.toggle('btn-success');
            x.getElementsByTagName('input')[0].value = "B";
            x.getElementsByTagName('i')[0].innerText = "Aprobar";
            x.getElementsByTagName('i')[0].classList = "fas fa-check-circle";
            x.getElementsByTagName('abbr')[0].title = "Aprobar para Compra";
        }
        else{
            boton.style.color = 'White';
            boton.classList.remove('btn-success');
            boton.classList.toggle('btn-danger');
            x.getElementsByTagName('input')[0].value = "A";
            x.getElementsByTagName('i')[0].innerText = "Entregar";
            x.getElementsByTagName('i')[0].classList = "fas fa-times-circle";
            x.getElementsByTagName('abbr')[0].title = "Entregar desde Almacén";
        }
    }

    function presionar2(boton){
        let x = document.getElementById(boton.id);
        if(boton.classList[1] == 'btn-info'){
            boton.style.color = 'White';
            boton.classList.remove('btn-info');
            boton.classList.toggle('btn-warning');
            x.getElementsByTagName('input')[0].value = "B";
            x.getElementsByTagName('i')[0].innerText = "Aprobar";
            x.getElementsByTagName('i')[0].classList = "fas fa-check-circle";
            x.getElementsByTagName('abbr')[0].title = "Aprobar para Compra/Descargo";
        }
        else{
            boton.style.color = 'White';
            boton.classList.remove('btn-warning');
            boton.classList.toggle('btn-info');
            x.getElementsByTagName('input')[0].value = "A";
            x.getElementsByTagName('i')[0].innerText = "Rechazar";
            x.getElementsByTagName('i')[0].classList = "fas fa-times-circle";
            x.getElementsByTagName('abbr')[0].title = "Rechazar para Compra/Descargo";
        }
    }

    function epresionar(boton){
        let x = document.getElementById(boton.id);
        if(boton.classList[1] == 'btn-danger'){
            boton.style.color = 'White';
            boton.classList.remove('btn-danger');
            boton.classList.toggle('btn-success');
            x.getElementsByTagName('input')[0].value = "B";
            x.getElementsByTagName('i')[0].innerText = "Aprobar";
            x.getElementsByTagName('i')[0].classList = "fas fa-check-circle";
            x.getElementsByTagName('abbr')[0].title = "Aprobar";
        }
        else{
            boton.style.color = 'White';
            boton.classList.remove('btn-success');
            boton.classList.toggle('btn-danger');
            x.getElementsByTagName('input')[0].value = "A";
            x.getElementsByTagName('i')[0].innerText = "Entregar";
            x.getElementsByTagName('i')[0].classList = "fas fa-times-circle";
            x.getElementsByTagName('abbr')[0].title = "Entregar";
        }
    }
</script>


<script>
    let valor1=0, valor2=0, valor3=0, valor4=0;
    function pendientes(dato){
        let dp = dato;
        if(ped_pendiente.checked) valor1=dp;
        else valor1=0;
        filtrar(valor1, valor2, valor3, valor4);
    }

    function aprobados(dato){
        let dp = dato;
        if(ped_aprobado.checked) valor2=dp;
        else valor2=0;
        filtrar(valor1, valor2, valor3, valor4);
    }

    function rechazados(dato){
        let dp = dato;
        if(ped_rechazado.checked) valor3=dp;
        else valor3=0;
        filtrar(valor1, valor2, valor3, valor4);
    }

    function eliminados(dato){
        let dp = dato;
        if(ped_eliminado.checked) valor4=dp;
        else valor4=0;
        filtrar(valor1, valor2, valor3, valor4);
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
                    url:"{{route('guardar.datos.almacen')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        swal({ icon: "success", title: "Se ha Guardado Correctamente"});
                        $('#modal-without-animation').modal('hide');
                    }
                    else if(html[0] == 2){
                        swal({ icon: "warning", title: "Debe elegir la opción de descargo"});
                    }
                    else if(html[0] == 3){
                        swal({ icon: "warning", title: "La cantidad aprobada de la fila "+html[1]+" debe estar entre 1 y la cantidad solicitada"});
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
                    url:"{{route('editar.datos.almacen')}}",
                    type:"POST",
                    datatype: "html",
                    data: formData,
                    cache:false,
                    contentType:false,
                    processData:false
                }).done(function(html){
                    if(html[0] == 1){
                        $('#lista').DataTable().ajax.reload();
                        $('#modal-without-animation2').modal('hide');
                        swal({ icon: "success", title: "Se han actualizado los datos"});
                    }
                    else if(html[0] == 2){
                        swal({ icon: "warning", title: "La cantidad en la fila "+html[1]+" debe ser menor o igual a la cantidad pedida"});
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
                url: "{{route('lista.pedido.pendiente.almacen')}}",
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
                                if(name=="ASIGNADO"){
                                    return '<abbr title="Pedido Aprobado para Cotización"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="RECHAZADO"){
                                    return '<abbr title="Pedido Rechazado para Cotización"><button class="btn btn-danger"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
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
        $('#lista2').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.pendiente.almacen') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad' , name: 'cantidad'},
                        {data: 'boton', name:'boton'},
                        {data: 'disponible' , name: 'disponible'},
                        {data: 'archivo' , 
                            render: function(name){
                                name: 'archivo';
                                if(name!="VACIO"){
                                    return '<abbr title="Ver Archivo"><a href="'+name+'" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;</abbr>';
                                }
                                else return "";
                            }
                        },
                        {data: 'val', 
                            render: function(name){
                                i++;
                                return '<a id="anular'+i+'" name="anular[]" onclick="presionar(this)" class="btn btn-danger" style="color: white"><input type="hidden" value="A" name="valor[]" id="valor"><abbr title="Entregar desde Almacén"><i class="fas fa-times-circle">Entregar</i></abbr></a>';
                            }
                        },
                        {data: 'val', 
                            render: function(name){
                                i++;
                                return '<a id="rechazar'+i+'" name="rechazar[]" onclick="presionar2(this)" class="btn btn-info" style="color: white"><input type="hidden" value="A" name="valor2[]" id="valor2"><abbr title="Rechazar para Compra/Descargo"><i class="fas fa-times-circle">Rechazar</i></abbr></a>';
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
                { orderable: false, targets: 5 },
                { orderable: false, targets: 6 },
                { orderable: false, targets: 7 }
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
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.pendiente.almacen') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad' , name: 'cantidad'},
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
                        {data: 'estado2', 
                            render: function(name){
                                name: 'estado2';
                                const estado = name, est=estado.split("/");
                                const est_alma = est[0];
                                const est_alm = est[1];
                                const est_aprob = est[2];
                                i++;
                                console.log(i+" "+est_alm)
                                
                                if(est_aprob == "PENDIENTE"){
                                    $('#actualiza').hide();
                                    if(est_alm == "ASIGNADO"){

                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-danger" style="color: white"><input type="hidden" value="A" name="evalor[]" id="evalor"><abbr title="Entregar"><i class="fas fa-times-circle">Entregar</i></abbr></a>';
                                    }
                                    if(est_alm == "RECHAZADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-success" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Aprobar"><i class="fas fa-check-circle">Aprobar</i></abbr></a>';
                                    }
                                    if(est_alm == "ELIMINADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" class="btn btn-warning" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Eliminado"><i class="fas fa-check-circle">Eliminado</i></abbr></a>';
                                    }
                                }
                                else{
                                    $('#actualiza').hide();
                                    if(est_alm == "ASIGNADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-danger" style="color: white"><input type="hidden" value="A" name="evalor[]" id="evalor"><abbr title="Entregar"><i class="fas fa-times-circle">Entregar</i></abbr></a>';
                                    }
                                    if(est_alm == "RECHAZADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-success" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Aprobar"><i class="fas fa-check-circle">Aprobar</i></abbr></a>';
                                    }
                                    if(est_alm == "ELIMINADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" class="btn btn-warning" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Eliminado"><i class="fas fa-check-circle">Eliminado</i></abbr></a>';
                                    }
                                }
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
    function ver2(dato){
        $('#lista2').DataTable().clear().destroy();
        let no=dato;
        let i=0;
        $('#guardar').hide();
        $('#descargo').hide();
        $('#lista2').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('listar.pedido.articulo.pendiente.almacen2') }}',
                data:{ _token: '{{ csrf_token ()}}', no:no}
            },
            columns: [
                        {data: 'numero'  , name: 'numero'},
                        {data: 'articulo' , name: 'articulo'},
                        {data: 'cantidad' , name: 'cantidad'},
                        {data: 'cant_aprob', name:'cant_aprob'},
                        {data: 'disponible' , name: 'disponible'},
                        {data: 'archivo' , 
                            render: function(name){
                                name: 'archivo';
                                if(name!="VACIO"){
                                    return '<abbr title="Ver Archivo"><a href="'+name+'" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i></a> &nbsp;</abbr>';
                                }
                                else return "";
                            }
                        },
                        {data: 'estado2', 
                            render: function(name){
                                name: 'estado2';
                                const estado = name, est=estado.split("/");
                                const est_alma = est[0];
                                const est_alm = est[1];
                                const est_aprob = est[2];
                                i++;
                                console.log(i+" "+est_alm)
                                
                                if(est_aprob == "PENDIENTE"){
                                    $('#actualiza').hide();
                                    if(est_alm == "ASIGNADO"){

                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-danger" style="color: white"><input type="hidden" value="A" name="evalor[]" id="evalor"><abbr title="Entregar"><i class="fas fa-times-circle">Entregar</i></abbr></a>';
                                    }
                                    if(est_alm == "RECHAZADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-success" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Aprobar"><i class="fas fa-check-circle">Aprobar</i></abbr></a>';
                                    }
                                    if(est_alm == "ELIMINADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" class="btn btn-warning" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Eliminado"><i class="fas fa-check-circle">Eliminado</i></abbr></a>';
                                    }
                                }
                                else{
                                    $('#actualiza').hide();
                                    if(est_alm == "ASIGNADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-danger" style="color: white"><input type="hidden" value="A" name="evalor[]" id="evalor"><abbr title="Entregar"><i class="fas fa-times-circle">Entregar</i></abbr></a>';
                                    }
                                    if(est_alm == "RECHAZADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" onclick="epresionar(this)" class="btn btn-success" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Aprobar"><i class="fas fa-check-circle">Aprobar</i></abbr></a>';
                                    }
                                    if(est_alm == "ELIMINADO"){
                                        return '<a id="eanular'+i+'" name="eanular[]" class="btn btn-warning" style="color: white"><input type="hidden" value="B" name="evalor[]" id="evalor"><abbr title="Eliminado"><i class="fas fa-check-circle">Eliminado</i></abbr></a>';
                                    }
                                }
                            }
                        },
                        {data: 'val', name: 'val'},
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
    function filtrar(dato1, dato2, dato3, dato4){
        $('#lista'). DataTable().clear().destroy();
        let est_ped1=dato1;
        let est_ped2=dato2;
        let est_ped3=dato3;
        let est_ped4=dato4;
        $('#lista').DataTable({
            
            "ajax": {
                type:'POST',
                url:'{{ route('lista.pedido.valor.almacen') }}',
                data:{ _token: '{{ csrf_token ()}}', est_ped1:est_ped1, est_ped2:est_ped2, est_ped3:est_ped3, est_ped4:est_ped4}
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
                                if(name=="ASIGNADO"){
                                    return '<abbr title="Pedido Aprobado para Cotización"><button class="btn btn-success"><i class="fas fa-check-circle"></i></button>&nbsp;</abbr>';
                                }
                                if(name=="RECHAZADO"){
                                    return '<abbr title="Pedido Rechazado para Cotización"><button class="btn btn-danger"><i class="fas fa-times-circle"></i></button>&nbsp;</abbr>';
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

<script>
    function convertirEnMayusculas(e){
        e.value = e.value.toUpperCase();
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