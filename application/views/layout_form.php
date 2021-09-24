<!-- - var menuBorder = true-->
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>SGI</title>
    <link rel="apple-touch-icon" href="<?php echo base_url();?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <?php $this->load->view("includes/include_style_form"); ?>
</head>

<body data-open="click" data-menu="vertical-overlay-menu" data-col="2-columns" class="vertical-layout vertical-overlay-menu 2-columns   menu-expanded fixed-navbar">
    <?php $this->load->view("includes/navbar"); ?>
    <?php $this->load->view("includes/menu"); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <?php $this->load->view($view);?>
        </div>
    </div>
    <?php $this->load->view("includes/footer"); ?>
</body>
</html>