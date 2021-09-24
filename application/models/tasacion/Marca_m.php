<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca_m extends CI_Model {

	public function searchMarca($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				$order = " ORDER BY nombre ASC";

				if (isset($data['marca_tipo'])) {
					if ($data['marca_tipo'] != '') {
                        $filters .= " WHERE tipo = '" . $data['marca_tipo'] . "'";
                    }
				}

				if (isset($data['marca_nombre'])) {
					if ($data['marca_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['marca_nombre'] . "%'";
                    } elseif ($data['marca_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['marca_nombre'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['marca_nombre'])) {
					if ($data['marca_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE tipo = '" . $data['marca_tipo'] . "' AND nombre = '" . $data['marca_nombre'] . "'";
                    } elseif ($data['marca_nombre'] != '' && $filters != '') {
                        $filters .= " AND tipo = '" . $data['marca_tipo'] . "' AND nombre = '" . $data['marca_nombre'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id marca_id,
										    nombre marca_nombre
										FROM tas_marca".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('tas_marca', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_marca', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Marca_m.php */
/* Location: ./application/models/tasacion/Marca_m.php */