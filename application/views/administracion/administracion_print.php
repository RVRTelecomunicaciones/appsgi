<h2>REPORTE DE FACTURACIONES</h2>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="font-size: 0.5rem">#</th>
			<th style="font-size: 0.5rem" width="85">COD. COTIZACIÓN</th>
			<th style="font-size: 0.5rem">NÚMERO SERIE</th>
			<th style="font-size: 0.5rem" width="210">FACTURADO A</th>
			<th style="font-size: 0.5rem" width="120">TIPO SERVICIO</th>
			<th style="font-size: 0.5rem" width="160">CONCEPTO</th>
			<th style="font-size: 0.5rem" width="100">SUB TOTAL</th>
			<th style="font-size: 0.5rem" width="100">IGV</th>
			<th style="font-size: 0.5rem" width="100">TOTAL</th>
			<th style="font-size: 0.5rem" width="80">FECHA DE EMISIÓN</th>
			<th style="font-size: 0.5rem" width="80">FECHA DE PAGO</th>
			<th style="font-size: 0.5rem" width="80">ESTADO</th>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $facturaciones;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>