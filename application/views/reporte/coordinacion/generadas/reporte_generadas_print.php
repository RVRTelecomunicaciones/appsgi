<div align="center"><h2>REPORTE DE COORDINACIONES GENERADAS</h2></div>
<div class="row">
	<div class="col-md-12">
		<div style="font-size: 1rem" align="center">
			<?php 
				if ($filtros['coordinacion_fecha_desde'] != '' && $filtros['coordinacion_fecha_hasta'] != '') {
					//echo "Filtrado por fecha de creación: <br>";
					echo "DESDE: <strong>" . date("d-m-Y",strtotime($filtros['coordinacion_fecha_desde'])) . "</strong> - HASTA: <strong>" . date("d-m-Y",strtotime($filtros['coordinacion_fecha_hasta'])) . "</strong>";
				}
			?>
		</div>
	</div>
</div>
<table class="table table-bordered">
	<thead>
		<tr>
            <th style="font-size: 0.5rem" rowspan="2">#</th>
            <th style="font-size: 0.5rem" rowspan="2">COORD.</th>
            <th style="font-size: 0.5rem" rowspan="2">ESTADO</th>
            <th style="font-size: 0.5rem" rowspan="2">SOLICITANTE</th>
            <th style="font-size: 0.5rem" rowspan="2">CLIENTE</th>
            <th style="font-size: 0.5rem" rowspan="2">TIPO SERVICIO</th>
            <th style="font-size: 0.5rem" colspan="3">INSPECCIÓN</th>
            <th style="font-size: 0.5rem" rowspan="2">DIGITADOR</th>
            <th style="font-size: 0.5rem" rowspan="2">CONTROL DE CALIDAD</th>
            <th style="font-size: 0.5rem" rowspan="2">COORDINADOR</th>
            <th style="font-size: 0.5rem" width="60" rowspan="2">FECHA DE ENTREGA</th>
            <th style="font-size: 0.5rem" width="60" rowspan="2">FECHA DE CREACIÓN</th>
        </tr>
        <tr>
            <th style="font-size: 0.5rem">DIRECCIÓN</th>
            <th style="font-size: 0.5rem" width="60">FECHA</th>
            <th style="font-size: 0.5rem">PERITO</th>
        </tr>
	</thead>
	<tbody>
		<?= $coordinacion ?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>
<div style="font-size: 0.65rem" align="left">Total de coordinaciones: <?= $cantidad ?> </div>