<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamento_m extends CI_Model {

	public function Insert($data)
    {
        $this->db->insert('tas_departamento', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('tas_departamento', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Departamento_m.php */
/* Location: ./application/models/tasacion/Departamento_m.php */