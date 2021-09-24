<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TVehiculo_m extends CI_Model {

	public function tipoVehiculoReporte()
	{
		$query = $this->db->query("	SELECT
										id tipo_vehiculo_id,
										nombre tipo_vehiculo_nombre
									FROM diccionario_vehiculo_tipo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function tipoMaquinariaReporte()
	{
		$query = $this->db->query("	SELECT
										id tipo_maquinaria_id,
										nombre tipo_maquinaria_nombre
									FROM diccionario_maquinaria_tipo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file TVehiculo_m.php */
/* Location: ./application/models/tasacion/TVehiculo_m.php */