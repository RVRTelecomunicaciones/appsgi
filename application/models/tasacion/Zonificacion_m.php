<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonificacion_m extends CI_Model {

	public function searchZonificacion($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				$order = " ORDER BY nombre ASC";
				if (isset($data['zonificacion_nombre'])) {
					if ($data['zonificacion_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['zonificacion_nombre'] . "%'";
                    } elseif ($data['zonificacion_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['zonificacion_nombre'] . "%'";
                    }
				}
			}/* else if ($data['accion'] == 'validar') {
				if (isset($data['zonificacion_nombre'])) {
					if ($data['zonificacion_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['zonificacion_nombre'] . "'";
                    } elseif ($data['zonificacion_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['zonificacion_nombre'] . "'";
                    }
				}
			}*/
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
										id zonificacion_id,
									    nombre zonificacion_nombre,
									    abreviatura zonificacion_abreviatura
									FROM tas_zonificacion".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('tas_zonificacion', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_zonificacion', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Zonificacion_m.php */
/* Location: ./application/models/zonificacion/Zonificacion_m.php */