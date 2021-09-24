<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendedor_m extends CI_Model {

	public function vendedorReporte()
	{
		$query = $this->db->query("	SELECT
										id as vendedor_id,
									    nombre as vendedor_nombre,
									    telefono as vendedor_telefono,
									    correo as vendedor_correo,
									    info_status as vendedor_estado
									FROM co_vendedor
									ORDER BY vendedor_nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file Vendedor_m.php */
/* Location: ./application/models/vendedor/Vendedor_m.php */