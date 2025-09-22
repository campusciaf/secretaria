<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 27;
	$submenu = 2703;
    require 'header.php';
	if($_SESSION['guiamiscasosestado']==1){
?>
<div id="precarga" class="precarga" hidden></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Estado de los casos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Estado de los casos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary" style="padding: 1% 1%">
                    <div class="col-md-12" >
                        <div class="btn-group" role="group" aria-label="Basic example" style="margin: 10px;">
                            <button type="button" value="Activo" onclick="buscar(this.value)" class="btn btn-primary">Activos</button>
                            <button type="button" value="Cerrado" onclick="buscar(this.value)" class="btn btn-danger">Cerrados</button>
                        </div>
                        <div class="col-md-12 tbl_casos"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
	}else{
        require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/guiacasosestado.js"></script>