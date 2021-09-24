<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante_m extends CI_Model {

	public function comprobanteReporte()
	{
		$query = $this->db->query("SELECT * FROM ad_facturacion_tipo_comprobante WHERE estado = 1");
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file Comprobante_m.php */
/* Location: ./application/models/comprobante/Comprobante_m.php */