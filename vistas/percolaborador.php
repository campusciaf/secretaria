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

require 'header.php';
?>
    <div id="precarga" class="precarga"></div>

    <div class="content-wrapper">

        <div class="content-header migas">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="titulo-4"> Configurar Cuenta </h2>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Configurar Cuenta</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

        <section class="content mt-2">
            <div class="row ">
                <div class="col-12 text-center pt-4">
                    <h3 class="titulo-3 text-bold fs-24">Optimiza <span class="text-gradient">tu experiencia visual</span>&nbsp;con nuestro <span class="text-gradient">modo oscuro</span></h3>
                    <p class="lead text-secondary">¡Tu pantalla,tus reglas!</p>
                </div>

                <div class="col-12 modo d-flex align-content-center justify-content-center flex-wrap pb-4">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="switch">
                                <input  id="switch" class="switch__input" name="switch" type="checkbox" onclick="cambioTema()">
                                <label  class="switch__label" for="switch"></label>
                            </div>
                        </div>
                        <div class="col-6 text-right ">Light</div>
                        <div class="col-6 border-left">Dark</div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mostrar-uno"></div>
                </div>
            </div>
        </section>
    </div>








    <script>
           
        </script>

<!--Fin-Contenido-->
<?php

		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/percolaborador.js"></script>

<?php
}
	ob_end_flush();
?>