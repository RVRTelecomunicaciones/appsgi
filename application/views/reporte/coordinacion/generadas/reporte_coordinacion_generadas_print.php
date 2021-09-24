<h2>REPORTE DE COORDINACIONES GENERADAS</h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th style="font-size: 0.5rem" width="60">COORD.</th>
			<th style="font-size: 0.5rem" width="100">ESTADO</th>
			<th style="font-size: 0.5rem" width="150">SOLICITANTE</th>
			<th style="font-size: 0.5rem" width="150">CLIENTE</th>
			<th style="font-size: 0.5rem" width="150">TIPO SERVICIO</th>
			<th style="font-size: 0.5rem">UBICACIÓN</th>
			<th style="font-size: 0.5rem" width="100">PERITO</th>
			<th style="font-size: 0.5rem" width="100">CONTROL DE CALIDAD</th>
			<th style="font-size: 0.5rem" width="100">COORDINADOR</th>
			<th style="font-size: 0.5rem" width="80">FECHA</th>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $coordinacion;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>