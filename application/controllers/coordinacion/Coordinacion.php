<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinacion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('coordinacion/coordinacion_m', 'coord');
        $this->load->model('coordinador/coordinador_m', 'coordi');
        $this->load->model('calidad/calidad_m', 'ccal');
        $this->load->model('perito/perito_m', 'per');
        $this->load->model('estado/estado_m', 'est');
        $this->load->model('formato/formato_m', 'fmt');
        $this->load->model('motivo/motivo_m', 'mot');
        $this->load->model('tservicio/TServicio_m', 'tps');
        $this->load->model('tcambio/TCambio_m', 'tcmb');
        $this->load->model('inspeccion/inspeccion_m', 'insp');
        $this->load->model('coordinador/coordinador_m', 'coor');
        $this->load->model('servicio/servicio_m', 'serv');
        $this->load->model('auditoria/auditoria_m', 'aud');
        $this->load->model('bitacora/bitacora_m', 'bit');

        /*LIBRERIAS*/
        $this->load->library('excel');
        $this->load->library('pdf');
    }

    public function index()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['conteo'] = $this->coord->countCoordinaciones();
            $data['estado'] = $this->est->estadoCoordinacion();
            $data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['ccalidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'coordinacion/coordinacion_list';
            $this->load->view('layout', $data);
        }
    }

    public function mantenimiento()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['coordinador'] = $this->coordi->coordinadorSearch(array('accion' => 'filtros', 'coordinador_estado' => '1'));
            $data['estado'] = $this->est->estadoCoordinacion();
            $data['formato'] = $this->fmt->searchFormato(array('accion' => 'filtros'));
            $data['motivo'] = $this->mot->searchMotivo(array('accion' => 'filtros'));
            //$data['tservicio'] = $this->tps->servicioTipoReporte();
            $data['tcambio'] = $this->tcmb->searchTCambio(array('accion' => 'filtros'));
            $data['view'] = 'coordinacion/coordinacion_mant';
            $this->load->view('layout_form', $data);
        }
    }

    public function searchCoordinacionxCotizacion()
    {
        $filters_find =   array(
            'accion' => 'cotizacion',
            'cotizacion_id' => $this->input->post('cotizacion_id')
        );

        $data = array(
            'coordinacion_records' => $this->coord->searchCoordinacion($filters_find)
        );
        //echo json_encode($this->coord->searchCoordinacion($filters_find));
        echo json_encode($data);
    }

    public function searchCoordinacion()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cotizacion_id' => $this->input->post('cotizacion_id'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            'estado_id' => $this->input->post('estado_id'),
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
            'coordinacion_ubicacion' => $this->input->post('coordinacion_ubicacion'),
            'perito_id' => $this->input->post('perito_id'),
            'control_calidad_id' => $this->input->post('control_calidad_id'),
            'coordinador_id' => $this->input->post('coordinador_id'),
            'riesgo_id' => $this->input->post('riesgo_id'),
            'tipo_fecha' => $this->input->post('tipo_fecha'),
            'coordinacion_fecha_desde' => $this->input->post('coordinacion_fecha_desde'),
            'coordinacion_fecha_hasta' => $this->input->post('coordinacion_fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'coordinacion_records' => $this->coord->searchCoordinacion($filters),
            'total_records_find' => $this->coord->searchCoordinacion($filters) == false ? false : count($this->coord->searchCoordinacion($filters_find)),
            'total_records' => $this->coord->searchCoordinacion(array('accion' => 'filtros')) == false ? false : count($this->coord->searchCoordinacion(array('accion' => 'filtros'))),
            'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
            'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }

    public function insertCoordinacion()
    {
        $field = array (
            'id' => $this->input->post('coordinacion_id'),
            'coordinador_id' => $this->input->post('coordinador_id'),
            'riesgo_id' => $this->input->post('riesgo_id'),
            'solicitante_fecha' => $this->input->post('solicitante_fecha'),
            'entrega_al_cliente_fecha' => $this->input->post('entrega_al_cliente_fecha'),
            'sucursal' => $this->input->post('sucursal'),
            'modalidad_id' => $this->input->post('modalidad_id'),
            'tipo2_id' => $this->input->post('tipo2_id'),
            'tipo_cambio_id' => $this->input->post('tipo_cambio_id'),
            'tipo_id' => $this->input->post('tipo_id'),
            'observacion' => $this->input->post('observacion'),
            'estado_id' => $this->input->post('estado_id'),
            'info_create_user' => $this->session->userdata('usu_id'),
            'info_status' => '1'
        );

        $insert = $this->coord->Insert($field);
        
        $msg['success'] = false;
        if ($insert > 0){
            $msg['success'] = true;

            $field_auditoria = array(        
                'aut_usu_id' => $this->session->userdata('usu_id'),
                'aut_coor_id' => $insert,
                'aut_coor_est' => $this->input->post('estado_id')
            );

            $this->aud->insertCoordinacion($field_auditoria);

        }
        echo json_encode($msg);
    }
    
    public function insertCoordinacionGenerada()
    {
        $msg['success'] = false;
        if ($this->session->userdata('usu_id') != null)
        {
            $cantidad = intval($this->input->post('cantidad'));
            $i = 0;

            for ($i; $i < $cantidad; $i++) {
                $field_search_coordinacion = array(
                    'cotizacion_id' => $this->input->post('cotizacion_id'),
                    'create_user' => $this->session->userdata('usu_id')
                );

                $objCoodinacion = $this->coord->searchCoordinacionGenerada($field_search_coordinacion);

                $field_coordinacion = array(
                    'codigo' => $objCoodinacion->codigo,
                    'estado_id' => $objCoodinacion->estado_id,
                    'modalidad_id' => $objCoodinacion->modalidad_id,
                    'tipo_id' => $objCoodinacion->tipo_id,
                    'tipo2_id' => $objCoodinacion->tipo2_id,
                    'coordinador_id' => $objCoodinacion->coordinador_id,
                    'cotizacion_id' => $objCoodinacion->cotizacion_id,
                    'cotizacion_correlativo' => $objCoodinacion->cotizacion_correlativo,
                    'solicitante_persona_tipo' => $objCoodinacion->solicitante_persona_tipo,
                    'solicitante_persona_id' => $objCoodinacion->solicitante_persona_id,
                    'solicitante_persona_id_new' => $objCoodinacion->solicitante_persona_id_new,
                    'solicitante_contacto_id' => $objCoodinacion->solicitante_contacto_id,
                    'solicitante_fecha' => $objCoodinacion->solicitante_fecha,
                    /*'cliente_persona_tipo' => $objCoodinacion->cliente_persona_tipo,
                    'cliente_persona_id' => $objCoodinacion->cliente_persona_id,
                    'cliente_persona_id_new' => $objCoodinacion->cliente_persona_id_new,*/
                    'cliente_persona_tipo' => $objCoodinacion->solicitante_persona_tipo,
                    'cliente_persona_id' => $objCoodinacion->solicitante_persona_id,
                    'cliente_persona_id_new' => $objCoodinacion->solicitante_persona_id_new,
                    'sucursal' => $objCoodinacion->sucursal,
                    'observacion' => $objCoodinacion->observacion,
                    'tipo_cambio_id' => $objCoodinacion->tipo_cambio_id,
                    'impreso' => $objCoodinacion->impreso,
                    'estado_facturacion' => $objCoodinacion->estado_facturacion,
                    'info_status' => $objCoodinacion->info_status,
                    'info_create_user' => $objCoodinacion->info_create_user
                );

                $coordinacion_id = $this->coord->insert($field_coordinacion);

                if ($coordinacion_id > 0) {
                    $field_inspeccion = array(
                        'info_status' => '1',
                        'coordinacion_id' => $coordinacion_id,
                        'perito_id' => '0',
                        'inspector_id' => '0',
                        'estado_id' => '1',
                        'departamento_id' => '15',
                        'provincia_id' => '1',
                        'distrito_id' => '1',
                        'ubigeo_distrito_id' => '1253',
                        'hora_real_mostrar' => 1,
                        'direccion' => '',
                        'observacion' => ''
                    );

                    $field_inspeccion_detalle = array(
                        'perito_id' => '0',
                        'contactos' => '',
                        'fecha' =>  '0000-00-00',
                        'hora' => '00:00',
                        'hora_tipo' => '1',
                        'distrito_id' => '1253',
                        'direccion' => '',
                        'observacion' => '',
                        'estado_id' => '1',
                        'info_create_user' => $this->session->userdata('usu_id'),
                        'info_status' => '1'
                    );

                    $this->insp->Insert($field_inspeccion);
                    $this->insp->insertDetalle($field_inspeccion_detalle, $coordinacion_id);

                    $field_auditoria = array(
                        'aut_usu_id' => $this->session->userdata('usu_id'),
                        'aut_coor_id' => $coordinacion_id ,
                        'aut_coor_est' => 6
                    );
                    $this->aud->insertCoordinacion($field_auditoria);
                }
            }

            $msg['success'] = true;
            $msg['text'] = $cantidad < 1 ? 'Se generó ' . $cantidad . ' coordinación...' : 'Se generarón ' . $cantidad . ' coordinaciones...';
        } else {
            $msg['text'] = 'Debe iniciar sesión...';
        }
        
        echo json_encode($msg);
    }

    public function updateCoordinacion()
    {
        $field = array (
            'riesgo_id' => $this->input->post('riesgo_id'),
            'solicitante_fecha' => $this->input->post('solicitante_fecha'),
            'coordinador_id' => $this->input->post('coordinador_id'),
            'entrega_al_cliente_fecha' => $this->input->post('entrega_al_cliente_fecha'),
            'sucursal' => $this->input->post('sucursal'),
            'modalidad_id' => $this->input->post('modalidad_id'),
            'tipo2_id' => $this->input->post('tipo2_id'),
            'tipo_cambio_id' => $this->input->post('tipo_cambio_id'),
            'tipo_id' => $this->input->post('tipo_id'),
            'observacion' => $this->input->post('observacion'),
            'estado_id' => $this->input->post('estado_id'),
            'info_status' => '1',
            'info_update_user' => $this->session->userdata('usu_id'),
            'info_update' => $this->input->post('coordinacion_fecha_update')
        );

        $update = $this->coord->Update($field, $this->input->post('coordinacion_id'));

        $msg['success'] = false;
        if ($update > 0) {
            $msg['success'] = true;

            $result = $this->aud->searchAuditoriaCoordinacion(array('accion' => 'filtros', 'coordinacion_id' => $this->input->post('coordinacion_id')));
            //echo json_encode($result);
            if ($result->aut_coor_est != $this->input->post('estado_id')) {
                $field_auditoria = array(        
                    'aut_usu_id' => $this->session->userdata('usu_id'),
                    'aut_coor_id' => $this->input->post('coordinacion_id'),
                    'aut_coor_est' => $this->input->post('estado_id')
                );

                $this->aud->insertCoordinacion($field_auditoria);
            }
        }
        echo json_encode($msg);
    }

    public function hojaCoordinacion()
    {
        //$datos = json_decode($this->uri->segment(3));
        $datos = json_decode($this->input->get('data'));
        if($datos->coordinacion_id != '' || $datos->coordinacion_id != null) {

            $row_coordinacion = $this->coord->searchCoordinacion(array('accion' => 'generar_pdf', 'coordinacion_id' => $datos->coordinacion_id));

            $arrArreglo = explode('-', $row_coordinacion->inspeccion_hora);
            $arrayHoras  = array('01' => '13', '02' => '14', '03' => '15', '04' => '16', '05' => '17', '06' => '18', '07' => '19', '08' => '20', '09' => '21', '10' => '22', '11' => '23', '12' => '12');
            $hora;

            if (count($arrArreglo) > 1) {
                $arrHoraIni = explode(':',$arrArreglo[0]);
                $arrHoraFin = explode(':',$arrArreglo[1]);
                $horaIni;
                $horaFin;

                if (intval($arrHoraIni[0]) < 12)
                    $horaIni = $arrHoraIni[0].':'.$arrHoraIni[1].' AM';
                else
                    $horaIni = array_search($arrHoraIni[0], $arrayHoras).':'.$arrHoraIni[1].' PM';

                if (intval($arrHoraFin[0]) < 12)
                    $horaFin = $arrHoraFin[0].':'.$arrHoraFin[1].' AM';
                else
                    $horaFin = array_search($arrHoraFin[0], $arrayHoras).':'.$arrHoraFin[1].' PM';

                $hora = $horaIni . ' a ' . $horaFin;
            } else {
                $arrHora = explode(':', $arrArreglo[0]);
                if (intval($arrHora[0]) < 12)
                    $hora = $arrHora[0].':'.$arrHora[1].' AM';
                elseif (intval($arrHora[0]) == 12)
                    $hora = '12:'.$arrHora[1].' PM';
                else
                    $hora = array_search($arrHora[0], $arrayHoras).':'.$arrHora[1].' PM';
            }

            $row_inspeccion = $this->insp->searchInspeccion(array('accion' => 'generar_pdf', 'inspeccion_id' => $datos->inspeccion_id));
            $row_servicio_detalle = $this->serv->searchCotizacionServicios($datos->cotizacion_id);

            //print_r($row_servicio_detalle);
            $servicios = '';
            foreach ($row_servicio_detalle as $row) {
                if ($row->servicio_id != 0)
                    $servicios .= $row->servicio_nombre.'<br><hr>';
                else
                    $servicios .= $row->servicio_descripcion.'<br><hr>';
            }

            $order   = array("\r\n", "\n", "\r");
            $replace = "<br>";
            $html_content = '<!DOCTYPE html>
                                <html lang="es">
                                    <head>
                                        <!--<meta charset="UTF-8">-->
                                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                                        <title>'.$row_coordinacion->coordinacion_correlativo.' - HOJA</title>
                                    </head>
                                    <body style="background-color: white">
                                        <style>
                                            table {
                                              border-collapse: collapse;
                                            }

                                            table, th, td {
                                              border: 1px solid black;
                                            }
                                        </style>
                                        <table border="1" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td colspan="6" align="center">Allemant Asociados Peritos Valuadores SAC</td>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Código de Coordinación</div></td>
                                                    <td colspan="2"><div style="margin-left: 10px">'.strtoupper($row_coordinacion->coordinacion_correlativo).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Coordinador</div></td>
                                                    <td colspan="5"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->coordinador_nombre).'</div></td>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">F. Solicitud</div></td>
                                                    <td colspan="2"><div style="margin-left: 10px">'.$row_coordinacion->fecha_solicitud.'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Formato</div></td>
                                                    <td colspan="5"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->formato_nombre).'</div></td>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">F. Entrega al Cliente</div></td>
                                                    <td colspan="2"><div style="margin-left: 10px">'.$row_coordinacion->fecha_entrega_cliente.'</div></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9" align="center" style="background-color: #b2b2b2;">Solicitud de Tasación</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Solicitante <br> Funcionario <br> Sucursal</div></td>
                                                    <td colspan="5" rowspan="3" valign="top"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->solicitante_nombre).' <br> '.strtoupper($row_coordinacion->contacto_nombre).' <br> '.strtoupper($row_coordinacion->coordinacion_sucursal).'</div></td>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Tipo de Servicio</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->servicio_tipo_nombre).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Inspección</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->tipo_inspeccion_nombre).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Tipo de Cambio</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->tipo_cambio_nombre).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Cliente</div></td>
                                                    <td colspan="5" rowspan="3"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->cliente_nombre).'</div></td>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Perito</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->perito_nombre).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Digitador</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_inspeccion->digitador_nombre).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Control de Calidad</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->control_calidad_nombre).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Ubicación</div></td>
                                                    <td colspan="5" rowspan="3"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper($row_coordinacion->inspeccion_direccion).'<br>'.$row_inspeccion->departamento_nombre.'<i style="color:red;"> -> </i>'.$row_inspeccion->provincia_nombre.'<i style="color:red;"> -> </i>'.$row_inspeccion->distrito_nombre.'</div></td>
                                                    <td align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Contactos</div></td>
                                                    <td colspan="2"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper(str_replace($order, $replace, $row_coordinacion->inspeccion_contacto)).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" align="right" style="background-color: #d2d2d2;"><div style="margin-right: 5px">Inspeccion Ocular</div></td>
                                                    <td align="center" style="background-color: #d2d2d2;">Fecha</td>
                                                    <td align="center" style="background-color: #d2d2d2;">Hora</td>
                                                </tr>
                                                <tr>
                                                    <td align="center">'.$row_coordinacion->inspeccion_fecha.'</td>
                                                    <td align="center">'.$hora.'</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" align="center" style="background-color: #b2b2b2;">Servicios</td>
                                                    <td colspan="3" align="center" style="background-color: #b2b2b2;">Observación</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" width="400" height="150" valign="top"><div style="font-size: 0.85rem;margin-left: 5px;">'.$servicios.'</div></td>
                                                    <td colspan="3" rowspan="3" valign="top"><div style="font-size: 0.85rem;margin-left: 5px;">'.strtoupper(str_replace($order, $replace, $row_coordinacion->inspeccion_observacion)).'</div></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="background-color: #d2d2d2;">Operaciones</td>
                                                    <td height="25"></td>
                                                    <td align="center" style="background-color: #d2d2d2;">Gerencia</td>
                                                    <td height="25"></td>
                                                    <td align="center" style="background-color: #d2d2d2;">Coordinación</td>
                                                    <td height="25"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" align="center" style="background-color: #b2b2b2;">Visto Bueno</td>
                                                </tr>
                                            </tbody>
                                        </table>                                      
                                    </body>
                                </html>';
            $this->pdf->set_paper('A4', 'landscape'); 
            $this->pdf->loadHtml($html_content);
            $this->pdf->render();
            $this->pdf->stream("Hoja de Coordinacion - ".$row_coordinacion->coordinacion_correlativo.".pdf", array("Attachment"=>0));
        }
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
                'servicio_tipo_id' => implode(",", $datos->servicio_tipo_id),
                'coordinacion_ubicacion' => $datos->coordinacion_ubicacion,
                'perito_id' => $datos->perito_id,
                'control_calidad_id' => $datos->control_calidad_id,
                'coordinador_id' => $datos->coordinador_id,
                'tipo_fecha' => $datos->tipo_fecha,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta
            );

            $impresion = $this->coord->searchCoordinacion($filters);
            $table_boddy = "";

            if ($impresion == false) {
                $table_boddy .= '<tr><td colspan="12">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($impresion as $row) {
                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.5rem">'.$i.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinacion_correlativo.'</td>
                                        <td style="font-size: 0.5rem">'.$row->coordinacion_estado_nombre.'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper(str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre))).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper(str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre))).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->servicio_tipo_nombre).'</td>
                                        <td style="font-size: 0.5rem"><div>'.$row->inspeccion_direccion.'</div><div>'.$row->departamento_nombre.' <i class="fa fa-play text-danger"></i> '.$row->provincia_nombre.' <i class="fa fa-play text-danger"></i>'.$row->distrito_nombre.'</div></td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->perito_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->control_calidad_nombre).'</td>
                                        <td style="font-size: 0.5rem">'.strtoupper($row->coordinador_nombre).'</td>
                                        <!--<td style="font-size: 0.5rem">'.$row->fecha_aprobacion.'</td>-->
                                        <td style="font-size: 0.5rem">'.$row->fecha_entrega.'</td>
                                        <!--<td style="font-size: 0.5rem">'.$row->fecha_entrega_cliente_nueva.'</td>-->
                                        <td style="font-size: 0.5rem">'.$row->inspeccion_fecha.'</td>
                                        <td style="font-size: 0.5rem">'.$row->riesgo_nombre.'</td>
                                    </tr>';
                    $i++;
                }
            }

            $data['coordinacion'] = $table_boddy;
            $data['view'] = 'coordinacion/coordinacion_print';
            $this->load->view('layout_impresion', $data);
        }
    }

    public function reportCoordinacionExcel()
    {
        $objeto = json_decode($this->input->post('data'));
        
        $filters = array(
                            'accion' => 'filtros',
                            'coordinacion_correlativo' => $objeto->coordinacion_correlativo,
                            'estado_id' => $objeto->estado_id,
                            'solicitante_nombre' => $objeto->solicitante_nombre,
                            'cliente_nombre' => $objeto->cliente_nombre,
                            'servicio_tipo_id' => implode(",", $objeto->servicio_tipo_id),
                            'coordinacion_ubicacion' => $objeto->coordinacion_ubicacion,
                            'perito_id' => $objeto->perito_id,
                            'control_calidad_id' => $objeto->control_calidad_id,
                            'coordinador_id' => $objeto->coordinador_id,
                            'tipo_fecha' => $objeto->tipo_fecha,
                            'coordinacion_fecha_desde' => $objeto->coordinacion_fecha_desde,
                            'coordinacion_fecha_hasta' => $objeto->coordinacion_fecha_hasta
                        );

        $Coordinacion = $this->coord->searchCoordinacion($filters);

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
        $objPHPExcel->getActiveSheet()->getStyle('B2:P2')->applyFromArray($style_title);
        
        //Configuramos el tamaño de los encabezados de las columnas
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(32.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12.7);

        //Añadimos los titulos a los encabezados de columnas
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A5', '#');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'CÓDIGO COORD.');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'ESTADO');
        $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'SOLICITANTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'CLIENTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'TIPO SERVICIO');
        $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'UBICACIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'PERITO');
        $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'CONTROL DE CALIDAD');
        $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'COORDINADOR');
        $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'FECHA DE APROBACIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'FECHA DE INSPECCIÓN');
        $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'FECHA DE ENTREGA AL CLIENTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'NUEVA FECHA DE ENTREGA AL CLIENTE');
        $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'DIAS');
        $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'PROGRESO');

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
        $objPHPExcel->getActiveSheet()->getStyle('A5:P5')->applyFromArray($style_columns_headers);

        //Obtener los datos
        $rowCount = 6;
        foreach ($Coordinacion as $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 5);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "$row->coordinacion_correlativo");
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, strtoupper($row->coordinacion_estado_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper(str_replace("* ","",str_replace('|',"\n",$row->solicitante_nombre))));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper(str_replace("* ","",str_replace('|',"\n",$row->cliente_nombre))));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, strtoupper($row->servicio_tipo_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, strtoupper($row->inspeccion_direccion)."\n".$row->departamento_nombre." > ".$row->provincia_nombre." > ".$row->distrito_nombre);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, strtoupper($row->perito_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, strtoupper($row->control_calidad_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, strtoupper($row->coordinador_nombre));
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->fecha_aprobacion);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->inspeccion_fecha);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->fecha_entrega_cliente);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->fecha_entrega_cliente_nueva);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, '');

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
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':O' . $rowCount)->applyFromArray($style_rows);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . $rowCount)->applyFromArray($style_rows_adjust_text);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C' . $rowCount)->applyFromArray($style_rows_horizontal_center);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows_horizontal_center);

            $rowCount++;
        }

        $fileName = 'Reporte de Coordinacion - ' . date('dmY-his') . '.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function insertCambioFecha()
    {
        $msg['success'] = false;

        $field_cambio = array(        
            'coordinacion_id' => $this->input->post('cambio_coordinacion_id'),
            'fecha_anterior' => $this->input->post('cambio_fecha_anterior'),
            'fecha_nueva' => $this->input->post('cambio_fecha_nueva'),
            'desripcion' => $this->input->post('cambio_desripcion'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $field_coordinacion = array(
            'entrega_al_cliente_fecha' => $this->input->post('cambio_fecha_nueva'),
        );

        $insert = $this->coord->insertCambioFecha($field_cambio);
        
        if ($insert > 0) {
            $msg['success'] = true;
            $update = $this->coord->Update($field_coordinacion, $this->input->post('cambio_coordinacion_id'));
        }

        echo json_encode($msg);
    }

    /*REPROCESOS*/

    public function insertCoordinacionReproceso()
    {
        $msg['success'] = false;

        $field_reproceso = array(
            'coordinacion_id' => $this->input->post('reproceso_coordinacion_id'),
            'motivo_id' => $this->input->post('reproceso_motivo_id'),
            'observacion' => $this->input->post('reproceso_desripcion'),
            'fecha_nueva' => $this->input->post('reproceso_fecha_nueva'),
            'info_create_user' => $this->session->userdata('usu_id')
        );

        $field_coordinacion = array(
            'estado_id' => $this->input->post('reproceso_estado_id'),
            'entrega_al_cliente_fecha_nueva' => $this->input->post('reproceso_fecha_nueva')
        );

        $insert = $this->coord->insertCoordinacionReproceso($field_reproceso);

        if ($insert > 0) {
            $msg['success'] = true;
            $update = $this->coord->Update($field_coordinacion, $this->input->post('reproceso_coordinacion_id'));
        }

        echo json_encode($msg);
    }

    public function searchCoordinacionReprocesos()
    {
        $filters_find =   array(
            'accion' => $this->input->post('accion'),
            'cotizacion_id' => $this->input->post('cotizacion_id'),
            'coordinacion_correlativo' => $this->input->post('coordinacion_correlativo'),
            /*'estado_id' => $this->input->post('estado_id'),*/
            'solicitante_nombre' => $this->input->post('solicitante_nombre'),
            'cliente_nombre' => $this->input->post('cliente_nombre'),
            'servicio_tipo_id' => $this->input->post('servicio_tipo_id'),
            'coordinacion_ubicacion' => $this->input->post('coordinacion_ubicacion'),
            'perito_id' => $this->input->post('perito_id'),
            'control_calidad_id' => $this->input->post('control_calidad_id'),
            'coordinador_id' => $this->input->post('coordinador_id'),
            'tipo_fecha' => $this->input->post('tipo_fecha'),
            'coordinacion_fecha_desde' => $this->input->post('coordinacion_fecha_desde'),
            'coordinacion_fecha_hasta' => $this->input->post('coordinacion_fecha_hasta')
        );

        $filters_pagination = array(
            'init' => ($this->input->post('num_page')-1) * $this->input->post('quantity'),
            'quantity' => $this->input->post('quantity')
        );

        $filters = array_merge($filters_find, $filters_pagination);

        $data = array(
            'coordinacion_records' => $this->coord->searchCoordinacionReprocesos($filters),
            'total_records_find' => $this->coord->searchCoordinacionReprocesos($filters) == false ? false : count($this->coord->searchCoordinacionReprocesos($filters_find)),
            'total_records' => $this->coord->searchCoordinacionReprocesos(array('accion' => 'full')) == false ? false : count($this->coord->searchCoordinacionReprocesos(array('accion' => 'full'))),
            'init' => (($this->input->post('num_page')-1) * $this->input->post('quantity') + 1),
            'quantity' => $this->input->post('quantity')
        );

        echo json_encode($data);
    }
    
    
    //COORDINACION CON DETALLE DE INSPECCIÓN
    public function listado()
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
            $data['view'] = 'coordinacion/coordinacion';
            $this->load->view('layout', $data);
        }
    }

    public function registro()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = $this->uri->segment(1);
            $data['coordinador'] = $this->coordi->coordinadorSearch(array('accion' => 'filtros', 'coordinador_estado' => '1'));
            $data['estado'] = $this->est->estadoCoordinacion();
            $data['formato'] = $this->fmt->searchFormato(array('accion' => 'filtros'));
            $data['motivo'] = $this->mot->searchMotivo(array('accion' => 'filtros'));
            $data['tcambio'] = $this->tcmb->searchTCambio(array('accion' => 'filtros'));
            $data['peritos'] = $this->per->search(array('perito_estado' => 1));
            $data['control_calidad'] = $this->ccal->search(array('control_calidad_estado' => 1));
            $data['view'] = 'coordinacion/coordinacion_mantenimiento';
            $this->load->view('layout_form', $data);
        }
    }

    public function operaciones()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = 'Operaciones';
            $data['conteo'] = $this->coord->countCoordinaciones();
            $data['estado'] = $this->est->estadoCoordinacion();
            $data['tipo_servicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['control_calidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'coordinacion/coordinacion_operaciones';
            $this->load->view('layout', $data);
        }
    }

    public function search()
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
            'coordinacion_riesgo' => $this->input->post('coordinacion_riesgo'),
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
        if ($this->input->post('action') != 'maintenance' && $this->input->post('action') != 'cotizacion') {
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
                                    <td $rowSpan><a id='lnkViewCoordinacion' href data-cotizacion='$rowItem->cotizacion_id' data-coordinacion='$rowItem->coordinacion_id'>$rowItem->coordinacion_correlativo</a></td>
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
                                    <td $rowSpan>$rowItem->coordinacion_fecha_operaciones</td>
                                    <td $rowSpan><div class='badge' style='background: $backgound;'>$rowItem->riesgo_nombre</div></td>
                                    <td $rowSpan> <a id='lnkSeguimiento' href class='btn btn-outline-secondary btn-sm grey' data-coordinacion='$rowItem->coordinacion_id'><i class='fa fa-list-alt'></i></a></td>
                                </tr>";

                    $body .= $bodyInspeccion;
                    $iItem++;
                }
            }
        }
        $data = array();

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
        } else {
            $data = array(
                'records_all_count' => $this->coord->search($filters_count),
                'records_find_count' => $this->coord->search(array_merge($filters_count, $filters_find)),
                'records_find' => $body
            );
        }

        echo json_encode($data);
    }

    /*public function insert()
    {
    }*/

    public function update()
    {
        $fields = array(
            'riesgo_id' => $this->input->post('coordinacion_riesgo'),
            'coordinador_id' => $this->input->post('coordinacion_coordinador'),
            'estado_id' => $this->input->post('coordinacion_estado'),
            'entrega_al_cliente_fecha' => $this->input->post('coordinacion_fecha_entrega'),
            'entrega_por_operaciones_fecha' => $this->input->post('coordinacion_fecha_entrega_operaciones'),
            'sucursal' => $this->input->post('coordinacion_sucursal'),
            'modalidad_id' => $this->input->post('coordinacion_formato'),
            'tipo_cambio_id' => $this->input->post('coordinacion_tipo_cambio'),
            'tipo_id' => $this->input->post('coordinacion_tipo_inspeccion'),
            'observacion' => $this->input->post('coordinacion_observacion'),
            'digitador_id' => $this->input->post('coordinacion_digitador'),
            'control_calidad_id' => $this->input->post('coordinacion_control_calidad'),
            'info_update' => date('Y-m-d H:i:s'),
            'info_update_user' => $this->session->userdata('usu_id')
        );

        $update = $this->coord->updateDetalle($fields, $this->input->post('coordinacion_codigo'));

        $msg['success'] = false;
        if ($update > 0) {
            $msg['success'] = true;

            $result = $this->aud->search(array('action' => 'sheet', 'coordinacion_codigo' => $this->input->post('coordinacion_codigo')));
            //echo json_encode($result);
            if (intval($result->estado_id) != intval($this->input->post('coordinacion_estado'))) {
                $fields_auditoria = array(        
                    'aut_usu_id' => $this->session->userdata('usu_id'),
                    'aut_coor_id' => $this->input->post('coordinacion_codigo'),
                    'aut_coor_est' => $this->input->post('coordinacion_estado')
                );

                $this->aud->insertCoordinacion($fields_auditoria);
            }
        }

        echo json_encode($msg);
    }
    
    public function updateCliente()
    {
        $fields = array(
            'cliente_persona_tipo' => $this->input->post('coordinacion_cliente_tipo'),
            'cliente_persona_id_new' => $this->input->post('coordinacion_cliente'),
            'info_update' => date('Y-m-d H:i:s'),
            'info_update_user' => $this->session->userdata('usu_id')
        );

        $update = $this->coord->updateDetalle($fields, $this->input->post('coordinacion_codigo'));

        $msg['success'] = false;
        if ($update > 0) {
            $msg['success'] = true;
        }

        echo json_encode($msg);
    }
    
    public function hoja()
    {
        //$datos = json_decode($this->input->get('data'));
        $cotizacion_codigo = $this->input->get('cotizacion');
        $inspeccion_codigo = $this->input->get('inspeccion');

        /*$row_coordinacion = $this->insp->search(array('accion' => 'sheet', 'inspeccion_codigo' => $datos->inspeccion_id));
        $row_servicio_detalle = $this->serv->searchCotizacionServicios($datos->cotizacion_id);*/
        
        $row_coordinacion = $this->insp->search(array('action' => 'sheet', 'inspeccion_codigo' => $inspeccion_codigo));
        $row_servicio_detalle = $this->serv->searchCotizacionServicios($cotizacion_codigo);

        $arrArreglo = explode('-', $row_coordinacion->inspeccion_hora);
        $arrayHoras  = array('12' => '12', '01' => '13', '02' => '14', '03' => '15', '04' => '16', '05' => '17', '06' => '18', '07' => '19', '08' => '20', '09' => '21', '10' => '22', '11' => '23', '00' => '24');
        $hora_final;
        if (count($arrArreglo) > 1) {
            $arrHoraIni = explode(':', $arrArreglo[0]);
            $arrHoraFin = explode(':', $arrArreglo[1]);
            $horaIni;
            $horaFin;

            if (intval($arrHoraIni[0]) < 12)
                $horaIni = $arrHoraIni[0] . ":" . $arrHoraIni[1] . " AM";
            else
                $horaIni = array_search($arrHoraIni[0], $arrayHoras) . ":" . $arrHoraIni[1] . " PM";

            if (intval($arrHoraFin[0]) < 12)
                $horaFin = $arrHoraFin[0] . ":" . $arrHoraFin[1] . " AM";
            else
                $horaFin = array_search($arrHoraFin[0], $arrayHoras) . ":" . $arrHoraFin[1] . " PM";

            $hora_final = $horaIni . " a " . $horaFin;
        } else {
            $arrHora = explode(':', $arrArreglo[0]);

            if ($arrHora[0] < 12)
                $hora_final = $arrHora[0] . ":" . $arrHora[1] . " AM";
            else
                $hora_final = array_search($arrHora[0], $arrayHoras) . ":" . $arrHora[1] . " PM";
        }

        $servicios = '';
        foreach ($row_servicio_detalle as $row) {
            if ($row->servicio_id != 0)
                $servicios .= $row->servicio_nombre.'<br><hr>';
            else
                $servicios .= $row->servicio_descripcion.'<br><hr>';
        }
        
        $riesgo_color = "";
        switch ($row_coordinacion->riesgo_id) {
            case '1':
                $riesgo_color = "green";
                break;
            case '2':
                $riesgo_color = "yellow";
                break;
            case '3':
                $riesgo_color = "red";
                break;
            default:
                $riesgo_color = "white";
                break;
        }

        $order   = array("\r\n", "\r", "\n");
        $replace = "<br />";
        $html_content = '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                            <title>'.$row_coordinacion->coordinacion_correlativo.' - HOJA DE COORDINACIÓN</title>
                        </head>
                        <body>
                            <style>
                                table {
                                    border-collapse: collapse;
                                }
                        
                                table, th, td {
                                    border: 1px solid black;
                                }
                            </style>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="6" align="center"><strong>Allemant Asociados Peritos Valuadores S.A.C.</strong></td>
                                        <td style="background-color: lightgrey;" colspan="2" width="12.5%"><div style="margin-left: 5px;">Coordinación</div></td>
                                        <td align="center" width="12.5%">'.$row_coordinacion->coordinacion_correlativo.'</td>
                                        <td style="background-color: lightgrey;" colspan="2" width="12.5%"><div style="margin-left: 5px;">Inspección</div></td>
                                        <td align="center" width="12.5%">'.$row_coordinacion->inspeccion_id.'</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;"><div style="margin-left: 5px;">Coordinador</div></td>
                                        <td colspan="5"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px;">'.strtoupper($row_coordinacion->coordinador_nombre).'</div></td>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">F. Solicitud</div></td>
                                        <td colspan="4"><div style="margin-left: 5px;">'.$row_coordinacion->fecha_solicitud.'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;"><div style="margin-left: 5px;">Riesgo</div></td>
                                        <td style="background-color: '.$riesgo_color.';"></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px;">'.strtoupper($row_coordinacion->riesgo_nombre).'</div></td>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">F. Entrega</div></td>
                                        <td colspan="4"><div style="margin-left: 5px;">'.$row_coordinacion->fecha_entrega.'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: grey;" colspan="12" align="center">Solicitud de Tasación</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" rowspan="4"><div style="margin-left: 5px; position: absolute;">Solicitante <br /> Funcionario</div></td>
                                        <td colspan="5" rowspan="4">
                                            <div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px; position: absolute;">'.strtoupper($row_coordinacion->solicitante_nombre).' <br /> '.strtoupper($row_coordinacion->contacto_nombre).'</div>
                                        </td>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">Tipo de Servicio</div></td>
                                        <td colspan="4" height="5%"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px; position: absolute;">'.strtoupper($row_coordinacion->servicio_tipo_nombre).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">Formato</div></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px;">'.strtoupper($row_coordinacion->modalidad_nombre).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">T. de Inspección</div></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px;">'.strtoupper($row_coordinacion->tipo_inspeccion_nombre).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">Tipo de Cambio</div></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px;">'.strtoupper($row_coordinacion->tipo_cambio_nombre).'</div></td>
                                    </tr>
                        
                                    <tr>
                                        <td style="background-color: lightgrey;" rowspan="3"><div style="margin-left: 5px;">Cliente</div></td>
                                        <td colspan="5" rowspan="3"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px; position: absolute;">'.strtoupper($row_coordinacion->cliente_nombre).'</div></td>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">Perito</div></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px;">'.strtoupper($row_coordinacion->perito_nombre).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">Digitador</div></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px;">'.strtoupper($row_coordinacion->digitador_nombre).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">C. de Calidad</div></td>
                                        <td colspan="4"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px;">'.strtoupper($row_coordinacion->control_calidad_nombre).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" rowspan="3"><div style="margin-left: 5px;">Dirección</div></td>
                                        <td colspan="5" rowspan="3"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px; position: absolute;">'.strtoupper($row_coordinacion->inspeccion_direccion).'<br >'.$row_coordinacion->departamento_nombre.' - '.$row_coordinacion->provincia_nombre.' - '.$row_coordinacion->distrito_nombre.'</div></td>
                                        <td style="background-color: lightgrey;" colspan="2"><div style="margin-left: 5px;">Contacto</div></td>
                                        <td colspan="4" height="8%"><div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px; position: absolute;">'.strtoupper(str_replace($order, $replace, $row_coordinacion->inspeccion_contacto)).'</div></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" colspan="2" rowspan="2"><div style="margin-left: 5px;">Inspeccion Ocular</div></td>
                                        <td style="background-color: lightgrey;" colspan="2" align="center">Fecha</td>
                                        <td style="background-color: lightgrey;" colspan="2" align="center">Hora</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">'.$row_coordinacion->inspeccion_fecha.'</td>
                                        <td colspan="2" align="center">'.$hora_final.'</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: grey;" colspan="6" align="center">Servicios</td>
                                        <td style="background-color: grey;" colspan="6" align="center">Observación</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="justify" valign="top" height="38%">
                                            <div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px;">'.$servicios.'</div>
                                        </td>
                                        <td colspan="6" rowspan="3" align="justify" valign="top">
                                            <div style="font-size: 0.85rem; margin-left: 5px; margin-right: 5px; position: absolute;">'.strtoupper(str_replace($order, $replace, $row_coordinacion->inspeccion_observacion)).'</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: lightgrey;" align="center" width="11.5%">Operaciones</td>
                                        <td width="5.1%"></td>
                                        <td style="background-color: lightgrey;" align="center" width="11.5%">Gerencia</td>
                                        <td width="5.1%"></td>
                                        <td style="background-color: lightgrey;" align="center" width="11.5%">Coordinación</td>
                                        <td width="5.1%"></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: grey;" colspan="6" align="center">Visto Bueno</td>
                                    </tr>
                                </tbody>
                            </table>
                        </body>
                        </html>';
        $this->pdf->set_paper('A4', 'landscape'); 
        $this->pdf->loadHtml($html_content);
        $this->pdf->render();
        $this->pdf->stream("Hoja de Coordinacion - ".$row_coordinacion->coordinacion_correlativo.".pdf", array("Attachment"=>0));
    }

    public function cambioFecha()
    {
        $resultAuditoria = $this->aud->search(array('action' => 'count', 'coordinacion_codigo' => $this->input->post('cambio_coordinacion_codigo'), 'coordinacion_estado' => '8'));

        $fields = array();
        if ($resultAuditoria > 0) {
            $fields = array(
                'historial_fechas' => array(
                    'coordinacion_id' => $this->input->post('cambio_coordinacion_codigo'),
                    'fecha_anterior' => $this->input->post('cambio_coordinacion_fecha_anterior'),
                    'fecha_nueva' => $this->input->post('cambio_coordinacion_nueva_fecha'),
                    'desripcion' => $this->input->post('cambio_coordinacion_motivo'),
                    'info_create_user' => $this->session->userdata('usu_id')
                ),
                'coordinacion' => array(
                    'entrega_al_cliente_fecha_nueva' => $this->input->post('cambio_coordinacion_nueva_fecha')
                )
            );
        } else {
            $fields = array(
                'historial_fechas' => array(
                    'coordinacion_id' => $this->input->post('cambio_coordinacion_codigo'),
                    'fecha_anterior' => $this->input->post('cambio_coordinacion_fecha_anterior'),
                    'fecha_nueva' => $this->input->post('cambio_coordinacion_nueva_fecha'),
                    'desripcion' => $this->input->post('cambio_coordinacion_motivo'),
                    'info_create_user' => $this->session->userdata('usu_id')
                ),
                'coordinacion' => array(
                    'entrega_al_cliente_fecha' => $this->input->post('cambio_coordinacion_nueva_fecha')
                )
            );
        }

        $result = $this->coord->inserCambioFecha($fields, $this->input->post('cambio_coordinacion_codigo'));

        $msg['success'] = false;
        if ($result > 0) {
            $msg['success'] = true;
        }
        
        echo json_encode($msg);
    }

    public function reproceso()
    {
        $fields = array(
            'actualizar' => array(
                'info_status' => '0'  
            ),
            'reproceso' => array(
                'coordinacion_id' => $this->input->post('coordinacion_codigo'),
                'motivo_id' => $this->input->post('reproceso_motivo'),
                'observacion' => $this->input->post('reproceso_descripcion'),
                'fecha_nueva' => $this->input->post('reproceso_nueva_fecha'),
                'info_create_user' => $this->session->userdata('usu_id'),
                'info_status' => '1'
            ),
            'coordinacion' => array(
                'estado_id' => '8',
                'entrega_al_cliente_fecha_nueva' => $this->input->post('reproceso_nueva_fecha')
            )
        );

        $result = $this->coord->inserReproceso($fields, $this->input->post('coordinacion_codigo'));

        $msg['success'] = false;
        if ($result > 0) {
            $msg['success'] = true;

            $result = $this->aud->search(array('action' => 'sheet', 'coordinacion_codigo' => $this->input->post('coordinacion_codigo')));
            //echo json_encode($result);
            if ($result->estado_id != '8') {
                $fields_auditoria = array(        
                    'aut_usu_id' => $this->session->userdata('usu_id'),
                    'aut_coor_id' => $this->input->post('coordinacion_codigo'),
                    'aut_coor_est' => '8'
                );

                $this->aud->insertCoordinacion($fields_auditoria);
            }
        }
        
        echo json_encode($msg);
    }

    public function imprimir()
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
                'coordinacion_riesgo' => $datos->coordinacion_riesgo,
                'coordinacion_fecha_tipo' => $datos->coordinacion_fecha_tipo,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta,
                
                'order' => $datos->order,
                'order_type' => $datos->order_type
            );

            $cabezera = $this->coord->search($filters);

            $body = ""; $iItem = 0;
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
                                    <td style='font-size: 0.5rem' $rowSpan>".(($this->input->post('num_page') - 1) * $this->input->post('quantity') + $iItem + 1)."</td>
                                    <td style='font-size: 0.5rem' $rowSpan><a id='lnkViewCoordinacion' href data-cotizacion='$rowItem->cotizacion_id' data-coordinacion='$rowItem->coordinacion_id'>$rowItem->coordinacion_correlativo</a></td>
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
                                    <td style='font-size: 0.5rem' $rowSpan>$rowItem->coordinacion_fecha_operaciones</td>
                                    <td style='font-size: 0.5rem' $rowSpan><div class='badge' style='background: $backgound;'>$rowItem->riesgo_nombre</div> </td>
                                </tr>";

                    $body .= $bodyInspeccion;
                    $iItem++;
                }
            }

            $data['coordinacion'] = $body;
            $data['view'] = 'coordinacion/print';
            $this->load->view('layout_impresion', $data);
        }
    }
    
    public function exportarReprocesoExcel()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));
            $filters =   array(
                'coordinacion_correlativo' => $datos->coordinacion_correlativo,
                'coordinacion_solicitante' => $datos->coordinacion_solicitante,
                'coordinacion_cliente' => $datos->coordinacion_cliente,
                'coordinacion_servicio_tipo' => $datos->coordinacion_servicio_tipo,
                'coordinacion_direccion' => $datos->coordinacion_direccion,
                'coordinacion_digitador' => $datos->coordinacion_digitador,
                'coordinacion_control_calidad' => $datos->coordinacion_control_calidad,
                'coordinacion_coordinador' => $datos->coordinacion_coordinador,
                'tipo_fecha' => $datos->tipo_fecha,
                'coordinacion_fecha_desde' => $datos->coordinacion_fecha_desde,
                'coordinacion_fecha_hasta' => $datos->coordinacion_fecha_hasta,
            );
            
            $objPHPExcel = new PHPExcel();

            //Ponemos Nombre a la Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Reporte Reprocesos');
            
            //Definimos Propiedades
            $objPHPExcel->getProperties()->setTitle('Reporte de Reprocesos')
                                        ->setCreator('Allemant & Asociados Peritos Valuadores')
                                        ->setLastModifiedBy('Allemant & Asociados Peritos Valuadores');
                                        
            //Combinación de celdas
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:L2');

            //Añadimos titlo del reporte
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'REPORTE DE REPROCESOS');
            
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
            
        
            
            //Configuramos el tamaño de los encabezados de las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20.7);


            //Añadimos los titulos a los encabezados de columnas
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', '#');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'COORD.');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'SOLICITANTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'CLIENTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'TIPO SERVICIO');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'DIGITADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'CONTROL DE CALIDAD');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'COORDINADOR');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'MOTIVO');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'FECHA');
            
            
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
            $cabezera = $this->coord->searchCoordinacionReprocesos($filters);
             $iItem = 0; $rowCount = 6;
            
              if ($cabezera != false) {
                foreach ($cabezera as $rowItem) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 5);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $rowItem->coordinacion_correlativo);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, strtoupper($rowItem->solicitante_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, strtoupper($rowItem->cliente_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, strtoupper($rowItem->servicio_tipo_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, strtoupper($rowItem->digitador_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, strtoupper($rowItem->control_calidad_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, strtoupper($rowItem->coordinador_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, strtoupper($rowItem->motivo_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $rowItem->motivo_fecha);
                    
                    
                    
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
                    $rowCount++;
                }
              }
            $fileName = 'Reporte de Reprocesos - ' . date('dmY-his') . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }
    

    public function exportarExcel()
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
                'coordinacion_riesgo' => $datos->coordinacion_riesgo,
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
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:P2');

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
            $objPHPExcel->getActiveSheet()->getStyle('B2:P2')->applyFromArray($style_title);

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
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O5:O6');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P5:P6');
            
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
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(9.7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(50.7);


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
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'FECHA DE ENTREGA AL CLIENTE');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'FECHA DE ENTREGA POR OPERACIONES');
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'RIESGO');
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'COMENTARIO (BITACORA)');

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
            $objPHPExcel->getActiveSheet()->getStyle('A5:P6')->applyFromArray($style_columns_headers);

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
                    
                    //BEGIN INSPECCION
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
                    //END INSPECCION

                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, strtoupper($rowItem->digitador_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, strtoupper($rowItem->control_calidad_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, strtoupper($rowItem->coordinador_nombre));
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $rowItem->coordinacion_fecha_entrega);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $rowItem->coordinacion_fecha_operaciones);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $rowItem->riesgo_nombre);

                    //BITACORA
                    $rowBitacora = $this->bit->search(array('action' => 'sheet', 'coordinacion_codigo' => $rowItem->coordinacion_id));
                    $comentario = $rowBitacora == false ? '' : $rowBitacora->bitacora_descripcion;
                    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $comentario);

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
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O' . $rowCount . ':O' . ($rowCount + $iItem - 1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P' . $rowCount . ':P' . ($rowCount + $iItem - 1));

                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':P' . ($rowCount + $iItem - 1))->applyFromArray($style_rows);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_adjust_text);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':F' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':H' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':P' . ($rowCount + $iItem - 1))->applyFromArray($style_rows_horizontal_center);
                    } else {
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount.':G' . $rowCount)->applyFromArray($style_rows_adjust_text);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':F' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':H' . $rowCount)->applyFromArray($style_rows_horizontal_center);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':P' . $rowCount)->applyFromArray($style_rows_horizontal_center);
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

    public function searchBitacora()
    {
        $filters_count = array('action' => 'count');

        $filters_find =   array(
            'coordinacion_codigo' => $this->input->post('coordinacion_codigo')
        );

        $data = array(
            'records_find_count' => $this->bit->search(array_merge($filters_count, $filters_find)),
            'records_find' => $this->bit->search($filters_find)
        );

        echo json_encode($data);
    }

    public function insertBitacora()
    {
        $field = array(
            'coordinacion_id' => $this->input->post('coordinacion_codigo'),
            'usuario_id' => $this->session->userdata('usu_id'),
            'descripcion' => $this->input->post('bitacora_decripcion')
        );

        $insert = $this->bit->insert($field);
        
        $msg['success'] = false;
        if ($insert > 0)
            $msg['success'] = true;

        echo json_encode($msg);
    }

    public function imprimirBitacora()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $datos = json_decode($this->input->post('data'));

            $filters =   array(
                'coordinacion_codigo' => $datos->coordinacion_codigo
            );

            $impresion = $this->bit->search($filters);
            $table_boddy = "";

            if ($impresion == false) {
                $table_boddy .= '<tr><td colspan="5">NO HAY REGISTROS</td></tr>';
            } else {
                $i = 1;
                foreach ($impresion as $row) {
                    $table_boddy .= '<tr>
                                        <td style="font-size: 0.7rem">'.$i.'</td>
                                        <td style="font-size: 0.7rem">'.$row->usuario_nombre.'</td>
                                        <td style="font-size: 0.7rem">'.strtoupper($row->bitacora_descripcion).'</td>
                                        <td style="font-size: 0.7rem">'.$row->bitacora_fecha.'</td>
                                        <td style="font-size: 0.7rem">'.$row->bitacora_hora.'</td>
                                    </tr>';
                    $i++;
                }
            }
            $data['coordinacion'] = $datos->coordinacion_correlativo;
            $data['bitacora'] = $table_boddy;
            $data['view'] = 'coordinacion/bitacora_print';
            $this->load->view('layout_impresion', $data);
        }
    }
}

/* End of file Coordinacion.php */
/* Location: ./application/controllers/coordinacion/Coordinacion.php */