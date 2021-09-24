<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TLocal_m extends CI_Model {

	public function tlocalReporte()
	{
		$query = $this->db->query("	SELECT
										id local_tipo_id,
									    nombre local_tipo_nombre
									FROM tas_local_tipo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file TLocal.php */
/* Location: ./application/models/tasacion/TLocal.php */