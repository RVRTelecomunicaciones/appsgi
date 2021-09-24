<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/modelo_m', 'mdl');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
		
	}

	public function searchModelo()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'modelo_tipo' => $this->input->post('modelo_tipo'),
            'modelo_nombre' => $this->input->post('modelo_nombre')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_modelo_all' => $this->mdl->searchModelo(array('accion' => 'filtros', 'modelo_tipo' => $this->input->post('modelo_tipo'))),
            'tasacion_modelo_records' => $this->mdl->searchModelo($filters),
        	'total_records_find' => $this->mdl->searchModelo($filters) == false ? 0 : count($this->mdl->searchModelo($filters_find)),
        	'total_records' => count($this->mdl->searchModelo(array('accion' => 'filtros', 'modelo_tipo' => $this->input->post('modelo_tipo')))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertModelo()
    {
        $filters_find = array(
            'accion' => 'validar',
            'modelo_tipo' => $this->input->post('modelo_tipo'),
            'modelo_nombre' => $this->input->post('modelo_nombre')
        );

        $resultValidar = $this->mdl->searchModelo($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
            	'tipo' => $this->input->post('modelo_tipo'),
                'nombre' => $this->input->post('modelo_nombre'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->mdl->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateModelo()
    {
        $field = array(
            'nombre' => $this->input->post('modelo_nombre')
        );

        $insert = $this->mdl->Update($field, $this->input->post('modelo_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Modelo.php */
/* Location: ./application/controllers/tasacion/Modelo.php */