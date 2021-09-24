<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traccion_m extends CI_Model {

	public function traccionVehiculoReporte()
	{
		$query = $this->db->query("	SELECT
										id traccion_vehiculo_id,
										nombre traccion_vehiculo_nombre
									FROM diccionario_vehiculo_traccion
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file Traccion_m.php */
/* Location: ./application/models/tasacion/Traccion_m.php */