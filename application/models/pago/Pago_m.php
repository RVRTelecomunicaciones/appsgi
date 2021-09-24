<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago_m extends CI_Model {

	public function Insert($data)
	{
		$this->db->insert('co_pago', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
    {
        $this->db->update('co_pago', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Pago_m.php */
/* Location: ./application/models/pago/Pago_m.php */