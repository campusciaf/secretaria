<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 13;
    $submenu = 1319;
    require 'header.php';
    if ($_SESSION['carreporteactivos'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Caracterización</span><br>
                                <span class="fs-16 f-montserrat-regular">Panorama global</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte general</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-12 table-responsive p-2" id="listadoregistros">
                                        <table id="tbllistado" class="table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID Credencial</th>
                                                    <th>Identificación</th>
                                                    <th>Nombre completo</th>
                                                    <th>Programa actual</th>
                                                    <th>Jornada</th>
                                                    <th>Genero</th>
                                                    <th>Periodo ingreso</th>
                                                    <th>Fecha nacimiento</th>
                                                    <th>Departamento nacimiento</th>
                                                    <th>Municipio nacimiento</th>
                                                    <th>Estado civil</th>
                                                    <th>Grupo étnico</th>
                                                    <th>Nombre étnico</th>
                                                    <th>Desplazado por violencia</th>
                                                    <th>Conflicto armado</th>
                                                    <th>Departamento residencia</th>
                                                    <th>Municipio residencia</th>
                                                    <th>Tipo de residencia</th>
                                                    <th>Zona de residencia</th>
                                                    <th>Dirección</th>
                                                    <th>Barrio</th>
                                                    <th>Estrato</th>
                                                    <th>Celular</th>
                                                    <th>WhatsApp</th>
                                                    <th>Instagram</th>
                                                    <th>Facebook</th>
                                                    <th>Twitter</th>
                                                    <th>Email personal</th>
                                                    <th>Tipo de sangre</th>

                                                    <th>¿Estás embarazada?</th>
                                                    <th>¿Cuántos meses de embarazo tienes?</th>
                                                    <th>¿Eres desplazado(a) por la violencia?</th>
                                                    <th>¿Qué tipo de desplazamiento?</th>
                                                    <th>¿A qué grupo poblacional perteneces?</th>
                                                    <th>¿Perteneces a la comunidad LGBTIQ+?</th>
                                                    <th>¿A cuál comunidad?</th>
                                                    <th>Nombre del primer contacto de emergencia</th>
                                                    <th>Relación con esta persona</th>
                                                    <th>Correo del contacto de emergencia</th>
                                                    <th>Teléfono del contacto de emergencia</th>
                                                    <th>Nombre del segundo contacto de emergencia</th>
                                                    <th>Relación con esta persona</th>
                                                    <th>Correo electrónico de este contacto</th>
                                                    <th>Número de teléfono de este contacto</th>
                                                    <th>¿Tienes un computador o tablet?</th>
                                                    <th>¿Tienes conexión a internet en casa?</th>
                                                    <th>¿Tienes planes de datos en tu celular?</th>

                                                    <th>Estado civil</th>
                                                    <th>¿Tienes hijos?</th>
                                                    <th>¿Cuántos hijos tienes?</th>
                                                    <th>¿Tu padre se encuentra vivo?</th>
                                                    <th>Nombre completo de tu padre</th>
                                                    <th>Teléfono de contacto del padre</th>
                                                    <th>Nivel educativo de tu padre</th>
                                                    <th>¿Tu madre se encuentra viva?</th>
                                                    <th>Nombre completo de tu madre</th>
                                                    <th>Teléfono de contacto de la madre</th>
                                                    <th>Nivel educativo de tu madre</th>
                                                    <th>¿Cuál es la situación laboral actual de tus padres?</th>
                                                    <th>¿En qué industria o sector trabajan tus padres?</th>
                                                    <th>¿Qué cursos o diplomados de interés para tus padres?</th>
                                                    <th>¿Tienes pareja actualmente?</th>
                                                    <th>¿Nombre de tu pareja?</th>
                                                    <th>¿Número de celular de tu pareja?</th>
                                                    <th>¿Tienes hermanos?</th>
                                                    <th>¿Cuántos hermanos tienes?</th>
                                                    <th>¿En qué rango de edad se encuentran tus hermanos?</th>
                                                    <th>¿Con quién vive?</th>
                                                    <th>¿Tienes personas a tu cargo?</th>
                                                    <th>¿Cuántas personas tienes a cargo?</th>
                                                    <th>¿Quién es la persona que te inspiró a estudiar?</th>
                                                    <th>¿Cuál es el nombre de tu inspirador?</th>
                                                    <th>WhatsApp del inspirador</th>
                                                    <th>Correo electrónico del inspirador</th>
                                                    <th>¿Nivel de formación de tu inspirador?</th>
                                                    <th>¿Cuál es la situación laboral actual de tu inspirador?</th>
                                                    <th>¿En qué industria o sector trabaja tu inspirador?</th>
                                                    <th>¿Qué cursos o diplomados de interés para tu inspirador?</th>

                                                    <th>¿Trabajas actualmente?</th>
                                                    <th>¿Nombre de la empresa en la que trabajas?</th>
                                                    <th>¿Tipo de sector de la empresa en la que trabajas?</th>
                                                    <th>¿Dirección de la empresa donde trabajas?</th>
                                                    <th>¿Teléfono de la empresa donde trabajas?</th>
                                                    <th>¿Jornada laboral?</th>
                                                    <th>¿Qué incentivos genera tu empresa para tu proceso de formación?</th>
                                                    <th>¿Alguien de tu trabajo actual o anteriores, te inspiró a estudiar?</th>
                                                    <th>¿Nombre completo?</th>
                                                    <th>¿Teléfono de contacto?</th>
                                                    <th>¿Tienes una empresa legalmente constituida?</th>
                                                    <th>¿Nombre y razón social de la empresa?</th>
                                                    <th>¿Tienes una idea de negocio o emprendimiento?</th>
                                                    <th>¿Nombre de la empresa, emprendimiento o idea de negocio?</th>
                                                    <th>¿Sector de la empresa, emprendimiento o idea de negocio?</th>
                                                    <th>¿Cuál fue tu principal motivación para emprender?</th>
                                                    <th>¿Qué recursos o apoyo necesitarías para desarrollar tu emprendimiento?</th>
                                                    <th>¿Has realizado algún curso o capacitación relacionada con emprendimiento?</th>
                                                    <th>¿Cuál curso o capacitación?</th>


                                                    <th>¿Cuáles son tus ingresos mensuales? (en pesos colombianos)</th>
                                                    <th>¿Quién paga tu matrícula?</th>
                                                    <th>¿Cuentas con algún apoyo financiero?</th>
                                                    <th>¿En la actualidad recibes prima y/o cesantías?</th>
                                                    <th>¿Cuentas con obligaciones financieras?</th>
                                                    <th>¿De qué tipo?</th>

                                                    <th>¿Qué te motivó a estudiar?</th>
                                                    <th>¿Cómo te enteraste de CIAF?</th>
                                                    <th>¿Cuál de las siguientes áreas es de tu preferencia?</th>
                                                    <th>¿De qué manera aprendes más fácil?</th>
                                                    <th>¿Te gustaría realizar una doble titulación en nuestros programas?</th>
                                                    <th>¿Qué programa te interesaría?</th>
                                                    <th>¿Dominas un segundo idioma?</th>
                                                    <th>¿Qué idioma?</th>
                                                    <th>¿En qué nivel te encuentras?</th>
                                                    <th>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</th>


                                                    <th>¿Tienes alguna enfermedad física?</th>
                                                    <th>¿Qué enfermedad física?</th>
                                                    <th>¿Recibes algún tratamiento para esta enfermedad que padeces?</th>
                                                    <th>¿Has sido diagnosticado con algún trastorno mental?</th>
                                                    <th>¿Qué trastorno mental?</th>
                                                    <th>¿Recibes tratamiento médico del trastorno mental que presentas?</th>
                                                    <th>¿Hay algún aspecto específico que desees compartir sobre tu bienestar emocional o psicológico?</th>
                                                    <th>¿A cuál EPS está afiliado actualmente?</th>
                                                    <th>¿Consumes algún medicamento de manera permanente?</th>
                                                    <th>¿Qué medicamentos?</th>
                                                    <th>¿Tienes alguna habilidad especial o talento que te gustaría mencionar?</th>
                                                    <th>¿Cuál habilidad?</th>
                                                    <th>¿Participas en actividades extracurriculares relacionadas con tus habilidades o talentos?</th>
                                                    <th>¿Has recibido algún tipo de reconocimiento o premio por tus habilidades o talentos?</th>
                                                    <th>¿Cómo integras tus habilidades o talentos en tu vida universitaria y cotidiana?</th>
                                                    <th>¿Cuáles son las actividades de tu interés?</th>
                                                    <th>¿Pertenece a algún tipo de voluntariado?</th>
                                                    <th>¿Cuál voluntariado?</th>
                                                    <th>¿Desearía participar en CIAF cómo?</th>
                                                    <th>¿Seleccione los temas de tu interés?</th>
                                                    <th>¿Música de tu preferencia?</th>
                                                    <th>¿Qué habilidades o talentos te gustaría desarrollar durante tu tiempo en la universidad?</th>
                                                    <th>¿Cuál es tu deporte de interés?</th>

                                                    <th>Estado crédito</th>
                                                    <th>Días atraso</th>
                                                    <th>Credito Finalizado</th>
                                                    <th>Uso plataforma %</th>
                                                    <th>Edad</th>


                                                    

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/carreporteactivos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>