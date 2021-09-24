<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinador_m extends CI_Model {

	public function coordinadorSearch($data)
	{
        $filters = "";
		$order = " ORDER BY coordinador_nombre ASC";
        $limit = "";

        if (isset($data['accion'])) {

        	if ($data['accion'] == 'filtros') {

        		if (isset($data['coordinador_nombre'])) {

        			if ($data['coordinador_nombre'] != '') {
        				$filters .= " AND full_name LIKE '%".$data['coordinador_nombre']."%'";
        			}
        		}

        		if (isset($data['coordinador_estado'])) {
       				if ($data['coordinador_estado'] != '') {
	       				$filters .= " AND login_user_has_profile.info_status = 1";
	       			}
       			}
        	}
        }

        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

		$query = $this->db->query(" SELECT
										user_id AS coordinador_id,
									    full_name AS coordinador_nombre,
										login_user_has_profile.info_status AS coordinador_estado
									FROM login_user_has_profile
									LEFT JOIN login_user ON login_user_has_profile.user_id = login_user.id
									WHERE login_user_has_profile.profile_id = 2".$filters.$order.$limit);
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file Coordinador_m.php */
/* Location: ./application/models/coordinador/Coordinador_m.php */