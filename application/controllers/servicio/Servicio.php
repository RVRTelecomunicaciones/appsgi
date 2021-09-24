<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        /*MODELOS*/
        $this->load->model('servicio/Servicio_m', 'serv');
		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		redirect('intranet/inicio');
	}

	public function searchServicioCombo()
	{
		$filters = array(
			'accion' => 'tipo_servicio',
			'servicio_tipo_id' => $this->input->post('servicio_tipo_id')
		);

		$data = array(
						'servicio_records' => $this->serv->searchServicio($filters)
					);

		echo json_encode($data);
	}

	public function searchServicio()
	{
		$filters_find =   array(
			'accion' => $this->input->post('accion'),
			'tipo_servicio' => $this->input->post('tipo_servicio'),
            'servicio_nombre' => $this->input->post('servicio_nombre'),
            'servicio_estado' => $this->input->post('servicio_estado')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'servicio_records' => $this->serv->searchServicio($filters),
        	'total_records_find' => $this->serv->searchServicio($filters) == false ? 0 : count($this->serv->searchServicio($filters_find)),
        	'total_records' => count($this->serv->searchServicio(array('accion' => 'filtros', 'tipo_servicio' => $this->input->post('tipo_servicio')))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
			'quantity' => $this->input->post('quantity'),
			'filtros' => $filters
        );

        echo json_encode($data);
	}

	public function insertServicio()
    {
        $field = array (
			'nombre' => $this->input->post('servicio_nombre'),
			'servicio_tipo_id' => $this->input->post('tipo_id'),
            'info_status' => $this->input->post('servicio_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->serv->InsertServicio($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateServicio()
    {
        $field = array (
			'nombre' => $this->input->post('servicio_nombre'),
			'servicio_tipo_id' => $this->input->post('tipo_id'),
            'info_status' => $this->input->post('servicio_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('servicio_fecha_update')
        );

        $update = $this->serv->UpdateServicio($field, $this->input->post('servicio_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
	}
	
	//reporte 
	public function servicioMasCotizado()
	{
		$filters =   array(
			'accion' => $this->input->post('accion'),
			'anio' => $this->input->post('anio'),
            'mes' => $this->input->post('mes')
        );

        $data = array(
            'servicio_mas_cotizado_records' => $this->serv->servicioMasCotizado($filters)
        );

        echo json_encode($data);
	}

	public function mayorServicioCotizado()
	{
		$filters =   array(
			'accion' => $this->input->post('accion'),
			'anio' => $this->input->post('anio'),
			'mes' => $this->input->post('mes'),
			'tipo' => $this->input->post('tipo')
        );

        $data = array(
            'mayor_servicio_cotizado_records' => $this->serv->mayorServicioCotizado($filters)
        );

        echo json_encode($data);
	}

	public function resumenVentasPorServicios()
	{
		$filters =   array(
			'accion' => $this->input->post('accion'),
			'anio' => $this->input->post('anio'),
			'mes' => $this->input->post('mes'),
			'tipo' => $this->input->post('tipo')
        );

        $data = array(
            'ventas_servicio' => $this->serv->resumenVentasPorServicios($filters)
        );

        echo json_encode($data);
	}
}

/* End of file Servicio.php */
/* Location: ./application/controllers/servicio/Servicio.php */