<?php
//Activamos el almacenamiento en el buffer
date_default_timezone_set("America/Bogota");	
ob_start();
session_start();
if(!isset($_SESSION["menupanel"])){
    header("Location: ../");
}else{
    $menu = 29;
    $submenu = 291;
    require 'header.php';
	if($_SESSION['sofitransacciones']==1){
?>
<!-- <div id="precarga" class="precarga"></div> -->

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Idiomas</span><br>
                        <span class="fs-16 f-montserrat-regular">Bienvenido a nuestro modulo para agregar a nuestros seres originales a el curso de idiomas</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'>
                        <i class="fa-solid fa-play"></i> Tour
                    </button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Idiomas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">				
                    <div class="panel-body table-responsive" style="padding-bottom: 10px;" id="listadoregistros">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                            Agregar estudiante
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col" id="contenido"></div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
	
    <!-- Modal agregar estudiante -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nº de identificación</label>
                                    <input type="number" class="form-control" placeholder="CC" onchange="consulta_cc(this.value)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Programa</label>
                                    <select class="custom-select " id="programas" disabled onchange="nivel(this.value)"></select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nivel</label>
                                    <select class="custom-select " id="niveles" disabled ></select>
                                </div>
                            </div>
                            
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  
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
<script type="text/javascript" src="scripts/idiomas_estudiantes.js"></script>