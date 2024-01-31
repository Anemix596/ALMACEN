@extends('layouts.default')

@section('title', 'Kardex de Artículo')

@push('css')

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
    
    
    <h1 class="page-header">Kardex de Articulo</h1>
    <h3 class="page-header">Materiales y Suministros</h3>
    
    
    <div class="row">
		<div class="col-xl-12">
			<div class="panel panel-inverse" data-sortable-id="form-validation-1">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Kardex de Artículo - Materiales y Suministros</h4>
				</div>
				<div class="panel-body">
					<form id="reporte" action="{{ route('ver.imprimir.kardex.articulo') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
						@csrf
						<div class="form-group row m-b-15">
							<label class="col-md-4 col-sm-4 col-form-label">Partida Presupuestaria * :</label>
							
							<div class="col-md-8 col-sm-8">
								<select id="part" name="part" class="default-select2 form-control" data-size="10" data-live-search="true" onchange="obtener_articulo(this.value)" required>
							
								</select>
							</div>
						</div>

						<div class="form-group row m-b-15">
							<label class="col-md-4 col-sm-4 col-form-label">Artículo * :</label>
							
							<div class="col-md-8 col-sm-8">
								<select id="articulo" name="articulo" class="default-select2 form-control" data-size="10" data-live-search="true" required>
							
								</select>
							</div>
						</div>
						<div class="form-group row m-b-15">
							<div class="col-md-6">
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
							<div class="col-md-6">
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
						</div>
						<div class="form-group row m-b-0">
							<label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
							<div class="col-md-8 col-sm-8">
								<button type="submit" class="btn btn-primary">Imprimir Reporte</button>
							</div>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
 
@endsection

@push('scripts')

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
                window.open(html, '_blank');
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

	function valor_fecha(dato){
		$('#datepicker-default2').datepicker('setStartDate', dato);
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