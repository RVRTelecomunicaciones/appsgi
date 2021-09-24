<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinador extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('coordinador/coordinador_m', 'coord');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		
	}

	public function searchCoordinadorCombo()
	{
		$data = array(
						'coordinador_records' => $this->coord->coordinadorSearch()
					);

		echo json_encode($data);
	}

}

/* End of file Coordinador.php */
/* Location: ./application/controllers/coordinador/Coordinador.php */