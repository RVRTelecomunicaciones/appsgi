<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TDepartamento_m extends CI_Model {

	public function tdepartamentoReporte()
	{
		$query = $this->db->query("	SELECT
										id departamento_tipo_id,
									    nombre departamento_tipo_nombre
									FROM tas_departamento_tipo");
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