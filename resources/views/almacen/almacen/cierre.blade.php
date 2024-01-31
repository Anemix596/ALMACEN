@extends('layouts.default')

@section('title', 'Cierre de Gestión')

@push('css')

<link href="{{ asset('/assets/plugins/gritter/css/jquery.gritter.css')}}" rel="stylesheet" />
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

    <div class="row">
		<div class="col-xl-12">
			<div class="panel panel-inverse" data-sortable-id="form-validation-1">
				<div class="panel-body">
					<form id="reporte" action="{{ route('cierre.almacen') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
						@csrf
						<div class="modal-header">
							<h4 class="modal-title" style="color: blue"><i class="fa fa-calendar"></i><b> CIERRE ANUAL</b></h4>
						</div>
						<div class="alert alert-danger m-b-0">
							<h5><i class="fa fa-info-circle"></i> Advertencia</h5>
							<p>Usted está a punto de <b>CERRAR el PERIODO</b>. Recuerde que este proceso es irreversible, una vez cerrada el <b>AÑO</b> no se podrá rehacer duchos cambios. <b>CONSIDERE QUE ESTE PROCESO PUEDE TARDAR VARIOS MINUTOS</b></p>
						</div>
						<br>
						<div class="alert alert-info m-b-0">
							<h5><i class="fa fa-info-circle"></i> Nota</h5>
							<p>Por ser un proceso complejo, se recomienda realizar previamente una <b>COPIA DE SEGURIDAD</b> del sistema</p>
						</div>
						<br>
						<div class="alert alert-info m-b-0">
							<div class="form-group row m-b-15">
								<div class="col-md-4">
									<div class="form-group m-b-10">
										<div class="form-group row">
											<label class="col-lg-4 col-form-label">Fecha de Inicio</label>
											<div class="col-lg-8">
												<div class="row">
													<div class="col-lg-11">
														<div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
															<input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fechai" id="fechai" onchange="valor_fecha(this.value)" required/>
															<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-10">
										<div class="form-group row">
											<label class="col-lg-4 col-form-label">Fecha Fin</label>
											<div class="col-lg-8">
												<div class="row">
													<div class="col-lg-11">
														<div class="input-group date" id="datepicker-default2" data-date-format="dd-mm-yyyy">
															<input type="text" class="form-control" placeholder="Seleccione una Fecha" name="fechaf" id="fechaf" required/>
															<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group m-b-10">
										<div class="form-group row">
											<label class="col-lg-2 col-form-label">Factor</label>
											<div class="col-lg-8">
												<div class="row">
													<div class="col-md-9">
														<div class="checkbox checkbox-css is-invalid">
															<input type="checkbox" id="factor" name="factor" value="1" />
															<label for="factor">Actualizar</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="text-center">
							<button class="btn btn-primary">CERRAR PERIODO</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
 
@endsection

@push('scripts')

<script>
	function valor_fecha(dato){
		$('#datepicker-default2').datepicker('setStartDate', dato);
	}
</script>

<script>
    $(document).on("submit" ,"#reporte", function(e){
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
					swal({ icon: "success", title: "Realizando el Cierre Anual Correspondiente"});
				}
				else if(html == 2){
					swal({ icon: "warning", title: "La Fecha de Inicio debe ser menor a la Fecha Final"});
				}
				else if(html == 3){
					swal({ icon: "warning", title: "UFV no encontrada correspondiente a la Fecha Final"});
				}
				else if(html == 4){
					swal({ icon: "warning", title: "Ya se realizó el Cierre Anual"});
				}
				else if(html == 5){
					swal({ icon: "error", title: "Ha ocurrido un error durante el Cierre Anual"});
				}
				else{swal({ icon: "error", title: "Ha ocurrido un error"});}
            }
        });
        
    });
</script>

<script>
    $.ajax({
        type:'GET',
        url:'{{ route('recuperar.partida.presup') }}',
        data:$(this).serialize(),
        success:function(html){
            $('#part').html(html);
        }
        
    });

	function obtener_articulo(dato){
		$.ajax({
			type:'POST',
			url:"{{ route('recuperar.articulo.valor2') }}",
			data:{ _token: '{{ csrf_token ()}}', id:dato},
			success:function(articulo){
				$('#articulo').html(articulo);
			}
			
		});
	}
</script>

<script>
    $(document).on("submit" ,"#reporte_inventario", function(e){
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
                window.open(html, '_blank');
            }
        });
        
    });
</script>

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

@endpush