<h2>REPORTE DE COORDINACIONES</h2>
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
            <th style="font-size: 0.5rem" width="80" rowspan="2">FECHA DE ENTREGA AL CLIENTE</th>
            <th style="font-size: 0.5rem" width="80" rowspan="2">FECHA DE ENTREGA POR OPERACIONES</th>
            <th style="font-size: 0.5rem" rowspan="2">RIESGO</th>
        </tr>
        <tr>
            <th style="font-size: 0.5rem">UBICACIÓN</th>
            <th style="font-size: 0.5rem" width="80">FECHA</th>
            <th style="font-size: 0.5rem">PERITO</th>
        </tr>
	</thead>
	<tbody>
		<?php
			echo $coordinacion;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>