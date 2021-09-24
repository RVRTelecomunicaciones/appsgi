<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intranet extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
	}

	public function index()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        }else{
        	$data['view'] = 'dashboard/index';
			$this->load->view('layout', $data);
		}
	}

	public function acceso()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            $this->load->view('acceso');
        }else{
            redirect('intranet/inicio');
        }
    }

    public function salir()
    {
    	$this->session->sess_destroy();
        redirect('intranet/acceso');
    }
}

/* End of file Intranet.php */
/* Location: ./application/controllers/Intranet.php */