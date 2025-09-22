<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: login.html");
}else{
    $menu = 5;
    $submenu = 503;
    require 'header.php';
	if($_SESSION['cancelarmateria']==1){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Cancelar materias</span><br>
                        <span class="fs-14 f-montserrat-regular">Espacio para gestionar la cancelación de materias con registro.</span>
                </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Cancelar materia</li>
                    </ol>
            </div>
            </div>
        </div>
    </div>

    <section class="container-fluid px-4">
        <!--Fondo de la vista -->
        <div class="row col-12">

            <div class="col-4" id="seleccionprograma">
                <form name="formularioverificar" id="formularioverificar" method="POST" class="row">
                    <div class="col-9 m-0 p-0">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="20">
                                <label>Número Identificación</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-3 m-0 p-0">
                        <button type="submit" id="btnVerificar" class="btn btn-success py-3">Buscar</button> 
                    </div>
                </form>
            </div>

            <div class="col-8" id="mostrardatos">
                <div class="row">
                    <div class="col-4 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="rounded bg-light-white p-2 text-gray ">
                                    <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                                <span class="">Nombres </span> <br>
                                <span class="text-semibold fs-14">Apellidos </span> 
                            </div>
                        </div>
                    </div>

                    <div class="col-4 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto ">
                                <span class="rounded bg-light-white p-2 text-gray">
                                    <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                                <span class="">Correo electrónico</span> <br>
                                <span class="text-semibold fs-14">correo@correo.com</span> 
                            </div>
                        </div>
                    </div>

                    <div class="col-4 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="rounded bg-light-white p-2 text-gray">
                                    <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                                <span class="">Número celular</span> <br>
                                <span class="text-semibold fs-14">+570000000</span> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-12 table-responsive p-4" id="listadoregistros">
                <table id="tbllistado" class="table table-hover" style="width:100%">
                    <thead>
                        <th>Opciones</th>
                        <th>Id estudiante</th>
                        <th>Programa académico</th>
                        <th>Jornada</th>
                        <th>Semestre</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                        <th>Nuevo del</th>
                        <th>Periodo Activo</th>
                    </thead>
                    <tbody>                            
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div id="listadomaterias" class="row" style="width: 100%"></div>
            </div>

        </div><!-- /.row -->
    </section><!-- /.content -->
</div>


<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/eliminar_materia.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>