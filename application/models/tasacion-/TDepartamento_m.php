<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TDepartamento_m extends CI_Model {

	public function tdepartamentoReporte()
	{
		$query = $this->db->query("	SELECT
										id tipo_departamento_id,
									    nombre tipo_departamento_nombre
									FROM diccionario_departamento_tipo
									ORDER BY nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

}

/* End of file TDepartamento_m.php */
/* Location: ./application/models/tdepartamento/TDepartamento_m.php */