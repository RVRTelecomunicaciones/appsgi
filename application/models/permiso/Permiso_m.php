<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permiso_m extends CI_Model {

	public function searchPermiso($data)
	{
        $filters = "";
		$sql_query = "";
        $order = "";

        /*if (isset($data['accion'])) {
            if ($data['accion'] == 'login') {
                $filters .= " WHERE login_permiso.id <> 0";
            }
        }*/

        $sql_query = $this->db->query("	SELECT
                                            IFNULL(login_permiso.id, 0) permiso_id,
                                            " . $data['usuario_id'] . " usuario_id,
                                            login_menu.id menu_id,
                                            tipo menu_tipo,
                                            nombre menu_descripcion,
                                            pertenece menu_pertenece,
                                            IFNULL(lectura, 0) permiso_lectura,
                                            IFNULL(escritura, 0) permiso_escritura,
                                            IFNULL((SELECT lp.lectura FROM login_permiso lp WHERE menu_id = login_menu.pertenece AND usuario_id =" . $data['usuario_id'] . "), 0) principal,
                                            '' permiso_accion
                                        FROM login_menu
                                        LEFT JOIN login_permiso ON login_menu.id = login_permiso.menu_id AND usuario_id = " . $data['usuario_id'] . $filters . " ORDER BY orden ASC");
        if($sql_query->num_rows() > 0)
           return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('login_permiso', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('login_permiso', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    
    public function Delete($id)
	{
        /*$this->db->delete('login_permiso', array('id' => $id));
        return $this->db->affected_rows();*/
        if ($this->db->delete('login_permiso', array('id' => $id)))
            return 1;
        else
            return 0;
	}
}

/* End of file area_m.php */
/* Location: ./application/models/usuario/area_m.php */