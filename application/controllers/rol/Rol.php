<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rol/rol_m','rol');
    }

    public function index()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['view'] = 'rol/rol_list';
			$this->load->view('layout', $data);
		}
    }

    public function searchRol()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'rol_descripcion' => $this->input->post('rol_descripcion')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'rol_all' => $this->rol->searchRol(array('accion' => 'full')),
            'rol_records' => $this->rol->searchRol($filters),
        	'total_records_find' => $this->rol->searchRol($filters) == false ? 0 : count($this->rol->searchRol($filters_find)),
        	'total_records' => count($this->rol->searchRol(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }

    public function insertRol()
    {
        $filters_find = array(
            'accion' => 'validar',
            'rol_descripcion' => $this->input->post('rol_descripcion')
        );

        $resultValidar = $this->rol->searchRol($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->input->post('rol_descripcion'),
                'info_status' => '1'
            );

            $insert = $this->rol->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateRol()
    {
        $field = array(
            'nombre' => $this->input->post('rol_descripcion'),
            'info_update' => date('Y-m-d H:i:s')
        );

        $insert = $this->rol->Update($field, $this->input->post('rol_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file rol.php */
/* Location: ./application/controllers/rol/rol.php */