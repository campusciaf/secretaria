<?php
//Activamos el almacenamiento en el buffer
date_default_timezone_set("America/Bogota");	
ob_start();
session_start();
if(!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 999;
    $submenu = 1;
    require 'header.php';
	if($_SESSION['sofitransacciones']==1){
?>
<!-- <div id="precarga" class="precarga"></div> -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Estudiantes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Panel</a></li>
                        <li class="breadcrumb-item active">Resultados</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="panel-body table-responsive" id="listardatos"></div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

	<!-- Button trigger modal -->
</div>
</div><!-- /.content-wrapper -->
<?php
	}else{
        require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/idiomas_asignar_grupo.js"></script>