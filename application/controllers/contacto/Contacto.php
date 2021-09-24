<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('contacto/contacto_m', 'cont');
	}

	public function fetch_all_combobox()
	{
		$filters = array(
            'action' => 'combobox',
            'juridica_id' => $this->input->post('search'),
            'order' => 'ASC'
        );

        $fetch_data = $this->cont->fetch_all($filters);

        $data = array();
        foreach ($fetch_data as $row)
        {
        	$data[] = array(
        		'id' => $row['id'],
        		'text'=> strtoupper($row['nombre'])
        	);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}

/* End of file Contacto.php */
/* Location: ./application/controllers/contacto/Contacto.php */