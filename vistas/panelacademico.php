<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
    header("Location: login.html");
}
else
{
$menu=29;
$submenu=293;
require 'header.php';

	if ($_SESSION['panelacademico']==1)
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
                                <span class="titulo-2 fs-18 text-semibold">Panel Académico</span><br>
                                <span class="fs-16 f-montserrat-regular">Bienvenido a nuestro Panel Académico</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Panel Académico</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-6 p-2 tono-3">
                                        <div class="row align-items-center">
                                            <div class="pl-3">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                    <span class="">Panel Académico</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                    <button class="btn btn-success" id="btnconfigurar" onclick="configurar()"><i class="fa fa-plus-circle"></i> Configurar</button>
                                    </div>
                                </div>

                    <form action="#" method="post" class="row" id="form_consulta_filtrada">

                        <div class="campo-select col-xl-2 col-lg-2 col-md-4 col-6">
                            <select name="periodo" id="periodo" data-live-search="true" onchange="buscar(this.value)">
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Periodo</label>
                        </div>

                        <div class="campo-select col-xl-2 col-lg-2 col-md-4 col-6">
                            <select name="nivel" id="nivel" class="campo" onchange="buscar(this.value)">
                                <option value="0">Todas</option>
                                <option value="1">Nivel 1</option>
                                <option value="2">Nivel 2</option>
                                <option value="3">Nivel 3</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Nivel de Formación</label>
                        </div>

                        <div class="campo-select col-xl-2 col-lg-2 col-md-4 col-6">
                            <select name="escuela" id="escuela" class="campo" onchange="buscar(this.value)">
                                <option value="0">Todas</option>
                                <option value="1">Administración</option>
                                <option value="2">Ingenieria</option>
                                <option value="3">Salud</option>
                                <option value="5">Industrial</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Escuelas</label>
                        </div>

                        <div class="campo-select col-xl-2 col-lg-2 col-md-4 col-6">
                            <select name="programa" id="programa" data-live-search="true" onchange="buscar(this.value)">
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Programa</label>
                        </div>

                        <div class="campo-select col-xl-2 col-lg-2 col-md-4 col-6">
                            <select name="jornada" id="jornada" data-live-search="true" onchange="buscar(this.value)">
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Jornada</label>
                        </div>

                        <div class="campo-select col-xl-2 col-lg-3 col-md-4 col-6">
                            <select name="semestre" id="semestre"  class="campo" required data-style="border" onchange="buscar(this.value)">
                                <option value="0">Todas</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Semestre:</label>
                        </div>
                    </form>
                </div>

                <div class="col-xl-12" style="padding: 2% 1%">
                    <div class="row" id="totalestudiantes">
                    <div class="col-xl-3">
                        <table>
                            <tr>
                                <td colspan="2"><span class="titulo-3">Estudiantes Activos </span></td>
                            </tr>
                            <tr>
                                <td><h1 class="titulo">0</h1> </td>
                                <td ><span class="titulo-3 text-success">100% <img src='../public/img/aumento.webp' width='20px'></span>
                                <br><span style="cursor:pointer" title="'.$totalestudiantesanterior.'">0000</span> </td>
                            </tr>
                        </table>      
                    </div>

                    <div class="col-xl-3">
                        <table>
                            <tr>
                                <td colspan="2"><span class="titulo-3">Número de Matriculas</span></td>
                            </tr>
                            <tr>
                                <td><h1 class="titulo">0</h1> </td>
                                <td ><span class="titulo-3 text-success">100% <img src='../public/img/aumento.webp' width='20px'></span>
                                <br><span style="cursor:pointer" title="'.$totalestudiantesanterior.'">0000</span> </td>
                            </tr>
                        </table>      
                    </div>
                    <div class="col-xl-3">
                        <table>
                            <tr>
                                <td colspan="2"><span class="titulo-3">Estudiantes Nuevos</span></td>
                            </tr>
                            <tr>
                                <td><h1 class="titulo">0</h1> </td>
                                <td ><span class="titulo-3 text-success">100% <img src='../public/img/aumento.webp' width='20px'></span>
                                <br><span style="cursor:pointer" title="'.$totalestudiantesanterior.'">0000</span> </td>
                            </tr>
                        </table>      
                    </div>
                        
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="row">

                        <div class="col-xl-12" id="muestreo1" style="padding: 2% 0%">
                            <div class="border p-2 m-2">
                                <div id="chartContainer" style="height: 560px; max-width: 100%; margin: 0px auto;"></div>
                            </div>
                        </div>


                        <div class="col-xl-4" id="muestreo2" style="padding: 2% 0%">
                            <div class="border p-2 m-2">
                                <div id="chartContainer3" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                            </div>
                        </div>
                            


                        <div class="col-xl-6" style="padding: 2% 0%">
                            <div class="border p-2 m-2">
                                <div id="chartContainer4" style="height: 420px; max-width: 920px; margin: 0px auto;"></div>
                            </div>
                        </div>

                        <div class="col-xl-6" style="padding: 2% 0%">
                            <div class="border p-2 m-2">
                                <div id="chartContainer2" style="height: 420px; max-width: 920px; margin: 0px auto;"></div>
                            </div>
                        </div>
                      
                    </div>
                </div>
                    
        
         </div><!-- /.card-->
   </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!--Fin-Contenido-->




<!-- Modal -->
<div class="modal fade" id="configacademico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/panelacademico.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>
