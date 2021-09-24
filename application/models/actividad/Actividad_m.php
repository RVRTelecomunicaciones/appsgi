<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad_m extends CI_Model {

	public function searchActividad($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $limit = "";

        if ($search['actividad_nombre'] != '')
            $filters .= " WHERE nombre LIKE '%".$search['actividad_nombre']."%'";

        if ($search['actividad_estado'] != '' && $filters == '')
            $filters .= " WHERE info_status = ".$search['actividad_estado'];
        else if ($search['actividad_estado'] != '' && $filters != '')
        	$filters .= " AND info_status = ".$search['actividad_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query =    "SELECT
							id actividad_id,
						    nombre actividad_nombre,
						    info_status actividad_estado
						FROM co_involucrado_actividad".$filters."
						ORDER BY actividad_nombre ASC".$limit.";";

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
        $this->db->insert('co_involucrado_actividad', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('co_involucrado_actividad', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Actividad_m.php */
/* Location: ./application/models/actividad/Actividad_m.php */