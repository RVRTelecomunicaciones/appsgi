<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proceso_m extends CI_Model {

    public function search($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY coor_proceso_operaciones.id ASC";

        if (isset($data['proceso_coordinacion']) && $data['proceso_coordinacion'] != '') {
            $filters .= " WHERE coordinacion_id = ".$data['proceso_coordinacion'];
        }

        if (isset($data['proceso_estado']) && $data['proceso_estado'] != '') {
            if ($filters == "") {
                $filters .= " WHERE coor_proceso_operaciones.estado_id = ".$data['proceso_estado'];
            } else {
                $filters .= " AND coor_proceso_operaciones.estado_id = ".$data['proceso_estado'];
            }
        }

        $sql_query = $this->db->query(" SELECT
                                            coor_proceso_operaciones.id proceso_id,
                                            IF(enviado_de = 1, 'PERITO', IF(enviado_de = 2, 'CONTROL DE CALIDAD', IF(enviado_de = 3, 'AUDITOR', ''))) proceso_enviado_de,
                                            IF(enviado_a = 1, 'PERITO', IF(enviado_a = 2, 'CONTROL DE CALIDAD', IF(enviado_a = 3, 'AUDITOR', ''))) proceso_enviado_a,
                                            IFNULL(full_name, '') usuario_nombre,
                                            observacion proceso_observacion,
                                            DATE_FORMAT(fecha_inicio, '%d-%m-%Y') proceso_fecha_inicio,
                                            DATE_FORMAT(fecha_inicio, '%H:%i:%s') proceso_fecha_inicio_hora,
                                            DATE_FORMAT(fecha_final, '%d-%m-%Y') proceso_fecha_final,
                                            DATE_FORMAT(fecha_final, '%H:%i:%s') proceso_fecha_final_hora,
                                            coor_proceso_operaciones.estado_id,
                                            coor_proceso_operaciones_estado.nombre estado_nombre
                                        FROM coor_proceso_operaciones
                                        LEFT JOIN login_user ON coor_proceso_operaciones.usuario_id = login_user.id
                                        INNER JOIN coor_proceso_operaciones_estado ON coor_proceso_operaciones.estado_id = coor_proceso_operaciones_estado.id".$filters.$order);

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

	public function insert($data)
	{
        $this->db->insert('coor_proceso_operaciones', $data);
        return $this->db->insert_id();
	}

	public function update($data, $id)
	{
        $this->db->update('coor_coordinacion', $data['coordinacion'], $id['coordinacion']);
        $this->db->update('coor_proceso_operaciones', $data['proceso'], $id['proceso']);
        return $this->db->affected_rows();
        
	}
}

/* End of file Proceso_m.php */
/* Location: ./application/models/proceso/Proceso_m.php */