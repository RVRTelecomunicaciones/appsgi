<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/cliente_m', 'tascli');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
        
	}

	public function searchCliente()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_cliente_all' => $this->tascli->searchCliente(array('accion' => 'full')),
            'tasacion_cliente_records' => $this->tascli->searchCliente($filters),
        	'total_records_find' => $this->tascli->searchCliente($filters) == false ? 0 : count($this->tascli->searchCliente($filters_find)),
        	'total_records' => count($this->tascli->searchCliente(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertCliente()
    {
        $field = array(
            'nombre' => $this->input->post('cliente_nombre'),
            'sinonimo' => '0'
        );

        $insert = $this->tascli->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    public function updateCliente()
    {
        $field = array(
            'nombre' => $this->input->post('cliente_nombre')
        );

        $insert = $this->tascli->Update($field, $this->input->post('cliente_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Cliente.php */
/* Location: ./application/controllers/tasacion/Cliente.php */