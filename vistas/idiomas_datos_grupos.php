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
                    <h1 class="m-0">Datos grupos</h1>
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
                    <div class="row text-center">
                        <div class="col">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_docente">
                                Registrar Docente
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_grupo">
                                Registrar Tipo de Grupo
                            </button>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_crear_grupo">
                                Crear Grupo
                            </button>
                        </div>

                    </div><br>
                    <div class="panel-body table-responsive" id="listardatos"></div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
	<!-- Button trigger modal -->


    <!-- Modal Tipo de grupo-->
    <div class="modal fade" id="modal_grupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Docentes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                

                <form action="#" method="post" id="form_grupo">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Grupo</label>
                            <input type="text" name="nombre" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Dia</label>
                            <select class="form-control" name="dia">
                                <option selected disabled>-Dia-</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miercoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Desde:</label>
                            <input type="time" name="hora1" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Hasta:</label>
                            <input type="time" name="hora2" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Docente-->
    <div class="modal fade" id="modal_docente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Grupos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                

                <form action="#" method="post" id="form_docente">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Docente</label>
                            <input type="text" name="nombre" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear grupo-->
    <div class="modal fade" id="modal_crear_grupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Grupos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                

                <form action="#" method="post" id="form_crear_grupo">
                    <div class="form-row">
                        <div class="form-group col-md-6" id="docente"></div>
                        <div class="form-group col-md-6" id="tipo_grupo"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<script type="text/javascript" src="scripts/idiomas_datos_grupos.js"></script>