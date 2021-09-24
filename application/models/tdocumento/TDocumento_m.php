<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TDocumento_m extends CI_Model {

	public function search($data)
	{
		$sql_query = "";
        $filters = " WHERE info_status = 1";
        $order = "";
        $limit = "";

        /*if (isset($data['control_calidad_codigo']) && $data['control_calidad_codigo'] != '') {
            $filters .= " AND login_user.id = ".$data['control_calidad_codigo'];
        }*/

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
											id documento_tipo_id,
										    nombre documento_tipo_nombre,
										    abreviatura documento_tipo_abreviatura
										FROM co_involucrado_documento_tipo".$filters.$order.$limit);

        if (isset($data['accion']) && $data['accion'] == 'count') {
            return $sql_query->num_rows();
        } else {
            if($sql_query->num_rows() > 0)
                if (isset($data['accion']) && $data['accion'] == 'sheet')
                    return $sql_query->row();
                else
                    return $sql_query->result();
            else
                return false;
        }
	}
}

/* End of file TDocumento_m.php */
/* Location: ./application/models/tdocumento/TDocumento_m.php */