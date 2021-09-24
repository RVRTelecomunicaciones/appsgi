<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_m extends CI_Model {

	public function searchRol($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				//$order = " ORDER BY nombre ASC";
				if (isset($data['rol_descripcion'])) {
					if ($data['rol_descripcion'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['rol_descripcion'] . "%'";
                    } elseif ($data['rol_descripcion'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['rol_descripcion'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['rol_descripcion'])) {
					if ($data['rol_descripcion'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['rol_descripcion'] . "'";
                    } elseif ($data['rol_descripcion'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['rol_descripcion'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id rol_id,
											nombre rol_descripcion
										FROM login_profile".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('login_profile', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('login_profile', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file rol_m.php */
/* Location: ./application/models/usuario/rol_m.php */