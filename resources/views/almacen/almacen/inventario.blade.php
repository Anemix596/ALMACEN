@extends('layouts.default')

@section('title', 'Resumen de Inventario')

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
    
    
    <h1 class="page-header">Reporte de Resumen de Inventario</h1>
    <h3 class="page-header">Materiales y Suministros</h3>
    
    
    <div class="row">
		<div class="col-xl-12">
			<div class="panel panel-inverse" data-sortable-id="form-validation-1">
				
				<div class="panel-heading">
					<h4 class="panel-title">Reporte de Resumen de Inventario - Materiales y Suministros</h4>
				</div>
				<div class="panel-body">
					<form id="reporte_inventario" action="{{ route('ver.imprimir.inventario') }}" method="POST" class="form-horizontal" data-parsley-validate="true">
						@csrf
						<div class="form-group row m-b-15">
							<label class="col-md-4 col-sm-4 col-form-label">Seleccione Año * :</label>
							
							<div class="col-md-8 col-sm-8">
								<select id="anio" name="anio" class="default-select2 form-control" data-size="10" data-live-search="true" required>
							
								</select>
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

<script>
    $.ajax({
        type:'GET',
        url:'{{ route('recuperar.gestion.inventario') }}',
        data:$(this).serialize(),
        success:function(html){
            $('#anio').html(html);
        }
        
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