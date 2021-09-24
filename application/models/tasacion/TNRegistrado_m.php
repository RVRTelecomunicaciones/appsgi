<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TNRegistrado_m extends CI_Model {

	public function searchTNRegistrado($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				$order = " ORDER BY nombre ASC";
				if (isset($data['no_registrado_nombre'])) {
					if ($data['no_registrado_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['no_registrado_nombre'] . "%'";
                    } elseif ($data['no_registrado_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['no_registrado_nombre'] . "%'";
                    }
				}
			}  else if ($data['accion'] == 'validar') {
				if (isset($data['no_registrado_nombre'])) {
					if ($data['no_registrado_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['no_registrado_nombre'] . "'";
                    }/* elseif ($data['no_registrado_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['no_registrado_nombre'] . "'";
                    }*/
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id tipo_no_registrado_id,
										    nombre tipo_no_registrado_nombre
										FROM tas_no_registrado_tipo".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('tas_no_registrado_tipo', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_no_registrado_tipo', $data, array('id' => $id));
        return $this->db->affected_rows();
	}

}

/* End of file TNRegistrado_m.php */
/* Location: ./application/models/tasacion/TNRegistrado_m.php */