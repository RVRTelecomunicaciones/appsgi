<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquinaria_m extends CI_Model {

    /*public function searchMaquinarias($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY informe_id ASC";
        $limit = "";

        if (isset($data['accion'])) {
        	if ($data['accion'] == 'filtros') {

                if (isset($data['maquinaria_coordinacion'])) {
                    if ($data['maquinaria_coordinacion'] != '' && $filters == '') {
                        $filters .= " WHERE informe_id = " . $data['maquinaria_coordinacion'];
                    } elseif ($data['maquinaria_coordinacion'] != '' && $filters != '') {
                        $filters .= " AND informe_id = " . $data['maquinaria_coordinacion'];
                    }
                }

                if (isset($data['maquinaria_solicitante'])) {
                    if ($data['maquinaria_solicitante'] != '' && $filters == '') {
                        $filters .= " WHERE replace(tas_solicitante.nombre, '\\\\', '') LIKE '%" . $data['maquinaria_solicitante'] . "%'";
                    } elseif ($data['maquinaria_solicitante'] != '' && $filters != '') {
                        $filters .= " AND replace(tas_solicitante.nombre, '\\\\', '') LIKE '%" . $data['maquinaria_solicitante'] . "%'";
                    }
                }

                if (isset($data['maquinaria_cliente'])) {
                    if ($data['maquinaria_cliente'] != '' && $filters == '') {
                        $filters .= " WHERE replace(tas_cliente.nombre, '\\\\', '') LIKE '%" . $data['maquinaria_cliente'] . "%'";
                    } elseif ($data['maquinaria_cliente'] != '' && $filters != '') {
                        $filters .= " AND replace(tas_cliente.nombre, '\\\\', '') LIKE '%" . $data['maquinaria_cliente'] . "%'";
                    }
                }

                if (isset($data['maquinaria_clase'])) {
                    if ($data['maquinaria_clase'] != '' && $filters == '') {
                        $filters .= " WHERE clase_id = " . $data['maquinaria_clase'];
                    } elseif ($data['maquinaria_clase'] != '' && $filters != '') {
                        $filters .= " AND clase_id = " . $data['maquinaria_clase'];
                    }
                }

                if (isset($data['maquinaria_marca'])) {
                    if ($data['maquinaria_marca'] != '' && $filters == '') {
                        $filters .= " WHERE marca_id = " . $data['maquinaria_marca'];
                    } elseif ($data['maquinaria_marca'] != '' && $filters != '') {
                        $filters .= " AND marca_id = " . $data['maquinaria_marca'];
                    }
                }

                if (isset($data['maquinaria_modelo'])) {
                    if ($data['maquinaria_modelo'] != '' && $filters == '') {
                        $filters .= " WHERE modelo_id = " . $data['maquinaria_modelo'];
                    } elseif ($data['maquinaria_modelo'] != '' && $filters != '') {
                        $filters .= " AND modelo_id = " . $data['maquinaria_modelo'];
                    }
                }
        	}
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        
        $sql_query = $this->db->query(" SELECT
                                            tas_maquinaria.id,
                                            informe_id,
                                            DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                            cliente_id,
                                            tas_cliente.nombre cliente_nombre,
                                            propietario_id,
                                            tas_propietario.nombre propietario_nombre,
                                            solicitante_id,
                                            tas_solicitante.nombre solicitante_nombre,
                                            clase_id,
                                            tas_clase.nombre clase_nombre,
                                            marca_id,
                                            tas_marca.nombre marca_nombre,
                                            modelo_id,
                                            tas_modelo.nombre modelo_nombre,
                                            fabricacion_anio,
                                            valor_similar_nuevo,
                                            ruta_informe
                                        FROM tas_maquinaria
                                        INNER JOIN tas_cliente ON tas_maquinaria.cliente_id = tas_cliente.id
                                        INNER JOIN tas_propietario ON tas_maquinaria.propietario_id = tas_propietario.id
                                        INNER JOIN tas_solicitante ON tas_maquinaria.solicitante_id = tas_solicitante.id
                                        INNER JOIN tas_clase ON tas_maquinaria.clase_id = tas_clase.id
                                        INNER JOIN tas_marca ON tas_maquinaria.marca_id = tas_marca.id
                                        INNER JOIN tas_modelo ON tas_maquinaria.modelo_id = tas_modelo.id".$filters.$order.$limit);
           
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

        if (isset($data['maquinaria_coordinacion'])) {
            if ($data['maquinaria_coordinacion'] != '' && $filters == '')
                $filters .= " WHERE informe_id = '".$data['maquinaria_coordinacion']."'";
            else if ($data['maquinaria_coordinacion'] != '' && $filters != '')
                $filters .= " AND informe_id = '".$data['maquinaria_coordinacion']."'";
        }

        if (isset($data['maquinaria_solicitante'])) {
            if ($data['maquinaria_solicitante'] != '' && $filters == '')
                $filters .= " WHERE IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) LIKE '%".$data['maquinaria_solicitante']."%'";
            else if ($data['maquinaria_solicitante'] != '' && $filters != '')
                $filters .= " AND IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) LIKE '%".$data['maquinaria_solicitante']."%'";
        }

        if (isset($data['maquinaria_cliente'])) {
            if ($data['maquinaria_cliente'] != '' && $filters == '')
                $filters .= " WHERE IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) LIKE '%".$data['maquinaria_cliente']."%'";
            else if ($data['maquinaria_cliente'] != '' && $filters != '')
                $filters .= " AND IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) LIKE '%".$data['maquinaria_cliente']."%'";
        }

        if (isset($data['maquinaria_clase'])) {
            if ($data['maquinaria_clase'] != '' && $filters == '')
                $filters .= " WHERE clase_id = '".$data['maquinaria_clase']."'";
            else if ($data['maquinaria_clase'] != '' && $filters != '')
                $filters .= " AND clase_id = '".$data['maquinaria_clase']."'";
        }

        if (isset($data['maquinaria_marca'])) {
            if ($data['maquinaria_marca'] != '' && $filters == '')
                $filters .= " WHERE marca_id = '".$data['maquinaria_marca']."'";
            else if ($data['maquinaria_marca'] != '' && $filters != '')
                $filters .= " AND marca_id = '".$data['maquinaria_marca']."'";
        }

        if (isset($data['maquinaria_modelo'])) {
            if ($data['maquinaria_modelo'] != '' && $filters == '')
                $filters .= " WHERE modelo_id = '".$data['maquinaria_modelo']."'";
            else if ($data['maquinaria_modelo'] != '' && $filters != '')
                $filters .= " AND modelo_id = '".$data['maquinaria_modelo']."'";
        }

        if (isset($data['maquinaria_fecha_desde']) && isset($data['maquinaria_fecha_hasta'])) {
            if ($data['maquinaria_fecha_desde'] != '' && $data['maquinaria_fecha_hasta'] != '' && $filters == '')
                $filters .= " WHERE DATE_FORMAT(tas_maquinaria.tasacion_fecha, '%Y-%m-%d') BETWEEN  '".$data['maquinaria_fecha_desde']."' AND '".$data['maquinaria_fecha_hasta']."'";
            else if ($data['maquinaria_fecha_desde'] != '' && $data['maquinaria_fecha_hasta'] != '' && $filters != '')
                $filters .= " AND DATE_FORMAT(tas_maquinaria.tasacion_fecha, '%Y-%m-%d') BETWEEN  '".$data['maquinaria_fecha_desde']."' AND '".$data['maquinaria_fecha_hasta']."'";    
        }

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            tas_maquinaria.id,
                                            informe_id,
                                            DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                            cliente_id,
                                            replace(IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)), '\\\\', '') cliente_nombre,
                                            propietario_id,
                                            tas_propietario.nombre propietario_nombre,
                                            solicitante_id,
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
                                        FROM tas_maquinaria
                                        LEFT JOIN tas_propietario ON tas_maquinaria.propietario_id = tas_propietario.id
                                        LEFT JOIN tas_cliente ON tas_maquinaria.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                        LEFT JOIN tas_solicitante ON tas_maquinaria.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                        LEFT JOIN involucrado_natural cli_nat ON tas_maquinaria.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                        LEFT JOIN involucrado_juridico cli_jur ON tas_maquinaria.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                        LEFT JOIN involucrado_natural sol_nat ON tas_maquinaria.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                        LEFT JOIN involucrado_juridico sol_jur ON tas_maquinaria.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                        LEFT JOIN tas_clase ON tas_maquinaria.clase_id = tas_clase.id
                                        LEFT JOIN tas_marca ON tas_maquinaria.marca_id = tas_marca.id
                                        LEFT JOIN tas_modelo ON tas_maquinaria.modelo_id = tas_modelo.id".$filters.$order.$limit);

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
        $this->db->insert('tas_maquinaria', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('tas_maquinaria', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
}

/* End of file Maquinaria_m.php */
/* Location: ./application/models/tasacion/Maquinaria_m.php */