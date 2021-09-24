<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_m extends CI_Model {

	public function estadoCotizacion()
	{
		$query = $this->db->query("	SELECT
										id AS estado_id,
									    nombre AS estado_nombre
									FROM co_estado
									WHERE info_status = 1");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function estadoFacturacion()
	{
		$query = $this->db->query("	SELECT
										id estado_id,
									    nombre estado_nombre
									FROM ad_facturacion_estados
									WHERE info_status = 1");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function estadoCoordinacion()
	{
		$query = $this->db->query("	SELECT
										id estado_id,
									    nombre estado_nombre
									FROM coor_coordinacion_estado
									WHERE info_status = 1 ORDER BY orden ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file Estado_m.php */
/* Location: ./application/models/estado/Estado_m.php */