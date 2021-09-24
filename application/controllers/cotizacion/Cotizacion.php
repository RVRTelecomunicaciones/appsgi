<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizacion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        /*MODELOS*/
        $this->load->model('cotizacion/cotizacion_m', 'cot');
        $this->load->model('tcotizacion/TCotizacion_m', 'tpc');
        $this->load->model('tservicio/TServicio_m', 'tps');
        $this->load->model('coordinador/coordinador_m', 'coor');
        $this->load->model('vendedor/vendedor_m', 'ven');
        $this->load->model('estado/estado_m', 'est');
        $this->load->model('desglose/desglose_m', 'dsg');
        $this->load->model('moneda/moneda_m', 'mnd');
        $this->load->model('involucrado/involucrado_m', 'inv');
        $this->load->model('contacto/contacto_m', 'con');
        $this->load->model('clasificacion/clasificacion_m', 'cla');
        $this->load->model('actividad/actividad_m', 'act');
        $this->load->model('grupo/grupo_m', 'grp');
        $this->load->model('servicio/servicio_m', 'ser');
        $this->load->model('pago/pago_m', 'pag');
        $this->load->model('perito/perito_m', 'per');
        $this->load->model('coordinacion/coordinacion_m', 'coord');
        $this->load->model('inspeccion/inspeccion_m', 'ins');
        $this->load->model('auditoria/auditoria_m', 'aud');
        $this->load->model('requisito/requisito_m', 'req');
        $this->load->model('facturacion/facturacion_m', 'fac');
		
        $this->load->model('seguimiento/seguimiento_m', 'seg');

        
        $this->load->model('impuesto/impuesto_m', 'imp');

        /*LIBRERIAS*/
        $this->load->library('excel');
        $this->load->library('word');
        $this->load->library('conversor');
    }

    /*BEGIN COTIZACIÓN*/
	public function index()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        }else{
			$data['conteo'] = $this->cot->countCotizacionEstados();
        	$data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['tservicio'] = $this->tps->searchTServicio(array('accion' => 'filtros', 'servicio_tipo_estado' => ''));
        	$data['vendedor'] = $this->ven->vendedorReporte();
        	$data['estado'] = $this->est->estadoCotizacion();
        	$data['view'] = 'cotizacion/cotizacion_list';
			$this->load->view('layout', $data);
		}
	}

    public function mantenimiento()
    {
        $data['tcotizacion'] = $this->tpc->tcotizacionReporte();
		$data['tservicio'] = $this->tps->searchTServicio(array('accion' => 'filtros', 'servicio_tipo_estado' => '1'));
        $data['vendedor'] = $this->ven->vendedorReporte();
        $data['estado'] = $this->est->estadoCotizacion();
        $data['desglose'] = $this->dsg->desgloseReporte();
        $data['moneda'] = $this->mnd->monedaReporte();
        $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
        $data['impuesto'] = $this->imp->search(array('action' => 'sheet'));
        $data['view'] = 'cotizacion/cotizacion_mant';
        $this->load->view('layout_form', $data);
    }

	public function searchCotizacion()
	{
        $filters = array(
                            'cotizacion_codigo' => $this->input->post('cotizacion_codigo'),
                            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
                            'coordinador_id' => $this->input->post('coordinador_id'),
                            'vendedor_id' => $this->input->post('vendedor_id'),
                            'cliente_nombre' => $this->input->post('cliente_nombre'),
                            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
                            'cotizacion_moneda_monto' => $this->input->post('cotizacion_moneda_monto'),
                            'tipo_fecha' => $this->input->post('tipo_fecha'),
                            'cotizacion_fecha_desde' => $this->input->post('cotizacion_fecha_desde'),
                            'cotizacion_fecha_hasta' => $this->input->post('cotizacion_fecha_hasta'),

                            'estado_id' => $this->input->post('estado_id'),
                            'order' => $this->input->post('order'),
                            'order_type' => $this->input->post('order_type')
                        );

        $filters_total_records = array(
                            'cotizacion_codigo' => '',
                            'servicio_tipo_id' => '',
                            'coordinador_id' => '',
                            'vendedor_id' => '',
                            'cliente_nombre' => '',
                            'solicitante_nombre' => '',
                            'cotizacion_moneda_monto' => '',
                            'tipo_fecha' => '',
                            'cotizacion_fecha_desde' => '',
                            'cotizacion_fecha_hasta' => '',
                            'estado_id' => ''
                        );
        $num_page =  $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'cotizacion' => $this->cot->searchCotizacion($filters, $init, $quantity),
                        'total_records_find' => $this->cot->searchCotizacion($filters) == false ? false : count($this->cot->searchCotizacion($filters)),
                        'total_records' => $this->cot->searchCotizacion($filters_total_records) == false ? false : count($this->cot->searchCotizacion($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function searchCotizacionById()
    {
        $result = $this->cot->searchCotizacionById($this->input->post('cotizacion_id'));
        echo json_encode($result);
    }

    public function searchInvServ($cotizacion)
    {
        $data = array(
                            'involucrados' => $this->inv->searchCotizacionInvolucrados($cotizacion),
                            'servicios' => $this->ser->searchCotizacionServicios($cotizacion)
                        );
        echo json_encode($data);
    }

    public function existeCoordinacion($cotizacion)
    {   
        $data = array('cantCoordinacion' => json_encode($this->coord->searchCoordinacion(array('accion' => 'cotizacion', 'cotizacion_id' => $cotizacion))) == 'false' ? 0 : count($this->coord->searchCoordinacion(array('accion' => 'cotizacion', 'cotizacion_id' => $cotizacion))));
        echo json_encode($data);
    }

    public function insertCotizacion()
    {
        if ($this->session->userdata('usu_id') == null) {
            $data = array('success' => 'session');
            echo json_encode($data);
        } else {
            $path = '../files/cotizacion/adjuntos/';
            //$path = 'files/cotizacion/adjuntos/';
            $file_name = '';
            //$file_ext = '';
            $arrClientes = [];
            $arrSolicitantes = [];

            if (isset($_FILES['file'])) {
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
                //$file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $file = $path.$file_name;

                move_uploaded_file($file_tmp, $file);
            }
            
            $row_colum = $this->cot->obtenerCorrelativo();

            $field = array (
                'id' => $this->input->post('cotizacion_id'),
                'codigo' => $row_colum->cotizacion_correlativo,
                'cantidad_informe' => $this->input->post('cotizacion_cantidad'),
                'actualizacion' => $this->input->post('cotizacion_actualizacion'),
                'tipo_cotizacion_id' => $this->input->post('tipo_cotizacion_id'),
                'servicio_tipo_id' => '0',
                //'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
                //'orden_servicio' => $this->input->post('orden_servicio'),
                'motivo' => $this->input->post('motivo'),
                'estado_id' => $this->input->post('estado_id'),
                'adjunto' => $file_name,
                'fecha_solicitud' => $this->input->post('cotizacion_fecha_solicitud'),
                'fecha_envio_cliente' => $this->input->post('cotizacion_fecha_envio_cliente'),
                'fecha_finalizacion' => $this->input->post('cotizacion_fecha_finalizacion'),
                'plazo' => $this->input->post('plazo'),
                'vendedor_id' => $this->input->post('vendedor_id'),
                'vendedor_porcentaje_comision' => $this->input->post('vendedor_porcentaje_comision'),
                'desglose_id' => $this->input->post('desglose_id'),
                'tipo_perito' => $this->input->post('tipo_perito'),
                'perito_id' => $this->input->post('perito_id'),
                'perito_costo' => $this->input->post('perito_costo'),
                'viatico_importe' => $this->input->post('viatico_importe'),
                'datos_adicionales' => $this->input->post('datos_adicionales'),
                'info_status' => '1',
                'info_create_user' => $this->session->userdata('usu_id')
            );

            $cotizacion_id = $this->cot->Insert($field);
            
            $arrayTServicio = explode(',', $this->input->post('servicio_tipo_id'));

            for ($i = 0; $i < sizeof($arrayTServicio); $i++) { 
                $field_detalle = array(
                    'cotizacion_id' => $cotizacion_id,
                    'servicio_tipo_id' => $arrayTServicio[$i]
                );

                $this->cot->insertCotizacionDetalle($field_detalle);
            }
            
            $objInvolucrado = json_decode($this->input->post('involucrados'));
            $objServicio = json_decode($this->input->post('servicios'));

            if (count((array) $objInvolucrado) > 0) {
                $c = 0; $s = 0;
                foreach ($objInvolucrado as $row) {
                    $fild_involucrado = array (
                        'id' => '0',
                        'cotizacion_id' => $cotizacion_id,
                        'persona_id' => '0',
                        'persona_id_new' => $row->involucrado_id,
                        'persona_tipo' => $row->involucrado_tipo_nombre,
                        'rol_id' => $row->rol_id,
                        'contacto_id' => $row->contacto_id,
                        'info_status' => '1',
                        'info_create_user' => $this->session->userdata('usu_id')
                    );
                    $this->inv->insertCotizacionInvolucrado($fild_involucrado);
                    
                    if ($row->rol_id === 1){
                        $arrClientes[$c] = $row->involucrado_id.'-'.$row->involucrado_tipo_nombre;
                        $c++;
                    }

                    if ($row->rol_id === 2){
                        $arrSolicitantes[$s] = $row->involucrado_id.'-'.$row->involucrado_tipo_nombre.'-'.$row->contacto_id;
                        $s++;
                    }
                }
            }

            if (count((array) $objServicio) > 0) {
                foreach ($objServicio as $row) {
                    $fild_servicio = array (
                        'id' => '0',
                        'servicio_sub_id' => $row->servicio_id,
                        'descripcion' => '',
                        'cantidad' => $row->servicio_cantidad,
                        'subtotal' => $row->servicio_costo,
                        'cotizacion_id' => $cotizacion_id,
                        'info_status' => '1',
                        'info_create_user' => $this->session->userdata('usu_id')
                    );
                    $this->ser->insertCotizacionServicio($fild_servicio);
                }
            }

            $field_pago = array(
                'id' => $this->input->post('pago_id'),
                'cotizacion_id' => $cotizacion_id,
                //'total_igv' => $this->input->post('igv') == 'con' ? '0' : '0.18',
                'impuesto_id' => $this->input->post('impuesto_id'),
                'total_igv' => '0.18',
                'total_igv_de' => $this->input->post('igv'),
                'total_monto' => $this->input->post('pago_subtotal'),
                'total_monto_igv' => $this->input->post('pago_total'),
                'total_cambio' => $this->input->post('pago_tipo_cambio'),
                'total_moneda_id' => $this->input->post('moneda_id'),
                'fecha' => $this->input->post('pago_fecha'),
                'info_status' => '1',
                'info_create_user' => $this->session->userdata('usu_id')
            );

            $pago_id = $this->pag->Insert($field_pago);

            //BEGIN COORDINACIÓN
            $solicitante_id = 0;
            $solicitante_tipo = '';
            $solicitante_contacto_id = 0;
            $cliente_id = 0;
            $cliente_tipo = '';

            if (count($arrClientes) === 1) {
                $part = explode('-', $arrClientes[0]);
                $cliente_id = $part[0];
                $cliente_tipo = $part[1];
            }

            if (count($arrSolicitantes) === 1) {
                $part = explode('-', $arrSolicitantes[0]);
                $solicitante_id = $part[0];
                $solicitante_tipo = $part[1];
                $solicitante_contacto_id = $part[2];
            }

            $data_coordinacion = array(
                'cotizacion_id' => $cotizacion_id, 
                'coordinador_id' => $this->session->userdata('usu_id'),
                'solicitante_id' => '0',
                'solicitante_id_new' => $solicitante_id,
                'solicitante_tipo' => $solicitante_tipo,
                'solicitante_contacto_id' => $solicitante_contacto_id,
                'cliente_id' => '0',
                'cliente_id_new' => $cliente_id,
                'cliente_tipo' => $cliente_tipo,
                'tipo_id' => $this->input->post('servicio_tipo_id'),
                'tipo2_id' => 1,
                'solicitante_fecha' => $this->input->post('cotizacion_fecha_solicitud'),
                'entrega_al_cliente_fecha' => $this->input->post('cotizacion_fecha_envio_cliente'),
                'cantidad_informe' => $this->input->post('cotizacion_cantidad'),
                'estado_id' => $this->input->post('estado_id')
            );

            $this->insertCoordinacion($data_coordinacion);
            //END COORDINACIÓN

            $data = array(
                        'success' => $cotizacion_id > 0 ? true : false,
                        'cotizacion_id' => $cotizacion_id,
                        'cotizacion_correlativo' => $row_colum->cotizacion_correlativo,
                        'pago_id' => $pago_id
                    );
            echo json_encode($data);
        }
        
    }

    public function updateCotizacion()
    {
        $path = '../files/cotizacion/adjuntos/';
        //$path = 'files/cotizacion/adjuntos/';
        $file_name = '';
        //$file_ext = '';
        $arrClientes = [];
        $arrSolicitantes = [];

        if (isset($_FILES['file'])) {
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            //$file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $file = $path.$file_name;

            move_uploaded_file($file_tmp, $file);
        }

        $field = array (
            'cantidad_informe' => $this->input->post('cotizacion_cantidad'),
            'actualizacion' => $this->input->post('cotizacion_actualizacion'),
            'tipo_cotizacion_id' => $this->input->post('tipo_cotizacion_id'),
            'servicio_tipo_id' => '0',
            'orden_servicio' => $this->input->post('orden_servicio'),
            'estado_id' => $this->input->post('estado_id'),
            'adjunto' => $file_name,
            'fecha_solicitud' => $this->input->post('cotizacion_fecha_solicitud'),
            'fecha_envio_cliente' => $this->input->post('cotizacion_fecha_envio_cliente'),
            'fecha_finalizacion' => $this->input->post('cotizacion_fecha_finalizacion'),
            'plazo' => $this->input->post('plazo'),
            'vendedor_id' => $this->input->post('vendedor_id'),
            'desglose_id' => $this->input->post('desglose_id'),
            'tipo_perito' => $this->input->post('tipo_perito'),
            'perito_id' => $this->input->post('perito_id'),
            'perito_costo' => $this->input->post('perito_costo'),
            'viatico_importe' => $this->input->post('viatico_importe'),
            'datos_adicionales' => $this->input->post('datos_adicionales'),
            'info_status' => '1',
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('cotizacion_fecha_update')
        );

        $resultUpdate = $this->cot->Update($field,$this->input->post('cotizacion_id'));
		
		$tipo_servicio = explode(',',$this->input->post('servicio_tipo_id'));
        $tipo_servicio_old = explode(',',$this->input->post('servicio_tipo_id_old'));

        $tipo_servicio_insert = array_values(array_diff($tipo_servicio, $tipo_servicio_old));
        $tipo_servicio_delete = array_values(array_diff($tipo_servicio_old, $tipo_servicio));

        if (sizeof($tipo_servicio_insert) > 0) {
            for ($i = 0; $i < sizeof($tipo_servicio_insert); $i++) { 
                $field_detalle = array(
                    'cotizacion_id' => $this->input->post('cotizacion_id'),
                    'servicio_tipo_id' => $tipo_servicio_insert[$i]
                );

                $this->cot->insertCotizacionDetalle($field_detalle);
            }
        }

        if (sizeof($tipo_servicio_delete) > 0) {
            for ($i = 0; $i < sizeof($tipo_servicio_delete); $i++) {
                $field_detalle = array(
                    'cotizacion_id' => $this->input->post('cotizacion_id'),
                    'servicio_tipo_id' => $tipo_servicio_delete[$i]
                );
                $this->cot->deleteCotizacionDetalle($field_detalle);
            }
        }

        $objInvolucrado = json_decode($this->input->post('involucrados'));
        $objInvolucradoInt = json_decode($this->input->post('involucradosInt'));
        $objInvolucradoOld = json_decode($this->input->post('involucradosOld'));

        $objServicio = json_decode($this->input->post('servicios'));
        $objServicioOld = json_decode($this->input->post('serviciosOld'));
        $servicioUpdate = json_decode($this->input->post('servicioUpdate'));

        $resultInvolucrado = 0;
        $resultServicio = 0;
        $i = 0; $s = 0;

        if (count((array) $objInvolucrado) > 0) {
            foreach ($objInvolucrado as $row) {
                $fild_involucrado = array (
                    'id' => '0',
                    'cotizacion_id' => $this->input->post('cotizacion_id'),
                    'persona_id' => '0',
                    'persona_id_new' => $row->involucrado_id,
                    'persona_tipo' => $row->involucrado_tipo_nombre,
                    'rol_id' => $row->rol_id,
                    'contacto_id' => $row->contacto_id,
                    'info_status' => '1',
                    'info_create_user' => $this->session->userdata('usu_id')
                );
                $resultInvolucrado +=  $this->inv->insertCotizacionInvolucrado($fild_involucrado);

                if ($row->rol_id === 1){
                    $arrClientes[$i] = $row->involucrado_id.'-'.$row->involucrado_tipo_nombre;
                    $i++;
                }

                if ($row->rol_id === 2){
                    $arrSolicitantes[$s] = $row->involucrado_id.'-'.$row->involucrado_tipo_nombre.'-'.$row->contacto_id;
                    $s++;
                }
            }
        }

        if (count((array) $objInvolucradoOld) > 0) {
            foreach ($objInvolucradoOld as $row) {
                $resultInvolucrado += $this->inv->deleteCotizacionInvolucrado($row->id);
            }
        }

        if (count((array) $objServicio) > 0) {
            foreach ($objServicio as $row) {
                $fild_servicio = array (
                    'id' => '0',
                    'servicio_sub_id' => $row->servicio_id,
                    'descripcion' => '',
                    'cantidad' => $row->servicio_cantidad,
                    'subtotal' => $row->servicio_costo,
                    'cotizacion_id' => $this->input->post('cotizacion_id'),
                    'info_status' => '1',
                    'info_create_user' => $this->session->userdata('usu_id')
                );
                $resultServicio += $this->ser->insertCotizacionServicio($fild_servicio);
            }
        }

        if (count((array) $servicioUpdate) > 0) {
            foreach ($servicioUpdate as $row) {
                $field_servicio = array (
                    'cantidad' => $row->servicio_cantidad,
                    'subtotal' => $row->servicio_costo,
                    'info_update_user' => $this->session->userdata('usu_id')
                );

                $field_condicion = array(
                    'id' => $row->id
                );

                $resultServicio += $this->ser->updateCotizacionServicio($field_servicio,$field_condicion);
            }
        }

        if (count((array) $objServicioOld) > 0) {
            foreach ($objServicioOld as $row) {
                $resultServicio += $this->ser->deleteCotizacionServicio($row->id);
            }
        }

        if (count((array) $objInvolucradoInt) > 0) {
            foreach ($objInvolucradoInt as $row) {
                if ($row->rol_id === '1'){
                    $arrClientes[$i] = $row->involucrado_id.'-'.$row->involucrado_tipo_nombre;
                    $i++;
                }

                if ($row->rol_id === '2'){
                    $arrSolicitantes[$s] = $row->involucrado_id.'-'.$row->involucrado_tipo_nombre.'-'.$row->contacto_id;
                    $s++;
                }
            }
        }

        $field_pago = array(
            'total_igv' => $this->input->post('igv') == 'con' ? '0' : '0.18',
            'total_igv_de' => $this->input->post('igv'),
            'total_monto' => $this->input->post('pago_subtotal'),
            'total_monto_igv' => $this->input->post('pago_total'),
            'total_cambio' => $this->input->post('pago_tipo_cambio'),
            'total_moneda_id' => $this->input->post('moneda_id'),
            'fecha' => $this->input->post('pago_fecha'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('cotizacion_fecha_update')
        );

        $resultPago = $this->pag->Update($field_pago, $this->input->post('pago_id'));

        /*BEGIN COORDINACIÓN*/
        $solicitante_id = 0;
        $solicitante_tipo = '';
        $solicitante_contacto_id = 0;
        $cliente_id = 0;
        $cliente_tipo = '';

        if (count($arrClientes) === 1) {
            $part = explode('-', $arrClientes[0]);
            $cliente_id = $part[0];
            $cliente_tipo = $part[1];
        }

        if (count($arrSolicitantes) === 1) {
            $part = explode('-', $arrSolicitantes[0]);
            $solicitante_id = $part[0];
            $solicitante_tipo = $part[1];
            $solicitante_contacto_id = $part[2];
        }

        $data_coordinacion = array(
            'cotizacion_id' => $this->input->post('cotizacion_id'), 
            'coordinador_id' => $this->session->userdata('usu_id'),
            'solicitante_id' => '0',
            'solicitante_id_new' => $solicitante_id,
            'solicitante_tipo' => $solicitante_tipo,
            'solicitante_contacto_id' => $solicitante_contacto_id,
            'cliente_id' => '0',
            'cliente_id_new' => $cliente_id,
            'cliente_tipo' => $cliente_tipo,
            'tipo_id' => $this->input->post('servicio_tipo_id'),
            'tipo2_id' => 1,
            'solicitante_fecha' => $this->input->post('cotizacion_fecha_solicitud'),
            'entrega_al_cliente_fecha' => $this->input->post('cotizacion_fecha_envio_cliente'),
            'cantidad_informe' => $this->input->post('cotizacion_cantidad'),
            'estado_id' => $this->input->post('estado_id')
        );

        $this->insertCoordinacion($data_coordinacion);
        /*END COORDINACIÓN*/
        
        $data = array(
                    'success' => $resultUpdate > 0 ? true : $resultInvolucrado > 0 ? true : $resultServicio > 0 ? true : $resultPago > 0 ? true : false
                );

        echo json_encode($data);
    }
    
    public function insertCoordinacion($data)
    {
        if ($data['estado_id'] === '3' && json_encode($this->coord->searchCoordinacion(array('accion' => 'cotizacion', 'cotizacion_id' => $data['cotizacion_id']))) === 'false'){
            $row = $this->coord->obtenerCorrelativo();
            for ($i = 1; $i <= (int) $data['cantidad_informe']; $i++) {
                $field_coordinacion = array(
                    'id' => '0',
                    'codigo' => '0',
                    'estado_id' => '6',
                    'modalidad_id' => '0',
                    'tipo_id' => '0',
                    'tipo2_id' => $data['tipo_id'],
                    'coordinador_id' => $data['coordinador_id'],
                    'cotizacion_id' => $data['cotizacion_id'],
                    'cotizacion_correlativo' => intval($row->correlativo) + $i,
                    'solicitante_persona_tipo' => $data['solicitante_tipo'],
                    'solicitante_persona_id' => '0',
                    'solicitante_persona_id_new' => $data['solicitante_id_new'],
                    'solicitante_contacto_id' => $data['solicitante_contacto_id'],
                    'solicitante_fecha' => $data['solicitante_fecha'],
                    //'entrega_al_cliente_fecha' => $data['entrega_al_cliente_fecha'],
                    'cliente_persona_tipo' => $data['cliente_tipo'],
                    'cliente_persona_id' => '0',
                    'cliente_persona_id_new' => $data['cliente_id_new'],
                    'sucursal' => '',
                    'observacion' => '',
                    'tipo_cambio_id' => '0',
                    'impreso' => '0',
                    'estado_facturacion' => '0',
                    'info_status' => '1',
                    'info_create_user' => $this->session->userdata('usu_id')
                );

                $coordinacion_id = $this->coord->Insert($field_coordinacion);

                if ($coordinacion_id > 0) {
                    $field_inspeccion = array(
                        'info_status' => '1',
                        'coordinacion_id' => $coordinacion_id,
                        'perito_id' => '0',
                        'inspector_id' => '0',
                        'estado_id' => '1',
                        'departamento_id' => '15',
                        'provincia_id' => '1',
                        'distrito_id' => '1',
                        'ubigeo_distrito_id' => '1253',
                        'hora_real_mostrar' => 1,
                        'direccion' => '',
                        'observacion' => ''
                    );

                    $field_inspeccion_detalle = array(
                        'perito_id' => '0',
                        'contactos' => '',
                        'fecha' =>  '0000-00-00',
                        'hora' => '00:00',
                        'hora_tipo' => '1',
                        'distrito_id' => '1253',
                        'direccion' => '',
                        'observacion' => '',
                        'estado_id' => '1',
                        'info_create_user' => $this->session->userdata('usu_id'),
                        'info_status' => '1'
                    );

                    $this->ins->Insert($field_inspeccion);

                    $this->ins->insertDetalle($field_inspeccion_detalle, $coordinacion_id);

                    $field_auditoria = array(
                        //'id' => '0',
                        'aut_usu_id' => $this->session->userdata('usu_id'),
                        'aut_coor_id' => $coordinacion_id ,
                        'aut_coor_est' => 6
                    );

                    $this->aud->insertCoordinacion($field_auditoria);
                }
            }
        } else if ($data['estado_id'] === '3' && json_encode($this->coord->searchCoordinacion(array('accion' => 'cotizacion', 'cotizacion_id' => $data['cotizacion_id']))) !== 'false'){
            $field_coordinacion = array(
                'solicitante_persona_tipo' => $data['solicitante_tipo'],
                'solicitante_persona_id_new' => $data['solicitante_id_new'],
                'solicitante_contacto_id' => $data['solicitante_contacto_id'],
                'cliente_persona_tipo' => $data['cliente_tipo'],
                'cliente_persona_id_new' => $data['cliente_id_new']
            );

            $this->coord->updateCoordinacionxCotizacion($field_coordinacion, $data['cotizacion_id']);
        }
    }

    public function impresion()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters =   array(
                'cotizacion_codigo' => $datos->cotizacion_codigo,
                'servicio_tipo_id' => $datos->servicio_tipo_id,
                'coordinador_id' => $datos->coordinador_id,
                'vendedor_id' => $datos->vendedor_id,
                'cliente_nombre' => $datos->cliente_nombre,
                'solicitante_nombre' => $datos->solicitante_nombre,
                'cotizacion_moneda_monto' => $datos->cotizacion_moneda_monto,
                'tipo_fecha' => $datos->tipo_fecha,
                'cotizacion_fecha_desde' => $datos->cotizacion_fecha_desde,
                'cotizacion_fecha_hasta' => $datos->cotizacion_fecha_hasta,
                'estado_id' => $datos->estado_id
            );

            $impresion = $this->cot->searchCotizacion($filters);
            $table_boddy = "";

            if ($impresion == false) {
                $table_boddy .= '<tr><td colspan="12">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($impresion as $row) {
                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_codigo.'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->sercivio_tipo_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->coordinador_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->vendedor_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre)).'</td>
                                        <td style="font-size: 0.5rem">'.str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre)).'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_monto.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_fecha_solicitud.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_fecha_envio_cliente.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_fecha_finalizacion.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_fecha_desestimacion.'</td>
                                        <td style="font-size: 0.5rem">'.$row->estado_nombre.'</td>
                                    </tr>';
                    $i++;
                }
            }

            $data['cotizacion'] = $table_boddy;
            $data['view'] = 'cotizacion/cotizacion_print';
            $this->load->view('layout_impresion', $data);
        }
    }

    /*public function reportCotizacionExcel()
    {
        $objeto = json_decode($this->input->post('data'));

        //print_r($objeto);
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $objeto = json_decode($this->input->post('data'));
            
            $filters = array(
                                'cotizacion_codigo' => $objeto->cotizacion_codigo,
                                'servicio_tipo_id' => $objeto->servicio_tipo_id,
                                'coordinador_id' => $objeto->coordinador_id,
                                'vendedor_id' => $objeto->vendedor_id,
                                'cliente_nombre' => $objeto->cliente_nombre,
                                'solicitante_nombre' => $objeto->solicitante_nombre,
                                'cotizacion_moneda_monto' => $objeto->cotizacion_moneda_monto,
                                'tipo_fecha' => $objeto->tipo_fecha,
                                'cotizacion_fecha_desde' => $objeto->cotizacion_fecha_desde,
                                'cotizacion_fecha_hasta' => $objeto->cotizacion_fecha_hasta,
                                'estado_id' => $objeto->estado_id
                            );

            $cotizacion = $this->cot->searchCotizacion($filters);

            $objPHPExcel = new PHPExcel();

            //Ponemos Nombre a la Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Reporte Cotización');

            //Definimos Propiedades
            $objPHPExcel->getProperties()->setTitle('Reporte de Cotización')
                                        ->setCreator('Allemant & Asociados Peritos Valuadores')
                                        ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

            //Combinación de celdas
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:P2');

            //Añadimos titlo del reporte
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'REPORTE DE COTIZACIÓN');

            //Estilo para el titulo del reporte
            $style_title    =   array(
                'font' => array(
                    'name'      => 'Verdana',
                    'bold'      => true,
                    'italic'    => false,
                    'strike'    => false,
                    'size'      => 14,
                    'color'     => array(
                        'rgb' => '000000'
                    )
                ),
                'alignment' =>  array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'rotation'   => 0
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('B2:P2')->applyFromArray($style_title);
            
            //Configuramos el tamaño de los encabezados de las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(130.7);

            //Añadimos los titulos a los encabezados de columnas
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A6', '#');
            $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'CÓDIGO COTIZACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'TIPO SERVICIO');
            $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'COORDINADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'VENDEDOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'CLIENTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'MONTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'FECHA DE SOLICITUD');
            $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'FECHA DE ENVÍO');
            $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'FECHA DE APROBACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'FECHA DE DESESTIMACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('M6', 'ESTADO');

            $objPHPExcel->getActiveSheet()->SetCellValue('N6', 'FECHA SEGUIMIENTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('O6', 'CONTACTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('P6', 'SEGUIMIENTO');

            //Estilo para los encabezados de columnas
            $style_columns_headers   =   array(
                'font'  =>  array(
                    'name'  =>  'Calibri',
                    'bold'  =>  true,
                    'size'  =>  11,
                    'color' =>  array(
                        'rgb'   =>  'FFFFFF'
                    )
                ),
                'fill'  =>  array(
                    'type'  =>  PHPExcel_Style_Fill::FILL_SOLID,
                    'color' =>  array(
                        'rgb'   =>  '00B5B8'
                    )
                ),
                'borders'   =>  array(
                    'top'   =>  array(
                        'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                        'color' =>  array(
                            'rgb'   =>  '000000'
                        )
                    ),
                    'bottom'    =>  array(
                        'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                        'color' =>  array(
                            'rgb'   =>  '000000'
                        )
                    )
                ),
                'alignment' =>  array(
                    'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray($style_columns_headers);

            //Obtener los datos
            $rowCount = 7;
            foreach ($cotizacion as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 6);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "$row->cotizacion_codigo");
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, strtoupper($row->sercivio_tipo_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper($row->coordinador_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper($row->vendedor_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre)));
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre)));
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->cotizacion_monto);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->cotizacion_fecha_solicitud);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->cotizacion_fecha_envio_cliente);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->cotizacion_fecha_finalizacion);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->cotizacion_fecha_desestimacion);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->estado_nombre);

                //BEGIN SEGUIMIENTO
                $field_seguimiento = array('accion' => 'cotizacion', 'cotizacion_id' => $row->cotizacion_id);
                $seguimiento = $this->seg->searchSeguimiento($field_seguimiento);

                $fecha = "";
                $contacto = "";
                $mensaje = "";

                $i = 0;
                if($seguimiento != false) {
                    foreach ($seguimiento as $row_seguimiento) {
                        if ($i == count($seguimiento)-1) {
                            $fecha .= $row_seguimiento->seguimiento_fecha_creacion;
                            $contacto .= $row->contacto_nombre;
                            $mensaje .= "- ".$row_seguimiento->seguimiento_mensaje;
                        } else {
                            $fecha .= $row_seguimiento->seguimiento_fecha_creacion."|";
                            $contacto .= $row->contacto_nombre."|";
                            $mensaje .= "- ".$row_seguimiento->seguimiento_mensaje."|";
                        }
                        $i++;
                    }
                }

                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, str_replace('|',"\n",$fecha));
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, str_replace('|',"\n",$contacto));
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, str_replace('|',"\n",$mensaje));
                //END SEGUIMIENTO
                
                $style_rows =   array(
                    'borders'   =>  array(
                        'allborders'   =>  array(
                            'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                            'color' =>  array(
                                'rgb'   =>  '000000'
                            )
                        )
                    ),
                    'alignment' =>  array(
                        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                );

                $style_rows_adjust_text = array(
                    'alignment' =>  array(
                        'wrap'      => TRUE
                    )
                );

                $style_rows_horizontal_center = array(
                    'alignment' =>  array(
                        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($style_rows_horizontal_center);

                if ($row->moneda_id == 1)
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_SOLES_SIMPLE);
                else if ($row->moneda_id == 2)
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                else
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

                $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount.':M' . $rowCount)->applyFromArray($style_rows_horizontal_center);

                $rowCount++;
            }

            $fileName = 'Reporte de Cotizacion-' . date('dmY-his') . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }*/
    
    public function reportCotizacionExcel()
    {
        $objeto = json_decode($this->input->post('data'));

        //print_r($objeto);
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $objeto = json_decode($this->input->post('data'));
            
            $filters = array(
                                'cotizacion_codigo' => $objeto->cotizacion_codigo,
                                'servicio_tipo_id' => $objeto->servicio_tipo_id,
                                'coordinador_id' => $objeto->coordinador_id,
                                'vendedor_id' => $objeto->vendedor_id,
                                'cliente_nombre' => $objeto->cliente_nombre,
                                'solicitante_nombre' => $objeto->solicitante_nombre,
                                'cotizacion_moneda_monto' => $objeto->cotizacion_moneda_monto,
                                'tipo_fecha' => $objeto->tipo_fecha,
                                'cotizacion_fecha_desde' => $objeto->cotizacion_fecha_desde,
                                'cotizacion_fecha_hasta' => $objeto->cotizacion_fecha_hasta,
                                'estado_id' => $objeto->estado_id
                            );

            $cotizacion = $this->cot->searchCotizacion($filters);

            $objPHPExcel = new PHPExcel();

            //Ponemos Nombre a la Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Reporte Cotización');

            //Definimos Propiedades
            $objPHPExcel->getProperties()->setTitle('Reporte de Cotización')
                                        ->setCreator('Allemant & Asociados Peritos Valuadores')
                                        ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

            //Combinación de celdas
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:P2');

            //Añadimos titlo del reporte
            $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'REPORTE DE COTIZACIÓN');

            //Estilo para el titulo del reporte
            $style_title    =   array(
                'font' => array(
                    'name'      => 'Verdana',
                    'bold'      => true,
                    'italic'    => false,
                    'strike'    => false,
                    'size'      => 14,
                    'color'     => array(
                        'rgb' => '000000'
                    )
                ),
                'alignment' =>  array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'rotation'   => 0
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($style_title);
            
            //Configuramos el tamaño de los encabezados de las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(32.7);

            /*$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20.7);*/

            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12.7);

            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(130.7);

            //Añadimos los titulos a los encabezados de columnas
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A6', '#');
            $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'CÓDIGO COTIZACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'TIPO SERVICIO');
            $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'COORDINADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'VENDEDOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'CLIENTE');

			/*$objPHPExcel->getActiveSheet()->SetCellValue('H6', 'RUC');
			$objPHPExcel->getActiveSheet()->SetCellValue('I6', 'DIRECCIÓN');
			$objPHPExcel->getActiveSheet()->SetCellValue('J6', 'CONTACTO CLIENTE');
			$objPHPExcel->getActiveSheet()->SetCellValue('K6', 'CONTACTO TELÉFONO');
            $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'CONTACTO CORREO');*/

            $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'MONTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'FECHA DE SOLICITUD');
            $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'FECHA DE ENVÍO');
            $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'FECHA DE APROBACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'FECHA DE DESESTIMACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('M6', 'ESTADO');

            $objPHPExcel->getActiveSheet()->SetCellValue('N6', 'FECHA SEGUIMIENTO');
            $objPHPExcel->getActiveSheet()->SetCellValue('O6', 'CONTACTO SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('P6', 'SEGUIMIENTO');

            //Estilo para los encabezados de columnas
            $style_columns_headers   =   array(
                'font'  =>  array(
                    'name'  =>  'Calibri',
                    'bold'  =>  true,
                    'size'  =>  11,
                    'color' =>  array(
                        'rgb'   =>  'FFFFFF'
                    )
                ),
                'fill'  =>  array(
                    'type'  =>  PHPExcel_Style_Fill::FILL_SOLID,
                    'color' =>  array(
                        'rgb'   =>  '00B5B8'
                    )
                ),
                'borders'   =>  array(
                    'top'   =>  array(
                        'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                        'color' =>  array(
                            'rgb'   =>  '000000'
                        )
                    ),
                    'bottom'    =>  array(
                        'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                        'color' =>  array(
                            'rgb'   =>  '000000'
                        )
                    )
                ),
                'alignment' =>  array(
                    'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray($style_columns_headers);

            //Obtener los datos
            $rowCount = 7;
            foreach ($cotizacion as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 6);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "$row->cotizacion_codigo");
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, strtoupper($row->sercivio_tipo_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper($row->coordinador_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper($row->vendedor_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre)));
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre)));
                
                /*$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->cliente_nro_documento);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->cliente_direccion);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->contacto_cliente_nombre);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->contacto_cliente_telefono);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->contacto_cliente_correo);*/

                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->cotizacion_monto);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->cotizacion_fecha_solicitud);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->cotizacion_fecha_envio_cliente);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->cotizacion_fecha_finalizacion);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->cotizacion_fecha_desestimacion);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->estado_nombre);

                /*BEGIN SEGUIMIENTO*/
                $field_seguimiento = array('accion' => 'cotizacion', 'cotizacion_id' => $row->cotizacion_id);
                $seguimiento = $this->seg->searchSeguimiento($field_seguimiento);

                $fecha = "";
                $contacto = "";
                $mensaje = "";

                $i = 0;
                if($seguimiento != false) {
                    foreach ($seguimiento as $row_seguimiento) {
                        if ($i == count($seguimiento)-1) {
                            $fecha .= $row_seguimiento->seguimiento_fecha_creacion;
                            $contacto .= $row->contacto_nombre;
                            $mensaje .= "- ".$row_seguimiento->seguimiento_mensaje;
                        } else {
                            $fecha .= $row_seguimiento->seguimiento_fecha_creacion."|";
                            $contacto .= $row->contacto_nombre."|";
                            $mensaje .= "- ".$row_seguimiento->seguimiento_mensaje."|";
                        }
                        $i++;
                    }
                }

                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, str_replace('|',"\n",$fecha));
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, str_replace('|',"\n",$contacto));
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, str_replace('|',"\n",$mensaje));
                /*END SEGUIMIENTO*/
                
                $style_rows =   array(
                    'borders'   =>  array(
                        'allborders'   =>  array(
                            'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                            'color' =>  array(
                                'rgb'   =>  '000000'
                            )
                        )
                    ),
                    'alignment' =>  array(
                        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                );

                $style_rows_adjust_text = array(
                    'alignment' =>  array(
                        'wrap'      => TRUE
                    )
                );

                $style_rows_horizontal_center = array(
                    'alignment' =>  array(
                        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($style_rows_horizontal_center);

                if ($row->moneda_id == 1)
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_SOLES_SIMPLE);
                else if ($row->moneda_id == 2)
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                else
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

                $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount.':M' . $rowCount)->applyFromArray($style_rows_horizontal_center);

                $rowCount++;
            }

            $fileName = 'Reporte de Cotizacion-' . date('dmY-his') . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }

    public function generarPropuestaCotizacionWord()
    {
        //echo base_url()."assets/images/logo.jpg";
        $resultCotizacion = $this->cot->searchCotizacionPropuesta(array('cotizacion_codigo' => $this->input->get('cotizacion_codigo'), 'rol_id' => 1, 'init' => 0, 'quantity' => 1));

        $cotizacion_id = $resultCotizacion->id;
        $cotizacion_codigo = $resultCotizacion->codigo;
        $cotizacion_tipo = $resultCotizacion->tipo;
        $cotizacion_empresa = $resultCotizacion->empresa;
        $cotizacion_involucrado = $resultCotizacion->involucrado;
        $cotizacion_cargo = $resultCotizacion->cargo;
        $cotizacion_servicio_id = $resultCotizacion->servicio_id;
        $cotizacion_servicio = $resultCotizacion->servicio;
        $cotizacion_datos_adicionales = $resultCotizacion->datos_adicionales;
        $cotizacion_plazo = $resultCotizacion->plazo;
        $cotizacion_igv = $resultCotizacion->igv_check;
        $cotizacion_simbolo = $resultCotizacion->simbolo;
        $cotizacion_moneda = $resultCotizacion->moneda;
        $cotizacion_monto = number_format($resultCotizacion->monto, 2);
        $cotizacion_desglose = $resultCotizacion->desglose_id;
		$cotizacion_desglose_nombre = $resultCotizacion->desglose;
        $cotizacion_email = $resultCotizacion->email;

        $cot_impuesto = $resultCotizacion->impuesto;
        $cot_subtotal = $resultCotizacion->subtotal;
        $cot_igv = $resultCotizacion->igv;
        $cot_total = $resultCotizacion->total;

        $cotizacion_fecha = $resultCotizacion->fecha;
        $arrFecha = explode('-', $cotizacion_fecha);
        $dia = $arrFecha[0];
        $mes_letras = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes_letras[intval($arrFecha[1])-1];
        $año = $arrFecha[2];

        $resultRequisitos = $this->req->searchRequisito(array('servicio_tipo_id' => $cotizacion_servicio_id));
        $resultServicios = $this->ser->searchCotizacionServicios($cotizacion_id);

        //OTROS
        $correlativo = intval(substr($cotizacion_codigo, 4,strlen($cotizacion_codigo))).'-'.substr($cotizacion_codigo, 0, 4);

        $PHPWord = new PHPWord();

        if ($cotizacion_tipo == 1) {

            //Estilos
            $PHPWord->setDefaultFontName('Calibri');
            $PHPWord->setDefaultFontSize(10);
            $ParagraphStyle = array(
                'align' => 'both',
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'spacing' => 0
            );

            $ParagraphCellStyle = array(
                'align' => 'center',
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'spacing' => 0
            );

            //Estilo General
            $section = $PHPWord->createSection();
            $sectionStyle = $section->getSettings();
            $sectionStyle->setPortrait();
            $sectionStyle->setMarginLeft(1000);
            $sectionStyle->setMarginRight(1000);
            $sectionStyle->setMarginTop(300);
            $sectionStyle->setMarginBottom(0);
            $imageStyle = array(
                'positioning' => 'relative',
                'width' => 100,
                'height' => 100,
                'align' => 'left'
            );

            //Estilo Especifico
            $boldStyle = array(
                'bold' => true
            );

            $footerStyle = array(
                'name' => 'Times New Roman',
                'size' => 9
            );

            $footerParagraphStyle = array(
                'align' => 'center',
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'spacing' => 0
            );

            //Estilo de Tabla
            $styleTable = array(
                'borderSize' => 6,
                'borderColor' => '006699',
                'cellMargin' => 80
            );

            //Estilo de celdas de tabla
            $styleCell = array(
                'valign' => 'center',
                'borderTopSize' => 1,
                'borderRightSize' => 1,
                'borderLeftSize' => 1,
                'borderBottomSize' => 1,
                'borderTopColor' => '000000',
                'borderLeftColor' => '000000',
                'borderRightColor' => '000000',
                'borderBottomColor' => '000000'
            );

            $styleCellSpan = array(
                'valign' => 'center',
                'borderTopSize' => 1,
                'borderRightSize' => 1,
                'borderLeftSize' => 1,
                'borderBottomSize' => 1,
                'borderTopColor' => '000000',
                'borderLeftColor' => '000000',
                'borderRightColor' => '000000',
                'borderBottomColor' => '000000',
                'gridSpan' => 2
            );

            // Define font style for first row
            $fontStyle = array(
                'bold' => true,
                'align' => 'center'
            );
            // Add table style
            $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleCell);

            //Creando Word
            $section->addImage('assets/images/logo.jpg', $imageStyle);
            $section->addText(utf8_decode('Cotización Nº '.$correlativo.'/AC-AAPV'));
            $section->addText('Lima, '.$dia.' de '.$mes.' del '.$año);

            $section->addText(utf8_decode('Señores:'), null, $ParagraphStyle);
            $section->addText(utf8_decode($cotizacion_empresa), $boldStyle, $ParagraphStyle);
            $section->addText(utf8_decode('Presente.-'), array('underline' => PHPWord_Style_Font::UNDERLINE_SINGLE), $ParagraphStyle);

            $table = $section->addTable();
            $table->addRow(100);
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText(utf8_decode('Atención'));
            $table->addCell(6000)->addText(': ' . utf8_decode($cotizacion_involucrado));
            $table->addRow(50);
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText('');
            $table->addCell(6000)->addText('  ' . utf8_decode($cotizacion_cargo));
            $table->addRow(100);
            $table->addCell(2000)->addText('');
            $table->addCell(2000)->addText('Asunto');
            $table->addCell(6000)->addText(': ' . utf8_decode($cotizacion_servicio));

            $section->addText(utf8_decode('De nuestra consideración:'));
            $section->addText(utf8_decode('Por intermedio de la presente nos dirigimos a Usted, con la finalidad de hacer entrega de nuestra cotización, para el servicio solicitado vía email:'));

            //Encabezado de tabla
            $table = $section->addTable('myOwnTableStyle');
            $table->addRow(100);
            $table->addCell(4000, $styleCell)->addText(utf8_decode('DESCRIPCIÓN'), $fontStyle, $ParagraphCellStyle);
            $table->addCell(1000, $styleCell)->addText(utf8_decode('CANTIDAD'), $fontStyle, $ParagraphCellStyle);
            //$table->addCell(2000, $styleCell)->addText(utf8_decode('COSTO UNITARIO'), $fontStyle, $ParagraphCellStyle);
            $table->addCell(2500, $styleCell)->addText(utf8_decode('IMPORTE'), $fontStyle, $ParagraphCellStyle);
            
            //Cuerpo de tabla
            $total_costo = 0;
            $order   = array("\r\n", "\n\r", "\n", "\r");
            $replace = "|";
            $datos_adicionales = str_replace($order, $replace, $cotizacion_datos_adicionales);
            $datos = explode("|", $datos_adicionales);

            foreach ($resultServicios as $row) {
                $table->addRow(100);
                $celda = $table->addCell(4000, $styleCell);
                $celda->addText($row->servicio_id == 0 ? utf8_decode($row->servicio_descripcion) : utf8_decode($row->servicio_nombre), null, $ParagraphCellStyle);
                
                for ($i=0; $i < sizeof($datos); $i++) { 
                    $celda->addText(utf8_decode($datos[$i]), null, $ParagraphCellStyle);    
                }
                
                $table->addCell(1000, $styleCell)->addText($row->servicio_cantidad, null, $ParagraphCellStyle);
                //$table->addCell(2000, $styleCell)->addText($row->moneda_simbolo.' '.$row->servicio_costo, null, $ParagraphCellStyle);
                //$table->addCell(2500, $styleCell)->addText($row->moneda_simbolo.' '.number_format(($row->servicio_cantidad * $row->servicio_costo), 2), null, $ParagraphCellStyle);
                $table->addCell(2500, $styleCell)->addText($row->moneda_simbolo.' '.number_format($row->servicio_costo, 2), null, $ParagraphCellStyle);
                //$total_costo = $total_costo + ($row->servicio_cantidad * $row->servicio_costo);
                $total_costo = $total_costo + $row->servicio_costo; 
            }

            //Pie de tabla
            $table->addRow(100);

            $table->addCell(null, $styleCellSpan)->addText(utf8_decode('COSTO DEL SERVICIO '), $fontStyle, $ParagraphCellStyle);
            //$table->addCell(2500, $styleCell)->addText($cotizacion_simbolo.' '.number_format($total_costo, 2), $fontStyle, $ParagraphCellStyle);
            $table->addCell(2500, $styleCell)->addText($cotizacion_simbolo.' '.number_format($cot_subtotal, 2), $fontStyle, $ParagraphCellStyle);

            $table->addRow(100);

            $table->addCell(null, $styleCellSpan)->addText(utf8_decode('IMPUESTO '.$cot_impuesto.' %'), $fontStyle, $ParagraphCellStyle);
            $table->addCell(2500, $styleCell)->addText($cotizacion_simbolo.' '.number_format($cot_igv, 2), $fontStyle, $ParagraphCellStyle);

       
	        //$table->addRow(100);
	        // RICHARD
            //$table->addCell(null, $styleCellSpan)->addText($cotizacion_igv == 'con' ? utf8_decode('TOTAL EN '.strtoupper($cotizacion_moneda).' (INCLUYE IGV)') : utf8_decode('TOTAL EN '.strtoupper($cotizacion_moneda).' (NO INCLUYE IGV)'), $fontStyle, $ParagraphCellStyle);
            //$table->addCell(2500, $styleCell)->addText($cotizacion_simbolo.' '.number_format($total_costo, 2), $fontStyle, $ParagraphCellStyle);

            $table->addRow(100);

            $table->addCell(null, $styleCellSpan)->addText(utf8_decode('PRECIO EN '.strtoupper($cotizacion_moneda).' (TOTAL CON IMPUESTO)'), $fontStyle, $ParagraphCellStyle);
            $table->addCell(2500, $styleCell)->addText($cotizacion_simbolo.' '.number_format($cot_total, 2), $fontStyle, $ParagraphCellStyle);

            $section->addTextBreak(1);
            $section->addText(utf8_decode('La presente cotización tiene una vigencia de 15 días, contadas a partir de la fecha de emisión.'), $boldStyle, $ParagraphStyle);
            if ($cotizacion_plazo == 0) {
            	$section->addText(utf8_decode('Plazo del servicio: 6 días hábiles, contados a partir del día siguiente de realizada la inspección y entregada la documentación completa.'), null, $ParagraphStyle);
            }else{
            	$section->addText(utf8_decode('Plazo del servicio: '.$cotizacion_plazo.' días hábiles, contados a partir del día siguiente de realizada la inspección y entregada la documentación completa.'), null, $ParagraphStyle);
            }
            $section->addTextBreak(1);
            $section->addText(utf8_decode('Asimismo, para la valorización se necesitará lo siguiente:'), $boldStyle, $ParagraphStyle);

            //Requisitos
            foreach ($resultRequisitos as $row) {
                $section->addText('- '.utf8_decode($row->nombre), null, $ParagraphStyle);
            }

            $section->addTextBreak(1);
            $section->addText('Forma de pago: ', $boldStyle, $ParagraphStyle);
			
			switch ($cotizacion_desglose) {
				case '1':
                    $section->addText(utf8_decode('- Pago del 100% a la aceptación de la propuesta.'), null, $ParagraphStyle);
                    //$section->addText(utf8_decode('- La contraprestación será pagada al final de la prestación del servicio, previa conformidad.'), null, $ParagraphStyle);
					break;
				case '2':
					$section->addText(utf8_decode('- 50% de adelanto a la aprobación de la cotización.'), null, $ParagraphStyle);
					$section->addText(utf8_decode('- 50% a la entrega del informe virtual.'), null, $ParagraphStyle);
					break;
				case '3':
					$section->addText(utf8_decode('- 50% de adelanto a la aprobación de la cotización.'), null, $ParagraphStyle);
					$section->addText(utf8_decode('- 30% a la entrega del Primer Borrador.'), null, $ParagraphStyle);
					$section->addText(utf8_decode('- 20% a la entrega del Informe Final.'), null, $ParagraphStyle);
					break;
				case '4':
					$section->addText(utf8_decode('- 40% de adelanto a la aprobación de la cotización.'), null, $ParagraphStyle);
					$section->addText(utf8_decode('- 30% a la entrega del Primer Borrador.'), null, $ParagraphStyle);
					$section->addText(utf8_decode('- 30% a la entrega del Informe Final.'), null, $ParagraphStyle);
					break;
				case '5':
				case '6':
					$section->addText(utf8_decode('- Pago a ' . $cotizacion_desglose_nombre), null, $ParagraphStyle);
					break;
				default:
					$section->addText(utf8_decode('- La contraprestación será pagada al final de la prestación del servicio, previa conformidad.'), null, $ParagraphStyle);
					break;
			}
            //$section->addTextBreak(1);
            $section->addText(utf8_decode('Vía transferencia a nuestras cuentas siguientes:'), $boldStyle, $ParagraphStyle);

            switch ($cotizacion_moneda) {
                case 'Soles':
                    $section->addText(utf8_decode('- Cuenta Corriente Soles del BCP Nº 194-1907303-0-86'), null, $ParagraphStyle);
                    $section->addText(utf8_decode('- Cuenta Interbancaria Soles del BCP Nº 002-194-001907303086-98'), null, $ParagraphStyle);
                    break;
                case 'Dolares americanos':
                    $section->addText(utf8_decode('- Cuenta Corriente Dólares del BCP Nº 194-1900582-1-07'), null, $ParagraphStyle);
                    $section->addText(utf8_decode('- Cuenta Interbancaria Dólares del BCP Nº 002-194-001900582107-99'), null, $ParagraphStyle);
                    break;
            }

            $section->addTextBreak(1);
            $section->addText(utf8_decode('El informe final será entregado en Original (01), incluye la presentación del álbum fotográfico.'), null, $ParagraphStyle);
            $section->addText(utf8_decode('Agradeceremos remitir la conformidad a la presente, al correo electrónico peritos@allemantperitos.com e indicar el Nº de RUC para tenerlo presente al facturar el servicio.'), null, $ParagraphStyle);
            $section->addTextBreak(1);
            $section->addText(utf8_decode('Sin otro particular, quedo de Usted.'), null, $ParagraphStyle);
            $section->addText(utf8_decode('Atentamente,'), null, $ParagraphStyle);
            $section->addTextBreak(1);
            /*$section->addText(utf8_decode('Pedro Carreño Bardales'), $boldStyle, $ParagraphStyle);
            $section->addText(utf8_decode('Gerente General'), $boldStyle, $ParagraphStyle);*/
            $section->addText('Allemant Asociados Peritos Valuadores S.A.C.', $boldStyle, $ParagraphStyle);
            $section->addText(utf8_decode('Área Comercial'), $boldStyle, $ParagraphStyle);

            //Pie de pagina
            $footer = $section->createFooter();
            $footer->addText(utf8_decode('Av. Manuel Olguín Nº 373 Piso 6, Oficina 604 - Santiago de Surco'), $footerStyle, $footerParagraphStyle);
            $footer->addText(utf8_decode('Teléfono: (01) 396-4627, Email: peritos@allemantperitos.com'), $footerStyle, $footerParagraphStyle);

            $fileName = substr($cotizacion_codigo, 5,strlen($cotizacion_codigo)).' PROPUESTA ALLEMANT -' . $cotizacion_empresa . '.docx';
            $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
            header('Content-Type: application/vnd.ms-word');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        } 
        elseif ($cotizacion_tipo == 2) {
            $requerimientos_str = "";
            $requerimientos_str .= "</w:t></w:r></w:p>";
            foreach($resultRequisitos as $row) {
                $requerimientos_str .= "<w:p><w:r><w:t>- ". utf8_decode($row->nombre) . "</w:t></w:r></w:p>\n";
            }
            $requerimientos_str .= "<w:p><w:r><w:t>";


            $template = $PHPWord->loadTemplate('assets/template/Template.docx');
            $conversor = new Conversor();

            $template->setValue('CODIGO', $correlativo);
            $template->setValue('FECHA', 'Lima, '.$dia.' de '.$mes.' del '.$año);
            $template->setValue('CLIENTE', $cotizacion_empresa);
            $template->setValue('CONTACTO', $cotizacion_involucrado);
            $template->setValue('CARGO', $cotizacion_cargo);
            $template->setValue('SERVICIO', strtoupper($cotizacion_servicio));
            $template->setValue('ANIO', $año);
            $template->setValue('LETRAS', $conversor->convertir($cotizacion_monto, $cotizacion_simbolo, $cotizacion_moneda));
            //$template->setValue('DESGLOSE', $cotizacion_desglose);
            $template->setValue('REQUERIMIENTOS', $requerimientos_str);
            $fileName = substr($cotizacion_codigo, 5,strlen($cotizacion_codigo)).' PROPUESTA ALLEMANT -' . $cotizacion_empresa . '.docx';
            $template->save($fileName);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $fileName);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            flush();
            readfile($fileName);
            unlink($fileName);
            exit;
        }
    }

    public function propuestaWord()
    {
        phpinfo();
        /*$PHPWord = new PHPWord();
        $PHPWord->setDefaultFontName('Calibri');
        $PHPWord->setDefaultFontSize(10);

        //MARGENES DEL DOCUMENTO
        $section = $PHPWord->createSection();
        $sectionStyle = $section->getSettings();
        $sectionStyle->setPortrait();
        $sectionStyle->setMarginLeft(1000);
        $sectionStyle->setMarginRight(1000);
        $sectionStyle->setMarginTop(1000);
        $sectionStyle->setMarginBottom(0);

        //ESTILO DE IMAGEN
        $imageStyle = array(
            'width' => 100,
            'height' => 100,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line'
        );

        $section->addImage('assets/images/logo.jpg', $imageStyle);
        $section->addText('HOLAAA');

        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        header('Content-Type: application/vnd.ms-word');
        //header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Content-Disposition: attachment;filename="PRUEBA.docx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');*/
    }

    /*END COTIZACIÓN*/

    /*BEGIN TIPO DE SERVICIO*/
    public function searchTServicio()
    {
        $filters = array(
                            'servicio_tipo_nombre' => $this->input->post('servicio_tipo_nombre'),
                            'servicio_tipo_estado' => $this->input->post('servicio_tipo_estado')
                        );

        $filters_total_records =    array(
                                        'servicio_tipo_nombre' => '',
                                        'servicio_tipo_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'servicio_tipo_find' => $this->tps->searchTServicio($filters, $init, $quantity),
                        'servicio_tipo_all' => $this->tps->searchTServicio($filters_total_records),
                        'total_records_find' => $this->tps->searchTServicio($filters) == false ? false : count($this->tps->searchTServicio($filters)),
                        'total_records' => $this->tps->searchTServicio($filters_total_records) == false ? false : count($this->tps->searchTServicio($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertTServicio()
    {
        $field = array (
            'id' => $this->input->post('servicio_tipo_id'),
            'nombre' => $this->input->post('servicio_tipo_nombre'),
            'info_status' => $this->input->post('servicio_tipo_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->tps->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateTServicio()
    {
        $field = array (
            'nombre' => $this->input->post('servicio_tipo_nombre'),
            'info_status' => $this->input->post('servicio_tipo_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('servicio_tipo_fecha_update')
        );

        $update = $this->tps->Update($field, $this->input->post('servicio_tipo_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END TIPO DE SERVICIO*/

    /*BEGIN INVOLUCRADOS*/
    public function involucradoReporte($tipo)
    {
        if ($tipo == 'J')
            $result = $this->inv->involucradoJuridicaReporte();
        else
            $result = $this->inv->involucradoNaturalReporte();
        echo json_encode($result);
    }

    public function searchInvolucrado($tipo)
    {
        $filters = '';
        $filters_total_records = '';

        if ($tipo == 'J') {
            $filters = array(
                                'involucrado_nombre' => $this->input->post('involucrado_nombre'),
                                'involucrado_documento' => $this->input->post('involucrado_documento'),
                                /*'clasificacion_id' => $this->input->post('clasificacion_id'),
                                'actividad_id' => $this->input->post('actividad_id'),
                                'grupo_id' => $this->input->post('grupo_id'),*/
                                'involucrado_direccion' => $this->input->post('involucrado_direccion'),
                                'involucrado_telefono' => $this->input->post('involucrado_telefono'),
                                'involucrado_estado' => $this->input->post('involucrado_estado')
                            );

            $filters_total_records =    array(
                                            'involucrado_nombre' => '',
                                            'involucrado_documento' => '',
                                            /*'clasificacion_id' => '',
                                            'actividad_id' => '',
                                            'grupo_id' => '',*/
                                            'involucrado_direccion' => '',
                                            'involucrado_telefono' => '',
                                            'involucrado_estado' => ''
                                        );
        } else {
            $filters = array(
                                'involucrado_nombre' => $this->input->post('involucrado_nombre'),
                                'involucrado_documento' => $this->input->post('involucrado_documento'),
                                'involucrado_direccion' => $this->input->post('involucrado_direccion'),
                                'involucrado_correo' => $this->input->post('involucrado_correo'),
                                'involucrado_estado' => $this->input->post('involucrado_estado')
                            );

            $filters_total_records =    array(
                                            'involucrado_nombre' => '',
                                            'involucrado_documento' => '',
                                            'involucrado_direccion' => '',
                                            'involucrado_correo' => '',
                                            'involucrado_estado' => ''
                                        );
        }

        $result;
        $resultFind;
        if ($tipo == 'J') {
            $result = $this->inv->searchInvolucradoJuridico($filters_total_records) == false ? 0 : count($this->inv->searchInvolucradoJuridico($filters_total_records));
            $resultFind = $this->inv->searchInvolucradoJuridico($filters) == false ? 0 : count($this->inv->searchInvolucradoJuridico($filters));
        } else {
            $result = $this->inv->searchInvolucradoNatural($filters_total_records) == false ? 0 : count($this->inv->searchInvolucradoNatural($filters_total_records));
            $resultFind = $this->inv->searchInvolucradoNatural($filters) == false ? 0 : count($this->inv->searchInvolucradoNatural($filters));
        }
            

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'involucrado_find' => $tipo == 'J' ? $this->inv->searchInvolucradoJuridico($filters, $init, $quantity) : $this->inv->searchInvolucradoNatural($filters, $init, $quantity),
                        'involucrado_all' => $tipo == 'J' ? $this->inv->searchInvolucradoJuridico($filters_total_records) : $this->inv->searchInvolucradoNatural($filters),
                        'total_records_find' => $resultFind,
                        'total_records' => $result,
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertInvolucrado($tipo)
    {
        $field = '';
        $insert = '';
        $msg['success'] = false;

        if ($tipo == 'J') {
            /*ANTIGUO
            $field = array (
                'id' => $this->input->post('involucrado_id'),
                'nombre' => $this->input->post('involucrado_nombre'),
                'ruc' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'observacion' => '',
                'clasificacion_id' => $this->input->post('clasificacion_id'),
                'actividad_id' => $this->input->post('actividad_id'),
                'grupo_id' => $this->input->post('grupo_id'),
                'vendedor_id' => '0',
                'estado_id' => '1',
                'referido_id' => '0',
                'importante_id' => '1',
                'info_status' => $this->input->post('involucrado_estado'),
                'info_create_user' => $this->session->userdata('usu_id')
            );*/
            $field = array (
                'razon_social' => $this->input->post('involucrado_nombre'),
                'tipo_documento_id' => '4',
                'nro_documento' => $this->input->post('involucrado_documento'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'correo' => '',
                'vendedor_id' => '0',
                'referido_id' => '0',
                'importancia_id' => '1',
                'info_create_user' => $this->session->userdata('usu_id'),
                'info_status' => $this->input->post('involucrado_estado')
            );

            $filters = array(
                                'involucrado_nombre' => '',
                                'involucrado_documento' => $this->input->post('involucrado_documento'),
                                'involucrado_direccion' => '',
                                'involucrado_telefono' => '',
                                'involucrado_estado' => ''
                            );

            $exist_ruc = $this->inv->searchInvolucradoJuridico($filters);

            if ($exist_ruc == false)
                $insert = $this->inv->insertInvolucradoJuridico($field);
            else
                $msg['success'] = 'exist';
        } else {
            /* ANTIGUO
            $field = array (
                'id' => $this->input->post('involucrado_id'),
                'nombre' => $this->input->post('involucrado_nombre'),
                'documento_tipo_id' => '1',
                'documento' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'correo' => $this->input->post('involucrado_correo'),
                'vendedor_id' => '0',
                'estado_id' => '1',
                'observacion' => '',
                'referido_id' => '0',
                'importante_id' => '1',
                'info_status' => $this->input->post('involucrado_estado'),
                'info_create_user' => $this->session->userdata('usu_id')
            );*/

            $field = array (
                'paterno' => $this->input->post('involucrado_paterno'),
                'materno' => $this->input->post('involucrado_materno'),
                'nombres' => $this->input->post('involucrado_nombres'),
                'tipo_documento_id' => '2',
                'nro_documento' => $this->input->post('involucrado_documento'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'correo' => $this->input->post('involucrado_correo'),
                'vendedor_id' => '0',
                'referido_id' => '0',
                'importancia_id' => '1',
                'info_create_user' => $this->session->userdata('usu_id'),
                'info_status' => $this->input->post('involucrado_estado')
            );

            $insert = $this->inv->insertInvolucradoNatural($field);
        }
        
        if ($msg['success'] != 'exist'){
            if ($insert > 0) {
                $msg['success'] = true;
            }
        }

        echo json_encode($msg);
    }

    public function updateInvolucrado($tipo)
    {
        $field = '';
        $insert = '';
        $msg['success'] = false;

        if ($tipo == 'J') {
            /*ANTIGUO
            $field = array (
                'nombre' => $this->input->post('involucrado_nombre'),
                'nro_documento' => $this->input->post('involucrado_documento'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'info_update' => $this->input->post('involucrado_fecha_update'),
                'info_update_user' => $this->session->userdata('usu_id'),
                'info_status' => $this->input->post('involucrado_estado')
            );*/

            $field = array (
                'razon_social' => $this->input->post('involucrado_nombre'),
                'nro_documento' => $this->input->post('involucrado_documento'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'info_update' => $this->input->post('involucrado_fecha_update'),
                'info_update_user' => $this->session->userdata('usu_id'),
                'info_status' => $this->input->post('involucrado_estado')
            );

            $update = $this->inv->updateInvolucradoJuridico($field, $this->input->post('involucrado_id'));
        } else {
            /*ANTIGUO
            $field = array (
                'nombre' => $this->input->post('involucrado_nombre'),
                'documento' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'correo' => $this->input->post('involucrado_correo'),
                'info_status' => $this->input->post('involucrado_estado'),
                'info_update_user' => $this->session->userdata('usu_id'),
                'info_update' => $this->input->post('involucrado_fecha_update')
            );*/

            $field = array (
                'paterno' => $this->input->post('involucrado_paterno'),
                'materno' => $this->input->post('involucrado_materno'),
                'nombres' => $this->input->post('involucrado_nombres'),
                'nro_documento' => $this->input->post('involucrado_documento'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'correo' => $this->input->post('involucrado_correo'),
                'info_status' => $this->input->post('involucrado_estado'),
                'info_update_user' => $this->session->userdata('usu_id'),
                'info_update' => $this->input->post('involucrado_fecha_update')
            );

            $update = $this->inv->updateInvolucradoNatural($field, $this->input->post('involucrado_id'));
        }
        
        if ($update > 0) {
            $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    /*public function apiRUC($ruc)
    {
        //$data = file_get_contents("http://consultas.dsdinformaticos.com/sunat.php?ruc=".$ruc);
        $data = file_get_contents("http://ruc.aqpfact.pe/sunat/".$ruc);
        $info = json_decode($data, true);
        
        if(empty($data)){
            $datos = array('existe' => false);
            echo json_encode($datos);
        } else {
            $datos = array(
                'ruc' => $info['Ruc'], 
                'razon_social' => $info['RazonSocial'],
                'direccion' => $info['DireccionCompleta']
            );

            echo json_encode($datos);
        }
    }

    public function apiDNI($dni)
    {
        //$data = file_get_contents("http://consultas.dsdinformaticos.com/reniec.php?dni=".$dni);
        $data = file_get_contents("https://api.reniec.cloud/dni/".$dni);
        $info = json_decode($data, true);
        
        if(empty($data)){
            $datos = array('existe' => false);
            echo json_encode($datos);
        } else {
            $datos = array(
                'dni' => $info['dni'], 
                'nombres' => $info['nombres'],
                'paterno' => $info['apellido_paterno'],
                'materno' => $info['apellido_materno']
            );
            echo json_encode($datos);
        }
    }*/
    public function consultar_dni($dni)
    {       
        $data = file_get_contents('https://dniruc.apisperu.com/api/v1/dni/' . $dni . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFwcnJhbW9zZEBnbWFpbC5jb20ifQ.8ytQaBIm0dcC6VclPYmixWtKMTE9QpvkOq1TkNAEB-c', FALSE, stream_context_set_default(array('http' => array('ignore_errors' => true), 'ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
        $info = json_decode($data, TRUE);
        $fields = array();

        if (isset($info['success']) && $info['success'] == false)
        {
            $fields = array(
                'success' => FALSE,
                'message' => 'DNI no existe...'
            );
        }
        else
        {
            $fields = array(
                'success' => TRUE,
                'nombres' => $info['nombres'],
                'paterno' => $info['apellidoPaterno'],
                'materno' => $info['apellidoMaterno']
            );
        }

        echo json_encode($fields);
    }

    public function consultar_ruc($ruc)
    {
        $data = file_get_contents('https://dniruc.apisperu.com/api/v1/ruc/' . $ruc . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFwcnJhbW9zZEBnbWFpbC5jb20ifQ.8ytQaBIm0dcC6VclPYmixWtKMTE9QpvkOq1TkNAEB-c', FALSE, stream_context_set_default(array('http' => array('ignore_errors' => true), 'ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
        $info = json_decode($data, TRUE);
        $fields = array();

        if (isset($info['success']) && $info['success'] == false)
        {
            $fields = array(
                'success' => FALSE,
                'message' => 'RUC no existe...'
            );
        }
        else
        {
            $fields = array(
                'success'       => TRUE,
                'nombres'       => $info['razonSocial'],
                'direccion'     => $info['direccion'],
                'distrito'      => $info['distrito'],
                'provincia'     => $info['provincia'],
                'departamento'  => $info['departamento'],
                'estado'        => $info['estado']
            );
        }

        echo json_encode($fields);
    }
    /*END INVOLUCRADOS*/

    /*BEGIN CONTACTOS*/
    /*ANTIGUO
    public function contactoReporte($id)
    {
        $result = $this->con->contactoReporte($id);
        echo json_encode($result);
    }*/

    public function contactoReporte($id)
    {
        $result = $this->con->contactoReporte($id);
        echo json_encode($result);
    }

    public function searchContacto()
    {
        $filters = array(
                            'involucrado_juridico' => $this->input->post('involucrado_juridico'),
                            'contacto_nombre' => $this->input->post('contacto_nombre'),
                            'contacto_cargo' => $this->input->post('contacto_cargo'),
                            'contacto_correo' => $this->input->post('contacto_correo'),
                            'contacto_estado' => $this->input->post('contacto_estado')
                        );

        $filters_total_records =    array(
                                        'involucrado_juridico' => $this->input->post('involucrado_juridico'),
                                        'contacto_nombre' => '',
                                        'contacto_cargo' => '',
                                        'contacto_correo' => '',
                                        'contacto_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'contacto_find' => $this->con->searchContacto($filters, $init, $quantity),
                        'contacto_all' => $this->con->searchContacto($filters_total_records),
                        'total_records_find' => $this->con->searchContacto($filters) == false ? false : count($this->con->searchContacto($filters)),
                        'total_records' => $this->con->searchContacto($filters_total_records) == false ? false : count($this->con->searchContacto($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertContacto()
    {
        $field = array (
            'id' => $this->input->post('contacto_id'),
            'nombre' => $this->input->post('contacto_nombre'),
            'cargo' => $this->input->post('contacto_cargo'),
            'telefono' => $this->input->post('contacto_telefono'),
            'correo' => $this->input->post('contacto_correo'),
            /*ANTIGUO
                'juridica_id' => $this->input->post('juridica_id'),*/
            'juridica_id' => 0,
            'juridica_id_new' => $this->input->post('juridica_id'),
            'info_status' => $this->input->post('contacto_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->con->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateContacto()
    {
        $field = array (
            'nombre' => $this->input->post('contacto_nombre'),
            'cargo' => $this->input->post('contacto_cargo'),
            'telefono' => $this->input->post('contacto_telefono'),
            'correo' => $this->input->post('contacto_correo'),
            'info_status' => $this->input->post('contacto_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('contacto_fecha_update')
        );

        $update = $this->con->Update($field, $this->input->post('contacto_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END CONTACTOS*/


    /*BEGIN CLASIFICACIÓN*/
    public function searchClasificacion()
    {
        $filters = array(
                            'clasificacion_nombre' => $this->input->post('clasificacion_nombre'),
                            'clasificacion_estado' => $this->input->post('clasificacion_estado')
                        );

        $filters_total_records =    array(
                                        'clasificacion_nombre' => '',
                                        'clasificacion_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'clasificacion_find' => $this->cla->searchClasificacion($filters, $init, $quantity),
                        'clasificacion_all' => $this->cla->searchClasificacion($filters_total_records),
                        'total_records_find' => $this->cla->searchClasificacion($filters) == false ? false : count($this->cla->searchClasificacion($filters)),
                        'total_records' => $this->cla->searchClasificacion($filters_total_records) == false ? false : count($this->cla->searchClasificacion($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertClasificacion()
    {
        $field = array (
            'id' => $this->input->post('clasificacion_id'),
            'nombre' => $this->input->post('clasificacion_nombre'),
            'info_status' => $this->input->post('clasificacion_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->cla->Insert($field);

        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateClasificacion()
    {
        $field = array (
            'nombre' => $this->input->post('clasificacion_nombre'),
            'info_status' => $this->input->post('clasificacion_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('clasificacion_fecha_update')
        );

        $update = $this->cla->Update($field, $this->input->post('clasificacion_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END CLASIFICACIÓN*/

    /*BEGIN ACTIVIDAD*/
    public function searchActividad()
    {
        $filters = array(
                            'actividad_nombre' => $this->input->post('actividad_nombre'),
                            'actividad_estado' => $this->input->post('actividad_estado')
                        );

        $filters_total_records =    array(
                                        'actividad_nombre' => '',
                                        'actividad_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'actividad_find' => $this->act->searchactividad($filters, $init, $quantity),
                        'actividad_all' => $this->act->searchActividad($filters_total_records),
                        'total_records_find' => $this->act->searchactividad($filters) == false ? false : count($this->act->searchactividad($filters)),
                        'total_records' => $this->act->searchactividad($filters_total_records) == false ? false : count($this->act->searchactividad($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertActividad()
    {
        $field = array (
            'id' => $this->input->post('actividad_id'),
            'nombre' => $this->input->post('actividad_nombre'),
            'info_status' => $this->input->post('actividad_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->act->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateActividad()
    {
        $field = array (
            'nombre' => $this->input->post('actividad_nombre'),
            'info_status' => $this->input->post('actividad_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('actividad_fecha_update')
        );

        $update = $this->act->Update($field, $this->input->post('actividad_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END ACTIVIDAD*/

    /*BEGIN GRUPO*/
    public function searchGrupo()
    {
        $filters = array(
                            'grupo_nombre' => $this->input->post('grupo_nombre'),
                            'grupo_estado' => $this->input->post('grupo_estado')
                        );

        $filters_total_records =    array(
                                        'grupo_nombre' => '',
                                        'grupo_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'grupo_find' => $this->grp->searchGrupo($filters, $init, $quantity),
                        'grupo_all' => $this->grp->searchGrupo($filters_total_records),
                        'total_records_find' => $this->grp->searchGrupo($filters) == false ? false : count($this->grp->searchGrupo($filters)),
                        'total_records' => $this->grp->searchGrupo($filters_total_records) == false ? false : count($this->grp->searchGrupo($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertGrupo()
    {
        $field = array (
            'id' => $this->input->post('grupo_id'),
            'nombre' => $this->input->post('grupo_nombre'),
            'info_status' => $this->input->post('grupo_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->grp->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateGrupo()
    {
        $field = array (
            'nombre' => $this->input->post('grupo_nombre'),
            'info_status' => $this->input->post('grupo_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('grupo_fecha_update')
        );

        $update = $this->grp->Update($field, $this->input->post('grupo_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END GRUPO*/

    /*BEGIN SERVICIO*/
    public function searchServicio()
    {
        $filters = array(
                            'servicio_nombre' => $this->input->post('servicio_nombre'),
                            'servicio_estado' => $this->input->post('servicio_estado')
                        );

        $filters_total_records =    array(
                                            'servicio_nombre' => '',
                                            'servicio_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'servicio_find' => $this->ser->searchServicio($filters, $init, $quantity),
                        'servicio_all' => $this->ser->searchServicio($filters_total_records),
                        'total_records_find' => $this->ser->searchServicio($filters) == false ? false : count($this->ser->searchServicio($filters)),
                        'total_records' => $this->ser->searchServicio($filters_total_records) == false ? false : count($this->ser->searchServicio($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertServicio()
    {
        $field = array (
            'id' => $this->input->post('servicio_id'),
            'nombre' => $this->input->post('servicio_nombre'),
            'moneda_id' => $this->input->post('moneda_id'),
            'costo' => $this->input->post('servicio_costo'),
            'info_status' => $this->input->post('servicio_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->ser->InsertServicio($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateServicio()
    {
        $field = array (
            'nombre' => $this->input->post('servicio_nombre'),
            'moneda_id' => $this->input->post('moneda_id'),
            'costo' => $this->input->post('servicio_costo'),
            'info_status' => $this->input->post('servicio_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('servicio_fecha_update')
        );

        $update = $this->ser->UpdateServicio($field, $this->input->post('servicio_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END SERVICIO*/
}
/* End of file Cotizacion.php */
/* Location: ./application/controllers/cotizacion/Cotizacion.php */

