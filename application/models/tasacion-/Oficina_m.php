<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oficina_m extends CI_Model {

	public function Insert($data)
    {
        $this->db->insert('t_oficina', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('t_oficina', $data, array('id' => $id));
        return $this->db->affected_rows();
    }

}

/* End of file Oficina_m.php */
/* Location: ./application/models/tasacion/Oficina_m.php */