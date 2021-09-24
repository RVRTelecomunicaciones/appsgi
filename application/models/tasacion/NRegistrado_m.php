<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NRegistrado_m extends CI_Model {

	/*public function searchNRegistrado($data)
    {
        $sql_query = "";
        $filters = "";
        $order = " ORDER BY informe_id ASC";
        $limit = "";

        if (isset($data['accion'])) {
        	if ($data['accion'] == 'filtros') {

                if (isset($data['otros_coordinacion'])) {
                    if ($data['otros_coordinacion'] != '' && $filters == '') {
                        $filters .= " WHERE informe_id = " . $data['otros_coordinacion'];
                    } elseif ($data['otros_coordinacion'] != '' && $filters != '') {
                        $filters .= " AND informe_id = " . $data['otros_coordinacion'];
                    }
				}
				
				if (isset($data['otros_tipo'])) {
                    if ($data['otros_tipo'] != '' && $filters == '') {
                        $filters .= " WHERE tipo_no_registrado_id = " . $data['otros_tipo'];
                    } elseif ($data['otros_tipo'] != '' && $filters != '') {
                        $filters .= " AND tipo_no_registrado_id = " . $data['otros_tipo'];
                    }
                }

                if (isset($data['otros_observacion'])) {
                    if ($data['otros_observacion'] != '' && $filters == '') {
                        $filters .= " WHERE observacion LIKE '%" . $data['otros_observacion'] . "%'";
                    } elseif ($data['otros_observacion'] != '' && $filters != '') {
                        $filters .= " AND observacion LIKE '%" . $data['otros_observacion'] . "%'";
                    }
				}
        	}
        }

        if (isset($data['quantity']))
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];

        
        $sql_query = $this->db->query(" SELECT
											tas_no_registrado.id,
											informe_id,
                                            DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
											tipo_no_registrado_id,
											tas_no_registrado_tipo.nombre tipo_no_registrado_nombre,
											observacion,
											ruta_informe
										FROM tas_no_registrado
										INNER JOIN tas_no_registrado_tipo ON tas_no_registrado.tipo_no_registrado_id = tas_no_registrado_tipo.id".$filters.$order.$limit);
           
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

        if (isset($data['otros_coordinacion'])) {
            if ($data['otros_coordinacion'] != '' && $filters == '')
                $filters .= " WHERE informe_id = '".$data['otros_coordinacion']."'";
            else if ($data['otros_coordinacion'] != '' && $filters != '')
                $filters .= " AND informe_id = '".$data['otros_coordinacion']."'";
        }

        if (isset($data['otros_tipo'])) {
            if ($data['otros_tipo'] != '' && $filters == '')
                $filters .= " WHERE tipo_no_registrado_id = '".$data['otros_tipo']."'";
            else if ($data['otros_tipo'] != '' && $filters != '')
                $filters .= " AND tipo_no_registrado_id = '".$data['otros_tipo']."'";
        }

        if (isset($data['otros_observacion'])) {
            if ($data['otros_observacion'] != '' && $filters == '')
                $filters .= " WHERE observacion LIKE '%".$data['otros_observacion']."%'";
            else if ($data['otros_observacion'] != '' && $filters != '')
                $filters .= " AND observacion LIKE '%".$data['otros_observacion']."%'";
        }

        if (isset($data['otros_fecha_desde']) && isset($data['otros_fecha_hasta'])) {
            if ($data['otros_fecha_desde'] != '' && $data['otros_fecha_hasta'] != '' && $filters == '')
                $filters .= " WHERE DATE_FORMAT(tas_no_registrado.tasacion_fecha, '%Y-%m-%d') BETWEEN  '".$data['otros_fecha_desde']."' AND '".$data['otros_fecha_hasta']."'";
            else if ($data['otros_fecha_desde'] != '' && $data['otros_fecha_hasta'] != '' && $filters != '')
                $filters .= " AND DATE_FORMAT(tas_no_registrado.tasacion_fecha, '%Y-%m-%d') BETWEEN  '".$data['otros_fecha_desde']."' AND '".$data['otros_fecha_hasta']."'";    
        }

        if (isset($data['init']) && isset($data['quantity'])) {
            $limit .= " LIMIT ".$data['init'].",".$data['quantity'];
        }

        $sql_query = $this->db->query(" SELECT
                                            tas_no_registrado.id,
                                            informe_id,
                                            DATE_FORMAT(tasacion_fecha, '%d-%m-%Y') tasacion_fecha,
                                            tipo_no_registrado_id,
                                            tas_no_registrado_tipo.nombre tipo_no_registrado_nombre,
                                            observacion,
                                            ruta_informe
                                        FROM tas_no_registrado
                                        INNER JOIN tas_no_registrado_tipo ON tas_no_registrado.tipo_no_registrado_id = tas_no_registrado_tipo.id".$filters.$order.$limit);

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
		$this->db->insert('tas_no_registrado', $data);
        return $this->db->insert_id();
	}

	public function Update($data, $id)
	{
		$this->db->update('tas_no_registrado', $data, array('id' => $id));
        return $this->db->affected_rows();
	}

}

/* End of file NRegistrado_m.php */
/* Location: ./application/models/tasacion/NRegistrado_m.php */