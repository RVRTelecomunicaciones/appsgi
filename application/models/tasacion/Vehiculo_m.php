<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculo_m extends CI_Model {

    /*public function searchVehiculos($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY informe_id ASC";
        $limit = "";

        if (isset($data['accion'])) {
        	if ($data['accion'] == 'filtros') {

                if (isset($data['vehiculo_coordinacion'])) {
                    if ($data['vehiculo_coordinacion'] != '' && $filters == '') {
                        $filters .= " WHERE informe_id = " . $data['vehiculo_coordinacion'];
                    } elseif ($data['vehiculo_coordinacion'] != '' && $filters != '') {
                        $filters .= " AND informe_id = " . $data['vehiculo_coordinacion'];
                    }
                }

                if (isset($data['vehiculo_solicitante'])) {
                    if ($data['vehiculo_solicitante'] != '' && $filters == '') {
                        $filters .= " WHERE replace(tas_solicitante.nombre, '\\\\', '') LIKE '%" . $data['vehiculo_solicitante'] . "%'";
                    } elseif ($data['vehiculo_solicitante'] != '' && $filters != '') {
                        $filters .= " AND replace(tas_solicitante.nombre, '\\\\', '') LIKE '%" . $data['vehiculo_solicitante'] . "%'";
                    }
                }

                if (isset($data['vehiculo_cliente'])) {
                    if ($data['vehiculo_cliente'] != '' && $filters == '') {
                        $filters .= " WHERE replace(tas_cliente.nombre, '\\\\', '') LIKE '%" . $data['vehiculo_cliente'] . "%'";
                    } elseif ($data['vehiculo_cliente'] != '' && $filters != '') {
                        $filters .= " AND replace(tas_cliente.nombre, '\\\\', '') LIKE '%" . $data['vehiculo_cliente'] . "%'";
                    }
                }

                if (isset($data['vehiculo_clase'])) {
                    if ($data['vehiculo_clase'] != '' && $filters == '') {
                        $filters .= " WHERE clase_id = " . $data['vehiculo_clase'];
                    } elseif ($data['vehiculo_clase'] != '' && $filters != '') {
                        $filters .= " AND clase_id = " . $data['vehiculo_clase'];
                    }
                }

                if (isset($data['vehiculo_marca'])) {
                    if ($data['vehiculo_marca'] != '' && $filters == '') {
                        $filters .= " WHERE marca_id = " . $data['vehiculo_marca'];
                    } elseif ($data['vehiculo_marca'] != '' && $filters != '') {
                        $filters .= " AND marca_id = " . $data['vehiculo_marca'];
                    }
                }

                if (isset($data['vehiculo_modelo'])) {
                    if ($data['vehiculo_modelo'] != '' && $filters == '') {
                        $filters .= " WHERE modelo_id = " . $data['vehiculo_modelo'];
                    } elseif ($data['vehiculo_modelo'] != '' && $filters != '') {
                        $filters .= " AND modelo_id = " . $data['vehiculo_modelo'];
                    }
                }
        	}
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        
        $sql_query = $this->db->query(" SELECT
                                            tas_vehiculo.id,
                                            informe_id,
                                            DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                            cliente_id,
                                            cliente_tipo,
											IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                            propietario_id,
                                            tas_propietario.nombre propietario_nombre,
                                            solicitante_id,
                                            solicitante_tipo,
											IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                            clase_id,
                                            tas_clase.nombre clase_nombre,
                                            marca_id,
                                            tas_marca.nombre marca_nombre,
                                            modelo_id,
                                            tas_modelo.nombre modelo_nombre,
                                            fabricacion_anio,
                                            valor_similar_nuevo,
                                            ruta_informe
                                        FROM tas_vehiculo
                                        LEFT JOIN tas_propietario ON tas_vehiculo.propietario_id = tas_propietario.id
                                        LEFT JOIN tas_cliente ON tas_vehiculo.cliente_id = tas_cliente.id AND cliente_tipo = ''
										LEFT JOIN tas_solicitante ON tas_vehiculo.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
										LEFT JOIN involucrado_natural cli_nat ON tas_vehiculo.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
										LEFT JOIN involucrado_juridico cli_jur ON tas_vehiculo.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
										LEFT JOIN involucrado_natural sol_nat ON tas_vehiculo.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
										LEFT JOIN involucrado_juridico sol_jur ON tas_vehiculo.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                        LEFT JOIN tas_clase ON tas_vehiculo.clase_id = tas_clase.id
                                        LEFT JOIN tas_marca ON tas_vehiculo.marca_id = tas_marca.id
                                        LEFT JOIN tas_modelo ON tas_vehiculo.modelo_id = tas_modelo.id".$filters.$order.$limit);
           
        if($sql_query->num_rows() > 0)
            return $sql_query->result();
        else
            return false;
    }*/

    public function search($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY informe_id ASC";
        $limit = "";

        if (isset($data['vehiculo_coordinacion'])) {
            if ($data['vehiculo_coordinacion'] != '' && $filters == '')
                $filters .= " WHERE informe_id = '".$data['vehiculo_coordinacion']."'";
            else if ($data['vehiculo_coordinacion'] != '' && $filters != '')
                $filters .= " AND informe_id = '".$data['vehiculo_coordinacion']."'";
        }

        if (isset($data['vehiculo_solicitante'])) {
            if ($data['vehiculo_solicitante'] != '' && $filters == '')
                $filters .= " WHERE IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) LIKE '%".$data['vehiculo_solicitante']."%'";
            else if ($data['vehiculo_solicitante'] != '' && $filters != '')
                $filters .= " AND IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) LIKE '%".$data['vehiculo_solicitante']."%'";
        }

        if (isset($data['vehiculo_cliente'])) {
            if ($data['vehiculo_cliente'] != '' && $filters == '')
                $filters .= " WHERE IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) LIKE '%".$data['vehiculo_cliente']."%'";
            else if ($data['vehiculo_cliente'] != '' && $filters != '')
                $filters .= " AND IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) LIKE '%".$data['vehiculo_cliente']."%'";
        }

        if (isset($data['vehiculo_clase'])) {
            if ($data['vehiculo_clase'] != '' && $filters == '')
                $filters .= " WHERE clase_id = '".$data['vehiculo_clase']."'";
            else if ($data['vehiculo_clase'] != '' && $filters != '')
                $filters .= " AND clase_id = '".$data['vehiculo_clase']."'";
        }

        if (isset($data['vehiculo_marca'])) {
            if ($data['vehiculo_marca'] != '' && $filters == '')
                $filters .= " WHERE marca_id = '".$data['vehiculo_marca']."'";
            else if ($data['vehiculo_marca'] != '' && $filters != '')
                $filters .= " AND marca_id = '".$data['vehiculo_marca']."'";
        }

        if (isset($data['vehiculo_modelo'])) {
            if ($data['vehiculo_modelo'] != '' && $filters == '')
                $filters .= " WHERE modelo_id = '".$data['vehiculo_modelo']."'";
            else if ($data['vehiculo_modelo'] != '' && $filters != '')
                $filters .= " AND modelo_id = '".$data['vehiculo_modelo']."'";
        }

        if (isset($data['vehiculo_fecha_desde']) && isset($data['vehiculo_fecha_hasta'])) {
            if ($data['vehiculo_fecha_desde'] != '' && $data['vehiculo_fecha_hasta'] != '' && $filters == '')
                $filters .= " WHERE DATE_FORMAT(tas_vehiculo.tasacion_fecha, '%Y-%m-%d') BETWEEN  '".$data['vehiculo_fecha_desde']."' AND '".$data['vehiculo_fecha_hasta']."'";
            else if ($data['vehiculo_fecha_desde'] != '' && $data['vehiculo_fecha_hasta'] != '' && $filters != '')
                $filters .= " AND DATE_FORMAT(tas_vehiculo.tasacion_fecha, '%Y-%m-%d') BETWEEN  '".$data['vehiculo_fecha_desde']."' AND '".$data['vehiculo_fecha_hasta']."'";    
        }

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            tas_vehiculo.id,
                                            informe_id,
                                            DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                            cliente_id,
                                            cliente_tipo,
                                            replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                            propietario_id,
                                            tas_propietario.nombre propietario_nombre,
                                            solicitante_id,
                                            solicitante_tipo,
                                            replace(IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)), '\\\\', '') solicitante_nombre,
                                            clase_id,
                                            tas_clase.nombre clase_nombre,
                                            marca_id,
                                            tas_marca.nombre marca_nombre,
                                            modelo_id,
                                            tas_modelo.nombre modelo_nombre,
                                            fabricacion_anio,
                                            valor_similar_nuevo,
                                            ruta_informe
                                        FROM tas_vehiculo
                                        LEFT JOIN tas_propietario ON tas_vehiculo.propietario_id = tas_propietario.id
                                        LEFT JOIN tas_cliente ON tas_vehiculo.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                        LEFT JOIN tas_solicitante ON tas_vehiculo.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                        LEFT JOIN involucrado_natural cli_nat ON tas_vehiculo.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                        LEFT JOIN involucrado_juridico cli_jur ON tas_vehiculo.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                        LEFT JOIN involucrado_natural sol_nat ON tas_vehiculo.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                        LEFT JOIN involucrado_juridico sol_jur ON tas_vehiculo.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                        LEFT JOIN tas_clase ON tas_vehiculo.clase_id = tas_clase.id
                                        LEFT JOIN tas_marca ON tas_vehiculo.marca_id = tas_marca.id
                                        LEFT JOIN tas_modelo ON tas_vehiculo.modelo_id = tas_modelo.id".$filters.$order.$limit);

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

	public function Insert($data)
    {
        $this->db->insert('tas_vehiculo', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('tas_vehiculo', $data, array('id' => $id));
        return $this->db->affected_rows();
    }

}

/* End of file Vehiculo_m.php */
/* Location: ./application/models/tasacion/Vehiculo_m.php */