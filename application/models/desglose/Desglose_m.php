<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desglose_m extends CI_Model {

	public function desgloseReporte()
	{
		$query = $this->db->query("	SELECT
										id desglose_id,
									    nombre desglose_nombre
									FROM co_desglose");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file Desgloce_m.php */
/* Location: ./application/models/desgloce/Desgloce_m.php */