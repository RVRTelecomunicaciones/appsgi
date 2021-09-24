<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_m extends CI_Model {

	public function searchArea($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				//$order = " ORDER BY nombre ASC";
				if (isset($data['area_descripcion'])) {
					if ($data['area_descripcion'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['area_descripcion'] . "%'";
                    } elseif ($data['area_descripcion'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['area_descripcion'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['area_descripcion'])) {
					if ($data['area_descripcion'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['area_descripcion'] . "'";
                    } elseif ($data['area_descripcion'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['area_descripcion'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id area_id,
											nombre area_descripcion
										FROM login_area".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('login_area', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('login_area', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file area_m.php */
/* Location: ./application/models/usuario/area_m.php */