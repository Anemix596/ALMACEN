<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'menu' => [[
		'icon' => 'home',
		'title' => 'Realizar Pedidos',
		'url' => 'javascript:;',
        'caret' => true,
//		'badge' => '10',
		'sub_menu' => [[
			'url' => 'inicio_solicitante',
			'title' => 'Activos Reales'
		],[
			'url' => 'inicio_suministros',
			'title' => 'Materiales y Suministros'
		]]
	],[
		'icon' => 'note',
		'title' => 'Pedidos Realizados',
		'url' => 'vista_pedidos_realizados',
	],[
		'icon' => 'note',
		'title' => 'Pedidos Anulados',
		'url' => 'vista_pedidos_anulados',
	]]
];
