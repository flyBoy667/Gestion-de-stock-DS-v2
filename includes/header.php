<?php
$link = $_SERVER['REQUEST_URI'];

$website_url = "/stock_final/";

//echo $link;
if ($link == $website_url . "dashboard.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "user.php" || $link == $website_url . "reglages.php") {
    $menu = 'class=\'nav-item has-treeview menu-open\'';
}
if ($link == $website_url . "user.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "reglages.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "categorie.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "produit.php") {
    $active = 'class=\'nav-link active\'';
}

if ($link == $website_url . "client.php" || $link == $website_url . "fournisseur.php") {
    $menu = 'class=\'nav-item has-treeview menu-open\'';
}
if ($link == $website_url . "client.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "fournisseur.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "liste_achat.php" || $link == $website_url . "achat_fournisseur.php") {
    $menu = 'class=\'nav-item has-treeview menu-open\'';
}
if ($link == $website_url . "liste_achat.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "achat_fournisseur.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "liste_vente.php" || $link == $website_url . "vente.php") {
    $menu = 'class=\'nav-item has-treeview menu-open\'';
}
if ($link == $website_url . "liste_vente.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "vente.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "depense.php") {
    $active = 'class=\'nav-link active\'';
}
if ($link == $website_url . "rapport.php") {
    $active = 'class=\'nav-link active\'';
}
$url_en_cours = substr($link, strripos($link, "/") + 1);
$url_en_cours = str_replace(".php", "", str_replace("-", " ", $url_en_cours));
$url_en_cours = strtoupper(substr($url_en_cours, 0, 1)) . substr($url_en_cours, 1);
//echo $url_en_cours;
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>D&S Stock <?php echo $url_en_cours; ?></title>
    <!-- Jquery-ui -->
    <link rel="stylesheet" href="plugins/jquery-ui/jquery-ui.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Icon dans le navigateur-->
    <link rel="icon" type="image/png" href="dist/img/icon_stock.png"/>
    <!-- Google Font: Source Sans Pro -->
    <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
</head>

<body class="hold-transition sidebar-mini" style=" font-size: 15px !important;">
<div class="wrapper">
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="dashboard.php" class="brand-link">
            <img src="dist/img/logo_stock.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">D&S stock 2</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/admin.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">DIALLO Cheick</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <?php include('includes/menu.php') ?>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><?php if ($url_en_cours == "Index") echo("Tableau de bord"); else echo $url_en_cours; ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><?php if ($url_en_cours == "Index") echo("Tableau de bord"); else echo $url_en_cours; ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">