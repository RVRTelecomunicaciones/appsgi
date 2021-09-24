<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspeccion_m extends CI_Model {

    public function searchInspeccion($data)
    {
        $sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {
            if($data['accion'] == 'generar_pdf') {
                $filters .= " WHERE coor_inspeccion.id = ".$data['inspeccion_id'];
            }if($data['accion'] == 'inspeccion_coordinacion') {
                $filters .= " WHERE coor_inspeccion.id = ".$data['inspeccion_id'];
            } elseif ($data['accion'] == 'filtros') {
                $order = " ORDER BY coordinacion_correlativo DESC";
                
                if (isset($data['coordinacion_correlativo'])) {
                    if ($data['coordinacion_correlativo'] != '') {
                        $filters .= " WHERE cotizacion_correlativo = ".$data['coordinacion_correlativo'];
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
                    if ($data['solicitante_nombre'] != '' && $filters == '') {
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
                    }
                }

                if (isset($data['cliente_nombre'])) {
                    if ($data['cliente_nombre'] != '' && $filters == '') {
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
                    }
                }

                if (isset($data['servicio_tipo_id'])) {
                    if ($data['servicio_tipo_id'] != '' && $filters == '') {
                        $filters .= " WHERE servicio_tipo_id = " . $data['servicio_tipo_id'];
                    } elseif ($data['servicio_tipo_id'] != '' && $filters != '') {
                        $filters .= " AND servicio_tipo_id = " . $data['servicio_tipo_id'];
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

                if (isset($data['tipo_fecha'])) {
                    if ($data['tipo_fecha'] == '1' && $filters == '') {
                        $filters .= " WHERE coor_inspeccion.fecha BETWEEN '" . $data['inspeccion_fecha_desde'] . "' AND '" . $data['inspeccion_fecha_hasta'] . "'";
                    } elseif ($data['tipo_fecha'] == '1' && $filters != '') {
                        $filters .= " AND coor_inspeccion.fecha BETWEEN '" . $data['inspeccion_fecha_desde'] . "' AND '" . $data['inspeccion_fecha_hasta'] . "'";
                    }
                }
            }
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


            $sql_query = $this->db->query(" SELECT
                                                cotizacion_correlativo coordinacion_correlativo,
                                                /*ESTADO*/
                                                coor_coordinacion.estado_id coordinacion_estado_id,
                                                coor_coordinacion_estado.nombre coordinacion_estado_nombre,
                                                IFNULL((CASE
                                                    WHEN solicitante_persona_tipo = 'Juridica' THEN
                                                        (SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
                                                    ELSE
                                                        (SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
                                                END),'') solicitante_nombre,
                                                IFNULL((CASE
                                                    WHEN cliente_persona_tipo = 'Juridica' THEN
                                                        (SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
                                                    ELSE
                                                        (SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
                                                END),'') cliente_nombre,
                                                IFNULL(coordinador_id, 0) coordinador_id,
                                                IFNULL(coord.full_name, '') coordinador_nombre,
                                                coor_inspeccion.id inspeccion_id,
                                                /*PERITO*/
                                                IFNULL(coor_inspeccion.perito_id, 0) perito_id,
                                                IFNULL(peri.full_name, '') perito_nombre,
                                                /*DIGITADOR*/
                                                IFNULL(coor_inspeccion.digitador_id, 0) digitador_id,
                                                IFNULL(digi.full_name, '') digitador_nombre,
                                                /*CONTROL DE CALIDAD*/
                                                IFNULL(inspector_id, 0) control_calidad_id,
                                                IFNULL(ctrl.full_name, '') control_calidad_nombre,
                                                contactos inspeccion_contacto,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_distrito_id distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                latitud inspeccion_latitud,
                                                longitud inspeccion_longitud,
                                                IFNULL(direccion,'') inspeccion_direccion,
                                                IFNULL(coor_inspeccion.observacion,'') inspeccion_observacion,
                                                ruta inspeccion_ruta,
                                                IFNULL(IF(convert(coor_inspeccion.fecha, date) = '0000-00-00','',date_format(coor_inspeccion.fecha,'%d-%m-%Y')),'') inspeccion_fecha,
                                                IFNULL(IF(convert(coor_inspeccion.fecha, date) = '0000-00-00','',date_format(coor_inspeccion.fecha,'%Y-%m-%d')),'') inspeccion_fecha_normal,
                                                hora_real_mostrar,
                                                hora_estimada_mostrar,
                                                IFNULL(IF(hora_estimada_mostrar = 1, hora_estimada, hora_real),'') inspeccion_hora
                                            FROM coor_inspeccion
                                            INNER JOIN coor_coordinacion ON coor_inspeccion.coordinacion_id = coor_coordinacion.id
                                            LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
                                            LEFT JOIN login_user peri ON coor_inspeccion.perito_id = peri.id
                                            LEFT JOIN login_user digi ON coor_inspeccion.digitador_id = digi.id
                                            LEFT JOIN login_user ctrl ON coor_inspeccion.inspector_id = ctrl.id
                                            INNER JOIN ubigeo_distrito ON coor_inspeccion.ubigeo_distrito_id = ubigeo_distrito.id
                                            INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                            LEFT JOIN coor_coordinacion_estado ON coor_coordinacion.estado_id = coor_coordinacion_estado.id".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
            if (isset($data['accion']) && $data['accion'] == 'generar_pdf')
                return $sql_query->row();
            else
                return $sql_query->result();
        else
            return false;
    }

	public function Insert($data)
    {
        $this->db->insert('coor_inspeccion', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('coor_inspeccion', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    
    /* INSPECCION DETALLE */
    public function search($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY fecha DESC";
        $limit = "";

        if (isset($data['coordinacion_codigo']) && $data['coordinacion_codigo'] != '') {
            $filters .= " AND coor_inspeccion_detalle.coordinacion_id = ".$data['coordinacion_codigo'];
        }

        if (isset($data['inspeccion_codigo']) && $data['inspeccion_codigo'] != '') {
            $filters .= " AND coor_inspeccion_detalle.inspeccion_id = ".$data['inspeccion_codigo'];
        }

        if (isset($data['coordinacion_correlativo']) && $data['coordinacion_correlativo'] != '') {
            $filters .= " AND cotizacion_correlativo = ".$data['coordinacion_correlativo'];
        }

        if (isset($data['inspeccion_solicitante']) && $data['inspeccion_solicitante'] != '') {
            $filters .= "   AND IF(solicitante_persona_tipo = 'Juridica', sol_jur.razon_social, 
                                    CONCAT(
                                        IF(length(sol_nat.paterno) > 0, concat(sol_nat.paterno, ' '),''),
                                        IF(length(sol_nat.materno) > 0, concat(sol_nat.materno, ' '),''),
                                        sol_nat.nombres
                                    )
                                ) LIKE '%".$data['inspeccion_solicitante']."%'";
        }

        if (isset($data['inspeccion_cliente']) && $data['inspeccion_cliente'] != '') {
            $filters .= "   AND IF(cliente_persona_tipo = 'Juridica', cli_jur.razon_social, 
                                    CONCAT(
                                        IF(length(cli_nat.paterno) > 0, concat(cli_nat.paterno, ' '),''),
                                        IF(length(cli_nat.materno) > 0, concat(cli_nat.materno, ' '),''),
                                        cli_nat.nombres
                                    )
                                ) LIKE '%".$data['inspeccion_cliente']."%'";
        }

        if (isset($data['inspeccion_servicio_tipo']) && $data['inspeccion_servicio_tipo'] != '') {
            $filters .= "   AND (SELECT
                                    GROUP_CONCAT(
                                        servicio_tipo_id
                                        SEPARATOR ','
                                    ) campo
                                FROM co_cotizacion_servicio_tipo_detalle
                                WHERE cotizacion_id = co_cotizacion.id) in (".$data['inspeccion_servicio_tipo'].")";
        }

        if (isset($data['inspeccion_direccion']) && $data['inspeccion_direccion'] != '') {
            $filters .= " AND inspeccion.direccion LIKE '%".$data['inspeccion_direccion']."%'";
        }

        if (isset($data['inspeccion_perito']) && $data['inspeccion_perito'] != '') {
            $filters .= " AND inspeccion.perito_id = ".$data['inspeccion_perito'];
        }

        if (isset($data['inspeccion_coordinador']) && $data['inspeccion_coordinador'] != '') {
            $filters .= " AND coordinador_id = ".$data['inspeccion_coordinador'];
        }

        if (isset($data['inspeccion_fecha_desde']) && isset($data['inspeccion_fecha_hasta'])) {
            if ($data['inspeccion_fecha_desde'] != '' && $data['inspeccion_fecha_hasta'] != '') {
                $filters .= " AND fecha BETWEEN '".$data['inspeccion_fecha_desde']."' AND '".$data['inspeccion_fecha_hasta']."'";
            }
        }

        if (isset($data['inspeccion_estado']) && $data['inspeccion_estado'] != '') {
            $filters .= " AND inspeccion.estado_id = ".$data['inspeccion_estado'];
        }

        if (isset($data['order']) && $data['order'] != '') {
			if ($data['order'] == 'coordinacion') {
				$order = " ORDER BY coordinacion_correlativo ".$data['order_type'];
			} else if ($data['order'] == 'solicitante') {
				$order = " ORDER BY solicitante_nombre ".$data['order_type'];
			} else if ($data['order'] == 'cliente') {
				$order = " ORDER BY cliente_nombre ".$data['order_type'];
			} else if ($data['order'] == 'tipo_servicio') {
				$order = " ORDER BY servicio_tipo_nombre ".$data['order_type'];
			} else if ($data['order'] == 'direccion') {
				$order = " ORDER BY inspeccion_direccion ".$data['order_type'];
			} else if ($data['order'] == 'perito') {
				$order = " ORDER BY perito_nombre ".$data['order_type'];
			} else if ($data['order'] == 'coordinador') {
				$order = " ORDER BY coordinador_nombre ".$data['order_type'];
			} else if ($data['order'] == 'fecha') {
				$order = " ORDER BY inspeccion_fecha_normal ".$data['order_type'];
			}  else if ($data['order'] == 'estado') {
				$order = " ORDER BY estado_nombre ".$data['order_type'];
			}
        }
        
        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            cotizacion_id,
                                            coordinacion_id,
                                            cotizacion_correlativo coordinacion_correlativo,
                                            riesgo_id,
											IF(riesgo_id = 1, 'BAJO', IF(riesgo_id = 2, 'MEDIO', 'ALTO')) riesgo_nombre,
                                            coordinador_id,
                                            IFNULL(coord.full_name, '') coordinador_nombre,
                                            IF(fecha_solicitud = '0000-00-00', '', DATE_FORMAT(fecha_solicitud, '%d-%m-%Y')) fecha_solicitud,
                                            IF(entrega_al_cliente_fecha = '0000-00-00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%d-%m-%Y')) entrega_al_cliente_fecha,
                                            IFNULL(IF(entrega_al_cliente_fecha_nueva = '0000-00-00', IF(entrega_al_cliente_fecha = '0000-00-00', '', DATE_FORMAT(entrega_al_cliente_fecha, '%d-%m-%Y')), DATE_FORMAT(entrega_al_cliente_fecha_nueva, '%d-%m-%Y')),'') fecha_entrega,
                                            solicitante_persona_id_new solicitante_id,
                                            IF(solicitante_persona_tipo = 'Juridica', sol_jur.razon_social, 
                                                CONCAT(
                                                    IF(length(sol_nat.paterno) > 0, concat(sol_nat.paterno, ' '),''),
                                                    IF(length(sol_nat.materno) > 0, concat(sol_nat.materno, ' '),''),
                                                    sol_nat.nombres
                                                )
                                            ) solicitante_nombre,
                                            solicitante_contacto_id contacto_id,
                                            co_involucrado_contacto.nombre contacto_nombre,
                                            cliente_persona_id_new cliente_id,
                                            IF(cliente_persona_tipo = 'Juridica', cli_jur.razon_social, 
                                                CONCAT(
                                                    IF(length(cli_nat.paterno) > 0, concat(cli_nat.paterno, ' '),''),
                                                    IF(length(cli_nat.materno) > 0, concat(cli_nat.materno, ' '),''),
                                                    cli_nat.nombres
                                                )
                                            ) cliente_nombre,
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
                                            WHERE cotizacion_id = co_cotizacion.id) as servicio_tipo_nombre,
                                            tipo_cambio_id,
                                            IFNULL(coor_coordinacion_tipo_cambio.nombre, '') tipo_cambio_nombre,
                                            tipo_id tipo_inspeccion_id,
                                            IFNULL(coor_coordinacion_tipo.nombre, '') tipo_inspeccion_nombre,
                                            modalidad_id,
                                            IFNULL(coor_coordinacion_modalidad.nombre, '') modalidad_nombre,
                                            
                                            coor_inspeccion_detalle.inspeccion_id,
                                            inspeccion.perito_id,
                                            IFNULL(peri.full_name, '') perito_nombre,
                                            IFNULL(contactos, '') inspeccion_contacto,
                                            IF(fecha = '0000-00-00', '', DATE_FORMAT(fecha, '%d-%m-%Y')) inspeccion_fecha,
                                            fecha inspeccion_fecha_normal,
                                            hora inspeccion_hora,
                                            hora_tipo inspeccion_hora_tipo,
                                            distrito_id,
                                            ubigeo_distrito.nombre distrito_nombre,
                                            provincia_id,
                                            ubigeo_provincia.nombre provincia_nombre,
                                            departamento_id,
                                            ubigeo_departamento.nombre departamento_nombre,
                                            IFNULL(inspeccion.direccion, '') inspeccion_direccion,
                                            latitud inspeccion_latitud,
                                            longitud inspeccion_longitud,
                                            IFNULL(inspeccion.observacion, '') inspeccion_observacion,
                                            inspeccion.estado_id,
                                            coor_inspeccion_estado.nombre estado_nombre,
                                            inspeccion.info_status,
                                            
                                            digitador_id,
                                            IFNULL(digi.full_name, '') digitador_nombre,
                                            control_calidad_id,
                                            IFNULL(contr.full_name, '') control_calidad_nombre,
                                            IFNULL(inspeccion_visita.id, 0) visita_id
                                        FROM coor_inspeccion_detalle
                                        INNER JOIN coor_coordinacion ON coor_inspeccion_detalle.coordinacion_id = coor_coordinacion.id
                                        LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
                                        LEFT JOIN involucrado_juridico sol_jur ON coor_coordinacion.solicitante_persona_id_new = sol_jur.id AND coor_coordinacion.solicitante_persona_tipo = 'Juridica'
                                        LEFT JOIN involucrado_natural sol_nat ON coor_coordinacion.solicitante_persona_id_new = sol_nat.id AND coor_coordinacion.solicitante_persona_tipo = 'Natural'
                                        LEFT JOIN involucrado_juridico cli_jur ON coor_coordinacion.cliente_persona_id_new = cli_jur.id AND coor_coordinacion.cliente_persona_tipo = 'Juridica'
                                        LEFT JOIN involucrado_natural cli_nat ON coor_coordinacion.cliente_persona_id_new = cli_nat.id AND coor_coordinacion.cliente_persona_tipo = 'Natural'
                                        LEFT JOIN co_involucrado_contacto ON solicitante_contacto_id = co_involucrado_contacto.id
                                        LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
                                        LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
                                        LEFT JOIN coor_coordinacion_modalidad ON coor_coordinacion.modalidad_id = coor_coordinacion_modalidad.id
                                        LEFT JOIN login_user digi ON coor_coordinacion.digitador_id = digi.id
                                        LEFT JOIN login_user contr ON coor_coordinacion.control_calidad_id = contr.id
                                        INNER JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
                                        INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
                                        LEFT JOIN login_user peri ON inspeccion.perito_id = peri.id
                                        INNER JOIN ubigeo_distrito ON inspeccion.distrito_id = ubigeo_distrito.id
                                        INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                        INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                        INNER JOIN coor_inspeccion_estado ON inspeccion.estado_id = coor_inspeccion_estado.id
                                        LEFT JOIN inspeccion_visita ON inspeccion.id = inspeccion_visita.inspeccion_id
                                        WHERE inspeccion.info_status = 1".$filters.$order.$limit);

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
    
    public function listAppInspeccionCoordinacion($coordinacion){
        
        $sql_query = $this->db->query("SELECT
	cotizacion_id,
	coordinacion_id,
	cotizacion_correlativo coordinacion_correlativo,
	riesgo_id,
IF
	(
		riesgo_id = 1,
		'BAJO',
	IF
	( riesgo_id = 2, 'MEDIO', 'ALTO' )) riesgo_nombre,
	coordinador_id,
	IFNULL( coord.full_name, '' ) coordinador_nombre,
IF
	(
		fecha_solicitud = '0000-00-00',
		'',
	DATE_FORMAT( fecha_solicitud, '%d-%m-%Y' )) fecha_solicitud,
IF
	(
		entrega_al_cliente_fecha = '0000-00-00',
		'',
	DATE_FORMAT( entrega_al_cliente_fecha, '%d-%m-%Y' )) entrega_al_cliente_fecha,
	IFNULL(
	IF
		(
			entrega_al_cliente_fecha_nueva = '0000-00-00',
		IF
			(
				entrega_al_cliente_fecha = '0000-00-00',
				'',
			DATE_FORMAT( entrega_al_cliente_fecha, '%d-%m-%Y' )),
		DATE_FORMAT( entrega_al_cliente_fecha_nueva, '%d-%m-%Y' )),
		'' 
	) fecha_entrega,
	solicitante_persona_id_new solicitante_id,
IF
	(
		solicitante_persona_tipo = 'Juridica',
		sol_jur.razon_social,
		CONCAT(
		IF
			( length( sol_nat.paterno ) > 0, concat( sol_nat.paterno, ' ' ), '' ),
		IF
			( length( sol_nat.materno ) > 0, concat( sol_nat.materno, ' ' ), '' ),
			sol_nat.nombres 
		) 
	) solicitante_nombre,
	solicitante_contacto_id contacto_id,
	co_involucrado_contacto.nombre contacto_nombre,
	cliente_persona_id_new cliente_id,
IF
	(
		cliente_persona_tipo = 'Juridica',
		cli_jur.razon_social,
		CONCAT(
		IF
			( length( cli_nat.paterno ) > 0, concat( cli_nat.paterno, ' ' ), '' ),
		IF
			( length( cli_nat.materno ) > 0, concat( cli_nat.materno, ' ' ), '' ),
			cli_nat.nombres 
		) 
	) cliente_nombre,
	( SELECT GROUP_CONCAT( servicio_tipo_id SEPARATOR ',' ) campo FROM co_cotizacion_servicio_tipo_detalle WHERE cotizacion_id = co_cotizacion.id ) servicio_tipo_id,
	(
	SELECT
		GROUP_CONCAT( nombre SEPARATOR ', ' ) campo 
	FROM
		co_cotizacion_servicio_tipo_detalle
		LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id 
	WHERE
		cotizacion_id = co_cotizacion.id 
	) AS servicio_tipo_nombre,
	tipo_cambio_id,
	IFNULL( coor_coordinacion_tipo_cambio.nombre, '' ) tipo_cambio_nombre,
	tipo_id tipo_inspeccion_id,
	IFNULL( coor_coordinacion_tipo.nombre, '' ) tipo_inspeccion_nombre,
	modalidad_id,
	IFNULL( coor_coordinacion_modalidad.nombre, '' ) modalidad_nombre,
	inspeccion_id,
	inspeccion.perito_id,
	IFNULL( peri.full_name, '' ) perito_nombre,
	IFNULL( contactos, '' ) inspeccion_contacto,
IF
	(
		fecha = '0000-00-00',
		'',
	DATE_FORMAT( fecha, '%d-%m-%Y' )) inspeccion_fecha,
	fecha inspeccion_fecha_normal,
	hora inspeccion_hora,
	hora_tipo inspeccion_hora_tipo,
	distrito_id,
	ubigeo_distrito.nombre distrito_nombre,
	provincia_id,
	ubigeo_provincia.nombre provincia_nombre,
	departamento_id,
	ubigeo_departamento.nombre departamento_nombre,
	IFNULL( inspeccion.direccion, '' ) inspeccion_direccion,
	latitud inspeccion_latitud,
	longitud inspeccion_longitud,
	IFNULL( inspeccion.observacion, '' ) inspeccion_observacion,
	inspeccion.estado_id,
	coor_inspeccion_estado.nombre estado_nombre,
	inspeccion.info_status,
	digitador_id,
	IFNULL( digi.full_name, '' ) digitador_nombre,
	control_calidad_id,
	IFNULL( contr.full_name, '' ) control_calidad_nombre 
FROM
	coor_inspeccion_detalle
	INNER JOIN coor_coordinacion ON coor_inspeccion_detalle.coordinacion_id = coor_coordinacion.id
	LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
	LEFT JOIN involucrado_juridico sol_jur ON coor_coordinacion.solicitante_persona_id_new = sol_jur.id 
	AND coor_coordinacion.solicitante_persona_tipo = 'Juridica'
	LEFT JOIN involucrado_natural sol_nat ON coor_coordinacion.solicitante_persona_id_new = sol_nat.id 
	AND coor_coordinacion.solicitante_persona_tipo = 'Natural'
	LEFT JOIN involucrado_juridico cli_jur ON coor_coordinacion.cliente_persona_id_new = cli_jur.id 
	AND coor_coordinacion.cliente_persona_tipo = 'Juridica'
	LEFT JOIN involucrado_natural cli_nat ON coor_coordinacion.cliente_persona_id_new = cli_nat.id 
	AND coor_coordinacion.cliente_persona_tipo = 'Natural'
	LEFT JOIN co_involucrado_contacto ON solicitante_contacto_id = co_involucrado_contacto.id
	LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
	LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
	LEFT JOIN coor_coordinacion_modalidad ON coor_coordinacion.modalidad_id = coor_coordinacion_modalidad.id
	LEFT JOIN login_user digi ON coor_coordinacion.digitador_id = digi.id
	LEFT JOIN login_user contr ON coor_coordinacion.control_calidad_id = contr.id
	INNER JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
	INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
	LEFT JOIN login_user peri ON inspeccion.perito_id = peri.id
	INNER JOIN ubigeo_distrito ON inspeccion.distrito_id = ubigeo_distrito.id
	INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
	INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
	INNER JOIN coor_inspeccion_estado ON inspeccion.estado_id = coor_inspeccion_estado.id 
WHERE inspeccion.info_status = 1 and inspeccion.estado_id = 1 and coordinacion_id=".$coordinacion);
    return $sql_query->row();
        
    }
    
    public function listAppInspeccion($idUser,$idTipoinpeccion){
        
        $sql_query = $this->db->query("SELECT
	cotizacion_id,
	coordinacion_id,
	cotizacion_correlativo coordinacion_correlativo,
	riesgo_id,
IF
	(
		riesgo_id = 1,
		'BAJO',
	IF
	( riesgo_id = 2, 'MEDIO', 'ALTO' )) riesgo_nombre,
	coordinador_id,
	IFNULL( coord.full_name, '' ) coordinador_nombre,
IF
	(
		fecha_solicitud = '0000-00-00',
		'',
	DATE_FORMAT( fecha_solicitud, '%d-%m-%Y' )) fecha_solicitud,
IF
	(
		entrega_al_cliente_fecha = '0000-00-00',
		'',
	DATE_FORMAT( entrega_al_cliente_fecha, '%d-%m-%Y' )) entrega_al_cliente_fecha,
	IFNULL(
	IF
		(
			entrega_al_cliente_fecha_nueva = '0000-00-00',
		IF
			(
				entrega_al_cliente_fecha = '0000-00-00',
				'',
			DATE_FORMAT( entrega_al_cliente_fecha, '%d-%m-%Y' )),
		DATE_FORMAT( entrega_al_cliente_fecha_nueva, '%d-%m-%Y' )),
		'' 
	) fecha_entrega,
	solicitante_persona_id_new solicitante_id,
IF
	(
		solicitante_persona_tipo = 'Juridica',
		sol_jur.razon_social,
		CONCAT(
		IF
			( length( sol_nat.paterno ) > 0, concat( sol_nat.paterno, ' ' ), '' ),
		IF
			( length( sol_nat.materno ) > 0, concat( sol_nat.materno, ' ' ), '' ),
			sol_nat.nombres 
		) 
	) solicitante_nombre,
	solicitante_contacto_id contacto_id,
	co_involucrado_contacto.nombre contacto_nombre,
	cliente_persona_id_new cliente_id,
IF
	(
		cliente_persona_tipo = 'Juridica',
		cli_jur.razon_social,
		CONCAT(
		IF
			( length( cli_nat.paterno ) > 0, concat( cli_nat.paterno, ' ' ), '' ),
		IF
			( length( cli_nat.materno ) > 0, concat( cli_nat.materno, ' ' ), '' ),
			cli_nat.nombres 
		) 
	) cliente_nombre,
	( SELECT GROUP_CONCAT( servicio_tipo_id SEPARATOR ',' ) campo FROM co_cotizacion_servicio_tipo_detalle WHERE cotizacion_id = co_cotizacion.id ) servicio_tipo_id,
	(
	SELECT
		GROUP_CONCAT( nombre SEPARATOR ', ' ) campo 
	FROM
		co_cotizacion_servicio_tipo_detalle
		LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id 
	WHERE
		cotizacion_id = co_cotizacion.id 
	) AS servicio_tipo_nombre,
	tipo_cambio_id,
	IFNULL( coor_coordinacion_tipo_cambio.nombre, '' ) tipo_cambio_nombre,
	tipo_id tipo_inspeccion_id,
	IFNULL( coor_coordinacion_tipo.nombre, '' ) tipo_inspeccion_nombre,
	modalidad_id,
	IFNULL( coor_coordinacion_modalidad.nombre, '' ) modalidad_nombre,
	inspeccion_id,
	inspeccion.perito_id,
	IFNULL( peri.full_name, '' ) perito_nombre,
	IFNULL( contactos, '' ) inspeccion_contacto,
IF
	(
		fecha = '0000-00-00',
		'',
	DATE_FORMAT( fecha, '%d-%m-%Y' )) inspeccion_fecha,
	fecha inspeccion_fecha_normal,
	hora inspeccion_hora,
	hora_tipo inspeccion_hora_tipo,
	distrito_id,
	ubigeo_distrito.nombre distrito_nombre,
	provincia_id,
	ubigeo_provincia.nombre provincia_nombre,
	departamento_id,
	ubigeo_departamento.nombre departamento_nombre,
	IFNULL( inspeccion.direccion, '' ) inspeccion_direccion,
	latitud inspeccion_latitud,
	longitud inspeccion_longitud,
	IFNULL( inspeccion.observacion, '' ) inspeccion_observacion,
	inspeccion.estado_id,
	coor_inspeccion_estado.nombre estado_nombre,
	inspeccion.info_status,
	digitador_id,
	IFNULL( digi.full_name, '' ) digitador_nombre,
	control_calidad_id,
	IFNULL( contr.full_name, '' ) control_calidad_nombre 
FROM
	coor_inspeccion_detalle
	INNER JOIN coor_coordinacion ON coor_inspeccion_detalle.coordinacion_id = coor_coordinacion.id
	LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
	LEFT JOIN involucrado_juridico sol_jur ON coor_coordinacion.solicitante_persona_id_new = sol_jur.id 
	AND coor_coordinacion.solicitante_persona_tipo = 'Juridica'
	LEFT JOIN involucrado_natural sol_nat ON coor_coordinacion.solicitante_persona_id_new = sol_nat.id 
	AND coor_coordinacion.solicitante_persona_tipo = 'Natural'
	LEFT JOIN involucrado_juridico cli_jur ON coor_coordinacion.cliente_persona_id_new = cli_jur.id 
	AND coor_coordinacion.cliente_persona_tipo = 'Juridica'
	LEFT JOIN involucrado_natural cli_nat ON coor_coordinacion.cliente_persona_id_new = cli_nat.id 
	AND coor_coordinacion.cliente_persona_tipo = 'Natural'
	LEFT JOIN co_involucrado_contacto ON solicitante_contacto_id = co_involucrado_contacto.id
	LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
	LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
	LEFT JOIN coor_coordinacion_modalidad ON coor_coordinacion.modalidad_id = coor_coordinacion_modalidad.id
	LEFT JOIN login_user digi ON coor_coordinacion.digitador_id = digi.id
	LEFT JOIN login_user contr ON coor_coordinacion.control_calidad_id = contr.id
	INNER JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
	INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
	LEFT JOIN login_user peri ON inspeccion.perito_id = peri.id
	INNER JOIN ubigeo_distrito ON inspeccion.distrito_id = ubigeo_distrito.id
	INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
	INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
	INNER JOIN coor_inspeccion_estado ON inspeccion.estado_id = coor_inspeccion_estado.id 
WHERE inspeccion.info_status = 1 and inspeccion.estado_id = 1 and coor_coordinacion.estado_id=7 and coor_coordinacion.tipo_id=".$idTipoinpeccion." and inspeccion.perito_id=".$idUser." ORDER BY inspeccion.fecha desc");
    return $sql_query->result();
        
    }
    

    public function insertDetalle($data, $id)
    {
        $this->db->trans_begin();
        $this->db->insert('inspeccion', $data);

        $detail = array(
            'coordinacion_id' => $id,
            'inspeccion_id' => $this->db->insert_id()
        );
        $this->db->insert('coor_inspeccion_detalle', $detail);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function updateDetalle($data, $id)
    {
        $this->db->update('inspeccion', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Inspeccion_m.php */
/* Location: ./application/models/inspeccion/Inspeccion_m.php */