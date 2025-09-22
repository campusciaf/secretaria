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
                        <h2 class="titulo-4 m-0"> Configurar Cuenta </h2>
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

            <div class="row p-2">

               


                <div class="col-12 p-4 ">
                    <form class="guardarDatosPersonales" id="form" method="POST">  
                        <div class="row">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-0 p-0 pb-4 mb-4">
                                <div class="mostrar-uno"></div>
                            </div>

                            <div class="col-12">
                                <h6 class="title">Información Básica</h6>
                            </div>
                            <input type="hidden" name="id" value="">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_nombre_p" id="usuario_nombre_p">
                                        <label>Primer Nombre</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="usuario_nombre_2_p" id="usuario_nombre_2_p">
                                        <label>Segundo Nombre</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_apellido_p" id="usuario_apellido_p">
                                        <label>Primer Apellido</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_apellido_2_p" id="usuario_apellido_2_p">
                                        <label>Segundo Apellido</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_fecha_nacimiento_p" id="usuario_fecha_nacimiento_p">
                                        <label>Fecha de Nacimiento</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_departamento_nacimiento_p" id="usuario_departamento_nacimiento_p" onChange="mostrarmunicipio(this.value)"></select>
                                        <label>Departamento de Nacimiento</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select required="" class="form-control border-start-0" name="usuario_municipio_nacimiento_p" id="usuario_municipio_nacimiento_p"></select>
                                        <label>Ciudad de Nacimiento</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_tipo_sangre_p" id="usuario_tipo_sangre_p"></select>
                                        <label>Tipo de Sangre</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-12">
                                <h6 class="title">Datos de Contacto</h6>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="number" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_celular_p" id="usuario_celular_p">
                                        <label>Número Celular</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="number" placeholder="" value=""  class="form-control border-start-0" name="usuario_telefono_p" id="usuario_telefono_p">
                                        <label>Número Fijo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_direccion_p" id="usuario_direccion_p">
                                        <label>Dirección de Residencia</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12 text-center pt-2">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>

                            

                        </div>
                        
                    </form>

                    
                </div>

                <div class="col-12">
                    <div class="col-12">
                        <h6 class="title">Seguridad</h6>
                    </div>
                </div>
                <div class="col-12">
                    <form class="guardarDatos" id="form2" method="POST">
                        <div class="row">

                            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="anterior" id="anterior">
                                        <label>Contraseña Anterior</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="nueva" id="nueva">
                                        <label>Nueva Contraseña</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="confirma" id="confirma">
                                        <label>Confirmar Contraseña</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-12 col-12 pt-2"><button type="submit" class="btn btn-success guardarDatos">Cambiar contraseña</button></div>

                        </div>

                        
                    </form>
                </div>

               
            </div>
        </section>
    </div>






<!--Fin-Contenido-->
<?php

		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/configurarcuenta.js"></script>

<?php
}
	ob_end_flush();
?>