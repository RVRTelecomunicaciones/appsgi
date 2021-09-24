<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permiso extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('permiso/permiso_m','prm');
    }

    /*public function index()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['view'] = 'permiso/permiso_list';
			$this->load->view('layout', $data);
		}
    }*/

    public function searchPermiso()
    {
        $filters =   array(
            'usuario_id' => $this->input->post('usuario_id')
        );

        $data = array(
            'permiso_records' => $this->prm->searchPermiso($filters)
        );

        echo json_encode($data);
    }

    public function asignarPermiso()
    {
        $objPermiso = json_decode($this->input->post('permisos'));
        
        if (count((array) $objPermiso) > 0) {
            $i = 0;
            foreach ($objPermiso as $row) {
                if ($row->permiso_accion == 'add') {
                    $field = array(
                        'usuario_id' => $row->usuario_id,
                        'menu_id' => $row->menu_id,
                        'lectura' => $row->permiso_lectura,
                        'escritura' => $row->permiso_escritura
                    );
        
                    $insert = $this->prm->Insert($field);
                    if ($insert > 0)
                        $i++;
                } else if ($row->permiso_accion == 'upd') {
                    $field = array(
                        'lectura' => $row->permiso_lectura,
                        'escritura' => $row->permiso_escritura
                    );

                    $update = $this->prm->Update($field, $row->permiso_id);
                    if ($update > 0)
                        $i++;

                } else if ($row->permiso_accion == 'del') {
                    $delete = $this->prm->Delete($row->permiso_id);
                    if ($delete > 0)
                        $i++;
                }
            }

            if ($i > 0)
                $msg['success'] = true;
            
            echo json_encode($msg);
        } else {
            $msg['success'] = false;
            echo json_encode($msg);
        }
    }
}

/* End of file permiso.php */
/* Location: ./application/contpermisolers/permiso/permiso.php */