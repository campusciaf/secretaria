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
$menu=29;
$submenu=291;
require 'header.php';

	if ($_SESSION['panelcomercial']==1)
	{
?>


<div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Panel Comercial</span><br>
                                <span class="fs-16 f-montserrat-regular">Bienvenido a nuestro panel comercial</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Panel comercial</li>
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

                <div class="row">

                    <div class="col-xl-12 boton-mandos">
                        <div class="col-xl-12 col-lg-12 d-flex justify-content-end">
                            <ul>
                                <li><a onclick="listardatos(1)" id="opcion1">Hoy</a></li>
                                <li><a onclick="listardatos(2)" id="opcion2">Ayer</a></li>
                                <li><a onclick="listardatos(3)" id="opcion3">última semana</a></li>
                                <li><a onclick="listardatos(4)" id="opcion4">Este mes</a></li>
                                <li><a  onclick="listardatos(5)" data-toggle="modal" data-target="#exampleModal" id="opcion5">Rango de fecha</a></li>
                                <!-- <li><a data-toggle="modal" data-target="#exampleModal" id="opcion5">Rango de fecha</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light elevation-1"><img src="../public/img/contactanos.webp" class="icono-1"></span>
                                    <div class="info-box-content" onclick="tareascreadas()">
                                        <span class="info-box-text">Tareas creadas</span>
                                        <span class="info-box-number" id="dato_tarea">
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light elevation-1"><img src="../public/img/contactanos.webp" class="icono-1"></span>
                                    <div class="info-box-content" onclick="tareasrealizadas()">
                                        <span class="info-box-text">Tareas realizadas</span>
                                        <span class="info-box-number" id="dato_realizadas">
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light elevation-1"><img src="../public/img/contactanos.webp" class="icono-1"></span>
                                    <div class="info-box-content" onclick="seguimientos()">
                                        <span class="info-box-text">Seguimientos</span>
                                        <span class="info-box-number" id="dato_seguimiento">
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light elevation-1"><img src="../public/img/contactanos.webp" class="icono-1"></span>
                                    <div class="info-box-content" onclick="llamadas()">
                                        <span class="info-box-text">Llamadas</span>
                                        <span class="info-box-number" id="dato_llamada">
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light elevation-1"><img src="../public/img/contactanos.webp" class="icono-1"></span>
                                    <div class="info-box-content" onclick="citas()">
                                        <span class="info-box-text">Citas</span>
                                        <span class="info-box-number" id="dato_cita">
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light elevation-1"><img src="../public/img/contactanos.webp" class="icono-1"></span>
                                    <div class="info-box-content" onclick="sinexito()">
                                        <span class="info-box-text">Sin exito</span>
                                        <span class="info-box-number" id="dato_sinexito">
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal" id="sinexito">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Sin Exito</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datossinexito"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="modal" id="interesados">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Interesados</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosusuario"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="tareas">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Tareas Creadas</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datostareas"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal" id="tareasrealizadas">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Tareas Realizadas</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                        <div id="datostareasrealizadas"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal" id="seguimientos">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Seguimientos</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosseguimientos"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal" id="llamadas">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">LLamadas</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosllamadas"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="citas">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Citas</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datoscitas"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal" id="preinscritos">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Preinscritos</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datospreinscritos"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="inscritos">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Inscritos</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosinscritos"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="seleccionados">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Seleccionados</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosseleccionados"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="admitidos">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Admitidos</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosadmitidos"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="matriculados">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Matriculados</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosmatriculados"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal" id="marketingdigital">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Marketing-digital</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosmarketingdigital"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="asesordigital">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Asesor</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosasesor"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="web">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Web</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datosweb"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="contactanos">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Contactanos</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div id="datoscontactanos"></div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Seleccionar un rango</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        
                        <div class="group col-12">     
                                <input type="date" value="" name="fecha-inicio" id="fecha-inicio">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Fecha de inicial</label>
                        </div>
                        <div class="group col-12">   
                                <input type="date" value="" name="fecha-hasta" id="fecha-hasta">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Fecha de final</label>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                        <button class="btn btn-success" type="button" onclick="listarrango()"> Buscar</button>
                        </div>
                    
                    </div>
                    </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="card">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="interesados()">
                                                Interesados <span class="float-right badge bg-success" id="datouno"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="preinscritos()">
                                                Preinscritos <span class="float-right badge bg-primary" id="datodos"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="inscritos()">
                                            Inscritos <span class="float-right badge bg-secondary" id="datotres"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="seleccionados()">
                                                Seleccionados <span class="float-right badge bg-info" id="datocuatro"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="admitidos()">
                                                Admitidos <span class="float-right badge bg-warning" id="datocinco"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="matriculados()">
                                                Matriculados <span class="float-right badge bg-success" id="datoseis"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="Marketingdigital()">
                                            Marketing-digital <span class="float-right badge bg-primary" id="totalmarketing"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="Web()">
                                            Web  <span class="float-right badge bg-primary" id="totalweb"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" onclick="Asesor()">
                                            Asesor <span class="float-right badge bg-primary" id="totalasesor"></span>
                                            </a>
                                        </li>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                </div>

            </div>


            <div class="card card-primary " style="padding: 2% 1%">

                <div class="row" id="datos_conversion"></div>

<hr>
                <div class="row" id="datos_conversion_comparacion"></div>
            </div>



            <!-- /.card-->
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

<script type="text/javascript" src="scripts/panelcomercial.js?001"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>
