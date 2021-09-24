<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquinaria_m extends CI_Model {

	public function Insert($data)
    {
        $this->db->insert('t_maquinaria', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('t_maquinaria', $data, array('id' => $id));
        return $this->db->affected_rows();
    }

}

/* End of file Maquinaria_m.php */
/* Location: ./application/models/tasacion/Maquinaria_m.php */