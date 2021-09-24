<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('estado/estado_m', 'est');
        $this->load->model('tservicio/TServicio_m', 'tps');
        $this->load->model('perito/perito_m', 'per');
        $this->load->model('calidad/calidad_m', 'ccal');
        $this->load->model('coordinador/coordinador_m', 'coor');
        $this->load->model('inspeccion/inspeccion_m', 'insp');

        $this->load->model('coordinacion/coordinacion_m', 'coord');

        $this->load->model('auditoria/auditoria_m', 'aud');

        $this->load->model('motivo/motivo_m', 'mot');

        /*LIBRERIAS*/
        $this->load->library('excel');
        $this->load->library('pdf');
    }

	public function index()
	{
		/*$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/reporte_dashboard';
			$this->load->view('layout', $data);
        }*/
        redirect('intranet/inicio');
    }
    /* BEGIN ADMINISTRACIÓN */
    public function administracion()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/reporte_administracion';
			$this->load->view('layout', $data);
		}
    }

    public function terminadas()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	/*$data['estado'] = $this->est->estadoCoordinacion();
            $data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['ccalidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));*/
        	$data['view'] = 'reporte/administracion/terminadas/reporte_coordinacion_terminadas';
			$this->load->view('layout', $data);
		}
    }

    public function searchCoordinacionTerminadas()
    {
        $filters_count = array('action' => 'count');

        $filters_find =   array(
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'coordinacion_estado' => $this->input->post('coordinacion_estado'),
            'coordinacion_solicitante' => $this->input->post('coordinacion_solicitante'),
            'coordinacion_cliente' => $this->input->post('coordinacion_cliente'),
            'coordinacion_servicio_tipo' => $this->input->post('coordinacion_servicio_tipo'),
            /*'coordinacion_fecha_tipo' => '1',
            'coordinacion_fecha_desde' => $this->input->post('coordinacion_fecha_desde'),
            'coordinacion_fecha_hasta' => $this->input->post('coordinacion_fecha_hasta')*/
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $body = ""; $iItem = 0;
        
        $cabezera = $this->coord->search($filters);

        if ($cabezera != false) {
            foreach ($cabezera as $rowItem) {
                $rowSpan = $rowItem->auditoria > 1 ? 'rowspan="'.$rowItem->auditoria.'"' : '';
                
                $body .=    "<tr>
                                <td $rowSpan>".(($this->input->post('num_page') - 1) * $this->input->post('quantity') + $iItem + 1)."</td>
                                <td $rowSpan>$rowItem->coordinacion_correlativo</td>
                                <td $rowSpan>$rowItem->estado_nombre</td>
                                <td $rowSpan>".strtoupper($rowItem->solicitante_nombre)."</td>
                                <td $rowSpan>".strtoupper($rowItem->cliente_nombre)."</td>
                                <td $rowSpan>".strtoupper($rowItem->servicio_tipo_nombre)."</td>
                                <td $rowSpan>$rowItem->coordinacion_fecha_entrega</td>";
                $cuerpo = $this->aud->search(array('coordinacion_codigo' => $rowItem->coordinacion_id, 'coordinacion_estado' => '4,8'));
                $bodyAuditoria = "";
                if (!empty($cuerpo)) {
                    $iSubItem = 0;
                    foreach ($cuerpo as $rowSubItem) {
                        if ($iSubItem == 0) {
                            $body .="<td>".strtoupper($rowSubItem->estado_nombre)."</td>
                                    <td>".strtoupper($rowSubItem->auditoria_fecha)."</td>";
                        } else {
                            $bodyAuditoria .="<tr>
                                                <td>".strtoupper($rowSubItem->estado_nombre)."</td>
                                                <td>".strtoupper($rowSubItem->auditoria_fecha)."</td>
                                            </tr>";
                        }
                        $iSubItem++;
                    }
                } else {
                    $body .=    "<td></td>
                                <td></td>";
                }

                $body .=    "</tr>";

                $body .= $bodyAuditoria;
                $iItem++;
            }
        }
        
        $data = array(
            'records_all_count' => $this->coord->search($filters_count),
            'records_find_count' => $this->coord->search(array_merge($filters_count, $filters_find)),
            'records_find' => $body
        );

        echo json_encode($data);
    }
    /* END ADMINISTRACIÓN */

    /* BEGIN COORDINACION */
	public function coordinacion()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/reporte_coordinacion';
			$this->load->view('layout', $data);
		}
	}

	public function generadas()
	{
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = $this->uri->segment(1);
            $data['conteo'] = $this->coord->countCoordinaciones();
            $data['estado'] = $this->est->estadoCoordinacion();
            $data['tipo_servicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['control_calidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'reporte/coordinacion/generadas/reporte_generadas';
            $this->load->view('layout', $data);
        }
    }
    
    public function searchGeneradas()
    {
        $filters_count = array('action' => 'count');

        $filters_find =   array(
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'coordinacion_estado' => $this->input->post('coordinacion_estado'),
            'coordinacion_solicitante' => $this->input->post('coordinacion_solicitante'),
            'coordinacion_cliente' => $this->input->post('coordinacion_cliente'),
            'coordinacion_servicio_tipo' => $this->input->post('coordinacion_servicio_tipo'),
            'coordinacion_direccion' => $this->input->post('coordinacion_direccion'),
            'coordinacion_perito' => $this->input->post('coordinacion_perito'),
            'coordinacion_digitador' => $this->input->post('coordinacion_digitador'),
            'coordinacion_control_calidad' => $this->input->post('coordinacion_control_calidad'),
            'coordinacion_coordinador' => $this->input->post('coordinacion_coordinador'),
            //'coordinacion_riesgo' => $this->input->post('coordinacion_riesgo'),
            'coordinacion_fecha_tipo' => $this->input->post('coordinacion_fecha_tipo'),
            'coordinacion_fecha_desde' => $this->input->post('coordinacion_fecha_desde'),
            'coordinacion_fecha_hasta' => $this->input->post('coordinacion_fecha_hasta'),

            'order' => $this->input->post('order'),
            'order_type' => $this->input->post('order_type')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $body = ""; $iItem = 0;
        /*if ($this->input->post('action') != 'maintenance' && $this->input->post('action') != 'cotizacion') {*/
            $cabezera = $this->coord->search($filters);

            if ($cabezera != false) {
                foreach ($cabezera as $rowItem) {
                    $rowSpan = $rowItem->cantidad_inspeccion > 1 ? 'rowspan="'.$rowItem->cantidad_inspeccion.'"' : '';
                    $backgound = "";
                    if ($rowItem->riesgo_id == '1')
                        $backgound = 'green';
                    else if ($rowItem->riesgo_id == '2')
                        $backgound = 'yellow; color: black';
                    else
                        $backgound = 'red';

                    $body .=    "<tr>
                                    <td $rowSpan>".(($this->input->post('num_page') - 1) * $this->input->post('quantity') + $iItem + 1)."</td>
                                    <td $rowSpan><div style='color: #009c9f;'>$rowItem->coordinacion_correlativo</div></td>
                                    <td $rowSpan>$rowItem->estado_nombre</td>
                                    <td $rowSpan>".strtoupper($rowItem->solicitante_nombre)."</td>
                                    <td $rowSpan>".strtoupper($rowItem->cliente_nombre)."</td>
                                    <td $rowSpan>".strtoupper($rowItem->servicio_tipo_nombre)."</td>";
                    $cuerpo = $this->insp->search(array('coordinacion_codigo' => $rowItem->coordinacion_id));
                    $bodyInspeccion = "";
                    if (!empty($cuerpo)) {
                        $iSubItem = 0;
                        foreach ($cuerpo as $rowSubItem) {
                            if ($iSubItem == 0) {
                                $body .="<td>".strtoupper($rowSubItem->inspeccion_direccion)."
                                            <div>$rowSubItem->departamento_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->provincia_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->distrito_nombre</div>
                                        </td>
                                        <td>$rowSubItem->inspeccion_fecha</td>
                                        <td>".strtoupper($rowSubItem->perito_nombre)."</td>";
                            } else {
                                $bodyInspeccion .="<tr>
                                                    <td>".strtoupper($rowSubItem->inspeccion_direccion)."
                                                        <div>$rowSubItem->departamento_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->provincia_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->distrito_nombre</div>
                                                    </td>
                                                    <td>$rowSubItem->inspeccion_fecha</td>
                                                    <td>".strtoupper($rowSubItem->perito_nombre)."</td>
                                                </tr>";
                            }
                            $iSubItem++;
                        }
                    } else {
                        $body .=    "<td></td>
                                    <td></td>
                                    <td></td>";
                    }

                    $body .=        "<td $rowSpan>".strtoupper($rowItem->digitador_nombre)."</td>
                                    <td $rowSpan>".strtoupper($rowItem->control_calidad_nombre)."</td>
                                    <td $rowSpan>".strtoupper($rowItem->coordinador_nombre)."</td>
                                    <td $rowSpan>$rowItem->coordinacion_fecha_entrega</td>
                                    <td $rowSpan>$rowItem->coordinacion_fecha_creacion</td>
                                </tr>";

                    $body .= $bodyInspeccion;
                    $iItem++;
                }
            }
        /*}*/
        /*$data = array();

        if ($this->input->post('action') == 'maintenance') {
            $data = array(
                'records_find' => $this->coord->search(array('action' => $this->input->post('action'), 'coordinacion_codigo' => $this->input->post('coordinacion_codigo')))
            );
        } else if ($this->input->post('action') == 'cotizacion') {
            $data = array(
                'records_find' => $this->coord->search(array('action' => $this->input->post('action'), 'cotizacion_codigo' => $this->input->post('cotizacion_codigo')))
            );
        } else if ($this->input->post('action') == 'print') {
            $data = array(
                'records_find' => $body
            );
        } else {*/
            $data = array(
                'records_all_count' => $this->coord->search($filters_count),
                'records_find_count' => $this->coord->search(array_merge($filters_count, $filters_find)),
                'records_find' => $body
            );
        /*}*/

        echo json_encode($data);
    }

	public function imprimirGeneradas()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));
            
            $filters_count = array('action' => 'count');

            $filters_find =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'coordinacion_estado' => $datos->coordinacion_estado,
                'coordinacion_solicitante' => $datos->coordinacion_solicitante,
                'coordinacion_cliente' => $datos->coordinacion_cliente,
                'coordinacion_servicio_tipo' => $datos->coordinacion_servicio_tipo,
                'coordinacion_direccion' => $datos->coordinacion_direccion,
                'coordinacion_perito' => $datos->coordinacion_perito,
                'coordinacion_digitador' => $datos->coordinacion_digitador,
                'coordinacion_control_calidad' => $datos->coordinacion_control_calidad,
                'coordinacion_coordinador' => $datos->coordinacion_coordinador,
                //'coordinacion_riesgo' => $datos->coordinacion_riesgo,
                'coordinacion_fecha_tipo' => $datos->coordinacion_fecha_tipo,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta,
                
                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $cabezera = $this->coord->search($filters_find);

            $body = ""; $iItem = 0;
            if ($cabezera != false) {
                foreach ($cabezera as $rowItem) {
                    $rowSpan = $rowItem->cantidad_inspeccion > 1 ? 'rowspan="'.$rowItem->cantidad_inspeccion.'"' : '';
                    $body .=    "<tr>
                                    <td style='font-size: 0.5rem' $rowSpan>".(($this->input->post('num_page') - 1) * $this->input->post('quantity') + $iItem + 1)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan><div style='color: #009c9f;'>$rowItem->coordinacion_correlativo</div></td>
                                    <td style='font-size: 0.5rem' $rowSpan>$rowItem->estado_nombre</td>
                                    <td style='font-size: 0.5rem' $rowSpan>".strtoupper($rowItem->solicitante_nombre)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan>".strtoupper($rowItem->cliente_nombre)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan>".strtoupper($rowItem->servicio_tipo_nombre)."</td>";
                    $cuerpo = $this->insp->search(array('coordinacion_codigo' => $rowItem->coordinacion_id));
                    $bodyInspeccion = "";
                    if (!empty($cuerpo)) {
                        $iSubItem = 0;
                        foreach ($cuerpo as $rowSubItem) {
                            if ($iSubItem == 0) {
                                $body .="<td style='font-size: 0.5rem'>".strtoupper($rowSubItem->inspeccion_direccion)."
                                            <div>$rowSubItem->departamento_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->provincia_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->distrito_nombre</div>
                                        </td>
                                        <td style='font-size: 0.5rem'>$rowSubItem->inspeccion_fecha</td>
                                        <td style='font-size: 0.5rem'>".strtoupper($rowSubItem->perito_nombre)."</td>";
                            } else {
                                $bodyInspeccion .="<tr>
                                                    <td style='font-size: 0.5rem'>".strtoupper($rowSubItem->inspeccion_direccion)."
                                                        <div>$rowSubItem->departamento_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->provincia_nombre <i class='fa fa-play text-danger'></i> $rowSubItem->distrito_nombre</div>
                                                    </td>
                                                    <td style='font-size: 0.5rem'>$rowSubItem->inspeccion_fecha</td>
                                                    <td style='font-size: 0.5rem'>".strtoupper($rowSubItem->perito_nombre)."</td>
                                                </tr>";
                            }
                            $iSubItem++;
                        }
                    } else {
                        $body .=    "<td></td>
                                    <td></td>
                                    <td></td>";
                    }

                    $body .=        "<td style='font-size: 0.5rem' $rowSpan>".strtoupper($rowItem->digitador_nombre)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan>".strtoupper($rowItem->control_calidad_nombre)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan>".strtoupper($rowItem->coordinador_nombre)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan>$rowItem->coordinacion_fecha_entrega</td>
                                    <td style='font-size: 0.5rem' $rowSpan>$rowItem->coordinacion_fecha_creacion</td>
                                </tr>";

                    $body .= $bodyInspeccion;
                    $iItem++;
                }
            }

            $data['coordinacion'] = $body;
            $data['filtros'] = $filters_find;
            $data['cantidad'] = $this->coord->search(array_merge($filters_count, $filters_find));
            $data['view'] = 'reporte/coordinacion/generadas/reporte_generadas_print';
            $this->load->view('layout_impresion', $data);
        }
    }
    
    
    public function exportarExcelGeneradas()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'coordinacion_estado' => $datos->coordinacion_estado,
                'coordinacion_solicitante' => $datos->coordinacion_solicitante,
                'coordinacion_cliente' => $datos->coordinacion_cliente,
                'coordinacion_servicio_tipo' => $datos->coordinacion_servicio_tipo,
                'coordinacion_direccion' => $datos->coordinacion_direccion,
                'coordinacion_perito' => $datos->coordinacion_perito,
                'coordinacion_digitador' => $datos->coordinacion_digitador,
                'coordinacion_control_calidad' => $datos->coordinacion_control_calidad,
                'coordinacion_coordinador' => $datos->coordinacion_coordinador,
                //'coordinacion_riesgo' => $datos->coordinacion_riesgo,
                'coordinacion_fecha_tipo' => $datos->coordinacion_fecha_tipo,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta,

                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $objPHPExcel = new PHPExcel();

            //Ponemos Nombre a la Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Reporte Coordinación');

            //Definimos Propiedades
            $objPHPExcel->getProperties()->setTitle('Reporte de Coordinación')
                                        ->setCreator('Allemant & Asociados Peritos Valuadores')
                                        ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

            //Combinación de celdas
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:L2');

            //Añadimos titlo del reporte
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'REPORTE DE COORDINACIÓN');

            //Estilo para el titulo del reporte
            $style_title    =   array(
                'font' => array(
                    'name'      => 'Verdana',
                    'bold'      => true,
                    'italic'    => false,
                    'strike'    => false,
                    'size'      => 14,
                    'color'     => array(
                        'rgb' => '000000'
                    )
                ),
                'alignment' =>  array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'rotation'   => 0
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('B2:N2')->applyFromArray($style_title);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:A6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5:B6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:C6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D5:D6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E5:E6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:F6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:I5');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J5:J6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K5:K6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L5:L6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M5:M6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N5:N6');
            
            //Configuramos el tamaño de los encabezados de las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.7);

            //Añadimos los titulos a los encabezados de columnas
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', '#');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'COORD.');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'ESTADO');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'CLIENTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'TIPO SERVICIO');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'INSPECCIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'UBICACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'FECHA');
            $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'PERITO');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'DIGITADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'CONTROL DE CALIDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'COORDINADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'FECHA DE ENTREGA');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'FECHA DE CREACIÓN');

            //Estilo para los encabezados de columnas
            $style_columns_headers   =   array(
                'font'  =>  array(
                    'name'  =>  'Calibri',
                    'bold'  =>  true,
                    'size'  =>  11,
                    'color' =>  array(
                        'rgb'   =>  'FFFFFF'
                    )
                ),
                'fill'  =>  array(
                    'type'  =>  PHPExcel_Style_Fill::FILL_SOLID,
                    'color' =>  array(
                        'rgb'   =>  '00B5B8'
                    )
                ),
                'borders'   =>  array(
                    'top'   =>  array(
                        'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                        'color' =>  array(
                            'rgb'   =>  '000000'
                        )
                    ),
                    'bottom'    =>  array(
                        'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                        'color' =>  array(
                            'rgb'   =>  '000000'
                        )
                    )
                ),
                'alignment' =>  array(
                    'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A5:N6')->applyFromArray($style_columns_headers);

            //Obtener los datos
            $cabezera = $this->coord->search($filters);

            $iItem = 0; $rowCount = 7;
            if ($cabezera != false) {
                foreach ($cabezera as $rowItem) {
                    $iItem = $rowItem->cantidad_inspeccion;

                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 6);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $rowItem->coordinacion_correlativo);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $rowItem->estado_nombre);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper($rowItem->solicitante_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper($rowItem->cliente_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, strtoupper($rowItem->servicio_tipo_nombre));
                    
                    $cuerpo = $this->insp->search(array('coordinacion_codigo' => $rowItem->coordinacion_id));
                    if (!empty($cuerpo)) {
                        $iSubItem = 0;
                        foreach ($cuerpo as $rowSubItem) {
                            if ($iSubItem == 0) {
                                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, strtoupper($rowSubItem->inspeccion_direccion)."\n".$rowSubItem->departamento_nombre." > ".$rowSubItem->provincia_nombre." > ".$rowSubItem->distrito_nombre);
                                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $rowSubItem->inspeccion_fecha);
                                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, strtoupper($rowSubItem->perito_nombre));
                            } else {
                                $objPHPExcel->getActiveSheet()->SetCellValue('G' . ($rowCount + $iSubItem), strtoupper($rowSubItem->inspeccion_direccion)."\n".$rowSubItem->departamento_nombre." > ".$rowSubItem->provincia_nombre." > ".$rowSubItem->distrito_nombre);
                                $objPHPExcel->getActiveSheet()->SetCellValue('H' . ($rowCount + $iSubItem), $rowSubItem->inspeccion_fecha);
                                $objPHPExcel->getActiveSheet()->SetCellValue('I' . ($rowCount + $iSubItem), strtoupper($rowSubItem->perito_nombre));
                            }
                            $iSubItem++;
                        }
                        
                    } else {
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, strtoupper($rowSubItem->inspeccion_direccion)."\n".$rowSubItem->departamento_nombre." > ".$rowSubItem->provincia_nombre." > ".$rowSubItem->distrito_nombre);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $rowSubItem->inspeccion_fecha);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, strtoupper($rowSubItem->perito_nombre));
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, strtoupper($rowItem->digitador_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, strtoupper($rowItem->control_calidad_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, strtoupper($rowItem->coordinador_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $rowItem->coordinacion_fecha_entrega);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $rowItem->coordinacion_fecha_creacion);
                    
                    $style_rows =   array(
                        'borders'   =>  array(
                            'allborders'   =>  array(
                                'style' =>  PHPExcel_Style_Border::BORDER_THIN,
                                'color' =>  array(
                                    'rgb'   =>  '000000'
                                )
                            )
                        ),
                        'alignment' =>  array(
                            'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    );
    
                    $style_rows_adjust_text = array(
                        'alignment' =>  array(
                            'wrap'      => TRUE
                        )
                    );
    
                    $style_rows_horizontal_center = array(
                        'alignment' =>  array(
                            'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                        )
                    );

                    if ($iItem != 1) {
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $rowCount . ':A' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $rowCount . ':B' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $rowCount . ':C' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D' . $rowCount . ':D' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E' . $rowCount . ':E' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $rowCount . ':F' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J' . $rowCount . ':J' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K' . $rowCount . ':K' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L' . $rowCount . ':L' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M' . $rowCount . ':M' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N' . $rowCount . ':N' . ($rowCount + $iItem - 1));

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':N' . ($rowCount + $iItem - 1))->applyFromArray($style_rows);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_adjust_text);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':F' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':H' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':N' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                    } else {
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':N' . $rowCount)->applyFromArray($style_rows);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . $rowCount)->applyFromArray($style_rows_adjust_text);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':F' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':H' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':N' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                    }

                    $rowCount = $rowCount + $iItem;
                }
            }

            $fileName = 'Reporte de Coordinacion - ' . date('dmY-his') . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }

    public function resumenGeneradas()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));
            $filters_count = array('action' => 'count');

            $filters_find =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'coordinacion_estado' => $datos->coordinacion_estado,
                'coordinacion_solicitante' => $datos->coordinacion_solicitante,
                'coordinacion_cliente' => $datos->coordinacion_cliente,
                'coordinacion_servicio_tipo' => $datos->coordinacion_servicio_tipo,
                'coordinacion_direccion' => $datos->coordinacion_direccion,
                'coordinacion_perito' => $datos->coordinacion_perito,
                'coordinacion_digitador' => $datos->coordinacion_digitador,
                'coordinacion_control_calidad' => $datos->coordinacion_control_calidad,
                'coordinacion_coordinador' => $datos->coordinacion_coordinador,
                //'coordinacion_riesgo' => $datos->coordinacion_riesgo,
                'coordinacion_fecha_tipo' => $datos->coordinacion_fecha_tipo,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta,
                
                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $filters_find_resumen =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'coordinacion_estado' => $datos->coordinacion_estado,
                'coordinacion_solicitante' => $datos->coordinacion_solicitante,
                'coordinacion_cliente' => $datos->coordinacion_cliente,
                'coordinacion_servicio_tipo' => $datos->coordinacion_servicio_tipo,
                'coordinacion_direccion' => $datos->coordinacion_direccion,
                'coordinacion_perito' => $datos->coordinacion_perito,
                'coordinacion_digitador' => $datos->coordinacion_digitador,
                'coordinacion_control_calidad' => $datos->coordinacion_control_calidad,
                'coordinacion_coordinador' => $datos->coordinacion_coordinador,
                //'coordinacion_riesgo' => $datos->coordinacion_riesgo,
                'coordinacion_fecha_tipo' => 4,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta,
                
                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $resultCoordinacion = $this->coord->search($filters_find);
            $coordinar = 0; $inspecion = 0; $elaboracion = 0; $espera = 0; $aprobar = 0; $terminado = 0; 
            $desestimado = 0; $reproceso = 0; $total = 0; /*$aTiempo = 0; $retraso = 0;
            $arrayaTiempo = array(); $arrayRetraso = array();*/
            foreach ($resultCoordinacion as $row) {
                switch ($row->estado_id) {
                    case '1':
                        $inspecion++;
                        $total++;
                        break;
                    case '2':
                        $espera++;
                        $total++;
                        break;
                    case '3':
                        $aprobar++;
                        $total++;
                        break;
                    case '4':
                        $terminado++;
                        $total++;
                        /*if ($row->fecha_terminado_auditoria > $row->coordinacion_fecha_entrega_normal) {
                            array_push(
                                $arrayRetraso,
                                array(
                                    'coordinacion_correlativo' => $row->coordinacion_correlativo,
                                    'solicitante_nombre' => $row->solicitante_nombre,
                                    'cliente_nombre' => $row->cliente_nombre,
                                    'fecha_entrega' => date("d-m-Y",strtotime($row->coordinacion_fecha_entrega_normal)),
                                    'fecha_terminado' => date("d-m-Y",strtotime($row->fecha_terminado_auditoria))
                                )
                            );
                            $retraso++;
                        } else {
                            array_push(
                                $arrayaTiempo,
                                array(
                                    'coordinacion_correlativo' => $row->coordinacion_correlativo,
                                    'solicitante_nombre' => $row->solicitante_nombre,
                                    'cliente_nombre' => $row->cliente_nombre,
                                    'fecha_entrega' => date("d-m-Y",strtotime($row->coordinacion_fecha_entrega_normal)),
                                    'fecha_terminado' => date("d-m-Y",strtotime($row->fecha_terminado_auditoria))
                                )
                            );
                            $aTiempo++;
                        }*/
                        break;
                    case '5':
                        $desestimado++;
                        $total++;
                        break;
                    case '6':
                        $coordinar++;
                        $total++;
                        break;
                    case '7':
                        $elaboracion++;
                        $total++;
                        break;
                    case '8':
                        $reproceso++;
                        $total++;
                        break;
                }
            }

            $estados = array(
                'coordinar' => $coordinar,
                'inspeccion' => $inspecion,
                'elaboracion' => $elaboracion,
                'espera' => $espera,
                'aprobar' => $aprobar,
                'terminado' => $terminado,
                /*'a_tiempo' => $aTiempo,
                'retraso' => $retraso,*/
                'desestimado' => $desestimado,
                'reproceso' => $reproceso,
                'total' => $total
            );

            $data['motivos'] = $this->mot->searchMotivo(array());
            $data['countReprocesos'] = $this->aud->searchAuditoriaReprocesos($datos->coordinacion_fecha_tipo == '1' ? array_merge(array('action' => 'count'), $filters_find_resumen) : array_merge(array('action' => 'count'), $filters_find));
            $data['auditoriaReprocesos'] = $this->aud->searchAuditoriaReprocesos($datos->coordinacion_fecha_tipo == '1' ? $filters_find_resumen : $filters_find);
            
            /*$data['listATiempo'] = $arrayaTiempo;
            $data['listRetraso'] = $arrayRetraso;*/
            $data['estados'] = $estados;
            $data['filtros'] = $filters_find;
            $data['view'] = 'reporte/coordinacion/generadas/reporte_generadas_resumen';
            $this->load->view('layout_impresion', $data);
        }
    }

	public function reprocesos()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	//$data['estado'] = $this->est->estadoCoordinacion();
            $data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['ccalidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
        	$data['view'] = 'reporte/coordinacion/reprocesos/reporte_coordinacion_reprocesos';
			$this->load->view('layout', $data);
		}
	}

	public function impresionReprocesos()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters =   array(
                'accion' => 'filtros',
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                //'estado_id' => $datos->estado_id,
                'solicitante_nombre' => $datos->solicitante_nombre,
                'cliente_nombre' => $datos->cliente_nombre,
                'servicio_tipo_id' => implode(",", $datos->servicio_tipo_id),
                'coordinacion_ubicacion' => $datos->coordinacion_ubicacion,
                'digitador_id' => $datos->digitador_id,
                'control_calidad_id' => $datos->control_calidad_id,
                'coordinador_id' => $datos->coordinador_id,
                'coordinacion_fecha_tipo' => $datos->coordinacion_fecha_tipo,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta
            );

            $impresion = $this->coord->searchCoordinacionReprocesos($filters);
            $table_boddy = "";

            if ($impresion == false) {
                $table_boddy .= '<tr><td colspan="12">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($impresion as $row) {
                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinacion_correlativo.'</td>
                                        <!--<td style="font-size: 0.5rem">'.$row->coordinacion_estado_nombre.'</td>-->
                                        <td style="font-size: 0.5rem">'.strtoupper(str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre))).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper(str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre))).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->servicio_tipo_nombre).'</td>
                                        <td style="font-size: 0.5rem"><div>'.$row->inspeccion_direccion.'</div><div>'.$row->departamento_nombre.' <i class="fa fa-play text-danger"></i> '.$row->provincia_nombre.' <i class="fa fa-play text-danger"></i>'.$row->distrito_nombre.'</div></td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->digitador_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->control_calidad_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->coordinador_nombre).'</td>
                                        <td style="font-size: 0.5rem">
                                        	<div class="text-justify">
                                                <strong>'. $row->motivo_nombre .': <br /> </strong>'. $row->motivo_observacion .'
                                            </div>
                                        </td>
                                        <td style="font-size: 0.5rem">'.$row->motivo_fecha.'</td>
                                    </tr>';
                    $i++;
                }
            }

            $data['coordinacion'] = $table_boddy;
            $data['view'] = 'reporte/coordinacion/generadas/reporte_coordinacion_generadas_print';
            $this->load->view('layout_impresion', $data);
        }
    }
    /* END COORDINACION */

    /* BEGIN OPERACIONES */
    public function operaciones()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/reporte_operaciones';
			$this->load->view('layout', $data);
		}
    }
    /* END OPERACIONES */

    /* BEGIN SISTEMAS */
    public function sistemas()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/reporte_sistemas';
			$this->load->view('layout', $data);
		}
    }
    
    public function servicio_cotizado()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/sistemas/servicio/reporte_servicio_mas_cotizado';
			$this->load->view('layout', $data);
		}
    }

    public function mayor_servicio_cotizado_particulares()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/sistemas/cliente/particular/reporte_mayor_servicio_solicitado';
			$this->load->view('layout', $data);
		}
    }

    public function mayor_servicio_cotizado_bancos()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	
        	$data['view'] = 'reporte/sistemas/cliente/banco/reporte_mayor_servicio_solicitado';
			$this->load->view('layout', $data);
		}
    }

    public function ventas_servicio()
    {
        $logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['view'] = 'reporte/sistemas/venta/reporte_venta_servicio';
			$this->load->view('layout', $data);
		}
    }
    /* END SISTEMAS */
}

/* End of file Reporte.php */
/* Location: ./application/controllers/reporte/Reporte.php */