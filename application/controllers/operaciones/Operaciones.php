<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		/*MODELOS*/
        $this->load->model('coordinacion/coordinacion_m', 'coord');
        $this->load->model('coordinador/coordinador_m', 'coordi');
        $this->load->model('calidad/calidad_m', 'ccal');
        $this->load->model('perito/perito_m', 'per');
        $this->load->model('estado/estado_m', 'est');
        $this->load->model('tservicio/TServicio_m', 'tps');
        $this->load->model('inspeccion/inspeccion_m', 'insp');
        $this->load->model('coordinador/coordinador_m', 'coor');
	}

	public function digitador()
	{
		$logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = $this->uri->segment(1);
            $data['tipo_servicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            //$data['control_calidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'operaciones/digitador';
            $this->load->view('layout', $data);
        }
	}

    public function control_calidad()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = $this->uri->segment(1);
            $data['tipo_servicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['control_calidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'operaciones/control_calidad';
            $this->load->view('layout', $data);
        }
    }

    public function auditoria()
    {
        $logued = $this->session->userdata('login');

        if (!isset($logued) || $logued != true) {
            redirect('intranet/acceso');
        } else {
            $data['modulo'] = $this->uri->segment(1);
            $data['tipo_servicio'] = $this->tps->servicioTipoReporte();
            $data['perito'] = $this->per->searchPerito(array('accion' => 'filtros', 'perito_estado' => '1'));
            $data['control_calidad'] = $this->ccal->searchControlCalidad(array('accion' => 'filtros', 'control_calidad_estado' => '1'));
            $data['coordinador'] = $this->coor->coordinadorSearch(array('accion' => 'filtros'));
            $data['view'] = 'operaciones/auditoria';
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
            /*'coordinacion_fecha_tipo' => $this->input->post('coordinacion_fecha_tipo'),
            'coordinacion_fecha_desde' => $this->input->post('coordinacion_fecha_desde'),
            'coordinacion_fecha_hasta' => $this->input->post('coordinacion_fecha_hasta'),*/
            'operaciones_area' => $this->input->post('operaciones_area'),
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
                                    <td $rowSpan><div class='badge' style='background: $backgound;'>$rowItem->riesgo_nombre</div> </td>
                                    <td $rowSpan>
                                        <div class='btn-group'>
                                            <button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                            <div class='dropdown-menu'>";
                                    if ($rowItem->proceso_estado == 0) {
                                    	$body .= "<a id='lnkInicio' href class='dropdown-item' data-coordinacion='$rowItem->coordinacion_id'>Iniciar</a>";
                                    } else if ($rowItem->proceso_estado == 1 || $rowItem->proceso_estado == 2) {
                                    	$body .= "<a id='lnkFinalizar' href class='dropdown-item' data-proceso='$rowItem->proceso_id' data-coordinacion='$rowItem->coordinacion_id'>Finalizar</a>";
                                    }

                                    if ($rowItem->proceso_count_observaciones > 0) {
                                        $body .= "<a id='lnkObservaciones' href class='dropdown-item' data-proceso='$rowItem->proceso_id' data-coordinacion='$rowItem->coordinacion_id'>Observaciones</a>";
                                    }

                                    
                    $body .=        "       </div>
                                        </div>
                                    </td>
                                </tr>";

                    $body .= $bodyInspeccion;
                    $iItem++;
                }
            }
        }
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
                'records_all_count' => $this->coord->search(
                    array_merge(
                        $filters_count,
                        array(
                            'coordinacion_digitador' => $this->input->post('coordinacion_digitador'),
                            'coordinacion_control_calidad' => $this->input->post('coordinacion_control_calidad'),
                            'coordinacion_estado' => $this->input->post('coordinacion_estado'),
                            'operaciones_area' => $this->input->post('operaciones_area')
                        )
                    )
                ),
                'records_find_count' => $this->coord->search(array_merge($filters_count, $filters_find)),
                'records_find' => $body
            );
        /*}*/

        echo json_encode($data);
	}
}

/* End of file Operaciones.php */
/* Location: ./application/controllers/operaciones/Operaciones.php */