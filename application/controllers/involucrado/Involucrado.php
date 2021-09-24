<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Involucrado extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('involucrado/involucrado_m', 'inv');
	}

	public function search()
	{
		$filters_count = array('action' => 'count');

        $filters_find = array(
        	'involucrado_tipo' => $this->input->post('involucrado_tipo'),
        	'involucrado_codigo' => $this->input->post('involucrado_codigo'),
        	'involucrado_nombres' => $this->input->post('involucrado_nombres'),
        	'involucrado_documento_tipo' => $this->input->post('involucrado_documento_tipo'),
        	'involucrado_nro_documento' => $this->input->post('involucrado_nro_documento')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array();

        if ($this->input->post('action') != 'combobox') {
        	$data = array(
	            'records_all_count' => $this->inv->search($filters_count),
	            'records_find_count' => $this->inv->search(array_merge($filters_count, $filters_find)),
	            'records_find' => $this->inv->search($filters)
	        );
        } else {
        	$data = array(
	            'records_all' => $this->inv->search($filters_find)
	        );
        }

        echo json_encode($data);
	}

    public function insert()
    {
        $insert = 0;
        if ($this->input->post('involucrado_tipo') == 'Juridica') {
            $field = array(
                'razon_social' => $this->input->post('involucrado_nombres'),
                'tipo_documento_id' => $this->input->post('involucrado_documento_tipo'),
                'nro_documento' => $this->input->post('involucrado_nro_documento'),
                'telefono' => '',
                'direccion' => '',
                'correo' => '',
                'vendedor_id' => '0',
                'referido_id' => '0',
                'importancia_id' => '1', 
                'info_create_user' => $this->session->userdata('usu_id'),
                'info_status' => '1'
            );

            $insert = $this->inv->Insert($field, 'J');
        } else {
            $field = array(
                'paterno' => $this->input->post('involucrado_paterno'),
                'materno' => $this->input->post('involucrado_materno'),
                'nombres' => $this->input->post('involucrado_nombres'),
                'tipo_documento_id' => $this->input->post('involucrado_documento_tipo'),
                'nro_documento' => $this->input->post('involucrado_nro_documento'),
                'telefono' => '',
                'direccion' => '',
                'correo' => '',
                'vendedor_id' => '0',
                'referido_id' => '0',
                'importancia_id' => '1', 
                'info_create_user' => $this->session->userdata('usu_id'),
                'info_status' => '1'
            );

            $insert = $this->inv->Insert($field, 'N');
        }
        
        if ($insert > 0){
            $msg = array('success' => true, 'idInvolucrado' => $insert);
        } else {
            $msg = array('success' => false, 'idInvolucrado' => '0');
        }
        echo json_encode($msg);
    }
    
    //
    public function fetch_all_involucrado()
    {
        if ($this->input->is_ajax_request())
        {
            $filters = array(
                'action' => 'table',
                'type' => $this->input->post('type'),
                'nombre_completo' => $this->input->post('nombre_completo'),
                'nro_documento' => $this->input->post('nro_documento'),
                'order' => $this->input->post('order'),
                'length' => $this->input->post('length'),
                'start' => $this->input->post('start')
            );

            $fetch_data = $this->inv->fectch_all_involucrado($filters);
            $data = array();

            foreach ($fetch_data as $row)
            {
                $array = array();
                $array[] = $row->id;
                $array[] = $row->nombre_completo;
                $array[] = $row->nro_documento;

                $array[] = $row->info_status === '1' ? '<span class="label label-success">Activo</span>' : '<span class="label label-default">Inactivo</span>';
                $array[] = '<button type="button" class="btn mr-1 btn-outline-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn mr-1 btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>';

                $data[] = $array;
            }

            $output = array(
                //'draw' => intval($_POST['draw']),  
                'recordsTotal' =>  $this->inv->count_all($filters),  
                'recordsFiltered'=> $this->inv->count_filter($filters),  
                'data' => $data  
            );

            echo json_encode($output);
        }
        else
        {
            show_404();
        }
    }

    public function fetch_combobox_involucrado()
    {
        $filters = array(
            'action' => 'combobox',
            'type' => $this->input->post('type'),
            'nombre_completo' => $this->input->post('search'),
            'order' => 'ASC'
        );

        $fetch_data = $this->inv->fectch_all_involucrado($filters);

        foreach ($fetch_data as $row) {

            if ($this->input->post('type') === 'N')
            {
                $selectajax[] = array(
                    'id' => $row['id'],
                    'text' => $row['nro_documento'] != '' ? strtoupper($row['nombre_completo']) . ' (' . $row['nro_documento'] . ')' : strtoupper($row['nombre_completo']),
                );

                $this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
            }
            else if ($this->input->post('type') === 'J')
            {
                $selectajax[] = array(
                    'id' => $row['id'],
                    'text' => $row['nro_documento'] != '' ? strtoupper($row['razon_social']) . ' (' . $row['nro_documento'] . ')' : strtoupper($row['razon_social']),
                );

                $this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
            }
        }
    }
}

/* End of file Involucrado.php */
/* Location: ./application/controllers/involucrado/Involucrado.php */