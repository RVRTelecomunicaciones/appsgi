<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propietario_m extends CI_Model {

	public function searchPropietario($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'registro') {
				if (isset($data['propietario_nombre_exacto'])) {
					if ($data['propietario_nombre_exacto'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['propietario_nombre_exacto'] . "'";
                    } elseif ($data['propietario_nombre_exacto'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['propietario_nombre_exacto'] . "'";
                    }
				}
			} elseif ($data['accion'] == 'filtros') {
				if (isset($data['propietario_nombre'])) {
					if ($data['propietario_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['propietario_nombre'] . "%'";
                    } elseif ($data['propietario_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['propietario_nombre'] . "%'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id propietario_id,
										    nombre propietario_nombre
										FROM diccionario_propietario".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
            if ($data['accion'] == 'registro') {
        		$resultPropietario = $sql_query->row();
        		return $resultPropietario->propietario_id;
        	} else {
        		return $sql_query->result();
        	}
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('diccionario_propietario', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('diccionario_propietario', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Propietario_m.php */
/* Location: ./application/models/tasacion/Propietario_m.php */