<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizacion_m extends CI_Model {

    public function searchCotizacion($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $order = " ORDER BY codigo DESC";
        $limit = "";

        if (isset($search['cotizacion_codigo']) && $search['cotizacion_codigo'] != '')
            $filters .= " AND codigo like '".$search['cotizacion_codigo']."%'";

        if (isset($search['servicio_tipo_id']) && $search['servicio_tipo_id'] != '')
            $filters .= " AND (SELECT
                                GROUP_CONCAT(
                                        servicio_tipo_id
                                        SEPARATOR ','
                                    ) campo
                            FROM co_cotizacion_servicio_tipo_detalle
                            WHERE cotizacion_id = co_cotizacion.id) in (".$search['servicio_tipo_id'].")";

        if (isset($search['coordinador_id']) && $search['coordinador_id'] != '')
            $filters .= " AND co_cotizacion.info_create_user = ".$search['coordinador_id'];

        if (isset($search['vendedor_id']) && $search['vendedor_id'] != '')
            $filters .= " AND vendedor_id = ".$search['vendedor_id'];

        if (isset($search['cliente_nombre']) && $search['cliente_nombre'] != '')
            /*$filters .= " AND IFNULL((SELECT
                                            GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                        FROM co_involucrado
                                        LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                        LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                        WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') like '%".$search['cliente_nombre']."%'";*/
            $filters .= " AND IFNULL((  SELECT
                                            GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                        FROM co_involucrado
                                        LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                        LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                        WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') like '%".$search['cliente_nombre']."%'";

        if (isset($search['solicitante_nombre']) && $search['solicitante_nombre'] != '')
            /*$filters .= " AND IFNULL((SELECT
                                            GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                        FROM co_involucrado
                                        LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                        LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                        WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') like '%".$search['solicitante_nombre']."%'";*/
            $filters .= " AND IFNULL((  SELECT
                                            GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                        FROM co_involucrado
                                        LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                        LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                        WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') like '%".$search['solicitante_nombre']."%'";

        if (isset($search['cotizacion_moneda_monto']) && $search['cotizacion_moneda_monto'] != '')
            $filters .= " AND CONCAT(simbolo,' ',total_monto) like '%".$search['cotizacion_moneda_monto']."%'";

        if(isset($search['tipo_fecha']) && $search['tipo_fecha'] != '') {
            if ($search['tipo_fecha'] == '1') {
                $filters .= " AND DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') BETWEEN '".$search['cotizacion_fecha_desde']."' AND '".$search['cotizacion_fecha_hasta']."'";
            } elseif ($search['tipo_fecha'] == '2') {
                $filters .= " AND DATE_FORMAT(fecha_envio_cliente, '%Y-%m-%d') BETWEEN '".$search['cotizacion_fecha_desde']."' AND '".$search['cotizacion_fecha_hasta']."'";
            } elseif ($search['tipo_fecha'] == '3') {
                $filters .= " AND DATE_FORMAT(fecha_finalizacion, '%Y-%m-%d') BETWEEN '".$search['cotizacion_fecha_desde']."' AND '".$search['cotizacion_fecha_hasta']."'";
            } elseif ($search['tipo_fecha'] == '4') {
                $filters .= " AND IFNULL((SELECT
                                        MAX(DATE_FORMAT(info_create, '%Y-%m-%d'))
                                    FROM co_mensaje
                                    WHERE cotizacion_id = co_cotizacion.id AND co_mensaje.estado_id = 4
                                    GROUP BY co_mensaje.cotizacion_id),'') between '".$search['cotizacion_fecha_desde']."' AND '".$search['cotizacion_fecha_hasta']."'";
            }
        }

        if (isset($search['estado_id']) && $search['estado_id'] != '')
            $filters .= " AND estado_id = ".$search['estado_id'];

        
        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        if (isset($search['order']) && $search['order'] != '') {
            if ($search['order'] == 'monto') {
                $order = " ORDER BY total_monto ".$search['order_type'];
            }
        }

        $sql_query = "  SELECT
                            co_cotizacion.id AS cotizacion_id,
                            codigo AS cotizacion_codigo,
                            cantidad_informe AS cotizacion_cantidad_informe,
                            actualizacion AS cotizacion_actualizacion,
                            tipo_cotizacion_id,
                            /*servicio_tipo_id,*/
                            /*co_servicio_tipo.nombre AS sercivio_tipo_nombre,*/
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
                            WHERE cotizacion_id = co_cotizacion.id) as sercivio_tipo_nombre,
                            co_cotizacion.info_create_user AS coordinador_id,
                            login_user.full_name AS coordinador_nombre,
                            vendedor_id,
                            IFNULL(co_vendedor.nombre,'') AS vendedor_nombre,
                            vendedor_porcentaje_comision,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_nombre,
                            /*IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.nro_documento), CONCAT('* ',involucrado_natural.nro_documento)) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_nro_documento,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.direccion),'') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_direccion,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_contacto.nombre),'') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS contacto_cliente_nombre,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_contacto.telefono),'') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS contacto_cliente_telefono,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_contacto.correo),'') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS contacto_cliente_correo,*/
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_contacto.nombre),'') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS contacto_nombre,
                            total_moneda_id AS moneda_id,
                            simbolo AS moneda_simbolo,
                            codigo_sunat AS moneda_abreviatura,
                            ROUND(total_monto, 2) AS cotizacion_monto,
                            CONCAT(simbolo,' ',ROUND(total_monto, 2)) AS cotizacion_moneda_monto,
                            (CASE
                                WHEN total_moneda_id = 2 THEN
                                    CONCAT(simbolo,ROUND(total_monto, 2))
                                ELSE
                                    CONCAT(simbolo,' ',ROUND(total_monto, 2))
                             END) AS cotizacion_moneda_monto_reporte,
                            IF(fecha_solicitud = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_solicitud,'%d-%m-%Y')) AS cotizacion_fecha_solicitud,
                            IF(fecha_envio_cliente = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_envio_cliente,'%d-%m-%Y')) AS cotizacion_fecha_envio_cliente,
                            IF(fecha_finalizacion = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_finalizacion,'%d-%m-%Y')) AS cotizacion_fecha_finalizacion,
                            IFNULL(DATE_FORMAT((SELECT
                                        MAX(info_create)
                                    FROM co_mensaje
                                    WHERE cotizacion_id = co_cotizacion.id AND co_mensaje.estado_id = 4
                                    GROUP BY co_mensaje.cotizacion_id),'%d-%m-%Y'),'') AS cotizacion_fecha_desestimacion,
                            co_cotizacion.estado_id,
                            co_estado.nombre AS estado_nombre,
                            adjunto as cotizacion_adjunto,
                            co_cotizacion.desglose_id,
                            IF(total_igv = '0', 'con', 'sin') AS cotizacion_igv_check,
                            ROUND(total_monto_igv, 2) AS cotizacion_total,
                            co_pago.id AS pago_id,
                            orden_servicio as cotizacion_orden_servicio,
                            orden_servicio_adjunto as cotizacion_orden_servicio_adjunto,
                            plazo as cotizacion_plazo_entrega,
                            tipo_perito,
                            perito_id,
                            perito_costo,
                            viatico_importe,
                            datos_adicionales
                        FROM co_cotizacion
                        LEFT JOIN co_servicio_tipo ON co_cotizacion.servicio_tipo_id = co_servicio_tipo.id
                        LEFT JOIN login_user ON co_cotizacion.info_create_user = login_user.id
                        LEFT JOIN co_vendedor ON co_cotizacion.vendedor_id = co_vendedor.id
                        LEFT JOIN co_pago ON co_cotizacion.id = co_pago.cotizacion_id
                        LEFT JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
                        LEFT JOIN co_estado ON co_cotizacion.estado_id = co_estado.id
                        WHERE codigo <> 0".$filters.$order.$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function searchCotizacionById($id)
    {
        $sql_query = "  SELECT
                            co_cotizacion.id AS cotizacion_id,
                            codigo AS cotizacion_codigo,
                            cantidad_informe AS cotizacion_cantidad_informe,
                            actualizacion AS cotizacion_actualizacion,
                            tipo_cotizacion_id,
                            /*servicio_tipo_id,*/
                            /*co_servicio_tipo.nombre AS sercivio_tipo_nombre,*/
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
                            WHERE cotizacion_id = co_cotizacion.id) as sercivio_tipo_nombre,
                            co_cotizacion.info_create_user AS coordinador_id,
                            login_user.full_name AS coordinador_nombre,
                            vendedor_id,
                            IFNULL(co_vendedor.nombre,'') AS vendedor_nombre,
                            vendedor_porcentaje_comision,
                            /*ANTIGUO
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_nombre,*/
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_nombre,
                            /*ANTIGUO
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,*/
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,
                            /*ANTIGUO
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_contacto.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS contacto_nombre,*/
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_contacto.nombre),''/*CONCAT('* ',co_involucrado_natural.nombre)*/) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    /*LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id*/
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS contacto_nombre,
                            total_moneda_id AS moneda_id,
                            simbolo AS moneda_simbolo,
                            codigo_sunat AS moneda_abreviatura,
                            ROUND(total_monto, 2) AS cotizacion_monto,
                            CONCAT(simbolo,' ',ROUND(total_monto, 2)) AS cotizacion_moneda_monto,
                            (CASE
                                WHEN total_moneda_id = 2 THEN
                                    CONCAT(simbolo,ROUND(total_monto, 2))
                                ELSE
                                    CONCAT(simbolo,' ',ROUND(total_monto, 2))
                             END) AS cotizacion_moneda_monto_reporte,
                            IF(fecha_solicitud = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_solicitud,'%d-%m-%Y')) AS cotizacion_fecha_solicitud,
                            IF(fecha_envio_cliente = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_envio_cliente,'%d-%m-%Y')) AS cotizacion_fecha_envio_cliente,
                            IF(fecha_finalizacion = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_finalizacion,'%d-%m-%Y')) AS cotizacion_fecha_finalizacion,
                            co_cotizacion.estado_id,
                            co_estado.nombre AS estado_nombre,
                            adjunto as cotizacion_adjunto,
                            co_cotizacion.desglose_id,
                            IF(total_igv = '0', 'con', 'sin') AS cotizacion_igv_check,
                            ROUND(total_monto_igv, 2) AS cotizacion_total,
                            co_pago.id AS pago_id,
                            orden_servicio as cotizacion_orden_servicio,
                            plazo as cotizacion_plazo_entrega,
                            tipo_perito,
                            perito_id,
                            perito_costo,
                            viatico_importe,
                            datos_adicionales
                        FROM co_cotizacion
                        LEFT JOIN co_servicio_tipo ON co_cotizacion.servicio_tipo_id = co_servicio_tipo.id
                        LEFT JOIN login_user ON co_cotizacion.info_create_user = login_user.id
                        LEFT JOIN co_vendedor ON co_cotizacion.vendedor_id = co_vendedor.id
                        LEFT JOIN co_pago ON co_cotizacion.id = co_pago.cotizacion_id
                        LEFT JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
                        LEFT JOIN co_estado ON co_cotizacion.estado_id = co_estado.id
                        WHERE co_cotizacion.id = ".$id.";";

        $records = $this->db->query($sql_query);
        return $records->row();
    }
    
    public function countCotizacionEstados()
    {
        return $data = array(
                                'pendiente' => $this->searchCotizacion(array('estado_id' => 1)) == false ? 0 : count($this->searchCotizacion(array('estado_id' => 1))),
                                'aprobado' => $this->searchCotizacion(array('estado_id' => 3)) == false ? 0 : count($this->searchCotizacion(array('estado_id' => 3))),
                                'desestimado' => $this->searchCotizacion(array('estado_id' => 4)) == false ? 0 : count($this->searchCotizacion(array('estado_id' => 4)))
                            );
    }

    public function searchCotizacionFacturacion($data)
    {
        $sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['accion'])) {

            if ($data['accion'] == 'filtros') {
                $order .= " ORDER BY IF(ad_existe = 0, 0, IF(cotizacion_monto = ad_monto_facturado, 1, 0)) ASC, codigo DESC";

                if (isset($data['cotizacion_codigo'])) {
                    if ($data['cotizacion_codigo'] != '') {
                        $filters .= " AND codigo = '".$data['cotizacion_codigo']."'";
                    }
                }
                
                if (isset($data['solicitante_nombre'])) {
                    if ($data['solicitante_nombre'] != '') {
                        /*$filters .= " AND IFNULL((SELECT
                                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                                    FROM co_involucrado
                                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') like '%".$data['solicitante_nombre']."%'";*/

                        $filters .= " AND IFNULL((SELECT
                                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                                    FROM co_involucrado
                                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') like '%".$data['solicitante_nombre']."%'";
                    }
                }

                if (isset($data['cliente_nombre'])) {
                    if ($data['cliente_nombre'] != '') {
                        /*$filters .= " AND IFNULL((SELECT
                                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                                    FROM co_involucrado
                                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') like '%".$data['cliente_nombre']."%'";*/

                         $filters .= " AND IFNULL((SELECT
                                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                                    FROM co_involucrado
                                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') like '%".$data['cliente_nombre']."%'";
                    }
                }

                /*if (isset($data['cotizacion_fecha_finalizacion'])) {
                    if ($data['cotizacion_fecha_finalizacion'] != '') {
                        $filters .= " AND IF(fecha_finalizacion = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_finalizacion,'%d-%m-%Y')) like '%".$data['cotizacion_fecha_finalizacion']."%'";
                    }
                }*/

                if (isset($data['servicio_tipo_id'])) {
                    if ($data['servicio_tipo_id'] != '') {
                        $filters .= " AND (SELECT
                                                GROUP_CONCAT(
                                                        servicio_tipo_id
                                                        SEPARATOR ','
                                                    ) campo
                                            FROM co_cotizacion_servicio_tipo_detalle
                                            WHERE cotizacion_id = co_cotizacion.id) in (".$data['servicio_tipo_id'].")";
                    }
                }

                if (isset($data['coordinador_id'])) {
                    if ($data['coordinador_id'] != '') {
                        $filters .= " AND co_cotizacion.info_create_user = ".$data['coordinador_id'];
                    }
                }

                if (isset($data['cotizacion_moneda_monto'])) {
                    if ($data['cotizacion_moneda_monto'] != '') {
                        $filters .= " AND CONCAT(simbolo,' ',total_monto) like '%".$data['cotizacion_moneda_monto']."%'";
                    }
                }

                if (isset($data['vendedor_id'])) {
                    if ($data['vendedor_id'] != '') {
                        $filters .= " AND vendedor_id = ".$data['vendedor_id'];
                    }
                }

                if (isset($data['estado_id'])) {
                    if ($data['estado_id'] != '') {
                        $filters .= " AND estado_id = ".$data['estado_id'];
                    }
                }
            }
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        $sql_query =    "SELECT
                            co_cotizacion.id cotizacion_id,
                            codigo cotizacion_codigo,
                            /*IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_nombre,*/
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') AS cliente_nombre,
                            /*IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,*/
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',involucrado_juridico.razon_social),CONCAT('* ',CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres))) SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                    LEFT JOIN involucrado_juridico ON co_involucrado.persona_id_new = involucrado_juridico.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,
                            IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', IF(co_involucrado_juridica.abreviatura = '', 'PART', co_involucrado_juridica.abreviatura), 'PART') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_abreviatura,
                            cantidad_informe contizacion_cantidad_informe,
                            IF(fecha_finalizacion = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_finalizacion,'%d-%m-%Y')) cotizacion_fecha_finalizacion,
                            /*servicio_tipo_id,
                            co_servicio_tipo.nombre servicio_tipo_nombre,*/
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
                            co_cotizacion.info_create_user coordinador_id,
                            login_user.full_name coordinador_nombre,
                            desglose_id,
                            co_desglose.nombre desglose_nombre,
                            total_moneda_id moneda_id,
                            simbolo moneda_simbolo,
                            IF(total_igv = 0, 'con','sin') cotizacion_igv_check,
                            ROUND(total_monto,2) cotizacion_monto,
                            CONCAT(simbolo,' ',ROUND(total_monto,2)) cotizacion_moneda_monto,
                            ROUND(total_monto_igv,2) cotizacion_monto_igv,
                            vendedor_id,
                            IFNULL(co_vendedor.nombre,'') AS vendedor_nombre,
                            IF(tipo_perito = 1, 'OFICINA', 'EXTERNO') tipo_perito,
                            perito_id,
                            IFNULL(perito.full_name,'') perito_nombre,
                            perito_costo,
                            orden_servicio,
                            (SELECT COUNT(*) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id) AS ad_existe,
                            IFNULL((SELECT IF(igv_tipo = 'sin', SUM(ad_subtotal), SUM(ad_total)) FROM ad_facturacion where cotizacion_id = co_cotizacion.id AND ad_facturacion.estado_id IN (1,2,3)), 0) AS ad_monto_facturado,
                            IFNULL((SELECT ad_porcentaje FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id LIMIT 1),0) ad_porcentaje,
                            IFNULL((SELECT SUM(ad_porcentaje_num) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id and ad_facturacion.estado_id <> 4),0) ad_porcentaje_num,
                            IFNULL((SELECT
                                GROUP_CONCAT(CONCAT('Tas',IFNULL((SELECT
                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', IF(co_involucrado_juridica.abreviatura = '', 'PART', co_involucrado_juridica.abreviatura), 'PART') SEPARATOR '|') campo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),''),SUBSTR(co_cotizacion.codigo,1,4),'-',cotizacion_correlativo) SEPARATOR ' / ') campo
                            FROM coor_coordinacion
                            WHERE cotizacion_id = co_cotizacion.id
                            ORDER BY cotizacion_correlativo ASC),'') cotizacion_coordinaciones,
                            orden_servicio
                        FROM co_cotizacion
                        LEFT JOIN login_user ON co_cotizacion.info_create_user = login_user.id
                        LEFT JOIN co_servicio_tipo ON co_cotizacion.servicio_tipo_id = co_servicio_tipo.id
                        LEFT JOIN login_user perito ON co_cotizacion.perito_id = perito.id
                        LEFT JOIN co_vendedor ON co_cotizacion.vendedor_id = co_vendedor.id
                        LEFT JOIN co_desglose ON co_cotizacion.desglose_id = co_desglose.id
                        LEFT JOIN co_pago ON co_cotizacion.id = co_pago.cotizacion_id
                        LEFT JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
                        LEFT JOIN co_estado ON co_cotizacion.estado_id = co_estado.id
                        WHERE codigo <> 0".$filters.$order.$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function searchCotizacionPropuesta($data)
    {
        $sql_query = "";
        $filters = "";
        $limit = "";

        if (isset($data['cotizacion_codigo']))
            $filters .= " WHERE codigo = ".$data['cotizacion_codigo'];

        if (isset($data['rol_id']) && $filters == "")
            $filters .= " WHERE rol_id = ".$data['rol_id'];
        else if (isset($data['rol_id']) && $filters != "")
            $filters .= " AND rol_id = ".$data['rol_id'];

        if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'].";";


        $sql_query = $this->db->query(" SELECT
                                            IF(fecha_finalizacion = '0000-00-00 00:00:00',DATE_FORMAT(NOW(),'%d-%m-%Y'),DATE_FORMAT(fecha_finalizacion,'%d-%m-%Y')) AS fecha,
                                            co_cotizacion.id AS id,
                                            codigo AS codigo,
                                            tipo_cotizacion_id AS tipo,
                                            /*ANTIGUO
                                            IF(co_involucrado.contacto_id = 0, 'PERSONA NATURAL', co_involucrado_juridica.nombre) AS empresa,
                                            IF(co_involucrado.contacto_id = 0, co_involucrado_natural.nombre, co_involucrado_contacto.nombre) AS involucrado,*/
                                            IF(co_involucrado.contacto_id = 0, 'PERSONA NATURAL', involucrado_juridico.razon_social) AS empresa,
                                            IF(co_involucrado.contacto_id = 0, CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres), co_involucrado_contacto.nombre) AS involucrado,
                                            IF(co_involucrado.contacto_id = 0, 'PERSONA NATURAL', co_involucrado_contacto.cargo) AS cargo,
                                            /*co_servicio_tipo.id AS servicio_id,
                                            co_servicio_tipo.nombre*/
                                            (SELECT
                                                GROUP_CONCAT(
                                                        servicio_tipo_id
                                                        SEPARATOR ','
                                                    ) campo
                                            FROM co_cotizacion_servicio_tipo_detalle
                                            WHERE cotizacion_id = co_cotizacion.id) AS servicio_id,
                                            (SELECT
                                                GROUP_CONCAT(
                                                        nombre
                                                        SEPARATOR ', '
                                                    ) campo
                                            FROM co_cotizacion_servicio_tipo_detalle
                                            LEFT JOIN co_servicio_tipo ON co_cotizacion_servicio_tipo_detalle.servicio_tipo_id = co_servicio_tipo.id
                                            WHERE cotizacion_id = co_cotizacion.id) AS servicio,
                                            datos_adicionales,
                                            plazo,
                                            IF(total_igv = '0', 'con', 'sin') igv_check,
                                            ROUND(total_monto, 2) AS monto,
                                            ROUND(total_monto_igv, 2) AS monto_igv,
                                            
                                            porcentaje impuesto,
                                            CAST(if(total_igv_de = 'sin', total_monto, total_monto/ (1 + (porcentaje/100))) AS DECIMAL(18,2)) subtotal,
                                            CAST(if(total_igv_de = 'sin', total_monto * (porcentaje/100), total_monto - total_monto/ (1 + (porcentaje/100))) AS DECIMAL(18,2)) igv,
                                            CAST(if(total_igv_de = 'sin', total_monto * (1 + (porcentaje/100)), total_monto) AS DECIMAL(18,2)) total,

                                            co_moneda.nombre AS moneda,
                                            simbolo AS simbolo,
                                            co_desglose.id desglose_id,
                                            co_desglose.nombre AS desglose,
                                            login_user.email AS email
                                        FROM co_cotizacion
                                        INNER JOIN login_user ON co_cotizacion.info_create_user = login_user.id
                                        INNER JOIN co_involucrado ON co_cotizacion.id = co_involucrado.cotizacion_id
                                        /*ANTIGUO
                                        LEFT JOIN co_involucrado_juridica  ON co_involucrado.persona_id = co_involucrado_juridica.id
                                        LEFT JOIN co_involucrado_natural ON co_involucrado_natural.id = co_involucrado.persona_id*/
                                        LEFT JOIN involucrado_juridico  ON co_involucrado.persona_id_new = involucrado_juridico.id
                                        LEFT JOIN involucrado_natural ON co_involucrado.persona_id_new = involucrado_natural.id
                                        LEFT JOIN co_involucrado_contacto ON co_involucrado_contacto.id = co_involucrado.contacto_id
                                        /*INNER JOIN co_servicio_tipo ON co_servicio_tipo.id = co_cotizacion.servicio_tipo_id*/
                                        INNER JOIN co_pago ON co_cotizacion.id = co_pago.cotizacion_id
                                        INNER JOIN co_impuesto ON co_pago.impuesto_id = co_impuesto.id
                                        INNER JOIN co_cotizacion_tipo ON co_cotizacion_tipo.id = co_cotizacion.tipo_cotizacion_id
                                        INNER JOIN co_moneda ON co_moneda.id = co_pago.total_moneda_id
                                        INNER JOIN co_desglose ON co_desglose.id = co_cotizacion.desglose_id".$filters.$limit);
        if($sql_query->num_rows() > 0)
            return $sql_query->row();
        else
            return false;
    }

    public function obtenerCorrelativo()
    {
        $sql_query = "  SELECT
                            CONCAT(YEAR(NOW()),LPAD(IFNULL(MAX(RIGHT(CODIGO,6)),0) + 1,6,0)) cotizacion_correlativo
                        FROM co_cotizacion
                        WHERE LEFT(codigo,4) = YEAR(NOW())";
        $records = $this->db->query($sql_query);
        return $records->row();
    }

    public function Insert($data)
    {
        $this->db->insert('co_cotizacion', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('co_cotizacion', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    
    /*BEGIN COTIZACIÓN SERVICIO TIPO*/  
    public function insertCotizacionDetalle($data)
    {
        $this->db->insert('co_cotizacion_servicio_tipo_detalle', $data);
        return $this->db->affected_rows();
    }

    public function deleteCotizacionDetalle($data)
    {
        $this->db->delete('co_cotizacion_servicio_tipo_detalle', $data);
        return $this->db->affected_rows();
    }
}

/* End of file Cotizacion_m.php */
/* Location: ./application/models/cotizaciones/Cotizacion_m.php */