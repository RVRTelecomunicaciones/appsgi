<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="SGI, SGI, SGI Software, Sistema Gestion">
    <meta name="Russell F. Vergara Rojas" content="Dashboard">
    <link rel="shortcut icon" href="assets/images/fa
    <title>SGI - Sistema de Gestion</title>vicon_1.ico">
    <?php $this->load->view("includes/include_style"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />


</head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view("includes/topbar"); ?>
            <?php $this->load->view("includes/leftsidebar"); ?>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <?php $this->load->view($view);?>
                    </div>
                    <!-- end row -->
                </div>
                <footer class="footer text-right">
                    2017 © Allemant Peritos Valuadores SAC
                </footer>
                <!-- end container -->
            </div>
            <!-- end content -->

        </div>
        <!-- sample modal content -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"
             data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Registro de Tasaciones</h4>
                    </div>
                    <div class="modal-body">
                        <a class="btn btn-block btn--md btn-primary waves-effect waves-light" id="btnAddTerreno" href="<?= base_url('tasaciones/tasaciones/addTasacionesCasa'); ?>" role="button">TERRENO</a>
                        <a class="btn btn-block btn--md btn-primary waves-effect waves-light" id="btnAddCasa" href="<?= base_url('tasaciones/addTasacionesCasa'); ?>" role="button">CASA</a>
                        <a class="btn btn-block btn--md btn-primary waves-effect waves-light" id="btnAddDepa" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">DEPARTAMENTO</a>
                        <a class="btn btn-block btn--md btn-primary waves-effect waves-light" id="btnAddLocalComercial" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">LOCAL COMERCIAL</a>
                        <a class="btn btn-block btn--md btn-primary waves-effect waves-light" id="btnAddTerreno" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">LOCAL INDUSTRIAL</a>
                        <a class="btn btn-block btn--md btn-primary waves-effect waves-light" id="btnAddTerreno" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">OFICINA</a>
                        <a class="btn btn-block btn--md btn-success waves-effect waves-light" id="btnAddTerreno" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">VEHICULO</a>
                        <a class="btn btn-block btn--md btn-success waves-effect waves-light" id="btnAddTerreno" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">MAQUINARIA</a>
                        <a class="btn btn-block btn--md btn-danger waves-effect waves-light" id="btnAddTerreno" href="<?= base_url('tasaciones/tasaciones_casa_add'); ?>" role="button">NO REGISTRAR LA TASACIÓN</a>
                        <button id="btnAddTerreno" type="button" class="btn btn-block btn--md btn-primary waves-effect waves-light">TERRENO</button>s
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <?php $this->load->view("includes/include_script"); ?>
        <?php $this->load->view("includes/datatable_script"); ?>
        <?php $this->load->view("tasaciones/include/tasacion_script"); ?>
        <script>
            var resizefunc = [];
        </script>
    </body>
</html>