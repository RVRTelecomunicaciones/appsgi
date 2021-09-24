<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traccion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/traccion_m', 'trac');

        /*LIBRERIAS*/
        //$this->load->library('excel');
    }

	public function traccionSearch()
	{
		$data = array(
						'traccion_records' => $this->trac->traccionVehiculoReporte()
					);

		echo json_encode($data);
	}

}

/* End of file Traccion.php */
/* Location: ./application/controllers/tasacion/Traccion.php */