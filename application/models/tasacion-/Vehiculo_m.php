<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculo_m extends CI_Model {

	public function Insert($data)
    {
        $this->db->insert('t_vehiculo', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('t_vehiculo', $data, array('id' => $id));
        return $this->db->affected_rows();
    }

}

/* End of file Vehiculo_m.php */
/* Location: ./application/models/tasacion/Vehiculo_m.php */