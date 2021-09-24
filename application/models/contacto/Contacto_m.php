<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto_m extends CI_Model {

	public function contactoReporte($id)
	{
		$query = $this->db->query("	SELECT
										id contacto_id,
									    TRIM(nombre) contacto_nombre,
									    cargo contacto_cargo,
									    telefono contacto_telefono,
									    correo contacto_correo,
									    juridica_id
									FROM co_involucrado_contacto
									/*ANTIGUO
                                        WHERE juridica_id = $id AND info_status = 1 OR id = 0
                                    */
                                    WHERE juridica_id_new = $id AND info_status = 1 OR id = 0
									ORDER BY id ASC");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	public function searchContacto($search, $init = FALSE, $quantity = FALSE)
    {
        $filters = "";
        $limit = "";


        if ($search['involucrado_juridico'] != '') {
            /*ANTIGUO
                $filters .= " WHERE juridica_id = ".$search['involucrado_juridico'];*/
            $filters .= " WHERE juridica_id_new = ".$search['involucrado_juridico'];
        }

        if ($search['contacto_nombre'] != '' && $filters == '')
            $filters .= " WHERE TRIM(nombre) LIKE '%".$search['contacto_nombre']."%'";
        else if ($search['contacto_nombre'] != '' && $filters != '')
            $filters .= " AND TRIM(nombre) LIKE '%".$search['contacto_nombre']."%'";

        if ($search['contacto_cargo'] != '' && $filters == '')
            $filters .= " WHERE cargo LIKE '%".$search['contacto_cargo']."%'";
        else if ($search['contacto_cargo'] != '' && $filters != '')
        	$filters .= " AND cargo = ".$search['contacto_cargo'];

        if ($search['contacto_correo'] != '' && $filters == '')
            $filters .= " WHERE correo LIKE '%".$search['contacto_correo']."%'";
        else if ($search['contacto_correo'] != '' && $filters != '')
        	$filters .= " AND correo LIKE '%".$search['contacto_correo']."%'";

        if ($search['contacto_estado'] != '' && $filters == '')
            $filters .= " WHERE info_status = ".$search['contacto_estado'];
        else if ($search['contacto_estado'] != '' && $filters != '')
        	$filters .= " AND info_status = ".$search['contacto_estado'];


        if ($init !== FALSE && $quantity !== FALSE)
            $limit .= " LIMIT $init, $quantity";

        $sql_query =    "SELECT
        					id contacto_id,
        					TRIM(nombre) contacto_nombre,
        					cargo contacto_cargo,
        					telefono contacto_telefono,
        					correo contacto_correo,
        					juridica_id,
                            info_status contacto_estado
        				FROM co_involucrado_contacto".$filters."
        				ORDER BY contacto_nombre ASC".$limit.";";

        $records = $this->db->query($sql_query);
        if($records->num_rows()> 0){
            return $records->result();
        }
        else{
            return false;
        }
    }

    public function Insert($data)
    {
        $this->db->insert('co_involucrado_contacto', $data);
        return $this->db->insert_id();
    }

    public function Update($data, $id)
    {
        $this->db->update('co_involucrado_contacto', $data, array('id' => $id));
        return $this->db->affected_rows();
    }
    
    
    
    /**/
    protected $table = 'co_involucrado_contacto';

    protected $table_attributes = array(
        'id',
        'juridica_id_new',
        'TRIM(nombre) nombre',
        'cargo',
        'correo',
        'telefono',
        'info_status'
    );

    protected $table_order = array(
        null,
        'nombre',
        null,
        null
    );

    public function make_query($filters)
    {
        $this->db->select($this->table_attributes);
        $this->db->from($this->table);

        if (isset($filters['juridica_id']) && $filters['juridica_id'] != '')
        {
            $where = 'juridica_id_new = ' . $filters['juridica_id'] . ' OR id = 0';
            //$this->db->where('juridica_id_new', $filters['juridica_id']);
            $this->db->where($where);
        }

        if (isset($filters['nombre']) && $filters['nombre'] != '')
        {
            $this->db->like('nombre', $filters['nombre'], 'BOTH');
        }

        if (isset($filters['order']) && $filters['order'] != '')
        {
            if ($filters['action'] === 'table')
            {
                $this->db->order_by($this->table_order[$filters['order']['0']['column']], $filters['order']['0']['dir']);
            }
            else if ($filters['action'] === 'combobox')
            {
                $this->db->order_by('juridica_id_new desc, nombre asc');
            }
        }        
    }

    public function fetch_all($filters)
    {
        $this->make_query($filters);
        if (isset($filters['length']) && $filters['length'] != -1) {
            $this->db->limit($filters['length'], $filters['start']);
        }
        $query = $this->db->get();

        if ($filters['action'] === 'table')
        {
            return $query->result();
        }
        else if ($filters['action'] === 'combobox')
        {
            return $query->result_array();
        }
    }

    public function count_filter($filters)
    {
        $this->make_query($filters);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);

        return $this->db->count_all_results();
    }
}

/* End of file Contacto_m.php */
/* Location: ./application/models/contacto/Contacto_m.php */