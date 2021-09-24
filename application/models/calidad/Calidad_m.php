<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calidad_m extends CI_Model {

	public function searchControlCalidad($data)
	{
		$filters = "";
		$order = " ORDER BY control_calidad_nombre ASC";
        $limit = "";

        if (isset($data['accion'])) {

        	if ($data['accion'] == 'filtros') {

        		if (isset($data['control_calidad_nombre'])) {

        			if ($data['control_calidad_nombre'] != '') {
        				$filters .= " AND full_name LIKE '%".$data['control_calidad_nombre']."%'";
        			}
        		}

        		if (isset($data['control_calidad_estado'])) {
       				if ($data['control_calidad_estado'] != '') {
	       				$filters .= " AND coor_rol_has_user.info_status = ".$data['control_calidad_estado'];
	       			}
       			}
        	}
        }

        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

		$query = $this->db->query(" SELECT
                                        user_id AS control_calidad_id,
                                        full_name AS control_calidad_nombre,
                                        coor_rol_has_user.info_status AS control_calidad_estado
                                    FROM coor_rol_has_user
                                    JOIN login_user ON coor_rol_has_user.user_id = login_user.id
                                    JOIN coor_rol ON coor_rol_has_user.rol_id = coor_rol.id
                                    WHERE coor_rol.id = 2".$filters.$order.$limit);
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

        if (isset($data['control_calidad_codigo']) && $data['control_calidad_codigo'] != '') {
            $filters .= " AND login_user.id = ".$data['control_calidad_codigo'];
        }

        if (isset($data['control_calidad_nombre']) && $data['control_calidad_nombre'] != '') {
            $filters .= " AND full_name LIKE '%".$data['control_calidad_nombre']."%'";
        }

        if (isset($data['control_calidad_estado']) && $data['control_calidad_estado'] != '') {
            $filters .= " AND coor_rol_has_user.info_status = ".$data['control_calidad_estado'];
        }

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            user_id control_calidad_id,
                                            full_name control_calidad_nombre,
                                            coor_rol_has_user.info_status control_calidad_estado
                                        FROM coor_rol_has_user
                                        JOIN login_user ON coor_rol_has_user.user_id = login_user.id
                                        JOIN coor_rol ON coor_rol_has_user.rol_id = coor_rol.id
                                        WHERE coor_rol.id = 2".$filters.$order.$limit);

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

/* End of file CCalidad_m.php */
/* Location: ./application/models/control-calidad/CCalidad_m.php */