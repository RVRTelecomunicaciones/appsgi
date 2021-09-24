<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perito_m extends CI_Model {

	public function searchPerito($data)
	{
		$filters = "";
		$order = " ORDER BY perito_nombre ASC";
        $limit = "";

        if (isset($data['accion'])) {

        	if ($data['accion'] == 'filtros') {

        		if (isset($data['perito_nombre'])) {

        			if ($data['perito_nombre'] != '') {
        				$filters .= " AND full_name LIKE '%".$data['perito_nombre']."%'";
        			}
        		}

        		if (isset($data['perito_estado'])) {
       				if ($data['perito_estado'] != '') {
	       				$filters .= " AND coor_rol_has_user.info_status = ".$data['perito_estado'];
	       			}
       			}
        	}
        }

        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

		$query = $this->db->query(" SELECT
                                        user_id perito_id,
                                        full_name perito_nombre,
                                        coor_rol_has_user.info_status perito_estado
                                    FROM coor_rol_has_user
                                    JOIN login_user ON coor_rol_has_user.user_id = login_user.id
                                    JOIN coor_rol ON coor_rol_has_user.rol_id = coor_rol.id
                                    WHERE coor_rol.id = 1".$filters.$order.$limit);
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    
    public function search($data)
    {
        $sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['perito_codigo']) && $data['perito_codigo'] != '') {
            $filters .= " AND login_user.id = ".$data['perito_codigo'];
        }

        if (isset($data['perito_nombre']) && $data['perito_nombre'] != '') {
            $filters .= " AND full_name LIKE '%".$data['perito_nombre']."%'";
        }

        if (isset($data['perito_estado']) && $data['perito_estado'] != '') {
            $filters .= " AND coor_rol_has_user.info_status = ".$data['perito_estado'];
        }

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            user_id perito_id,
                                            full_name perito_nombre,
                                            coor_rol_has_user.info_status perito_estado
                                        FROM coor_rol_has_user
                                        JOIN login_user ON coor_rol_has_user.user_id = login_user.id
                                        JOIN coor_rol ON coor_rol_has_user.rol_id = coor_rol.id
                                        WHERE coor_rol.id = 1".$filters.$order.$limit);

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

/* End of file Perito_m.php */
/* Location: ./application/models/perito/Perito_m.php */