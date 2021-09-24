<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca_m extends CI_Model {

	public function marcaVehiculoReporte()
	{
		$query = $this->db->query("	SELECT
										id marca_vehiculo_id,
										nombre marca_vehiculo_nombre
									FROM diccionario_vehiculo_marca
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function marcaMaquinariaReporte()
	{
		$query = $this->db->query("	SELECT
										id marca_maquinaria_id,
										nombre marca_maquinaria_nombre
									FROM diccionario_maquinaria_marca
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file Marca_m.php */
/* Location: ./application/models/tasacion/Marca_m.php */