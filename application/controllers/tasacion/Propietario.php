<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propietario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('tasacion/propietario_m', 'tasprop');

		/*LIBRERIAS*/
		$this->load->library('excel');
	}

	public function index()
	{

	}

	public function searchPropietario()
	{
		$filters_find =   array(
			'accion' => $this->input->post('accion'),
			'propietario_nombre' => addslashes($this->db->escape_str($this->input->post('propietario_nombre'))),
			'propietario_nro_documento' => $this->input->post('propietario_nro_documento')
		);

		$filters_pagination = array(
			'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
			'quantity' => $this->input->post('quantity')
		);

		$filters = array_merge($filters_find, $filters_pagination);

		$data = array(
			'tasacion_propietario_all' => $this->tasprop->searchPropietario(array('accion' => 'full')),
			'tasacion_propietario_records' => $this->tasprop->searchPropietario($filters),
			'total_records_find' => $this->tasprop->searchPropietario($filters) == false ? 0 : count($this->tasprop->searchPropietario($filters_find)),
			'total_records' => count($this->tasprop->searchPropietario(array('accion' => 'full'))),
			'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
			'quantity' => $this->input->post('quantity')
		);

		echo json_encode($data);
	}

	public function insertPropietario()
	{
		$filters_find = array(
			'accion' => 'validar',
			'propietario_nombre' => addslashes($this->db->escape_str($this->input->post('propietario_nombre')))
		);

		$resultValidar = $this->tasprop->searchPropietario($filters_find);
		$countValidar = $resultValidar == false ? 0 : count($resultValidar);
		$msg['success'] = false;

		if ($countValidar > 0) {
			$msg['success'] = 'existe';
		} else {
			$field = array(
				'nombre' => $this->db->escape_str($this->input->post('propietario_nombre')),
				'nro_documento' => $this->input->post('propietario_nro_documento'),
				'usuario_registro_id' => $this->session->userdata('usu_id')
			);

			$insert = $this->tasprop->Insert($field);
			
			if ($insert > 0)
				$msg['success'] = true;
		}

		echo json_encode($msg);
	}

	public function updatePropietario()
	{
		$filters_find = array(
			'accion' => 'validar',
			'propietario_nombre' => addslashes($this->db->escape_str($this->input->post('propietario_nombre')))
		);

		$resultValidar = $this->tasprop->searchPropietario($filters_find);
		$countValidar = $resultValidar == false ? 0 : count($resultValidar);
		$msg['success'] = false;

		if ($countValidar > 0) {
			$msg['success'] = 'existe';
		} else {
			$field = array(
				'nombre' => $this->db->escape_str($this->input->post('propietario_nombre')),
				'nro_documento' => $this->input->post('propietario_nro_documento')
			);

			$update = $this->tasprop->Update($field, $this->input->post('propietario_id'));
			
			if ($update > 0)
				$msg['success'] = true;
		}

		echo json_encode($msg);
	}
}

/* End of file Propietario.php */
/* Location: ./application/controllers/tasacion/Propietario.php */