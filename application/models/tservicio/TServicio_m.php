<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TServicio_m extends CI_Model {
    
    public function servicioTipoReporte()
    {
        $query = $this->db->query(" SELECT
                                        id servicio_tipo_id,
                                        nombre servicio_tipo_nombre,
                                        info_status servicio_tipo_estado
                                    FROM co_servicio_tipo
                                    ORDER BY servicio_tipo_nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }

	public function searchTServicio($data)
    {
        $sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {
            if ($data['accion'] == 'filtros') {
                $order = " ORDER BY servicio_tipo_nombre ASC";
                if (isset($data['servicio_tipo_id'])) {
                    if ($data['servicio_tipo_id'] != '' && $filters == '') {
                        $filters .= " WHERE id = " . $data['servicio_tipo_id'];
                    }
                }

                if (isset($data['servicio_tipo_nombre'])) {
                    if ($data['servicio_tipo_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['servicio_tipo_nombre'] . "%'";
                    } elseif ($data['servicio_tipo_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['servicio_tipo_nombre'] . "%'";
                    }
                }

                if (isset($data['servicio_tipo_estado'])) {
                    if ($data['servicio_tipo_estado'] != '' && $filters == '') {
                        $filters .= " WHERE info_status = " . $data['servicio_tipo_estado'];
                    } elseif ($data['servicio_tipo_estado'] != '' && $filters != '') {
                        $filters .= " AND info_status = " . $data['servicio_tipo_estado'];
                    }
                }
            }
        }

        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query(" SELECT
                                            id servicio_tipo_id,
                                            nombre servicio_tipo_nombre,
                                            info_status servicio_tipo_estado
                                        FROM co_servicio_tipo".$filters.$order.$limit);
        
        if($sql_query->num_rows()> 0){
            return $sql_query->result();
        }
        else{
            return false;
        }
    }

    public function Insert($data)
    {
        $this->db->insert('co_servicio_tipo', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('co_servicio_tipo', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file TServicio_m.php */
/* Location: ./application/models/tservicio/TServicio_m.php */