<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cultivo_m extends CI_Model {

	public function cultivoReporte()
	{
		$query = $this->db->query("	SELECT
										id terreno_tipo_id,
									    nombre terreno_tipo_nombre
									FROM tas_terreno_tipo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file Cultivo_m.php */
/* Location: ./application/models/cultivo/Cultivo_m.php */