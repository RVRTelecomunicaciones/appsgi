<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubigeo_m extends CI_Model {
	/*UBIGEO FINAL*/

	public function searchUbigeoDepartamento()
	{
		$order = " ORDER BY nombre ASC";

		$query = $this->db->query(" SELECT
										id departamento_id,
										lpad(id, 2, '00') departamento_ubigeo,
									    nombre departamento_nombre
									FROM ubigeo_departamento".$order);
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function searchUbigeoProvincia($data)
	{
		$filters = " WHERE departamento_id = ".$data['departamento_id'];
		$order = " ORDER BY right(ubigeo,2) ASC";

		$query = $this->db->query(" SELECT
										id provincia_id,
										right(ubigeo,2) provincia_ubigeo,
									    nombre provincia_nombre
									FROM ubigeo_provincia".$filters.$order);
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function searchUbigeoDistrito($data)
	{
		$filters = " WHERE provincia_id = ".$data['provincia_id'];
		$order = " ORDER BY right(ubigeo,2) ASC";

		$query = $this->db->query(" SELECT
										id distrito_id,
										right(ubigeo,2) distrito_ubigeo,
									    nombre distrito_nombre
									FROM ubigeo_distrito".$filters.$order);
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}
}

/* End of file Ubigeo_m.php */
/* Location: ./application/models/ubigeo/Ubigeo_m.php */