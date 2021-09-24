<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terreno_m extends CI_Model {

	public function searchTerreno($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {
        	if ($data['accion'] == 'filtros') {
                $order .= " ORDER BY informe_id DESC";

        		if (isset($data['coordinacion_correlativo'])) {
                    if ($data['coordinacion_correlativo'] != '') {
                        $filters .= " WHERE informe_id = ".$data['coordinacion_correlativo'];
                    }
                }

                if (isset($data['solicitante_nombre'])) {
                    if ($data['solicitante_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE diccionario_solicitante.nombre LIKE '%" . $data['solicitante_nombre'] . "%'";
                    } elseif ($data['solicitante_nombre'] != '' && $filters != '') {
                        $filters .= " AND diccionario_solicitante.nombre LIKE '%" . $data['solicitante_nombre'] . "%'";
                    }
                }

                if (isset($data['cliente_nombre'])) {
                    if ($data['cliente_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE diccionario_cliente.nombre LIKE '%" . $data['cliente_nombre'] . "%'";
                    } elseif ($data['cliente_nombre'] != '' && $filters != '') {
                        $filters .= " AND diccionario_cliente.nombre LIKE '%" . $data['cliente_nombre'] . "%'";
                    }
                }

                if (isset($data['propietario_nombre'])) {
                    if ($data['propietario_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE diccionario_propietario.nombre LIKE '%" . $data['propietario_nombre'] . "%'";
                    } elseif ($data['propietario_nombre'] != '' && $filters != '') {
                        $filters .= " AND diccionario_propietario.nombre LIKE '%" . $data['propietario_nombre'] . "%'";
                    }
                }

                if (isset($data['tasacion_ubicacion'])) {
                    if ($data['tasacion_ubicacion'] != '' && $filters == '') {
                        $filters .= " WHERE CONCAT(
                                                IFNULL(ubicacion, ''),' ',
                                                CONVERT(ubigeo_departamento.nombre, CHAR),' ',
                                                CONVERT(ubigeo_provincia.nombre, CHAR),' ',
                                                CONVERT(ubigeo_distrito.nombre, CHAR)) LIKE '%" . $data['tasacion_ubicacion'] . "%'";
                    } elseif ($data['tasacion_ubicacion'] != '' && $filters != '') {
                        $filters .= " AND CONCAT(
                                                IFNULL(ubicacion, ''),' ',
                                                CONVERT(ubigeo_departamento.nombre, CHAR),' ',
                                                CONVERT(ubigeo_provincia.nombre, CHAR),' ',
                                                CONVERT(ubigeo_distrito.nombre, CHAR)) LIKE '%" . $data['tasacion_ubicacion'] . "%'";
                    }
                }

                if (isset($data['zonificacion_id'])) {
                    if ($data['zonificacion_id'] != '' && $filters == '') {
                        $filters .= " WHERE in_zonificacion.id = " . $data['zonificacion_id'];
                    } elseif ($data['zonificacion_id'] != '' && $filters != '') {
                        $filters .= " AND in_zonificacion.id = " . $data['zonificacion_id'];
                    }
                }

                if (isset($data['cultivo_tipo_id'])) {
                    if ($data['cultivo_tipo_id'] != '' && $filters == '') {
                        $filters .= " WHERE cultivo_tipo_id = " . $data['cultivo_tipo_id'];
                    } elseif ($data['cultivo_tipo_id'] != '' && $filters != '') {
                        $filters .= " AND cultivo_tipo_id = " . $data['cultivo_tipo_id'];
                    }
                }

                if (isset($data['tasacion_fecha_desde']) && isset($data['tasacion_fecha_hasta'])) {
                    if ($data['tasacion_fecha_desde'] != '' && $data['tasacion_fecha_hasta'] != '' && $filters == '') {
                        $filters .= " WHERE tasacion_fecha BETWEEN '" . $data['tasacion_fecha_desde'] . "' AND '" . $data['tasacion_fecha_hasta'] . "'";
                    } elseif ($data['tasacion_fecha_desde'] != '' && $data['tasacion_fecha_hasta'] != '' && $filters != '') {
                        $filters .= " AND tasacion_fecha BETWEEN '" . $data['tasacion_fecha_desde'] . "' AND '" . $data['tasacion_fecha_hasta'] . "'";
                    }
                }

                if (isset($data['tasacion_terreno_desde']) && isset($data['tasacion_terreno_hasta'])) {
                    if ($data['tasacion_terreno_desde'] != '' && $data['tasacion_terreno_hasta'] != '' && $filters == '') {
                        $filters .= " WHERE terreno_area BETWEEN '" . $data['tasacion_terreno_desde'] . "' AND '" . $data['tasacion_terreno_hasta'] . "'";
                    } elseif ($data['tasacion_terreno_desde'] != '' && $data['tasacion_terreno_hasta'] != '' && $filters != '') {
                        $filters .= " AND terreno_area BETWEEN '" . $data['tasacion_terreno_desde'] . "' AND '" . $data['tasacion_terreno_hasta'] . "'";
                    }
                }
        	}
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

       	$sql_query = $this->db->query("	SELECT
											t_terreno.id tasacion_id,
										    IFNULL(proyecto_id, 0) proyecto_id,
										    IFNULL(informe_id, 0) informe_id,
										    IFNULL(solicitante_id, '') solicitante_id,
										    IFNULL(diccionario_solicitante.nombre, '') solicitante_nombre,
										    IFNULL(cliente_id, '') cliente_id,
										    IFNULL(diccionario_cliente.nombre, '') cliente_nombre,
										    IFNULL(propietario_id, '') propietario_id,
										    IFNULL(diccionario_propietario.nombre, '') propietario_nombre,
										    IF(tasacion_fecha = '0000-00-00', '', DATE_FORMAT(tasacion_fecha, '%d-%m-%Y')) tasacion_fecha_realizado,
										    IFNULL(ubicacion, '') tasacion_ubicacion,
										    IFNULL(ubigeo_provincia.departamento_id, 0) departamento_id,
										    IFNULL(ubigeo_departamento.nombre, '') departamento_nombre,
										    IFNULL(ubigeo_distrito.provincia_id, 0) provincia_id,
										    IFNULL(ubigeo_provincia.nombre, '') provincia_nombre,
										    IFNULL(ubigeo_distrito_id, 0) distrito_id,
										    IFNULL(ubigeo_distrito.nombre, '') distrito_nombre,
										    mapa_latitud,
										    mapa_longitud,
                                            IFNULL(in_zonificacion.id, 0) zonificacion_id,
										    IFNULL(zonificacion, '') zonificacion_nombre,
										    IFNULL(cultivo_tipo_id, 0) cultivo_tipo_id,
										    IFNULL(diccionario_cultivo_tipo.nombre, '') cultivo_tipo_nombre,
										    IFNULL(terreno_area, 0) tasacion_area_terreno,
										    IFNULL(terreno_valorunitario, 0) tasacion_valor_unitario,
										    IFNULL(valor_comercial, 0) tasacion_valor_comercial,
										    IFNULL(tipo_cambio, 0) tasacion_tipo_cambio,
										    IFNULL(observacion, '') tasacion_observacion,
										    IFNULL(ruta_informe, '') tasacion_ruta
										FROM t_terreno
										LEFT JOIN diccionario_solicitante ON t_terreno.solicitante_id = diccionario_solicitante.id
										LEFT JOIN diccionario_cliente ON t_terreno.cliente_id = diccionario_cliente.id
										LEFT JOIN diccionario_propietario ON t_terreno.propietario_id = diccionario_propietario.id
										LEFT JOIN ubigeo_distrito ON t_terreno.ubi_distrito_id = ubigeo_distrito.id
										LEFT JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
										LEFT JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                        LEFT JOIN in_zonificacion ON t_terreno.zonificacion = in_zonificacion.nombre
										LEFT JOIN diccionario_cultivo_tipo ON t_terreno.cultivo_tipo_id = diccionario_cultivo_tipo.id".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
	}

    public function Insert($data)
    {
        $this->db->insert('tas_terreno', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('tas_terreno', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Terreno_m.php */
/* Location: ./application/models/tasacion/Terreno_m.php */