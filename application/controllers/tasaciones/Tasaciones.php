<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasaciones extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tasaciones/tasacion_m','m');
    }

    public function index(){
       // $this->load->view('welcome_message');
        $data['view'] = 'tasaciones/tasaciones_list';
        $this->load->view('layout', $data);
    }

    //################### API REST ###########################

    public function showAllTasacionesCasa(){
        $response = $this ->m->tasacionesCasa();
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function showAllTasacionesCasaPorDato($match){
        $response = $this ->m->tasacionesCasaPorCampos($match);
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function tasacionesCasa(){
        $data['view'] = 'tasaciones/tasaciones_de_casa';
        $this->load->view('layoutGrid', $data);
    }
    public function tasacionesCasaMapa(){
        $data['view'] = 'tasaciones/tasaciones_mapa_casa';
        $this->load->view('tasaciones/tasaciones_mapa_casa');
    }
    public function tasacionesCasaMapaAnterior(){
        $data['view'] = 'tasaciones/tasaciones_mapa_casa2';
        $this->load->view('tasaciones/tasaciones_mapa_casa2');
    }
    public function showAllTasacionesDepartamento(){
        $response = $this ->m->tasacionesDepartamento();
        //$this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
        echo json_encode($response);
    }
    public function tasacionesDepartamento(){
        $data['view'] = 'tasaciones/tasaciones_de_departamento';
        $this->load->view('layoutGrid', $data);
    }

    public function showAllTasacionesLocalComercial(){
        $response = $this ->m->tasacionesLocalComercial();
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function tasacionesLocalComercial(){
        $data['view'] = 'tasaciones/tasaciones_de_localcomercial';
        $this->load->view('layoutGrid', $data);
    }

    public function showAllTasacionesLocalIndustrial(){
        $response = $this ->m->tasacionesLocalIndustrial();
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function tasacionesLocalIndustrial(){
        $data['view'] = 'tasaciones/tasaciones_de_localindustrial';
        $this->load->view('layoutGrid', $data);
    }

    public function showAllTasacionesTerreno(){
        $response = $this ->m->tasacionesTerreno();
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function tasacionesTerreno(){
        $data['view'] = 'tasaciones/tasaciones_de_terreno';
        $this->load->view('layoutGrid', $data);
	}
	
	public function tasacionesTodas(){
		$respuesta = $this ->m-> tasacionAll();
		echo json_encode($respuesta);
	}

    public function showAllTasacionesOficina(){
        $response = $this ->m->tasacionesOficina();
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function tasacionesOficina(){
        $data['view'] = 'tasaciones/tasaciones_de_oficina';
        $this->load->view('layoutGrid', $data);
    }

    public function showAllTasacionesRegistrar(){
        $response = $this ->m->tasacionesPorRegistrar();
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function tasacionesRegistrar(){
        $data['view'] = 'tasaciones/tasaciones_registrar_lista';
        $this->load->view('layoutGrid', $data);
    }
    //########################################################




    public function addTasacionesCasa(){

        if($this->input->post('submit')){
            $this->form_validation->set_rules('informe_id', 'coordinacion', 'trim|required');
            $this->form_validation->set_rules('tasacion_fecha', 'fechaTasacion', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');
            $this->form_validation->set_rules('solicitante_id', 'solicitante', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('user_role', 'User Role', 'trim|required');


            $nuevo_casa_data = array(
                'id' => "",
                'proyecto_id' => $_POST['informe_id'],
                'informe_id' => $_POST['informe_id'],
                'cliente_id' => $_POST['cliente_id'],
                'propietario_id' => $_POST['propietario_id'],
                'solicitante_id' => $_POST['solicitante_id'],
                'ubicacion' => $_POST['ubicacion'],
                'tasacion_fecha' => $_POST['tasacion_fecha'],
                'ubi_departamento_id' => $_POST['ubi_departamento_id'],
                'ubi_provincia_id' => $_POST['ubi_provincia_id'],
                'ubi_distrito_id' => $_POST['ubi_distrito_id'],
                'mapa_latitud' => $_POST['mapa_latitud'],
                'mapa_longitud' => $_POST['mapa_longitud'],
                'zonificacion' => $_POST['tasacion_zonificacion_id'],
                'piso_cantidad' => $_POST['piso_cantidad'],
                'terreno_area' => $_POST['terreno_area'],
                'terreno_valorunitario' => $_POST['terreno_valorunitario'],
                'edificacion_area' => $_POST['edificacion_area'],
                'valor_comercial' => $_POST['valor_comercial'],
                'areas_complementarias' => $_POST['areas_complementarias'],
                'tipo_cambio' => $_POST['tipo_cambio'],
                'observacion' => $_POST['observacion'],
                'usuario_registro_id' => $_POST['usuario_registro_id'],
                'ruta_informe' => str_replace("\\","\\\\",$_POST['ruta_informe']));


            if ($this->form_validation->run() == FALSE) {
                $data['view'] = 'tasaciones/tasaciones_casa_add';
                $this->load->view('tasaciones/layout', $data);
            }
            else{
                $data = array(
                    'username' => $this->input->post('firstname').' '.$this->input->post('lastname'),
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'email' => $this->input->post('email'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'is_admin' => $this->input->post('user_role'),
                    'created_at' => date('Y-m-d : h:m:s'),
                    'updated_at' => date('Y-m-d : h:m:s'),
                    'created_usu' => $this->session->userdata('admin_id')

                );
                $data = $this->security->xss_clean($data);
                $response = $this->user_model->add_user($data);
                if($response){
                    $this->session->set_flashdata('msg', 'Record is Added Successfully!');
                    redirect(base_url('admin/users'));
                }
            }
        }
        else{
            $data['view'] = 'tasaciones/tasaciones_casa_add';
            $this->load->view('tasaciones/layout', $data);
        }

        /*$zonificacion = $this->m->listar_zonificacion();
        $option = "<option value=''>Seleccione Zonificacion</option>";
        foreach($zonificacion as $item) {
            $option .= "<option value='$item->id'>$item->detalle</option>";
        }
        $data['combo_zonificacion'] = $option;*/

        $data['view'] = 'tasaciones/tasaciones_casa_add';
        $this->load->view('layout', $data);
    }
    public function showAllProvincia($data){
        $response = $this ->m->listarProvincia($data);
        echo json_encode($response);
    }
    public function showAllDistrito($data2){
        $response = $this ->m->listarDistrito($data2);
        echo json_encode($response);
    }
    public function showAllZonificacion($data2){
        $response = $this ->m->listarZonificacion($data2);
        echo json_encode($response);
    }

}