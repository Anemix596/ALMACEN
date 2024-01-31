<?php

use App\Http\Controllers\VistaController;
use App\Http\Controllers\VerificarLoginController;
use App\Http\Controllers\SolicitanteController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\DafController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CotizadorController;

Auth::routes();
Route::get('/', [VistaController::class, 'index']);

Route::middleware(['auth'])->group(function () {

    /* Vistas */
    Route::get('inicio_solicitante', [VerificarLoginController::class, 'vista_solicitante'])->name('inicio.solicitante');
    Route::get('/inicio_presupuesto', [VerificarLoginController::class, 'vista_presupuesto'])->name('inicio.presupuesto');
    Route::get('inicio_daf', [VerificarLoginController::class, 'vista_daf'])->name('inicio.daf');
    Route::get('/inicio_bien', [VerificarLoginController::class, 'vista_bien'])->name('inicio.bien');
    Route::get('inicio_almacen', [VerificarLoginController::class, 'vista_almacen'])->name('inicio.almacen');
    Route::get('inicio_cotizador', [VerificarLoginController::class, 'vista_cotizador'])->name('inicio.cotizador');
    Route::get('/inicio_adquisicion', [VerificarLoginController::class, 'vista_adquisicion'])->name('inicio.adquisicion');

    /* Solicitante */
    Route::get('inicio_suministros', [SolicitanteController::class, 'vista_suministros']);
    Route::get('vista_pedidos_realizados', [SolicitanteController::class, 'pedidos_realizados']);
    Route::post('/listar_pedido_articulo', [SolicitanteController::class, 'ver_lista_pedido_articulo'])->name('listar.pedido.articulo');
    Route::get('vista_pedidos_anulados', [SolicitanteController::class, 'pedidos_anulados']);
    Route::get('/recuperar_unidad_solicitante', [SolicitanteController::class, 'recuperar_unidad_solicitante'])->name('recuperar.unidad.solicitante');
    Route::post('/estructura_programatica', [SolicitanteController::class, 'estructura_programatica'])->name('estructura.programatica');
    Route::get('/recuperar_superior_responsable', [SolicitanteController::class, 'recuperar_superior_responsable'])->name('recuperar.superior.responsable');
    Route::get('/recuperar_articulo', [SolicitanteController::class, 'recuperar_articulo'])->name('recuperar.articulo');
    Route::post('/recuperar_articulo_valor', [SolicitanteController::class, 'recuperar_articulo_valor'])->name('recuperar.articulo.valor');
    Route::post('/recuperar_articulo_valor2', [SolicitanteController::class, 'recuperar_articulo_valor2'])->name('recuperar.articulo.valor2');
    Route::post('/recuperar_unidad_medida', [SolicitanteController::class, 'recuperar_unidad_medida'])->name('recuperar.unidad.medida');
    Route::get('/recuperar_categoria', [SolicitanteController::class, 'recuperar_categoria'])->name('recuperar.categoria');
    Route::get('/listar_unidad_medida', [SolicitanteController::class, 'listar_unidad_medida'])->name('listar.unidad.medida');
    Route::post('/ver_imprimir_pedido', [SolicitanteController::class, 'ver_imprimir_pedido'])->name('ver.imprimir.pedido');
    Route::post('/recuperar_observacion_pedido', [SolicitanteController::class, 'recuperar_observacion_pedido'])->name('recuperar.observacion.pedido');

    //Articulo
    Route::post('/insertar_articulo', [SolicitanteController::class, 'insertar_articulo'])->name('insertar.articulo');
    Route::post('/insertar_articulo2', [SolicitanteController::class, 'insertar_articulo2'])->name('insertar.articulo2');

    //Clasificacion
    Route::get('/recuperar_clasificacion', [SolicitanteController::class, 'recuperar_grupo_presupuesto'])->name('recuperar.clasificacion');
    Route::get('/recuperar_part_presup', [SolicitanteController::class, 'recuperar_part_presup'])->name('recuperar.partida.presup');
    Route::post('/listar_grupo_presupuesto', [SolicitanteController::class, 'listar_grupo_presupuesto'])->name('ver.editar.pedido.presup');
    Route::post('/listar_grupo_part', [SolicitanteController::class, 'listar_grupo_part'])->name('ver.editar.pedido.part');

    //Pedido
    Route::get('/ver_lista_pedido_realizado', [SolicitanteController::class, 'ver_lista_pedido_realizado'])->name('ver.lista.pedido.realizado');
    Route::post('/insertar_pedido_archivo', [SolicitanteController::class, 'insertar_pedido_archivo'])->name('insertar.pedido.archivo');
    Route::post('/ver_editar_pedido', [SolicitanteController::class, 'ver_editar_pedido'])->name('ver.editar.pedido');
    Route::post('/ver_editar_pedido_articulo', [SolicitanteController::class, 'ver_editar_pedido_articulo'])->name('ver.editar.pedido.articulo');
    Route::post('/ver_editar_pedido_categoria', [SolicitanteController::class, 'ver_editar_pedido_categoria'])->name('ver.editar.pedido.categoria');
    Route::post('/actualizar_pedido', [SolicitanteController::class, 'actualizar_pedido'])->name('actualizar.pedido');
    Route::post('/eliminar_pedido', [SolicitanteController::class, 'eliminar_pedido'])->name('eliminar.pedido');
    Route::post('/eliminar_archivo', [SolicitanteController::class, 'eliminar_archivo'])->name('eliminar.archivo');
    Route::get('/ver_lista_pedido', [SolicitanteController::class, 'ver_lista_pedido'])->name('ver.lista.pedido');
    Route::get('/ver_lista_pedido_anulado', [SolicitanteController::class, 'ver_lista_pedido_anulado'])->name('ver.lista.pedido.anulado');
    Route::post('/listar_pedido_articulo_anulado', [SolicitanteController::class, 'ver_lista_pedido_articulo_anulado'])->name('listar.pedido.articulo.anulado');
    Route::post('/lista_pedido_valor_solicitante', [SolicitanteController::class, 'lista_pedido_valor_solicitante'])->name('lista.pedido.valor.solicitante');



    //Presupuesto
    Route::get('/ver_lista_pedido_pendiente', [PresupuestoController::class, 'ver_lista_pedido_pendiente'])->name('ver.lista.pedido.pendiente');
    Route::post('/ver_lista_pedido_articulo_pendiente', [PresupuestoController::class, 'ver_lista_pedido_articulo_pendiente'])->name('listar.pedido.articulo.pendiente');
    Route::post('/ver_lista_pedido_articulo_pendiente_observacion', [PresupuestoController::class, 'ver_lista_pedido_articulo_pendiente_observacion'])->name('listar.pedido.articulo.pendiente.observacion');
    Route::get('/recuperar_fuente', [PresupuestoController::class, 'recuperar_fuente'])->name('recuperar.fuente');
    Route::get('/recuperar_organo', [PresupuestoController::class, 'recuperar_organo'])->name('recuperar.organo');
    Route::get('/recuperar_presupuesto', [PresupuestoController::class, 'recuperar_presupuesto'])->name('recuperar.presupuesto');
    Route::post('/valor_fuente', [PresupuestoController::class, 'valor_fuente'])->name('valor.fuente');
    Route::post('/valor_organo', [PresupuestoController::class, 'valor_organo'])->name('valor.organo');
    Route::post('/valor_presupuesto', [PresupuestoController::class, 'valor_presupuesto'])->name('valor.presupuesto');
    Route::post('/asignar_presupuesto_articulo', [PresupuestoController::class, 'asignar_presupuesto_articulo'])->name('asignar.presupuesto.articulo');
    Route::post('/ver_editar_pedido_presupuesto', [PresupuestoController::class, 'ver_editar_pedido_presupuesto'])->name('ver.editar.pedido.presupuesto');
    Route::post('/ver_editar_pedido_fuente', [PresupuestoController::class, 'ver_editar_pedido_fuente'])->name('ver.editar.pedido.fuente');
    Route::post('/ver_editar_pedido_organo', [PresupuestoController::class, 'ver_editar_pedido_organo'])->name('ver.editar.pedido.organo');
    Route::post('/ver_listar_pedido_presupuesto', [PresupuestoController::class, 'ver_listar_pedido_presupuesto'])->name('ver.listar.pedido.presupuesto');
    Route::post('/editar_presupuesto_articulo', [PresupuestoController::class, 'editar_presupuesto_articulo'])->name('editar.presupuesto.articulo');
    Route::post('/editar_estado_presupuesto_articulo', [PresupuestoController::class, 'editar_estado_presupuesto_articulo'])->name('editar.estado.presupuesto.articulo');
    Route::post('/ver_editar_fuente_fnto_pedido', [PresupuestoController::class, 'ver_editar_fuente_fnto_pedido'])->name('ver.editar.fuente.fnto.pedido');
    Route::post('/asignar_fuente_fnto_pedido', [PresupuestoController::class, 'asignar_fuente_fnto_pedido'])->name('asignar.fuente.fnto.pedido');
    Route::post('/editar_fuente_fnto_pedido', [PresupuestoController::class, 'editar_fuente_fnto_pedido'])->name('editar.fuente.fnto.pedido');
    Route::post('/lista_pedido_pendiente_valor', [PresupuestoController::class, 'lista_pedido_pendiente_valor'])->name('lista.pedido.pendiente.valor');
    Route::post('/ver_imprimir_pedido_presupuesto', [PresupuestoController::class, 'ver_imprimir_pedido'])->name('ver.imprimir.pedido.presupuesto');
    Route::post('/anular_pedido_presupuesto', [PresupuestoController::class, 'anular_pedido_presupuesto'])->name('anular.pedido.presupuesto');



    //Daf
    Route::get('/lista_pedido_pendiente_daf', [DafController::class, 'lista_pedido_pendiente'])->name('lista.pedido.pendiente.daf');
    Route::post('/lista_pedido_articulo_pendiente_daf', [DafController::class, 'lista_pedido_articulo_pendiente'])->name('listar.pedido.articulo.pendiente.daf');
    Route::post('/lista_pedido_articulo_pendiente_observacion_daf', [DafController::class, 'lista_pedido_articulo_pendiente_observacion'])->name('listar.pedido.articulo.pendiente.observacion.daf');
    Route::post('/guardar_datos_daf', [DafController::class, 'guardar_datos_daf'])->name('guardar.datos.daf');
    Route::post('/editar_datos_daf', [DafController::class, 'editar_datos_daf'])->name('editar.datos.daf');
    Route::post('/listar_pedido_aprobado_daf', [DafController::class, 'listar_pedido_aprobado_daf'])->name('listar.pedido.aprobado.daf');
    Route::post('/lista_pedido_valor_daf', [DafController::class, 'lista_pedido_valor_daf'])->name('lista.pedido.valor.daf');
    Route::get('autorizacion_compra_daf', [DafController::class, 'vista_aprobacion'])->name('autorizacion.compra.daf');
    Route::get('/listar_solicitud_daf', [DafController::class, 'listar_solicitud'])->name('listar.solicitud.daf');
    Route::post('/lista_solicitud_articulo', [DafController::class, 'lista_solicitud_articulo'])->name('listar.solicitud.articulo');
    Route::post('/aprobar_pedido_daf', [DafController::class, 'aprobar_pedido'])->name('aprobar.pedido.daf');
    Route::post('/rechazar_pedido_daf', [DafController::class, 'rechazar_pedido'])->name('rechazar.pedido.daf');
    Route::post('/lista_solicitud_valor_daf', [DafController::class, 'lista_solicitud_valor_daf'])->name('lista.solicitud.valor.daf');
    Route::post('/ver_imprimir_pedido_daf', [DafController::class, 'ver_imprimir_pedido'])->name('ver.imprimir.pedido.daf');
    Route::post('/ver_imprimir_solicitud_daf', [DafController::class, 'ver_imprimir_solicitud'])->name('ver.imprimir.solicitud.daf');
    Route::post('/anular_pedido_daf', [DafController::class, 'anular_pedido_daf'])->name('anular.pedido.daf');


    //Bien
    Route::get('/lista_pedido_pendiente_bien', [BienController::class, 'lista_pedido_pendiente'])->name('lista.pedido.pendiente.bien');
    Route::post('/lista_pedido_articulo_pendiente_bien', [BienController::class, 'lista_pedido_articulo_pendiente'])->name('listar.pedido.articulo.pendiente.bien');
    Route::post('/lista_pedido_valor_bien', [BienController::class, 'lista_pedido_valor_bien'])->name('lista.pedido.valor.bien');
    Route::post('/guardar_datos_bien', [BienController::class, 'guardar_datos_bien'])->name('guardar.datos.bien');
    Route::post('/editar_datos_bien', [BienController::class, 'editar_datos_bien'])->name('editar.datos.bien');
    Route::post('/ver_imprimir_pedido_bien', [BienController::class, 'ver_imprimir_pedido'])->name('ver.imprimir.pedido.bien');

    //Almacen
    Route::get('/lista_pedido_pendiente_almacen', [AlmacenController::class, 'lista_pedido_pendiente'])->name('lista.pedido.pendiente.almacen');
    Route::post('/lista_pedido_articulo_pendiente_almacen', [AlmacenController::class, 'lista_pedido_articulo_pendiente'])->name('listar.pedido.articulo.pendiente.almacen');
    Route::post('/lista_pedido_articulo_pendiente_almacen2', [AlmacenController::class, 'lista_pedido_articulo_pendiente2'])->name('listar.pedido.articulo.pendiente.almacen2');
    Route::post('/guardar_datos_almacen', [AlmacenController::class, 'guardar_datos_almacen'])->name('guardar.datos.almacen');
    Route::post('/editar_datos_almacen', [AlmacenController::class, 'editar_datos_almacen'])->name('editar.datos.almacen');
    Route::post('/lista_pedido_valor_almacen', [AlmacenController::class, 'lista_pedido_valor_almacen'])->name('lista.pedido.valor.almacen');
    Route::get('recepcion_orden_almacen', [AlmacenController::class, 'recepcion_orden'])->name('recepcion.orden.almacen');
    Route::get('/listar_todo_orden_almacen', [AlmacenController::class, 'listar_todo_orden'])->name('listar.todo.orden.almacen');
    Route::post('/listar_todo_orden_almacen_valor', [AlmacenController::class, 'listar_todo_orden_valor'])->name('listar.todo.orden.almacen.valor');
    Route::post('/listar_articulo_orden_almacen', [AlmacenController::class, 'listar_articulo_orden'])->name('listar.articulo.orden.almacen');
    Route::post('/listar_articulo_orden_almacen2', [AlmacenController::class, 'listar_articulo_orden2'])->name('listar.articulo.orden.almacen2');
    Route::post('/guardar_datos_recepcion_almacen', [AlmacenController::class, 'guardar_datos_recepcion'])->name('guardar.datos.recepcion.almacen');
    Route::post('/ver_imprimir_pedido_almacen', [AlmacenController::class, 'ver_imprimir_pedido'])->name('ver.imprimir.pedido.almacen');
    Route::post('/ver_imprimir_solicitud_almacen', [AlmacenController::class, 'ver_imprimir_solicitud'])->name('ver.imprimir.solicitud.almacen');
    Route::post('/ver_imprimir_recepcion_almacen', [AlmacenController::class, 'ver_imprimir_recepcion'])->name('ver.imprimir.recepcion.almacen');
    Route::post('/ver_imprimir_recepcion_almacen2', [AlmacenController::class, 'ver_imprimir_recepcion2'])->name('ver.imprimir.recepcion.almacen.lic_exc');
    Route::get('/listar_todo_orden_excepcion_almacen', [AlmacenController::class, 'listar_todo_orden_excepcion'])->name('listar.todo.orden.excepcion.almacen');
    Route::post('/listar_todo_orden_excepcion_almacen_valor', [AlmacenController::class, 'listar_todo_orden_excepcion_valor'])->name('listar.todo.orden.excepcion.almacen.valor');
    Route::get('recepcion_orden_excepcion_almacen', [AlmacenController::class, 'recepcion_orden_excepcion']);
    Route::get('recepcion_orden_licitacion_almacen', [AlmacenController::class, 'recepcion_orden_licitacion']);
    Route::get('recepcion_orden_anpe_almacen', [AlmacenController::class, 'recepcion_orden_anpe']);
    Route::post('/listar_articulo_orden_licitacion_almacen', [AlmacenController::class, 'listar_articulo_orden_licitacion'])->name('listar.articulo.orden.licitacion.almacen');
    Route::post('/listar_articulo_orden_licitacion_almacen2', [AlmacenController::class, 'listar_articulo_orden_licitacion2'])->name('listar.articulo.orden.licitacion.almacen2');
    Route::post('/guardar_datos_recepcion_licitacion_almacen', [AlmacenController::class, 'guardar_datos_recepcion_licitacion'])->name('guardar.datos.recepcion.licitacion.almacen');
    Route::get('/listar_todo_orden_licitacion_almacen', [AlmacenController::class, 'listar_todo_orden_licitacion'])->name('listar.todo.orden.licitacion.almacen');
    Route::post('/listar_todo_orden_licitacion_almacen_valor', [AlmacenController::class, 'listar_todo_orden_licitacion_valor'])->name('listar.todo.orden.licitacion.almacen.valor');
    Route::get('/listar_todo_orden_anpe_almacen', [AlmacenController::class, 'listar_todo_orden_anpe'])->name('listar.todo.orden.anpe.almacen');
    Route::post('/listar_todo_orden_anpe_almacen_valor', [AlmacenController::class, 'listar_todo_orden_anpe_valor'])->name('listar.todo.orden.anpe.almacen.valor');

    //Cotizador
    Route::get('/lista_pedido_pendiente_cotizador', [CotizadorController::class, 'lista_pedido_pendiente'])->name('lista.pedido.pendiente.cotizador');
    Route::get('proveedor_cotizacion', [CotizadorController::class, 'proveedor_cotizacion'])->name('proveedor.cotizacion');
    Route::get('proveedor_anpe', [CotizadorController::class, 'proveedor_anpe'])->name('proveedor.anpe');
    Route::post('/lista_pedido_articulo_pendiente_cotizador', [CotizadorController::class, 'lista_pedido_articulo_pendiente'])->name('listar.pedido.articulo.pendiente.cotizador');
    Route::post('/lista_pedido_articulo_pendiente_cotizador2', [CotizadorController::class, 'lista_pedido_articulo_pendiente2'])->name('listar.pedido.articulo.pendiente.cotizador2');
    Route::post('/guardar_datos_cotizador', [CotizadorController::class, 'guardar_datos'])->name('guardar.datos.cotizador');
    Route::post('/editar_datos_cotizador', [CotizadorController::class, 'editar_datos'])->name('editar.datos.cotizador');
    Route::post('/lista_pedido_valor_cotizador', [CotizadorController::class, 'lista_pedido_valor'])->name('lista.pedido.valor.cotizador');
    Route::get('/lista_pedido_proveedor_cotizador', [CotizadorController::class, 'lista_pedido_proveedor'])->name('lista.pedido.proveedor.cotizador');
    Route::post('/lista_pedido_proveedor_cotizador_valor', [CotizadorController::class, 'lista_pedido_proveedor_valor'])->name('lista.pedido.proveedor.cotizador.valor');
    Route::post('/lista_pedido_articulo_proveedor_cotizador', [CotizadorController::class, 'lista_pedido_articulo_proveedor'])->name('listar.pedido.articulo.proveedor.cotizador');
    Route::post('/lista_pedido_articulo_proveedor_cotizador2', [CotizadorController::class, 'lista_pedido_articulo_proveedor2'])->name('listar.pedido.articulo.proveedor.cotizador2');
    Route::post('/guardar_datos_cotizacion', [CotizadorController::class, 'guardar_datos_cotizacion'])->name('guardar.datos.cotizacion');
    Route::post('/recuperar_proveedor', [CotizadorController::class, 'recuperar_proveedor'])->name('recuperar.proveedor');
    Route::post('/recuperar_proveedor2', [CotizadorController::class, 'recuperar_proveedor2'])->name('recuperar.proveedor2');
    Route::post('/editar_proveedor', [CotizadorController::class, 'editar_proveedor'])->name('editar.proveedor');
    Route::post('/editar_proveedor2', [CotizadorController::class, 'editar_proveedor2'])->name('editar.proveedor2');
    Route::post('/editar_datos_cotizacion', [CotizadorController::class, 'editar_datos_cotizacion'])->name('editar.datos.cotizacion');
    Route::post('/listar_orden', [CotizadorController::class, 'listar_orden'])->name('listar.orden');
    Route::post('/listar_articulo_orden', [CotizadorController::class, 'listar_articulo_orden'])->name('listar.articulo.orden');
    Route::post('/listar_articulo_orden2', [CotizadorController::class, 'listar_articulo_orden2'])->name('listar.articulo.orden2');
    Route::post('/cuadro_proveedor', [CotizadorController::class, 'cuadro_proveedor'])->name('cuadro.proveedor');
    Route::post('/cuadro_proveedor2', [CotizadorController::class, 'cuadro_proveedor2'])->name('cuadro.proveedor2');
    Route::get('recepcion_orden', [CotizadorController::class, 'recepcion_orden'])->name('recepcion.orden');
    Route::get('/listar_todo_orden', [CotizadorController::class, 'listar_todo_orden'])->name('listar.todo.orden');
    Route::post('/guardar_datos_recepcion', [CotizadorController::class, 'guardar_datos_recepcion'])->name('guardar.datos.recepcion');
    Route::post('/editar_datos_recepcion', [CotizadorController::class, 'editar_datos_recepcion'])->name('editar.datos.recepcion');
    Route::post('/listar_todo_orden_valor', [CotizadorController::class, 'listar_todo_orden_valor'])->name('listar.todo.orden.valor');
    Route::post('/ver_imprimir_orden_cotizador', [CotizadorController::class, 'ver_imprimir_orden'])->name('ver.imprimir.orden.cotizador');
    Route::post('/ver_imprimir_orden_cotizador2', [CotizadorController::class, 'ver_imprimir_orden2'])->name('ver.imprimir.orden.cotizador.lic_exc');
    Route::post('/ver_imprimir_solicitud_cotizacion', [CotizadorController::class, 'ver_imprimir_solicitud_cotizacion'])->name('ver.imprimir.solicitud.cotizacion.cotizador');
    Route::post('/ver_imprimir_cuadro_cotizador', [CotizadorController::class, 'ver_imprimir_cuadro'])->name('ver.imprimir.cuadro.cotizador');
    Route::post('/ver_imprimir_recepcion_cotizador', [CotizadorController::class, 'ver_imprimir_recepcion'])->name('ver.imprimir.recepcion.cotizador');
    Route::post('/ver_imprimir_recepcion_cotizador2', [CotizadorController::class, 'ver_imprimir_recepcion2'])->name('ver.imprimir.recepcion.cotizador.lic_exc');
    Route::get('/recuperar_modalidad', [CotizadorController::class, 'recuperar_modalidad'])->name('recuperar.modalidad');
    Route::post('/mostrar_modalidad', [CotizadorController::class, 'mostrar_modalidad'])->name('mostrar.modalidad');
    Route::get('/lista_pedido_anpe_cotizador', [CotizadorController::class, 'lista_pedido_anpe'])->name('lista.pedido.anpe.cotizador');
    Route::post('/guardar_datos_anpe', [CotizadorController::class, 'guardar_datos_anpe'])->name('guardar.datos.anpe');
    Route::post('/lista_pedido_articulo_anpe_cotizador', [CotizadorController::class, 'lista_pedido_articulo_anpe'])->name('listar.pedido.articulo.anpe.cotizador');
    Route::post('/lista_pedido_articulo_anpe_cotizador2', [CotizadorController::class, 'lista_pedido_articulo_anpe2'])->name('listar.pedido.articulo.anpe.cotizador2');
    Route::post('/editar_anpe', [CotizadorController::class, 'editar_anpe'])->name('editar.anpe');
    Route::post('/editar_anpe2', [CotizadorController::class, 'editar_anpe2'])->name('editar.anpe2');
    Route::post('/editar_datos_anpe', [CotizadorController::class, 'editar_datos_anpe'])->name('editar.datos.anpe');
    Route::post('/editar_anpe_orden', [CotizadorController::class, 'editar_anpe_orden'])->name('editar.anpe.orden');
    Route::post('/editar_anpe_orden2', [CotizadorController::class, 'editar_anpe_orden2'])->name('editar.anpe.orden2');
    Route::post('/guardar_datos_anpe_orden', [CotizadorController::class, 'guardar_datos_anpe_orden'])->name('guardar.datos.anpe.orden');
    Route::post('/recuperar_proveedor_anpe', [CotizadorController::class, 'recuperar_proveedor_anpe'])->name('recuperar.proveedor.anpe');
    Route::get('/recuperar_proveedor_anpe2', [CotizadorController::class, 'recuperar_proveedor_anpe2'])->name('recuperar.proveedor.anpe2');
    Route::post('/modificar_anpe_orden', [CotizadorController::class, 'modificar_anpe_orden'])->name('modificar.anpe.orden');
    Route::post('/modificar_anpe_orden2', [CotizadorController::class, 'modificar_anpe_orden2'])->name('modificar.anpe.orden2');
    Route::post('/editar_datos_anpe_orden', [CotizadorController::class, 'editar_datos_anpe_orden'])->name('editar.datos.anpe.orden');
    Route::post('/lista_pedido_anpe_cotizador_valor', [CotizadorController::class, 'lista_pedido_anpe_valor'])->name('lista.pedido.anpe.cotizador.valor');
    Route::post('/insertar_proveedor2', [CotizadorController::class, 'insertar_proveedor2'])->name('insertar.proveedor');
    Route::post('/insertar_proveedor', [CotizadorController::class, 'insertar_proveedor'])->name('insertar.proveedor2');
    Route::post('/recuperar_proveedor_valor', [CotizadorController::class, 'recuperar_proveedor_valor'])->name('recuperar.proveedor.valor');
    Route::post('/finalizar_recepcion', [CotizadorController::class, 'finalizar_recepcion'])->name('finalizar.recepcion');
    Route::get('proveedor_licitacion', [CotizadorController::class, 'proveedor_licitacion'])->name('proveedor.licitacion');
    Route::get('/lista_pedido_licitacion_cotizador', [CotizadorController::class, 'lista_pedido_licitacion'])->name('lista.pedido.licitacion.cotizador');
    Route::post('/lista_pedido_licitacion_cotizador_valor', [CotizadorController::class, 'lista_pedido_licitacion_valor'])->name('lista.pedido.licitacion.cotizador.valor');
    Route::get('proveedor_excepcion', [CotizadorController::class, 'proveedor_excepcion'])->name('proveedor.excepcion');
    Route::get('/lista_pedido_excepcion_cotizador', [CotizadorController::class, 'lista_pedido_excepcion'])->name('lista.pedido.excepcion.cotizador');
    Route::post('/lista_pedido_excepcion_cotizador_valor', [CotizadorController::class, 'lista_pedido_excepcion_valor'])->name('lista.pedido.excepcion.cotizador.valor');
    Route::post('/guardar_datos_contrato', [CotizadorController::class, 'guardar_datos_contrato'])->name('guardar.datos.contrato');
    Route::post('/editar_orden_contrato', [CotizadorController::class, 'editar_orden_contrato'])->name('editar.orden.contrato');
    Route::post('/eliminar_contrato', [CotizadorController::class, 'eliminar_contrato'])->name('eliminar.contrato');
    Route::post('/editar_orden_contrato_prov', [CotizadorController::class, 'editar_orden_contrato_prov'])->name('editar.orden.contrato.prov');
    Route::get('recepcion_anpe', [CotizadorController::class, 'recepcion_anpe'])->name('recepcion.anpe');
    Route::get('recepcion_licitacion', [CotizadorController::class, 'recepcion_licitacion'])->name('recepcion.licitacion');
    Route::get('recepcion_excepcion', [CotizadorController::class, 'recepcion_excepcion'])->name('recepcion.excepcion');
    Route::get('/listar_todo_orden_anpe', [CotizadorController::class, 'listar_todo_orden_anpe'])->name('listar.todo.orden.anpe');
    Route::get('/listar_todo_orden_licitacion', [CotizadorController::class, 'listar_todo_orden_licitacion'])->name('listar.todo.orden.licitacion');
    Route::get('/listar_todo_orden_excepcion', [CotizadorController::class, 'listar_todo_orden_excepcion'])->name('listar.todo.orden.excepcion');
    Route::post('/listar_todo_orden_anpe_valor', [CotizadorController::class, 'listar_todo_orden_anpe_valor'])->name('listar.todo.orden.anpe.valor');
    Route::post('/listar_todo_orden_licitacion_valor', [CotizadorController::class, 'listar_todo_orden_licitacion_valor'])->name('listar.todo.orden.licitacion.valor');
    Route::post('/listar_todo_orden_excepcion_valor', [CotizadorController::class, 'listar_todo_orden_excepcion_valor'])->name('listar.todo.orden.excepcion.valor');
    Route::post('/editar_licitacion_orden', [CotizadorController::class, 'editar_licitacion_orden'])->name('editar.licitacion.orden');
    Route::post('/guardar_datos_licitacion_orden', [CotizadorController::class, 'guardar_datos_licitacion_orden'])->name('guardar.datos.licitacion.orden');
    Route::post('/modificar_licitacion_orden', [CotizadorController::class, 'modificar_licitacion_orden'])->name('modificar.licitacion.orden');
    Route::post('/editar_datos_licitacion_orden', [CotizadorController::class, 'editar_datos_licitacion_orden'])->name('editar.datos.licitacion.orden');
    Route::post('/listar_articulo_orden_licitacion', [CotizadorController::class, 'listar_articulo_orden_licitacion'])->name('listar.articulo.orden.licitacion');
    Route::post('/listar_articulo_orden_licitacion2', [CotizadorController::class, 'listar_articulo_orden_licitacion2'])->name('listar.articulo.orden.licitacion2');
    Route::post('/guardar_datos_recepcion_licitacion', [CotizadorController::class, 'guardar_datos_recepcion_licitacion'])->name('guardar.datos.recepcion.licitacion');
    Route::post('/finalizar_recepcion2', [CotizadorController::class, 'finalizar_recepcion_licitacion'])->name('finalizar.recepcion2');

    // Almacen Ingresos y Salidas

    Route::get('ver_compras', [AlmacenController::class, 'ver_compras']);
    Route::get('ingreso_stock', [AlmacenController::class, 'ingreso_stock']);
    Route::get('ingreso_inmediato', [AlmacenController::class, 'ingreso_inmediato']);
    Route::get('salidas', [AlmacenController::class, 'salidas']);
    Route::get('/listar_recepcion', [AlmacenController::class, 'listar_recepcion'])->name('listar.recepcion');
    Route::post('/listar_articulo_recepcion', [AlmacenController::class, 'listar_articulo_recepcion'])->name('listar.articulo.recepcion');
    Route::post('/listar_articulo_recepcion2', [AlmacenController::class, 'listar_articulo_recepcion2'])->name('listar.articulo.recepcion2');
    Route::post('/listar_articulo_recepcion3', [AlmacenController::class, 'listar_articulo_recepcion3'])->name('listar.articulo.recepcion3');
    Route::post('/listar_articulo_ingreso', [AlmacenController::class, 'listar_articulo_ingreso'])->name('listar.articulo.ingreso');
    Route::post('/listar_articulo_ingreso2', [AlmacenController::class, 'listar_articulo_ingreso2'])->name('listar.articulo.ingreso2');
    Route::get('/recuperar_movimiento', [AlmacenController::class, 'recuperar_movimiento'])->name('recuperar.movimiento');
    Route::post('/recuperar_movimiento2', [AlmacenController::class, 'recuperar_movimiento2'])->name('recuperar.movimiento2');
    Route::post('/guardar_datos_ingreso', [AlmacenController::class, 'guardar_datos_ingreso'])->name('guardar.datos.ingreso');
    Route::post('/listar_ingreso_valor', [AlmacenController::class, 'listar_ingreso_valor'])->name('listar.ingreso.valor');
    Route::post('/editar_datos_ingreso', [AlmacenController::class, 'editar_datos_ingreso'])->name('editar.datos.ingreso');
    Route::get('/listar_ingreso_stock', [AlmacenController::class, 'listar_ingreso_stock'])->name('listar.ingreso.stock');
    Route::post('/listar_articulo_ingreso3', [AlmacenController::class, 'listar_articulo_ingreso3'])->name('listar.articulo.ingreso3');
    Route::post('/guardar_salida_inmediato', [AlmacenController::class, 'guardar_salida_inmediato'])->name('guardar.datos.salida.inmediato');
    Route::post('/listar_articulo_salida', [AlmacenController::class, 'listar_articulo_salida'])->name('listar.articulo.salida');
    Route::post('/listar_salida_stock_valor', [AlmacenController::class, 'listar_salida_stock_valor'])->name('listar.salida.stock.valor');
    Route::get('/listar_ingreso_inmediato', [AlmacenController::class, 'listar_ingreso_inmediato'])->name('listar.ingreso.inmediato');
    Route::post('/listar_salida_inmediato_valor', [AlmacenController::class, 'listar_salida_inmediato_valor'])->name('listar.salida.inmediato.valor');
    Route::post('/guardar_salida_stock', [AlmacenController::class, 'guardar_salida_stock'])->name('guardar.datos.salida.stock');
    Route::post('/recuperar_datos_almacenados', [AlmacenController::class, 'recuperar_datos_almacenados'])->name('recuperar.datos.almacenados');
    Route::post('/recuperar_datos_almacenados2', [AlmacenController::class, 'recuperar_datos_almacenados2'])->name('recuperar.datos.almacenados2');
    Route::post('/recuperar_responsable_pedido', [AlmacenController::class, 'recuperar_superior_responsable'])->name('recuperar.responsable.pedido');
    Route::post('/guardar_datos_almacen_descargar', [AlmacenController::class, 'guardar_datos_almacen_descargar'])->name('guardar.datos.almacen.descargar');

    Route::get('resumen_inventario', [AlmacenController::class, 'resumen_inventario']);
    Route::get('recuperar_gestion_inventario', [AlmacenController::class, 'recuperar_gestion_inventario'])->name('recuperar.gestion.inventario');
    Route::post('imprimir_resumen_inventario', [AlmacenController::class, 'ver_imprimir_inventario'])->name('ver.imprimir.inventario');
    Route::get('inventario', [AlmacenController::class, 'inventario']);
    Route::get('kardex_articulo', [AlmacenController::class, 'kardex_articulo']);
    Route::post('imprimir_inventario', [AlmacenController::class, 'imprimir_kardex_articulo'])->name('ver.imprimir.kardex.articulo');
    Route::get('cierre', [AlmacenController::class, 'cierre']);
    Route::post('cierre_almacen', [AlmacenController::class, 'cierre_almacen'])->name('cierre.almacen');
    Route::get('recuperar_gestion_cierre', [AlmacenController::class, 'recuperar_gestion_cierre'])->name('recuperar.gestion.cierre');
    Route::get('vista_cierre', [AlmacenController::class, 'vista_cierre']);
    Route::post('imprimir_cierre', [AlmacenController::class, 'ver_imprimir_cierre'])->name('ver.imprimir.cierre');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
