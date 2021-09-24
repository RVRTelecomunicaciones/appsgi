<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TDocumento extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

        /*MODELOS*/
        $this->load->model('tdocumento/TDocumento_m', 'tdoc');
	}

	public function search()
	{
		$filters_count = array('action' => 'count');

        $filters_find = array();

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array();

        if ($this->input->post('action') != 'combobox') {
        	$data = array(
	            'records_all_count' => $this->tdoc->search($filters_count),
	            'records_find_count' => $this->tdoc->search(array_merge($filters_count, $filters_find)),
	            'records_find' => $this->tdoc->search($filters)
	        );
        } else {
        	$data = array(
	            'records_all' => $this->tdoc->search($filters_find)
	        );
        }

        echo json_encode($data);
	}
}

/* End of file TDocumento.php */
/* Location: ./application/controllers/tdocumento/TDocumento.php */