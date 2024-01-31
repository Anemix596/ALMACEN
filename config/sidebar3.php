<?php

return [

    /*
    daf
    */

    'menu' => [[
		'icon' => 'home',
		'title' => 'Principal',
		'url' => 'javascript:;',
	],[
		'icon' => 'settings',
		'title' => 'Opciones de Director',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => 'inicio_daf',
			'title' => 'Autorización del Pedido'
		],[
            'url' => 'autorizacion_compra_daf',
            'title' => 'Autorización de Compra'
        ]]
	]]
];
