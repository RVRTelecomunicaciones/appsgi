<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/marca_m', 'mrc');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
		
	}

	public function searchMarca()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'marca_tipo' => $this->input->post('marca_tipo'),
            'marca_nombre' => $this->input->post('marca_nombre')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_marca_all' => $this->mrc->searchMarca(array('accion' => 'filtros', 'marca_tipo' => $this->input->post('marca_tipo'))),
            'tasacion_marca_records' => $this->mrc->searchMarca($filters),
        	'total_records_find' => $this->mrc->searchMarca($filters) == false ? 0 : count($this->mrc->searchMarca($filters_find)),
        	'total_records' => count($this->mrc->searchMarca(array('accion' => 'filtros', 'marca_tipo' => $this->input->post('marca_tipo')))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertMarca()
    {
        $filters_find = array(
            'accion' => 'validar',
            'marca_tipo' => $this->input->post('marca_tipo'),
            'marca_nombre' => $this->input->post('marca_nombre')
        );

        $resultValidar = $this->mrc->searchMarca($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
            	'tipo' => $this->input->post('marca_tipo'),
                'nombre' => $this->input->post('marca_nombre'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->mrc->Insert($field);

            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateMarca()
    {
        $field = array(
            'nombre' => $this->input->post('marca_nombre')
        );

        $insert = $this->mrc->Update($field, $this->input->post('marca_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Marca.php */
/* Location: ./application/controllers/tasacion/Marca.php */