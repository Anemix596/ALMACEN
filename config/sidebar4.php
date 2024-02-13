<?php

return [

	/*
    Almacen
    */

	'menu' => [[
		'icon' => 'check',
		'url' => 'inicio_almacen',
		'title' => 'Aprobación de Pedidos'
	], [
		'icon' => 'wallet',
		'title' => 'Recepción de Órdenes',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => 'recepcion_orden_almacen',
			'title' => 'Contratación Menor'
		], [
			'url' => 'recepcion_orden_anpe_almacen',
			'title' => 'Apoyo Nacional a la Producción y Empleo'
		], [
			'url' => 'recepcion_orden_licitacion_almacen',
			'title' => 'Licitación Pública'
		], [
			'url' => 'recepcion_orden_excepcion_almacen',
			'title' => 'Contratación por Excepción'
		], [
			'url' => 'recepcion_orden_compra_almacen',
			'title' => 'Compra Directa'
		]]
	], [
		'icon' => 'book',
		'title' => 'Almacén',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => 'ver_compras',
			'title' => 'Ver Compras'
		], [
			'url' => 'ingreso_stock',
			'title' => 'Ingresos Stock'
		], [
			'url' => 'ingreso_inmediato',
			'title' => 'Ingresos Inmediatos'
		], [
			'url' => 'salida_stock',
			'title' => 'Salidas Stock'
		], [
			'url' => 'salida_inmediato',
			'title' => 'Salidas Inmediatas'
		], [
			'url' => 'cierre',
			'title' => 'Cierre'
		]]
	], [
		'icon' => 'book',
		'title' => 'Reportes',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => 'inventario',
			'title' => 'Inventario'
		], [
			'url' => 'kardex_articulo',
			'title' => 'Kardex de Artículo'
		], [
			'url' => 'resumen_inventario',
			'title' => 'Resumen de Movimientos'
		], [
			'url' => 'vista_cierre',
			'title' => 'Cierre Anual'
		]]
	]]
];
