<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinacion_m extends CI_Model {

	public function countCoordinaciones()
	{
		return $data = array(
								'coordinar' => $this->search(array('action' => 'count', 'coordinacion_estado' => 6)),
								'inspeccion' => $this->search(array('action' => 'count', 'coordinacion_estado' => 1)),
								'elaboracion' => $this->search(array('action' => 'count', 'coordinacion_estado' => 7)),
								'espera' => $this->search(array('action' => 'count', 'coordinacion_estado' => 2)),
								'terminado' => $this->search(array('action' => 'count', 'coordinacion_estado' => 4)),
								'reproceso' => $this->search(array('action' => 'count', 'coordinacion_estado' => 8))
							);
	}

	public function searchCoordinacion($data)
	{
		$sql_query = "";
		$filters = "";
		$order = "";
        $limit = "";

        if (isset($data['accion'])) {
			if($data['accion'] == 'cotizacion') {
				$filters .= " WHERE coor_coordinacion.cotizacion_id = ".$data['cotizacion_id']." AND coor_coordinacion.info_status = 1";
				$order .= " ORDER BY coordinacion_correlativo ASC";
			} elseif($data['accion'] == 'generar_pdf') {
				$filters .= " WHERE coor_coordinacion.id = ".$data['coordinacion_id'];
			} elseif($data['accion'] == 'filtros') {
				$filters .= " WHERE coor_coordinacion.info_status = 1";
				$order .= " ORDER BY coordinacion_correlativo DESC";

				if (isset($data['coordinacion_correlativo'])) {
	       			if ($data['coordinacion_correlativo'] != '' && $filters == '') {
	       				$filters .= " WHERE cotizacion_correlativo = ".$data['coordinacion_correlativo'];
	       			}  elseif ($data['coordinacion_correlativo'] != '' && $filters != '') {
	       				$filters .= " AND cotizacion_correlativo = " . $data['coordinacion_correlativo'];
	       			}
	       		}

	       		if (isset($data['estado_id'])) {
	       			if ($data['estado_id'] != '' && $filters == '') {
	       				$filters .= " WHERE coor_coordinacion.estado_id = " . $data['estado_id'];
	       			} elseif ($data['estado_id'] != '' && $filters != '') {
	       				$filters .= " AND coor_coordinacion.estado_id = " . $data['estado_id'];
	       			}
	       		}

	       		if (isset($data['solicitante_nombre'])) {
	       			/*if ($data['solicitante_nombre'] != '' && $filters == '') {
	       				$filters .= " WHERE IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
											END),'') LIKE '%" . $data['solicitante_nombre'] . "%'";
	       			} elseif ($data['solicitante_nombre'] != '' && $filters != '') {
	       				$filters .= " AND IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
											END),'') LIKE '%" . $data['solicitante_nombre'] . "%'";
					}*/
					   
					if ($data['solicitante_nombre'] != '' && $filters == '') {
						$filters .= " WHERE IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') LIKE '%" . $data['solicitante_nombre'] . "%'";
					} elseif ($data['solicitante_nombre'] != '' && $filters != '') {
						$filters .= " AND IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') LIKE '%" . $data['solicitante_nombre'] . "%'";
					}
	       		}

	       		if (isset($data['cliente_nombre'])) {
	       			/*if ($data['cliente_nombre'] != '' && $filters == '') {
	       				$filters .= " WHERE IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
											END),'') LIKE '%" . $data['cliente_nombre'] . "%'";
	       			} elseif ($data['cliente_nombre'] != '' && $filters != '') {
	       				$filters .= " AND IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
											END),'') LIKE '%" . $data['cliente_nombre'] . "%'";
					}*/
					   
					if ($data['cliente_nombre'] != '' && $filters == '') {
						$filters .= " WHERE IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') LIKE '%" . $data['cliente_nombre'] . "%'";
					} elseif ($data['cliente_nombre'] != '' && $filters != '') {
						$filters .= " AND IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') LIKE '%" . $data['cliente_nombre'] . "%'";
					}
	       		}

	       		if (isset($data['servicio_tipo_id'])) {
					if ($data['servicio_tipo_id'] != '' && $filters == '') {
	       				$filters .= " WHERE (SELECT
												GROUP_CONCAT(
													servicio_tipo_id
													SEPARATOR ','
												) campo
											FROM co_cotizacion_servicio_tipo_detalle
											WHERE cotizacion_id = co_cotizacion.id) in (".$data['servicio_tipo_id'].")";
	       			} elseif ($data['servicio_tipo_id'] != '' && $filters != '') {
	       				$filters .= " AND (SELECT
												GROUP_CONCAT(
													servicio_tipo_id
													SEPARATOR ','
												) campo
											FROM co_cotizacion_servicio_tipo_detalle
											WHERE cotizacion_id = co_cotizacion.id) in (".$data['servicio_tipo_id'].")";
	       			}
				}

	       		if (isset($data['coordinacion_ubicacion'])) {
	       			if ($data['coordinacion_ubicacion'] != '' && $filters == '') {
	       				$filters .= " WHERE CONCAT(
	       										coor_inspeccion.direccion,' ',
	       										CONVERT(ubigeo_departamento.nombre, CHAR),' ',
	       										CONVERT(ubigeo_provincia.nombre, CHAR),' ',
	       										CONVERT(ubigeo_distrito.nombre, CHAR)) LIKE '%" . $data['coordinacion_ubicacion'] . "%'";
	       			} elseif ($data['coordinacion_ubicacion'] != '' && $filters != '') {
	       				$filters .= " AND CONCAT(
	       										coor_inspeccion.direccion,' ',
	       										CONVERT(ubigeo_departamento.nombre, CHAR),' ',
	       										CONVERT(ubigeo_provincia.nombre, CHAR),' ',
	       										CONVERT(ubigeo_distrito.nombre, CHAR)) LIKE '%" . $data['coordinacion_ubicacion'] . "%'";
	       			}
	       		}

	       		if (isset($data['perito_id'])) {
	       			if ($data['perito_id'] != '' && $filters == '') {
	       				$filters .= " WHERE coor_inspeccion.perito_id = " . $data['perito_id'];
	       			} elseif ($data['perito_id'] != '' && $filters != '') {
	       				$filters .= " AND coor_inspeccion.perito_id = " . $data['perito_id'];
	       			}
	       		}

	       		if (isset($data['control_calidad_id'])) {
	       			if ($data['control_calidad_id'] != '' && $filters == '') {
	       				$filters .= " WHERE inspector_id = " . $data['control_calidad_id'];
	       			} elseif ($data['control_calidad_id'] != '' && $filters != '') {
	       				$filters .= " AND inspector_id = " . $data['control_calidad_id'];
	       			}
	       		}

	       		if (isset($data['coordinador_id'])) {
	       			if ($data['coordinador_id'] != '' && $filters == '') {
	       				$filters .= " WHERE coordinador_id = " . $data['coordinador_id'];
	       			} elseif ($data['coordinador_id'] != '' && $filters != '') {
	       				$filters .= " AND coordinador_id = " . $data['coordinador_id'];
	       			}
				}
				   
				if (isset($data['riesgo_id'])) {
					if ($data['riesgo_id'] != '' && $filters == '') {
						$filters .= " WHERE riesgo_id = " . $data['riesgo_id'];
					} elseif ($data['riesgo_id'] != '' && $filters != '') {
						$filters .= " AND riesgo_id = " . $data['riesgo_id'];
					}
				}

	       		if (isset($data['tipo_fecha'])) {
	       			if ($data['tipo_fecha'] == '0' && $filters == '' && $data['coordinacion_fecha_desde'] != '') {
	       				$filters .= " WHERE coor_coordinacion.info_create BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			} elseif ($data['tipo_fecha'] == '0' && $filters != '' && $data['coordinacion_fecha_desde'] != '') {
	       				$filters .= " AND coor_coordinacion.info_create BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			}

	       			if ($data['tipo_fecha'] == '2' && $filters == '') {
	       				$filters .= " WHERE coor_inspeccion.fecha BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			} elseif ($data['tipo_fecha'] == '2' && $filters != '') {
	       				$filters .= " AND coor_inspeccion.fecha BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			}

	       			if ($data['tipo_fecha'] == '3' && $filters == '') {
	       				$filters .= " WHERE IF(coor_coordinacion.entrega_al_cliente_fecha_nueva = '0000-00-00', coor_coordinacion.entrega_al_cliente_fecha, coor_coordinacion.entrega_al_cliente_fecha_nueva) BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			} elseif ($data['tipo_fecha'] == '3' && $filters != '') {
						   $filters .= " AND IF(coor_coordinacion.entrega_al_cliente_fecha_nueva = '0000-00-00', coor_coordinacion.entrega_al_cliente_fecha, coor_coordinacion.entrega_al_cliente_fecha_nueva) BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			}

	       			if ($data['tipo_fecha'] == '4' && $filters == '') {
	       				$filters .= " WHERE entrega_al_cliente_fecha_nueva BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			} elseif ($data['tipo_fecha'] == '4' && $filters != '') {
	       				$filters .= " AND entrega_al_cliente_fecha_nueva BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			}
	       		}
			}
		}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query(" SELECT
											coor_coordinacion.cotizacion_id,
										    coor_coordinacion.id coordinacion_id,
											riesgo_id,
											if(riesgo_id = 1, 'BAJO', if(riesgo_id = 2, 'MEDIO', 'ALTO')) riesgo_nombre,
										    cotizacion_correlativo coordinacion_correlativo,
										    IFNULL(co_cotizacion.codigo,'') cotizacion_correlativo,
										    /*ESTADO*/
										    coor_coordinacion.estado_id coordinacion_estado_id,
										    coor_coordinacion_estado.nombre coordinacion_estado_nombre,
										    /*SOLICITANTE*/
											/*solicitante_persona_id solicitante_id,
											IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
											END),'') solicitante_nombre,*/
											solicitante_persona_id_new solicitante_id,
											IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') solicitante_nombre,
                                            /*CONTACTO*/
                                            solicitante_contacto_id contacto_id,
                                            IFNULL(co_involucrado_contacto.nombre,'') contacto_nombre,
										    /*CLIENTE*/
										    /*cliente_persona_id cliente_id,
										    IFNULL(cliente_persona_tipo,'') cliente_tipo,
										    IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
											END),'') cliente_nombre,*/
											cliente_persona_id_new cliente_id,
										    IFNULL(cliente_persona_tipo,'') cliente_tipo,
										    IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') cliente_nombre,
										    IFNULL(sucursal,'') coordinacion_sucursal,
										    /*TIPO DE SERVICIO*/
										    (SELECT
				                                GROUP_CONCAT(
				                                        servicio_tipo_id
				                                        SEPARATOR ','
				                                    ) campo
				                            FROM co_cotizacion_servicio_tipo_detalle
				                            WHERE cotizacion_id = co_cotizacion.id) as servicio_tipo_id,
				                            (SELECT
				                                GROUP_CONCAT(
				                                        nombre
				                                        SEPARATOR ', '
				                                    ) campo
				                            FROM co_cotizacion_servicio_tipo_detalle
				                            LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id
				                            WHERE cotizacion_id = co_cotizacion.id) as servicio_tipo_nombre,
                                            /*COORDINADOR*/
                                            IFNULL(coordinador_id, 0) coordinador_id,
                                            IFNULL(coord.full_name, '') coordinador_nombre,
										    /*TIPO FORMATO*/
										    modalidad_id formato_id,
										    IFNULL(coor_coordinacion_modalidad.nombre,'') formato_nombre,
                                            /*TIPO DE CAMBIO*/
                                            tipo_cambio_id,
                                            IFNULL(coor_coordinacion_tipo_cambio.nombre,'') tipo_cambio_nombre,
                                            /*TIPO DE INSPECCION*/
                                            tipo_id tipo_inspeccion_id,
                                            IFNULL(coor_coordinacion_tipo.nombre,'') tipo_inspeccion_nombre,
                                            /*OBSERVACION COTIZACION*/
                                            IFNULL(coor_coordinacion.observacion,'') coordinacion_observacion,
                                            /*UBIGEO*/
                                            ubigeo_provincia.departamento_id,
                                            ubigeo_departamento.nombre departamento_nombre,
                                            ubigeo_distrito.provincia_id,
                                            ubigeo_provincia.nombre provincia_nombre,
                                            ubigeo_distrito_id,
                                            ubigeo_distrito.nombre distrito_nombre,
                                            /*FECHAS*/
                                            DATE_FORMAT(coor_coordinacion.info_create, '%d-%m-%Y') fecha_creacion,
                                            IFNULL(IF(solicitante_fecha = '0000-00-00', DATE_FORMAT(co_cotizacion.fecha_solicitud, '%d-%m-%Y'), DATE_FORMAT(solicitante_fecha, '%d-%m-%Y')),'') fecha_solicitud,
                                            IFNULL(IF(co_cotizacion.fecha_finalizacion = '0000-00-00', '', DATE_FORMAT(co_cotizacion.fecha_finalizacion, '%d-%m-%Y')),'') fecha_aprobacion,
                                            IFNULL(IF(entrega_al_cliente_fecha = '0000-00-00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%d-%m-%Y')),'') fecha_entrega_cliente,
                                            IFNULL(IF(entrega_al_cliente_fecha_nueva = '0000-00-00', '', DATE_FORMAT(entrega_al_cliente_fecha_nueva, '%d-%m-%Y')),'') fecha_entrega_cliente_nueva,
											IFNULL(IF(entrega_al_cliente_fecha_nueva = '0000-00-00', IF(entrega_al_cliente_fecha = '0000-00-00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%d-%m-%Y')), DATE_FORMAT(entrega_al_cliente_fecha_nueva, '%d-%m-%Y')),'') fecha_entrega,
                                            /*INSPECCION*/
                                            IFNULL(coor_inspeccion.id,'0') inspeccion_id,
                                            /*PERITO*/
										    IFNULL(coor_inspeccion.perito_id, 0) perito_id,
										    IFNULL(peri.full_name, '') perito_nombre,
                                            /*CONTROL DE CALIDAD*/
                                            IFNULL(inspector_id, 0) control_calidad_id,
                                            IFNULL(ctrl.full_name, '') control_calidad_nombre,
                                            /*CONTACTO*/
                                            IFNULL(contactos,'') inspeccion_contacto,
                                            IFNULL(coor_inspeccion.direccion,'') inspeccion_direccion,
                                            IFNULL(coor_inspeccion.observacion,'') inspeccion_observacion,
                                            IF(entrega_por_operaciones_fecha = '00:00:00', '', DATE_FORMAT(entrega_por_operaciones_fecha, '%d-%m-%Y')) fecha_entrega_operaciones,
                                            IFNULL(IF(convert(coor_inspeccion.fecha, date) = '0000-00-00','',date_format(coor_inspeccion.fecha,'%d-%m-%Y')),'') inspeccion_fecha,
											IFNULL(IF(hora_estimada_mostrar = 1, hora_estimada,hora_real),'') inspeccion_hora,
                                            /*GASTOS*/
										    IFNULL(total_moneda_id,'') moneda_id,
                                            IFNULL(simbolo,'') moneda_simbolo,
										    IFNULL((SELECT SUM(afdg_monto) FROM ad_facturacion_detalle_gastos WHERE coordinacion_id = coor_coordinacion.id), 0) gasto_importe,
										    IFNULL(IF(total_igv = '0', total_monto_igv, total_monto),'0') as cotizacion_importe,
											/*DIAS TRANSCURRIDOS*/
                                            IFNULL((CASE
												WHEN coor_coordinacion.estado_id in (1,2,3,7) THEN
													IF(convert(coor_inspeccion.fecha,date) = '0000-00-00', 0, TIMESTAMPDIFF(DAY,coor_inspeccion.fecha, now()))
												/*WHEN coor_coordinacion.estado_id = 4 THEN
													IF(convert(coor_inspeccion.fecha,date) = '0000-00-00', 0, TIMESTAMPDIFF(DAY,coor_inspeccion.fecha, (SELECT aut_coor_fecha FROM auditoria_coordinacion WHERE auditoria_coordinacion.aut_coor_id = coor_coordinacion.id AND auditoria_coordinacion.aut_coor_est = 4 ORDER BY aut_id DESC LIMIT 1)))*/
												WHEN coor_coordinacion.estado_id = 4 THEN
													IF(convert(coor_inspeccion.fecha,date) = '0000-00-00', 0, TIMESTAMPDIFF(DAY,coor_inspeccion.fecha, entrega_al_cliente_fecha))
                                                ELSE
													''
                                            END),'') dias_transcurridos
										FROM coor_coordinacion
										LEFT JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
										LEFT JOIN coor_coordinacion_estado ON coor_coordinacion.estado_id = coor_coordinacion_estado.id
										LEFT JOIN coor_inspeccion ON coor_coordinacion.id = coor_inspeccion.coordinacion_id
										INNER JOIN ubigeo_distrito ON coor_inspeccion.ubigeo_distrito_id = ubigeo_distrito.id
										INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
										INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
										/*LEFT JOIN co_servicio_tipo ON co_cotizacion.servicio_tipo_id = co_servicio_tipo.id*/
										LEFT JOIN login_user peri ON coor_inspeccion.perito_id = peri.id
                                        LEFT JOIN login_user ctrl ON coor_inspeccion.inspector_id = ctrl.id
										LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
										LEFT JOIN coor_coordinacion_modalidad ON coor_coordinacion.modalidad_id = coor_coordinacion_modalidad.id
                                        LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
                                        LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
                                        /*LEFT JOIN co_involucrado_contacto ON coor_coordinacion.solicitante_persona_id = co_involucrado_contacto.juridica_id AND coor_coordinacion.solicitante_contacto_id = co_involucrado_contacto.id*/
										LEFT JOIN co_involucrado_contacto ON coor_coordinacion.solicitante_persona_id_new = co_involucrado_contacto.juridica_id_new AND coor_coordinacion.solicitante_contacto_id = co_involucrado_contacto.id
										LEFT JOIN co_pago ON coor_coordinacion.cotizacion_id = co_pago.cotizacion_id
                                        LEFT JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id".$filters.$order.$limit);
        if($sql_query->num_rows() > 0) {
            if (isset($data['accion']) && $data['accion'] == 'generar_pdf')
            	return $sql_query->row();
            else
            	return $sql_query->result();
        }
        else
            return false;
	}

	public function obtenerCorrelativo()
    {
        $sql_query = "  SELECT
							MAX(cotizacion_correlativo) as correlativo
						FROM coor_coordinacion";
        $records = $this->db->query($sql_query);
        return $records->row();
    }

	public function Insert($data)
	{
		$this->db->insert('coor_coordinacion', $data);
		return $this->db->insert_id();
	}
	
	public function searchCoordinacionGenerada($data)
	{
		$row = $this->obtenerCorrelativo();
		$correlativo = intval($row->correlativo) + 1;

		$sql_query = $this->db->query(" SELECT
										    0 codigo,
										    6 estado_id,
										    0 modalidad_id,
										    0 tipo_id,
										    tipo2_id,
										    coordinador_id,
										    cotizacion_id,
										    $correlativo cotizacion_correlativo,
										    solicitante_persona_tipo,
											0 solicitante_persona_id,
											solicitante_persona_id_new,
										    solicitante_contacto_id,
										    solicitante_fecha,
										    cliente_persona_tipo,
											0 cliente_persona_id,
											cliente_persona_id_new,
										    '' sucursal,
										    '' observacion,
										    0 tipo_cambio_id,
										    0 impreso,
										    0 estado_facturacion,
										    now() info_create,
										    1 info_status,
										    ". $data['create_user'] ." info_create_user
										FROM coor_coordinacion
										WHERE cotizacion_id = ". $data['cotizacion_id'] ." LIMIT 1");
		if ($sql_query->num_rows() > 0) {
			return $sql_query->row();
		} else {
			return false;
		}
	}

	public function Update($data, $id)
	{
		$this->db->update('coor_coordinacion', $data, array('id' => $id));
		return $this->db->affected_rows();
	}

	public function updateCoordinacionxCotizacion($data, $id)
	{
		$this->db->update('coor_coordinacion', $data, array('cotizacion_id' => $id));
		return $this->db->affected_rows();
	}

	/* COO */
	public function insertCambioFecha($data)
	{
		$this->db->insert('coor_coordinacion_historial_fechas', $data);
		return $this->db->insert_id();
	}

	public function insertCoordinacionReproceso($data)
	{
		$this->db->insert('auditoria_estado_coordinacion', $data);
		return $this->db->insert_id();
	}

	public function searchCoordinacionReprocesos($data)
	{
		$sql_query = "";
		$filters = "";
		$filters_inspeccion = "";
		$filters_detalle = "";
		$order = " ORDER BY coordinacion_correlativo DESC";
        $limit = "";
        
        
        //if (isset($data['accion'])) {
			//if($data['accion'] == 'filtros') {

				
                if (isset($data['coordinacion_correlativo']) && $data['coordinacion_correlativo'] != '') {
                    $filters .= " AND cotizacion_correlativo = ".$data['coordinacion_correlativo'];
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
	       		if (isset($data['coordinacion_ubicacion'])) {
	       			if ($data['coordinacion_ubicacion'] != '' && $filters == '') {
	       				$filters .= " WHERE CONCAT(
	       										coor_inspeccion.direccion,' ',
	       										CONVERT(ubigeo_departamento.nombre, CHAR),' ',
	       										CONVERT(ubigeo_provincia.nombre, CHAR),' ',
	       										CONVERT(ubigeo_distrito.nombre, CHAR)) LIKE '%" . $data['coordinacion_ubicacion'] . "%'";
	       			} elseif ($data['coordinacion_ubicacion'] != '' && $filters != '') {
	       				$filters .= " AND CONCAT(
	       										coor_inspeccion.direccion,' ',
	       										CONVERT(ubigeo_departamento.nombre, CHAR),' ',
	       										CONVERT(ubigeo_provincia.nombre, CHAR),' ',
	       										CONVERT(ubigeo_distrito.nombre, CHAR)) LIKE '%" . $data['coordinacion_ubicacion'] . "%'";
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
        		
        		if (isset($data['tipo_fecha'])) {
	       			
	       			if ($data['tipo_fecha'] == '0' && $filters == '' && $data['coordinacion_fecha_desde'] != '') {
	       				$filters .= " WHERE DATE_FORMAT(auditoria_estado_coordinacion.info_create, '%Y-%m-%d') BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			} elseif ($data['tipo_fecha'] == '0' && $filters != '' && $data['coordinacion_fecha_desde'] != '') {
	       				$filters .= " AND DATE_FORMAT(auditoria_estado_coordinacion.info_create, '%Y-%m-%d') BETWEEN '" . $data['coordinacion_fecha_desde'] . "' AND '" . $data['coordinacion_fecha_hasta'] . "'";
	       			}
	       		}

	       	
			//}
		//}

		if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query(" SELECT
											coor_coordinacion.cotizacion_id,
										    coor_coordinacion.id coordinacion_id,
										    cotizacion_correlativo coordinacion_correlativo,
										    IFNULL(co_cotizacion.codigo,'') cotizacion_correlativo,
										    /*ESTADO*/
										    coor_coordinacion.estado_id coordinacion_estado_id,
										    coor_coordinacion_estado.nombre coordinacion_estado_nombre,
										    /*SOLICITANTE*/
											/*solicitante_persona_id solicitante_id,
											IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
											END),'') solicitante_nombre,*/
											solicitante_persona_id_new solicitante_id,
											IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') solicitante_nombre,
                                            /*CONTACTO*/
                                            solicitante_contacto_id contacto_id,
                                            IFNULL(co_involucrado_contacto.nombre,'') contacto_nombre,
										    /*CLIENTE*/
										    /*cliente_persona_id cliente_id,
										    IFNULL(cliente_persona_tipo,'') cliente_tipo,
										    IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
											END),'') cliente_nombre,*/
											cliente_persona_id_new cliente_id,
										    IFNULL(cliente_persona_tipo,'') cliente_tipo,
										    IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') cliente_nombre,
										    IFNULL(sucursal,'') coordinacion_sucursal,
										    /*TIPO DE SERVICIO*/
										    (SELECT
				                                GROUP_CONCAT(
				                                        servicio_tipo_id
				                                        SEPARATOR ','
				                                    ) campo
				                            FROM co_cotizacion_servicio_tipo_detalle
				                            WHERE cotizacion_id = co_cotizacion.id) as servicio_tipo_id,
				                            (SELECT
				                                GROUP_CONCAT(
				                                        nombre
				                                        SEPARATOR ', '
				                                    ) campo
				                            FROM co_cotizacion_servicio_tipo_detalle
				                            LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id
				                            WHERE cotizacion_id = co_cotizacion.id) as servicio_tipo_nombre,
                                            /*COORDINADOR*/
                                            IFNULL(coordinador_id, 0) coordinador_id,
                                            IFNULL(coord.full_name, '') coordinador_nombre,
										    /*TIPO FORMATO*/
										    modalidad_id formato_id,
										    IFNULL(coor_coordinacion_modalidad.nombre,'') formato_nombre,
                                            /*TIPO DE CAMBIO*/
                                            tipo_cambio_id,
                                            IFNULL(coor_coordinacion_tipo_cambio.nombre,'') tipo_cambio_nombre,
                                            /*TIPO DE INSPECCION*/
                                            tipo_id tipo_inspeccion_id,
                                            IFNULL(coor_coordinacion_tipo.nombre,'') tipo_inspeccion_nombre,
                                            /*OBSERVACION COTIZACION*/
                                            IFNULL(coor_coordinacion.observacion,'') coordinacion_observacion,
                                            /*UBIGEO*/
                                            ubigeo_provincia.departamento_id,
                                            ubigeo_departamento.nombre departamento_nombre,
                                            ubigeo_distrito.provincia_id,
                                            ubigeo_provincia.nombre provincia_nombre,
                                            ubigeo_distrito_id,
                                            ubigeo_distrito.nombre distrito_nombre,
                                            /*FECHAS*/
                                            DATE_FORMAT(coor_coordinacion.info_create, '%d-%m-%Y') fecha_creacion,
                                            IFNULL(IF(solicitante_fecha = '00:00:00', '', DATE_FORMAT(solicitante_fecha, '%d-%m-%Y')),'') fecha_solicitud,
                                            IFNULL(IF(co_cotizacion.fecha_finalizacion = '00:00:00', '', DATE_FORMAT(co_cotizacion.fecha_finalizacion, '%d-%m-%Y')),'') fecha_aprobacion,
                                            IFNULL(IF(entrega_al_cliente_fecha = '00:00:00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%d-%m-%Y')),'') fecha_entrega_cliente,
                                            IFNULL(IF(entrega_al_cliente_fecha_nueva = '00:00:00', '', DATE_FORMAT(entrega_al_cliente_fecha_nueva, '%d-%m-%Y')),'') fecha_entrega_cliente_nueva,
                                            /*INSPECCION*/
                                            IFNULL(coor_inspeccion.id,'0') inspeccion_id,
                                            coor_coordinacion.digitador_id,
											IFNULL(digi.full_name, '') digitador_nombre,
											coor_coordinacion.control_calidad_id,
											IFNULL(ctrl.full_name, '') control_calidad_nombre,
                                            
                                            /*CONTACTO*/
                                            IFNULL(contactos,'') inspeccion_contacto,
                                            IFNULL(coor_inspeccion.direccion,'') inspeccion_direccion,
                                            IFNULL(coor_inspeccion.observacion,'') inspeccion_observacion,
                                            IF(entrega_por_operaciones_fecha = '00:00:00', '', DATE_FORMAT(entrega_por_operaciones_fecha, '%d-%m-%Y')) fecha_entrega_operaciones,
                                            IFNULL(IF(convert(coor_inspeccion.fecha, date) = '0000-00-00','',date_format(coor_inspeccion.fecha,'%d-%m-%Y')),'') inspeccion_fecha,
											IFNULL(IF(hora_estimada_mostrar = 1, hora_estimada,hora_real),'') inspeccion_hora,
                                            /*GASTOS*/
										    IFNULL(total_moneda_id,'') moneda_id,
                                            IFNULL(simbolo,'') moneda_simbolo,
										    IFNULL((SELECT SUM(afdg_monto) FROM ad_facturacion_detalle_gastos WHERE coordinacion_id = coor_coordinacion.id), 0) gasto_importe,
										    IFNULL(IF(total_igv = '0', total_monto_igv, total_monto),'0') as cotizacion_importe,
											/*DIAS TRANSCURRIDOS*/
                                            IFNULL((CASE
												WHEN coor_coordinacion.estado_id in (1,2,3,7) THEN
													IF(convert(coor_inspeccion.fecha,date) = '0000-00-00', 0, TIMESTAMPDIFF(DAY,coor_inspeccion.fecha, now()))
												/*WHEN coor_coordinacion.estado_id = 4 THEN
													IF(convert(coor_inspeccion.fecha,date) = '0000-00-00', 0, TIMESTAMPDIFF(DAY,coor_inspeccion.fecha, (SELECT aut_coor_fecha FROM auditoria_coordinacion WHERE auditoria_coordinacion.aut_coor_id = coor_coordinacion.id AND auditoria_coordinacion.aut_coor_est = 4 ORDER BY aut_id DESC LIMIT 1)))*/
												WHEN coor_coordinacion.estado_id = 4 THEN
													IF(convert(coor_inspeccion.fecha,date) = '0000-00-00', 0, TIMESTAMPDIFF(DAY,coor_inspeccion.fecha, entrega_al_cliente_fecha))
                                                ELSE
													''
                                            END),'') dias_transcurridos,
                                            motivo_id,
                                            coor_coordinacion_motivo.descripcion motivo_nombre,
                                            auditoria_estado_coordinacion.observacion motivo_observacion,
                                            DATE_FORMAT(auditoria_estado_coordinacion.info_create, '%d-%m-%Y') motivo_fecha
										FROM coor_coordinacion
										LEFT JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
										LEFT JOIN coor_coordinacion_estado ON coor_coordinacion.estado_id = coor_coordinacion_estado.id
										LEFT JOIN coor_inspeccion ON coor_coordinacion.id = coor_inspeccion.coordinacion_id
										INNER JOIN ubigeo_distrito ON coor_inspeccion.ubigeo_distrito_id = ubigeo_distrito.id
										INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
										INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
										/*LEFT JOIN co_servicio_tipo ON co_cotizacion.servicio_tipo_id = co_servicio_tipo.id*/
										LEFT JOIN login_user digi ON  coor_coordinacion.digitador_id = digi.id
										LEFT JOIN login_user ctrl ON  coor_coordinacion.control_calidad_id = ctrl.id
										LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
										LEFT JOIN coor_coordinacion_modalidad ON coor_coordinacion.modalidad_id = coor_coordinacion_modalidad.id
                                        LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
                                        LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
                                        LEFT JOIN co_involucrado_contacto ON coor_coordinacion.solicitante_persona_id = co_involucrado_contacto.juridica_id AND coor_coordinacion.solicitante_contacto_id = co_involucrado_contacto.id
										LEFT JOIN co_pago ON coor_coordinacion.cotizacion_id = co_pago.cotizacion_id
                                        LEFT JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
                                        INNER JOIN auditoria_estado_coordinacion ON coor_coordinacion.id = auditoria_estado_coordinacion.coordinacion_id
                                        INNER JOIN coor_coordinacion_motivo ON auditoria_estado_coordinacion.motivo_id = coor_coordinacion_motivo.id".$filters.$order.$limit);
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

	/* COORDINACION */
	public function search($data)
	{
		$sql_query = "";
		$filters = "";
		$filters_inspeccion = "";
		$filters_detalle = "";
		$order = " ORDER BY coordinacion_correlativo DESC";
        $limit = "";

        if (isset($data['cotizacion_codigo']) && $data['cotizacion_codigo'] != '') {
            $filters .= " AND cotizacion_id = ".$data['cotizacion_codigo'];
        }

		if (isset($data['coordinacion_codigo']) && $data['coordinacion_codigo'] != '') {
            $filters .= " AND coor_coordinacion.id = ".$data['coordinacion_codigo'];
        }

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
					break;
				case '4':
					if ($data['coordinacion_fecha_desde'] != '' && $data['coordinacion_fecha_hasta'] != '') {
						$filters .= " AND date_format(coor_coordinacion.entrega_por_operaciones_fecha, '%Y-%m-%d') BETWEEN '".$data['coordinacion_fecha_desde']."' AND '".$data['coordinacion_fecha_hasta']."'";
					}
					break;
				default:
					break;
			}
		}

		if (isset($data['coordinacion_proceso']) && $data['coordinacion_proceso'] != '') {
            $filters .= " AND IFNULL((SELECT enviado_a FROM coor_proceso_operaciones WHERE coordinacion_id = coor_coordinacion.id ORDER BY id DESC LIMIT 1), 1) = ".$data['coordinacion_proceso'];
		}
		
		if (isset($data['action']) && $data['action'] != '') {
			if ($data['action'] == 'cotizacion') {
				$order = " ORDER BY coordinacion_correlativo ASC";
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

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query("	SELECT
											cotizacion_id,
											co_cotizacion.codigo cotizacion_coorelativo,
											(SELECT
												GROUP_CONCAT(
													servicio_tipo_id
													SEPARATOR ','
												) campo
											FROM co_cotizacion_servicio_tipo_detalle
											WHERE cotizacion_id = co_cotizacion.id) servicio_tipo_id,
											(SELECT
												GROUP_CONCAT(
													nombre
													SEPARATOR ', '
												) campo
											FROM co_cotizacion_servicio_tipo_detalle
											LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id
											WHERE cotizacion_id = co_cotizacion.id) servicio_tipo_nombre,
											coor_coordinacion.id coordinacion_id,
											date_format(coor_coordinacion.info_create, '%d-%m-%Y') coordinacion_fecha_creacion,
											cotizacion_correlativo coordinacion_correlativo,
											riesgo_id,
											coor_coordinacion_riesgo.nombre riesgo_nombre,
											coor_coordinacion.estado_id,
											coor_coordinacion_estado.nombre estado_nombre,
											modalidad_id,
											IFNULL(coor_coordinacion_modalidad.nombre, '') modalidad_nombre,
											tipo_id tipo_inspeccion_id,
											IFNULL(coor_coordinacion_tipo.nombre, '') tipo_inspeccion_nombre,
											coordinador_id,
											IFNULL(coor.full_name, '') coordinador_nombre,
											tipo_cambio_id,
											IFNULL(coor_coordinacion_tipo_cambio.nombre, '') tipo_cambio_nombre,
											solicitante_persona_id_new solicitante_id,
											solicitante_persona_tipo solicitante_tipo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') solicitante_nombre,
											solicitante_contacto_id contacto_id,
                                            IFNULL(co_involucrado_contacto.nombre, '') contacto_nombre,
											cliente_persona_id_new cliente_id,
											cliente_persona_tipo cliente_tipo,
											IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') cliente_nombre,
											sucursal coordinacion_sucursal,
											IFNULL(coor_coordinacion.observacion, '') coordinacion_observacion,
											digitador_id,
											IFNULL(digi.full_name, '') digitador_nombre,
											control_calidad_id,
											IFNULL(ctrl.full_name, '') control_calidad_nombre,
											IF(solicitante_fecha = '0000-00-00 00:00:00', IF(fecha_solicitud = '0000-00-00 00:00:00', '',DATE_FORMAT(fecha_solicitud, '%d-%m-%Y')), DATE_FORMAT(solicitante_fecha, '%d-%m-%Y')) coordinacion_fecha_solicitud,
											IF(fecha_finalizacion = '0000-00-00 00:00:00', '', DATE_FORMAT(fecha_finalizacion, '%d-%m-%Y')) coordinacion_fecha_aprobacion,
											IF(entrega_al_cliente_fecha_nueva = '0000-00-00 00:00:00', IF(entrega_al_cliente_fecha = '0000-00-00 00:00:00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%d-%m-%Y')), DATE_FORMAT(entrega_al_cliente_fecha_nueva, '%d-%m-%Y')) coordinacion_fecha_entrega,
											IF(entrega_al_cliente_fecha_nueva = '0000-00-00 00:00:00', IF(entrega_al_cliente_fecha = '0000-00-00 00:00:00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%Y-%m-%d')), DATE_FORMAT(entrega_al_cliente_fecha_nueva, '%Y-%m-%d')) coordinacion_fecha_entrega_normal,
											IF(entrega_por_operaciones_fecha = '0000-00-00 00:00:00' or entrega_por_operaciones_fecha < '2020-09-30','',DATE_FORMAT(entrega_por_operaciones_fecha, '%d-%m-%Y')) coordinacion_fecha_operaciones,
											IF(entrega_por_operaciones_fecha = '0000-00-00 00:00:00' or entrega_por_operaciones_fecha < '2020-09-30','',DATE_FORMAT(entrega_por_operaciones_fecha, '%Y-%m-%d')) coordinacion_fecha_operaciones_normal,
											coor_coordinacion.info_status,
											(SELECT COUNT(*) FROM coor_inspeccion_detalle
											INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
											WHERE coordinacion_id = coor_coordinacion.id".$filters_inspeccion.") cantidad_inspeccion,
											(SELECT COUNT(*) FROM auditoria_coordinacion WHERE aut_coor_id = coor_coordinacion.id AND aut_coor_est IN (4,8)) auditoria,
                                            (SELECT date_format(aut_coor_fecha, '%Y-%m-%d') FROM auditoria_coordinacion WHERE aut_coor_id = coor_coordinacion.id and aut_coor_est = 4 ORDER BY aut_id DESC LIMIT 1) fecha_terminado_auditoria,
                                            /*IFNULL(coor_proceso_operaciones.id, 0) proceso_id,
                                            IFNULL((SELECT enviado_a FROM coor_proceso_operaciones WHERE coordinacion_id = coor_coordinacion.id ORDER BY id DESC LIMIT 1), 1) proceso_enviado_a,
                                            IFNULL(coor_proceso_operaciones.info_status, 0) proceso_estado*/
                                            area_operaciones_id,
                                            IFNULL(coor_proceso_operaciones.id, 0) proceso_id,
                                            IFNULL(coor_proceso_operaciones.estado_id, 0) proceso_estado,
                                            (SELECT COUNT(*) FROM coor_proceso_operaciones WHERE coordinacion_id = coor_coordinacion.id AND estado_id = 3) proceso_count_observaciones
										FROM coor_coordinacion
										INNER JOIN coor_coordinacion_riesgo ON coor_coordinacion.riesgo_id = coor_coordinacion_riesgo.id
										LEFT JOIN coor_coordinacion_estado ON coor_coordinacion.estado_id = coor_coordinacion_estado.id
										LEFT JOIN coor_coordinacion_modalidad ON coor_coordinacion.modalidad_id = coor_coordinacion_modalidad.id
										LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
										LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
										LEFT JOIN login_user coor ON  coor_coordinacion.coordinador_id = coor.id
										LEFT JOIN login_user digi ON  coor_coordinacion.digitador_id = digi.id
										LEFT JOIN login_user ctrl ON  coor_coordinacion.control_calidad_id = ctrl.id
										INNER JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
										LEFT JOIN co_involucrado_contacto ON coor_coordinacion.solicitante_persona_id_new = co_involucrado_contacto.juridica_id_new AND coor_coordinacion.solicitante_contacto_id = co_involucrado_contacto.id
										/*LEFT JOIN coor_proceso_operaciones ON coor_coordinacion.id = coor_proceso_operaciones.coordinacion_id and coor_proceso_operaciones.info_status = 1*/
										LEFT JOIN coor_proceso_operaciones ON coor_coordinacion.id = coor_proceso_operaciones.coordinacion_id and coor_proceso_operaciones.estado_id <> 3
										WHERE coor_coordinacion.info_status = 1".$filters.$filters_detalle.$order.$limit);

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

	public function insertDetalle($data, $id)
    {
        $this->db->insert('coor_coordinacion', $data);
		return $this->db->insert_id();
    }

    public function updateDetalle($data, $id)
    {
        $this->db->update('coor_coordinacion', $data, array('id' => $id));
        return $this->db->affected_rows();
	}
	
	public function inserCambioFecha($data, $id)
	{
		$this->db->trans_begin();
        $this->db->insert('coor_coordinacion_historial_fechas', $data['historial_fechas']);
		
		$this->updateDetalle($data['coordinacion'], $id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
	}

	public function inserReproceso($data, $id)
	{
		$this->db->trans_begin();
		//actualiza los reprocesos anteriores de la coordinacion
		$this->db->update('auditoria_estado_coordinacion', $data['actualizar'], array('coordinacion_id' => $id));

		//inserta reproceso nuevo activo
        $this->db->insert('auditoria_estado_coordinacion', $data['reproceso']);
		
		//actualiza la coordinacion
		$this->updateDetalle($data['coordinacion'], $id);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
	}

	public function updateReproceso($data, $id)
	{
		$this->db->update('auditoria_estado_coordinacion', $data, array('coordinacion_id' => $id));
		return $this->db->affected_rows();
	}
}

/* End of file Coordinacion_m.php */
/* Location: ./application/models/coordinacion/Coordinacion_m.php */