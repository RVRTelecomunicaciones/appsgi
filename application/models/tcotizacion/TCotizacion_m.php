<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TCotizacion_m extends CI_Model {

	public function tcotizacionReporte()
	{
		$query = $this->db->query("	SELECT
										id AS cotizacion_tipo_id,
									    nombre AS cotizacion_tipo_nombre
									FROM co_cotizacion_tipo");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file TCotizacion.php */
/* Location: ./application/models/tcotizacion/TCotizacion.php */