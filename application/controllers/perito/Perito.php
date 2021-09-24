<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perito extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('perito/perito_m', 'pert');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		
	}

	public function searchPeritoCombo()
	{
		$data = array(
						'perito_records' => $this->pert->searchPerito(array('accion' => 'filtros', 'perito_estado' => 1))
					);

		echo json_encode($data);
	}

	public function search()
	{
		$filters_count = array('accion' => 'count');

        $filters_find =   array(
			'perito_codigo' => $this->input->post('perito_codigo'),
			'perito_nombre' => $this->input->post('perito_nombre'),
			'perito_estado' => $this->input->post('perito_estado')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->pert->search($filters_count),
            'records_find_count' => $this->pert->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->pert->search($filters)
        );

        echo json_encode($data);
	}
}

/* End of file Perito.php */
/* Location: ./application/controllers/perito/Perito.php */