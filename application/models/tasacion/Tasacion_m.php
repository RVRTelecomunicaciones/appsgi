<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasacion_m extends CI_Model {

	public function searchTasaciones($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {
        	if ($data['accion'] == 'filtros') {
                $order .= " ORDER BY coor_coordinacion.info_create ASC, perito_nombre DESC";
				//AND control.id = 45
        		if (isset($data['coordinacion_correlativo'])) {
                    if ($data['coordinacion_correlativo'] != '') {
                        $filters .= " AND cotizacion_correlativo = ".$data['coordinacion_correlativo'];
                    }
                }

                if (isset($data['solicitante_nombre'])) {
                    if ($data['solicitante_nombre'] != '') {
                        $filters .= " AND IFNULL(
                                                (CASE
                                                    WHEN solicitante_persona_tipo = 'Juridica' THEN
                                                        (SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
                                                    ELSE
                                                        (SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
                                                END),
                                            '') LIKE '%" . $data['solicitante_nombre'] . "%'";
                    }
                }

                if (isset($data['cliente_nombre'])) {
                    if ($data['cliente_nombre'] != '') {
                        $filters .= " AND IFNULL(
                                                (CASE
                                                    WHEN cliente_persona_tipo = 'Juridica' THEN
                                                        (SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
                                                    ELSE
                                                        (SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
                                                END),
                                            '') LIKE '%" . $data['cliente_nombre'] . "%'";
                    }
                }

                if (isset($data['perito_id'])) {
                    if ($data['perito_id'] != '') {
                        $filters .= " AND perito.id = " . $data['perito_id'];
                    }
                }

                if (isset($data['control_calidad_id'])) {
                    if ($data['control_calidad_id'] != '') {
                        $filters .= " AND control.id = " . $data['control_calidad_id'];
                    }
                }
        	}
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

       	$sql_query = $this->db->query("	SELECT
                                            cotizacion_id,
                                            coor_coordinacion.id coordinacion_id,
                                            cotizacion_correlativo coordinacion_correlativo,
                                            /*solicitante_persona_id solicitante_id,
                                            IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
                                            IFNULL(
                                                (CASE
                                                    WHEN solicitante_persona_tipo = 'Juridica' THEN
                                                        (SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
                                                    ELSE
                                                        (SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
                                                END),
                                            '') solicitante_nombre,
                                            cliente_persona_id cliente_id,
                                            IFNULL(cliente_persona_tipo,'') cliente_tipo,
                                            IFNULL(
                                                (CASE
                                                    WHEN cliente_persona_tipo = 'Juridica' THEN
                                                        (SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
                                                    ELSE
                                                        (SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
                                                END),
                                            '') cliente_nombre,*/
                                            solicitante_persona_id_new solicitante_id,
                                            IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
                                            IFNULL(
                                                (CASE
                                                    WHEN solicitante_persona_tipo = 'Juridica' THEN
                                                        (SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
                                                END),
                                            '') solicitante_nombre,
                                            cliente_persona_id_new cliente_id,
                                            IFNULL(cliente_persona_tipo,'') cliente_tipo,
                                            IFNULL(
                                                (CASE
                                                    WHEN cliente_persona_tipo = 'Juridica' THEN
                                                        (SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
                                                END),
                                            '') cliente_nombre,
                                            DATE_FORMAT(coor_coordinacion.info_create, '%d-%m-%Y') coordinacion_fecha, 
                                            IFNULL(perito.full_name, '') perito_nombre, 
                                            IFNULL(control.full_name, '') control_calidad_nombre,
                                            ubigeo_departamento.id departamento_id,
                                            ubigeo_departamento.nombre departamento_nombre,
                                            ubigeo_provincia.id provincia_id,
                                            ubigeo_provincia.nombre provincia_nombre,
                                            ubigeo_distrito.id distrito_id,
                                            ubigeo_distrito.nombre distrito_nombre
                                        FROM coor_coordinacion 
                                        LEFT JOIN coor_inspeccion ON coor_coordinacion.id = coor_inspeccion.coordinacion_id 
                                        LEFT JOIN ubigeo_distrito ON coor_inspeccion.ubigeo_distrito_id = ubigeo_distrito.id
                                        LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                        LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                        LEFT JOIN login_user perito ON coor_inspeccion.perito_id = perito.id 
                                        LEFT JOIN login_user control ON coor_inspeccion.inspector_id = control.id
                                        WHERE 
                                            NOT EXISTS (SELECT 1 FROM tas_terreno WHERE tas_terreno.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM tas_casa WHERE tas_casa.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM tas_departamento WHERE tas_departamento.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM tas_oficina WHERE tas_oficina.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM tas_local_comercial WHERE tas_local_comercial.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM tas_local_industrial WHERE tas_local_industrial.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM tas_vehiculo WHERE tas_vehiculo.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM tas_maquinaria WHERE tas_maquinaria.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM tas_no_registrado WHERE tas_no_registrado.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND coor_coordinacion.estado_id = 4 AND coor_coordinacion.info_create > '2019-01-01'".$filters.$order.$limit);
        
        /*$sql_query = $this->db->query("SELECT
                                            cotizacion_id,
                                            coor_coordinacion.id coordinacion_id,
                                            cotizacion_correlativo coordinacion_correlativo,
                                            solicitante_persona_id_new solicitante_id,
                                            IFNULL(solicitante_persona_tipo,'') solicitante_tipo,
                                            IFNULL(
                                                (CASE
                                                    WHEN solicitante_persona_tipo = 'Juridica' THEN
                                                        (SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
                                                END),
                                            '') solicitante_nombre,
                                            cliente_persona_id_new cliente_id,
                                            IFNULL(cliente_persona_tipo,'') cliente_tipo,
                                            IFNULL(
                                                (CASE
                                                    WHEN cliente_persona_tipo = 'Juridica' THEN
                                                        (SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
                                                END),
                                            '') cliente_nombre,
                                            DATE_FORMAT(coor_coordinacion.info_create, '%d-%m-%Y') coordinacion_fecha, 
                                            IFNULL(perito.full_name, '') perito_nombre, 
                                            IFNULL(control.full_name, '') control_calidad_nombre,
                                            ubigeo_departamento.id departamento_id,
                                            ubigeo_departamento.nombre departamento_nombre,
                                            ubigeo_provincia.id provincia_id,
                                            ubigeo_provincia.nombre provincia_nombre,
                                            ubigeo_distrito.id distrito_id,
                                            ubigeo_distrito.nombre distrito_nombre,
                                            fc_tasaciones_reproceso(coor_coordinacion.id) reproceso
                                        FROM coor_coordinacion 
                                        LEFT JOIN coor_inspeccion ON coor_coordinacion.id = coor_inspeccion.coordinacion_id 
                                        LEFT JOIN ubigeo_distrito ON coor_inspeccion.ubigeo_distrito_id = ubigeo_distrito.id
                                        LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                        LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                        LEFT JOIN login_user perito ON coor_inspeccion.perito_id = perito.id 
                                        LEFT JOIN login_user control ON coor_inspeccion.inspector_id = control.id
										WHERE
											coor_coordinacion.estado_id = 4 AND coor_coordinacion.info_create > '2019-01-01' AND
											CONCAT(fc_tasaciones_encontradas(coor_coordinacion.cotizacion_correlativo),'-', fc_tasaciones_reproceso(coor_coordinacion.id)) <> '1-0'".$filters.$order.$limit);*/

        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
	}

    public function searchInmuebles($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY informe_id ASC";
        $limit = "";

        if (isset($data['inmueble_tipo'])) {
            if ($data['inmueble_tipo'] != '' && $filters == '')
                $filters .= " WHERE tasacion_tipo = '".$data['inmueble_tipo']."'";
            else if ($data['inmueble_tipo'] != '' && $filters != '')
                $filters .= " AND tasacion_tipo = '".$data['inmueble_tipo']."'";
        }

        if (isset($data['inmueble_coordinacion'])) {
            if ($data['inmueble_coordinacion'] != '' && $filters == '')
                $filters .= " WHERE informe_id = '".$data['inmueble_coordinacion']."'";
            else if ($data['inmueble_coordinacion'] != '' && $filters != '')
                $filters .= " AND informe_id = '".$data['inmueble_coordinacion']."'";
        }

        if (isset($data['inmueble_solicitante'])) {
            if ($data['inmueble_solicitante'] != '' && $filters == '')
                //$filters .= " WHERE replace(solicitante_nombre, '\\\\', '') LIKE '%".$data['inmueble_solicitante']."%'";
                $filters .= " WHERE solicitante_nombre LIKE '%".$data['inmueble_solicitante']."%'";
            else if ($data['inmueble_solicitante'] != '' && $filters != '')
                //$filters .= " AND replace(solicitante_nombre, '\\\\', '') LIKE '%".$data['inmueble_solicitante']."%'";
                $filters .= " AND solicitante_nombre LIKE '%".$data['inmueble_solicitante']."%'";
        }

        if (isset($data['inmueble_cliente'])) {
            if ($data['inmueble_cliente'] != '' && $filters == '')
                //$filters .= " WHERE replace(cliente_nombre, '\\\\', '') LIKE '%".$data['inmueble_cliente']."%'";
                $filters .= " WHERE cliente_nombre LIKE '%".$data['inmueble_cliente']."%'";
            else if ($data['inmueble_cliente'] != '' && $filters != '')
                //$filters .= " AND replace(cliente_nombre, '\\\\', '') LIKE '%".$data['inmueble_cliente']."%'";
                $filters .= " AND cliente_nombre LIKE '%".$data['inmueble_cliente']."%'";
        }

        if (isset($data['inmueble_direccion'])) {
            if ($data['inmueble_direccion'] != '' && $filters == '')
                $filters .= " WHERE ubicacion LIKE '%".$data['inmueble_direccion']."%'";
            else if ($data['inmueble_direccion'] != '' && $filters != '')
                $filters .= " AND ubicacion LIKE '%".$data['inmueble_direccion']."%'";
        }

        if (isset($data['inmueble_zonificacion'])) {
            if ($data['inmueble_zonificacion'] != '' && $filters == '')
                $filters .= " WHERE zonificacion_id = '".$data['inmueble_zonificacion']."'";
            else if ($data['inmueble_zonificacion'] != '' && $filters != '')
                $filters .= " AND zonificacion_id = '".$data['inmueble_zonificacion']."'";
        }

        if (isset($data['inmueble_fecha_desde']) && isset($data['inmueble_fecha_hasta'])) {
            if ($data['inmueble_fecha_desde'] != '' && $data['inmueble_fecha_hasta'] != '' && $filters == '')
                $filters .= " WHERE tasacion_fecha_normal BETWEEN  '".$data['inmueble_fecha_desde']."' AND '".$data['inmueble_fecha_hasta']."'";
            else if ($data['inmueble_fecha_desde'] != '' && $data['inmueble_fecha_hasta'] != '' && $filters != '')
                $filters .= " AND tasacion_fecha_normal BETWEEN  '".$data['inmueble_fecha_desde']."' AND '".$data['inmueble_fecha_hasta']."'";    
        }
        
        if (isset($data['inmueble_area_desde']) && isset($data['inmueble_area_hasta'])) {
            if ($data['inmueble_area_desde'] != '' && $data['inmueble_area_hasta'] != '' && $filters == '')
                $filters .= " WHERE terreno_area >= " . $data['inmueble_area_desde'] . " AND terreno_area <= " . $data['inmueble_area_hasta'];
            else if ($data['inmueble_area_desde'] != '' && $data['inmueble_area_hasta'] != '' && $filters != '')
                $filters .= " AND terreno_area >= " . $data['inmueble_area_desde'] . " AND terreno_area <= " . $data['inmueble_area_hasta'];
        }

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            *
                                        FROM (SELECT
                                                'TERRENO' tasacion_tipo,
                                                tas_terreno.id,
                                                informe_id,
                                                DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                                tasacion_fecha tasacion_fecha_normal,
                                                cliente_id,
                                                cliente_tipo,
                                                replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                                propietario_id,
                                                tas_propietario.nombre propietario_nombre,
                                                solicitante_id,
                                                solicitante_tipo,
                                                replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                                tipo_cambio,
                                                valor_comercial,
                                                ubicacion,
                                                observacion,
                                                ruta_informe,
                                                /*BEGIN DISTINTOS*/
                                                zonificacion_id,
                                                tas_zonificacion.abreviatura zonificacion_abreviatura,
                                                terreno_tipo_id,
                                                tas_terreno_tipo.nombre terreno_tipo_nombre,
                                                0 departamento_tipo_id,
                                                '' departamento_tipo_nombre,
                                                0 local_tipo_id,
                                                '' loca_tipo_nombre,
                                                terreno_area,
                                                terreno_valorunitario,
                                                0 edificacion_area,
                                                0 valor_comercial_departamento,
                                                0 valor_ocupada,
                                                distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                0 antiguedad,
                                                mapa_latitud,
                                                mapa_longitud
                                            FROM tas_terreno
                                            LEFT JOIN tas_propietario ON tas_terreno.propietario_id = tas_propietario.id
                                            LEFT JOIN tas_cliente ON tas_terreno.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                            LEFT JOIN tas_solicitante ON tas_terreno.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                            LEFT JOIN involucrado_natural cli_nat ON tas_terreno.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico cli_jur ON tas_terreno.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                            LEFT JOIN involucrado_natural sol_nat ON tas_terreno.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico sol_jur ON tas_terreno.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                            LEFT JOIN tas_zonificacion ON tas_terreno.zonificacion_id = tas_zonificacion.id
                                            LEFT JOIN tas_terreno_tipo ON tas_terreno.terreno_tipo_id = tas_terreno_tipo.id
                                            LEFT JOIN ubigeo_distrito ON tas_terreno.distrito_id = ubigeo_distrito.id
                                            LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                            UNION
                                            SELECT
                                                'CASA' tasacion_tipo,
                                                tas_casa.id,
                                                informe_id,
                                                DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                                tasacion_fecha tasacion_fecha_normal,
                                                cliente_id,
                                                cliente_tipo,
                                                replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                                propietario_id,
                                                tas_propietario.nombre propietario_nombre,
                                                solicitante_id,
                                                solicitante_tipo,
                                                replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                                tipo_cambio,
                                                valor_comercial,
                                                ubicacion,
                                                observacion,
                                                ruta_informe,
                                                /*BEGIN DISTINTOS*/
                                                zonificacion_id,
                                                tas_zonificacion.abreviatura zonificacion_abreviatura,
                                                0 terreno_tipo_id,
                                                '' terreno_tipo_nombre,
                                                0 departamento_tipo_id,
                                                '' departamento_tipo_nombre,
                                                0 local_tipo_id,
                                                '' loca_tipo_nombre,
                                                terreno_area,
                                                terreno_valorunitario,
                                                0 edificacion_area,
                                                0 valor_comercial_departamento,
                                                0 valor_ocupada,
                                                0 distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                0 antiguedad,
                                                mapa_latitud,
                                                mapa_longitud
                                            FROM tas_casa
                                            LEFT JOIN tas_propietario ON tas_casa.propietario_id = tas_propietario.id
                                            LEFT JOIN tas_cliente ON tas_casa.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                            LEFT JOIN tas_solicitante ON tas_casa.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                            LEFT JOIN involucrado_natural cli_nat ON tas_casa.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico cli_jur ON tas_casa.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                            LEFT JOIN involucrado_natural sol_nat ON tas_casa.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico sol_jur ON tas_casa.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                            LEFT JOIN tas_zonificacion ON tas_casa.zonificacion_id = tas_zonificacion.id
                                            LEFT JOIN ubigeo_distrito ON tas_casa.distrito_id = ubigeo_distrito.id
                                            LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                            UNION
                                            SELECT
                                                'DEPARTAMENTO' tasacion_tipo,
                                                tas_departamento.id,
                                                informe_id,
                                                DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                                tasacion_fecha tasacion_fecha_normal,
                                                cliente_id,
                                                cliente_tipo,
                                                replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                                propietario_id,
                                                tas_propietario.nombre propietario_nombre,
                                                solicitante_id,
                                                solicitante_tipo,
                                                replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                                tipo_cambio,
                                                valor_comercial,
                                                ubicacion,
                                                observacion,
                                                ruta_informe,
                                                /*BEGIN DISTINTOS*/
                                                zonificacion_id,
                                                tas_zonificacion.abreviatura zonificacion_abreviatura,
                                                0 terreno_tipo_id,
                                                '' terreno_tipo_nombre,
                                                departamento_tipo_id,
                                                tas_departamento_tipo.nombre departamento_tipo_nombre,
                                                0 local_tipo_id,
                                                '' loca_tipo_nombre,
                                                terreno_area,
                                                terreno_valorunitario,
                                                edificacion_area,
                                                valor_comercial_departamento,
                                                valor_ocupada,
                                                0 distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                0 antiguedad,
                                                mapa_latitud,
                                                mapa_longitud
                                            FROM tas_departamento
                                            LEFT JOIN tas_propietario ON tas_departamento.propietario_id = tas_propietario.id
                                            LEFT JOIN tas_cliente ON tas_departamento.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                            LEFT JOIN tas_solicitante ON tas_departamento.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                            LEFT JOIN involucrado_natural cli_nat ON tas_departamento.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico cli_jur ON tas_departamento.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                            LEFT JOIN involucrado_natural sol_nat ON tas_departamento.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico sol_jur ON tas_departamento.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                            LEFT JOIN tas_zonificacion ON tas_departamento.zonificacion_id = tas_zonificacion.id
                                            LEFT JOIN tas_departamento_tipo ON tas_departamento.departamento_tipo_id = tas_departamento_tipo.id
                                            LEFT JOIN ubigeo_distrito ON tas_departamento.distrito_id = ubigeo_distrito.id
                                            LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                            UNION
                                            SELECT
                                                'OFICINA' tasacion_tipo,
                                                tas_oficina.id,
                                                informe_id,
                                                DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                                tasacion_fecha tasacion_fecha_normal,
                                                cliente_id,
                                                cliente_tipo,
                                                replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                                propietario_id,
                                                tas_propietario.nombre propietario_nombre,
                                                solicitante_id,
                                                solicitante_tipo,
                                                replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                                tipo_cambio,
                                                valor_comercial,
                                                ubicacion,
                                                observacion,
                                                ruta_informe,
                                                /*BEGIN DISTINTOS*/
                                                zonificacion_id,
                                                tas_zonificacion.abreviatura zonificacion_abreviatura,
                                                0 terreno_tipo_id,
                                                '' terreno_tipo_nombre,
                                                0 departamento_tipo_id,
                                                '' departamento_tipo_nombre,
                                                0 local_tipo_id,
                                                '' loca_tipo_nombre,
                                                terreno_area,
                                                terreno_valorunitario,
                                                edificacion_area,
                                                0 valor_comercial_departamento,
                                                valor_ocupada,
                                                0 distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                0 antiguedad,
                                                mapa_latitud,
                                                mapa_longitud
                                            FROM tas_oficina
                                            LEFT JOIN tas_propietario ON tas_oficina.propietario_id = tas_propietario.id
                                            LEFT JOIN tas_cliente ON tas_oficina.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                            LEFT JOIN tas_solicitante ON tas_oficina.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                            LEFT JOIN involucrado_natural cli_nat ON tas_oficina.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico cli_jur ON tas_oficina.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                            LEFT JOIN involucrado_natural sol_nat ON tas_oficina.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico sol_jur ON tas_oficina.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                            LEFT JOIN tas_zonificacion ON tas_oficina.zonificacion_id = tas_zonificacion.id
                                            LEFT JOIN ubigeo_distrito ON tas_oficina.distrito_id = ubigeo_distrito.id
                                            LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                            UNION
                                            SELECT
                                                'LOCAL COMERCIAL' tasacion_tipo,
                                                tas_local_comercial.id,
                                                informe_id,
                                                DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                                tasacion_fecha tasacion_fecha_normal,
                                                cliente_id,
                                                cliente_tipo,
                                                replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                                propietario_id,
                                                tas_propietario.nombre propietario_nombre,
                                                solicitante_id,
                                                solicitante_tipo,
                                                replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                                tipo_cambio,
                                                valor_comercial,
                                                ubicacion,
                                                observacion,
                                                ruta_informe,
                                                /*BEGIN DISTINTOS*/
                                                zonificacion_id,
                                                tas_zonificacion.abreviatura zonificacion_abreviatura,
                                                0 terreno_tipo_id,
                                                '' terreno_tipo_nombre,
                                                0 departamento_tipo_id,
                                                '' departamento_tipo_nombre,
                                                local_tipo_id,
                                                tas_local_tipo.nombre loca_tipo_nombre,
                                                terreno_area,
                                                terreno_valorunitario,
                                                edificacion_area,
                                                0 valor_comercial_departamento,
                                                valor_ocupada,
                                                0 distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                0 antiguedad,
                                                mapa_latitud,
                                                mapa_longitud
                                            FROM tas_local_comercial
                                            LEFT JOIN tas_propietario ON tas_local_comercial.propietario_id = tas_propietario.id
                                            LEFT JOIN tas_cliente ON tas_local_comercial.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                            LEFT JOIN tas_solicitante ON tas_local_comercial.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                            LEFT JOIN involucrado_natural cli_nat ON tas_local_comercial.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico cli_jur ON tas_local_comercial.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                            LEFT JOIN involucrado_natural sol_nat ON tas_local_comercial.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico sol_jur ON tas_local_comercial.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                            LEFT JOIN tas_zonificacion ON tas_local_comercial.zonificacion_id = tas_zonificacion.id
                                            LEFT JOIN tas_local_tipo ON tas_local_comercial.local_tipo_id = tas_local_tipo.id
                                            LEFT JOIN ubigeo_distrito ON tas_local_comercial.distrito_id = ubigeo_distrito.id
                                            LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                            UNION
                                            SELECT
                                                'LOCAL INDUSTRIAL' tasacion_tipo,
                                                tas_local_industrial.id,
                                                informe_id,
                                                DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                                tasacion_fecha tasacion_fecha_normal,
                                                cliente_id,
                                                cliente_tipo,
                                                replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                                propietario_id,
                                                tas_propietario.nombre propietario_nombre,
                                                solicitante_id,
                                                solicitante_tipo,
                                                replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                                tipo_cambio,
                                                valor_comercial,
                                                ubicacion,
                                                observacion,
                                                ruta_informe,
                                                /*BEGIN DISTINTOS*/
                                                zonificacion_id,
                                                tas_zonificacion.abreviatura zonificacion_abreviatura,
                                                0 terreno_tipo_id,
                                                '' terreno_tipo_nombre,
                                                0 departamento_tipo_id,
                                                '' departamento_tipo_nombre,
                                                0 local_tipo_id,
                                                '' loca_tipo_nombre,
                                                terreno_area,
                                                terreno_valorunitario,
                                                edificacion_area,
                                                0 valor_comercial_departamento,
                                                0 valor_ocupada,
                                                0 distrito_id,
                                                ubigeo_distrito.nombre distrito_nombre,
                                                ubigeo_provincia.id provincia_id,
                                                ubigeo_provincia.nombre provincia_nombre,
                                                ubigeo_departamento.id departamento_id,
                                                ubigeo_departamento.nombre departamento_nombre,
                                                0 antiguedad,
                                                mapa_latitud,
                                                mapa_longitud
                                            FROM tas_local_industrial
                                            LEFT JOIN tas_propietario ON tas_local_industrial.propietario_id = tas_propietario.id
                                            LEFT JOIN tas_cliente ON tas_local_industrial.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                            LEFT JOIN tas_solicitante ON tas_local_industrial.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                            LEFT JOIN involucrado_natural cli_nat ON tas_local_industrial.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico cli_jur ON tas_local_industrial.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                            LEFT JOIN involucrado_natural sol_nat ON tas_local_industrial.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                            LEFT JOIN involucrado_juridico sol_jur ON tas_local_industrial.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                            LEFT JOIN tas_zonificacion ON tas_local_industrial.zonificacion_id = tas_zonificacion.id
                                            LEFT JOIN ubigeo_distrito ON tas_local_industrial.distrito_id = ubigeo_distrito.id
                                            LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                            LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id) TASACIONES".$filters.$order.$limit);

        if (isset($data['action']) && $data['action'] == 'count') {
            return $sql_query->num_rows();
        } else {
            if($sql_query->num_rows() > 0)
                if (isset($data['action']) && $data['action'] == 'sheet')
                    return $sql_query->row();
                    //return $this->db->last_query();
                else
                    return $sql_query->result();
                    //return $this->db->last_query();
            else
                return false;
                //return $this->db->last_query();
        }
    }

    //
    public function search($data)
    {
        $sql_query = "";
        $filters = " AND coor_coordinacion.estado_id in (3,7,8)";
        $order = "";
        $limit = "";

        if (isset($data['coordinacion_codigo']) && $data['coordinacion_codigo'] != '') {
            $filters .= " AND coor_inspeccion_detalle.coordinacion_id = ".$data['coordinacion_codigo'];
        }

        if (isset($data['inspeccion_codigo']) && $data['inspeccion_codigo'] != '') {
            $filters .= " AND inspeccion_id = ".$data['inspeccion_codigo'];
        }

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
        
        if (isset($data['coordinacion_digitador']) && $data['coordinacion_digitador'] != '') {
            $filters .= " AND digitador_id = ".$data['coordinacion_digitador'];
		}

		if (isset($data['coordinacion_control_calidad']) && $data['coordinacion_control_calidad'] != '') {
            $filters .= " AND control_calidad_id = ".$data['coordinacion_control_calidad'];
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
                                            solicitante_persona_tipo solicitante_tipo,
                                            IF(solicitante_persona_tipo = 'Juridica', sol_jur.razon_social, 
                                            CONCAT(
                                                IF(length(sol_nat.paterno) > 0, concat(sol_nat.paterno, ' '),''),
                                                IF(length(sol_nat.materno) > 0, concat(sol_nat.materno, ' '),''),
                                                sol_nat.nombres)
                                            ) solicitante_nombre,
                                            cliente_persona_id_new cliente_id,
                                            cliente_persona_tipo cliente_tipo,
                                            IF(cliente_persona_tipo = 'Juridica', cli_jur.razon_social, 
                                            CONCAT(
                                                IF(length(cli_nat.paterno) > 0, concat(cli_nat.paterno, ' '),''),
                                                IF(length(cli_nat.materno) > 0, concat(cli_nat.materno, ' '),''),
                                                cli_nat.nombres)
                                            ) cliente_nombre,
                                            (SELECT
                                                GROUP_CONCAT(
                                                    nombre
                                                    SEPARATOR ', '
                                                ) campo
                                            FROM co_cotizacion_servicio_tipo_detalle
                                            LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id
                                            WHERE cotizacion_id = co_cotizacion.id) servicio_tipo_nombre,
                                            tipo_cambio_id,
                                            IFNULL(coor_coordinacion_tipo_cambio.nombre, '') tipo_cambio_nombre,
                                            tipo_id tipo_inspeccion_id,
                                            IFNULL(coor_coordinacion_tipo.nombre, '') tipo_inspeccion_nombre,
                                            
                                            inspeccion_id,
                                            inspeccion.perito_id,
                                            IFNULL(peri.full_name, '') perito_nombre,
                                            contactos inspeccion_contacto,
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
                                            inspeccion.direccion inspeccion_direccion,
                                            latitud inspeccion_latitud,
                                            longitud inspeccion_longitud,
                                            inspeccion.observacion inspeccion_observacion,
                                            inspeccion.estado_id,
                                            coor_inspeccion_estado.nombre estado_nombre,
                                            inspeccion.info_status,
                                            
                                            digitador_id,
                                            IFNULL(digi.full_name, '') digitador_nombre,
                                            control_calidad_id,
                                            IFNULL(contr.full_name, '') control_calidad_nombre,
                                            fc_tasaciones_encontradas('normal', coor_coordinacion.cotizacion_correlativo) encontradas,
                                            fc_tasaciones_reproceso(coor_coordinacion.id) reproceso
                                        FROM coor_inspeccion_detalle
                                        INNER JOIN coor_coordinacion ON coor_inspeccion_detalle.coordinacion_id = coor_coordinacion.id
                                        LEFT JOIN login_user coord ON coor_coordinacion.coordinador_id = coord.id
                                        LEFT JOIN involucrado_juridico sol_jur ON coor_coordinacion.solicitante_persona_id_new = sol_jur.id AND coor_coordinacion.solicitante_persona_tipo = 'Juridica'
                                        LEFT JOIN involucrado_natural sol_nat ON coor_coordinacion.solicitante_persona_id_new = sol_nat.id AND coor_coordinacion.solicitante_persona_tipo = 'Natural'
                                        LEFT JOIN involucrado_juridico cli_jur ON coor_coordinacion.cliente_persona_id_new = cli_jur.id AND coor_coordinacion.cliente_persona_tipo = 'Juridica'
                                        LEFT JOIN involucrado_natural cli_nat ON coor_coordinacion.cliente_persona_id_new = cli_nat.id AND coor_coordinacion.cliente_persona_tipo = 'Natural'
                                        LEFT JOIN coor_coordinacion_tipo_cambio ON coor_coordinacion.tipo_cambio_id = coor_coordinacion_tipo_cambio.id
                                        LEFT JOIN coor_coordinacion_tipo ON coor_coordinacion.tipo_id = coor_coordinacion_tipo.id
                                        LEFT JOIN login_user digi ON coor_coordinacion.digitador_id = digi.id
                                        LEFT JOIN login_user contr ON coor_coordinacion.control_calidad_id = contr.id
                                        INNER JOIN co_cotizacion ON coor_coordinacion.cotizacion_id = co_cotizacion.id
                                        INNER JOIN inspeccion ON coor_inspeccion_detalle.inspeccion_id = inspeccion.id
                                        LEFT JOIN login_user peri ON inspeccion.perito_id = peri.id
                                        INNER JOIN ubigeo_distrito ON inspeccion.distrito_id = ubigeo_distrito.id
                                        INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                        INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                        INNER JOIN coor_inspeccion_estado ON inspeccion.estado_id = coor_inspeccion_estado.id
                                        WHERE inspeccion.info_status = 1 /*AND coor_coordinacion.info_create > '2019-01-01'*/ AND
											CONCAT(fc_tasaciones_encontradas('listado', coor_coordinacion.cotizacion_correlativo),'-', fc_tasaciones_reproceso(coor_coordinacion.id)) IN ('0-0', '0-1', '1-1')".$filters.$order.$limit);

        if (isset($data['action']) && $data['action'] == 'count') {
            return $sql_query->num_rows();
        } else {
            if($sql_query->num_rows() > 0)
                if (isset($data['action']) && $data['action'] == 'sheet')
                    return $sql_query->row();
                    //return $this->db->last_query();
                else
                    return $sql_query->result();
                    //return $this->db->last_query();
            else
                return false;
        }
    }

    public function searchDetalle($data)
    {
        $sql_query = $this->db->query("CALL sp_tasaciones_detalle(".$data['coordinacion_correlativo'].")");

        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
    }
}

/* End of file Tasacion_m.php */
/* Location: ./application/models/tasacion/Tasacion_m.php */