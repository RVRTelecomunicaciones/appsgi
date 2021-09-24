<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_m extends CI_Model {

	public function searchModelo($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				$order = " ORDER BY nombre ASC";

				if (isset($data['modelo_tipo'])) {
					if ($data['modelo_tipo'] != '') {
                        $filters .= " WHERE tipo = '" . $data['modelo_tipo'] . "'";
                    }
				}

				if (isset($data['modelo_nombre'])) {
					if ($data['modelo_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['modelo_nombre'] . "%'";
                    } elseif ($data['modelo_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['modelo_nombre'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['modelo_nombre'])) {
					if ($data['modelo_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE tipo = '" . $data['modelo_tipo'] . "' AND nombre = '" . $data['modelo_nombre'] . "'";
                    } elseif ($data['modelo_nombre'] != '' && $filters != '') {
                        $filters .= " AND tipo = '" . $data['modelo_tipo'] . "' AND nombre = '" . $data['modelo_nombre'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id modelo_id,
										    nombre modelo_nombre
										FROM tas_modelo".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('tas_modelo', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_modelo', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Modelo_m.php */
/* Location: ./application/models/tasacion/Modelo_m.php */