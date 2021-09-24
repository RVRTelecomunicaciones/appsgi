<h2>REPORTE DE COTIZACIONES</h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="font-size: 0.5rem">#</th>
			<th style="font-size: 0.5rem">COD. COTIZACIÓN</th>
			<th style="font-size: 0.5rem" width="100">TIPO SERVICIO</th>
			<th style="font-size: 0.5rem">COORDINADOR</th>
			<th style="font-size: 0.5rem" width="100">VENDEDOR</th>
			<th style="font-size: 0.5rem">CLIENTE</th>
			<th style="font-size: 0.5rem">SOLICITANTE </th>
			<th style="font-size: 0.5rem">MONTO</th>
			<th style="font-size: 0.5rem" width="60">FECHA DE SOLICITUD</th>
			<th style="font-size: 0.5rem" width="60">FECHA DE  ENVÍO</th>
			<th style="font-size: 0.5rem" width="60">FECHA DE APROBACIÓN</th>
			<th style="font-size: 0.5rem" width="60">FECHA DE DESESTIMACIÓN</th>
			<th style="font-size: 0.5rem">ESTADO</th>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $cotizacion;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>