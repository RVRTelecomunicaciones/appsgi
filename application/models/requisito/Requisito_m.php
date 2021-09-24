<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisito_m extends CI_Model {

	public function searchRequisito($data)
	{
		$filters = "";
        $limit = "";

		if (isset($data['servicio_tipo_id']))
            $filters .= " WHERE servicio_tipo_id in (".$data['servicio_tipo_id'].")";

        if (isset($data['nombre']) && $filters == "")
        	$filters .= " WHERE co_requisito.nombre LIKE '%".$data['nombre']."%'";
        else if (isset($data['nombre']) && $filters != '')
        	$filters .= " AND co_requisito.nombre LIKE '%".$data['nombre']."%'";

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT " . $data['init'].",".$data['quantity'];


		$sql_query = $this->db->query(" SELECT
                                            co_requisito_detalle.id,
                                            /*cotizacion_id,
                                            requisito_id,*/
                                            co_requisito.nombre
                                        FROM co_requisito_detalle
                                        INNER JOIN co_requisito ON co_requisito_detalle.requisito_id = co_requisito.id".$filters.$limit);
        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
	}
}

/* End of file Requisito_m.php */
/* Location: ./application/models/requisito/Requisito_m.php */