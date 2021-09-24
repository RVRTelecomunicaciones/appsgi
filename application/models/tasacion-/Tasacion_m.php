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
                        $filters .= " AND informe_id = ".$data['coordinacion_correlativo'];
                    }
                }

                if (isset($data['solicitante_nombre'])) {
                    if ($data['solicitante_nombre'] != '') {
                        $filters .= " AND diccionario_solicitante.nombre LIKE '%" . $data['solicitante_nombre'] . "%'";
                    }
                }

                if (isset($data['cliente_nombre'])) {
                    if ($data['cliente_nombre'] != '') {
                        $filters .= " AND diccionario_cliente.nombre LIKE '%" . $data['cliente_nombre'] . "%'";
                    }
                }
				
				

                if (isset($data['perito_id'])) {
                    if ($data['perito_id'] != '') {
                        $filters .= " AND perito.id = " . $data['perito_id'];
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
										    solicitante_persona_id solicitante_id,
											/*IFNULL(solicitante_persona_tipo,'') solicitante_tipo,*/
											IFNULL(
												(CASE
													WHEN solicitante_persona_tipo = 'Juridica' THEN
														(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_persona_id)
													ELSE
														(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_persona_id)
												END),
										    '') solicitante_nombre,
										    cliente_persona_id cliente_id,
										    /*IFNULL(cliente_persona_tipo,'') cliente_tipo,*/
										    IFNULL(
												(CASE
													WHEN cliente_persona_tipo = 'Juridica' THEN
														(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_persona_id)
													ELSE
														(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_persona_id)
												END),
											'') cliente_nombre,
										    DATE_FORMAT(coor_coordinacion.info_create, '%d-%m-%Y') coordinacion_fecha, 
										    perito.full_name perito_nombre, 
										    control.full_name control_calidad_nombre
										FROM coor_coordinacion 
										LEFT JOIN coor_inspeccion ON coor_coordinacion.id = coor_inspeccion.coordinacion_id 
										LEFT JOIN login_user perito ON coor_inspeccion.perito_id =  perito.id 
										LEFT JOIN login_user control ON coor_inspeccion.inspector_id =  control.id
										WHERE 
											NOT EXISTS (SELECT 1 FROM t_terreno WHERE t_terreno.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM t_casa WHERE t_casa.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM t_departamento WHERE t_departamento.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM t_local_industrial WHERE t_local_industrial.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM t_local_comercial WHERE t_local_comercial.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM t_oficina WHERE t_oficina.informe_id = coor_coordinacion.cotizacion_correlativo)
											/*AND  NOT EXISTS (SELECT 1 FROM t_estacionamiento WHERE t_estacionamiento.informe_id = coor_coordinacion.cotizacion_correlativo)*/
											AND  NOT EXISTS (SELECT 1 FROM t_vehiculo WHERE t_vehiculo.informe_id = coor_coordinacion.cotizacion_correlativo)
                                            AND  NOT EXISTS (SELECT 1 FROM t_maquinaria WHERE t_maquinaria.informe_id = coor_coordinacion.cotizacion_correlativo)
											AND  NOT EXISTS (SELECT 1 FROM in_no_registrado WHERE in_no_registrado.informe_id = coor_coordinacion.cotizacion_correlativo)
										    AND coor_coordinacion.estado_id = 4 AND coor_coordinacion.info_create > '2019-03-01'".$filters.$order.$limit);
        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
	}

}

/* End of file Tasacion_m.php */
/* Location: ./application/models/tasacion/Tasacion_m.php */