<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
	$menu = 10;
	$submenu = 1003;
    require 'header.php';
	if($_SESSION['promedio']==1){  
?>
<div id="precarga" class="precarga" style="display: none"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Consulta promedio administrativo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Consulta promedio administrativo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px;">
                        <div class="form-group col-xs-12 col-sm-4 col-md-6 col-lg-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="far fa-user-circle"> </i> </span>
                                </div>
                                <input type="number" class="form-control" id="cedula" placeholder="Número de identificación">
                                <div class="input-group-append">
                                    <input type="submit" value="Consultar" onclick="consulta()" class="btn btn-success" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row datos"></div>
                    <div class="row" id="table" style="padding: 0;">
                    </div>                   
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
</div><!-- /.content-wrapper -->
<?php
	}else{
        require 'noacceso.php';
	}	
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/promedio.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>