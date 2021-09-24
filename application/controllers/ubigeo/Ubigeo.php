<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubigeo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
		$this->load->model('ubigeo/ubigeo_m', 'ubi');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
	}


	/*UBIGEO FINAL*/
	public function searchUbigeoDepartamento()
	{
		$data = array(
						'departamento_records' => $this->ubi->searchUbigeoDepartamento()
					);
		echo json_encode($data);
	}

	public function searchUbigeoProvincia()
	{
		$data = array(
						'provincia_records' => $this->ubi->searchUbigeoProvincia(array('departamento_id' => $this->input->post('departamento_id')))
					);
		echo json_encode($data);
	}

	public function searchUbigeoDistrito()
	{
		$data = array(
						'distrito_records' => $this->ubi->searchUbigeoDistrito(array('provincia_id' => $this->input->post('provincia_id')))
					);
		echo json_encode($data);
	}

}

/* End of file Ubigeo.php */
/* Location: ./application/controllers/ubigeo/Ubigeo.php */