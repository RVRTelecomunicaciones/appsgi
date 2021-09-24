<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguimiento extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('seguimiento/seguimiento_m', 'seg');
		$this->load->model('cotizacion/cotizacion_m', 'cot');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		
	}

	public function searchSeguimiento()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cotizacion_id' => $this->input->post('cotizacion_id')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'seguimiento_records' => $this->seg->searchSeguimiento($filters),
            'total_records' => $this->seg->searchSeguimiento($filters_find) != false ? count($this->seg->searchSeguimiento($filters_find)) : 0,
            'init' => (($this->input->post('num_page') - 1) * $this->input->post('quantity') + 1),
            'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

	public function insertSeguimiento()
	{
		$msg = array('success' => false);

        if ($this->input->post('accion') == 'desestimar') {
        	$field_seguimiento = array(
        		'cotizacion_id' => $this->input->post('cotizacion_id'),
				'estado_id' => $this->input->post('estado_id'),
				'mensaje' => $this->input->post('mensaje'),
				'proxima' => '0',
				'info_create_user' => $this->session->userdata('usu_id'),
				'info_status' => '1'
        	);

        	$insert_seguimiento = $this->seg->Insert($field_seguimiento);

        	if ($insert_seguimiento > 0) {
        		$field_cotizacion = array(
					'estado_id' => $this->input->post('estado_id'),
					'info_update_user' => $this->session->userdata('usu_id'),
					'info_update' => date('Y-m-d H:i:s')
	        	);

	        	$insert_cotizacion = $this->cot->Update($field_cotizacion, $this->input->post('cotizacion_id'));

	        	if ($insert_cotizacion > 0)
	        		$msg = array('success' => true);
        	}
        } else {
        	$field = array(
				'cotizacion_id' => $this->input->post('cotizacion_id'),
				'estado_id' => $this->input->post('estado_id'),
				'mensaje' => $this->input->post('mensaje'),
				'fecha_proxima' => $this->input->post('fecha_proxima'),
				'proxima' => '0',
				'info_create_user' => $this->session->userdata('usu_id'),
				'info_status' => '1'
			);

			$insert_seguimiento = $this->seg->Insert($field);
			if ($insert_seguimiento > 0)
				$msg = array('success' => true);
        }

        echo json_encode($msg);
	}
}

/* End of file Seguimiento.php */
/* Location: ./application/controllers/seguimiento/Seguimiento.php */