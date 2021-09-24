<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('area/area_m','area');
    }

    public function index()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['view'] = 'area/area_list';
			$this->load->view('layout', $data);
		}
    }

    public function searchArea()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'area_descripcion' => $this->input->post('area_descripcion')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'area_all' => $this->area->searchArea(array('accion' => 'full')),
            'area_records' => $this->area->searchArea($filters),
        	'total_records_find' => $this->area->searchArea($filters) == false ? 0 : count($this->area->searchArea($filters_find)),
        	'total_records' => count($this->area->searchArea(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }

    public function insertArea()
    {
        $filters_find = array(
            'accion' => 'validar',
            'area_descripcion' => $this->input->post('area_descripcion')
        );

        $resultValidar = $this->area->searchArea($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->input->post('area_descripcion'),
                'info_status' => '1'
            );

            $insert = $this->area->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateArea()
    {
        $field = array(
            'nombre' => $this->input->post('area_descripcion'),
            'info_update' => date('Y-m-d H:i:s')
        );

        $insert = $this->area->Update($field, $this->input->post('area_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file area.php */
/* Location: ./application/contarealers/area/area.php */