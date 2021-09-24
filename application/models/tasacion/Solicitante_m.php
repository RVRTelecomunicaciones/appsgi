<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class solicitante_m extends CI_Model {

	public function searchSolicitante($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				if (isset($data['solicitante_nombre'])) {
					if ($data['solicitante_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE replace(nombre, '\\\\', '') LIKE '%" . $data['solicitante_nombre'] . "%'";
                    } elseif ($data['solicitante_nombre'] != '' && $filters != '') {
                        $filters .= " AND replace(nombre, '\\\\', '') LIKE '%" . $data['solicitante_nombre'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['solicitante_nombre'])) {
					if ($data['solicitante_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['solicitante_nombre'] . "'";
                    } elseif ($data['solicitante_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['solicitante_nombre'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id solicitante_id,
										    nombre solicitante_nombre,
										    nro_documento solicitante_nro_documento
										FROM tas_solicitante".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('tas_solicitante', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_solicitante', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file solicitante_m.php */
/* Location: ./application/models/tasacion/solicitante_m.php */