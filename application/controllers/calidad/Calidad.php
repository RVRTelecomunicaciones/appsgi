<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calidad extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('calidad/calidad_m', 'ccal');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		echo "HOLAA";
	}

	public function searchControlCalidadCombo()
	{
		$data = array(
						'control_calidad_records' => $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'))
					);

		echo json_encode($data);
	}

	public function search()
	{
		$filters_count = array('accion' => 'count');

        $filters_find =   array(
			'control_calidad_codigo' => $this->input->post('control_calidad_codigo'),
			'control_calidad_nombre' => $this->input->post('control_calidad_nombre'),
			'control_calidad_estado' => $this->input->post('control_calidad_estado')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->ccal->search($filters_count),
            'records_find_count' => $this->ccal->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->ccal->search($filters)
        );

        echo json_encode($data);
	}
}

/* End of file CCalidad.php */
/* Location: ./application/controllers/control-calidad/CCalidad.php */