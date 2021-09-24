<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impuesto_m extends CI_Model {
    /* INSPECCION DETALLE */
    public function search($data)
    {
        $sql_query = "";
        $filters = " WHERE estado = 1";
        $order = "";
        $limit = "";

        /*if (isset($data['impuesto_estado']) && $data['impuesto_estado'] != '') {
            $filters .= " WHERE estado = ".$data['impuesto_estado'];
        }*/

        $sql_query = $this->db->query(" SELECT
                                            id impuesto_id,
                                            porcentaje impuesto_porcentaje,
                                            estado impuesto_estado
                                        FROM co_impuesto".$filters.$order.$limit);

        if (isset($data['action']) && $data['action'] == 'count') {
            return $sql_query->num_rows();
        } else {
            if($sql_query->num_rows() > 0)
                if (isset($data['action']) && $data['action'] == 'sheet')
                    return $sql_query->row();
                else
                    return $sql_query->result();
            else
                return false;
        }
    }
}

/* End of file Inspeccion_m.php */
/* Location: ./application/models/inspeccion/Inspeccion_m.php */