<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=22;
$submenu=2201;
require 'header.php';
	if ($_SESSION['usuario_nombre'])
	{
?>

<div id="precarga" class="precarga"></div>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
   <!-- Main content -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><small id="nombre_programa"></small>Ingresos Visitantes</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión visitantes</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <form name="form_encuesta" id="form_encuesta" method="POST">
                     <p class="text-center text-danger">El formulario solo esta funcional con el lector de código</p>
                     <div class="form-row">
                        <div class="form-group col-md-3">
                           <label>Identificación</label>
                           <input type="number" class="form-control" name="identificacion" onChange=buscar(this.value); required placeholder="Identificación" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Primer Apellido</label>
                           <input type="text" name="apellido" placeholder="Primer Apellido" class="form-control campos">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Segundo Apellido</label>
                           <input type="text" name="apellido_2" placeholder="Segundo Apellido" class="form-control campos">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Primer Nombre</label>
                           <input type="text" name="nombre" placeholder="Primer Nombre" class="form-control campos">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Segundo Nombre</label>
                           <input type="text" name="nombre_2" placeholder="Segundo Nombre" class="form-control campos">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Generó</label>
                           <input type="text" name="genero" placeholder="Generó" class="form-control campos">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Fecha Nacimiento</label>
                           <input type="text" name="fecha_nacimiento" placeholder="Fecha Nacimiento" class="form-control campos">
                        </div>
                        <div class="form-group col-md-3 ">
                           <label>Tipo de Sangre</label>
                           <input type="text" name="tipo_sangre" placeholder="Tipo de Sangre" class="form-control campos">
                        </div>
                     </div>
                     <div class="col-md-12" id="info_estudi" style="padding: 10px;"></div>
                     <div class="col-md-12" id="formulario">
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="conte2"></div>
                           <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="conte3"></div>
                           <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="conte4"></div>
                           <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-success btn-lg" id="btn-enviar">Registrar</button>
                           </div>
                        </div>
                  </form>
                  </div>                        
               </div>
               <!-- /.box-header -->
               <!-- centro -->
               <!--Fin centro -->
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
	  
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/encuestasaludvisitante.js?003"></script>
<?php
}
	ob_end_flush();
?>