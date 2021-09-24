<h2>REPORTE DE FACTURACIONES</h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="font-size: 0.5rem">#</th>
			<th style="font-size: 0.5rem" width="80">PROYECTO</th>
			<th style="font-size: 0.5rem">CLIENTE</th>
			<th style="font-size: 0.5rem">TIPO SERVICIO</th>
			<th style="font-size: 0.5rem" width="90">COSTO GENERAL PROYECTO</th>
			<th style="font-size: 0.5rem">PERITO</th>
			<th style="font-size: 0.5rem" width="90">COSTO GENERAL PERITO</th>
			<th style="font-size: 0.5rem">COMPROBANTE</th>
			<th style="font-size: 0.5rem">ESTADO</th>
			<th style="font-size: 0.5rem" width="80">FECHA EMISIÓN</th>
			<th style="font-size: 0.5rem" width="100">IMPORTE FACTURADO</th>
			<th style="font-size: 0.5rem" width="100">ABONO PERITO</th>
			<th style="font-size: 0.5rem">ESTADO PAGO PERITO</th>
			<th style="font-size: 0.5rem" width="60">FECHA PAGO PERITO</th>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $pago_perito;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>