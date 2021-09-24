<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proceso extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*MODELOS*/
        $this->load->model('proceso/proceso_m', 'proc');
	}

    public function search()
    {
        $filters_find =   array(
            'proceso_coordinacion' => $this->input->post('proceso_coordinacion'),
            'proceso_estado' => $this->input->post('proceso_estado')
        );

        $data = array(
            'records_find' => $this->proc->search($filters_find)
        );

        echo json_encode($data);
    }

	public function insert()
	{
		$field = array(
            'coordinacion_id' => $this->input->post('proceso_coordinacion'),
            'enviado_de' => $this->input->post('proceso_enviado_de'),
            'observacion' => $this->input->post('proceso_observacion'),
            'usuario_id' => $this->session->userdata('usu_id'),
            'estado_id' => $this->input->post('proceso_estado')
        );

        $insert = $this->proc->insert($field);
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
	}

	public function update()
	{
		$field = array(
            'proceso' => array(
                'enviado_a' => $this->input->post('proceso_enviado_a'),
                'observacion' => $this->input->post('proceso_observacion'),
                'fecha_final' => date('Y-m-d H:i:s'),
                'estado_id' => $this->input->post('proceso_estado')),
            'coordinacion' => array(
                'area_operaciones_id' => $this->input->post('proceso_enviado_a')
            )
        );

        $field_primary = array(
            'proceso' => array('id' => $this->input->post('proceso_codigo')),
            'coordinacion' => array('id' => $this->input->post('proceso_coordinacion'))
        );

        $update = $this->proc->update($field, $field_primary);

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
	}
}

/* End of file Proceso.php */
/* Location: ./application/controllers/operaciones/Proceso.php */