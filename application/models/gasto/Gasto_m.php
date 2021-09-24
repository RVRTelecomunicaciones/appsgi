<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gasto_m extends CI_Model {

	public function searchGasto($data)
	{
		$filters = "";
		$order = " ORDER BY nombre ASC";
        $limit = "";

		if (isset($data['gasto_nombre'])) {
			$filters .= " WHERE nombre LIKE '%" . $data['gasto_nombre'] . "%'";
		}

		if (isset($data['gasto_estado']) && $filters == '') {
			$filters .= " WHERE estado = " . $data['gasto_estado'];
		} elseif (isset($data['gasto_estado']) && $filters != '') {
			$filters .= " AND estado = " . $data['gasto_estado'];
		}

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query("	SELECT
											id gasto_id,
											nombre gasto_nombre,
											estado gasto_estado
										FROM ad_facturacion_gastos".$filters.$order.$limit);
        if($sql_query->num_rows() > 0) {
        	return $sql_query->result();
        }
        else
            return false;
	}

	public function searchDetalleGasto($data)
	{
		$filters = "";
		$order = "";
        $limit = "";

		if (isset($data['coordinacion_id'])) {
			$filters .= " WHERE coordinacion_id = " . $data['coordinacion_id'];
		}

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query("	SELECT
											afdg_id detalle_id,
										    coordinacion_id,
										    ad_facturacion_detalle_gastos.afg_id gasto_id,
										    ad_facturacion_gastos.nombre gasto_nombre,
										    ad_facturacion_detalle_gastos.moneda_id,
										    co_moneda.simbolo moneda_simbolo,
										    afdg_monto detalle_monto
										FROM ad_facturacion_detalle_gastos
										INNER JOIN ad_facturacion_gastos ON ad_facturacion_detalle_gastos.afg_id = ad_facturacion_gastos.id
										INNER JOIN co_moneda ON ad_facturacion_detalle_gastos.moneda_id = co_moneda.id".$filters.$order.$limit);
        if($sql_query->num_rows() > 0) {
        	return $sql_query->result();
        }
        else
            return false;
	}

	public function InsertDetalle($data)
	{
		$this->db->insert('ad_facturacion_detalle_gastos', $data);
        return $this->db->insert_id();
	}

    public function UpdateDetalle($data, $id)
    {
        $this->db->update('ad_facturacion_detalle_gastos', $data, array('afdg_id' => $id));
        return $this->db->affected_rows();
    }

    public function DeleteDetalle($id)
    {
    	$this->db->delete('ad_facturacion_detalle_gastos', array('afdg_id' => $id));
    	return $this->db->affected_rows();
    }
}

/* End of file Gasto_m.php */
/* Location: ./application/models/gasto/Gasto_m.php */