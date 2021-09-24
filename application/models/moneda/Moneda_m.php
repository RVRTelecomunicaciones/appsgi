<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moneda_m extends CI_Model {

	public function monedaReporte()
	{
		$query = $this->db->query("	SELECT
										id moneda_id,
									    nombre moneda_nombre,
									    simbolo moneda_simbolo,
									    codigo_sunat moneda_abreviatura,
									    monto moneda_monto
									FROM co_moneda");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file Moneda_m.php */
/* Location: ./application/models/moneda/Moneda_m.php */