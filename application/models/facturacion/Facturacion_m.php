<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion_m extends CI_Model {

	public function searchFacturacion($data)
	{
		$filters = "";
		$order = "";
        $limit = "";

       	if (isset($data['accion'])) {

       		if ($data['accion'] == 'informacion') {

       			$filters .= " WHERE ad_facturacion.cotizacion_id = ".$data['cotizacion_id'];
				$order .= " ORDER BY ad_fecha_emision ASC";

       		} elseif ($data['accion'] == 'generar_pdf') {

       			$filters .= " WHERE ad_id = ".$data['ad_id'];

       		} elseif ($data['accion'] == 'filtros') {
       			$order .= " ORDER BY ad_id DESC, ad_fecha_emision DESC";
       			if (isset($data['cotizacion_codigo'])) {
	       			if ($data['cotizacion_codigo'] != '') {
	       				$filters .= " WHERE codigo = ".$data['cotizacion_codigo'];
	       			}
	       		}

	       		if (isset($data['factura_correlativo'])) {
	       			if ($data['factura_correlativo'] != '' && $filters == '') {
	       				$filters .= " WHERE IF(ad_correlativo_documento = 0, '', CONCAT(LEFT(ad_facturacion_tipo_comprobante.nombre,1),lpad(ad_correlativo_documento,10,'0'))) LIKE '%".$data['factura_correlativo']."%'";
	       			} elseif ($data['factura_correlativo'] != '' && $filters != '') {
	       				$filters .= " AND IF(ad_correlativo_documento = 0, '', CONCAT(LEFT(ad_facturacion_tipo_comprobante.nombre,1),lpad(ad_correlativo_documento,10,'0'))) LIKE '%".$data['factura_correlativo']."%'";
	       			}
	       		}

	       		if (isset($data['solicitante_nombre'])) {
	       			if ($data['solicitante_nombre'] != '' && $filters == '') {
	       				$filters .= " WHERE (CASE
												WHEN solicitante_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_id)
											END) LIKE '%".$data['solicitante_nombre']."%'";
	       			} elseif ($data['solicitante_nombre'] != '' && $filters != '') {
	       				$filters .= " AND (CASE
												WHEN solicitante_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = solicitante_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = solicitante_id)
											END) LIKE '%".$data['solicitante_nombre']."%'";
	       			}
	       		}

	       		if (isset($data['cliente_nombre'])) {
	       			if ($data['cliente_nombre'] != '' && $filters == '') {
	       				$filters .= " WHERE (CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_facturado_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_facturado_id)
											END) LIKE '%".$data['cliente_nombre']."%'";
	       			} elseif ($data['cliente_nombre'] != '' && $filters != '') {
	       				$filters .= " AND (CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_facturado_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_facturado_id)
											END) LIKE '%".$data['cliente_nombre']."%'";
	       			}
	       		}

	       		if (isset($data['servicio_tipo_id'])) {
	       			if ($data['servicio_tipo_id'] != '' && $filters == '') {
	       				$filters .= " WHERE ad_facturacion.servicio_tipo_id = ".$data['servicio_tipo_id'];
	       			} elseif ($data['servicio_tipo_id'] != '' && $filters != '') {
	       				$filters .= " AND ad_facturacion.servicio_tipo_id = ".$data['servicio_tipo_id'];
	       			}
	       		}

	       		if (isset($data['perito_id'])) {
	       			if ($data['perito_id'] != '' && $filters == '') {
	       				$filters .= " WHERE perito_id = ".$data['perito_id'];
	       			} elseif ($data['perito_id'] != '' && $filters != '') {
	       				$filters .= " AND perito_id = ".$data['perito_id'];
	       			}
	       		}

	       		if (isset($data['vendedor_id'])) {
	       			if ($data['vendedor_id'] != '' && $filters == '') {
	       				$filters .= " WHERE vendedor_id = ".$data['vendedor_id'];
	       			} elseif ($data['vendedor_id'] != '' && $filters != '') {
	       				$filters .= " AND vendedor_id = ".$data['vendedor_id'];
	       			}
	       		}

	       		if (isset($data['ad_importe_moneda'])) {
	       			if ($data['ad_importe_moneda'] != '' && $filters == '') {
	       				$filters .= " WHERE IF(igv_tipo = 'sin', CONCAT(co_moneda.simbolo,' ',ad_subtotal), CONCAT(co_moneda.simbolo,' ',ad_total)) LIKE '%".$data['ad_importe_moneda']."%'";
	       			} elseif ($data['ad_importe_moneda'] != '' && $filters != '') {
	       				$filters .= " AND IF(igv_tipo = 'sin', CONCAT(co_moneda.simbolo,' ',ad_subtotal), CONCAT(co_moneda.simbolo,' ',ad_total)) LIKE '%".$data['ad_importe_moneda']."%'";
	       			}
	       		}

       			if (isset($data['estado_id'])) {
       				if ($data['estado_id'] != '' && $filters == '') {
	       				$filters .= " WHERE ad_facturacion.estado_id = ".$data['estado_id'];
	       			} elseif ($data['estado_id'] != '' && $filters != '') {
	       				$filters .= " AND ad_facturacion.estado_id = ".$data['estado_id'];
	       			}
       			}

       			if (isset($data['estado_pago_perito'])) {
       				if ($data['estado_pago_perito'] != '' && $filters == '') {
	       				$filters .= " WHERE estado_pago_perito = ".$data['estado_pago_perito'];
	       			} elseif ($data['estado_pago_perito'] != '' && $filters != '') {
	       				$filters .= " AND estado_pago_perito = ".$data['estado_pago_perito'];
	       			}
       			}

       			if (isset($data['fecha_tipo'])) {
       				if ($data['fecha_tipo'] == 1) {
       					if ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters == '') {
		       				$filters .= " WHERE ad_fecha_emision BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			} elseif ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters != '') {
		       				$filters .= " AND ad_fecha_emision BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			}
       				} elseif ($data['fecha_tipo'] == 2) {
       					if ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters == '') {
		       				$filters .= " WHERE ad_fecha_pago BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			} elseif ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters != '') {
		       				$filters .= " AND ad_fecha_pago BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			}
       				}
       			}
       		}
       	}

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query(" SELECT
											ad_id,
										    ad_facturacion.cotizacion_id,
										    ad_tipo_documento tipo_comprobante_id,
										    codigo AS cotizacion_codigo,
										    ad_facturacion_tipo_comprobante.nombre tipo_comprobante_nombre,
										    lpad(ad_correlativo_documento,3,'0') tipo_comprobante_correlativo,
										    IF(ad_correlativo_documento = 0, '', CONCAT(LEFT(ad_facturacion_tipo_comprobante.nombre,1),lpad(ad_correlativo_documento,3,'0'))) tipo_comprobante_nombre_correlativo,
										    IFNULL((CASE
												WHEN solicitante_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_id)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_id)
											END),'') solicitante_nombre,
										    IF(facturado_por = 1, 'Solicitante', IF(facturado_por = 2, 'Cliente', 'Otros')) facturado_por,
										    cliente_facturado_id,
										    cliente_facturado_tipo,
										    IFNULL((CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_facturado_id)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_facturado_id)
											END),'') cliente_facturado_nombre,
											(CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT co_involucrado_documento_tipo.abreviatura FROM involucrado_juridico INNER JOIN co_involucrado_documento_tipo ON involucrado_juridico.tipo_documento_id = co_involucrado_documento_tipo.id WHERE involucrado_juridico.id = cliente_facturado_id)
												ELSE
													(SELECT co_involucrado_documento_tipo.abreviatura FROM involucrado_natural INNER JOIN co_involucrado_documento_tipo ON involucrado_natural.tipo_documento_id = co_involucrado_documento_tipo.id WHERE involucrado_natural.id = cliente_facturado_id)
											END) cliente_facturado_tipo_documento,
											(CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT nro_documento FROM involucrado_juridico WHERE involucrado_juridico.id = cliente_facturado_id)
												ELSE
													(SELECT nro_documento FROM involucrado_natural WHERE involucrado_natural.id = cliente_facturado_id)
											END) cliente_facturado_nro_documento,
											(CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT direccion FROM involucrado_juridico WHERE involucrado_juridico.id = cliente_facturado_id)
												ELSE
													(SELECT direccion FROM involucrado_natural WHERE involucrado_natural.id = cliente_facturado_id)
											END) cliente_facturado_direccion,
										    /*ad_facturacion.servicio_tipo_id,
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
										    co_cotizacion.tipo_perito ad_tipo_perito_id,
                                            IF(co_cotizacion.tipo_perito = 1, 'OFICINA', 'EXTERNO') ad_tipo_perito_nombre,
                                            co_cotizacion.perito_id,
                                            IF(co_cotizacion.perito_id = 0, 'OFICINA', login_user.full_name) perito_nombre,
                                            co_cotizacion.perito_costo,
                                            IFNULL(vendedor_id, '0') vendedor_id,
                                            IF(IFNULL(vendedor_id, '0') = 0, '', co_vendedor.nombre) vendedor_nombre,
										    igv_tipo,
										    desglose_id,
										    co_moneda.id moneda_id,
										    co_moneda.codigo_sunat moneda_abreviatura,
										    co_moneda.simbolo moneda_simbolo,
										    co_moneda.nombre moneda_nombre,
										    ad_subtotal,
										    ad_igv,
										    ad_total,
										    IF(igv_tipo = 'sin', ad_subtotal, ad_total) ad_importe,
										    IF(igv_tipo = 'sin', CONCAT(co_moneda.simbolo,' ',ad_subtotal,' + IGV'), CONCAT(co_moneda.simbolo,' ',ad_total)) ad_importe_simbolo,
										    IF(ad_fecha_emision = '0000-00-00 00:00:00','',DATE_FORMAT(ad_fecha_emision,'%d-%m-%Y')) ad_fecha_emision_entrega,
										    IF(ad_fecha_pago = '0000-00-00','',DATE_FORMAT(ad_fecha_pago,'%d-%m-%Y')) ad_fecha_pago,
										    IF(ad_fecha_vencimiento = '0000-00-00','',DATE_FORMAT(ad_fecha_vencimiento,'%d-%m-%Y')) ad_fecha_vencimiento,
										    IF(ad_fech_create = '0000-00-00','',DATE_FORMAT(ad_fech_create,'%d-%m-%Y')) ad_fech_create,
										    ad_porcentaje,
										    ad_porcentaje_num,
										    ad_atencion,
										    ad_correo,
										    ad_concepto,
										    ad_codigo_tasacion,
										    co_cotizacion.orden_servicio ad_orden_servicio,
											ad_nro_aprobacion,
										    ad_observacion,
										    ad_adjunto_xml,
										    ad_adjunto_pdf,
										    ad_facturacion.estado_id,
										    ad_facturacion_estados.nombre estado_nombre,
										    estado_pago_perito,
										    CAST(fecha_pago_perito AS DATE) fecha_pago_perito,
											ad_nota_credito
										FROM ad_facturacion
										INNER JOIN co_cotizacion ON ad_facturacion.cotizacion_id = co_cotizacion.id
										INNER JOIN co_pago ON ad_facturacion.cotizacion_id = co_pago.cotizacion_id
										INNER JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
										INNER JOIN ad_facturacion_tipo_comprobante ON ad_facturacion.ad_tipo_documento = ad_facturacion_tipo_comprobante.id
										/*INNER JOIN co_servicio_tipo ON ad_facturacion.servicio_tipo_id = co_servicio_tipo.id*/
                                        LEFT JOIN login_user ON co_cotizacion.perito_id = login_user.id
                                        LEFT JOIN co_vendedor ON co_cotizacion.vendedor_id = co_vendedor.id
										INNER JOIN ad_facturacion_estados ON ad_facturacion.estado_id = ad_facturacion_estados.id".$filters.$order.$limit);
        if($sql_query->num_rows() > 0) {
        	if (isset($data['accion']) && $data['accion'] == 'generar_pdf')
            	return $sql_query->row();
            else
            	return $sql_query->result();
        }
        else
            return false;
	}

	public function countFacturacionEstados()
	{
		return $data = array(
								'por_facturar' => $this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 1)) == false ? 0 : count($this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 1))),
								'facturado' => $this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 2)) == false ? 0 : count($this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 2))),
								'cancelado' => $this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 3)) == false ? 0 : count($this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 3))),
								'anulado' => $this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 4)) == false ? 0 : count($this->searchFacturacion(array('accion' => 'filtros', 'estado_id' => 4)))
							);
	}

	public function facturacionCorrelativo($tipo_documento)
	{
		$query = $this->db->query("	SELECT
										MAX(ad_correlativo_documento) + 1 correlativo_comprobante
									FROM ad_facturacion
									WHERE ad_tipo_documento = $tipo_documento;");
        return $query->row();
	}

	public function searchPagoPerito($data)
	{
		$filters = "";
		$order = "";
		$group_by = "";
        $limit = "";

        if (isset($data['accion'])) {

       		if ($data['accion'] == 'detalle_comprobantes_proyecto') {
       			$filters .= " WHERE ad_facturacion.cotizacion_id = ".$data['cotizacion_id'];
				//$order .= " ORDER BY codigo DESC";
       		} else if ($data['accion'] == 'group_by') {
       			$group_by .= " GROUP BY codigo";
       		} else {
       			if (isset($data['cotizacion_codigo'])) {
	       			if ($data['cotizacion_codigo'] != '') {
	       				$filters .= " WHERE codigo = ".$data['cotizacion_codigo'];
	       			}
	       		}

       			if (isset($data['cliente_nombre'])) {
	       			if ($data['cliente_nombre'] != '' && $filters == '') {
	       				$filters .= " WHERE (CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_facturado_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_facturado_id)
											END) LIKE '%".$data['cliente_nombre']."%'";
	       			} elseif ($data['cliente_nombre'] != '' && $filters != '') {
	       				$filters .= " AND (CASE
												WHEN cliente_facturado_tipo = 'Juridica' THEN
													(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_facturado_id)
												ELSE
													(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_facturado_id)
											END) LIKE '%".$data['cliente_nombre']."%'";
	       			}
	       		}

	       		if (isset($data['servicio_tipo_id'])) {
	       			if ($data['servicio_tipo_id'] != '' && $filters == '') {
	       				$filters .= " WHERE ad_facturacion.servicio_tipo_id = ".$data['servicio_tipo_id'];
	       			} elseif ($data['servicio_tipo_id'] != '' && $filters != '') {
	       				$filters .= " AND ad_facturacion.servicio_tipo_id = ".$data['servicio_tipo_id'];
	       			}
	       		}

	       		if (isset($data['perito_id'])) {
	       			if ($data['perito_id'] != '' && $filters == '') {
	       				$filters .= " WHERE perito_id = ".$data['perito_id'];
	       			} elseif ($data['perito_id'] != '' && $filters != '') {
	       				$filters .= " AND perito_id = ".$data['perito_id'];
	       			}
	       		}

	       		if (isset($data['estado_id'])) {
       				if ($data['estado_id'] != '' && $filters == '') {
	       				$filters .= " WHERE ad_facturacion.estado_id = ".$data['estado_id'];
	       			} elseif ($data['estado_id'] != '' && $filters != '') {
	       				$filters .= " AND ad_facturacion.estado_id = ".$data['estado_id'];
	       			}
       			}

       			if (isset($data['estado_pago_perito'])) {
       				if ($data['estado_pago_perito'] != '' && $filters == '') {
	       				$filters .= " WHERE estado_pago_perito = ".$data['estado_pago_perito'];
	       			} elseif ($data['estado_pago_perito'] != '' && $filters != '') {
	       				$filters .= " AND estado_pago_perito = ".$data['estado_pago_perito'];
	       			}
       			}

       			if (isset($data['fecha_tipo'])) {
       				if ($data['fecha_tipo'] == 1) {
       					if ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters == '') {
		       				$filters .= " WHERE ad_fecha_emision BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			} elseif ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters != '') {
		       				$filters .= " AND ad_fecha_emision BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			}
       				} elseif ($data['fecha_tipo'] == 2) {
       					if ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters == '') {
		       				$filters .= " WHERE fecha_pago_perito BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			} elseif ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters != '') {
		       				$filters .= " AND fecha_pago_perito BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       			}
       				}
       			}

       			if (isset($data['group'])) {
       				$group_by = " GROUP BY codigo";
       				$order .= " ORDER BY codigo ASC";
       			}

       			if (isset($data['accion']) && $data['accion'] == 'filtros' && !isset($data['group'])) {
       				$order .= " ORDER BY codigo DESC";
       			}
       		}
       	}

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query(" SELECT
											ad_facturacion.ad_id,
										    ad_facturacion.cotizacion_id,
										    codigo cotizacion_codigo,
										    IFNULL((SELECT
		                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
		                                    FROM co_involucrado
		                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
		                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
		                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,
										    IFNULL((SELECT
														GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
													FROM co_involucrado
													LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
													LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
													WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') cliente_nombre,
											co_servicio_tipo.nombre servicio_tipo_nombre,
										    total_moneda_id moneda_id,
										    co_moneda.simbolo moneda_simbolo,
											co_moneda.nombre moneda_nombre,
										    ROUND(total_monto_igv, 2) cotizacion_importe_proyecto,
										    IFNULL(login_user.full_name,'OFICINA') perito_nombre,
										    ROUND(perito_costo, 2) perito_costo,
										    IF(ad_correlativo_documento = 0, '', CONCAT(LEFT(ad_facturacion_tipo_comprobante.nombre,1),LPAD(ad_correlativo_documento,3,'0'))) tipo_comprobante_nombre_correlativo,
										    ad_facturacion.estado_id,
										    ad_facturacion_estados.nombre estado_nombre,
										    IF(ad_fecha_emision = '0000-00-00 00:00:00','',DATE_FORMAT(ad_fecha_emision,'%d-%m-%Y')) ad_fecha_emision_entrega,
										    ad_total ad_total_facturado,
										    ROUND(IF(tipo_perito = 1, 0, IF(ad_porcentaje = 1, perito_costo * (ad_porcentaje_num/100), perito_costo)),2) perito_costo_comprobante,
										    estado_pago_perito estado_pago_perito_id,
										    IF(estado_pago_perito = 0, 'Pendiente','Cancelado') estado_pago_perito,
										    IF(fecha_pago_perito = '0000-00-00 00:00:00','',DATE_FORMAT(fecha_pago_perito,'%d-%m-%Y')) fecha_pago_perito,
										    (SELECT COUNT(*) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_id = 3 AND estado_pago_perito = 0) cantidad_comprobantes_pendientes
										FROM ad_facturacion
										INNER JOIN co_cotizacion ON ad_facturacion.cotizacion_id = co_cotizacion.id
										INNER JOIN co_pago ON ad_facturacion.cotizacion_id = co_pago.cotizacion_id
										INNER JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
										INNER JOIN ad_facturacion_tipo_comprobante ON ad_facturacion.ad_tipo_documento = ad_facturacion_tipo_comprobante.id
										INNER JOIN co_servicio_tipo ON ad_facturacion.servicio_tipo_id = co_servicio_tipo.id
										LEFT JOIN login_user ON co_cotizacion.perito_id = login_user.id
										LEFT JOIN co_vendedor ON co_cotizacion.vendedor_id = co_vendedor.id
										INNER JOIN ad_facturacion_estados ON ad_facturacion.estado_id = ad_facturacion_estados.id".$filters.$group_by.$order.$limit);
        if($sql_query->num_rows() > 0)
        	return $sql_query->result();
        else
            return false;
	}

	public function searchRentabilidad($data)
	{
		$filters = "";
		$order = "";
		$group_by = "";
        $limit = "";

        if (isset($data['accion'])) {

       		if ($data['accion'] == 'vendedor') {
				$group_by .= " GROUP BY codigo";
				$order .= " ORDER BY codigo DESC";
       		}

       		if (isset($data['cotizacion_codigo'])) {
	       		if ($data['cotizacion_codigo'] != '') {
	       			$filters .= " WHERE codigo = ".$data['cotizacion_codigo'];
	       		}
	       	}

       		if (isset($data['cliente_nombre'])) {
	       		if ($data['cliente_nombre'] != '' && $filters == '') {
	       			$filters .= " WHERE (CASE
											WHEN cliente_facturado_tipo = 'Juridica' THEN
												(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_facturado_id)
											ELSE
												(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_facturado_id)
										END) LIKE '%".$data['cliente_nombre']."%'";
	       		} elseif ($data['cliente_nombre'] != '' && $filters != '') {
	       			$filters .= " AND (CASE
											WHEN cliente_facturado_tipo = 'Juridica' THEN
												(SELECT nombre FROM co_involucrado_juridica WHERE id = cliente_facturado_id)
											ELSE
												(SELECT nombre FROM co_involucrado_natural WHERE id = cliente_facturado_id)
										END) LIKE '%".$data['cliente_nombre']."%'";
	       		}
	       	}

	       	if (isset($data['servicio_tipo_id'])) {
	       		if ($data['servicio_tipo_id'] != '' && $filters == '') {
	       			$filters .= " WHERE ad_facturacion.servicio_tipo_id = ".$data['servicio_tipo_id'];
	       		} elseif ($data['servicio_tipo_id'] != '' && $filters != '') {
	       			$filters .= " AND ad_facturacion.servicio_tipo_id = ".$data['servicio_tipo_id'];
	       		}
	       	}

	       	if (isset($data['estado_rentabilidad_id'])) {
       			if ($data['estado_rentabilidad_id'] != '' && $filters == '') {
       				if ($data['estado_rentabilidad_id'] == 0) {
       					$filters .= " WHERE ROUND(total_monto_igv, 2)-(SELECT IFNULL(SUM(ad_total),0) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_id = 3) > 0";
       				} elseif ($data['estado_rentabilidad_id'] == 1) {
       					$filters .= " WHERE ROUND(total_monto_igv, 2)-(SELECT IFNULL(SUM(ad_total),0) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_id = 3) = 0";
       				}
	       		} elseif ($data['estado_rentabilidad_id'] != '' && $filters != '') {
	       			if ($data['estado_rentabilidad_id'] == 0) {
       					$filters .= " AND ROUND(total_monto_igv, 2)-(SELECT IFNULL(SUM(ad_total),0) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_id = 3) > 0";
       				} elseif ($data['estado_rentabilidad_id'] == 1) {
       					$filters .= " AND ROUND(total_monto_igv, 2)-(SELECT IFNULL(SUM(ad_total),0) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_id = 3) = 0";
       				}
	       		}
       		}

	       	if (isset($data['vendedor_id'])) {
	       		if ($data['vendedor_id'] != '' && $filters == '') {
	       			if ($data['vendedor_id'] == 2) {
	       				$filters .= " WHERE vendedor_id IN (0,".$data['vendedor_id'].")";
	       			}else {
	       				$filters .= " WHERE vendedor_id = ".$data['vendedor_id'];
	       			}
	       		} elseif ($data['vendedor_id'] != '' && $filters != '') {
	       			if ($data['vendedor_id'] == 2) {
	       				$filters .= " AND vendedor_id IN (0,".$data['vendedor_id'].")";
	       			}else {
	       				$filters .= " AND vendedor_id = ".$data['vendedor_id'];
	       			}
	       			
	       		}
	       	}

	       	if (isset($data['vendedor_pago_estado'])) {
	       		if ($data['vendedor_pago_estado'] != '' && $filters == '') {
	       			$filters .= " WHERE vendedor_pago_estado = ".$data['vendedor_pago_estado'];
	       		} elseif ($data['vendedor_pago_estado'] != '' && $filters != '') {
	       			$filters .= " AND vendedor_pago_estado = ".$data['vendedor_pago_estado'];
	       		}
	       	}

	       	if (isset($data['fecha_desde']) && isset($data['fecha_hasta'])) {
	       		if ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters == '') {
		       		$filters .= " WHERE vendedor_fecha_pago BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       	} elseif ($data['fecha_desde'] != '' && $data['fecha_hasta'] != '' && $filters != '') {
		       		$filters .= " AND vendedor_fecha_pago BETWEEN '".$data['fecha_desde']."' AND '".$data['fecha_hasta']."'";
		       	}
       		}
       	}

		if (isset($data['init']) && isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];


		$sql_query = $this->db->query(" SELECT
											co_cotizacion.id cotizacion_id,
											codigo cotizacion_codigo,
											IFNULL((SELECT
		                                        GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
		                                    FROM co_involucrado
		                                    LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
		                                    LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
		                                    WHERE cotizacion_id = co_cotizacion.id AND rol_id = 2),'') AS solicitante_nombre,
										    IFNULL((SELECT
														GROUP_CONCAT(IF(persona_tipo = 'Juridica', CONCAT('* ',co_involucrado_juridica.nombre),CONCAT('* ',co_involucrado_natural.nombre)) SEPARATOR '|') campo
													FROM co_involucrado
										            LEFT JOIN co_involucrado_natural ON co_involucrado.persona_id = co_involucrado_natural.id
													LEFT JOIN co_involucrado_juridica ON co_involucrado.persona_id = co_involucrado_juridica.id
													WHERE cotizacion_id = co_cotizacion.id AND rol_id = 1),'') cliente_nombre,
											co_servicio_tipo.nombre servicio_tipo_nombre,
											total_moneda_id moneda_id,
											co_moneda.simbolo moneda_simbolo,
											co_moneda.nombre moneda_nombre,
										    ROUND(total_monto_igv, 2) cotizacion_importe_proyecto,
											(SELECT IFNULL(SUM(ad_total),0) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_id = 3) cotizacion_importe_proyecto_abonado,
											IFNULL(login_user.full_name,'OFICINA') perito_nombre,
											ROUND(perito_costo, 2) perito_costo,
										    (SELECT IFNULL(SUM(ROUND(IF(tipo_perito = 1, 0, IF(ad_porcentaje = 1, perito_costo * (ad_porcentaje_num/100), perito_costo)),2)),0) FROM ad_facturacion WHERE cotizacion_id = co_cotizacion.id AND estado_pago_perito = 1) perito_monto_abonado,
										    IFNULL((SELECT SUM(afdg_monto) FROM ad_facturacion_detalle_gastos WHERE ad_facturacion_detalle_gastos.cotizacion_id = co_cotizacion.id),0) gasto_operativo,
										    IF(vendedor_id = 0, 2, vendedor_id) vendedor_id,
										    IFNULL(co_vendedor.nombre,'EMPRESA') vendedor_nombre,
										    vendedor_porcentaje_comision,
										    vendedor_pago_estado vendedor_pago_estado_id,
										    IF(vendedor_fecha_pago = '00:00:00', '', DATE_FORMAT(vendedor_fecha_pago,'%d-%m-%Y')) vendedor_fecha_pago,
										    IF(vendedor_pago_estado = 0, 'Pendiente', 'Cancelado') vendedor_pago_estado
										FROM co_cotizacion
										INNER JOIN ad_facturacion ON co_cotizacion.id = ad_facturacion.cotizacion_id
										INNER JOIN co_servicio_tipo ON ad_facturacion.servicio_tipo_id = co_servicio_tipo.id
										INNER JOIN co_pago ON ad_facturacion.cotizacion_id = co_pago.cotizacion_id
										INNER JOIN co_moneda ON co_pago.total_moneda_id = co_moneda.id
										LEFT JOIN login_user ON co_cotizacion.perito_id = login_user.id
										LEFT JOIN co_vendedor ON co_cotizacion.vendedor_id = co_vendedor.id".$filters.$group_by.$order.$limit);
        if($sql_query->num_rows() > 0)
        	return $sql_query->result();
        else
            return false;
	}

	public function Insert($data)
	{
		$this->db->insert('ad_facturacion', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('ad_facturacion', $data, array('ad_id' => $id));
        return $this->db->affected_rows();
	}

	public function verificarPago($tipo, $id)
	{
		if ($tipo == 'perito') {
			$sql_query = $this->db->query(" SELECT estado_pago_perito FROM ad_facturacion WHERE ad_id = $id;");
		} else {
			$sql_query = $this->db->query(" SELECT vendedor_pago_estado FROM co_cotizacion WHERE id = $id;");
		}

		if($sql_query->num_rows() > 0)
			return $sql_query->row();
	}
}

/* End of file Facturacion_m.php */
/* Location: ./application/models/facturacion/Facturacion_m.php */