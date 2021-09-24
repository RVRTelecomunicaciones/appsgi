<h2>REPORTE DE INSPECCIONES</h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="font-size: 0.5rem">#</th>
			<th style="font-size: 0.5rem">COORD.</th>
			<th style="font-size: 0.5rem">SOLICITANTE</th>
			<th style="font-size: 0.5rem">CLIENTE</th>
			<th style="font-size: 0.5rem">TIPO SERVICIO</th>
			<th style="font-size: 0.5rem" width="250">DIRECCIÓN</th>
			<th style="font-size: 0.5rem">PERITO</th>
			<th style="font-size: 0.5rem">COORDINADOR</th>
			<th style="font-size: 0.5rem" width="60">FECHA</th>
			<th style="font-size: 0.5rem" width="60">HORA</th>
			<!--<th style="font-size: 0.5rem">ESTADO</th>-->
		</tr>
	</thead>
	<tbody>
		<?php
			echo $inspeccion;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>