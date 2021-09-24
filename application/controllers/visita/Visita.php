<?php
require APPPATH . 'libraries/REST_Controller.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Visita extends REST_Controller {
    

	
	function __construct() {
        parent::__construct();

		/*MODELOS*/
        $this->load->model('visita/visita_m', 'vst');

		/*LIBRERIAS*/
        $this->load->library('excel');
    }
	
	public function index_get(){
	    echo "LLEGO";
	}

    public function insert_post()
    {
        
        $response = $this->vst->insert(
            $this->post('inspeccion_id'),
            $this->post('atendido'),
            $this->post('direccion'),
            $this->post('nro_suministro'),
            $this->post('nro_puerta'),
            $this->post('ocupado'),
            $this->post('uso'),
            $this->post('muros'),
            $this->post('techos'),
            $this->post('inst_electricas'),
            $this->post('inst_sanitarias'),
            $this->post('calidad_construccion'),
            $this->post('puerta_tipo'),
            $this->post('puerta_material'),
            $this->post('puerta_sistema'),
            $this->post('ventana_marco'),
            $this->post('ventana_vidrio'),
            $this->post('ventana_sistema'),
            $this->post('piso_tipo'),
            $this->post('piso_material'),
            $this->post('revestimiento_tipo'),
            $this->post('revestimiento_material'),
            $this->post('vias_dispone'),
            $this->post('vias_calidad'),
            $this->post('vias_conservacion'),
            $this->post('veredas_dispone'),
            $this->post('veredas_calidad'),
            $this->post('veredas_conservacion'),
            $this->post('alcantarillado_dispone'),
            $this->post('alcantarillado_calidad'),
            $this->post('alcantarillado_conservacion'),
            $this->post('aguapotable_dispone'),
            $this->post('aguapotable_calidad'),
            $this->post('aguapotable_conservacion'),
            $this->post('alumbrado_dispone'),
            $this->post('alumbrado_calidad'),
            $this->post('alumbrado_conservacion'),
            $this->post('distribucion_inmueble')
          );
        
        $msg['success'] = "false";
        if ($response){
            $msg['success'] = "true";
        }
        $this->response($msg);
  
    	$field = array(
             'inspeccion_id' => $this->input->post('inspeccion_id'),
              'atendido'=> $this->input->post('atendido'),
              'direccion'=> $this->input->post('direccion'),
              'nro_suministro'=> $this->input->post('nro_suministro'),
              'nro_puerta'=> $this->input->post('nro_puerta'),
              'ocupado'=> $this->input->post('ocupado'),
              'uso'=> $this->input->post('uso'),
              'muros'=> $this->input->post('muros'),
              'techos'=> $this->input->post('techos'),
              'inst_electricas'=> $this->input->post('inst_electricas'),
              'inst_sanitarias'=> $this->input->post('inst_sanitarias'),
              'calidad_construccion'=> $this->input->post('calidad_construccion'),
              'puerta_tipo'=> $this->input->post('puerta_tipo'),
              'puerta_material'=> $this->input->post('puerta_material'),
              'puerta_sistema'=> $this->input->post('puerta_sistema'),
              'ventana_marco'=> $this->input->post('ventana_marco'),
              'ventana_vidrio'=> $this->input->post('ventana_vidrio'),
              'ventana_sistema'=> $this->input->post('ventana_sistema'),
              'piso_tipo'=> $this->input->post('piso_tipo'),
              'piso_material'=> $this->input->post('piso_material'),
              'revestimiento_tipo'=> $this->input->post('revestimiento_tipo'),
              'revestimiento_material'=> $this->input->post('revestimiento_material'),
              'vias_dispone'=> $this->input->post('vias_dispone'),
              'vias_calidad'=> $this->input->post('vias_calidad'),
              'vias_conservacion'=> $this->input->post('vias_conservacion'),
              'veredas_dispone'=> $this->input->post('veredas_dispone'),
              'veredas_calidad'=> $this->input->post('veredas_calidad'),
              'veredas_conservacion'=> $this->input->post('veredas_conservacion'),
              'alcantarillado_dispone'=> $this->input->post('alcantarillado_dispone'),
              'alcantarillado_calidad'=> $this->input->post('alcantarillado_calidad'),
              'alcantarillado_conservacion'=> $this->input->post('alcantarillado_conservacion'),
              'aguapotable_dispone'=> $this->input->post('aguapotable_dispone'),
              'aguapotable_calidad'=> $this->input->post('aguapotable_calidad'),
              'aguapotable_conservacion'=> $this->input->post('aguapotable_conservacion'),
              'alumbrado_dispone'=> $this->input->post('alumbrado_dispone'),
              'alumbrado_calidad'=> $this->input->post('alumbrado_calidad'),
              'alumbrado_conservacion'=> $this->input->post('alumbrado_conservacion'),
              'distribucion_inmueble'=> $this->input->post('distribucion_inmueble')
        );
        //$json = json_encode($field);
        //$insertField = array('json_field' => $json);

     
        //$response = $this->vst->insert($inspeccion);

        //$msg['success'] = false;
        //if ($response){
            //$msg['success'] = true;
        //}
        
        
        
        //echo json_encode($msg);
        
        
    }


    public function update_put()
    {
    	$field = array(
            'inspeccion_codigo' => $this->input->post('inspeccion_codigo')
        );

        $update = $this->vst->updateDetalle($field, $this->input->post('visita_codigo'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    public function index_post()
    {
        $datos = json_decode($this->input->post('data'));
        
    	$resultVisita = $this->vst->search(array('action' => 'sheet', 'inspeccion_codigo' => $datos->inspeccion_codigo));
    	
        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('./files/formatInspeccion.xlsx');

        // Indicamos que se pare en la hoja uno del libro
        $objPHPExcel->setActiveSheetIndex(0);

       
        
        //$objPHPExcel->getActiveSheet()->SetCellValue('S32', 'PROPIETARIO');
        //$objPHPExcel->getActiveSheet()->SetCellValue('B1', $resultVisita->cliente_nombre);
        //$objPHPExcel->getActiveSheet()->SetCellValue('B2', $resultVisita->solicitante_nombre);
        $objPHPExcel->getActiveSheet()->SetCellValue('B3', $resultVisita->solicitante_nombre);
        $objPHPExcel->getActiveSheet()->SetCellValue('B4', $resultVisita->cliente_nombre);
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', $resultVisita->atendido);
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', $resultVisita->direccion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B7', $resultVisita->nro_suministro);
        $objPHPExcel->getActiveSheet()->SetCellValue('B8', $resultVisita->nro_puerta);
        $objPHPExcel->getActiveSheet()->SetCellValue('B9', $resultVisita->ocupado);
        $objPHPExcel->getActiveSheet()->SetCellValue('B10', $resultVisita->uso);
        $objPHPExcel->getActiveSheet()->SetCellValue('B11', $resultVisita->muros);
        $objPHPExcel->getActiveSheet()->SetCellValue('B12', $resultVisita->techos);
        $objPHPExcel->getActiveSheet()->SetCellValue('B13', $resultVisita->inst_electricas);
        $objPHPExcel->getActiveSheet()->SetCellValue('B14', $resultVisita->inst_sanitarias);
        $objPHPExcel->getActiveSheet()->SetCellValue('B15', $resultVisita->calidad_construccion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B16', $resultVisita->puerta_tipo);
        $objPHPExcel->getActiveSheet()->SetCellValue('B17', $resultVisita->puerta_material);
        $objPHPExcel->getActiveSheet()->SetCellValue('B18', $resultVisita->puerta_sistema);
        $objPHPExcel->getActiveSheet()->SetCellValue('B19', $resultVisita->ventana_marco);
        $objPHPExcel->getActiveSheet()->SetCellValue('B20', $resultVisita->ventana_vidrio);
        $objPHPExcel->getActiveSheet()->SetCellValue('B21', $resultVisita->ventana_sistema);
        $objPHPExcel->getActiveSheet()->SetCellValue('B22', $resultVisita->piso_tipo);
        $objPHPExcel->getActiveSheet()->SetCellValue('B23', $resultVisita->piso_material);
        $objPHPExcel->getActiveSheet()->SetCellValue('B24', $resultVisita->revestimiento_tipo);
        $objPHPExcel->getActiveSheet()->SetCellValue('B25', $resultVisita->revestimiento_material);
        $objPHPExcel->getActiveSheet()->SetCellValue('B26', $resultVisita->vias_dispone);
        $objPHPExcel->getActiveSheet()->SetCellValue('B27', $resultVisita->vias_calidad);
        $objPHPExcel->getActiveSheet()->SetCellValue('B28', $resultVisita->vias_conservacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B29', $resultVisita->veredas_dispone);
        $objPHPExcel->getActiveSheet()->SetCellValue('B30', $resultVisita->veredas_calidad);
        $objPHPExcel->getActiveSheet()->SetCellValue('B31', $resultVisita->veredas_conservacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B32', $resultVisita->alcantarillado_dispone);
        $objPHPExcel->getActiveSheet()->SetCellValue('B33', $resultVisita->alcantarillado_calidad);
        $objPHPExcel->getActiveSheet()->SetCellValue('B34', $resultVisita->alcantarillado_conservacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B35', $resultVisita->aguapotable_dispone);
        $objPHPExcel->getActiveSheet()->SetCellValue('B36', $resultVisita->aguapotable_calidad);
        $objPHPExcel->getActiveSheet()->SetCellValue('B37', $resultVisita->aguapotable_conservacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B38', $resultVisita->alumbrado_dispone);
        $objPHPExcel->getActiveSheet()->SetCellValue('B39', $resultVisita->alumbrado_calidad);
        $objPHPExcel->getActiveSheet()->SetCellValue('B40', $resultVisita->alumbrado_conservacion);
        $objPHPExcel->getActiveSheet()->SetCellValue('B41', $resultVisita->distribucion_inmueble);

        //$objPHPExcel->setActiveSheetIndex(1);

        $fileName = 'Reporte de Inspeccion -' . date('dmY-his') . '.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
}

/* End of file Visita.php */
/* Location: ./application/controllers/visita/Visita.php */