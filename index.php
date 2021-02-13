<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php");
date_default_timezone_set("America/Guayaquil");
set_time_limit(0);
$conn=getDatabaseConnection();
$nivel_acceso=10;
$Numopc=10;
if ( $_COOKIE['usuario_nivel']==""){
    header ("Location: /main");
    exit;
}
$Ocole=new CMySQL("select * from datos where idinstitucion=?","bddinstituciones","186.4.154.145",array($_COOKIE['idinst']));
$Oinicial=explode(" ",str_replace('"',"", $Ocole->Row['nombre']));
for($i=0;$i<count($Oinicial);$i++)
    $sini.=substr(trim($Oinicial[$i]),0,1);

$forma=($_GET['forma']=="")?"ModAlumnos.php":$_GET['forma'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $_COOKIE['nombre']?> |  MATRICULAS ONLINE</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="icon" type="image/jpeg" href="data:image/jpeg;base64,  <?php echo base64_encode($Ocole->Row['logo'])?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->

    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">

    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validation/additional-methods.min.js"></script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="alertify/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="alertify/ionicons.min.css" rel="stylesheet" type="text/css" />
    <script src="alertify/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="alertify/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="alertify/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="alertify/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

    <!--
        RTL version
    -->
    <link rel="stylesheet" href="alertify/alertify.rtl.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="alertify/default.rtl.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="alertify/semantic.rtl.min.css"/>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index.php?forma=ModAlumnos.php" class="nav-link"><i class="fas fa-edit"></i> Actualizar Datos</a>
            </li>
            <?php
                if ($Ocole->Row['notas'] == 1){
                    ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="index.php?forma=ModNotas.php" class="nav-link"><i class="fas fa-table"></i> Notas</a>
                    </li>
            <?php
                }
            ?>
        </ul>

        <!-- SEARCH FORM -->


    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
            <img src="data:image/jpeg;base64,  <?php echo base64_encode($Ocole->Row['logo'])?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo $sini?></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/<?php echo ($_COOKIE['sexo']=='H')?"avatar5.png":"avatar2.png"?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $_COOKIE['alumno']?></a>
                    <a href="#" class="d-block"><?php  echo "CURSO: ".$_COOKIE['curso']?></a>

                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Mis Opciones
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="index.php?forma=ModAlumnos.php" class="nav-link active">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>Actualizar Datos</p>
                                </a>
                            </li>
                            <?php
                            if ($Ocole->Row['notas'] == 1){
                                ?>
                                <li class="nav-item">
                                    <a href="index.php?forma=ModNotas.php" class="nav-link active">
                                        <i class="nav-icon fas fa-table"></i>
                                        <p>Notas</p>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="nav-item">
                                <a href="usuarios/aut_logout.php" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Salir</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php
            if($forma!="") {
                include($forma);
            }
        ?>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">


        <div align="center"><img src="images/logo2.jpg"  width="50" height="50" border="0" />  </div>
        <div align="center"><strong>Copyright Â© 2020 All rights reserved | E-mail: info@grupoprosoft.net</strong></div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- GENERADOR DE PDFs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.0/jspdf.umd.min.js"></script>
<script>
    $("#imprimir").click(function(){
        var doc = new jsPDF()
        doc.text('Hello world!', 10, 10)
        doc.save('a4.pdf')
    })
</script>
</body>
</html>
