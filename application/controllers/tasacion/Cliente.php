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
            'cliente_nombre' => addslashes($this->db->escape_str($this->input->post('cliente_nombre'))),
            'cliente_nro_documento' => $this->input->post('cliente_nro_documento')
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
        $filters_find = array(
            'accion' => 'validar',
            'cliente_nombre' => addslashes($this->db->escape_str($this->input->post('cliente_nombre')))
        );

        $resultValidar = $this->tascli->searchCliente($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->db->escape_str($this->input->post('cliente_nombre')),
                'nro_documento' => $this->input->post('cliente_nro_documento'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->tascli->Insert($field);

            if ($insert > 0)
                $msg['success'] = true;
        }
        
        echo json_encode($msg);
    }

    public function updateCliente()
    {
        $filters_find = array(
            'accion' => 'validar',
            'cliente_nombre' => addslashes($this->db->escape_str($this->input->post('cliente_nombre')))
        );

        $resultValidar = $this->tascli->searchCliente($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->db->escape_str($this->input->post('cliente_nombre')),
                'nro_documento' => $this->input->post('cliente_nro_documento')
            );

            $update = $this->tascli->Update($field, $this->input->post('cliente_id'));

            if ($update > 0)
                $msg['success'] = true;
        }
        
        echo json_encode($msg);
    }
}

/* End of file Cliente.php */
/* Location: ./application/controllers/tasacion/Cliente.php */