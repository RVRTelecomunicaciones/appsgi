<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Involucrado_m extends CI_Model {

    /* ANTIGUO
    public function involucradoJuridicaReporte()
	{
		$query = $this->db->query("	SELECT
										co_involucrado_juridica.id involucrado_id,
										'Juridica' involucrado_tipo_nombre,
										co_involucrado_juridica.nombre involucrado_nombre,
									    ruc involucrado_documento,
									    direccion involucrado_direccion,
									    telefono involucrado_telefono,
									    '' involucrado_correo,
									    clasificacion_id,
									    IFNULL(co_involucrado_clasificacion.nombre, '') clasificacion_nombre,
									    actividad_id,
									    IFNULL(co_involucrado_actividad.nombre, '') actividad_nombre,
									    grupo_id,
									    IFNULL(co_involucrado_grupo.nombre, '') grupo_nombre,
									    co_involucrado_juridica.info_status involucrado_estado
									FROM co_involucrado_juridica
									LEFT JOIN co_involucrado_clasificacion ON co_involucrado_juridica.clasificacion_id = co_involucrado_clasificacion.id
									LEFT JOIN co_involucrado_actividad ON co_involucrado_juridica.actividad_id = co_involucrado_actividad.id
									LEFT JOIN co_involucrado_grupo ON co_involucrado_juridica.grupo_id = co_involucrado_grupo.id");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }*/
    
    public function involucradoJuridicaReporte()
	{
		$query = $this->db->query("	SELECT
                                        involucrado_juridico.id involucrado_id,
                                        'Juridica' involucrado_tipo_nombre,
                                        involucrado_juridico.razon_social involucrado_nombre,
                                        nro_documento involucrado_documento,
                                        direccion involucrado_direccion,
                                        telefono involucrado_telefono,
                                        correo involucrado_correo,
                                        involucrado_juridico.info_status involucrado_estado
                                    FROM involucrado_juridico
									ORDER BY involucrado_nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

    /* ANTIGUO
    public function involucradoNaturalReporte()
	{
		$query = $this->db->query("	SELECT
										co_involucrado_natural.id involucrado_id,
										'Natural' involucrado_tipo_nombre,
									    co_involucrado_natural.nombre involucrado_nombre,
									    documento_tipo_id,
									    co_involucrado_documento_tipo.nombre,
									    IFNULL(documento, '') involucrado_documento,
									    IFNULL(direccion, '') involucrado_direccion,
									    IFNULL(telefono, '') involucrado_telefono,
									    IFNULL(correo, '') involucrado_correo,
									    co_involucrado_natural.info_status involucrado_estado
									FROM co_involucrado_natural
									LEFT JOIN co_involucrado_documento_tipo ON co_involucrado_natural.documento_tipo_id = co_involucrado_documento_tipo.id
									ORDER BY involucrado_nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }*/

    public function involucradoNaturalReporte()
	{
		$query = $this->db->query("	SELECT
                                        involucrado_natural.id involucrado_id,
                                        'Natural' involucrado_tipo_nombre,
                                        CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) involucrado_nombre,
                                        nro_documento involucrado_documento,
                                        telefono involucrado_telefono,
                                        direccion involucrado_direccion,
                                        correo involucrado_correo,
                                        info_status involucrado_estado
                                    FROM involucrado_natural
                                    ORDER BY involucrado_nombre ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    
	/*BEGIN INVOLUCRADO JURIDICO*/
    /*ANTIGUO
    public function searchInvolucradoJuridico($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $limit = "";

        if ($search['involucrado_nombre'] != '')
            $filters .= " WHERE co_involucrado_juridica.nombre LIKE '%".$search['involucrado_nombre']."%'";

        if ($search['involucrado_documento'] != '' && $filters === '')
            $filters .= " WHERE ruc = ".$search['involucrado_documento'];
        else if ($search['involucrado_documento'] != '' && $filters != '')
        	$filters .= " AND ruc = ".$search['involucrado_documento'];

        if ($search['clasificacion_id'] != '' && $filters === '')
            $filters .= " WHERE clasificacion_id = ".$search['clasificacion_id'];
        else if ($search['clasificacion_id'] != '' && $filters != '')
        	$filters .= " AND clasificacion_id = ".$search['clasificacion_id'];

        if ($search['actividad_id'] != '' && $filters === '')
            $filters .= " WHERE actividad_id = ".$search['actividad_id'];
        else if ($search['actividad_id'] != '' && $filters != '')
        	$filters .= " AND actividad_id = ".$search['actividad_id'];

        if ($search['grupo_id'] != '' && $filters === '')
            $filters .= " WHERE grupo_id = ".$search['grupo_id'];
        else if ($search['grupo_id'] != '' && $filters != '')
        	$filters .= " AND grupo_id = ".$search['grupo_id'];

        if ($search['involucrado_direccion'] != '' && $filters === '')
            $filters .= " WHERE direccion LIKE '%".$search['involucrado_direccion']."%'";
        else if ($search['involucrado_direccion'] != '' && $filters != '')
        	$filters .= " AND direccion LIKE '%".$search['involucrado_direccion']."%'";

        if ($search['involucrado_telefono'] != '' && $filters === '')
            $filters .= " WHERE telefono LIKE '%".$search['involucrado_telefono']."%'";
        else if ($search['involucrado_telefono'] != '' && $filters != '')
        	$filters .= " AND telefono LIKE '%".$search['involucrado_telefono']."%'";

        if ($search['involucrado_estado'] != '' && $filters === '')
            $filters .= " WHERE co_involucrado_juridica.info_status = ".$search['involucrado_estado'];
        else if ($search['involucrado_estado'] != '' && $filters != '')
        	$filters .= " AND co_involucrado_juridica.info_status = ".$search['involucrado_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query = "	SELECT
        					co_involucrado_juridica.id involucrado_id,
        					'Juridica' involucrado_tipo_nombre,
        					co_involucrado_juridica.nombre involucrado_nombre,
        					ruc involucrado_documento,
        					direccion involucrado_direccion,
        					telefono involucrado_telefono,
        					'' involucrado_correo,
        					clasificacion_id,
        					IFNULL(co_involucrado_clasificacion.nombre, '') clasificacion_nombre,
        					actividad_id,
        					IFNULL(co_involucrado_actividad.nombre, '') actividad_nombre,
        					grupo_id,
        					IFNULL(co_involucrado_grupo.nombre, '') grupo_nombre,
        					co_involucrado_juridica.info_status involucrado_estado
        					FROM co_involucrado_juridica
        					LEFT JOIN co_involucrado_clasificacion ON co_involucrado_juridica.clasificacion_id = co_involucrado_clasificacion.id
        					LEFT JOIN co_involucrado_actividad ON co_involucrado_juridica.actividad_id = co_involucrado_actividad.id
        					LEFT JOIN co_involucrado_grupo ON co_involucrado_juridica.grupo_id = co_involucrado_grupo.id".$filters.$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function insertInvolucradoJuridico($data)
    {
        $this->db->insert('co_involucrado_juridica', $data);
        return $this->db->insert_id();
    }

    public function updateInvolucradoJuridico($data, $id)
    {
        $this->db->update('co_involucrado_juridica', $data, array('id' => $id));
        return $this->db->affected_rows();
    }*/

    public function searchInvolucradoJuridico($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $limit = "";

        if ($search['involucrado_nombre'] != '')
            $filters .= " WHERE involucrado_juridico.razon_social LIKE '%".$search['involucrado_nombre']."%'";

        if ($search['involucrado_documento'] != '' && $filters === '')
            $filters .= " WHERE nro_documento = ".$search['involucrado_documento'];
        else if ($search['involucrado_documento'] != '' && $filters != '')
        	$filters .= " AND nro_documento = ".$search['involucrado_documento'];

        if ($search['involucrado_direccion'] != '' && $filters === '')
            $filters .= " WHERE direccion LIKE '%".$search['involucrado_direccion']."%'";
        else if ($search['involucrado_direccion'] != '' && $filters != '')
        	$filters .= " AND direccion LIKE '%".$search['involucrado_direccion']."%'";

        if ($search['involucrado_telefono'] != '' && $filters === '')
            $filters .= " WHERE telefono LIKE '%".$search['involucrado_telefono']."%'";
        else if ($search['involucrado_telefono'] != '' && $filters != '')
        	$filters .= " AND telefono LIKE '%".$search['involucrado_telefono']."%'";

        if ($search['involucrado_estado'] != '' && $filters === '')
            $filters .= " WHERE involucrado_juridico.info_status = ".$search['involucrado_estado'];
        else if ($search['involucrado_estado'] != '' && $filters != '')
        	$filters .= " AND involucrado_juridico.info_status = ".$search['involucrado_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query = "	SELECT
        					involucrado_juridico.id involucrado_id,
                            'Juridica' involucrado_tipo_nombre,
                            involucrado_juridico.razon_social involucrado_nombre,
                            nro_documento involucrado_documento,
                            direccion involucrado_direccion,
                            telefono involucrado_telefono,
                            correo involucrado_correo,
                            0 clasificacion_id,
        					'' clasificacion_nombre,
        					0 actividad_id,
        					'' actividad_nombre,
        					0 grupo_id,
        					'' grupo_nombre,
                            involucrado_juridico.info_status involucrado_estado
        				FROM involucrado_juridico".$filters.$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function insertInvolucradoJuridico($data)
    {
        $this->db->insert('involucrado_juridico', $data);
        return $this->db->insert_id();
    }

    public function updateInvolucradoJuridico($data, $id)
    {
        $this->db->update('involucrado_juridico', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    /*END INVOLUCRADO JURIDICO*/

    /*BEGIN INVOLUCRADO NATURAL*/
    /* ANTIGUO
    public function searchInvolucradoNatural($search, $init = FALSE, $quantity = FALSE)
    {
    	$filters = "";
        $limit = "";

        if ($search['involucrado_nombre'] != '')
            $filters .= " WHERE co_involucrado_natural.nombre LIKE '%".$search['involucrado_nombre']."%'";

        if ($search['involucrado_documento'] != '' && $filters === '')
            $filters .= " WHERE documento = '%".$search['involucrado_documento']."%'";
        else if ($search['involucrado_documento'] != '' && $filters != '')
            $filters .= " AND documento = '%".$search['involucrado_documento']."%'";

        if ($search['involucrado_direccion'] != '' && $filters === '')
            $filters .= " WHERE direccion LIKE '%".$search['involucrado_direccion']."%'";
        else if ($search['involucrado_direccion'] != '' && $filters != '')
            $filters .= " AND direccion LIKE '%".$search['involucrado_direccion']."%'";

        if ($search['involucrado_correo'] != '' && $filters === '')
            $filters .= " WHERE correo LIKE '%".$search['involucrado_correo']."%'";
        else if ($search['involucrado_correo'] != '' && $filters != '')
            $filters .= " AND correo LIKE '%".$search['involucrado_correo']."%'";

        if ($search['involucrado_estado'] != '' && $filters === '')
            $filters .= " WHERE co_involucrado_natural.info_status = ".$search['involucrado_estado'];
        else if ($search['involucrado_estado'] != '' && $filters != '')
            $filters .= " AND co_involucrado_natural.info_status = ".$search['involucrado_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query = "  SELECT
                            co_involucrado_natural.id involucrado_id,
                            'Natural' involucrado_tipo_nombre,
                            co_involucrado_natural.nombre involucrado_nombre,
                            documento_tipo_id,
                            co_involucrado_documento_tipo.nombre,
                            IFNULL(documento, '') involucrado_documento,
                            IFNULL(direccion, '') involucrado_direccion,
                            IFNULL(telefono, '') involucrado_telefono,
                            IFNULL(correo, '') involucrado_correo,
                            co_involucrado_natural.info_status involucrado_estado
                        FROM co_involucrado_natural
                        LEFT JOIN co_involucrado_documento_tipo ON co_involucrado_natural.documento_tipo_id = co_involucrado_documento_tipo.id".$filters."
                        ORDER BY involucrado_nombre ASC".$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    } 

    public function insertInvolucradoNatural($data)
    {
        $this->db->insert('co_involucrado_natural', $data);
        return $this->db->insert_id();
    }

    public function updateInvolucradoNatural($data, $id)
    {
        $this->db->update('co_involucrado_natural', $data, array('id' => $id));
        return $this->db->affected_rows();
    }*/

    public function searchInvolucradoNatural($search, $init = FALSE, $quantity = FALSE)
    {
    	$filters = "";
        $limit = "";

        if ($search['involucrado_nombre'] != '')
            $filters .= " WHERE CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) LIKE '%".$search['involucrado_nombre']."%'";

        if ($search['involucrado_documento'] != '' && $filters === '')
            $filters .= " WHERE nro_documento = ".$search['involucrado_documento'];
        else if ($search['involucrado_documento'] != '' && $filters != '')
            $filters .= " AND nro_documento = ".$search['involucrado_documento'];

        if ($search['involucrado_direccion'] != '' && $filters === '')
            $filters .= " WHERE direccion LIKE '%".$search['involucrado_direccion']."%'";
        else if ($search['involucrado_direccion'] != '' && $filters != '')
            $filters .= " AND direccion LIKE '%".$search['involucrado_direccion']."%'";

        if ($search['involucrado_correo'] != '' && $filters === '')
            $filters .= " WHERE correo LIKE '%".$search['involucrado_correo']."%'";
        else if ($search['involucrado_correo'] != '' && $filters != '')
            $filters .= " AND correo LIKE '%".$search['involucrado_correo']."%'";

        if ($search['involucrado_estado'] != '' && $filters === '')
            $filters .= " WHERE info_status = ".$search['involucrado_estado'];
        else if ($search['involucrado_estado'] != '' && $filters != '')
            $filters .= " AND info_status = ".$search['involucrado_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query = "  SELECT
                            involucrado_natural.id involucrado_id,
							'Natural' involucrado_tipo_nombre,
                            paterno involucrado_paterno,
                            materno involucrado_materno,
                            nombres involucrado_nombres,
                            CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) involucrado_nombre,
                            nro_documento involucrado_documento,
                            telefono involucrado_telefono,
                            direccion involucrado_direccion,
                            correo involucrado_correo,
							info_status involucrado_estado
                        FROM involucrado_natural".$filters."
                        ORDER BY involucrado_nombre ASC".$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function insertInvolucradoNatural($data)
    {
        $this->db->insert('involucrado_natural', $data);
        return $this->db->insert_id();
    }

    public function updateInvolucradoNatural($data, $id)
    {
        $this->db->update('involucrado_natural', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    /*END INVOLUCRADO NATURAL*/

    /*BEGIN COTIZACION INVOLUCRADO*/
    /*ANTIGUO
    public function searchCotizacionInvolucrados($cotizacion)
    {
        $query = $this->db->query(" SELECT
                                        co_involucrado.id ,
                                        persona_id involucrado_id,
                                        rol_id,
                                        co_involucrado_rol.nombre rol_nombre,
                                        persona_tipo involucrado_tipo_nombre,
                                        (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                (SELECT nombre FROM co_involucrado_juridica WHERE id = persona_id)
                                            ELSE
                                                (SELECT nombre FROM co_involucrado_natural WHERE id = persona_id)
                                         END) involucrado_nombre,
                                         (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                (SELECT ruc FROM co_involucrado_juridica WHERE id = persona_id)
                                            ELSE
                                                (SELECT documento FROM co_involucrado_natural WHERE id = persona_id)
                                         END) involucrado_documento,
                                         (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                (SELECT telefono FROM co_involucrado_juridica WHERE id = persona_id)
                                            ELSE
                                                (SELECT telefono FROM co_involucrado_natural WHERE id = persona_id)
                                         END) involucrado_telefono,
                                         (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                ''
                                            ELSE
                                                (SELECT correo FROM co_involucrado_natural WHERE id = persona_id)
                                         END) involucrado_correo,
                                         contacto_id,
                                         IFNULL(co_involucrado_contacto.nombre, '') contacto_nombre,
                                         IFNULL(co_involucrado_contacto.cargo, '') contacto_cargo,
                                         IFNULL(co_involucrado_contacto.telefono, '') contacto_telefono,
                                         IFNULL(co_involucrado_contacto.correo, '') contacto_correo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_rol ON co_involucrado.rol_id = co_involucrado_rol.id
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = $cotizacion AND co_involucrado.info_status = 1;");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }*/

    public function searchCotizacionInvolucrados($cotizacion)
    {
        $query = $this->db->query(" SELECT
                                        co_involucrado.id ,
                                        persona_id_new involucrado_id,
                                        rol_id,
                                        co_involucrado_rol.nombre rol_nombre,
                                        persona_tipo involucrado_tipo_nombre,
                                        (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                (SELECT razon_social FROM involucrado_juridico WHERE id = persona_id_new)
                                            ELSE
                                                (SELECT CONCAT(if(length(paterno)>0, concat(paterno, ' '),''),if(length(materno)>0, concat(materno, ' '),''),nombres) FROM involucrado_natural WHERE id = persona_id_new)
                                        END) involucrado_nombre,
                                        (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                (SELECT nro_documento FROM involucrado_juridico WHERE id = persona_id_new)
                                            ELSE
                                                (SELECT nro_documento FROM involucrado_natural WHERE id = persona_id_new)
                                        END) involucrado_documento,
                                        (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                (SELECT telefono FROM involucrado_juridico WHERE id = persona_id_new)
                                            ELSE
                                                (SELECT telefono FROM involucrado_natural WHERE id = persona_id_new)
                                        END) involucrado_telefono,
                                        (CASE
                                            WHEN persona_tipo = 'Juridica' THEN
                                                ''
                                            ELSE
                                                (SELECT correo FROM involucrado_natural WHERE id = persona_id_new)
                                        END) involucrado_correo,
                                        contacto_id,
                                        IFNULL(co_involucrado_contacto.nombre, '') contacto_nombre,
                                        IFNULL(co_involucrado_contacto.cargo, '') contacto_cargo,
                                        IFNULL(co_involucrado_contacto.telefono, '') contacto_telefono,
                                        IFNULL(co_involucrado_contacto.correo, '') contacto_correo
                                    FROM co_involucrado
                                    LEFT JOIN co_involucrado_rol ON co_involucrado.rol_id = co_involucrado_rol.id
                                    LEFT JOIN co_involucrado_contacto ON co_involucrado.contacto_id = co_involucrado_contacto.id
                                    WHERE cotizacion_id = $cotizacion AND co_involucrado.info_status = 1;");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }

    public function insertCotizacionInvolucrado($data)
    {
        $this->db->insert('co_involucrado', $data);
        return $this->db->affected_rows();
    }

    public function deleteCotizacionInvolucrado($id)
    {
        $this->db->delete('co_involucrado', array('id' => $id));
        return $this->db->affected_rows();
    }
    /*END COTIZACION INVOLUCRADO*/

    public function search($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY involucrado_nombres ASC";
        $limit = "";

        if (isset($data['control_calidad_codigo']) && $data['control_calidad_codigo'] != '') {
            $filters .= " AND login_user.id = ".$data['control_calidad_codigo'];
        }

        if (isset($data['involucrado_tipo'])) {
            if ($data['involucrado_tipo'] == 'N') {
                $filters .= " WHERE involucrado_natural.info_status = 1";

                if (isset($data['involucrado_codigo']) && $data['involucrado_codigo'] != '') {
                    $filters .= " AND involucrado_natural.id = ".$data['involucrado_codigo'];
                }

                if (isset($data['involucrado_nombres']) && $data['involucrado_nombres'] != '') {
                    $filters .= " AND CONCAT(IF(LENGTH(paterno) > 0, CONCAT(paterno, ' '), ''),IF(LENGTH(materno) > 0, CONCAT(materno, ' '), ''), nombres) LIKE '%".$data['involucrado_nombres']."%'";
                }

                if (isset($data['involucrado_documento_tipo']) && $data['involucrado_documento_tipo'] != '') {
                    $filters .= " AND tipo_documento_id = ".$data['involucrado_documento_tipo'];
                }

                if (isset($data['involucrado_nro_documento']) && $data['involucrado_nro_documento'] != '') {
                    $filters .= " AND nro_documento = ".$data['involucrado_nro_documento'];
                }

                $sql_query = $this->db->query(" SELECT
                                                    involucrado_natural.id involucrado_id,
                                                    CONCAT(IF(LENGTH(paterno) > 0, CONCAT(paterno, ' '), ''),IF(LENGTH(materno) > 0, CONCAT(materno, ' '), ''), nombres) involucrado_nombres,
                                                    co_involucrado_documento_tipo.id documento_tipo_id,
                                                    co_involucrado_documento_tipo.abreviatura documento_tipo_abreviatura,
                                                    nro_documento involucrado_nro_documento,
                                                    direccion involucrado_direccion,
                                                    correo involucrado_correo
                                                FROM involucrado_natural
                                                INNER JOIN co_involucrado_documento_tipo ON involucrado_natural.tipo_documento_id = co_involucrado_documento_tipo.id".$filters.$order.$limit);
                if (isset($data['init']) && isset($data['quantity'])) {
                    $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
                }

                if (isset($data['accion']) && $data['accion'] == 'count') {
                    return $sql_query->num_rows();
                } else {
                    if($sql_query->num_rows() > 0)
                        if (isset($data['accion']) && $data['accion'] == 'sheet')
                            return $sql_query->row();
                        else
                            return $sql_query->result();
                    else
                        return false;
                }
            } else {
                $filters .= " WHERE involucrado_juridico.info_status = 1";

                if (isset($data['involucrado_codigo']) && $data['involucrado_codigo'] != '') {
                    $filters .= " AND involucrado_juridico.id = ".$data['involucrado_codigo'];
                }

                if (isset($data['involucrado_nombres']) && $data['involucrado_nombres'] != '') {
                    $filters .= " AND razon_social LIKE '%".$data['involucrado_nombres']."%'";
                }

                if (isset($data['involucrado_documento_tipo']) && $data['involucrado_documento_tipo'] != '') {
                    $filters .= " AND tipo_documento_id = ".$data['involucrado_documento_tipo'];
                }

                if (isset($data['involucrado_nro_documento']) && $data['involucrado_nro_documento'] != '') {
                    $filters .= " AND nro_documento = ".$data['involucrado_nro_documento'];
                }

                $sql_query = $this->db->query(" SELECT
                                                    involucrado_juridico.id involucrado_id,
                                                    razon_social involucrado_nombres,
                                                    co_involucrado_documento_tipo.id documento_tipo_id,
                                                    co_involucrado_documento_tipo.abreviatura documento_tipo_abreviatura,
                                                    nro_documento involucrado_nro_documento,
                                                    direccion involucrado_direccion,
                                                    correo involucrado_correo
                                                FROM involucrado_juridico
                                                INNER JOIN co_involucrado_documento_tipo ON involucrado_juridico.tipo_documento_id = co_involucrado_documento_tipo.id".$filters.$order.$limit);

                if (isset($data['init']) && isset($data['quantity'])) {
                    $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
                }

                if (isset($data['accion']) && $data['accion'] == 'count') {
                    return $sql_query->num_rows();
                } else {
                    if($sql_query->num_rows() > 0)
                        if (isset($data['accion']) && $data['accion'] == 'sheet')
                            return $sql_query->row();
                        else
                            return $sql_query->result();
                    else
                        return false;
                }
            }
        }
    }

    public function insert($data, $tipo)
    {
        if ($tipo == 'J') {
            $this->db->insert('involucrado_juridico', $data);
            return $this->db->insert_id();
        } else {
            $this->db->insert('involucrado_natural', $data);
            return $this->db->insert_id();
        }
    }
    
    //
    //
    protected $table_natural = 'involucrado_natural';
    protected $table_juridico = 'involucrado_juridico';

    protected $table_attributes_natural = array(
        'id',
        'REPLACE(TRIM(paterno)," ","") paterno',
        'REPLACE(TRIM(materno)," ","") materno',
        'REPLACE(TRIM(nombres)," ","") nombres',
        'CONCAT(
            IF(LENGTH(REPLACE(TRIM(paterno)," ","")) != 0, CONCAT(REPLACE(TRIM(paterno)," ","")," "),""),
            IF(LENGTH(REPLACE(TRIM(materno)," ","")) != 0, CONCAT(REPLACE(TRIM(materno)," ","")," "),""),
            REPLACE(TRIM(nombres)," ","")
        ) nombre_completo',
        'nro_documento',
        'direccion',
        'telefono',
        'correo',
        'info_status'
    );

    protected $table_attributes_juridico = array(
        'id',
        'REPLACE(TRIM(razon_social)," ","") razon_social',
        'nro_documento',
        'direccion',
        'telefono',
        'correo',
        'info_status'
    );

    protected $table_order_natural = array(
        null,
        'nombre_completo',
        'nro_documento',
        null,
        null
    );

    protected $table_order_juridico = array(
        null,
        'razon_social',
        'nro_documento',
        null,
        null
    );

    public function make_query($filters)
    {
        $this->db->select($filters['type'] === 'N' ? $this->table_attributes_natural : $this->table_attributes_juridico);
        $this->db->from($filters['type'] === 'N' ? $this->table_natural : $this->table_juridico);
        
        if (isset($filters['nombre_completo']) && $filters['nombre_completo'] != '')
        {
            if ($filters['type'] === 'N')
            {
                $this->db->like('
                    CONCAT(
                        IF(LENGTH(REPLACE(TRIM(paterno)," ","")) != 0, CONCAT(REPLACE(TRIM(paterno)," ","")," "), ""),
                        IF(LENGTH(REPLACE(TRIM(materno)," ","")) != 0, CONCAT(REPLACE(TRIM(materno)," ","")," "), ""),
                        REPLACE(TRIM(nombres)," ",""))', $filters['nombre_completo'], 'BOTH'
                    );
            }
            else if ($filters['type'] === 'J')
            {
                $this->db->like('REPLACE(TRIM(razon_social)," ","")', $filters['nombre_completo'], 'BOTH');
            }
        }
        
        if (isset($filters['nro_documento']) && $filters['nro_documento'] != '' && $filters['action'] === 'table')
        {
            $this->db->like('nro_documento', $filters['nro_documento'], 'BOTH');
        }
        else if ($filters['action'] === 'combobox')
        {
            $this->db->or_like('nro_documento', $filters['nombre_completo'], 'BOTH');
        }

        if (isset($filters['order']) && $filters['order'] != '')
        {
            if ($filters['action'] === 'table')
            {
                if ($filters['type'] === 'N')
                {
                    $this->db->order_by($this->table_order_natural[$filters['order']['0']['column']], $filters['order']['0']['dir']);
                }
                else if ($filters['type'] === 'J')
                {
                    $this->db->order_by($this->table_order_juridico[$filters['order']['0']['column']], $filters['order']['0']['dir']);
                }
                else
                    $this->db->order_by('id', 'ASC');
            }
            else if ($filters['action'] === 'combobox')
            {
                if ($filters['type'] === 'N')
                {
                    $this->db->order_by('nombre_completo', $filters['order']);
                }
                else if ($filters['type'] === 'J')
                {
                    $this->db->order_by('razon_social', $filters['order']);
                }
                
            }
        }
    }

    public function fectch_all_involucrado($filters)
    {
        $this->make_query($filters);
        if (isset($filters['length']) && $filters['length'] != -1) {
            $this->db->limit($filters['length'], $filters['start']);
        }
        $query = $this->db->get();

        if ($filters['action'] == 'table')
        {
            return $query->result();
            //return $this->db->last_query();
        }
        else if ($filters['action'] == 'combobox')
        {
            return $query->result_array();
            //return $this->db->last_query();
        }
    }

    public function count_filter($filters)
    {
        $this->make_query($filters);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($filters)
    {
        $this->db->select("*");
        $this->db->from($filters['type'] === 'N' ? $this->table_natural : $this->table_juridico);

        return $this->db->count_all_results();
    }
}

/* End of file Involucrado_m.php */
/* Location: ./application/models/involucrado/Involucrado_m.php */