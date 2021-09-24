<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspeccion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		/*MODELOS*/
        $this->load->model('inspeccion/inspeccion_m', 'insp');
        //$this->load->model('calidad/calidad_m', 'ccal');
        $this->load->model('tservicio/TServicio_m', 'tps');
        $this->load->model('perito/perito_m', 'per');
        //$this->load->model('estado/estado_m', 'est');
        $this->load->model('coordinador/coordinador_m', 'coor');

		/*LIBRERIAS*/
        $this->load->library('excel');
	}

	public function index()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['estado'] = $this->est->estadoCoordinacion();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['ccalidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'inspeccion/inspeccion_list';
            $this->load->view('layout', $data);
        }
	}

    public function searchInspeccionCoordinacion()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'inspeccion_id' => $this->input->post('inspeccion_id')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'inspeccion_find' => $this->insp->searchInspeccion($filters)
        );

        echo json_encode($data);
    }

    public function searchInspeccion()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'estado_id' => $this->input->post('estado_id'),
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'coordinacion_ubicacion' => $this->input->post('coordinacion_ubicacion'),
            'perito_id' => $this->input->post('perito_id'),
            'control_calidad_id' => $this->input->post('control_calidad_id'),
            'coordinador_id' => $this->input->post('coordinador_id'),
            'tipo_fecha' => $this->input->post('tipo_fecha'),
            'inspeccion_fecha_desde' => $this->input->post('inspeccion_fecha_desde'),
            'inspeccion_fecha_hasta' => $this->input->post('inspeccion_fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'inspeccion_records' => $this->insp->searchInspeccion($filters),
            'total_records_find' => $this->insp->searchInspeccion($filters) == false ? false : count($this->insp->searchInspeccion($filters_find)),
            'total_records' => $this->insp->searchInspeccion(array('accion' => 'full')) == false ? false : count($this->insp->searchInspeccion(array('accion' => 'full'))),
            'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
            'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }
    
    public function listAppInspeccion($userID,$tipoInspeccion){
        $response = $this ->insp->listAppInspeccion($userID,$tipoInspeccion);
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function listAppInspeccionCoordinacionId($coordinacionID){
        $response = $this ->insp->listAppInspeccionCoordinacion($coordinacionID);
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function insertInspeccion()
    {
    	$field = array (
            'id' => $this->input->post('inspeccion_id'),
            'coordinacion_id' => $this->input->post('coordinacion_id'),
            'perito_id' => $this->input->post('perito_id'),
            'digitador_id' => $this->input->post('digitador_id'),
            'inspector_id' => $this->input->post('control_calidad_id'),
            'contactos' => $this->input->post('inspeccion_contacto'),
            'fecha' => $this->input->post('inspeccion_fecha'),
            'hora_real_mostrar' => $this->input->post('inspeccion_hora_real_mostrar'),
            'hora_real' => $this->input->post('inspeccion_hora_real'),
            'hora_estimada_mostrar' => $this->input->post('inspeccion_hora_estimada_mostrar'),
            'hora_estimada' => $this->input->post('inspeccion_hora_estimada'),
            'departamento_id' => '0',
            'provincia_id' => '0',
            'distrito_id' => '0',
            'ubigeo_distrito_id' => $this->input->post('ubigeo_distrito_id'),
            'latitud' => $this->input->post('inspeccion_latitud'),
            'longitud' => $this->input->post('inspeccion_longitud'),
            'direccion' => $this->input->post('inspeccion_direccion'),
            'observacion' => $this->input->post('inspeccion_observacion'),
            'ruta' => $this->input->post('inspeccion_ruta'),
            'info_create_user' => $this->session->userdata('usu_id'),
            'info_status' => '1'
        );

        $insert = $this->insp->Insert($field);
        
        if ($insert > 0){
            $msg = array('success' => true, 'idInspeccion' => $insert);
        } else {
            $msg = array('success' => false, 'idInspeccion' => '0');
        }
        echo json_encode($msg);
    }

    public function updateInspeccion()
    {
    	$field = array (
            'coordinacion_id' => $this->input->post('coordinacion_id'),
            'perito_id' => $this->input->post('perito_id'),
            'digitador_id' => $this->input->post('digitador_id'),
            'inspector_id' => $this->input->post('control_calidad_id'),
            'contactos' => $this->input->post('inspeccion_contacto'),
            'fecha' => $this->input->post('inspeccion_fecha'),
            'hora_real_mostrar' => $this->input->post('inspeccion_hora_real_mostrar'),
            'hora_real' => $this->input->post('inspeccion_hora_real'),
            'hora_estimada_mostrar' => $this->input->post('inspeccion_hora_estimada_mostrar'),
            'hora_estimada' => $this->input->post('inspeccion_hora_estimada'),
            'ubigeo_distrito_id' => $this->input->post('ubigeo_distrito_id'),
            'latitud' => $this->input->post('inspeccion_latitud'),
            'longitud' => $this->input->post('inspeccion_longitud'),
            'direccion' => $this->input->post('inspeccion_direccion'),
            'observacion' => $this->input->post('inspeccion_observacion'),
            'ruta' => $this->input->post('inspeccion_ruta'),
            'info_status' => '1',
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('inspeccion_fecha_update')
        );

        $update = $this->insp->Update($field, $this->input->post('inspeccion_id'));

        $msg['success'] = false;
        if ($update > 0) {
            $msg['success'] = true;

            /*$field_ins = array(
                'perito_id' => $this->input->post('perito_id'),
                'contactos' => $this->input->post('inspeccion_contacto'),
                'fecha' =>  $this->input->post('inspeccion_fecha'),
                'hora' => $this->input->post('inspeccion_hora_real_mostrar') == '1' ? $this->input->post('inspeccion_hora_real') : $this->input->post('inspeccion_hora_estimada'),
                'hora_tipo' => $this->input->post('inspeccion_hora_real_mostrar') == '1' ? '1' : '2',
                'distrito_id' => $this->input->post('ubigeo_distrito_id'),
                'direccion' => $this->input->post('inspeccion_direccion'),
                'observacion' => $this->input->post('inspeccion_observacion'),
                'estado_id' => '2',
                'info_update' => date('Y-m-d H:i:s'),
                'info_update_user' => $this->session->userdata('usu_id')
            );
            $this->insp->updateDetalle($field_ins, $this->input->post('inspeccion_id'));*/
        }

        echo json_encode($msg);
    }

    public function impresion()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters =   array(
                'accion' => 'filtros',
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'estado_id' => $datos->estado_id,
                'solicitante_nombre' => $datos->solicitante_nombre,
                'cliente_nombre' => $datos->cliente_nombre,
                'coordinacion_ubicacion' => $datos->coordinacion_ubicacion,
                'perito_id' => $datos->perito_id,
                'control_calidad_id' => $datos->control_calidad_id,
                'coordinador_id' => $datos->coordinador_id,
                'tipo_fecha' => $datos->tipo_fecha,
                'inspeccion_fecha_desde' => $datos->inspeccion_fecha_desde,
                'inspeccion_fecha_hasta' => $datos->inspeccion_fecha_hasta
            );

            $impresion = $this->insp->searchInspeccion($filters);
            $table_boddy = "";

            if ($impresion == false) {
                $table_boddy .= '<tr><td colspan="11">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($impresion as $row) {
                    $arrArreglo = explode('-', $row->inspeccion_hora);
                    $arrayHoras  = array('12' => '00', '01' => '13', '02' => '14', '03' => '15', '04' => '16', '05' => '17', '06' => '18', '07' => '19', '08' => '20', '09' => '21', '10' => '22', '11' => '23', '12' => '24',);
                    $hora;

                    if (count($arrArreglo) > 1) {
                        $arrHoraIni = explode(':',$arrArreglo[0]);
                        $arrHoraFin = explode(':',$arrArreglo[1]);
                        $horaIni;
                        $horaFin;

                        if (intval($arrHoraIni[0]) == 0)
                            $horaIni = '12:'.$arrHora[1].' AM';
                        elseif (intval($arrHoraIni[0]) < 12)
                            $horaIni = $arrHoraIni[0].':'.$arrHoraIni[1].' AM';
                        else
                            $horaIni = array_search($arrHoraIni[0], $arrayHoras).':'.$arrHoraIni[1].' PM';

                        if (intval($arrHoraFin[0]) == 0)
                            $horaFin = '12:'.$arrHora[1].' AM';
                        elseif (intval($arrHoraFin[0]) < 12)
                            $horaFin = $arrHoraFin[0].':'.$arrHoraFin[1].' AM';
                        else
                            $horaFin = array_search($arrHoraFin[0], $arrayHoras).':'.$arrHoraFin[1].' PM';

                        $hora = $horaIni . ' a ' . $horaFin;
                    } else {
                        $arrHora = explode(':', $arrArreglo[0]);
                        if (intval($arrHora[0]) == 0)
                            $hora = '12:'.$arrHora[1].' AM';
                        elseif (intval($arrHora[0]) < 12)
                            $hora = $arrHora[0].':'.$arrHora[1].' AM';
                        elseif (intval($arrHora[0]) == 12)
                            $hora = '12:'.$arrHora[1].' PM';
                        else
                            $hora = array_search($arrHora[0], $arrayHoras).':'.$arrHora[1].' PM';
                    }

                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinacion_correlativo.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinacion_estado_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->solicitante_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cliente_nombre.'</td>
                                        <td style="font-size: 0.5rem"><div>'.$row->inspeccion_direccion.'</div><div>'.$row->departamento_nombre.' <i class="fa fa-play text-danger"></i> '.$row->provincia_nombre.' <i class="fa fa-play text-danger"></i>'.$row->distrito_nombre.'</div></td>
                                        <td style="font-size: 0.5rem">'.$row->inspeccion_fecha.'</td>
                                        <td style="font-size: 0.5rem">'.$hora.'</td>
                                        <td style="font-size: 0.5rem">'.$row->perito_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->control_calidad_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinador_nombre.'</td>
                                    </tr>';
                    $i++;
                }
            }

            $data['inspeccion'] = $table_boddy;
            $data['view'] = 'inspeccion/inspeccion_print';
            $this->load->view('layout_impresion', $data);
        }
    }

    public function reportInspeccionExcel()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));
            
            $filters =   array(
                'accion' => 'filtros',
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'estado_id' => $datos->estado_id,
                'solicitante_nombre' => $datos->solicitante_nombre,
                'cliente_nombre' => $datos->cliente_nombre,
                'coordinacion_ubicacion' => $datos->coordinacion_ubicacion,
                'perito_id' => $datos->perito_id,
                'control_calidad_id' => $datos->control_calidad_id,
                'coordinador_id' => $datos->coordinador_id,
                'tipo_fecha' => $datos->tipo_fecha,
                'inspeccion_fecha_desde' => $datos->inspeccion_fecha_desde,
                'inspeccion_fecha_hasta' => $datos->inspeccion_fecha_hasta
            );

            $inspeccion = $this->insp->searchInspeccion($filters);

            $objPHPExcel = new PHPExcel();

            //Ponemos Nombre a la Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Reporte de Inspección');

            //Definimos Propiedades
            $objPHPExcel->getProperties()->setTitle('Reporte de Inspección')
                                        ->setCreator('Allemant & Asociados Peritos Valuadores')
                                        ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

            //Combinación de celdas
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:K2');

            //Añadimos titlo del reporte
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'REPORTE DE INSPECCIÓN');

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
            $objPHPExcel->getActiveSheet()->getStyle('B2:K2')->applyFromArray($style_title);
            
            //Configuramos el tamaño de los encabezados de las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20.7);

            //Añadimos los titulos a los encabezados de columnas
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', '#');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'CÓDIGO COORD.');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'ESTADO');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'CLIENTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'UBICACIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'FECHA INSPECCIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'HORA INSPECCIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'PERITO');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'CONTROL DE CALIDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'COORDINADOR');

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
            $objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($style_columns_headers);

            //Obtener los datos
            $rowCount = 6;
            foreach ($inspeccion as $row) {
                $arrArreglo = explode('-', $row->inspeccion_hora);
                $arrayHoras  = array('12' => '00', '01' => '13', '02' => '14', '03' => '15', '04' => '16', '05' => '17', '06' => '18', '07' => '19', '08' => '20', '09' => '21', '10' => '22', '11' => '23', '12' => '24',);
                $hora;

                if (count($arrArreglo) > 1) {
                    $arrHoraIni = explode(':',$arrArreglo[0]);
                    $arrHoraFin = explode(':',$arrArreglo[1]);
                    $horaIni;
                    $horaFin;

                    if (intval($arrHoraIni[0]) == 0)
                        $horaIni = '12:'.$arrHora[1].' AM';
                    elseif (intval($arrHoraIni[0]) < 12)
                        $horaIni = $arrHoraIni[0].':'.$arrHoraIni[1].' AM';
                    else
                        $horaIni = array_search($arrHoraIni[0], $arrayHoras).':'.$arrHoraIni[1].' PM';

                    if (intval($arrHoraFin[0]) == 0)
                        $horaFin = '12:'.$arrHora[1].' AM';
                    elseif (intval($arrHoraFin[0]) < 12)
                        $horaFin = $arrHoraFin[0].':'.$arrHoraFin[1].' AM';
                    else
                        $horaFin = array_search($arrHoraFin[0], $arrayHoras).':'.$arrHoraFin[1].' PM';

                    $hora = $horaIni . ' a ' . $horaFin;
                } else {
                    $arrHora = explode(':', $arrArreglo[0]);
                    if (intval($arrHora[0]) == 0)
                        $hora = '12:'.$arrHora[1].' AM';
                    elseif (intval($arrHora[0]) < 12)
                        $hora = $arrHora[0].':'.$arrHora[1].' AM';
                    elseif (intval($arrHora[0]) == 12)
                        $hora = '12:'.$arrHora[1].' PM';
                    else
                        $hora = array_search($arrHora[0], $arrayHoras).':'.$arrHora[1].' PM';
                }

                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 5);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "$row->coordinacion_correlativo");
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, strtoupper($row->coordinacion_estado_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper(str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre))));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper(str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre))));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, strtoupper($row->inspeccion_direccion)."\n".$row->departamento_nombre." > ".$row->provincia_nombre." > ".$row->distrito_nombre);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->inspeccion_fecha);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $hora);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, strtoupper($row->perito_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, strtoupper($row->control_calidad_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, strtoupper($row->coordinador_nombre));

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
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':K' . $rowCount)->applyFromArray($style_rows);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':F' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':H' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount.':K' . $rowCount)->applyFromArray($style_rows_adjust_text);

                $rowCount++;
            }

            $fileName = 'Reporte de Inspección -' . date('dmY-his') . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }

    /* INSPECCION DETALLE */
    public function listado()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = $this->uri->segment(1);
            
            $data['tipo_servicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'inspeccion/inspeccion';
            $this->load->view('layout', $data);
        }
    }

    public function search()
    {
        $filters_count = array('action' => 'count');

        $filters_find =   array(
            'coordinacion_codigo' => $this->input->post('coordinacion_codigo'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'inspeccion_solicitante' => $this->input->post('inspeccion_solicitante'),
            'inspeccion_cliente' => $this->input->post('inspeccion_cliente'),
            'inspeccion_servicio_tipo' => $this->input->post('inspeccion_servicio_tipo'),
            'inspeccion_direccion' => $this->input->post('inspeccion_direccion'),
            'inspeccion_perito' => $this->input->post('inspeccion_perito'),
            'inspeccion_coordinador' => $this->input->post('inspeccion_coordinador'),
            //'inspeccion_estado' => $this->input->post('inspeccion_estado'),
            //'inspeccion_fecha_tipo' => $this->input->post('inspeccion_fecha_tipo'),
            'inspeccion_fecha_desde' => $this->input->post('inspeccion_fecha_desde'),
            'inspeccion_fecha_hasta' => $this->input->post('inspeccion_fecha_hasta'),

            'order' => $this->input->post('order'),
            'order_type' => $this->input->post('order_type')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'records_all_count' => $this->insp->search($filters_count),
            'records_find_count' => $this->insp->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->insp->search($filters)
        );

        echo json_encode($data);
    }

    public function imprimir()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters_find =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'inspeccion_solicitante' => $datos->inspeccion_solicitante,
                'inspeccion_cliente' => $datos->inspeccion_cliente,
                'inspeccion_servicio_tipo' => $datos->inspeccion_servicio_tipo,
                'inspeccion_direccion' => $datos->inspeccion_direccion,
                'inspeccion_perito' => $datos->inspeccion_perito,
                'inspeccion_coordinador' => $datos->inspeccion_coordinador,
                //'inspeccion_estado' => $datos->inspeccion_estado,
                //'inspeccion_fecha_tipo' => $datos->inspeccion_fecha_tipo,
                'inspeccion_fecha_desde' => $datos->inspeccion_fecha_desde,
                'inspeccion_fecha_hasta' => $datos->inspeccion_fecha_hasta,
    
                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $resultInspeccion = $this->insp->search($filters_find);
            $table_boddy = "";

            if ($resultInspeccion == false) {
                $table_boddy .= '<tr><td colspan="10">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($resultInspeccion as $row) {
                    $arrArreglo = explode('-', $row->inspeccion_hora);
                    $arrayHoras  = array('12' => '00', '01' => '13', '02' => '14', '03' => '15', '04' => '16', '05' => '17', '06' => '18', '07' => '19', '08' => '20', '09' => '21', '10' => '22', '11' => '23', '12' => '24',);
                    $hora;

                    if (count($arrArreglo) > 1) {
                        $arrHoraIni = explode(':',$arrArreglo[0]);
                        $arrHoraFin = explode(':',$arrArreglo[1]);
                        $horaIni;
                        $horaFin;

                        if (intval($arrHoraIni[0]) == 0)
                            $horaIni = '12:'.$arrHora[1].' AM';
                        elseif (intval($arrHoraIni[0]) < 12)
                            $horaIni = $arrHoraIni[0].':'.$arrHoraIni[1].' AM';
                        else
                            $horaIni = array_search($arrHoraIni[0], $arrayHoras).':'.$arrHoraIni[1].' PM';

                        if (intval($arrHoraFin[0]) == 0)
                            $horaFin = '12:'.$arrHora[1].' AM';
                        elseif (intval($arrHoraFin[0]) < 12)
                            $horaFin = $arrHoraFin[0].':'.$arrHoraFin[1].' AM';
                        else
                            $horaFin = array_search($arrHoraFin[0], $arrayHoras).':'.$arrHoraFin[1].' PM';

                        $hora = $horaIni . ' a ' . $horaFin;
                    } else {
                        $arrHora = explode(':', $arrArreglo[0]);
                        if (intval($arrHora[0]) == 0)
                            $hora = '12:'.$arrHora[1].' AM';
                        elseif (intval($arrHora[0]) < 12)
                            $hora = $arrHora[0].':'.$arrHora[1].' AM';
                        elseif (intval($arrHora[0]) == 12)
                            $hora = '12:'.$arrHora[1].' PM';
                        else
                            $hora = array_search($arrHora[0], $arrayHoras).':'.$arrHora[1].' PM';
                    }

                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinacion_correlativo.'</td>
                                        <td style="font-size: 0.5rem">'.$row->solicitante_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cliente_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->servicio_tipo_nombre.'</td>
                                        <td style="font-size: 0.5rem"><div>'.$row->inspeccion_direccion.'</div><div>'.$row->departamento_nombre.' <i class="fa fa-play text-danger"></i> '.$row->provincia_nombre.' <i class="fa fa-play text-danger"></i>'.$row->distrito_nombre.'</div></td>
                                        <td style="font-size: 0.5rem">'.$row->perito_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinador_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.$row->inspeccion_fecha.'</td>
                                        <td style="font-size: 0.5rem">'.$hora.'</td>
                                        <!--<td style="font-size: 0.5rem">'.$row->estado_nombre.'</td>-->
                                    </tr>';
                    $i++;
                }
            }

            $data['inspeccion'] = $table_boddy;
            $data['view'] = 'inspeccion/inspeccion_print';
            $this->load->view('layout_impresion', $data);
        }
    }

    public function exportarExcel()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters_find =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'inspeccion_solicitante' => $datos->inspeccion_solicitante,
                'inspeccion_cliente' => $datos->inspeccion_cliente,
                'inspeccion_servicio_tipo' => $datos->inspeccion_servicio_tipo,
                'inspeccion_direccion' => $datos->inspeccion_direccion,
                'inspeccion_perito' => $datos->inspeccion_perito,
                'inspeccion_coordinador' => $datos->inspeccion_coordinador,
                //'inspeccion_estado' => $datos->inspeccion_estado,
                //'inspeccion_fecha_tipo' => $datos->inspeccion_fecha_tipo,
                'inspeccion_fecha_desde' => $datos->inspeccion_fecha_desde,
                'inspeccion_fecha_hasta' => $datos->inspeccion_fecha_hasta,
    
                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $resultInspeccion = $this->insp->search($filters_find);

            $objPHPExcel = new PHPExcel();

            //Ponemos Nombre a la Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Reporte de Inspección');

            //Definimos Propiedades
            $objPHPExcel->getProperties()->setTitle('Reporte de Inspección')
                                        ->setCreator('Allemant & Asociados Peritos Valuadores')
                                        ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

            //Combinación de celdas
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:I2');

            //Añadimos titlo del reporte
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'REPORTE DE INSPECCIÓN');

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
            $objPHPExcel->getActiveSheet()->getStyle('B2:I2')->applyFromArray($style_title);
            
            //Configuramos el tamaño de los encabezados de las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12.7);
            /*$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13.7);*/

            //Añadimos los titulos a los encabezados de columnas
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', '#');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'COORD.');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'CLIENTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'TIPO SERVICIO');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'DIRECCIÓN');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'PERITO');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'COORDINADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'FECHA');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'HORA');
            /*$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'ESTADO');*/

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

            $objPHPExcel->getActiveSheet()->getStyle('A5:J5')->applyFromArray($style_columns_headers);

            //Obtener los datos
            $rowCount = 6;
            foreach ($resultInspeccion as $row) {
                $arrArreglo = explode('-', $row->inspeccion_hora);
                $arrayHoras  = array('12' => '00', '01' => '13', '02' => '14', '03' => '15', '04' => '16', '05' => '17', '06' => '18', '07' => '19', '08' => '20', '09' => '21', '10' => '22', '11' => '23', '12' => '12');
                $hora;

                if (count($arrArreglo) > 1) {
                    $arrHoraIni = explode(':',$arrArreglo[0]);
                    $arrHoraFin = explode(':',$arrArreglo[1]);
                    $horaIni;
                    $horaFin;

                    if (intval($arrHoraIni[0]) == 0)
                        $horaIni = '12:'.$arrHora[1].' AM';
                    elseif (intval($arrHoraIni[0]) < 12)
                        $horaIni = $arrHoraIni[0].':'.$arrHoraIni[1].' AM';
                    else
                        $horaIni = array_search($arrHoraIni[0], $arrayHoras).':'.$arrHoraIni[1].' PM';

                    if (intval($arrHoraFin[0]) == 0)
                        $horaFin = '12:'.$arrHora[1].' AM';
                    elseif (intval($arrHoraFin[0]) < 12)
                        $horaFin = $arrHoraFin[0].':'.$arrHoraFin[1].' AM';
                    else
                        $horaFin = array_search($arrHoraFin[0], $arrayHoras).':'.$arrHoraFin[1].' PM';

                    $hora = $horaIni . "\na\n" . $horaFin;
                } else {
                    $arrHora = explode(':', $arrArreglo[0]);
                    if (intval($arrHora[0]) == 0)
                        $hora = '12:'.$arrHora[1].' AM';
                    elseif (intval($arrHora[0]) < 12)
                        $hora = $arrHora[0].':'.$arrHora[1].' AM';
                    elseif (intval($arrHora[0]) == 12)
                        $hora = '12:'.$arrHora[1].' PM';
                    else
                        $hora = array_search($arrHora[0], $arrayHoras).':'.$arrHora[1].' PM';
                }

                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 5);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->coordinacion_correlativo);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, strtoupper($row->solicitante_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper($row->cliente_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper($row->servicio_tipo_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, trim(strtoupper($row->inspeccion_direccion))."\n".$row->departamento_nombre." > ".$row->provincia_nombre." > ".$row->distrito_nombre);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, strtoupper($row->perito_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, strtoupper($row->coordinador_nombre));
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->inspeccion_fecha);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $hora);
                /*$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->estado_nombre);*/

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
                
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':J' . $rowCount)->applyFromArray($style_rows);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':F' . $rowCount)->applyFromArray($style_rows_adjust_text);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':J' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount)->applyFromArray($style_rows_adjust_text);
                //$objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount.':K' . $rowCount)->applyFromArray($style_rows_adjust_text);

                $rowCount++;
            }

            $fileName = 'Reporte de Inspección -' . date('dmY-his') . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }

    public function insert()
    {
        $field = array(
            'perito_id' => $this->input->post('inspeccion_perito'),
            'contactos' => $this->input->post('inspeccion_contacto'),
            'fecha' => $this->input->post('inspeccion_fecha'),
            'hora' => $this->input->post('inspeccion_hora'),
            'hora_tipo' => $this->input->post('inspeccion_hora_tipo'),
            'distrito_id' => $this->input->post('inspeccion_distrito'),
            'direccion' => $this->input->post('inspeccion_direccion'),
            'observacion' => $this->input->post('inspeccion_observacion'),
            'estado_id' => '1',
            'info_create_user' => $this->session->userdata('usu_id'),
            'info_status' => '1'
        );

        $insert = $this->insp->insertDetalle($field, $this->input->post('coordinacion_codigo'));
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    public function update()
    {
        $field = array(
            'perito_id' => $this->input->post('inspeccion_perito'),
            'contactos' => $this->input->post('inspeccion_contacto'),
            'fecha' => $this->input->post('inspeccion_fecha'),
            'hora' => $this->input->post('inspeccion_hora'),
            'hora_tipo' => $this->input->post('inspeccion_hora_tipo'),
            'distrito_id' => $this->input->post('inspeccion_distrito'),
            'direccion' => $this->input->post('inspeccion_direccion'),
            'observacion' => $this->input->post('inspeccion_observacion'),
            /*'estado_id' => '2',*/
            'info_update' => date('Y-m-d H:i:s'),
            'info_update_user' => $this->session->userdata('usu_id')
        );

        $update = $this->insp->updateDetalle($field, $this->input->post('inspeccion_codigo'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
}

/* End of file Inspeccion.php */
/* Location: ./application/controllers/inspeccion/Inspeccion.php */