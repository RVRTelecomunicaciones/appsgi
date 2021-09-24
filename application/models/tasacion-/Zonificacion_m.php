<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonificacion_m extends CI_Model {

	public function zonificacionReporte()
	{
		$query = $this->db->query("	SELECT
										id zonificacion_id,
									    nombre zonificacion_nombre,
									    detalle zonificacion_detalle
									FROM in_zonificacion
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file Zonificacion_m.php */
/* Location: ./application/models/zonificacion/Zonificacion_m.php */