<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auditoria_m extends CI_Model {

	public function search($data)
	{
		$sql_query = "";
        $filters = "";
        $order = isset($data['action']) && $data['action'] == 'sheet' ? " ORDER BY aut_id DESC" : "";
        $limit = isset($data['action']) && $data['action'] == 'sheet' ? " LIMIT 1" : "";

        if (isset($data['coordinacion_codigo']) && $data['coordinacion_codigo'] != '') {
			$filters .= " WHERE aut_coor_id = ".$data['coordinacion_codigo'];
		}

		if (isset($data['coordinacion_correlativo']) && $data['coordinacion_correlativo'] != '') {
			$filters .= " WHERE aut_coor_id = ".$data['coordinacion_correlativo'];
		}

		if (isset($data['coordinacion_estado']) && $data['coordinacion_estado'] != '') {
			$filters .= " AND aut_coor_est in (".$data['coordinacion_estado'].")";
		}
		
		if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
											aut_id auditoria_id,
											aut_coor_id coordinacion_id,
											cotizacion_correlativo coordinacion_correlativo,
											aut_usu_id usuario_id,
											login_user.full_name usuario_nombre,
											aut_coor_est estado_id,
											coor_coordinacion_estado.nombre estado_nombre,
                                            DATE_FORMAT(auditoria_coordinacion.aut_coor_fecha, '%d-%m-%Y') auditoria_fecha
										FROM auditoria_coordinacion
										INNER JOIN coor_coordinacion ON auditoria_coordinacion.aut_coor_id = coor_coordinacion.id
										INNER JOIN login_user ON auditoria_coordinacion.aut_usu_id = login_user.id
										INNER JOIN coor_coordinacion_estado ON auditoria_coordinacion.aut_coor_est = coor_coordinacion_estado.id".$filters.$order.$limit);

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
	
	public function searchAuditoriaCoordinacion($data)
	{
		$sql_query = "";
		$filters = "";
		$order = "";
        $limit = " LIMIT 1";

        if (isset($data['accion'])) {
			if($data['accion'] == 'filtros') {
				$order .= " ORDER BY aut_id DESC";

				if (isset($data['coordinacion_id'])) {
	       			if ($data['coordinacion_id'] != '' && $filters == '') {
	       				$filters .= " WHERE aut_coor_id = ".$data['coordinacion_id'];
	       			}  elseif ($data['coordinacion_id'] != '' && $filters != '') {
	       				$filters .= " AND aut_coor_id = " . $data['coordinacion_id'];
	       			}
	       		}
			}
		}

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query( "SELECT
											*
										FROM auditoria_coordinacion".$filters.$order.$limit);
        if($sql_query->num_rows() > 0) {
            return $sql_query->row();
        } else
            return false;
	}

	public function searchAuditoriaReprocesos($data)
	{
		$sql_query = "";
		$filters = "";
		$filters_inspeccion = "";
		$filters_detalle = "";
        $order = " ORDER BY coordinacion_correlativo DESC";
        $limit = "";

        if (isset($data['coordinacion_correlativo']) && $data['coordinacion_correlativo'] != '') {
            $filters .= " AND cotizacion_correlativo = ".$data['coordinacion_correlativo'];
		}

		if (isset($data['coordinacion_estado']) && $data['coordinacion_estado'] != '') {
            $filters .= " AND coor_coordinacion.estado_id in (".$data['coordinacion_estado'].")";
		}
		
		if (isset($data['coordinacion_solicitante']) && $data['coordinacion_solicitante'] != '') {
            $filters .= " AND IFNULL((CASE
										WHEN solicitante_persona_tipo = 'Juridica' THEN
											(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
										ELSE
											(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
									END),'') LIKE '%".$data['coordinacion_solicitante']."%'";
		}

		if (isset($data['coordinacion_cliente']) && $data['coordinacion_cliente'] != '') {
            $filters .= " AND IFNULL((CASE
										WHEN cliente_persona_tipo = 'Juridica' THEN
											(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
										ELSE
											(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
									END),'') LIKE '%".$data['coordinacion_cliente']."%'";
		}

		if (isset($data['coordinacion_servicio_tipo']) && $data['coordinacion_servicio_tipo'] != '') {
            $filters .= " AND (SELECT
									GROUP_CONCAT(
										servicio_tipo_id
										SEPARATOR ','
									) campo
								FROM co_cotizacion_servicio_tipo_detalle
								WHERE cotizacion_id = co_cotizacion.id) in (".$data['coordinacion_servicio_tipo'].")";
		}

		if (isset($data['coordinacion_direccion']) && $data['coordinacion_direccion'] != '') {
			$filters_inspeccion .= " AND direccion LIKE '%".$data['coordinacion_direccion']."%'";

			if ($filters_detalle == "") {
				$filters_detalle .= " AND (SELECT COUNT(*) FROM coor_inspeccion_detalle
											INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
											WHERE coordinacion_id = coor_coordinacion.id".$filters_inspeccion.") > 0";
			}
		}

		if (isset($data['coordinacion_perito']) && $data['coordinacion_perito'] != '') {
			$filters_inspeccion .= " AND perito_id = ".$data['coordinacion_perito'];
			if ($filters_detalle == "") {
				$filters_detalle .= " AND (SELECT COUNT(*) FROM coor_inspeccion_detalle
											INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
											WHERE coordinacion_id = coor_coordinacion.id".$filters_inspeccion.") > 0";
			}
		}

		if (isset($data['coordinacion_digitador']) && $data['coordinacion_digitador'] != '') {
            $filters .= " AND digitador_id = ".$data['coordinacion_digitador'];
		}

		if (isset($data['coordinacion_control_calidad']) && $data['coordinacion_control_calidad'] != '') {
            $filters .= " AND control_calidad_id = ".$data['coordinacion_control_calidad'];
		}
		
		if (isset($data['coordinacion_coordinador']) && $data['coordinacion_coordinador'] != '') {
            $filters .= " AND coordinador_id = ".$data['coordinacion_coordinador'];
		}
		
		if (isset($data['coordinacion_riesgo']) && $data['coordinacion_riesgo'] != '') {
            $filters .= " AND riesgo_id = ".$data['coordinacion_riesgo'];
		}

		if (isset($data['coordinacion_fecha_tipo']) && $data['coordinacion_fecha_tipo'] != '') {
			switch ($data['coordinacion_fecha_tipo']) {
				case '1':
					$filters .= " AND IF(entrega_al_cliente_fecha_nueva = '0000-00-00 00:00:00', entrega_al_cliente_fecha, entrega_al_cliente_fecha_nueva) BETWEEN '".$data['coordinacion_fecha_desde']."' AND '".$data['coordinacion_fecha_hasta']."'";
					break;
				case '2':
					$filters_inspeccion .= " AND fecha BETWEEN '".$data['coordinacion_fecha_desde']."' AND '".$data['coordinacion_fecha_hasta']."'";
					if ($filters_detalle == "") {
						$filters_detalle .= " AND (SELECT COUNT(*) FROM coor_inspeccion_detalle
													INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
													WHERE coordinacion_id = coor_coordinacion.id".$filters_inspeccion.") > 0";
					}
					break;
				case '3':
					if ($data['coordinacion_fecha_desde'] != '' && $data['coordinacion_fecha_hasta'] != '') {
						$filters .= " AND date_format(coor_coordinacion.info_create, '%Y-%m-%d') BETWEEN '".$data['coordinacion_fecha_desde']."' AND '".$data['coordinacion_fecha_hasta']."'";
					}
				case '4':
					if ($data['coordinacion_fecha_desde'] != '' && $data['coordinacion_fecha_hasta'] != '') {
						$filters .= " AND date_format(auditoria_estado_coordinacion.info_create, '%Y-%m-%d') BETWEEN '".$data['coordinacion_fecha_desde']."' AND '".$data['coordinacion_fecha_hasta']."'";
					}
				default:
					break;
			}
		}

		if (isset($data['order']) && $data['order'] != '') {
			if ($data['order'] == 'coordinacion') {
				$order = " ORDER BY coordinacion_correlativo ".$data['order_type'];
			} else if ($data['order'] == 'estado') {
				$order = " ORDER BY estado_nombre ".$data['order_type'];
			} else if ($data['order'] == 'solicitante') {
				$order = " ORDER BY solicitante_nombre ".$data['order_type'];
			} else if ($data['order'] == 'cliente') {
				$order = " ORDER BY cliente_nombre ".$data['order_type'];
			} else if ($data['order'] == 'tipo_servicio') {
				$order = " ORDER BY servicio_tipo_nombre ".$data['order_type'];
			} else if ($data['order'] == 'digitador') {
				$order = " ORDER BY digitador_nombre ".$data['order_type'];
			} else if ($data['order'] == 'control_calidad') {
				$order = " ORDER BY control_calidad_nombre ".$data['order_type'];
			} else if ($data['order'] == 'coordinador') {
				$order = " ORDER BY coordinador_nombre ".$data['order_type'];
			} else if ($data['order'] == 'fecha_entrega') {
				$order = " ORDER BY IF(entrega_al_cliente_fecha_nueva = '0000-00-00 00:00:00', entrega_al_cliente_fecha, entrega_al_cliente_fecha_nueva) ".$data['order_type'];
			} else if ($data['order'] == 'riesgo') {
				$order = " ORDER BY riesgo_nombre ".$data['order_type'];
			} else if ($data['order'] == 'fecha_creacion') {
				$order = " ORDER BY date_format(coor_coordinacion.info_create, '%d-%m-%Y') ".$data['order_type'];
			}
		}

        $sql_query = $this->db->query(" SELECT
											cotizacion_correlativo coordinacion_correlativo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') solicitante_nombre,
											IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') cliente_nombre,
											motivo_id,
											auditoria_estado_coordinacion.info_status
										FROM auditoria_estado_coordinacion
										INNER JOIN coor_coordinacion_motivo ON auditoria_estado_coordinacion.motivo_id = coor_coordinacion_motivo.id
										INNER JOIN coor_coordinacion ON auditoria_estado_coordinacion.coordinacion_id = coor_coordinacion.id
										WHERE coor_coordinacion.info_status = 1".$filters.$order.$limit);

		if (isset($data['action']) && $data['action'] == 'count') {
			return $sql_query->num_rows();
		} else {
			if($sql_query->num_rows() > 0)
				if (isset($data['action']) && $data['action'] == 'maintenance')
					return $sql_query->row();
				else
					return $sql_query->result();
					//return $this->db->last_query();
			else
				return false;
				//return $this->db->last_query();
		}
	}
	
	public function insertCoordinacion($data)
	{
		$this->db->insert('auditoria_coordinacion', $data);
		return $this->db->affected_rows();
	}
	public function insertAuditoriaEstado($data)
	{
		$this->db->insert('auditoria_estado_coordinacion', $data);
		return $this->db->affected_rows();
	}

	public function insertFacturaion($data)
	{
		$this->db->insert('auditoria_facturacion', $data);
		return $this->db->affected_rows();
	}
}

/* End of file Auditoria_m.php */
/* Location: ./application/models/auditoria/Auditoria_m.php */