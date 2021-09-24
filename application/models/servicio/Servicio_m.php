<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio_m extends CI_Model {
    
    /*BEGIN SERVICIO*/
	public function searchServicio($data)
    {
        $sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {
            if ($data['accion'] == 'tipo_servicio'){
                $order = " ORDER BY servicio_nombre ASC";
                if (isset($data['servicio_tipo_id'])) {
                    if ($data['servicio_tipo_id'] != '' && $filters == '') {
                        $filters .= " WHERE servicio_tipo_id in (" . $data['servicio_tipo_id'] . ")";
                    }
                }
            } else if ($data['accion'] == 'filtros') {
                $order = " ORDER BY servicio_nombre ASC";

                if (isset($data['tipo_servicio'])) {
                    if ($data['tipo_servicio'] != '' && $filters == '') {
                        $filters .= " WHERE servicio_tipo_id in (" . $data['tipo_servicio'] . ")";
                    } elseif ($data['tipo_servicio'] != '' && $filters != '') {
                        $filters .= " AND servicio_tipo_id in (" . $data['tipo_servicio'] . ")";
                    }
                }

                if (isset($data['servicio_nombre'])) {
                    if ($data['servicio_nombre'] != '' && $filters == '') {
                        $filters .= " WHERE nombre LIKE '%" . $data['servicio_nombre'] . "%'";
                    } elseif ($data['servicio_nombre'] != '' && $filters != '') {
                        $filters .= " AND nombre LIKE '%" . $data['servicio_nombre'] . "%'";
                    }
                }

                if (isset($data['servicio_estado'])) {
                    if ($data['servicio_estado'] != '' && $filters == '') {
                        $filters .= " WHERE info_status = " . $data['servicio_estado'];
                    } elseif ($data['servicio_estado'] != '' && $filters != '') {
                        $filters .= " AND info_status = " . $data['servicio_estado'];
                    }
                }
            }
        }


        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query = $this->db->query(" SELECT
                                            co_sub_servicio.id servicio_id,
                                            co_sub_servicio.nombre servicio_nombre,
                                            co_sub_servicio.info_status servicio_estado
                                        FROM co_sub_servicio".$filters.$order.$limit);
        if($sql_query->num_rows()> 0){
            return $sql_query->result();
        }
        else{
            return false;
        }
    }

    public function InsertServicio($data)
    {
        $this->db->insert('co_sub_servicio', $data);
        return $this->db->insert_id();
    }

    public function UpdateServicio($data, $id)
    {
        $this->db->update('co_sub_servicio', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    /*END SERVICIO*/

    /*BEGIN SERVICIO DETALLE*/
    public function searchCotizacionServicios($cotizacion)
    {
        $query = $this->db->query(" SELECT
                                        co_servicio.id,
                                        servicio_sub_id servicio_id,
                                        co_sub_servicio.nombre servicio_nombre,
                                        descripcion servicio_descripcion,
                                        co_moneda.id moneda_id,
                                        simbolo moneda_simbolo,
                                        cantidad servicio_cantidad,
                                        ROUND(subtotal,2) servicio_costo,
                                        IF(total_igv = 0, '', ' + IGV') servicio_igv_letra
                                    FROM co_servicio
                                    LEFT JOIN co_sub_servicio ON co_servicio.servicio_sub_id = co_sub_servicio.id
                                    LEFT JOIN co_pago ON co_servicio.cotizacion_id = co_pago.cotizacion_id
                                    LEFT JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
                                    WHERE co_servicio.cotizacion_id = $cotizacion AND co_servicio.info_status = 1");
        if($query->num_rows()> 0) {
            return $query->result();
        }
        else{
            return false;
        }
    }

    public function insertCotizacionServicio($data)
    {
        $this->db->insert('co_servicio', $data);
        return $this->db->affected_rows();
    }

    public function updateCotizacionServicio($data, $condition)
    {
        $this->db->update('co_servicio', $data, $condition);
        return $this->db->affected_rows();
    }

    public function deleteCotizacionServicio($id)
    {
        $this->db->delete('co_servicio', array('id' => $id));
        return $this->db->affected_rows();
    }
    /*END SERVICIO DETALLE*/

    /* BEGIN REPORTE */
    public function servicioMasCotizado($data)
    {
        $sql_query = "";
        $filters = "";

        if (isset($data['accion'])) {
            if ($data['accion'] == 'filtros') {

                if (isset($data['anio'])) {
                    if ($data['anio'] != '') {
                        $filters .= " AND YEAR(co_cotizacion.info_create) = " . $data['anio'];
                    }
                }

                if (isset($data['mes'])) {
                    if ($data['mes'] != '') {
                        $filters .= " AND MONTH(co_cotizacion.info_create) = " . $data['mes'];
                    }
                }
            }
        }

        $sql_query = $this->db->query(" SELECT
                                            co_sub_servicio.id servicio_id,
                                            co_sub_servicio.nombre servicio_nombre,
                                            COUNT(*) servicio_cantidad
                                        FROM co_cotizacion
                                        INNER JOIN co_servicio ON co_cotizacion.id = co_servicio.cotizacion_id
                                        INNER JOIN co_sub_servicio ON co_servicio.servicio_sub_id = co_sub_servicio.id
                                        INNER JOIN co_servicio_tipo ON co_sub_servicio.servicio_tipo_id = co_servicio_tipo.id
                                        WHERE estado_id = 3". $filters . "
                                        GROUP BY co_servicio_tipo.id,co_servicio_tipo.nombre,co_sub_servicio.id,co_sub_servicio.nombre
                                        ORDER BY COUNT(*) DESC");

        if($sql_query->num_rows()> 0){
            return $sql_query->result();
            //return $this->db->last_query();
        }
        else{
            return false;
        }
    }

    public function mayorServicioCotizado($data)
    {
        $sql_query = "";
        $filters = "";

        if (isset($data['accion'])) {
            if ($data['accion'] == 'filtros') {

                if (isset($data['anio'])) {
                    if ($data['anio'] != '') {
                        $filters .= " AND YEAR(co_cotizacion.info_create) = " . $data['anio'];
                    }
                }

                if (isset($data['mes'])) {
                    if ($data['mes'] != '') {
                        $filters .= " AND MONTH(co_cotizacion.info_create) = " . $data['mes'];
                    }
                }

                if (isset($data['tipo'])) {
                    if ($data['tipo'] == 'particular') {
                        $filters .= " AND co_involucrado.persona_id not in(11,13,19,26,36,53,55,76,224,317,475,550,623,647,709,913,1218,4853,4968,6462,1976,2706,6314)";
                    } else {
                        $filters .= " AND co_involucrado.persona_tipo = 'Juridica' AND co_involucrado.persona_id in(11,13,19,26,36,53,55,76,224,317,475,550,623,647,709,913,1218,4853,4968,6462,1976,2706,6314)";
                    }
                }
            }
        }

        $sql_query = $this->db->query(" SELECT
                                            co_involucrado_rol.nombre,
                                            IF(persona_tipo = 'Natural', co_involucrado_natural.nombre, co_involucrado_juridica.nombre) persona_nombre,
                                            COUNT(*) persona_cantidad
                                        FROM co_cotizacion
                                        INNER JOIN co_involucrado ON co_cotizacion.id = co_involucrado.cotizacion_id
                                        INNER JOIN co_involucrado_rol ON co_involucrado.rol_id = co_involucrado_rol.id
                                        LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id AND co_involucrado.persona_tipo = 'Natural'
                                        LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id AND co_involucrado.persona_tipo = 'Juridica'
                                        WHERE co_cotizacion.estado_id = 3 and rol_id = 2" . $filters . "
                                        GROUP BY co_involucrado_rol.nombre, IF(persona_tipo = 'Natural', co_involucrado_natural.nombre, co_involucrado_juridica.nombre)
                                        ORDER BY COUNT(*) DESC;");

        if($sql_query->num_rows()> 0){
            return $sql_query->result();
            //return $this->db->last_query();
        }
        else{
            return false;
        }
    }

    public function resumenVentasPorServicios($data)
    {
        $sql_query = "";
        $filters = "";

        if (isset($data['accion'])) {
            if ($data['accion'] == 'filtros') {

                if (isset($data['anio'])) {
                    if ($data['anio'] != '') {
                        $filters .= " AND YEAR(co_cotizacion.info_create) = " . $data['anio'];
                    }
                }

                if (isset($data['mes'])) {
                    if ($data['mes'] != '') {
                        $filters .= " AND MONTH(co_cotizacion.info_create) = " . $data['mes'];
                    }
                }
            }
        }

        $sql_query = $this->db->query(" SELECT
                                            IFNULL(co_sub_servicio.id, 0) servicio_id,
                                            IFNULL(co_sub_servicio.nombre, 'OTROS') servicio_nombre,
                                            ROUND(SUM(IF(total_moneda_id = 1, subtotal, 0)),2) soles,
                                            ROUND(SUM(IF(total_moneda_id = 2, subtotal, 0)),2) dolares
                                        FROM co_cotizacion
                                        INNER JOIN co_servicio ON co_cotizacion.id = co_servicio.cotizacion_id
                                        LEFT JOIN co_sub_servicio ON co_servicio.servicio_sub_id = co_sub_servicio.id
                                        /*INNER JOIN co_servicio_tipo ON co_sub_servicio.servicio_tipo_id = co_servicio_tipo.id*/
                                        INNER JOIN co_pago ON co_cotizacion.id = co_pago.cotizacion_id
                                        WHERE codigo <> 0 AND estado_id = 3 " . $filters . "
                                        GROUP BY 
                                            servicio_id,
                                            servicio_nombre
                                        ORDER BY co_sub_servicio.nombre DESC;");

        if($sql_query->num_rows()> 0){
            return $sql_query->result();
            //return $this->db->last_query();
        }
        else{
            return false;
        }
    }
    /* END REPORTE */
}

/* End of file Servicio_m.php */
/* Location: ./application/models/servicio/Servicio_m.php */