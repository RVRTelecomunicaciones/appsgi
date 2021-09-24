<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TVehiculo extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/TVehiculo_m', 'tveh');

        /*LIBRERIAS*/
        //$this->load->library('excel');
    }

	public function tvehiculoSearch()
	{
		$data = array(
						'tvehiculo_records' => $this->input->post('tipo') == 'v' ? $this->tveh->tipoVehiculoReporte() : $this->tveh->tipoMaquinariaReporte()
					);

		echo json_encode($data);
	}

}

/* End of file TVehiculo.php */
/* Location: ./application/controllers/tasacion/TVehiculo.php */