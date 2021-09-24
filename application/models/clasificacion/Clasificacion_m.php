<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clasificacion_m extends CI_Model {

	public function searchClasificacion($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $limit = "";

        if ($search['clasificacion_nombre'] != '')
            $filters .= " WHERE nombre LIKE '%".$search['clasificacion_nombre']."%'";

        if ($search['clasificacion_estado'] != '' && $filters == '')
            $filters .= " WHERE info_status = ".$search['clasificacion_estado'];
        else if ($search['clasificacion_estado'] != '' && $filters != '')
        	$filters .= " AND info_status = ".$search['clasificacion_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query =    "SELECT
							id clasificacion_id,
						    nombre clasificacion_nombre,
						    info_status clasificacion_estado
						FROM co_involucrado_clasificacion".$filters."
						ORDER BY clasificacion_nombre ASC".$limit.";";

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
        $this->db->insert('co_involucrado_clasificacion', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('co_involucrado_clasificacion', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Clasificacion_m.php */
/* Location: ./application/models/clasficacion/Clasificacion_m.php */