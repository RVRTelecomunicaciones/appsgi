<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clase extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/clase_m', 'cls');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
		
	}

	public function searchClase()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'clase_tipo' => $this->input->post('clase_tipo'),
            'clase_nombre' => $this->input->post('clase_nombre')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_clase_all' => $this->cls->searchClase(array('accion' => 'filtros', 'clase_tipo' => $this->input->post('clase_tipo'))),
            'tasacion_clase_records' => $this->cls->searchClase($filters),
        	'total_records_find' => $this->cls->searchClase($filters) == false ? 0 : count($this->cls->searchClase($filters_find)),
        	'total_records' => count($this->cls->searchClase(array('accion' => 'filtros', 'clase_tipo' => $this->input->post('clase_tipo')))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertClase()
    {
        $filters_find = array(
            'accion' => 'validar',
            'clase_tipo' => $this->input->post('clase_tipo'),
            'clase_nombre' => $this->input->post('clase_nombre')
        );

        $resultValidar = $this->cls->searchClase($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
            	'tipo' => $this->input->post('clase_tipo'),
                'nombre' => $this->input->post('clase_nombre'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->cls->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateClase()
    {
        $field = array(
            'nombre' => $this->input->post('clase_nombre')
        );

        $insert = $this->cls->Update($field, $this->input->post('clase_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Clase.php */
/* Location: ./application/controllers/tasacion/Clase.php */