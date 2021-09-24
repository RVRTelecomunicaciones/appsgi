<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark bg-primary navbar-shadow navbar-brand-center">
<div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a href="<?= base_url()?>" class="navbar-brand">
                        <img alt="stack admin logo" src="<?= base_url() ?>app-assets/images/logo/stack-logo.png"
                             class="brand-logo">
                        <h2 class="brand-text">SGI</h2>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div id="navbar-mobile" class="collapse navbar-collapse">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i></a></li>
                </ul>
                <ul class="nav navbar-nav float-right">

                    <li class="dropdown dropdown-notification nav-item">
                        <a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon ft-bell"></i>
                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up notificacion"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0">
                                    <span class="grey darken-2">Notificaciones para hoy</span>
                                    <span class="notification-tag badge badge-default badge-danger float-right m-0 readnotificacion"></span>
                                </h6>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                <span class="avatar avatar-online">
                  <img src="<?= base_url() ?>app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span>
                            <span id="user_codigo" class="hidden"><?php echo strtoupper($this->session->userdata('usu_id')); ?></span>
                            <span id="user_name" class="user-name"><?php echo strtoupper($this->session->userdata('usu_nombre')); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="ft-user"></i> Editar Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url() ?>intranet/salir" class="dropdown-item"><i class="ft-power"></i> Cerrar sesion</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


