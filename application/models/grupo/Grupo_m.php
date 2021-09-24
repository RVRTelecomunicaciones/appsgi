<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo_m extends CI_Model {

	public function searchGrupo($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $limit = "";

        if ($search['grupo_nombre'] != '')
            $filters .= " WHERE nombre LIKE '%".$search['grupo_nombre']."%'";

        if ($search['grupo_estado'] != '' && $filters == '')
            $filters .= " WHERE info_status = ".$search['grupo_estado'];
        else if ($search['grupo_estado'] != '' && $filters != '')
        	$filters .= " AND info_status = ".$search['grupo_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query =    "SELECT
							id grupo_id,
						    nombre grupo_nombre,
						    info_status grupo_estado
						FROM co_involucrado_grupo".$filters."
						ORDER BY grupo_nombre ASC".$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function Insert($data)
    {
        $this->db->insert('co_involucrado_grupo', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('co_involucrado_grupo', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Grupo_m.php */
/* Location: ./application/models/grupo/Grupo_m.php */