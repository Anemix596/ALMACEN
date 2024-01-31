<?php

return [

    /*
    Cotizador
    */

    'menu' => [[
		'icon' => 'home',
		'title' => 'Principal',
		'url' => 'javascript:;',
	],[
		'icon' => 'settings',
		'title' => 'Opciones',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => 'inicio_cotizador',
			'title' => 'Lista de Pedidos Pendientes'
		],[
			'icon' => 'settings',
			'title' => 'Tipos de Modalidades',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [[
				'url' => 'proveedor_cotizacion',
            	'title' => 'Contratación Menor'
			],[
				'url' => 'proveedor_anpe',
            	'title' => 'Apoyo Nacional a la Producción y Empleo'
			],[
				'url' => 'proveedor_licitacion',
            	'title' => 'Licitación Pública'
			],[
				'url' => 'proveedor_excepcion',
            	'title' => 'Contratación por Excepción'
			]]
		],[
			'icon' => 'settings',
			'title' => 'Recepción de Órdenes',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [[
				'url' => 'recepcion_orden',
            	'title' => 'Contratación Menor'
			],[
				'url' => 'recepcion_anpe',
            	'title' => 'Apoyo Nacional a la Producción y Empleo'
			],[
				'url' => 'recepcion_licitacion',
            	'title' => 'Licitación Pública'
			],[
				'url' => 'recepcion_excepcion',
            	'title' => 'Contratación por Excepción'
			]]
		]
	]]
	]
];
