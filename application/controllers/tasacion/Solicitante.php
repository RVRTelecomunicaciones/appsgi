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
            'solicitante_nombre' => addslashes($this->db->escape_str($this->input->post('solicitante_nombre'))),
            'solicitante_nro_documento' => $this->input->post('solicitante_nro_documento')
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
        $filters_find = array(
            'accion' => 'validar',
            'solicitante_nombre' => addslashes($this->db->escape_str($this->input->post('solicitante_nombre')))
        );

        $resultValidar = $this->tassol->searchSolicitante($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->db->escape_str($this->input->post('solicitante_nombre')),
                'nro_documento' => $this->input->post('solicitante_nro_documento'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->tassol->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateSolicitante()
    {
        $filters_find = array(
            'accion' => 'validar',
            'solicitante_nombre' => addslashes($this->db->escape_str($this->input->post('solicitante_nombre')))
        );

        $resultValidar = $this->tassol->searchSolicitante($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'nombre' => $this->db->escape_str($this->input->post('solicitante_nombre')),
                'nro_documento' => $this->input->post('solicitante_nro_documento')                
            );

            $insert = $this->tassol->Update($field, $this->input->post('solicitante_id'));
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }
}

/* End of file Solicitante.php */
/* Location: ./application/controllers/tasacion/Solicitante.php */