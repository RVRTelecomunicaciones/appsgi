<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguimiento_m extends CI_Model {

	public function searchSeguimiento($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {
            if ($data['accion'] == 'cotizacion') {
                $order = " ORDER BY co_mensaje.info_create DESC";
                if (isset($data['cotizacion_id'])) {
                	if ($data['cotizacion_id'] != '' && $filters == '') {
                        $filters .= " WHERE cotizacion_id = " . $data['cotizacion_id'] . " AND co_mensaje.info_status = 1";
                    }
                }
            }
        }

        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query(" SELECT
											co_mensaje.id seguimiento_id,
										    cotizacion_id,
										    estado_id,
										    co_estado.nombre estado_nombre,
										    co_mensaje.info_create_user coordinador_id,
										    full_name coordinador_nombre,
										    mensaje seguimiento_mensaje,
										    DATE_FORMAT(co_mensaje.info_create,'%d-%m-%Y') seguimiento_fecha_creacion,
										    DATE_FORMAT(fecha_proxima,'%d-%m-%Y') seguimiento_fech_proxima
										FROM co_mensaje
										LEFT JOIN login_user ON co_mensaje.info_create_user = login_user.id
										LEFT JOIN co_estado ON co_mensaje.estado_id = co_estado.id".$filters.$order.$limit);
        
        if($sql_query->num_rows()> 0){
            return $sql_query->result();
        }
        else{
            return false;
        }
	}

	public function Insert($data)
	{
		$this->db->insert('co_mensaje', $data);
        return $this->db->insert_id();
	}

}

/* End of file Seguimiento_m.php */
/* Location: ./application/models/seguimiento/Seguimiento_m.php */