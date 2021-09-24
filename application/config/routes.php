<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
// USUARIO LOGEADO ---> $route['tasaciones/(:any)'] = 'tasaciones/tasaciones/$1';

|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'intranet';

$route['404_override'] = '';

$route['intranet/inicio'] = 'intranet';

/*BEGIN MANTENIMIENTO*/
$route['usuario'] = 'usuario/usuario';
$route['usuario/(.*)'] = 'usuario/usuario/$1';

$route['area'] = 'area/area';
$route['area/(.*)'] = 'area/area/$1';

$route['rol'] = 'rol/rol';
$route['rol/(.*)'] = 'rol/rol/$1';

$route['permiso'] = 'permiso/permiso';
$route['permiso/(.*)'] = 'permiso/permiso/$1';
/*END MANTENIMIENTO*/

/*BEGIN ADMINISTRACIÓN - COORDINACION - OPERACIONES*/
$route['administracion'] = 'administracion/administracion';
$route['administracion/(.*)'] = 'administracion/administracion/$1';

$route['cotizacion'] = 'cotizacion/cotizacion';
$route['cotizacion/(.*)'] = 'cotizacion/cotizacion/$1';

/*$route['coordinacion'] = 'coordinacion/coordinacion';
$route['coordinacion/(.*)'] = 'coordinacion/coordinacion/$1';*/
//$route['operaciones/(.*)'] = 'coordinacion/coordinacion/$1';
$route['(.*)/coordinaciones/(.*)'] = 'coordinacion/coordinacion/$2';
$route['(.*)/carga/(.*)'] = 'operaciones/operaciones/$2';
$route['(.*)/proceso/(.*)'] = 'operaciones/proceso/$2';


$route['facturacion'] = 'facturacion/facturacion';
$route['facturacion/(.*)'] = 'facturacion/facturacion/$1';

$route['coordinador'] = 'coordinador/coordinador';
$route['coordinador/(.*)'] = 'coordinador/coordinador/$1';

$route['perito'] = 'perito/perito';
$route['perito/(.*)'] = 'perito/perito/$1';

$route['calidad'] = 'calidad/calidad';
$route['calidad/(.*)'] = 'calidad/calidad/$1';

$route['ubigeo'] = 'ubigeo/ubigeo';
$route['ubigeo/(.*)'] = 'ubigeo/ubigeo/$1';
$route['(.*)/ubigeo/(.*)'] = 'ubigeo/ubigeo/$2';

$route['(.*)/tipo-documento/(.*)'] = 'tdocumento/TDocumento/$2';
$route['(.*)/involucrado/(.*)'] = 'involucrado/involucrado/$2';
$route['(.*)/contacto/(.*)'] = 'contacto/contacto/$2';

$route['visita'] = 'visita/visita';
$route['visita/(.*)'] = 'visita/visita/$1';

$route['inspeccion/(.*)'] = 'inspeccion/inspeccion/$1';
$route['(.*)/inspecciones/(.*)'] = 'inspeccion/inspeccion/$2';
$route['(.*)/visita/(.*)'] = 'visita/visita/$2';

$route['servicio'] = 'servicio/servicio';
$route['servicio/(.*)'] = 'servicio/servicio/$1';

$route['seguimiento'] = 'seguimiento/seguimiento';
$route['seguimiento/(.*)'] = 'seguimiento/seguimiento/$1';
/*END ADMINISTRACIÓN - COORDINACION - OPERACIONES*/


/*BEGIN REPORTE*/
$route['reporte'] = 'reporte/reporte';
    //BEGIN ADMINISTRACION
    $route['reporte/administracion/terminados'] = 'reporte/reporte/terminadas';
    //BEGIN COORDINACIÓN
    $route['reporte/coordinacion/generadas'] = 'reporte/reporte/generadas';
    $route['reporte/coordinacion/searchGeneradas'] = 'reporte/reporte/searchGeneradas';
    $route['reporte/coordinacion/generadas/imprimir'] = 'reporte/reporte/imprimirGeneradas';
    $route['reporte/coordinacion/generadas/exportarExcel'] = 'reporte/reporte/exportarExcelGeneradas';
    $route['reporte/coordinacion/generadas/resumen'] = 'reporte/reporte/resumenGeneradas';

    $route['reporte/coordinacion/reprocesos'] = 'reporte/reporte/reprocesos';
    $route['reporte/coordinacion/reprocesos/impresion'] = 'reporte/reporte/impresionReprocesos';
    //END COORDINACIÓN
    //BEGIN OPERACIONES
    //$route['reporte/coordinacion/generadas'] = 'reporte/reporte/generadas';
    //END OPERACIONES
    //BEGIN SISTEMAS
    $route['reporte/sistemas/servicio-cotizado'] = 'reporte/reporte/servicio_cotizado';
    $route['reporte/sistemas/mayor-servicio-solicitado-particulares'] = 'reporte/reporte/mayor_servicio_cotizado_particulares';
    $route['reporte/sistemas/mayor-servicio-solicitado-bancos'] = 'reporte/reporte/mayor_servicio_cotizado_bancos';
    $route['reporte/sistemas/ventas-por-servicio'] = 'reporte/reporte/ventas_servicio';
    //END SISTEMAS
$route['reporte/(.*)'] = 'reporte/reporte/$1';
/*END REPORTE*/

/*BEGIN TASACIÓN*/
$route['tasacion'] = 'tasacion/tasacion';
$route['tasacion/(.*)'] = 'tasacion/tasacion/$1';
$route['tasaciones/(.*)/(.*)'] = 'tasacion/tasacion/$2';

$route['tascliente'] = 'tasacion/cliente';
$route['tascliente/(.*)'] = 'tasacion/cliente/$1';

$route['taspropietario'] = 'tasacion/propietario';
$route['taspropietario/(.*)'] = 'tasacion/propietario/$1';

$route['tassolicitante'] = 'tasacion/solicitante';
$route['tassolicitante/(.*)'] = 'tasacion/solicitante/$1';

$route['zonificacion'] = 'tasacion/zonificacion';
$route['zonificacion/(.*)'] = 'tasacion/zonificacion/$1';

$route['clase'] = 'tasacion/clase';
$route['clase/(.*)'] = 'tasacion/clase/$1';

$route['marca'] = 'tasacion/marca';
$route['marca/(.*)'] = 'tasacion/marca/$1';

$route['modelo'] = 'tasacion/modelo';
$route['modelo/(.*)'] = 'tasacion/modelo/$1';

$route['tipo_no_registrado'] = 'tasacion/TNRegistrado';
$route['tipo_no_registrado/(.*)'] = 'tasacion/TNRegistrado/$1';

//MAPA ANTIGUO
$route['tasaciones'] = 'tasaciones/tasaciones';
$route['tasaciones/(.*)'] = 'tasaciones/tasaciones/$1';
/*END TASACION*/

$route['translate_uri_dashes'] = FALSE;
