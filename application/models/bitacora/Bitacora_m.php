<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora_m extends CI_Model {

	public function search($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";    

        if (isset($data['coordinacion_codigo']) && $data['coordinacion_codigo'] != '') {
			$filters .= " WHERE coordinacion_id = ".$data['coordinacion_codigo'];
		}

        if (isset($data['action']) && $data['action'] == 'sheet') {
            $order = " ORDER BY bitacora_id DESC";
            $limit = " LIMIT 1";
        }


        $sql_query = $this->db->query(" SELECT
                                            coor_coordinacion_bitacora.id bitacora_id,
                                            usuario_id,
                                            full_name usuario_nombre,
                                            descripcion bitacora_descripcion,
                                            DATE_FORMAT(coor_coordinacion_bitacora.info_create, '%d-%m-%Y') bitacora_fecha,
                                            DATE_FORMAT(coor_coordinacion_bitacora.info_create, '%H:%i:%s') bitacora_hora
                                        FROM coor_coordinacion_bitacora
                                        INNER JOIN login_user ON coor_coordinacion_bitacora.usuario_id = login_user.id".$filters.$order.$limit);

        if (isset($data['action']) && $data['action'] == 'count') {
            return $sql_query->num_rows();
        } else {
            if($sql_query->num_rows() > 0)
                if (isset($data['action']) && $data['action'] == 'sheet')
                    return $sql_query->row();
                else
                    return $sql_query->result();
            else
                return false;
        }
	}
	
	public function insert($data)
	{
		$this->db->insert('coor_coordinacion_bitacora', $data);
		return $this->db->insert_id();
	}
}

/* End of file Bitacora_m.php */
/* Location: ./application/models/auditoria/Bitacora_m.php */