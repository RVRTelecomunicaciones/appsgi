<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TCambio_m extends CI_Model {
	
	public function searchTCambio($data)
	{
		$sql_query = "";
		$filters = "";
		$order = "";
        $limit = "";

        if (isset($data['accion'])) {

			if ($data['accion'] == 'filtros') {
				$filters .= " WHERE info_status = 1";

				$order = " ORDER BY nombre ASC";
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query("	SELECT
											id tipo_cambio_id,
										    nombre tipo_cambio_nombre
										FROM coor_coordinacion_tipo_cambio".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
	}
}

/* End of file TCambio_m.php */
/* Location: ./application/models/tcambio/TCambio_m.php */