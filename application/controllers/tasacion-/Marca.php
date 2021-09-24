<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/marca_m', 'mar');

        /*LIBRERIAS*/
        //$this->load->library('excel');
    }

	public function marcaSearch()
	{
		$data = array(
						'marca_records' => $this->input->post('tipo') == 'v' ? $this->mar->marcaVehiculoReporte() : $this->mar->marcaMaquinariaReporte()
					);

		echo json_encode($data);
	}

}

/* End of file Marca.php */
/* Location: ./application/controllers/tasacion/Marca.php */