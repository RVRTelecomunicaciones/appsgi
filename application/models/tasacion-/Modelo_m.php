<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_m extends CI_Model {

	public function modeloVehiculoReporte()
	{
		$query = $this->db->query("	SELECT
										id modelo_vehiculo_id,
										nombre modelo_vehiculo_nombre
									FROM diccionario_vehiculo_modelo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function modeloMaquinariaReporte()
	{
		$query = $this->db->query("	SELECT
										id modelo_maquinaria_id,
										nombre modelo_maquinaria_nombre
									FROM diccionario_maquinaria_modelo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file Modelo_m.php */
/* Location: ./application/models/tasacion/Modelo_m.php */