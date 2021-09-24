<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-border">
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <li class=" navigation-header">
                <span>General</span>
                <i data-toggle="tooltip" data-placement="right" data-original-title="General" class=" ft-minus"></i>
            </li>
            <!-- MANTENIMIENTO DE TABLAS -->
            <li class="nav-item has-sub <?= buscarPermisoLectura(1, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="#"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">Mantenimiento</span></a>
                <ul class="menu-content">
                    <li class="<?= buscarPermisoLectura(2, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('usuario')?>" class="menu-item">Usuarios</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(3, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('rol')?>" class="menu-item">Roles</a>
                    </li>
                </ul>
            </li>

            <!-- ADMINISTRACIÓN -->
            <li class=" nav-item has-sub <?= buscarPermisoLectura(4, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="#"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">Administración</span></a>
                <ul class="menu-content">
                    <li class="<?= buscarPermisoLectura(5, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('administracion/facturaciones')?>" class="menu-item">Facturación</a>
                    </li>
                    <!--<li>
                        <a href="#" class="menu-item">Pagos</a>
                        <ul class="menu-content">
                            <li>
                                <a href="<?= base_url('administracion/pago_perito')?>" class="menu-item">Perito</a>
                            </li>
                            <li>
                                <a href="<?= base_url('administracion/pago_vendedor')?>" class="menu-item">Vendedor</a>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </li>

            <!-- COORDINACION -->
            <li class=" nav-item has-sub <?= buscarPermisoLectura(6, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="#"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">Coordinacion</span></a>
                <ul class="menu-content">
                    <li class="<?= buscarPermisoLectura(7, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('cotizacion')?>" class="menu-item">Cotizaciones</a>
                    </li>
                    <?php if ($this->session->userdata('usu_id') == '67') { ?>
                    <li class="<?= buscarPermisoLectura(8, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('coordinacion')?>" class="menu-item">Coordinaciones</a>
                    </li>
                    <?php }?>
                    <li class="<?= buscarPermisoLectura(8, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('coordinacion/coordinaciones/listado')?>" class="menu-item">Coordinaciones</a>
                    </li>
                    
                    <li class="<?= buscarPermisoLectura(9, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('inspeccion')?>" class="menu-item">Inspecciones</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(10, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('facturacion/informacion_facturacion')?>" class="menu-item">Información de Facturación</a>
                    </li>
                </ul>
            </li>

            <!-- OPERACIONES -->
            <li class=" nav-item has-sub <?= buscarPermisoLectura(11, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="#"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">Operaciones</span></a>
                <ul class="menu-content">
                    <?php if ($this->session->userdata('usu_id') == '67') { ?>
                    <!--<li class="<?= buscarPermisoLectura(12, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('coordinacion')?>" class="menu-item">Coordinaciones</a>
                    </li>-->
                    <?php }?>
                    <li class="<?= buscarPermisoLectura(12, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('operaciones/coordinaciones/listado')?>" class="menu-item">Coordinaciones</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(13, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('operaciones/inspecciones/listado')?>" class="menu-item">Inspecciones</a>
                    </li>
                    <!--<li>
                        <a href="<?= base_url('operaciones/operaciones/listado')?>" class="menu-item">Operaciones</a>
                    </li>-->
                    <li>
                        <a href="#" class="menu-item">Carga</a>
                        <ul class="menu-content">
                            <li>
                                <a href="<?= base_url('operaciones/carga/digitador')?>" class="menu-item">Digitador</a>
                            </li>
                            <li>
                                <a href="<?= base_url('operaciones/carga/control_calidad')?>" class="menu-item">Control Calidad</a>
                            </li>
                            <li>
                                <a href="<?= base_url('operaciones/carga/auditoria')?>" class="menu-item">Auditoria</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!-- TASACIONES -->
			<li class="nav-item has-sub <?= buscarPermisoLectura(14, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="#"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">Tasaciones</span></a>
                <ul class="menu-content">
                    <?php if ($this->session->userdata('usu_id') == '67') { ?>
                    <li class="<?= buscarPermisoLectura(15, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a id="lnkPorRegistrar" href="<?= base_url('tasacion/por_registrar')?>" class="menu-item"><i class="fa fa-plus"></i> Por Registrar</a>
                    </li>
                    <?php } ?>
                    <li class="<?= buscarPermisoLectura(15, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a id="lnkPorRegistrar" href="<?= base_url('tasaciones/por-registrar/listado')?>" class="menu-item"><i class="fa fa-plus"></i> Por Registrar</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(16, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="#" class="menu-item"><i class="fa fa-database"></i> Registradas</a>
                        <ul class="menu-content">
                            <li class="<?= buscarPermisoLectura(17, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                                <a href="<?= base_url('tasacion/inmuebles')?>" class="menu-item"><i class="fa fa-map-signs"></i> Inmuebles</a>
                            </li>
                            <li class="<?= buscarPermisoLectura(18, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                                <a href="<?= base_url('tasacion/vehiculos')?>" class="menu-item"><i class="fa fa-car"></i> Vehículos</a>
                            </li>
                            <li class="<?= buscarPermisoLectura(19, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                                <a href="<?= base_url('tasacion/maquinarias')?>" class="menu-item"><i class="fa fa-steam"></i> Maquinarias</a>
                            </li>
                            <li class="<?= buscarPermisoLectura(20, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                                <a href="<?= base_url('tasacion/otros')?>" class="menu-item"><i class="fa fa-cubes"></i> Otros</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!-- REPORTES -->
            <li class="nav-item has-sub <?= buscarPermisoLectura(21, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="#"><i class="ft-file-text"></i><span data-i18n="" class="menu-title">Reportes</span></a>
                <ul class="menu-content">
                    <li class="<?= buscarPermisoLectura(22, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('reporte/administracion')?>" class="menu-item">Administración</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(23, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('reporte/coordinacion')?>" class="menu-item">Coordinación</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(24, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('reporte/operaciones')?>" class="menu-item">Operaciones</a>
                    </li>
                    <li class="<?= buscarPermisoLectura(27, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                        <a href="<?= base_url('reporte/sistemas')?>" class="menu-item">Sistemas</a>
                    </li>
                </ul>
            </li>

            <!-- MAPA -->
			<li class=" nav-item <?= buscarPermisoLectura(25, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="<?= base_url('tasaciones/tasacionesCasaMapa')?>" target="_BLANK"><i class="ft-map"></i><span data-i18n="" class="menu-title">Mapa</span></a>
            </li>

            <!-- MAPA ANTIGUO -->
            <li class=" nav-item <?= buscarPermisoLectura(26, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">
                <a href="<?= base_url('tasaciones/tasacionesCasaMapaAnterior')?>" target="_BLANK"><i class="ft-map"></i><span data-i18n="" class="menu-title">Mapa Anterior</span></a>
            </li>
        </ul>
    </div>
</div>

<script>
    /*const lnkPorRegistrar = document.getElementById('lnkPorRegistrar');
    lnkPorRegistrar.addEventListener('click', e => {
        e.preventDefault();
        swal({
            text: "Módulo en mantenimiento ...",
            timer: 3000,
            buttons: false
        });
    });*/
</script>