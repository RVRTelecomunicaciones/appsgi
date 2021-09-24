<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Casa_m extends CI_Model {
    
	public function Insert($data)
    {
        $this->db->insert('t_casa', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('t_casa', $data, array('id' => $id));
        return $this->db->affected_rows();
    }

}

/* End of file Casa_m.php */
/* Location: ./application/models/tasacion/Casa_m.php */