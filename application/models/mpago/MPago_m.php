<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MPago_m extends CI_Model {

	public function medioPagoReporte()
	{
		$query = $this->db->query("	SELECT
										id medio_id,
										codigo_sunat medio_codigo_sunat,
									    abreviatura medio_abreviatura,
									    descripcion medio_descripcion,
									    estado medio_estado
									FROM ad_facturacion_medio_pago
									WHERE estado = 1");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file MPago_m.php */
/* Location: ./application/models/mpago/MPago_m.php */