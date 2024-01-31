<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
</head>
@php
	$bodyClass = (!empty($boxedLayout)) ? 'boxed-layout' : '';
	$bodyClass .= (!empty($paceTop)) ? 'pace-top ' : '';
	$bodyClass .= (!empty($bodyExtraClass)) ? $bodyExtraClass . ' ' : '';
	$sidebarHide = (!empty($sidebarHide)) ? $sidebarHide : '';
	$sidebarTwo = (!empty($sidebarTwo)) ? $sidebarTwo : '';
	$sidebarSearch = (!empty($sidebarSearch)) ? $sidebarSearch : '';
	$topMenu = (!empty($topMenu)) ? $topMenu : '';
	$footer = (!empty($footer)) ? $footer : '';

	$sidebarWide = true;
	$pageContainerClass = (!empty($topMenu)) ? 'page-with-top-menu ' : '';
	$pageContainerClass .= (!empty($sidebarWide)) ? 'page-with-wide-sidebar ' : '';
	$contentClass = (!empty($contentFullWidth) || !empty($contentFullHeight)) ? 'content-full-width ' : '';
	$contentClass .= (!empty($contentInverseMode)) ? 'content-inverse-mode ' : '';
@endphp
<body class="{{ $bodyClass }}">
	@include('includes.component.page-loader')

	<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed {{ $pageContainerClass }}">

		@include('includes.header')


		@if (session('cadena') == "SOLICITANTE")
		@includeWhen(!$sidebarHide, 'includes.sidebar')
		@elseif (session('cadena') == "PRESUPUESTO")
		@includeWhen(!$sidebarHide, 'includes.sidebar2')
		@elseif (session('cadena') == "DAF")
		@includeWhen(!$sidebarHide, 'includes.sidebar3')
		@elseif (session('cadena') == "BIEN")
		@includeWhen(!$sidebarHide, 'includes.sidebar6')
		@elseif (session('cadena') == "ALMACEN")
		@includeWhen(!$sidebarHide, 'includes.sidebar4')
		@elseif (session('cadena') == "ADQUISICION")
		@includeWhen(!$sidebarHide, 'includes.sidebar5')
		@elseif (session('cadena') == "COTIZADOR")
		@includeWhen(!$sidebarHide, 'includes.sidebar7')
		@endif


		<div id="content" class="content {{ $contentClass }}">
			@yield('content')
		</div>

		@includeWhen($footer, 'includes.footer')

		@include('includes.component.scroll-top-btn')

	</div>

	@include('includes.page-js')
</body>
</html>
