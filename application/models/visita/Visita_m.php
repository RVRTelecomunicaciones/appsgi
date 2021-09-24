<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visita_m extends CI_Model {

	public function search($data)
	{
		$sql_query = "";
        $filters = "";
        $order = "";
        $limit = "";

        if (isset($data['inspeccion_codigo']) && $data['inspeccion_codigo'] != '') {
        	if ($filters == "") {
        		$filters .= " WHERE inspeccion_visita.inspeccion_id = ".$data['inspeccion_codigo'];
        	} else {
        		$filters .= " AND inspeccion_visita.inspeccion_id = ".$data['inspeccion_codigo'];
        	}
		}
		
		if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
											coor_coordinacion.id coordinacion_id,
										    cotizacion_correlativo coordinacion_correlativo,
											solicitante_persona_id_new solicitante_id,
											solicitante_persona_tipo solicitante_tipo,
											IFNULL((CASE
												WHEN solicitante_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = solicitante_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = solicitante_persona_id_new)
											END),'') solicitante_nombre,
											cliente_persona_id_new cliente_id,
										    cliente_persona_tipo cliente_tipo,
										    IFNULL((CASE
												WHEN cliente_persona_tipo = 'Juridica' THEN
													(SELECT razon_social FROM involucrado_juridico WHERE id = cliente_persona_id_new)
												ELSE
													(SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = cliente_persona_id_new)
											END),'') cliente_nombre,
										    IF(fecha = '0000-00-00 00:00:00', '', DATE_FORMAT(fecha, '%d/%m/%Y')) inspeccion_fecha,
										    UPPER(inspeccion.direccion) inspeccion_direccion,
										    ubigeo_distrito.nombre distrito_nombre,
										    ubigeo_provincia.nombre provincia_nombre,
										    ubigeo_departamento.nombre departamento_nombre,
										    inspeccion_visita.atendido,inspeccion_visita.direccion,inspeccion_visita.nro_suministro,inspeccion_visita.nro_puerta,inspeccion_visita.ocupado,
										    inspeccion_visita.uso,inspeccion_visita.muros,inspeccion_visita.techos,inspeccion_visita.inst_electricas,inspeccion_visita.inst_sanitarias,
										    inspeccion_visita.calidad_construccion,inspeccion_visita.puerta_tipo,inspeccion_visita.puerta_material,inspeccion_visita.puerta_sistema,inspeccion_visita.ventana_marco,
										    inspeccion_visita.ventana_vidrio,inspeccion_visita.ventana_sistema,inspeccion_visita.piso_tipo,inspeccion_visita.piso_material,inspeccion_visita.revestimiento_tipo,
										    inspeccion_visita.revestimiento_material,inspeccion_visita.vias_dispone,inspeccion_visita.vias_calidad,inspeccion_visita.vias_conservacion,inspeccion_visita.veredas_dispone,
										    inspeccion_visita.veredas_calidad,inspeccion_visita.veredas_conservacion,inspeccion_visita.alcantarillado_dispone,inspeccion_visita.alcantarillado_calidad,inspeccion_visita.alcantarillado_conservacion,
										    inspeccion_visita.aguapotable_dispone,inspeccion_visita.aguapotable_calidad,inspeccion_visita.aguapotable_conservacion,inspeccion_visita.alumbrado_dispone,inspeccion_visita.alumbrado_calidad,
										    inspeccion_visita.alumbrado_conservacion,inspeccion_visita.distribucion_inmueble
										FROM inspeccion_visita
										INNER JOIN inspeccion ON inspeccion_visita.inspeccion_id = inspeccion.id
										INNER JOIN coor_inspeccion_detalle ON inspeccion.id = coor_inspeccion_detalle.inspeccion_id
										INNER JOIN coor_coordinacion ON coor_inspeccion_detalle.coordinacion_id = coor_coordinacion.id

										INNER JOIN ubigeo_distrito ON inspeccion.distrito_id = ubigeo_distrito.id
										INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
										INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id".$filters.$order.$limit);

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

	public function insert(
	    $inspeccion_id,
	    $atendido,
	    $direccion,
	    $nro_suministro,
	    $nro_puerta,
	    $ocupado,
	    $uso,$muros,
	    $techos,
	    $inst_electricas,
	    $inst_sanitarias,
	    $calidad_construccion,
	    $puerta_tipo,
	    $puerta_material,
	    $puerta_sistema,
	    $ventana_marco,
	    $ventana_vidrio,
	    $ventana_sistema,
	    $piso_tipo,
	    $piso_material,
	    $revestimiento_tipo,
	    $revestimiento_material,
	    $vias_dispone,
	    $vias_calidad,
	    $vias_conservacion,
	    $veredas_dispone,
	    $veredas_calidad,
	    $veredas_conservacion,
	    $alcantarillado_dispone,
	    $alcantarillado_calidad,
	    $alcantarillado_conservacion,
	    $aguapotable_dispone,
	    $aguapotable_calidad,
	    $aguapotable_conservacion,
	    $alumbrado_dispone,
	    $alumbrado_calidad,
	    $alumbrado_conservacion,
	    $distribucion_inmueble
	    )
    {
        
        $this->db->trans_begin();

        $data = array(
        "inspeccion_id"=>$inspeccion_id,
          'atendido'=> $atendido,
          'direccion'=> $direccion,
          'nro_suministro'=> $nro_suministro,
          'nro_puerta'=> $nro_puerta,
          'ocupado'=> $ocupado,
          'uso'=> $uso,
          'muros'=> $muros,
          'techos'=> $techos,
          'inst_electricas'=> $inst_electricas,
          'inst_sanitarias'=> $inst_sanitarias,
          'calidad_construccion'=> $calidad_construccion,
          'puerta_tipo'=> $puerta_tipo,
          'puerta_material'=> $puerta_material,
          'puerta_sistema'=> $puerta_sistema,
          'ventana_marco'=> $ventana_marco,
          'ventana_vidrio'=> $ventana_vidrio,
          'ventana_sistema'=> $ventana_sistema,
          'piso_tipo'=> $piso_tipo,
          'piso_material'=> $piso_material,
          'revestimiento_tipo'=> $revestimiento_tipo,
          'revestimiento_material'=> $revestimiento_material,
          'vias_dispone'=> $vias_dispone,
          'vias_calidad'=> $vias_calidad,
          'vias_conservacion'=> $vias_conservacion,
          'veredas_dispone'=> $veredas_dispone,
          'veredas_calidad'=> $veredas_calidad,
          'veredas_conservacion'=> $veredas_conservacion,
          'alcantarillado_dispone'=> $alcantarillado_dispone,
          'alcantarillado_calidad'=> $alcantarillado_calidad,
          'alcantarillado_conservacion'=> $alcantarillado_conservacion,
          'aguapotable_dispone'=> $aguapotable_dispone,
          'aguapotable_calidad'=> $aguapotable_calidad,
          'aguapotable_conservacion'=> $aguapotable_conservacion,
          'alumbrado_dispone'=> $alumbrado_dispone,
          'alumbrado_calidad'=> $alumbrado_calidad,
          'alumbrado_conservacion'=> $alumbrado_conservacion,
          'distribucion_inmueble'=> $distribucion_inmueble
        
        );
        $rst1 = $this->db->insert('inspeccion_visita',$data);
        $fields_inspeccion = array(
            'estado_id' => '2'
        );
        
        $this->db->where('id', $data['inspeccion_id']);
        $rst2 = $this->db->update('inspeccion', $fields_inspeccion);
        
        if($this->db->trans_status() === FALSE || !isset($rst1) || !isset($rst2)){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
       
        //$this->db->trans_begin();
        //$this->db->insert('inspeccion_visita', $data);
        //if ($this->db->affected_rows() > 0) {
        //return true;
        //} else {
        //return false;
        //}

        //$fields_inspeccion = array(
          //  'estado_id' => '2'
        //);

        //$this->db->update('inspeccion', $fields_inspeccion, $data['inspeccion_id']);
        //if ($this->db->trans_status() === FALSE) {
          //  $this->db->trans_rollback();
            //return 0;
        //} else {
            //$this->db->trans_commit();
          //  return 1;
        //}
    }

    public function update($data, $id)
    {
        $this->db->update('inspeccion_visita', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Visita_m.php */
/* Location: ./application/models/visita/Visita_m.php */