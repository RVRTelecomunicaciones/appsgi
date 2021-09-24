<h2>REPORTE DE COORDINACIONES</h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="font-size: 0.5rem">#</th>
			<th style="font-size: 0.5rem">COORD.</th>
			<th style="font-size: 0.5rem">ESTADO</th>
			<th style="font-size: 0.5rem">SOLICITANTE</th>
			<th style="font-size: 0.5rem">CLIENTE</th>
			<th style="font-size: 0.5rem">TIPO DE SERVICIOS</th>
			<th style="font-size: 0.5rem" width="235">UBICACIÓN</th>
			<th style="font-size: 0.5rem">PERITO</th>
			<th style="font-size: 0.5rem">CONTROL DE CALIDAD</th>
			<th style="font-size: 0.5rem">COORDINADOR</th>
			<th style="font-size: 0.5rem" width="60">FECHA DE APROBACIÓN</th>
			<th style="font-size: 0.5rem" width="60">FECHA ENTREGA AL CLIENTE</th>
			<!--<th style="font-size: 0.5rem" width="60">NUEVA FECHA ENTREGA AL CLIENTE</th>-->
			<th style="font-size: 0.5rem" width="60">RIESGO</th>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $coordinacion;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>