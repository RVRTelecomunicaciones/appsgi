<h2>BITACORA DE LA COORDINACIÓN <strong><?= $coordinacion; ?></strong></h2>
<table class="table table-bordered">
	<thead>
        <tr>
            <th style="font-size: 0.8rem" >#</th>
            <th style="font-size: 0.8rem" >USUARIO.</th>
            <th style="font-size: 0.8rem" >DESCRIPCIÓN</th>
            <th style="font-size: 0.8rem" width="80">FECHA</th>
            <th style="font-size: 0.8rem" width="80">HORA</th>
        </tr>
	</thead>
	<tbody>
		<?php
			echo $bitacora;
		?>
		<?php $this->load->view("includes/include_script_print"); ?>
	</tbody>
</table>