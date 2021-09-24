<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('tasacion/tasacion_m', 'tas');
		$this->load->model('calidad/calidad_m', 'ccal');
		$this->load->model('perito/perito_m', 'per');

        $this->load->model('tasacion/terreno_m', 'ter');
        $this->load->model('tasacion/casa_m', 'cas');
        $this->load->model('tasacion/departamento_m', 'dep');
        $this->load->model('tasacion/oficina_m', 'ofi');
        $this->load->model('tasacion/LComercial_m', 'com');
        $this->load->model('tasacion/LIndustrial_m', 'ind');
        $this->load->model('tasacion/vehiculo_m', 'veh');
        $this->load->model('tasacion/maquinaria_m', 'maq');

        $this->load->model('tasacion/zonificacion_m', 'znf');
        $this->load->model('tasacion/cultivo_m', 'cul');
        $this->load->model('tasacion/TDepartamento_m', 'tdep');

        $this->load->model('tasacion/cliente_m', 'cli');
        $this->load->model('tasacion/propietario_m', 'prop');
        $this->load->model('tasacion/solicitante_m', 'sol');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['perito'] = $this->per->searchPerito(array('accion' => 'filtros'));
            $data['ccalidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['view'] = 'tasacion/tasacion_list';
            $this->load->view('layout', $data);
        }
	}

	public function searchTasaciones()
	{
		/*COORDINACIONES TERMINDAS LISTAS PARA REGISTRAR*/
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'perito_id' => $this->input->post('perito_id')/*,
            'control_calidad_id' => $this->input->post('control_calidad_id'),
            'tasacion_fecha_desde' => $this->input->post('tasacion_fecha_desde'),
            'tasacion_fecha_hasta' => $this->input->post('tasacion_fecha_hasta')*/
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_records' => $this->tas->searchTasaciones($filters),
        	'total_records_find' => $this->tas->searchTasaciones($filters) == false ? false : count($this->tas->searchTasaciones($filters_find)),
        	'total_records' => count($this->tas->searchTasaciones(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

	public function terreno()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['cultivo'] = $this->cul->cultivoReporte();
        	$data['zonificacion'] = $this->znf->zonificacionReporte();
            $data['view'] = 'tasacion/terreno_list';
            $this->load->view('layout', $data);
        }
	}

	public function searchTerreno()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'propietario_nombre' => $this->input->post('propietario_nombre'),
            'tasacion_ubicacion' => $this->input->post('tasacion_ubicacion'),
            'zonificacion_id' => $this->input->post('zonificacion_id'),
            'cultivo_tipo_id' => $this->input->post('cultivo_tipo_id'),
            'tasacion_fecha_desde' => $this->input->post('tasacion_fecha_desde'),
            'tasacion_fecha_hasta' => $this->input->post('tasacion_fecha_hasta'),
            'tasacion_terreno_desde' => $this->input->post('tasacion_terreno_desde'),
            'tasacion_terreno_hasta' => $this->input->post('tasacion_terreno_hasta')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_terreno_records' => $this->ter->searchTerreno($filters),
        	'total_records_find' => $this->ter->searchTerreno($filters) == false ? false : count($this->ter->searchTerreno($filters_find)),
        	'total_records' => count($this->ter->searchTerreno(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

	public function casa()
	{
		# code...
	}

	public function searchCasa()
	{
		# code...
	}

	public function departamento()
	{
		# code...
	}

	public function oficina()
	{
		# code...
	}

	public function lcomercial()
	{
		# code...
	}

	public function lindustrial()
	{
		# code...
	}

	public function mantenimiento()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['cultivo'] = $this->cul->cultivoReporte();
        	$data['zonificacion'] = $this->znf->zonificacionReporte();
        	$data['tdepartamento'] = $this->tdep->tdepartamentoReporte();
            $data['view'] = 'tasacion/tasacion_mant';
            $this->load->view('layout_form', $data);
        }
	}

	public function insertTasacion()
	{
		$resultCliente = false;
		$resultPropietario = false;
		$resultSolicitante = false;
		if (!is_numeric($this->input->post('tasacion_cliente'))) {
			$resultCliente = $this->cli->searchCliente(array('accion' => 'registro', 'cliente_nombre_exacto' => $this->input->post('tasacion_cliente')));

			if ($resultCliente == false) {
				$resultCliente = $this->cli->Insert(array('nombre' => $this->input->post('tasacion_cliente'), 'sinonimo' => '0'));
			}
		} else {
			$resultCliente = $this->input->post('tasacion_cliente');
		}
		
		if (!is_numeric($this->input->post('tasacion_propietario'))) {
			$resultPropietario = $this->prop->searchPropietario(array('accion' => 'registro', 'propietario_nombre_exacto' => $this->input->post('tasacion_propietario')));

			if ($resultPropietario == false) {
				$resultPropietario = $this->prop->Insert(array('nombre' => $this->input->post('tasacion_propietario'), 'sinonimo' => '0'));
			}
		} else {
			$resultPropietario = $this->input->post('tasacion_propietario');
		}
		
		if (!is_numeric($this->input->post('tasacion_solicitante'))) {
			$resultSolicitante = $this->sol->searchSolicitante(array('accion' => 'registro', 'solicitante_nombre_exacto' => $this->input->post('tasacion_solicitante')));

			if ($resultSolicitante == false) {
				$resultSolicitante = $this->sol->Insert(array('nombre' => $this->input->post('tasacion_solicitante'), 'sinonimo' => '0'));
			}
		} else {
			$resultSolicitante = $this->input->post('tasacion_solicitante');
		}
		
		
		$field_generic = array(
			'proyecto_id' => $this->input->post('tasacion_correlativo'),
			'informe_id' => $this->input->post('tasacion_correlativo'),
			'cliente_id' => $this->input->post('tasacion_tipo') == '7' || $this->input->post('tasacion_tipo') == '8' ? 0 : $resultCliente,
			'propietario_id' => $this->input->post('tasacion_tipo') == '7' || $this->input->post('tasacion_tipo') == '8' ? 0 : $resultPropietario,
			'solicitante_id' => $this->input->post('tasacion_tipo') == '7' || $this->input->post('tasacion_tipo') == '8' ? 0 : $resultSolicitante,
			'ubicacion' => $this->input->post('tasacion_ubicacion'),
			'tasacion_fecha' => $this->input->post('tasacion_fecha'),
			'ubigeo_distrito_id' => $this->input->post('tasacion_ubigeo'),
			'mapa_latitud' => $this->input->post('tasacion_latitud'),
			'mapa_longitud' => $this->input->post('tasacion_longitud'),
			'zonificacion' => $this->input->post('tasacion_zonificacion'),
			'terreno_area' => $this->input->post('tasacion_area_terreno'),
			'terreno_valorunitario' => $this->input->post('tasacion_valor_unitario'),
			'valor_comercial' => $this->input->post('tasacion_valor_comercial'),
			'tipo_cambio' => $this->input->post('tasacion_tipo_cambio'),
			'observacion' => $this->input->post('tasacion_observacion'),
			'ruta_informe' => $this->input->post('tasacion_ruta'),
			'fecha_registro' => date("Y-m-d H:i:s"),
			'usuario_registro_id' => $this->session->userdata('usu_id')
		);

		$insert;
		if ($this->input->post('tasacion_tipo') == '1') {
			$field_terreno = array(
				'cultivo_tipo_id' => $this->input->post('tasacion_cultivo'),
				'estado' => '1'
			);
			$field = array_merge($field_generic, $field_terreno);

			$insert = $this->ter->Insert($field);
		} elseif ($this->input->post('tasacion_tipo') == '2') {
			$field_casa = array(
				'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_casa);

			$insert = $this->cas->Insert($field);
		} elseif ($this->input->post('tasacion_tipo') == '3') {
			$field_departamento = array(
				'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'piso_ubicacion' => $this->input->post('tasacion_piso_ubicacion'),
				'departamento_tipo_id' => $this->input->post('tasacion_departamento_tipo'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada'),
				'estacionamiento_cantidad' => $this->input->post('tasacion_cantidad_estacinamiento'),
				'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_departamento);

			$insert = $this->dep->Insert($field);
		} elseif ($this->input->post('tasacion_tipo') == '4') {
			$field_oficina = array(
				'tipo_propiedad' => $this->input->post('tasacion_propiedad'),
				'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'piso_ubicacion' => $this->input->post('tasacion_piso_ubicacion'),
				'departamento_tipo_id' => $this->input->post('tasacion_departamento_tipo'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada'),
				'estacionamiento_cantidad' => $this->input->post('tasacion_cantidad_estacinamiento'),
				'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_oficina);

			$insert = $this->ofi->Insert($field);
		} elseif ($this->input->post('tasacion_tipo') == '5') {
			$field_local_comercial = array(
				'vista_local_id' => $this->input->post('tasacion_vista'),
				'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'tipo_edificacion' => $this->input->post('tasacion_tipo_edificacion'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada')
			);
			$field = array_merge($field_generic, $field_local_comercial);

			$insert = $this->com->Insert($field);
		} elseif ($this->input->post('tasacion_tipo') == '6') {
			$field_local_industrial = array(
				'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_local_industrial);

			$insert = $this->ind->Insert($field);
		} elseif ($this->input->post('tasacion_tipo') == '7' || $this->input->post('tasacion_tipo') == '8') {
			$field_generic_vm = array(
				'proyecto_id' => $this->input->post('tasacion_correlativo'),
				'informe_id' => $this->input->post('tasacion_correlativo'),
				'cliente_id' => $this->input->post('tasacion_cliente'),
				'propietario_id' => $this->input->post('tasacion_propietario'),
				'solicitante_id' => $this->input->post('tasacion_solicitante'),
				'ubicacion' => $this->input->post('tasacion_ubicacion'),
				'tasacion_fecha' => $this->input->post('tasacion_fecha'),
				$this->input->post('tasacion_tipo') == '7' ? 'vehiculo_tipo_id' : 'maquinaria_tipo_id' => $this->input->post('tasacion_tipo_vm'),
				$this->input->post('tasacion_tipo') == '7' ? 'vehiculo_marca_id' : 'maquinaria_marca_id' => $this->input->post('tasacion_marca_vm'),
				$this->input->post('tasacion_tipo') == '7' ? 'vehiculo_modelo_id' : 'maquinaria_modelo_id' => $this->input->post('tasacion_modelo_vm'),
				'fabricacion_anio' => $this->input->post('tasacion_fabricacion'),
				'valor_similar_nuevo' => $this->input->post('tasacion_vsn'),
				'valor_comercial' => $this->input->post('tasacion_valor_comercial'),
				'tipo_cambio' => $this->input->post('tasacion_tipo_cambio'),
				'observacion' => $this->input->post('tasacion_observacion'),
				'ruta_informe' => $this->input->post('tasacion_ruta'),
				'fecha_registro' => date("Y-m-d H:i:s"),
				'usuario_registro_id' => $this->session->userdata('usu_id')
			);


			$field_vehiculo = array(
				'vehiculo_traccion_id' => $this->input->post('tasacion_traccion_v')
			);

			$field = array_merge($field_generic_vm, $field_vehiculo);
			
			$insert = $this->input->post('tasacion_tipo') == '7' ? $this->veh->Insert($field) : $this->maq->Insert($field_generic_vm);
		}

		$msg['success'] = false;
		if ($insert > 0) {
			$msg['success'] = true;
		}

		echo json_encode($msg);
	}

	public function updateTasacion()
	{

	}
}

/* End of file Tasacion.php */
/* Location: ./application/controllers/tasacion/Tasacion.php */