<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonificacion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/zonificacion_m', 'znf');

        /*LIBRERIAS*/
        $this->load->library('excel');
    }

	public function index()
	{
		
	}

	public function searchZonificacion()
	{
		$filters_find =   array(
            'accion' => $this->input->post('accion'),
            'zonificacion_nombre' => $this->input->post('zonificacion_nombre'),
            'zonificacion_abreviatura' => $this->input->post('zonificacion_abreviatura')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'tasacion_zonificacion_all' => $this->znf->searchZonificacion(array('accion' => 'full')),
            'tasacion_zonificacion_records' => $this->znf->searchZonificacion($filters),
        	'total_records_find' => $this->znf->searchZonificacion($filters) == false ? 0 : count($this->znf->searchZonificacion($filters_find)),
        	'total_records' => count($this->znf->searchZonificacion(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function insertzonificacion()
    {
        /*$filters_find = array(
            'accion' => 'validar',
            'zonificacion_nombre' => $this->input->post('zonificacion_nombre'),
            'zonificacion_abreviatura' => $this->input->post('zonificacion_abreviatura')
        );

        $resultValidar = $this->znf->searchZonificacion($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);*/
        $msg['success'] = false;

        /*if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {*/
            $field = array(
                'nombre' => $this->input->post('zonificacion_nombre'),
                'abreviatura' => $this->input->post('zonificacion_abreviatura'),
                'usuario_registro_id' => $this->session->userdata('usu_id')
            );

            $insert = $this->znf->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        /*}*/

        echo json_encode($msg);
    }

    public function updatezonificacion()
    {
        $field = array(
            'nombre' => $this->input->post('zonificacion_nombre'),
            'abreviatura' => $this->input->post('zonificacion_abreviatura')
        );

        $insert = $this->znf->Update($field, $this->input->post('zonificacion_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Zonificacion.php */
/* Location: ./application/controllers/tasacion/Zonificacion.php */