<div align="center"><h2>RESUMEN DE COORDINACIONES</h2></div>
<div class="row">
	<div class="col-md-12">
		<div style="font-size: 1rem" align="center">
			<?php 
				if ($filtros['coordinacion_fecha_desde'] != '' && $filtros['coordinacion_fecha_hasta'] != '') {
					//echo "Filtrado por fecha de creación: <br>";
					echo $filtros['coordinacion_fecha_tipo'] == '1' ? 'Filtrado por: <strong>FECHA DE ENTREGA</strong>' : 'Filtrado por: <strong>FECHA DE CREACIÓN</strong>';
					echo "<br>";
					echo "DESDE: <strong>" . date("d-m-Y",strtotime($filtros['coordinacion_fecha_desde'])) . "</strong> - HASTA: <strong>" . date("d-m-Y",strtotime($filtros['coordinacion_fecha_hasta'])) . "</strong>";
				}
			?>
		</div>
	</div>
</div>
<br>
<table class="table table-bordered">
	<thead>
        <tr>
			<th>POR COORDINAR</th>
			<th>EN INSPECCIÓN</th>
			<th>EN ELABORACIÓN</th>
			<th>EN ESPERA</th>
			<th>POR APROBAR</th>
			<th>TERMINADO</th>
			<th>DESESTIMADO</th>
			<th>REPROCESO</th>
			<th>TOTAL</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $estados['coordinar'] ?></td>
			<td><?= $estados['inspeccion'] ?></td>
			<td><?= $estados['elaboracion'] ?></td>
			<td><?= $estados['espera'] ?></td>
			<td><?= $estados['aprobar'] ?></td>
			<td><?= $estados['terminado'] ?></td>
			<td><?= $estados['desestimado'] ?></td>
			<td><?= $estados['reproceso'] ?></td>
			<td><?= $estados['total'] ?></td>
		</tr>
	</tbody>
</table>
<!--<div class="row" style="page-break-after: always;">
	<div class="col-12">
		<table class="table table-bordered" >
			<thead>
				<tr>
					<th colspan="5">ENTREGADAS A TIEMPO</th>
					<th><?= $estados['a_tiempo'] ?></th>
				</tr>
				<tr>
					<th width="20">#</th>
					<th width="60">COORD.</th>
					<th>SOLICITANTE</th>
					<th>CLIENTE</th>
					<th width="80">FECHA ENTREGA</th>
					<th width="80">FECHA TERMINADO</th>
				</tr>
			</thead>
			<tbody>
				<?php
					/*$i = 1;
					foreach ($listATiempo as $row) {
						echo '<tr>
								<td>'.$i.'</td>
								<td>'.$row['coordinacion_correlativo'].'</td>
								<td>'.$row['solicitante_nombre'].'</td>
								<td>'.$row['cliente_nombre'].'</td>
								<td>'.$row['fecha_entrega'].'</td>
								<td>'.$row['fecha_terminado'].'</td>
							</tr>';
						$i++;
					}*/
				?>
			</tbody>
		</table>
	</div>
	<div class="col-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="5">APROBADAS FUERA DE TIEMPO</th>
					<th><?= $estados['retraso'] ?></th>
				</tr>
				<tr>
					<th width="20">#</th>
					<th width="60">COORD.</th>
					<th>SOLICITANTE</th>
					<th>CLIENTE</th>
					<th width="80">FECHA ENTREGA</th>
					<th width="80">FECHA TERMINADO</th>
				</tr>
			</thead>
			<tbody>
				<?php
					/*$i = 1;
					foreach ($listRetraso as $row) {
						echo '<tr>
								<td>'.$i.'</td>
								<td>'.$row['coordinacion_correlativo'].'</td>
								<td>'.$row['solicitante_nombre'].'</td>
								<td>'.$row['cliente_nombre'].'</td>
								<td>'.$row['fecha_entrega'].'</td>
								<td>'.$row['fecha_terminado'].'</td>
							</tr>';
						$i++;
					}*/
				?>
			</tbody>
		</table>
	</div>
</div>-->
<hr>

<div align="center"><h2>COORDIANCIONES CON OBSERVACIONES: <?= $countReprocesos ?></h2></div>
<div class="row">
<?php
	$i = 1;
	foreach ($motivos as $row) {
?>
	<div class="col-4">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="85%"><?php echo strtoupper($row->motivo_nombre); ?></th>
					<td width="15%">
						<?php
							if (!empty($auditoriaReprocesos)) {
								$arr = array();
								foreach ($auditoriaReprocesos as $rowAud) {
									if ($row->motivo_id == $rowAud->motivo_id) {
										array_push(
											$arr,
											array(
												'coordinacion_correlativo' => $rowAud->coordinacion_correlativo
											)
										);
									}
								}
								echo count($arr);
							} else {
								echo '0';
							}
						?>
					</td>
				</tr>
				<!--<tr>
					<th>COORD</th>
					<th>SOLICITANTE</th>
					<th>CLIENTE</th>
				</tr>-->
			</thead>
			<!--<tbody>
				<?php
					if (!empty($auditoriaReprocesos)) {
						$j = 1;
						foreach ($auditoriaReprocesos as $rowAud) {
							
							if ($row->motivo_id == $rowAud->motivo_id) {
				?>
								<tr>
									<td><?php echo $rowAud->coordinacion_correlativo; ?></td>
									<td><?php echo $rowAud->solicitante_nombre; ?></td>
									<td><?php echo $rowAud->cliente_nombre; ?></td>
								</tr>
				<?php
							} /*else {
				?>
								<tr>
									<td colspan="3">NO HAY REGISTROS</td>
								</tr>
				<?php
							}*/
							$j++;
						}
					} else {
				?>
						<tr>
							<td colspan="3">NO HAY REGISTROS</td>
						</tr>
				<?php
					}
				?>
			</tbody>-->
		</table>
	</div>
<?php
		$i++;
	}
?>
</div>
<?php //$this->load->view("includes/include_script_print"); ?>