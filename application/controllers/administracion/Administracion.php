<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        /*MODELOS*/
        $this->load->model('facturacion/facturacion_m', 'fac');
        $this->load->model('cotizacion/cotizacion_m', 'cot');
        $this->load->model('tservicio/TServicio_m', 'tps');
		$this->load->model('vendedor/vendedor_m', 'ven');
        $this->load->model('estado/estado_m', 'est');
        $this->load->model('perito/perito_m', 'per');
        $this->load->model('comprobante/comprobante_m', 'cmp');
        $this->load->model('moneda/moneda_m', 'mnd');
        $this->load->model('mpago/MPago_m', 'mpg');
        $this->load->model('auditoria/auditoria_m', 'aud');

        /*LIBRERIAS*/
        $this->load->library('excel');
        $this->load->library('conversor');
    }

	public function facturaciones()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
        	$data['conteo'] = $this->fac->countFacturacionEstados();
        	$data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
        	$data['vendedor'] = $this->ven->vendedorReporte();
        	$data['estado'] = $this->est->estadoFacturacion();
        	$data['view'] = 'administracion/administracion_list';
			$this->load->view('layout', $data);
		}
	}

	public function facturaciones_mantenimiento()
	{
		$logued = $this->session->userdata('login');

		if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['estado'] = $this->est->estadoFacturacion();
        	$data['view'] = 'administracion/administracion_mant';
			$this->load->view('layout_form', $data);
		}
	}

    public function emision()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['comprobante'] = $this->cmp->comprobanteReporte();
            $data['moneda'] = $this->mnd->monedaReporte();
            $data['mpago'] = $this->mpg->medioPagoReporte();
            $data['view'] = 'administracion/administracion_emision';
            $this->load->view('layout_form', $data);
        }
    }

    public function pago_perito()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['estado'] = $this->est->estadoFacturacion();
            $data['view'] = 'administracion/administracion_pago_perito';
            $this->load->view('layout_form', $data);
        }
    }

    public function pago_vendedor()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['vendedor'] = $this->ven->vendedorReporte();
            $data['view'] = 'administracion/administracion_pago_vendedor';
            $this->load->view('layout_form', $data);
        }
    }

    public function convertirNumeroLetras()
    {
        $conversor = new Conversor();

        $data = array(
            'numero' => $conversor->convertirFactura($this->input->post('numero'), $this->input->post('moneda'))
        );

        echo json_encode($data);
    }

	public function searchFacturacionAdministracion()
	{
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cotizacion_codigo' => $this->input->post('cotizacion_codigo'),
            'factura_correlativo' => $this->input->post('factura_correlativo'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
            'perito_id' => $this->input->post('perito_id'),
            'vendedor_id' => $this->input->post('vendedor_id'),
            'ad_importe_moneda' => $this->input->post('ad_importe_moneda'),
            'estado_id' => $this->input->post('estado_id'),

            'estado_pago_perito' => $this->input->post('estado_pago_perito'),
            'fecha_tipo' => $this->input->post('fecha_tipo'),
            'fecha_desde' => $this->input->post('fecha_desde'),
            'fecha_hasta' => $this->input->post('fecha_hasta')
        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
    	);

    	$filters = array_merge($filters_find, $filters_pagination);

        $data = array(
        	'facturacion_records' => $this->fac->searchFacturacion($filters),
        	'total_records_find' => $this->fac->searchFacturacion($filters) == false ? false : count($this->fac->searchFacturacion($filters_find)),
        	'total_records' => $this->fac->searchFacturacion(array('accion' => 'full')) == false ? false : count($this->fac->searchFacturacion(array('accion' => 'full'))),
        	'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
	}

    public function impresionFacturacion()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $objeto = json_decode($this->input->post('data'));

            $filters =   array(
                'accion' => $objeto->accion,
                'cotizacion_codigo' => $objeto->cotizacion_codigo,
                'factura_correlativo' => $objeto->factura_correlativo,
                'cliente_nombre' => $objeto->cliente_nombre,
                'servicio_tipo_id' => $objeto->servicio_tipo_id,
                'estado_id' => $objeto->estado_id,
                'fecha_tipo' => $objeto->fecha_tipo,
                'fecha_desde' => $objeto->fecha_desde,
                'fecha_hasta' => $objeto->fecha_hasta
            );

            $impresion = $this->fac->searchFacturacion($filters);
            $table_boddy = "";

            if ($impresion == false) {
                $table_boddy .= '<tr><td colspan="12">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($impresion as $row) {
                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_codigo.'</td>
                                        <td style="font-size: 0.5rem">'.$row->tipo_comprobante_nombre_correlativo.'</td>
                                        <td style="font-size: 0.5rem">
                                            <div align="left">'.strtoupper($row->cliente_facturado_nombre).'<br><span style="font-weight: bold;">';
                                            if ($row->cliente_facturado_tipo == 'Natural') {
                                                $table_boddy .= 'DNI: ';
                                            } else {
                                                $table_boddy .= 'RUC: ';
                                            }
                    $table_boddy .=             $row->cliente_facturado_nro_documento.'</span>
                                                <br>
                                                <span style="font-weight: bold;">Dirección: '.strtoupper($row->cliente_facturado_direccion).'</span>
                                            </div>
                                        </td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->servicio_tipo_nombre).'</td>
                                        <td style="font-size: 0.5rem"><div align="left">'.strtoupper($row->ad_concepto).'</div></td>
                                        <td style="font-size: 0.5rem"><div align="right">'.$row->moneda_simbolo.' '.number_format($row->ad_subtotal,2).'</div></td>
                                        <td style="font-size: 0.5rem"><div align="right">'.$row->moneda_simbolo.' '.number_format($row->ad_igv,2).'</div></td>
                                        <td style="font-size: 0.5rem"><div align="right">'.$row->moneda_simbolo.' '.number_format($row->ad_total,2).'</div></td>
                                        <td style="font-size: 0.5rem">'.$row->ad_fecha_emision_entrega.'</td>
                                        <td style="font-size: 0.5rem">'.$row->ad_fecha_pago.'</td>
                                        <td style="font-size: 0.5rem">'.$row->estado_nombre.'</td>
                                    </tr>';
                    $i++;
                }
            }

            $data['facturaciones'] = $table_boddy;
            $data['view'] = 'administracion/administracion_print';
            $this->load->view('layout_impresion', $data);
        }
    }

    public function reportFacturacionExcel()
    {
        $objeto = json_decode($this->input->post('data'));
        

        $filters =   array(
            'accion' => $objeto->accion,
            'cotizacion_codigo' => $objeto->cotizacion_codigo,
            'factura_correlativo' => $objeto->factura_correlativo,
            'cliente_nombre' => $objeto->cliente_nombre,
            'servicio_tipo_id' => $objeto->servicio_tipo_id,
            'estado_id' => $objeto->estado_id,
            'fecha_tipo' => $objeto->fecha_tipo,
            'fecha_desde' => $objeto->fecha_desde,
            'fecha_hasta' => $objeto->fecha_hasta
        );


        $facturacion = $this->fac->searchFacturacion($filters);

        $objPHPExcel = new PHPExcel();

        //Ponemos Nombre a la Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte de Facturas');

        //Definimos Propiedades
        $objPHPExcel->getProperties()->setTitle('Reporte de Facturas')
                                    ->setCreator('Allemant & Asociados Peritos Valuadores')
                                    ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

        //Combinación de celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:R2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:A7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F6:F7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G6:G7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I6:I7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J6:J7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K6:K7');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L6:M6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N6:O6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P6:Q6');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R6:R7');

        //Añadimos titlo del reporte
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'REPORTE DE FACTURAS');

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
        $objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($style_title);
        
        //Configuramos el tamaño de los encabezados de las columnas
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12.7);

        //Añadimos los titulos a los encabezados de columnas
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A6', '#');
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'COD. COTIZACIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'COMPROBANTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'FECHA EMISIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'FECHA PAGO');
        $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'SOLICITANTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'CLIENTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'NRO DOCUMENTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'TIPO DE SERVICIO');
        $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'CÓDIGO TASACIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'CONCEPTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'SUB TOTAL');
        $objPHPExcel->getActiveSheet()->SetCellValue('L7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('M7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('N6', 'IGV');
        $objPHPExcel->getActiveSheet()->SetCellValue('N7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('O7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('P6', 'IMPORTE TOTAL');
        $objPHPExcel->getActiveSheet()->SetCellValue('P7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('R6', 'ESTADO');

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
                'allborders' => array(
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
        $objPHPExcel->getActiveSheet()->getStyle('A6:R7')->applyFromArray($style_columns_headers);

        //Obtener los datos
        $rowCount = 8;
        foreach ($facturacion as $row) {
            $importe_subtotal_soles = $row->moneda_id == 1 ? $row->ad_subtotal : '';
            $importe_subtotal_dolares = $row->moneda_id == 2 ? $row->ad_subtotal : '';

            $importe_igv_soles = $row->moneda_id == 1 ? $row->ad_igv : '';
            $importe_igv_dolares = $row->moneda_id == 2 ? $row->ad_igv : '';

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 7);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->cotizacion_codigo);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->tipo_comprobante_nombre_correlativo);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->ad_fecha_emision_entrega);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->ad_fecha_pago);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->solicitante_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->cliente_facturado_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->cliente_facturado_nro_documento);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->servicio_tipo_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->ad_codigo_tasacion);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->ad_concepto);

            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->moneda_id == 1 ? $row->ad_subtotal : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->moneda_id == 2 ? $row->ad_subtotal : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->moneda_id == 1 ? $row->ad_igv : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->moneda_id == 2 ? $row->ad_igv : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $importe_subtotal_soles == '' && $importe_igv_soles == '' ? '' : '=L' .$rowCount. '+N' .$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $importe_subtotal_dolares == '' && $importe_igv_dolares == '' ? '' : '=M' .$rowCount. '+O' .$rowCount);

            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->estado_nombre);

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
                    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                )
            );
            $style_rows_horizontal_center = array(
                'alignment' =>  array(
                    'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':R' . $rowCount)->applyFromArray($style_rows);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':E' . $rowCount)->applyFromArray($style_rows_horizontal_center);
            $objPHPExcel->getActiveSheet()->getStyle('R' . $rowCount)->applyFromArray($style_rows_horizontal_center);

            $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount . ':Q' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');

            /*$objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_SOLES_SIMPLE);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $objPHPExcel->getActiveSheet()->getStyle('N' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_SOLES_SIMPLE);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $objPHPExcel->getActiveSheet()->getStyle('P' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_SOLES_SIMPLE);
            $objPHPExcel->getActiveSheet()->getStyle('Q' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);*/

            $rowCount++;
        }

        /*$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, '=SUMA(L8:L' . ($rowCount - 1) . ')');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, '=SUMA(M8:M' . ($rowCount - 1) . ')');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, '=SUMA(N8:N' . ($rowCount - 1) . ')');
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, '=SUMA(O8:O' . ($rowCount - 1) . ')');
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, '=SUMA(P8:P' . ($rowCount - 1) . ')');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, '=SUMA(Q8:Q' . ($rowCount - 1) . ')');*/

        $fileName = 'Reporte de Facturación-' . date('dmY-his') . '.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function impresionPagoPeritos()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $objeto = json_decode($this->input->post('data'));

            $filters_header =   array(
                'accion' => $objeto->accion,
                'cotizacion_codigo' => $objeto->cotizacion_codigo,
                'cliente_nombre' => $objeto->cliente_nombre,
                'servicio_tipo_id' => $objeto->servicio_tipo_id,
                'perito_id' => $objeto->perito_id,
                'estado_id' => $objeto->estado_id,
                'estado_pago_perito' => $objeto->estado_pago_perito,
                'fecha_tipo' => $objeto->fecha_tipo,
                'fecha_desde' => $objeto->fecha_desde,
                'fecha_hasta' => $objeto->fecha_hasta,
                'group' => 'true'
            );

            $filters_boddy =   array(
                'accion' => $objeto->accion,
                'cotizacion_codigo' => $objeto->cotizacion_codigo,
                'cliente_nombre' => $objeto->cliente_nombre,
                'servicio_tipo_id' => $objeto->servicio_tipo_id,
                'perito_id' => $objeto->perito_id,
                'estado_id' => $objeto->estado_id,
                'estado_pago_perito' => $objeto->estado_pago_perito,
                'fecha_tipo' => $objeto->fecha_tipo,
                'fecha_desde' => $objeto->fecha_desde,
                'fecha_hasta' => $objeto->fecha_hasta
            );

            $arrayHeader =  $this->fac->searchPagoPerito($filters_header);
            $arrayBoddy =  $this->fac->searchPagoPerito($filters_boddy);
            $table_boddy = "";

            if ($arrayHeader == false) {
                $table_boddy .= '<tr><td colspan="12">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($arrayHeader as $row) {
                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->cotizacion_codigo.'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper(str_replace('* ','',$row->cliente_nombre)).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->servicio_tipo_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.$row->moneda_simbolo.' '.number_format($row->cotizacion_importe_proyecto,2).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->perito_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.$row->moneda_simbolo.' '.number_format($row->perito_costo,2).'</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo) {
                                                    $table_boddy .= '<div>'.$rowBody->tipo_comprobante_nombre_correlativo.'</div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo) {
                                                    $table_boddy .= '<div>'.$rowBody->estado_nombre.'</div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo && $rowBody->estado_id == 3) {
                                                    $table_boddy .= '<div>'.$rowBody->ad_fecha_emision_entrega.'</div>';
                                                } else {
                                                    $table_boddy .= '<div></div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo && $rowBody->estado_id == 3) {
                                                    $table_boddy .= '<div>'.$rowBody->moneda_simbolo.' '.$rowBody->ad_total_facturado.'</div>';
                                                } else {
                                                    $table_boddy .= '<div></div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo && $rowBody->estado_id == 3) {
                                                    $table_boddy .= '<div>'.$rowBody->moneda_simbolo.' '.$rowBody->perito_costo_comprobante.'</div>';
                                                } else {
                                                    $table_boddy .= '<div></div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo && $rowBody->estado_id == 3) {
                                                    $table_boddy .= '<div>'.$rowBody->estado_pago_perito.'</div>';
                                                } else {
                                                    $table_boddy .= '<div></div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                        <td style="font-size: 0.5rem">';
                                            foreach ($arrayBoddy as $rowBody) {
                                                if ($rowBody->cotizacion_codigo == $row->cotizacion_codigo && $rowBody->estado_id == 3) {
                                                    $table_boddy .= '<div>'.$rowBody->fecha_pago_perito.'</div>';
                                                } else {
                                                    $table_boddy .= '<div></div>';
                                                }
                                            }
                    $table_boddy .=     '</td>
                                    </tr>';
                    $i++;
                }
            }

            $data['pago_perito'] = $table_boddy;
            $data['view'] = 'administracion/administracion_pago_perito_print';
            $this->load->view('layout_impresion', $data);
        }
    }

    public function reportPagoPeritosExcel()
    {
        $objeto = json_decode($this->input->get('data'));
        
        $filters =   array(
            'accion' => $objeto->accion,
            'cotizacion_codigo' => $objeto->cotizacion_codigo,
            'cliente_nombre' => $objeto->cliente_nombre,
            'servicio_tipo_id' => $objeto->servicio_tipo_id,
            'perito_id' => $objeto->perito_id,
            'estado_id' => $objeto->estado_id,
            'estado_pago_perito' => $objeto->estado_pago_perito,
            'fecha_tipo' => $objeto->fecha_tipo,
            'fecha_desde' => $objeto->fecha_desde,
            'fecha_hasta' => $objeto->fecha_hasta
        );

        $facturacion = $this->fac->searchPagoPerito($filters);

        $objPHPExcel = new PHPExcel();

        //Ponemos Nombre a la Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte de Pago Peritos');

        //Definimos Propiedades
        $objPHPExcel->getProperties()->setTitle('Reporte de Pago Peritos')
                                    ->setCreator('Allemant & Asociados Peritos Valuadores')
                                    ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

        //Combinación de celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:O2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:A7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:B7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:C7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:D7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:E7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F6:G6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H6:H7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I6:J6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K6:K7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L6:M6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N6:N7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O6:O7');

        //Añadimos titlo del reporte
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'REPORTE DE PAGO PERITOS');

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
        $objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($style_title);
        
        //Configuramos el tamaño de los encabezados de las columnas
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12.7);

        //Añadimos los titulos a los encabezados de columnas
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A6', '#');
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'COD. COTIZACIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'SOLICITANTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'CLIENTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'TIPO DE SERVICIO');
        $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'COSTO DEL PROYECTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('F7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('G7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'PERITO');
        $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'COSTO PERITO');
        $objPHPExcel->getActiveSheet()->SetCellValue('I7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('J7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'COMPROBANTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'ABONO PERITO');
        $objPHPExcel->getActiveSheet()->SetCellValue('L7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('M7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('N6', 'FECHA PAGO');
        $objPHPExcel->getActiveSheet()->SetCellValue('O6', 'ESTADO');

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
                'allborders' => array(
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
        $objPHPExcel->getActiveSheet()->getStyle('A6:O7')->applyFromArray($style_columns_headers);

        //Obtener los datos
        $rowCount = 8;
        foreach ($facturacion as $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 7);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->cotizacion_codigo);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, str_replace('* ','',$row->solicitante_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, str_replace('* ','',$row->cliente_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->servicio_tipo_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->moneda_id == 1 ? $row->cotizacion_importe_proyecto : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->moneda_id == 2 ? $row->cotizacion_importe_proyecto : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->perito_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->moneda_id == 1 ? $row->perito_costo : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->moneda_id == 2 ? $row->perito_costo : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->tipo_comprobante_nombre_correlativo);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->moneda_id == 1 ? $row->perito_costo_comprobante : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->moneda_id == 2 ? $row->perito_costo_comprobante : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->fecha_pago_perito);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->estado_pago_perito);

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
                    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                )
            );
            $style_rows_horizontal_center = array(
                'alignment' =>  array(
                    'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':O' . $rowCount)->applyFromArray($style_rows);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount)->applyFromArray($style_rows_horizontal_center);
            $objPHPExcel->getActiveSheet()->getStyle('N' . $rowCount . ':O' . $rowCount)->applyFromArray($style_rows_horizontal_center);

            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount . ':G' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount . ':J' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount . ':M' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');

            $rowCount++;
        }

        $fileName = 'Reporte de pago a peritos -' . date('dmY-his') . '.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function reportPagoVendedorExcel()
    {
        $objeto = json_decode($this->input->get('data'));
        
        $filters =   array(
            'accion' => $objeto->accion,
            'cotizacion_codigo' => $objeto->cotizacion_codigo,
            'cliente_nombre' => $objeto->cliente_nombre,
            'servicio_tipo_id' => $objeto->servicio_tipo_id,
            'estado_rentabilidad_id' => $objeto->estado_rentabilidad_id,
            'vendedor_id' => $objeto->vendedor_id,
            'vendedor_pago_estado' => $objeto->vendedor_pago_estado,
            'fecha_desde' => $objeto->fecha_desde,
            'fecha_hasta' => $objeto->fecha_hasta
        );

        $facturacion = $this->fac->searchRentabilidad($filters);

        $objPHPExcel = new PHPExcel();

        //Ponemos Nombre a la Hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte de Pago Vendedor');

        //Definimos Propiedades
        $objPHPExcel->getProperties()->setTitle('Reporte de Pago Vendedor')
                                    ->setCreator('Allemant & Asociados Peritos Valuadores')
                                    ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');

        //Combinación de celdas
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:O2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:A8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:B8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:C8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D6:D8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:E8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F6:H6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F7:F8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G7:G8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H7:H8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I6:K6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I7:I8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J7:J8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K7:K8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L6:M6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L7:L8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M7:M8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N6:O6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N7:N8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O7:O8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P6:T6');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P7:P8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q7:R7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S7:S8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T7:T8');

        //Añadimos titlo del reporte
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'REPORTE DE PAGO VENDEDOR');

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
        $objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($style_title);
        
        //Configuramos el tamaño de los encabezados de las columnas
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12.7);

        //Añadimos los titulos a los encabezados de columnas
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A6', '#');
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'COD. COTIZACIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'SOLICITANTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'CLIENTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'TIPO DE SERVICIO');
        $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'COSTO DEL PROYECTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('F7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('G7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('H7', 'ESTADO');
        $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'COSTO PERITO');
        $objPHPExcel->getActiveSheet()->SetCellValue('I7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('J7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('K7', 'ESTADO PAGO PERITO');
        $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'GASTOS OPERATIVOS');
        $objPHPExcel->getActiveSheet()->SetCellValue('L7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('M7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('N6', 'RENTABILIDAD');
        $objPHPExcel->getActiveSheet()->SetCellValue('N7', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('O7', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('P6', 'VENDEDOR');
        $objPHPExcel->getActiveSheet()->SetCellValue('P7', 'NOMBRES Y APELLIDOS');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q7', 'COMISIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q8', 'SOLES');
        $objPHPExcel->getActiveSheet()->SetCellValue('R8', 'DOLARES');
        $objPHPExcel->getActiveSheet()->SetCellValue('S7', 'FECHA DE PAGO');
        $objPHPExcel->getActiveSheet()->SetCellValue('T7', 'ESTADO DE PAGO');

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
                'allborders' => array(
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
        $objPHPExcel->getActiveSheet()->getStyle('A6:T8')->applyFromArray($style_columns_headers);

        //Obtener los datos
        $rowCount = 9;
        foreach ($facturacion as $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 8);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->cotizacion_codigo);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, str_replace('* ','',$row->solicitante_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, str_replace('* ','',$row->cliente_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->servicio_tipo_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->moneda_id == 1 ? $row->cotizacion_importe_proyecto : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->moneda_id == 2 ? $row->cotizacion_importe_proyecto : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, ($row->cotizacion_importe_proyecto - $row->cotizacion_importe_proyecto_abonado) == 0 ? 'Cancelado' : 'Pendiente');
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->moneda_id == 1 ? $row->perito_costo : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->moneda_id == 2 ? $row->perito_costo : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, ($row->perito_costo - $row->perito_monto_abonado) == 0 ? 'Cancelado' : 'Pendiente');
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->moneda_id == 1 ? $row->gasto_operativo : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->moneda_id == 2 ? $row->gasto_operativo : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->moneda_id == 1 ? '=F' . $rowCount .'-I' . $rowCount . '-L' . $rowCount : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->moneda_id == 2 ? '=G' . $rowCount .'-J' . $rowCount . '-M' . $rowCount : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->vendedor_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->moneda_id == 1 ? '=N' . $rowCount .'*'. ($row->vendedor_porcentaje_comision/100) : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->moneda_id == 2 ? '=N' . $rowCount .'*'. ($row->vendedor_porcentaje_comision/100) : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->vendedor_fecha_pago);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->vendedor_pago_estado);

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
                    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'      => TRUE
                )
            );
            $style_rows_horizontal_center = array(
                'alignment' =>  array(
                    'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':T' . $rowCount)->applyFromArray($style_rows);
            //$objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount)->applyFromArray($style_rows_horizontal_center);
            //$objPHPExcel->getActiveSheet()->getStyle('N' . $rowCount . ':O' . $rowCount)->applyFromArray($style_rows_horizontal_center);

            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount . ':G' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount . ':J' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount . ':O' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('Q' . $rowCount . ':R' . $rowCount)->getNumberFormat()->setFormatCode('#,##0.00');

            $rowCount++;
        }

        $fileName = 'Reporte de pago a vendedor -' . date('dmY-his') . '.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function searchPagoPeritos()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cotizacion_id' => $this->input->post('cotizacion_id'),
            'cotizacion_codigo' => $this->input->post('cotizacion_codigo'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
            'perito_id' => $this->input->post('perito_id'),
            'estado_id' => $this->input->post('estado_id'),
            'estado_pago_perito' => $this->input->post('estado_pago_perito'),
            'fecha_tipo' => $this->input->post('fecha_tipo'),
            'fecha_desde' => $this->input->post('fecha_desde'),
            'fecha_hasta' => $this->input->post('fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'pagos_peritos_records' => $this->fac->searchPagoPerito($filters),
            'total_records_find' => $this->fac->searchPagoPerito($filters) == false ? false : count($this->fac->searchPagoPerito($filters_find)),
            'total_records' => $this->fac->searchPagoPerito(array('accion' => 'group_by')) == false ? false : count($this->fac->searchPagoPerito(array('accion' => 'group_by'))),
            'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
            'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }

    public function searchRentabilidades()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cotizacion_codigo' => $this->input->post('cotizacion_codigo'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
            'estado_rentabilidad_id' => $this->input->post('estado_rentabilidad_id'),
            'vendedor_id' => $this->input->post('vendedor_id'),
            'vendedor_pago_estado' => $this->input->post('vendedor_pago_estado'),
            'fecha_desde' => $this->input->post('fecha_desde'),
            'fecha_hasta' => $this->input->post('fecha_hasta'),
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'pagos_vendedor_records' => $this->fac->searchRentabilidad($filters),
            'total_records_find' => $this->fac->searchRentabilidad($filters) == false ? false : count($this->fac->searchRentabilidad($filters_find)),
            'total_records' => $this->fac->searchRentabilidad(array('accion' => 'group_by')) == false ? false : count($this->fac->searchRentabilidad(array('accion' => 'group_by'))),
            'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
            'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }

    public function updateFacturacion()
    {
        $field;
        if ($this->input->post('tipo_update') == 'F') {
            $correlativo = $this->fac->facturacionCorrelativo($this->input->post('tipo_comprobante_id'));
            $field  =   array(
                            'ad_correlativo_documento' => $correlativo->correlativo_comprobante,
                            'ad_fecha_emision' => $this->input->post('ad_fecha_emision'),
                            'ad_fecha_vencimiento' => $this->input->post('ad_fecha_vencimiento'),
                            'medio_pago_id' => $this->input->post('medio_pago_id'),
                            'estado_id' => $this->input->post('estado_id'),
                            'ad_fech_update' => $this->input->post('ad_fech_update'),
                            'ad_user_update' => $this->session->userdata('usu_id')
                        );
        } elseif ($this->input->post('tipo_update') == 'C') {
            $field  =   array(
                            'ad_fecha_pago' => $this->input->post('ad_fecha_pago'),
                            'estado_id' => $this->input->post('estado_id'),
                            'ad_fech_update' => $this->input->post('ad_fech_update'),
                            'ad_user_update' => $this->session->userdata('usu_id')
                        );
        } elseif ($this->input->post('tipo_update') == 'A') {
            $field  =   array(
                            'estado_id' => $this->input->post('estado_id'),
                            'ad_fech_update' => $this->input->post('ad_fech_update'),
                            'ad_user_update' => $this->session->userdata('usu_id')
                        );
        } elseif ($this->input->post('tipo_update') == 'P') {
            $field  =   array(
                            'estado_pago_perito' => $this->input->post('estado_pago_perito'),
                            'fecha_pago_perito' => $this->input->post('fecha_pago_perito')/*,
                            'ad_fech_update' => $this->input->post('ad_fech_update'),
                            'ad_user_update' => $this->session->userdata('usu_id')*/
                        );
        }


        $msg['success'] = false;
        if ($this->input->post('tipo_update') == 'A') {
            $verificarPagoPerito = $this->fac->verificarPago('perito', $this->input->post('ad_id'));
            $verificarPagoVendedor = $this->fac->verificarPago('vendedor', $this->input->post('cotizacion_id'));

            if ($verificarPagoPerito->estado_pago_perito == '1') {
                $msg['success'] = 'estado_perito';
            } else if ($verificarPagoVendedor->vendedor_pago_estado == '1'){
                $msg['success'] = 'estado_vendedor';
            } else {
                $update = $this->fac->Update($field, $this->input->post('ad_id'));
                if ($update > 0) {
                    $msg['success'] = true;
                    $field_auditoria = array(
                        'aut_usu_id' => $this->session->userdata('usu_id'),
                        'aut_ad_id' => $this->input->post('ad_id'),
                        'aut_ad_estado' => $this->input->post('estado_id')
                    );

                    $this->aud->insertFacturaion($field_auditoria);
                }
            }

        } else {
            $update = $this->fac->Update($field, $this->input->post('ad_id'));

            $msg['success'] = false;
            if ($update > 0) {
                $msg['success'] = true;

                if ($this->input->post('tipo_update') != 'P') {
                    $field_auditoria = array(
                        'aut_usu_id' => $this->session->userdata('usu_id'),
                        'aut_ad_id' => $this->input->post('ad_id'),
                        'aut_ad_estado' => $this->input->post('estado_id')
                    );

                    $this->aud->insertFacturaion($field_auditoria);
                }
            }
        }

        echo json_encode($msg);
    }

    public function updateNotaCredito()
    {
        $field = array(
            'ad_nota_credito' => $this->input->post('ad_nota_credito')
        );

        $update = $this->fac->Update($field, $this->input->post('ad_id'));

        $msg['success'] = false;
        if ($update > 0) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updatePagoVendedor()
    {
        $field  =   array(
                            'vendedor_pago_estado' => $this->input->post('vendedor_pago_estado'),
                            'vendedor_fecha_pago' => $this->input->post('vendedor_fecha_pago')
                        );
        $update = $this->cot->Update($field, $this->input->post('cotizacion_id'));

        $msg['success'] = false;
        if ($update > 0) {
            $msg['success'] = true;
        }

        echo json_encode($msg);
    }

    public function updateDocumentos()
    {
        $path = 'files/facturacion/';
        $file_xml_name = '';
        $file_pdf_name = '';

        $file_xml; $file_xml_tmp;
        $file_pdf; $file_pdf_tmp;

        $tipoDocumento = strtolower($this->input->post('tipo_documento'));
        $documentoCorrelativo = $this->input->post('documento_correlativo');

        if (isset($_FILES['fileXml'])) {
            /*if ($this->input->post('nameXml'))
                rmdir($path.$tipoDocumento.'/'.$documentoCorrelativo.'/'.$this->input->post('nameXml'));*/

            $file_xml_name = $_FILES['fileXml']['name'];
            $file_xml_tmp = $_FILES['fileXml']['tmp_name'];
            $file_xml = $path.$tipoDocumento.'/'.$documentoCorrelativo.'/'.$file_xml_name;
        }

        if (isset($_FILES['filePdf'])) {
            /*if ($this->input->post('namePdf'))
                rmdir($path.$tipoDocumento.'/'.$documentoCorrelativo.'/'.$this->input->post('namePdf'));*/

            $file_pdf_name = $_FILES['filePdf']['name'];
            $file_pdf_tmp = $_FILES['filePdf']['tmp_name'];
            $file_pdf = $path.$tipoDocumento.'/'.$documentoCorrelativo.'/'.$file_pdf_name;
        }

        $field = array(
            'ad_adjunto_xml' => $file_xml_name,
            'ad_adjunto_pdf' => $file_pdf_name
        );

        $update = $this->fac->Update($field, $this->input->post('ad_id'));

        $msg['success'] = false;
        if ($update > 0) {
            if (!file_exists($path.$tipoDocumento.'/'.$documentoCorrelativo)) {
                mkdir($path.$tipoDocumento.'/'.$documentoCorrelativo, 0777, true);
                if ($file_xml_name != '')
                    move_uploaded_file($file_xml_tmp, $file_xml);

                if ($file_pdf_name != '')
                    move_uploaded_file($file_pdf_tmp, $file_pdf);
            }
            $msg['success'] = true;
        }

        echo json_encode($msg);
    }
}

/* End of file Administracion.php */
/* Location: ./application/controllers/administracion/Administracion.php */