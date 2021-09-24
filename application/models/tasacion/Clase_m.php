<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clase_m extends CI_Model {

	public function searchClase($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				$order = " ORDER BY nombre ASC";

				if (isset($data['clase_tipo'])) {
					if ($data['clase_tipo'] != '') {
                        $filters .= " WHERE tipo = '" . $data['clase_tipo'] . "'";
                    }
				}

				if (isset($data['clase_nombre'])) {
					if ($data['clase_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['clase_nombre'] . "%'";
                    } elseif ($data['clase_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['clase_nombre'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['clase_nombre'])) {
					if ($data['clase_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE tipo = '" . $data['clase_tipo'] . "' AND nombre = '" . $data['clase_nombre'] . "'";
                    } elseif ($data['clase_nombre'] != '' && $filters != '') {
                        $filters .= " AND tipo = '" . $data['clase_tipo'] . "' AND nombre = '" . $data['clase_nombre'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id clase_id,
										    nombre clase_nombre
										FROM tas_clase".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('tas_clase', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_clase', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Clase.php */
/* Location: ./application/models/tasacion/Clase.php */