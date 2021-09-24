<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LComercial_m extends CI_Model {

	public function Insert($data)
    {
        $this->db->insert('t_local_comercial', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('t_local_comercial', $data, array('id' => $id));
        return $this->db->affected_rows();
    }

}

/* End of file LComercial_m.php */
/* Location: ./application/models/tasacion/LComercial_m.php */