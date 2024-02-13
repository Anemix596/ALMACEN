@php
	$headerClass = (!empty($headerInverse)) ? 'navbar-inverse ' : 'navbar-default ';
	$headerMenu = (!empty($headerMenu)) ? $headerMenu : '';
	$headerMegaMenu = (!empty($headerMegaMenu)) ? $headerMegaMenu : '';
	$headerTopMenu = (!empty($headerTopMenu)) ? $headerTopMenu : '';
@endphp

<div id="header" class="header {{ $headerClass }}">
	
	<div class="navbar-header">


        <button type="button" class="navbar-toggle collapsed navbar-toggle-left" data-click="sidebar-minify">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
		<a href="/" class="navbar-brand"> <strong>Adquisición</strong></a>


	</div>
	<ul class="navbar-nav navbar-right">
        @yield('header-nav')


		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<img src="{{ asset('/assets/img/user/user-13.jpg')}}" alt="" />
				<span class="d-none d-md-inline">
					@php
						echo session('usuario')
					@endphp
				</span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="{{ url('/logout')}}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
		
						<form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
							@csrf
						</form>
			</div>
		</li>

	</ul>
	
</div>

