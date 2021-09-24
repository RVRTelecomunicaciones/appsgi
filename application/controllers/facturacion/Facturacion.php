<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        /*MODELOS*/
        $this->load->model('facturacion/facturacion_m', 'fac');
        $this->load->model('cotizacion/cotizacion_m', 'cot');
        $this->load->model('tservicio/TServicio_m', 'tps');
        $this->load->model('coordinador/coordinador_m', 'coor');
        $this->load->model('vendedor/vendedor_m', 'ven');
        $this->load->model('comprobante/comprobante_m', 'comp');
        $this->load->model('involucrado/involucrado_m', 'inv');
        $this->load->model('servicio/servicio_m', 'ser');
        $this->load->model('coordinacion/coordinacion_m', 'coord');
        $this->load->model('moneda/moneda_m', 'mnd');
        $this->load->model('gasto/gasto_m', 'gas');
        /**/
        $this->load->model('clasificacion/clasificacion_m', 'cla');
        $this->load->model('actividad/actividad_m', 'act');
        $this->load->model('grupo/grupo_m', 'grp');
        /**/

        /*LIBRERIAS*/
        $this->load->library('pdf');
    }

	public function informacion_facturacion()
    {
        $logued = $this->session->userdata('login');
        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['vendedor'] = $this->ven->vendedorReporte();
            $data['view'] = 'facturacion/cotizacion_informacion_facturacion';
            $this->load->view('layout', $data);
        }
    }

    public function informacion_facturacion_mantenimiento()
    {
        $logued = $this->session->userdata('login');
        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            //$data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
	        $data['view'] = 'facturacion/cotizacion_informacion_facturacion_mant';
	        $this->load->view('layout_form', $data);
	    }
    }

    public function informacion_facturacion_gastos()
    {
        $logued = $this->session->userdata('login');
        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['moneda'] = $this->mnd->monedaReporte();
            $data['gasto'] = $this->gas->searchGasto(array('gasto_estado' => '1'));
            $data['view'] = 'facturacion/cotizacion_informacion_facturacion_gastos';
            $this->load->view('layout_form', $data);
        }
    }

    public function searchFacturacion()
    {
        $filters;
        if ($this->input->post('accion') == 'informacion') {
            $filters     =   array(
                'accion' => $this->input->post('accion'),
                'cotizacion_id' => $this->input->post('cotizacion_id')
            );

            $data = array(
                'informacion_facturacion' => $this->fac->searchFacturacion($filters)
            );
            echo json_encode($data);
        }
    }

    public function searchCotizacionFacturacion()
    {
        $filters_find = array(
                            'accion' => $this->input->post('accion'),
                            'cotizacion_codigo' => $this->input->post('cotizacion_codigo'),
                            /*'cotizacion_fecha_finalizacion' => $this->input->post('cotizacion_fecha_finalizacion'),*/
                            'cliente_nombre' => $this->input->post('cliente_nombre'),
                            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
                            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
                            'coordinador_id' => $this->input->post('coordinador_id'),
                            'vendedor_id' => $this->input->post('vendedor_id'),
                            'cotizacion_moneda_monto' => $this->input->post('cotizacion_moneda_monto'),
                            'estado_id' => '3'
                        );

        $filters_pagination = array(
        	'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );
        
        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
                        'cotizacion' => $this->cot->searchCotizacionFacturacion($filters),
                        'total_records_find' => $this->cot->searchCotizacionFacturacion($filters) == false ? 0 : count($this->cot->searchCotizacionFacturacion($filters_find)),
                        'total_records' => count($this->cot->searchCotizacionFacturacion(array('accion' => 'full'))),
                        'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
        	            'quantity' => $this->input->post('quantity')
                    );
        echo json_encode($data);
    }

    public function updateCotizacionOrden()
    {
        $path = '../files/cotizacion/ordenes/';
        $msg['success'] = false;

        if (isset($_FILES['file'])) {
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            //$file = $path.$file_name;
            $file_name_new = $this->input->post('correlativo').' - ORDEN DE SERVICIO - '. $this->input->post('orden') .'.'.$file_ext;
            $file = $path.$file_name_new;

            if (file_exists($file)) {
                unlink($file);
            }

            $field = array(
                'orden_servicio' => $this->input->post('orden'),
                'orden_servicio_adjunto' => $file_name_new
            );
    
            $update = $this->cot->Update($field,$this->input->post('id'));
    
            
            if ($update > 0) {
                $msg['success'] = true;
                move_uploaded_file($file_tmp, $file);
            }
        }

        echo json_encode($msg);
    }

    public function serarchCoordinaciones()
    {
        $filters = array(
            'accion' => 'cotizacion',
            'cotizacion_id' => $this->input->post('cotizacion_id')
        );

        $data = array(
            'coordinaciones' => $this->coord->searchCoordinacion($filters),
        );

        echo json_encode($data);
    }

    /*BEGIN COMPROBANTES*/
    public function comprobanteReporte()
    {
        $result = $this->comp->comprobanteReporte();
        echo json_encode($result);
    }
    /*END COMPROBANTES*/

    /*BEGIN INVOLUCRADOS Y SERVICIOS*/
    public function searchInvServ($cotizacion)
    {
        $data = array(
                            'involucrados' => $this->inv->searchCotizacionInvolucrados($cotizacion),
                            'servicios' => $this->ser->searchCotizacionServicios($cotizacion)
                        );
        echo json_encode($data);
    }
    /*END INVOLUCRADOS Y SERVICIOS*/

    public function insertInformacionFactura()
    {
        $field = array (
            'ad_id' => 0,
            'ad_tipo_documento' => $this->input->post('ad_tipo_documento'),
            'ad_correlativo_documento' => 0,
            'cotizacion_id' => $this->input->post('cotizacion_id'),
            'solicitante_id' => $this->input->post('solicitante_id'),
            'solicitante_tipo' => $this->input->post('solicitante_tipo'),
            'facturado_por' => $this->input->post('facturado_por'),
            'cliente_facturado_id' => $this->input->post('cliente_facturado_id'),
            'cliente_facturado_tipo' => $this->input->post('cliente_facturado_tipo'),
            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
            'igv_tipo' => $this->input->post('igv_tipo'),
            'ad_subtotal' => $this->input->post('ad_subtotal'),
            'ad_igv' => $this->input->post('ad_igv'),
            'ad_total' => $this->input->post('ad_total'),
            'ad_porcentaje' => $this->input->post('ad_porcentaje'),
            'ad_porcentaje_num' => $this->input->post('ad_porcentaje_num'),
            'ad_atencion' => $this->input->post('ad_atencion'),
            'ad_correo' => $this->input->post('ad_correo'),
            'ad_concepto' => $this->input->post('ad_concepto'),
            'ad_nro_aprobacion' => $this->input->post('ad_nro_aprobacion'),
            'ad_codigo_tasacion' => $this->input->post('ad_codigo_tasacion'),
            'ad_observacion' => $this->input->post('ad_observacion'),
            'ad_user_create' => $this->session->userdata('usu_id'),
            'estado_id' => $this->input->post('estado_id')
        );

        $ad_id = $this->fac->Insert($field);


        $data = array(
                    'success' => $ad_id > 0 ? true : false
                );
        echo json_encode($data);
    }

    public function informacionGenerarPDF()
    {
        if($this->uri->segment(3)) {
            $row = $this->fac->searchFacturacion(array('accion' => 'generar_pdf','ad_id' => $this->uri->segment(3)));

            $html_content = '<!DOCTYPE html>
                            <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <title>INFORMACIÓN DE LA COTIZACIÓN: '.$row->cotizacion_codigo.'</title>
                                </head>
                                <body style="background-color: white">
                                    <div class="center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table>
                                                    <td>
                                                        <img src="'.base_url().'/assets/images/logo-pdf.jpg" height="80">
                                                    </td>
                                                    <td>
                                                        <div style="padding-left: 11rem" align="center"><h1 style="color: #45405d">Allemant Asociados Peritos Valuadores</h1></div>
                                                    </td>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <table style="font-size: 0.8rem;">
                                                    <tr>
                                                        <td style="background-color: #45405d; color: white;">
                                                            DATOS GENERALES
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">CLIENTE / BANCO</td>
                                                        <td width="395" style="border: 1px solid">
                                                            '.strtoupper($row->solicitante_nombre).'
                                                        </td>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">FECHA DE CREACIÓN</td>
                                                        <td align="center" width="120" style="border: 1px solid">'.$row->ad_fech_create.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">AP. Y NOMBRES / RAZÓN SOCIAL</td>
                                                        <td style="border: 1px solid; font-weight: bold;">'.strtoupper($row->cliente_facturado_nombre).'</td>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">DNI / RUC</td>
                                                        <td align="center" style="border: 1px solid; font-weight: bold;">'.$row->cliente_facturado_nro_documento.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">DOMICILIO FISCAL</td>
                                                        <td colspan="3" style="border: 1px solid">'.strtoupper($row->cliente_facturado_direccion).'</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #45405d; color: white;">
                                                            SERVICIO E IMPORTE
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            CONCEPTO
                                                        </td>
                                                        <td style="border: 1px solid; font-weight: bold;">'.strtoupper($row->ad_concepto).'</td>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            MONTO
                                                        </td>
                                                        <td align="center" style="border: 1px solid; font-weight: bold;">
                                                            '.$row->ad_importe_simbolo.'
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            CÓDIGO DE TASACIÓN
                                                        </td>
                                                        <td colspan="3" style="border: 1px solid; font-weight: bold;">
                                                            '.$row->ad_codigo_tasacion.'
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            ORDEN DE SERVICIO
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            '.$row->ad_orden_servicio.'
                                                        </td>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            NÚMERO DE ACEPTACIÓN
                                                        </td>
                                                        <td align="center" style="border: 1px solid">
                                                            '.$row->ad_nro_aprobacion.'
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #45405d;color: white;">
                                                            DATOS DE ENVÍO
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            CON ATENCIÓN A
                                                        </td>
                                                        <td colspan="3" style="border: 1px solid">'.strtoupper($row->ad_atencion).'</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #d2d2d2; border: 1px solid;">
                                                            CORREO
                                                        </td>
                                                        <td colspan="3" style="border: 1px solid">'.$row->ad_correo.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #45405d;color: white;">
                                                            OBSERVACIONES
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" rowspan="2" style="border: 1px solid">
                                                            &nbsp;'.strtoupper($row->ad_observacion).'
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </body>
                            </html>';
            $this->pdf->set_paper('A4', 'landscape'); 
            $this->pdf->loadHtml($html_content);
            $this->pdf->render();
            $this->pdf->stream($row->cotizacion_codigo.".pdf", array("Attachment"=>0));
        } else {
            redirect('facturacion/informacion_facturacion','refresh');
        }
    }

    public function searchDetalleGasto()
    {
        $filters  = array(
            'coordinacion_id' => $this->input->post('coordinacion_id')
        );

        $data = array(
            'gastos_find' => $this->gas->searchDetalleGasto($filters)
        );

        echo json_encode($data);
    }

    public function insertDetalleGasto()
    {
        $field = array (
            'afdg_id' => '0',
            'cotizacion_id' => $this->input->post('cotizacion_id'),
            'coordinacion_id' => $this->input->post('coordinacion_id'),
            'afg_id' => $this->input->post('afg_id'),
            'moneda_id' => $this->input->post('moneda_id'),
            'afdg_monto' => $this->input->post('afdg_monto'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->gas->InsertDetalle($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateDetalleGasto()
    {
        $field = array (
            'afg_id' => $this->input->post('afg_id'),
            'afdg_monto' => $this->input->post('afdg_monto'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('info_update')
        );

        $update = $this->gas->UpdateDetalle($field, $this->input->post('afdg_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    public function deleteDetalleGasto()
    {
        $delete = $this->gas->DeleteDetalle($this->input->post('afdg_id'));

        $msg['success'] = false;
        if ($delete > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    /*BEGIN INVOLUCRADOS*/
    public function involucradoReporte($tipo)
    {
        if ($tipo == 'J')
            $result = $this->inv->involucradoJuridicaReporte();
        else
            $result = $this->inv->involucradoNaturalReporte();
        echo json_encode($result);
    }

    public function searchInvolucrado($tipo)
    {
        $filters = '';
        $filters_total_records = '';

        if ($tipo == 'J') {
            $filters = array(
                                'involucrado_nombre' => $this->input->post('involucrado_nombre'),
                                'involucrado_documento' => $this->input->post('involucrado_documento'),
                                /*'clasificacion_id' => $this->input->post('clasificacion_id'),
                                'actividad_id' => $this->input->post('actividad_id'),
                                'grupo_id' => $this->input->post('grupo_id'),*/
                                'involucrado_direccion' => $this->input->post('involucrado_direccion'),
                                'involucrado_telefono' => $this->input->post('involucrado_telefono'),
                                'involucrado_estado' => $this->input->post('involucrado_estado')
                            );

            $filters_total_records =    array(
                                            'involucrado_nombre' => '',
                                            'involucrado_documento' => '',
                                            /*'clasificacion_id' => '',
                                            'actividad_id' => '',
                                            'grupo_id' => '',*/
                                            'involucrado_direccion' => '',
                                            'involucrado_telefono' => '',
                                            'involucrado_estado' => ''
                                        );
        } else {
            $filters = array(
                                'involucrado_nombre' => $this->input->post('involucrado_nombre'),
                                'involucrado_documento' => $this->input->post('involucrado_documento'),
                                'involucrado_direccion' => $this->input->post('involucrado_direccion'),
                                'involucrado_correo' => $this->input->post('involucrado_correo'),
                                'involucrado_estado' => $this->input->post('involucrado_estado')
                            );

            $filters_total_records =    array(
                                            'involucrado_nombre' => '',
                                            'involucrado_documento' => '',
                                            'involucrado_direccion' => '',
                                            'involucrado_correo' => '',
                                            'involucrado_estado' => ''
                                        );
        }
            

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'involucrado_find' => $tipo == 'J' ? $this->inv->searchInvolucradoJuridico($filters, $init, $quantity) : $this->inv->searchInvolucradoNatural($filters, $init, $quantity),
                        'involucrado_all' => $tipo == 'J' ? $this->inv->searchInvolucradoJuridico($filters_total_records) : $this->inv->searchInvolucradoNatural($filters),
                        'total_records_find' => $tipo == 'J' ? $this->inv->searchInvolucradoJuridico($filters) == false ? false : count($this->inv->searchInvolucradoJuridico($filters)) : $this->inv->searchInvolucradoNatural($filters) == false ? false : count($this->inv->searchInvolucradoNatural($filters)),
                        'total_records' => $tipo == 'J' ? $this->inv->searchInvolucradoJuridico($filters_total_records) == false ? false : count($this->inv->searchInvolucradoJuridico($filters_total_records)) : $this->inv->searchInvolucradoNatural($filters_total_records) == false ? false : count($this->inv->searchInvolucradoNatural($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertInvolucrado($tipo)
    {
        $field = '';
        $insert = '';
        $msg['success'] = false;

        if ($tipo == 'J') {
            $field = array (
                'id' => $this->input->post('involucrado_id'),
                'nombre' => $this->input->post('involucrado_nombre'),
                'ruc' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'observacion' => '',
                'clasificacion_id' => $this->input->post('clasificacion_id'),
                'actividad_id' => $this->input->post('actividad_id'),
                'grupo_id' => $this->input->post('grupo_id'),
                'vendedor_id' => '0',
                'estado_id' => '1',
                'referido_id' => '0',
                'importante_id' => '1',
                'info_status' => $this->input->post('involucrado_estado'),
                'info_create_user' => $this->session->userdata('usu_id')
            );

            $filters = array(
                                'involucrado_nombre' => '',
                                'involucrado_documento' => $this->input->post('involucrado_documento'),
                                'involucrado_direccion' => '',
                                'involucrado_telefono' => '',
                                'involucrado_estado' => ''
                            );

            $exist_ruc = $this->inv->searchInvolucradoJuridico($filters);

            if ($exist_ruc == false)
                $insert = $this->inv->insertInvolucradoJuridico($field);
            else
                $msg['success'] = 'exist';
        } else {
            $field = array (
                'id' => $this->input->post('involucrado_id'),
                'nombre' => $this->input->post('involucrado_nombre'),
                'documento_tipo_id' => '1',
                'documento' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'correo' => $this->input->post('involucrado_correo'),
                'vendedor_id' => '0',
                'estado_id' => '1',
                'observacion' => '',
                'referido_id' => '0',
                'importante_id' => '1',
                'info_status' => $this->input->post('involucrado_estado'),
                'info_create_user' => $this->session->userdata('usu_id')
            );

            $insert = $this->inv->insertInvolucradoNatural($field);
        }
        
        if ($msg['success'] != 'exist'){
            if ($insert > 0) {
                $msg['success'] = true;
            }
        }

        echo json_encode($msg);
    }

    public function updateInvolucrado($tipo)
    {
        $field = '';
        $insert = '';
        $msg['success'] = false;

        if ($tipo == 'J') {
            $field = array (
                'nombre' => $this->input->post('involucrado_nombre'),
                'ruc' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'clasificacion_id' => $this->input->post('clasificacion_id'),
                'actividad_id' => $this->input->post('actividad_id'),
                'grupo_id' => $this->input->post('grupo_id'),
                'info_status' => $this->input->post('involucrado_estado'),
                'info_update_user' => $this->session->userdata('usu_id'),
                'info_update' => $this->input->post('involucrado_fecha_update')
            );

            $update = $this->inv->updateInvolucradoJuridico($field, $this->input->post('involucrado_id'));
        } else {
            $field = array (
                'nombre' => $this->input->post('involucrado_nombre'),
                'documento' => $this->input->post('involucrado_documento'),
                'direccion' => $this->input->post('involucrado_direccion'),
                'telefono' => $this->input->post('involucrado_telefono'),
                'correo' => $this->input->post('involucrado_correo'),
                'info_status' => $this->input->post('involucrado_estado'),
                'info_update_user' => $this->session->userdata('usu_id'),
                'info_update' => $this->input->post('involucrado_fecha_update')
            );

            $update = $this->inv->updateInvolucradoNatural($field, $this->input->post('involucrado_id'));
        }
        
        if ($update > 0) {
            $msg['success'] = true;
        }

        echo json_encode($msg);
    }
    /*END INVOLUCRADOS*/

    /*BEGIN CLASIFICACIÓN*/
    public function searchClasificacion()
    {
        $filters = array(
                            'clasificacion_nombre' => $this->input->post('clasificacion_nombre'),
                            'clasificacion_estado' => $this->input->post('clasificacion_estado')
                        );

        $filters_total_records =    array(
                                        'clasificacion_nombre' => '',
                                        'clasificacion_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'clasificacion_find' => $this->cla->searchClasificacion($filters, $init, $quantity),
                        'clasificacion_all' => $this->cla->searchClasificacion($filters_total_records),
                        'total_records_find' => $this->cla->searchClasificacion($filters) == false ? false : count($this->cla->searchClasificacion($filters)),
                        'total_records' => $this->cla->searchClasificacion($filters_total_records) == false ? false : count($this->cla->searchClasificacion($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertClasificacion()
    {
        $field = array (
            'id' => $this->input->post('clasificacion_id'),
            'nombre' => $this->input->post('clasificacion_nombre'),
            'info_status' => $this->input->post('clasificacion_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->cla->Insert($field);

        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateClasificacion()
    {
        $field = array (
            'nombre' => $this->input->post('clasificacion_nombre'),
            'info_status' => $this->input->post('clasificacion_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('clasificacion_fecha_update')
        );

        $update = $this->cla->Update($field, $this->input->post('clasificacion_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END CLASIFICACIÓN*/

    /*BEGIN ACTIVIDAD*/
    public function searchActividad()
    {
        $filters = array(
                            'actividad_nombre' => $this->input->post('actividad_nombre'),
                            'actividad_estado' => $this->input->post('actividad_estado')
                        );

        $filters_total_records =    array(
                                        'actividad_nombre' => '',
                                        'actividad_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'actividad_find' => $this->act->searchactividad($filters, $init, $quantity),
                        'actividad_all' => $this->act->searchActividad($filters_total_records),
                        'total_records_find' => $this->act->searchactividad($filters) == false ? false : count($this->act->searchactividad($filters)),
                        'total_records' => $this->act->searchactividad($filters_total_records) == false ? false : count($this->act->searchactividad($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertActividad()
    {
        $field = array (
            'id' => $this->input->post('actividad_id'),
            'nombre' => $this->input->post('actividad_nombre'),
            'info_status' => $this->input->post('actividad_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->act->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateActividad()
    {
        $field = array (
            'nombre' => $this->input->post('actividad_nombre'),
            'info_status' => $this->input->post('actividad_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('actividad_fecha_update')
        );

        $update = $this->act->Update($field, $this->input->post('actividad_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END ACTIVIDAD*/

    /*BEGIN GRUPO*/
    public function searchGrupo()
    {
        $filters = array(
                            'grupo_nombre' => $this->input->post('grupo_nombre'),
                            'grupo_estado' => $this->input->post('grupo_estado')
                        );

        $filters_total_records =    array(
                                        'grupo_nombre' => '',
                                        'grupo_estado' => ''
                                    );

        $num_page = $this->input->post('num_page');
        $quantity = $this->input->post('quantity');
        $init = ($num_page - 1) * $quantity;
        $data = array(
                        'grupo_find' => $this->grp->searchGrupo($filters, $init, $quantity),
                        'grupo_all' => $this->grp->searchGrupo($filters_total_records),
                        'total_records_find' => $this->grp->searchGrupo($filters) == false ? false : count($this->grp->searchGrupo($filters)),
                        'total_records' => $this->grp->searchGrupo($filters_total_records) == false ? false : count($this->grp->searchGrupo($filters_total_records)),
                        'init' => ($init + 1),
                        'quantity' => $quantity
                    );
        echo json_encode($data);
    }

    public function insertGrupo()
    {
        $field = array (
            'id' => $this->input->post('grupo_id'),
            'nombre' => $this->input->post('grupo_nombre'),
            'info_status' => $this->input->post('grupo_estado'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $insert = $this->grp->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function updateGrupo()
    {
        $field = array (
            'nombre' => $this->input->post('grupo_nombre'),
            'info_status' => $this->input->post('grupo_estado'),
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('grupo_fecha_update')
        );

        $update = $this->grp->Update($field, $this->input->post('grupo_id'));

        $msg['success'] = false;
        if ($update > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }
    /*END GRUPO*/
    
    public function apiRUC($ruc)
    {
        /*try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }*/

        //$data = file_get_contents("http://consultas.dsdinformaticos.com/sunat.php?ruc=".$ruc);
        $data = file_get_contents("http://ruc.aqpfact.pe/sunat/".$ruc);
        $info = json_decode($data, true);
        
        if(empty($data)){
            $datos = array('existe' => false);
            echo json_encode($datos);
        } else {
            /*$datos = array(
                'ruc' => $info['result']['ruc'], 
                'razon_social' => $info['result']['razon_social'],
                'direccion' => $info['result']['direccion']
            );*/
            $datos = array(
                'ruc' => $info['Ruc'], 
                'razon_social' => $info['RazonSocial'],
                'direccion' => $info['DireccionCompleta']
            );

            echo json_encode($datos);
        }
    }

    public function apiDNI($dni)
    {
        //$data = file_get_contents("http://consultas.dsdinformaticos.com/reniec.php?dni=".$dni);
        $data = file_get_contents("https://api.reniec.cloud/dni/".$dni);
        $info = json_decode($data, true);
        
        if(empty($data)){
            $datos = array('existe' => false);
            echo json_encode($datos);
        } else {
            /*$datos = array(
                'dni' => $info['result']['DNI'], 
                'nombres' => $info['result']['Nombres'],
                'paterno' => $info['result']['ApellidoPaterno'],
                'materno' => $info['result']['ApellidoMaterno']
            );*/
            $datos = array(
                'dni' => $info['dni'], 
                'nombres' => $info['nombres'],
                'paterno' => $info['apellido_paterno'],
                'materno' => $info['apellido_materno']
            );
            echo json_encode($datos);
        }
    }
}

/* End of file Facturacion.php */
/* Location: ./application/controllers/facturacion/Facturacion.php */