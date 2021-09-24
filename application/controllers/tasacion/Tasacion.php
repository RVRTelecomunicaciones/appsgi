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
		$this->load->model('tasacion/TLocal_m', 'tloc');
        $this->load->model('tasacion/casa_m', 'cas');
        $this->load->model('tasacion/departamento_m', 'dep');
        $this->load->model('tasacion/oficina_m', 'ofi');
        $this->load->model('tasacion/LComercial_m', 'com');
        $this->load->model('tasacion/LIndustrial_m', 'ind');
        $this->load->model('tasacion/vehiculo_m', 'veh');
        $this->load->model('tasacion/maquinaria_m', 'maq');
        $this->load->model('tasacion/NRegistrado_m', 'nrg');
        
        $this->load->model('tasacion/cultivo_m', 'cul');
		$this->load->model('tasacion/TDepartamento_m', 'tdep');
		$this->load->model('tasacion/zonificacion_m', 'znf');
		$this->load->model('tasacion/clase_m', 'cls');
		$this->load->model('tasacion/marca_m', 'mrc');
		$this->load->model('tasacion/modelo_m', 'mdl');
		$this->load->model('tasacion/TNRegistrado_m', 'tnrg');

        $this->load->model('tasacion/cliente_m', 'cli');
        $this->load->model('tasacion/propietario_m', 'prop');
		$this->load->model('tasacion/solicitante_m', 'sol');
		
		$this->load->model('coordinacion/Coordinacion_m', 'coor');
		$this->load->model('auditoria/auditoria_m', 'aud');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		redirect('intranet/inicio');
	}

	public function por_registrar()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['ccalidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['view'] = 'tasacion/tasacion_por_registrar_list';
            $this->load->view('layout', $data);
        }
	}
	/*COORDINACIONES TERMINDAS LISTAS PARA REGISTRAR*/
	public function searchTasaciones()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
			'perito_id' => $this->input->post('perito_id'),
			'control_calidad_id' => $this->input->post('control_calidad_id')
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

	public function inmuebles()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['zonificacion'] = $this->znf->searchZonificacion(array('accion' => 'filtros'));
            $data['view'] = 'tasacion/tasacion_inmuebles_list';
            $this->load->view('layout', $data);
        }
	}

	public function searchInmuebles()
	{
		$filters_count = array('action' => 'count');

        $filters_find = array(
			'inmueble_tipo' => $this->input->post('inmueble_tipo'),
            'inmueble_coordinacion' => $this->input->post('inmueble_coordinacion'),
            'inmueble_solicitante' => $this->input->post('inmueble_solicitante'),
            'inmueble_cliente' => $this->input->post('inmueble_cliente'),
			'inmueble_direccion' => $this->input->post('inmueble_direccion'),
			'inmueble_zonificacion' => $this->input->post('inmueble_zonificacion'),
			'inmueble_fecha_desde' => $this->input->post('inmueble_fecha_desde'),
			'inmueble_fecha_hasta' => $this->input->post('inmueble_fecha_hasta'),
			'inmueble_area_desde' => $this->input->post('inmueble_area_desde'),
            'inmueble_area_hasta' => $this->input->post('inmueble_area_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->tas->searchInmuebles($filters_count),
            'records_find_count' => $this->tas->searchInmuebles(array_merge($filters_count, $filters_find)),
            'records_find' => $this->tas->searchInmuebles($filters)
        );

        echo json_encode($data);
	}

	public function vehiculos()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
			$data['clase'] = $this->cls->searchClase(array('accion' => 'filtros', 'clase_tipo' => 'V'));
			$data['marca'] = $this->mrc->searchMarca(array('accion' => 'filtros', 'marca_tipo' => 'V'));
			$data['modelo'] = $this->mdl->searchModelo(array('accion' => 'filtros', 'modelo_tipo' => 'V'));
            $data['view'] = 'tasacion/tasacion_vehiculos_list';
            $this->load->view('layout', $data);
        }
	}

	public function searchVehiculos()
	{
		$filters_count = array('action' => 'count');

        $filters_find = array(
			'vehiculo_coordinacion' => $this->input->post('vehiculo_coordinacion'),
            'vehiculo_solicitante' => $this->input->post('vehiculo_solicitante'),
            'vehiculo_cliente' => $this->input->post('vehiculo_cliente'),
			'vehiculo_clase' => $this->input->post('vehiculo_clase'),
			'vehiculo_marca' => $this->input->post('vehiculo_marca'),
			'vehiculo_modelo' => $this->input->post('vehiculo_modelo'),
			'vehiculo_fecha_desde' => $this->input->post('vehiculo_fecha_desde'),
			'vehiculo_fecha_hasta' => $this->input->post('vehiculo_fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->veh->search($filters_count),
            'records_find_count' => $this->veh->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->veh->search($filters)
        );

        echo json_encode($data);
	}

	public function maquinarias()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
			$data['clase'] = $this->cls->searchClase(array('accion' => 'filtros', 'clase_tipo' => 'M'));
			$data['marca'] = $this->mrc->searchMarca(array('accion' => 'filtros', 'marca_tipo' => 'M'));
			$data['modelo'] = $this->mdl->searchModelo(array('accion' => 'filtros', 'modelo_tipo' => 'M'));
            $data['view'] = 'tasacion/tasacion_maquinaria_list';
            $this->load->view('layout', $data);
        }
	}

	public function searchMaquinarias()
	{		
		$filters_count = array('action' => 'count');

        $filters_find = array(
			'maquinaria_coordinacion' => $this->input->post('maquinaria_coordinacion'),
            'maquinaria_solicitante' => $this->input->post('maquinaria_solicitante'),
            'maquinaria_cliente' => $this->input->post('maquinaria_cliente'),
			'maquinaria_clase' => $this->input->post('maquinaria_clase'),
			'maquinaria_marca' => $this->input->post('maquinaria_marca'),
			'maquinaria_modelo' => $this->input->post('maquinaria_modelo'),
			'maquinaria_fecha_desde' => $this->input->post('maquinaria_fecha_desde'),
			'maquinaria_fecha_hasta' => $this->input->post('maquinaria_fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->maq->search($filters_count),
            'records_find_count' => $this->maq->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->maq->search($filters)
        );

        echo json_encode($data);
	}

	public function otros()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
			$data['tnregistrado'] = $this->tnrg->searchTNRegistrado(array('accion' => 'filtros'));
            $data['view'] = 'tasacion/tasacion_otros_list';
            $this->load->view('layout', $data);
        }
	}

	public function searchOtros()
	{		
		$filters_count = array('action' => 'count');

        $filters_find = array(
			'otros_coordinacion' => $this->input->post('otros_coordinacion'),
            'otros_tipo' => $this->input->post('otros_tipo'),
            'otros_observacion' => $this->input->post('otros_observacion'),
			'otros_fecha_desde' => $this->input->post('otros_fecha_desde'),
			'otros_fecha_hasta' => $this->input->post('otros_fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->nrg->search($filters_count),
            'records_find_count' => $this->nrg->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->nrg->search($filters)
        );

        echo json_encode($data);
	}

	public function mantenimiento()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['cultivo'] = $this->cul->cultivoReporte();
			$data['tlocal'] = $this->tloc->tlocalReporte();
        	$data['tdepartamento'] = $this->tdep->tdepartamentoReporte();
            $data['view'] = 'tasacion/tasacion_mant';
            $this->load->view('layout_form', $data);
        }
	}

	public function insertTasacion()
	{
		$objPropietario = $this->prop->searchPropietario(array('accion' => 'validar', 'propietario_nombre' => $this->input->post('tasacion_propietario')));
		$propietario_id;
		
		if ($objPropietario == false) {
			$propietario_id = $this->prop->Insert(array('nombre' => $this->input->post('tasacion_propietario'), 'nro_documento' => '', 'usuario_registro_id' => $this->session->userdata('usu_id')));
		} else {
			$propietario_id = $objPropietario->propietario_id;
		}

		$field_generic = array(
			'informe_id' => $this->input->post('tasacion_correlativo'),
			'propietario_id' => $propietario_id,
			'cliente_id' => $this->input->post('tasacion_cliente'),
			'cliente_tipo' => $this->input->post('tasacion_cliente_tipo'),
			'solicitante_id' => $this->input->post('tasacion_solicitante'),
			'solicitante_tipo' => $this->input->post('tasacion_solicitante_tipo'),
			'ubicacion' => $this->input->post('tasacion_ubicacion'),
			'tasacion_fecha' => $this->input->post('tasacion_fecha'),
			'distrito_id' => $this->input->post('tasacion_ubigeo'),
			'mapa_latitud' => $this->input->post('tasacion_latitud'),
			'mapa_longitud' => $this->input->post('tasacion_longitud'),
			'zonificacion_id' => $this->input->post('tasacion_zonificacion'),
			'terreno_area' => $this->input->post('tasacion_area_terreno'),
			'terreno_valorunitario' => $this->input->post('tasacion_valor_unitario'),
			'valor_comercial' => $this->input->post('tasacion_valor_comercial'),
			'tipo_cambio' => $this->input->post('tasacion_tipo_cambio'),
			'observacion' => $this->input->post('tasacion_observacion'),
			'ruta_informe' => $this->input->post('tasacion_ruta'),
			'usuario_registro_id' => $this->session->userdata('usu_id')
		);

		$insert;
		if ($this->input->post('tasacion_tipo') == '1') {
			$field_terreno = array(
				'terreno_tipo_id' => $this->input->post('tasacion_cultivo')
			);
			$field = array_merge($field_generic, $field_terreno);

			$insert = $this->ter->Insert($field);

			//$path .= 'terreno/';
		} elseif ($this->input->post('tasacion_tipo') == '2') {
			//$field_casa = array(
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				//'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				//'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			//);
			//$field = array_merge($field_generic, $field_casa);

			$insert = $this->cas->Insert($field_generic);

			//$path .= 'casa/';
		} elseif ($this->input->post('tasacion_tipo') == '3') {
			$field_departamento = array(
				'valor_comercial_departamento' => $this->input->post('tasacion_valor_comercial_departamento'),
				//'piso_ubicacion' => $this->input->post('tasacion_piso_ubicacion'),
				'departamento_tipo_id' => $this->input->post('tasacion_departamento_tipo'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada'),
				'antiguedad' => $this->input->post('tasacion_antiguedad')
			);
			$field = array_merge($field_generic, $field_departamento);

			$insert = $this->dep->Insert($field);

			//$path .= 'departamento/';
		} elseif ($this->input->post('tasacion_tipo') == '4') {
			$field_oficina = array(
				//'tipo_propiedad' => $this->input->post('tasacion_propiedad'),
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				//'piso_ubicacion' => $this->input->post('tasacion_piso_ubicacion'),
				//'departamento_tipo_id' => $this->input->post('tasacion_departamento_tipo'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada')//,
				//'estacionamiento_cantidad' => $this->input->post('tasacion_cantidad_estacinamiento'),
				//'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_oficina);

			$insert = $this->ofi->Insert($field);

			//$path .= 'oficina/';
		} elseif ($this->input->post('tasacion_tipo') == '5') {
			$field_local_comercial = array(
				'local_tipo_id' => $this->input->post('tasacion_local_tipo'),
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				//'tipo_edificacion' => $this->input->post('tasacion_tipo_edificacion'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada')
			);
			$field = array_merge($field_generic, $field_local_comercial);

			$insert = $this->com->Insert($field);

			//$path .= 'local_comercial/';
		} elseif ($this->input->post('tasacion_tipo') == '6') {
			$field_local_industrial = array(
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion')//,
				//'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_local_industrial);

			$insert = $this->ind->Insert($field);

			//$path .= 'local_industrial/';
		} elseif ($this->input->post('tasacion_tipo') == '7' || $this->input->post('tasacion_tipo') == '8') {
			$field_generic_vm = array(
				'informe_id' => $this->input->post('tasacion_correlativo'),
				'cliente_id' => $this->input->post('tasacion_cliente'),
				'cliente_tipo' => $this->input->post('tasacion_cliente_tipo'),
				'propietario_id' => $propietario_id,
				'solicitante_id' => $this->input->post('tasacion_solicitante'),
				'solicitante_tipo' => $this->input->post('tasacion_solicitante_tipo'),
				'ubicacion' => $this->input->post('tasacion_ubicacion'),
				'tasacion_fecha' => $this->input->post('tasacion_fecha'),
				'clase_id' => $this->input->post('tasacion_clase'),
				'marca_id' => $this->input->post('tasacion_marca'),
				'modelo_id' => $this->input->post('tasacion_modelo'),
				'fabricacion_anio' => $this->input->post('tasacion_fabricacion'),
				'valor_similar_nuevo' => $this->input->post('tasacion_vsn'),
				'valor_comercial' => $this->input->post('tasacion_valor_comercial'),
				'tipo_cambio' => $this->input->post('tasacion_tipo_cambio'),
				'observacion' => $this->input->post('tasacion_observacion'),
				'ruta_informe' => $this->input->post('tasacion_ruta'),
				//'fecha_registro' => date("Y-m-d H:i:s"),
				'usuario_registro_id' => $this->session->userdata('usu_id')
			);
			
			$insert = $this->input->post('tasacion_tipo') == '7' ? $this->veh->Insert($field_generic_vm) : $this->maq->Insert($field_generic_vm);

			//$path .= $this->input->post('tasacion_tipo') == '7' ? 'vehiculo/' : 'maquinaria/';
		} elseif ($this->input->post('tasacion_tipo') == '9') {
			$field_no_registrado = array(
				'informe_id' => $this->input->post('tasacion_correlativo'),
				'tasacion_fecha' => $this->input->post('tasacion_fecha'),
				'tipo_no_registrado_id' => $this->input->post('tasacion_tipo_no_registrado'),
				'observacion' => $this->input->post('tasacion_observacion'),
				'ruta_informe' => $this->input->post('tasacion_ruta'),
				'usuario_registro_id' => $this->session->userdata('usu_id')
			);

			$insert = $this->nrg->Insert($field_no_registrado);
		}

		$msg['success'] = false;
		if ($insert > 0) {
			//if (isset($_FILES['file'])) {
				//$file = $path.$file_name;
		        //move_uploaded_file($file_tmp, $file);
		    //}

			$msg['success'] = true;

			if ($this->input->post('tasacion_action') != 'nuevo') {

				$objCoordinacion = $this->coor->search(array('action' => 'maintenance', 'coordinacion_correlativo' => $this->input->post('tasacion_correlativo')));

				$fields = array(
					'estado_id' => '3'
				);

				$resultUpdateDetalle = $this->coor->updateDetalle($fields, $objCoordinacion->coordinacion_id);

				if ($resultUpdateDetalle > 0) {
					$field_auditoria = array(        
						'aut_usu_id' => $this->session->userdata('usu_id'),
						'aut_coor_id' => $objCoordinacion->coordinacion_id,
						'aut_coor_est' => '3'
					);

					$this->aud->insertCoordinacion($field_auditoria);
				}
			}
		}

		echo json_encode($msg);
	}

	public function updateTasacion()
	{
		$objPropietario = $this->prop->searchPropietario(array('accion' => 'validar', 'propietario_nombre' => $this->input->post('tasacion_propietario')));
		$propietario_id;
		
		if ($objPropietario == false) {
			$propietario_id = $this->prop->Insert(array('nombre' => $this->input->post('tasacion_propietario'), 'nro_documento' => '', 'usuario_registro_id' => $this->session->userdata('usu_id')));
		} else {
			$propietario_id = $objPropietario->propietario_id;
		}

		$field_generic = array(
			/*'informe_id' => $this->input->post('tasacion_correlativo'),*/
			'propietario_id' => $propietario_id,
			'cliente_id' => $this->input->post('tasacion_cliente'),
			'cliente_tipo' => $this->input->post('tasacion_cliente_tipo'),
			'solicitante_id' => $this->input->post('tasacion_solicitante'),
			'solicitante_tipo' => $this->input->post('tasacion_solicitante_tipo'),
			'ubicacion' => $this->input->post('tasacion_ubicacion'),
			'tasacion_fecha' => $this->input->post('tasacion_fecha'),
			'distrito_id' => $this->input->post('tasacion_ubigeo'),
			'mapa_latitud' => $this->input->post('tasacion_latitud'),
			'mapa_longitud' => $this->input->post('tasacion_longitud'),
			'zonificacion_id' => $this->input->post('tasacion_zonificacion'),
			'terreno_area' => $this->input->post('tasacion_area_terreno'),
			'terreno_valorunitario' => $this->input->post('tasacion_valor_unitario'),
			'valor_comercial' => $this->input->post('tasacion_valor_comercial'),
			'tipo_cambio' => $this->input->post('tasacion_tipo_cambio'),
			'observacion' => $this->input->post('tasacion_observacion'),
			'ruta_informe' => $this->input->post('tasacion_ruta'),
			'info_update' => date('Y-m-d H:i:s'),
			'info_update_user' => $this->session->userdata('usu_id')
		);

		$update;
		if ($this->input->post('tasacion_tipo') == '1') {
			$field_terreno = array(
				'terreno_tipo_id' => $this->input->post('tasacion_cultivo')
			);
			$field = array_merge($field_generic, $field_terreno);

			$update = $this->ter->Update($field, $this->input->post('tasacion_codigo'));

			//$path .= 'terreno/';
		} elseif ($this->input->post('tasacion_tipo') == '2') {
			/*$field_casa = array(
				'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_casa);*/

			$update = $this->cas->Update($field_generic, $this->input->post('tasacion_codigo'));

			//$path .= 'casa/';
		} elseif ($this->input->post('tasacion_tipo') == '3') {
			$field_departamento = array(
				'valor_comercial_departamento' => $this->input->post('tasacion_valor_comercial_departamento'),
				//'piso_ubicacion' => $this->input->post('tasacion_piso_ubicacion'),
				'departamento_tipo_id' => $this->input->post('tasacion_departamento_tipo'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada'),
				'antiguedad' => $this->input->post('tasacion_antiguedad')
			);
			$field = array_merge($field_generic, $field_departamento);

			$update = $this->dep->Update($field, $this->input->post('tasacion_codigo'));

			//$path .= 'departamento/';
		} elseif ($this->input->post('tasacion_tipo') == '4') {
			$field_oficina = array(
				//'tipo_propiedad' => $this->input->post('tasacion_propiedad'),
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				//'piso_ubicacion' => $this->input->post('tasacion_piso_ubicacion'),
				//'departamento_tipo_id' => $this->input->post('tasacion_departamento_tipo'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada')//,
				//'estacionamiento_cantidad' => $this->input->post('tasacion_cantidad_estacinamiento'),
				//'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_oficina);

			$update = $this->ofi->Update($field, $this->input->post('tasacion_codigo'));

			//$path .= 'oficina/';
		} elseif ($this->input->post('tasacion_tipo') == '5') {
			$field_local_comercial = array(
				'local_tipo_id' => $this->input->post('tasacion_local_tipo'),
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				//'tipo_edificacion' => $this->input->post('tasacion_tipo_edificacion'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion'),
				'valor_ocupada' => $this->input->post('tasacion_area_ocupada')
			);
			$field = array_merge($field_generic, $field_local_comercial);

			$update = $this->com->Update($field, $this->input->post('tasacion_codigo'));

			//$path .= 'local_comercial/';
		} elseif ($this->input->post('tasacion_tipo') == '6') {
			$field_local_industrial = array(
				//'piso_cantidad' => $this->input->post('tasacion_cantidad_piso'),
				'edificacion_area' => $this->input->post('tasacion_area_edificacion')//,
				//'areas_complementarias' => $this->input->post('tasacion_area_complementaria')
			);
			$field = array_merge($field_generic, $field_local_industrial);

			$update = $this->ind->Update($field, $this->input->post('tasacion_codigo'));

			//$path .= 'local_industrial/';
		} elseif ($this->input->post('tasacion_tipo') == '7' || $this->input->post('tasacion_tipo') == '8') {
			$field_generic_vm = array(
				/*'informe_id' => $this->input->post('tasacion_correlativo'),*/
				'propietario_id' => $propietario_id,
				'cliente_id' => $this->input->post('tasacion_cliente'),
				'cliente_tipo' => $this->input->post('tasacion_cliente_tipo'),
				'solicitante_id' => $this->input->post('tasacion_solicitante'),
				'solicitante_tipo' => $this->input->post('tasacion_solicitante_tipo'),
				'ubicacion' => $this->input->post('tasacion_ubicacion'),
				'tasacion_fecha' => $this->input->post('tasacion_fecha'),
				'clase_id' => $this->input->post('tasacion_clase'),
				'marca_id' => $this->input->post('tasacion_marca'),
				'modelo_id' => $this->input->post('tasacion_modelo'),
				'fabricacion_anio' => $this->input->post('tasacion_fabricacion'),
				'valor_similar_nuevo' => $this->input->post('tasacion_vsn'),
				'valor_comercial' => $this->input->post('tasacion_valor_comercial'),
				'tipo_cambio' => $this->input->post('tasacion_tipo_cambio'),
				'observacion' => $this->input->post('tasacion_observacion'),
				'ruta_informe' => $this->input->post('tasacion_ruta'),
				'info_update' => date('Y-m-d H:i:s'),
				'info_update_user' => $this->session->userdata('usu_id')
			);
			
			$update = $this->input->post('tasacion_tipo') == '7' ? $this->veh->Update($field_generic_vm, $this->input->post('tasacion_codigo')) : $this->maq->Update($field_generic_vm, $this->input->post('tasacion_codigo'));

			//$path .= $this->input->post('tasacion_tipo') == '7' ? 'vehiculo/' : 'maquinaria/';
		} elseif ($this->input->post('tasacion_tipo') == '9') {
			$field_no_registrado = array(
				'informe_id' => $this->input->post('tasacion_correlativo'),
				'tasacion_fecha' => $this->input->post('tasacion_fecha'),
				'tipo_no_registrado_id' => $this->input->post('tasacion_tipo_no_registrado'),
				'observacion' => $this->input->post('tasacion_observacion'),
				'ruta_informe' => $this->input->post('tasacion_ruta'),
				'info_update' => date('Y-m-d H:i:s'),
				'info_update_user' => $this->session->userdata('usu_id')
			);

			$update = $this->nrg->Update($field_no_registrado, $this->input->post('tasacion_codigo'));
		}

		$msg['success'] = false;
		if ($update > 0) {
			/*if (isset($_FILES['file'])) {
				$file = $path.$file_name;
		        move_uploaded_file($file_tmp, $file);
		    }*/

			$msg['success'] = true;
			$objCoordinacion = $this->coor->search(array('action' => 'maintenance', 'coordinacion_correlativo' => $this->input->post('tasacion_correlativo')));

			$fields = array(
				'estado_id' => '3'
			);

			$resultUpdateDetalle = $this->coor->updateDetalle($fields, $objCoordinacion->coordinacion_id);

			//if ($resultUpdateDetalle > 0) {
				$result = $this->aud->searchAuditoriaCoordinacion(array('accion' => 'filtros', 'coordinacion_id' => $objCoordinacion->coordinacion_id));
				
				if ($result->aut_coor_est != '3') {
					$field_auditoria = array(        
						'aut_usu_id' => $this->session->userdata('usu_id'),
						'aut_coor_id' => $objCoordinacion->coordinacion_id,
						'aut_coor_est' => '3'
					);

					$this->aud->insertCoordinacion($field_auditoria);
				}
			//}
		}

		echo json_encode($msg);
	}

	//
	public function listado()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
			$data['modulo'] = $this->uri->segment(1);
			$data['menu'] = $this->uri->segment(2);
        	$data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['control_calidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['view'] = 'tasacion/tasacion_por_registrar';
            $this->load->view('layout', $data);
        }
	}

	public function detalle()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
			$data['modulo'] = $this->uri->segment(1);
			$data['menu'] = $this->uri->segment(2);
            $data['view'] = 'tasacion/tasacion_detalle';
            $this->load->view('layout', $data);
        }
	}

	public function search()
	{
		$filters_count = array('action' => 'count');

        $filters_find = array(
			'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
			'inspeccion_codigo' => $this->input->post('inspeccion_codigo'),
			'coordinacion_solicitante' => $this->input->post('coordinacion_solicitante'),
			'coordinacion_cliente' => $this->input->post('coordinacion_cliente'),
			'coordinacion_digitador' => $this->input->post('coordinacion_digitador'),
			'coordinacion_control_calidad' => $this->input->post('coordinacion_control_calidad')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->tas->search($filters_count),
            'records_find_count' => $this->tas->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->tas->search($filters)
        );

        echo json_encode($data);
	}

	public function searchDetalle()
	{
		$data = array(
            'records' => $this->tas->searchDetalle(array('coordinacion_correlativo' => $this->input->post('coordinacion_correlativo')))
        );

        echo json_encode($data);
	}

	public function registro()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
			$data['modulo'] = $this->uri->segment(1);
			$data['menu'] = $this->uri->segment(2);
			$data['cultivo'] = $this->cul->cultivoReporte();
			$data['tlocal'] = $this->tloc->tlocalReporte();
        	$data['tdepartamento'] = $this->tdep->tdepartamentoReporte();
            $data['view'] = 'tasacion/tasacion_mantenimiento';
			$this->load->view('layout', $data);
        }
	}

	public function finalizarReproceso()
	{
		$objCoordinacion = $this->coor->search(array('action' => 'maintenance', 'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo')));

		$fields = array(
			'info_status' => '0'
		);

		$update = $this->coor->updateReproceso($fields, $objCoordinacion->coordinacion_id);

		$msg['success'] = false;
		if ($update > 0) {
	        $msg['success'] = true;
		}

		echo json_encode($msg);
	}

	public function searchCoordinacion()
	{
        $filters_find = array(
			'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo')
        );

        $data = array(
            'records_find' => $this->tas->search(array_merge(array('action' => 'maintenance'), $filters_find))
        );

        echo json_encode($data);
	}
}

/* End of file Tasacion.php */
/* Location: ./application/controllers/tasacion/Tasacion.php */

