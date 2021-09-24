<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_m extends CI_Model {

	public function searchCliente($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'registro') {
				if (isset($data['cliente_nombre_exacto'])) {
					if ($data['cliente_nombre_exacto'] != '' && $filters == '') {
                        $filters .= " WHERE nombre = '" . $data['cliente_nombre_exacto'] . "'";
                    } elseif ($data['cliente_nombre_exacto'] != '' && $filters != '') {
                        $filters .= " AND nombre = '" . $data['cliente_nombre_exacto'] . "'";
                    }
				}
			} elseif ($data['accion'] == 'filtros') {
				if (isset($data['cliente_nombre'])) {
					if ($data['cliente_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['cliente_nombre'] . "%'";
                    } elseif ($data['cliente_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['cliente_nombre'] . "%'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											id cliente_id,
										    nombre cliente_nombre
										FROM diccionario_cliente".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
            if ($data['accion'] == 'registro') {
        		$resultCliente = $sql_query->row();
        		return $resultCliente->cliente_id;
        	} else {
        		return $sql_query->result();
        	}
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('diccionario_cliente', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('diccionario_cliente', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Cliente_m.php */
/* Location: ./application/models/tasacion/Cliente_m.php */