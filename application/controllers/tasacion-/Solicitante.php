<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitante extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/solicitante_m', 'tassol');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
        
	}

	public function searchSolicitante()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_solicitante_all' => $this->tassol->searchSolicitante(array('accion' => 'full')),
            'tasacion_solicitante_records' => $this->tassol->searchSolicitante($filters),
        	'total_records_find' => $this->tassol->searchSolicitante($filters) == false ? 0 : count($this->tassol->searchSolicitante($filters_find)),
        	'total_records' => count($this->tassol->searchSolicitante(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertSolicitante()
    {
        $field = array(
            'nombre' => $this->input->post('solicitante_nombre'),
            'sinonimo' => '0'
        );

        $insert = $this->tassol->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    public function updateSolicitante()
    {
        $field = array(
            'nombre' => $this->input->post('solicitante_nombre')
        );

        $insert = $this->tassol->Update($field, $this->input->post('solicitante_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Solicitante.php */
/* Location: ./application/controllers/tasacion/Solicitante.php */