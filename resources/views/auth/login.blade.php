
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Adquisición de Bienes | Iniciar Sesión</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<link href="assets/css/material/app.min.css" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<div class="material-loader">
			<svg class="circular" viewBox="25 25 50 50">
				<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
			</svg>
			<div class="message">Cargando...</div>
		</div>
	</div>
	<!-- end #page-loader -->
	
	<!-- begin login-cover -->
	<div class="login-cover">
		<div class="login-cover-image" style="background-image: url(assets/img/login-bg/login-bg-17.jpg)" data-id="login-cover-image"></div>
		<div class="login-cover-bg"></div>
	</div>
	<!-- end login-cover -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin login -->
		<div class="login login-v2" data-pageload-addclass="animated fadeIn">
			<!-- begin brand -->
			<div class="login-header">
				<div class="brand">
					<span class="logo"></span> <b>Sistema de Pedidos</b>
				</div>
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
			</div>
			<!-- end brand -->
			<!-- begin login-content -->
			<div class="login-content">
				<form method="POST" action="{{ route('login') }}" class="margin-bottom-0">
					@csrf
					<div class="form-group m-b-20">
						<label class="col-lg-1 text-lg-right col-form-label">USUARIO </label>
						<input class="form-control form-control-lg @error('alias') is-invalid @enderror" id="alias" type="text" name="alias" placeholder="INGRESE AQUÍ SU USUARIO" value="{{ old('alias') }}" required autocomplete="alias" autofocus onkeyup="convertirEnMayusculas(this)" {{-- onkeypress="return solo_letras(event)" --}}>
						@error('alias')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group m-b-20">
						<label class="col-lg-1 text-lg-right col-form-label">CONTRASEÑA </label>
						<input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="INGRESE AQUÍ SU CONTRASEÑA" minlength="3" required autocomplete="current-password">

						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					{{-- <div class="checkbox checkbox-css m-b-20">
						<input type="checkbox" id="remember_checkbox" /> 
						<label for="remember_checkbox">
							Recordarme
						</label>
					</div> --}}
					<div class="login-buttons">
						<button type="submit" class="btn btn-aqua btn-block btn-lg">Iniciar Sesión</button>
					</div>
					<div class="m-t-20">
						No recuerda la contraseña? Comuníquese con el Administrador.
					</div>
				</form>
			</div>
			<!-- end login-content -->
		</div>
		<!-- end login -->		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/theme/material.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="assets/js/demo/login-v2.demo.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		function convertirEnMayusculas(e){
			e.value = e.value.toUpperCase();
		}

		function solo_letras (e) {
			key=e.keyCode || e.which;
			teclado=String.fromCharCode(key).toLowerCase();
			letras_num="abcdefghijklmnñopqrstuvwxyz";
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
</body>
</html>