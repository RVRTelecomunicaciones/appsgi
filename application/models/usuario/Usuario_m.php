<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_m extends CI_Model {

	public function searchUsuario($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

		if (isset($data['accion'])) {
			if ($data['accion'] == 'filtros') {
				$order = " ORDER BY full_name ASC";
				if (isset($data['usuario_nombre_completo'])) {
					if ($data['usuario_nombre_completo'] != '' && $filters == '') {
                        $filters .= " WHERE full_name LIKE '%" . $data['usuario_nombre_completo'] . "%'";
                    } elseif ($data['usuario_nombre_completo'] != '' && $filters != '') {
                        $filters .= " AND full_name LIKE '%" . $data['usuario_nombre_completo'] . "%'";
                    }
				} else if (isset($data['usuario_correo'])) {
					if ($data['usuario_correo'] != '' && $filters == '') {
                        $filters .= " WHERE email LIKE '%" . $data['usuario_correo'] . "%'";
                    } elseif ($data['usuario_correo'] != '' && $filters != '') {
                        $filters .= " AND email LIKE '%" . $data['usuario_correo'] . "%'";
                    }
				}
			} else if ($data['accion'] == 'validar') {
				if (isset($data['usuario_login'])) {
					if ($data['usuario_login'] != '' && $filters == '') {
                        $filters .= " WHERE login = '" . $data['usuario_login'] . "'";
                    } elseif ($data['usuario_login'] != '' && $filters != '') {
                        $filters .= " AND login = '" . $data['usuario_login'] . "'";
                    }
				}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query("	SELECT
											login_user.id usuario_id,
											full_name usuario_nombre_completo,
											login usuario_login,
											IFNULL(pass, '') usuario_pass,
											IFNULL(email, '') usuario_correo,
											area_id,
											IFNULL(login_area.nombre, '') area_descripcion,
											profile_id rol_id,
											IFNULL(login_profile.nombre, '') rol_descripcion
										FROM login_user
										LEFT JOIN login_area ON login_user.area_id = login_area.id
										LEFT JOIN login_profile ON login_user.profile_id = login_profile.id".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function login($usuario, $contraseña)
	{
		$this->db->select('id, full_name, login, pass, email, info_status');
		$this->db->from('login_user');
		$this->db->where('login', $usuario);
		$this->db->where('pass', $contraseña);
		$result = $this->db->get();

		if($result->num_rows()> 0)
            return $result->row();
        else
            return null;
	}
	
	public function ListUser(){
	    $this->db->select('id, full_name, login,email,info_status');
	    $sql_query = $this->db->get('login_user');
	    if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
	}
	
	public function getUserId($id){
	    $this->db->select('id,full_name');
	    $this->db->from('login_user');
	    $this->db->where('id', $id);
	    $result = $this->db->get();
	    
	    if($result->num_rows()> 0)
            return $result->row();
        else
            return null;
	}

	public function Insert($data)
	{
		$this->db->insert('login_user', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('login_user', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
}

/* End of file Usuario_m.php */
/* Location: ./application/models/usuario/Usuario_m.php */