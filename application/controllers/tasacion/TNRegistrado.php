<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TNRegistrado extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/TNRegistrado_m', 'tnr');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
		
	}

	public function searchTNRegistrado()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'no_registrado_nombre' => $this->input->post('tipo_no_registrado_nombre')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_tipo_no_registrado_all' => $this->tnr->searchTNRegistrado(array('accion' => 'full')),
            'tasacion_tipo_no_registrado_records' => $this->tnr->searchTNRegistrado($filters),
        	'total_records_find' => $this->tnr->searchTNRegistrado($filters) == false ? 0 : count($this->tnr->searchTNRegistrado($filters_find)),
        	'total_records' => count($this->tnr->searchTNRegistrado(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertTNRegistrado()
    {
        $filters_find = array(
            'accion' => 'validar',
            'no_registrado_nombre' => $this->input->post('tipo_no_registrado_nombre')
        );

        $resultValidar = $this->tnr->searchTNRegistrado($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->input->post('tipo_no_registrado_nombre'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->tnr->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateTNRegistrado()
    {
        $field = array(
            'nombre' => $this->input->post('tipo_no_registrado_nombre')
        );

        $update = $this->tnr->Update($field, $this->input->post('tipo_no_registrado_id'));
        
        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file TNRegistrado.php */
/* Location: .//C/Users/Usuario/Desktop/TNRegistrado.php */