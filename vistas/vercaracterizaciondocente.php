<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
error_reporting(0);
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 610;
    require 'header.php';
    if ($_SESSION['vercaracterizaciondocente'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Caracterización docente</span><br>
                                <span class="fs-14 f-montserrat-regular">Son los docentes los que permiten que los estudiantes puedan convertirse en creativos e innovadores.</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Caracterización docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content p-4">
                <div class="d-flex justify-content-end">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <span class="mr-2 align-self-center">Deshabilitar</span>
                            <div class="custom-control custom-switch align-self-center" style="display: block;">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" onclick="actualizarEstadoBotones()">
                                <label class="custom-control-label" for="customSwitch1"></label>
                            </div>
                            <span class="ml-2 align-self-center">Habilitar</span>
                        </div>
                    </div>
                </div>
                <div>
                    <a class="toggle-vis btn btn-success btn-flat btn-xs mt-2" style="color: white !important;" data-column="0" onclick="activarBotonDt(this)"> Identificación</a>
                    <a class="toggle-vis btn btn-success btn-flat btn-xs mt-2" style="color: white !important;" data-column="1" onclick="activarBotonDt(this)"> Nombre Docente</a>
                    <a class="toggle-vis btn btn-success btn-flat btn-xs mt-2" style="color: white !important;" data-column="2" onclick="activarBotonDt(this)"> Acepto Datos</a>
                    <a class="toggle-vis btn btn-success btn-flat btn-xs mt-2" style="color: white !important;" data-column="3" onclick="activarBotonDt(this)"> Fecha Actualización</a>

                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="4" onclick="activarBotonDt(this)">¿Nombre persona de contacto en caso de emergencia?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="5" onclick="activarBotonDt(this)">¿Parentesco del contacto de emergencia?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="6" onclick="activarBotonDt(this)">Correo electrónico del contacto de emergencia</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="7" onclick="activarBotonDt(this)">Teléfono del contacto de emergencia</a>
                    <!-- información academica y familiar -->
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="8" onclick="activarBotonDt(this)">¿Actualmente te encuentras estudiando?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="9" onclick="activarBotonDt(this)">¿Tienes pareja actualmente?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="10" onclick="activarBotonDt(this)">¿Nombre de tu pareja?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="11" onclick="activarBotonDt(this)">¿Número de celular de tu pareja?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="12" onclick="activarBotonDt(this)">¿Tienes mascotas?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="13" onclick="activarBotonDt(this)">¿Nombre de tu mascota?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="14" onclick="activarBotonDt(this)">¿Tipo de mascota?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="15" onclick="activarBotonDt(this)">¿Dominas un segundo idioma?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="16" onclick="activarBotonDt(this)">¿Cual idioma?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="17" onclick="activarBotonDt(this)">¿Cuántas personas conviven en tu casa?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="18" onclick="activarBotonDt(this)">¿Eres cabeza de familia ?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="19" onclick="activarBotonDt(this)">¿Numero de personas que tienes a tu cargo?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="20" onclick="activarBotonDt(this)">¿Tienes hijos?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="21" onclick="activarBotonDt(this)">¿Cuántos hijos tiene?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="22" onclick="activarBotonDt(this)">¿Edad de hijos? Ejemplo 7-12</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="23" onclick="activarBotonDt(this)">¿Tipo de vivienda?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="24" onclick="activarBotonDt(this)">¿Medio de transporte?</a>
                    <!-- información salud -->
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="25" onclick="activarBotonDt(this)">¿Usas anteojos?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="26" onclick="activarBotonDt(this)">¿Tomas medicamentos?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="27" onclick="activarBotonDt(this)">¿Fumas y/o consumes bebidas alcohólicas?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="28" onclick="activarBotonDt(this)">¿Tienes un Diagnostico que afecte tu estado de salud físico?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="29" onclick="activarBotonDt(this)">¿Tienes un Diagnostico que afecte tu estado de salud mental?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="30" onclick="activarBotonDt(this)">¿Cuál es la EPS en la que te encuentra afiliado?</a>
                    <!-- Información ocio, pasatiempos y gustos -->
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="31" onclick="activarBotonDt(this)">¿Cuáles son tus hobbies?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="32" onclick="activarBotonDt(this)">¿Perteneces a un voluntariado?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="33" onclick="activarBotonDt(this)">¿Cuál es tu comida favorita?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="34" onclick="activarBotonDt(this)">¿Cuál es tu bebida favorita?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="35" onclick="activarBotonDt(this)">¿Tienes algún talento que quieras contarnos</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="36" onclick="activarBotonDt(this)">¿Cuando te sientes desanimado ¿qué te sube el ánimo?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="37" onclick="activarBotonDt(this)">¿Cuál es tu postre o torta favorita?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="38" onclick="activarBotonDt(this)">¿Cuál es tu color favorito?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="39" onclick="activarBotonDt(this)">¿Quién es la persona más importante para ti?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="40" onclick="activarBotonDt(this)">¿Cuándo te dan un detalle qué prefieres?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="41" onclick="activarBotonDt(this)">¿Cual es la cualidad o valor que te define?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="42" onclick="activarBotonDt(this)">¿Sientes que te destacas en algún tema diferente a tu profesión ?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="43" onclick="activarBotonDt(this)">¿Cual tema?</a>
                    <!-- Información deportiva y física -->
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="44" onclick="activarBotonDt(this)">¿Realizas algun deporte?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="45" onclick="activarBotonDt(this)">¿Cuantas veces en la semana realizas actividad fisica ?</a>
                    <!-- Información de emprendimiento -->
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="46" onclick="activarBotonDt(this)">¿Tienes una empresa legalmente constituida?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="47" onclick="activarBotonDt(this)">¿Haces parte de algún tipo de agremiación, organización o proyecto?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="48" onclick="activarBotonDt(this)">¿Tienes una idea de negocio o emprendimiento?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="49" onclick="activarBotonDt(this)">¿Te interesa la doble titulación en algunos de los programas de CIAF?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="50" onclick="activarBotonDt(this)">¿En qué temas consideras qué podríamos capacitarte para mejorar tus habilidades?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="51" onclick="activarBotonDt(this)">¿Tienes algún empleo o labor adicional que te genere ingresos extra? ¿Qué tipo de labor?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="52" onclick="activarBotonDt(this)">¿Alguien de tu grupo familiar actualmente estudia en CIAF?</a>
                    <a class="toggle-vis btn btn-secondary btn-flat btn-xs mt-2" style="color: white !important;" data-column="53" onclick="activarBotonDt(this)">¿Cuál es tu principal proyecto o meta para este año?</a>
                </div><br>
                <div class="row card">
                    <div class="col-12">
                        <div>
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistado" class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>Identificación</th>
                                        <th>Nombre Docente</th>
                                        <th>Acepto datos</th>
                                        <th>Fecha de actualización</th>
                                        <!--preguntas-->
                                        <th>¿Nombre persona de contacto en caso de emergencia?</th>
                                        <th>¿Parentesco del contacto de emergencia?</th>
                                        <th>Correo electrónico del contacto de emergencia</th>
                                        <th>Teléfono del contacto de emergencia</th>
                                        <th>¿Actualmente te encuentras estudiando?</th>
                                        <th>¿Tienes pareja actualmente?</th>
                                        <th>¿Nombre de tu pareja?</th>
                                        <th>¿Número de celular de tu pareja?</th>
                                        <th>¿Tienes mascotas?</th>
                                        <th>¿Nombre de tu mascota?</th>
                                        <th>¿Tipo de mascota?</th>
                                        <th>¿Dominas un segundo idioma?</th>
                                        <th>¿Cual idioma?</th>
                                        <th>¿Cuántas personas conviven en tu casa?</th>
                                        <th>¿Eres cabeza de familia ?</th>
                                        <th>¿Numero de personas que tienes a tu cargo?</th>
                                        <th>¿Tienes hijos?</th>
                                        <th>¿Cuántos hijos tiene?</th>
                                        <th>¿Edad de hijos? Ejemplo 7-12</th>
                                        <th>¿Tipo de vivienda?</th>
                                        <th>¿Medio de transporte?</th>
                                        <th>¿Usas anteojos?</th>
                                        <th>¿Tomas medicamentos?</th>
                                        <th>¿Fumas y/o consumes bebidas alcohólicas?</th>
                                        <th>¿Tienes un Diagnostico que afecte tu estado de salud físico?</th>
                                        <th>¿Tienes un Diagnostico que afecte tu estado de salud mental?</th>
                                        <th>¿Cuál es la EPS en la que te encuentra afiliado?</th>
                                        <th>¿Cuáles son tus hobbies?</th>
                                        <th>¿Perteneces a un voluntariado?</th>
                                        <th>¿Cuál es tu comida favorita?</th>
                                        <th>¿Cuál es tu bebida favorita?</th>
                                        <th>¿Tienes algún talento que quieras contarnos</th>
                                        <th>¿Cuando te sientes desanimado ¿qué te sube el ánimo?</th>
                                        <th>¿Cuál es tu postre o torta favorita?</th>
                                        <th>¿Cuál es tu color favorito?</th>
                                        <th>¿Quién es la persona más importante para ti?</th>
                                        <th>¿Cuándo te dan un detalle qué prefieres?</th>
                                        <th>¿Cual es la cualidad o valor que te define?</th>
                                        <th>¿Sientes que te destacas en algún tema diferente a tu profesión ?</th>
                                        <th>¿Cual tema?</th>
                                        <th>¿Realizas algun deporte?</th>
                                        <th>¿Cuantas veces en la semana realizas actividad fisica ?</th>
                                        <th> ¿Tienes una empresa legalmente constituida?</th>
                                        <th>¿Haces parte de algún tipo de agremiación, organización o proyecto?</th>
                                        <th>¿Tienes una idea de negocio o emprendimiento?</th>
                                        <th>¿Te interesa la doble titulación en algunos de los programas de CIAF?</th>
                                        <th>¿En qué temas consideras qué podríamos capacitarte para mejorar tus habilidades?</th>
                                        <th> ¿Tienes algún empleo o labor adicional que te genere ingresos extra? ¿Qué tipo de labor?</th>
                                        <th>¿Alguien de tu grupo familiar actualmente estudia en CIAF?</th>
                                        <th>¿Cuál es tu principal proyecto o meta para este año?</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

<?php
}
ob_end_flush();
?>


<script type="text/javascript" src="scripts/vercaracterizaciondocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>