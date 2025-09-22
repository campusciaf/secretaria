<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 0;
    require 'header_estudiante.php';
?>
    <?php
    require_once "../modelos/Usuario.php";
    $usuario = new Usuario();
    $valor_estado = $usuario->consultar_Estado_Estudiante($_SESSION["credencial_identificacion"]);
    // $estado_ciafi = $valor_estado['estado_ciafi'];

    if (empty($valor_estado)) {
        $estado_ciafi = 1;
    } else {

        $estado_ciafi = $valor_estado['estado_ciafi'];
    }
    if ($estado_ciafi == 1) {

    ?>



        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16 pl-4">
                                <span class="titulo-2 fs-18 text-semibold">Hola</span><br>
                                <span class="fs-14 f-montserrat-regular">Bienvenid@ a tu programa académico.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>

                    </div>
                </div>
            </div>
           
            <section class="container-fluid px-4">
                <div class="contenido px-4" id="mycontenido">
                    <div class="row">

                        <!-- cursos de educacion contonuada -->
                        <div class="col-12">
                            <div class="row" id="misCursos"></div>
                        </div>
                        <!-- *********************************** -->

                        <!-- feria de emprendimientos -->
                        <div class="col-12 d-none">
                            <div class="row tono-3 ml-1 py-4">
                                <div class="col-xl-6 col-lg-12 col-md-12 col-12 d-flex align-items-center  rounded border-right">
                                    <div class="row justify-content-center pt-4">
                                        <div class="col-12 text-center fs-28 bold titulo-7 pt-0 mt-0 line-height-18 pb-4">Feria de <br>Emprendimientos</div>
                                        <div class="col-12 text-center fs-40 bold titulo-7 pt-0 mt-0 ">No te detengas</div>
                                        <div class="col-2">
                                            <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center" style="width:70px"><span id="days" class="fs-28 titulo-7"></span> <br>días </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center" style="width:70px"><span id="hours" class="fs-28 titulo-7"></span> <br>horas </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center" style="width:70px"><span id="minutes" class="fs-28 titulo-7"></span> min. </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center" style="width:70px"><span id="seconds" class="fs-28 titulo-7"></span> seg. </div>
                                        </div>
                                        <div class="col-12 text-center fs-40 bold titulo-7 pt-0 mt-0 pt-4">Te esperamos</div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-12 rounded ">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-auto">
                                                    <i class="fa-solid fa-hashtag p-3 fa-2x bg-light-blue rounded my-2" aria-hidden="true"></i>
                                                </div>
                                                <div class="col-auto line-height-18">
                                                    <span class="">Eventos en</span> <br>
                                                    <span class="titulo-7 text-semibold fs-20">Exposición</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-4">
                                            <div class="conte2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- *********************************** -->

                        <!-- clase para mostrar el contenido de los card de la caja de herramientas en el panel admin y calendarios -->
                        <div class="col-xl-9">
                            <div class="row">
                                <div class="col-xl-12 py-4 d-none">
                                    <div class="row align-items-center">
                                        <div class="col-auto pl-4">
                                            <span class="rounded bg-light-green p-3 text-success">
                                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="col-auto line-height-18">

                                            <span class="">Herramientas</span> <br>
                                            <span class="text-semibold fs-20">Digitales</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-none">
                                    <div class="row">
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-12 conte mb-4"></div> 
                                    </div>
                                </div>

                                    

                                 <!-- calendarios -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 ">
                                    <div class="row ">
                                        <!-- calendario academico -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-4 tono-3 rounded" id="t-paso23">
                                            <div class="row ">
                                    
                                                <div class="col-12 py-3">
                                                    
                                                    <div class="row">
                                                        <div class="col-xl-auto col-auto text-regular text-center pl-4">
                                                            <div class="rounded bg-light-green p-2 text-success ">
                                                                <i class="fa-solid fa-calendar-days "></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-auto col-auto fs-14 line-height-18">
                                                            <span class="">Calendario</span> <br>
                                                            <span class="text-semibold fs-20">Académico</span>
                                                        </div>
                                                    </div>
                                                       
                                                </div>

                                                <div class="col-xl-2 col-3 pt-2 tono-2 text-center">

                                                    <form action="#" method="post" class="row m-0 p-0" name="check_list" id="check_list">
                                                        
                                                        <div class="timeline">
                                                            
                                                            
                                                            <?php
                                                            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                                                            // Suponiendo que recibes id_semestre_actual como un parámetro GET
                                                            $semestreActual = $_SESSION['semestre_actual'];;
                                                            // Ajustar el rango de meses basado en el semestre
                                                            $inicio = $semestreActual == 1 ? 0 : 6;
                                                            $fin = $semestreActual == 1 ? 6 : 12;
                                                            $mesActual = date('n') - 1;
                                                            for ($i = $mesActual; $i < $fin; $i++) {
                                                                ?>
                                                                
                                                                    <label for="<?= $meses[$i] ?>" class=" button-calendario tono-1 text-center <?= ($i == $mesActual) ? 'button-active' : '' ?> col-8" onclick="cambiarEstilo(this, '<?= $meses[$i] ?>')"><?= ucfirst($meses[$i]) ?></label>
                                                                    <input style="display:none" id="<?= $meses[$i] ?>" type="radio" <?= ($i == $mesActual) ? 'checked' : '' ?> name="check_list[]" value="<?= ($i + 1) ?>" onchange="mostrarcalendario()">
                                                                
                                                                <?php
                                                            }
                                                            ?>
                                                       </div>
                                                    </form>
                                                </div>

                                                <div class=" col-xl-10 col-9 py-2 tono-2">
                                                    <div class="row m-0">
                                                        <div class="col-12">
                                                            <div class="traer_calendario"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                        <!-- calendario de eventos -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 tono-3 rounded" id="t-paso25">
                                            <div class="row p-0">
                                                <div class="col-12  py-3 ">
                                                    <div class="row align-items-center">
                                                        <div class="pl-4">
                                                            <div class="rounded bg-light-green p-2 text-success ">
                                                                <i class="fa-regular fa-calendar-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="col-5 fs-14 line-height-18">
                                                                <span class="">Calendario</span> <br>
                                                                <span class="text-semibold fs-20">Eventos</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 tono-2">
                                                    <div class="traer_calendario_eventos pt-2"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </div>
                        </div>

                        <!-- eduacion continuada -->
                        <div class="col-xl-6 mb-4 d-none" id="t-paso24">
                            <div id="slides-continuada"></div>
                        </div>
                        <!-- ******************************** -->

                         <!-- desafios -->
                        <div class="col-xl-3 px-4 " id="t-paso24">
                            <div class="row">

                                <div class="col-12 mb-4 py-2">
                                    <div class="row">
                                        <div class="col-auto text-regular text-center pt-2">
                                            <span class="rounded bg-light-yellow p-2 text-warning">
                                                <i class="fa-solid fa-calendar-days "></i>
                                            </span>
                                        </div>
                                        <div class="col-auto col-lg-5 col-md-5 col-5 fs-14 line-height-18">
                                            <span class="">Siguiente</span> <br>
                                            <span class="text-semibold fs-20">Nivel</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 diario p-4">
                                    <div class="row">
                                        <div class="col-9">
                                        <h3 class="text-white fs-36">¡Hola de nuevo!</h3>
                                        <p class="text-white fs-18">Completa desafíos y recibe recompensas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 p-4">
                                    <div class="row">
                                        <div class="col-6 fs-16 font-weight-bolder">Desafíos del día</div>
                                        <div class="col-6 text-right fs-18 font-weight-bolder text-warning"><i class="fa-solid fa-clock"></i> Pronto</div>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="row align-items-center d-none">
                                        <div class="col-4 text-center "><img src="../public/img/coin-2.webp" width="50px"></div>
                                        <div class="col-8">
                                            <span class="fs-18 font-weight-bolder">Gana 5 Pts</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                        </div>
                                        <div class="col-12 text-right">
                                            <p class="fs-16 font-weight-bolder"><i class="fa-solid fa-link"></i> Desafio Instagram</p>
                                        </div>
                            
                                    </div>

                                    <div class="col-12">
                                        <div class="row tono-2" id="ingresosCampus"></div>
                                    </div>



                                    <div class="col-12 borde p-4 my-4 rounded">
                                        <div class="row">
                                            <div class="col-2"><i class="fa-solid fa-lock fa-2x"></i></div>
                                            <div class="col-10 fs-14 font-weight-bolder">Estamos preparando más desafíos</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                           
                        </div>

                        

                       
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" tabindex="-1" id="modalpublicidad" role="dialog" aria-labelledby="modalpublicidad" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-12 tono-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="rounded bg-light-green p-3 text-success">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </span>
                                </div>
                                <div class="col-10 line-height-18">
                                    <span class="">Cuarto encuentro de</span> <br>
                                    <span class="text-semibold fs-20">Semilleros de investigación</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>Es un honor darles la bienvenida a este evento que ha venido fortaleciendo nuestro compromiso con la investigación y el desarrollo del conocimiento desde el año 2021.</p>
                        <p>En esta cuarta edición, la era digital se toma CIAF, así que continuamos celebrando el esfuerzo de nuestros jóvenes investigadores. Durante el evento, tendrán la oportunidad de presentar sus investigaciones, intercambiar ideas con sus pares y recibir retroalimentación constructiva por parte de nuestros profesores y expertos en diferentes campos. Además, contaremos con conferencias magistrales de destacados investigadores que compartirán sus experiencias y conocimientos, inspirando a todos a seguir explorando y aprendiendo.</p>
                        <p>Esta edición tendrá apertura en el marco de la semana original de CIAF, específicamente en su cumpleaños 52; en este orden de ideas, el cuarto encuentro de semilleros se llevará a cabo el 23 de octubre del 2024 en las instalaciones de CIAF. Calle 20 número 4 – 57 en todo el centro de Pereira.</p>
                        <p>En este apartado encontraremos <b>los términos de referencia de la convocatoria, carta de aval del tutor del semillero, formato de póster y proyecto en curso o terminado.</b></p>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-6 line-height-16 text-center">
                                <a href="https://ciaf.digital/public/web_investigaciones/CARTA-AVAL-DEL-LIDER-DEL-SEMILLERO.docx" target="_blank">
                                    <img src="../public/img/icono-doc.webp" width="60%">
                                    <p>Carta aval del lider del semillero</p>
                                </a>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-6 line-height-16 text-center">
                                <a href="https://ciaf.digital/public/web_investigaciones/FORMATO-PROYECTO-EN-CURSO-O-TERMINADO.docx" target="_blank">
                                    <img src="../public/img/icono-doc.webp" width="60%">
                                    <p>Formato proyecto en curso o terminado</p>
                                </a>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-6 line-height-16 text-center">
                                <a href="https://ciaf.digital/public/web_investigaciones/TERMINOS-DE-REFERENCIA.docx" target="_blank">
                                    <img src="../public/img/icono-doc.webp" width="60%">
                                    <p>Terminos de referencia</p>
                                </a>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-6 line-height-16 text-center">
                                <a href="https://ciaf.digital/public/web_investigaciones/FORMATO%20DE%20PRESENTACI%C3%93N%20P%C3%93STER%20DE%20INVESTIGACI%C3%93N.docx" target="_blank">
                                    <img src="../public/img/icono-doc.webp" width="60%">
                                    <p>Formato de presentación póster de investigación</p>
                                </a>
                            </div>
                            <div class="col-12 alert alert-primary text-center">
                                Por último, les dejamos los links necesarios para la debida inscripción.
                            </div>
                            <div class="col-12">
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <a href="https://forms.gle/CjWGGC4ueiJ5NAg47" target="_blank">
                                            <img src="../public/img/convocatorias-internas.webp" width="60%">
                                            <p>Inscripción Asistentes</p>
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="https://forms.gle/Jj7mYKY5jF2bPwRZ6" target="_blank">
                                            <img src="../public/img/convocatorias-internas.webp" width="60%">
                                            <p>Inscripción Ponentes</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="perfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-12 tono-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="rounded bg-light-green p-3 text-success">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </span>
                                </div>
                                <div class="col-10 line-height-18">
                                    <span class="">Actualizar perfil</span> <br>
                                    <span class="text-semibold fs-20">Validar datos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form name="formularioperfil" id="formularioperfil" method="POST">
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="email" placeholder="" value="" required class="form-control border-start-0 usuario_email" name="email" id="email" maxlength="50">
                                        <label>Correo Electronico personal (No CIAF)</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="number" placeholder="" value="" class="form-control border-start-0 " name="telefono" id="telefono" maxlength="20">
                                        <label>Telefono fijo (si tiene)</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="number" placeholder="" value="" class="form-control border-start-0 " name="celular" id="celular" maxlength="20" required>
                                        <label>Número celular</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required class="form-control border-start-0 usuario_direccion" name="barrio" id="barrio" maxlength="70" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Barrio de residencia</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required class="form-control border-start-0" name="direccion" id="direccion" maxlength="70" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Dirección de residencia</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="campo" id="campo">
                                            <option value="1">Bajo - bajo</option>
                                            <option value="2">Bajo</option>
                                            <option value="3">Medio-bajo</option>
                                            <option value="4">Medio</option>
                                            <option value="5">Medio-alto</option>
                                            <option value="6">Alto</option>
                                            <option value="7">Sin estrato</option>
                                        </select>
                                        <label>Estato (nivel socio-economico)</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar cambios </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalIngresosEstudiantes">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ingreso Estudiantes</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="datosusuario_estudiante"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalFaltas">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Faltas Reportadas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="datosusuario_faltas"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModalActividades">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Actividades</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="datosusuario_actividades"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalActividadesdocente">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Actividades</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="datosusuario_mostraractividades"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalNotasReportada">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Notas Reportadas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="datosusuario_nota_reportada"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para ver las acciones y los proyectos -->
        <div class="modal fade" id="myModalClasesdelDia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll ;">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Clase del Dia</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <div id="clasedeldia"></div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal encuesta -->
        <div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario" aria-hidden="true">
            <form method="POST">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <b>
                                <h3 class="modal-title" id="modalCalendarioLabel">Ver Evento</h3>
                            </b>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idActividad" name="idActividad" /><br>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Título: </label>
                                    <input class="form-control" type="text" id="txtTitulo" name="txtTitulo" placeholder="Título del Evento" disabled />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Fecha Inicio:</label>
                                    <input class="form-control" type="date" id="txtFechaInicio" name="txtFechaInicio" disabled />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Fecha Fin:</label>
                                    <input class="form-control" type="date" id="txtFechaFin" name="txtFechaFin" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModalEncuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Disculpa que te interrumpa pero quiero que me regales dos
                            minutos para mejorar tu experiencia académica en CIAF.</h5>
                    </div>
                    <div class="modal-body">
                        <form name="formularioencuesta" id="formularioencuesta" method="POST">
                            <div class="col-12">
                                <p><b>Instrucciones</b></p>
                                <p> Selecciona la opción que corresponda en la calificación es de 1 a 5, teniendo en cuenta que
                                    1
                                    es la calificación más baja y 5 la calificación más alta.</p>
                            </div>
                            <div class="group col-xl-12">
                                <div class="col-xl-12">
                                    <p><b>¿Has podido evidenciar elementos creativos e innovadores en tu experiencia
                                            académica?</b></p>
                                    <select name="pre1" id="pre1" class="form-control">
                                        <option value="1">Muy Insatisfecho </option>
                                        <option value="2">Poco Satisfecho</option>
                                        <option value="3">Regular</option>
                                        <option value="4">Bueno</option>
                                        <option value="5">Muy bueno</option>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                            </div>
                            <div class="group col-xl-12">
                                <div class="col-xl-12">
                                    <p><b>¿En el cumplimiento de tu meta, es decir, el grado ¿te sientes apoyado por la
                                            institución?</b></p>
                                    <select name="pre2" id="pre2" class="form-control">
                                        <option value="1">Muy Insatisfecho </option>
                                        <option value="2">Poco Satisfecho</option>
                                        <option value="3">Regular</option>
                                        <option value="4">Bueno</option>
                                        <option value="5">Muy bueno</option>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                            </div>
                            <div class="group col-xl-12">
                                <div class="col-xl-12">
                                    <p><b>¿Cuál crees tú que es el docente más creativo e innovador de la institución?</b></p>
                                    <select name="pre3" id="pre3" class="form-control selectpicker" data-live-search="true" required>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar cambios </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="myModalEncuestad" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><strong>SEMANA ORIGINAL CIAF</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div id="preguntas"></div>
                        <form name="formulario" id="formulario" method="POST">
                            <img src="../public/img/encuesta.jpg" width="100%">
                            <div class="well">
                                Apreciado estudiante y colaborador, para nuestra institución es muy importante tu opinión, para
                                ello nos interesa conocer cual de las siguientes actividades planteadas son de tu interés. La
                                información recopilada será utilizada para uso interno estadístico de acuerdo al tratamiento de
                                la información Habeas Data.<br><br>
                                <b>Nuestra semana original CIAF 2020, estará enfoca en actividades de gran interés, para ello te
                                    solicitamos selecciones las actividades planteadas de manera remota que consideres
                                    interesante:</b>
                                Iniciaremos con una serie de charlas virtuales dentro de un modelo dinámico, en esta oportunidad
                                conocerás las charlas de la noche del miércoles 21 de octubre.<br><br>
                            </div>
                            <h1 class="titulo-1">Primer bloque</h1>
                            <label>
                                <input type="radio" name="r1" id="r1" value="La Cajita Feliz">
                                La Cajita Feliz financiera: 6 tips para manejar las finanzas personales correctamente
                            </label><br>
                            <label>
                                <input type="radio" name="r1" id="r1" value="Ven y emprende">
                                Ven y emprende con la Alcaldía de Pereira: nacimiento del Valle del Software
                            </label><br>
                            <label>
                                <input type="radio" name="r1" id="r1" value="Redes sociales">
                                Redes sociales para la consultoría: un medio para dar a conocer a otros mi potencial
                            </label><br>
                            <label>
                                <input type="radio" name="r1" id="r1" value="Revolución del talento">
                                Revolución del talento: 3 Habilidades blandas en el mundo 4,0
                            </label>
                            <h1 class="titulo-1">Segundo Bloque</h1>
                            <label>
                                <input type="radio" name="r2" id="r2" value="Caso de éxito">
                                Caso de éxito: Emprendiendo con propósito
                            </label><br>
                            <label>
                                <input type="radio" name="r2" id="r2" value="El científico de datos">
                                El científico de datos, el profesional sexy del futuro ( qué es y para qué sirve)
                            </label><br>
                            <label>
                                <input type="radio" name="r2" id="r2" value="Gerencie con felicidad">
                                Gerencie con felicidad: Descubre como hacer feliz a tu equipo, Happiness Management 4.0
                            </label><br>
                            <label>
                                <input type="radio" name="r2" id="r2" value="Inteligencia artificial para fútbol">
                                Inteligencia artificial para fútbol<br>
                            </label>
                            <h1 class="titulo-1">Tercer Bloque</h1>
                            <label>
                                <input type="radio" name="r3" id="r3" value="consejos SST">
                                ¿Sigue abierto su lugar de trabajo durante el COVID -19? 6 consejos SST para su lugar de trabajo
                            </label><br>
                            <label>
                                <input type="radio" name="r3" id="r3" value="juego de ajedrez">
                                Sea estratégico en el juego: Inteligencia artificial para el juego de ajedrez
                            </label><br>
                            <label>
                                <input type="radio" name="r3" value="La importancia de saber respirar">
                                La importancia de saber respirar: ¿cómo afrontar un momento de estrés?
                            </label><br>
                            <label>
                                <input type="radio" name="r3" id="r3" value="tips para mejorar Memoria">
                                3 tips para mejorar Memoria<br>
                            </label>
                            <h1 class="titulo-1">Cuarto Bloque</h1>
                            <label>
                                <input type="radio" name="r4" id="r4" value="Networking">
                                Networking: 6 tips para hacer contactos en un mundo de negocios
                            </label><br>
                            <label>
                                <input type="radio" name="r4" id="r4" value="tips para hablar en público y convencer">
                                Vende tu idea a un auditorio: 3 tips para hablar en público y convencer
                            </label><br>
                            <label>
                                <input type="radio" name="r4" id="r4" value="En TIC Confío">
                                En TIC Confío: 3 Herramientas para afrontar con seguridad los riesgos del uso de las TIC
                            </label><br>
                            <label>
                                <input type="radio" name="r4" id="r4" value="Caso de éxito en clase">
                                Caso de éxito en clase: desarrollo de habilidades para el servicio<br>
                            </label><br>
                            <button class="btn btn-success btn-block" type="submit" id="btnGuardar">
                                <i class="fa fa-save"></i>
                                Guardar
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalEducacionContinuada" tabindex="-1" aria-labelledby="modalEducacionContinuadaLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <div class="row">
                                <div class="col-12 p-2">
                                    <div class="row">
                                        <div class="pl-4 d-flex align-items-center">
                                            <span class="rounded bg-light-yellow p-3 text-warning">
                                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="col-8 fs-14 line-height-18 pl-4">
                                            <span class="categoria_curso text-capitalize">tipo</span> en: <br>
                                            <span class="text-semibold fs-18 nombre_curso">Eventos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div id="precarga_modal" class="precarga_modal"></div>
                    <div class="modal-body py-1">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row justify-content-center">
                                    <div class="col-xl-12 p-0"><img width="100%" class="img_curso" src="" alt="Angular"></div>
                                </div>
                            </div>
                            <div class="col-xl-12 pt-2">
                                <p class="descripcion_curso fs-16 "> - </p>
                            </div>
                            <div class="col-xl-12">
                                <div class="row mb-2 p-2">
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-xl-12 p-2 borde rounded">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="p-3 rounded bg-light-green text-success">
                                                            <i class="fa-solid fa-cart-shopping"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <div class="small mb-0">Inversión</div>
                                                        <span class="boton fs-24 text-semibold">$ <span class="valor_curso"> -
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="row boton_epayco"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex align-items-center justify-content-center borde rounded ml-3 ">
                                        <div class="row">
                                            <div class="col-12 small text-center">Separa tu cupo</div>
                                            <div class="col-12 boton_inscripcion text-center justify-content-center"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row tono-1 py-2 ">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                        <div class="row justify-content-center">
                                            <div class="col-12 hidden">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="p-2 rounded bg-light-blue text-primary">
                                                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <div class="small mb-0">Nivel</div>
                                                        <div class="text-semibold nivel_curso fs-14 text-capitalize">--</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                        <div class="row justify-content-center">
                                            <div class="col-12 hidden">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="p-2 rounded bg-light-blue text-primary">
                                                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <div class="small mb-0">Modalidad</div>
                                                        <div class="text-semibold modalidad_curso fs-14 text-capitalize">--
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                        <div class="row justify-content-center">
                                            <div class="col-12 hidden">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="p-2 rounded bg-light-blue text-primary">
                                                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <div class="small mb-0">Duración</div>
                                                        <div class="text-semibold duracion_curso fs-14 text-capitalize">--</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 my-4">
                                    <div class="small mb-0">Fecha de inicio</div>
                                    <h4 class="text-dark mb-0">
                                        <span class="text-semibold fecha_inicio fs-14">0</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModalDireccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title"><strong>Ubicación residencia</strong></h6>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="formulariomapas" name="formulariomapas">
                            <div class="row">
                                <input type="hidden" name="latitud" id="latitud">
                                <input type="hidden" name="longitud" id="longitud">
                                <div class="col-12 tono-3">
                                    <span class="titulo-3">Ubicar el punto rojo del mapa en su dirección de residencia</span>
                                </div>
                                <div class="col-4 pt-2">
                                    <button class="btn btn-success btn-lg" type="submit" id="btnMapas">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Clic aquí para guardar ubicación
                                    </button>
                                </div>
                                <div class="col-12">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalmonitoreandoestudiante" tabindex="-1" role="dialog" aria-labelledby="modalmonitoreandoestudiante" aria-hidden="true" data-backdrop="static" data-keyboard="false">

            <form method="POST" name="form-monitoreando-estudiante" id="form-monitoreando-estudiante">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <img src="../public/img/monitoriando_experiencia.jpg" alt="CIAF - Encuesta de Autoevaluación" width="460px">
                            <div class="form-row mt-3">
                                <p>En CIAF, estamos comprometidos con la mejora continua y las experiencias de calidad a toda nuestra comunidad. Para seguir mejorando, necesitamos conocer tu opinión sobre diversos aspectos de nuestra institución.</p>
                                <p>Tu participación es muy importante para nosotros. Te invitamos a completar la siguiente encuesta de percepción, donde podrás compartir tus impresiones y sugerencias sobre tu experiencia en CIAF. Esto nos permitirá identificar oportunidades de mejora y fortalecer los procesos que impactan tu formación y bienestar.</p>
                                <p>Agradecemos de antemano tu tiempo y disposición para ayudarnos a crecer juntos.</p>
                                <p><strong>Para cada afirmación, selecciona una opción en la siguiente escala de Likert del 1 al 5:</strong></p>
                                <ul>
                                    <li>5: Se cumple plenamente.</li>
                                    <li>4: Se cumple en gran medida.</li>
                                    <li>3: Se cumple de manera aceptable.</li>
                                    <li>2: Se cumple de forma insatisfactoria.</li>
                                    <li>1: No se cumple.</li>
                                </ul>
                                <h4 class="mt-3">MECANISMOS DE SELECCIÓN Y EVALUACIÓN DE ESTUDIANTES 				
                                </h4>
                                <div class="likert">
                                    <label>El reglamento estudiantil se encuentra disponible para ser consultado fácilmente y permite su apropiación</label><br>
                                    <input type="radio" name="p1" value="1" required> 1
                                    <input type="radio" name="p1" value="2" required> 2
                                    <input type="radio" name="p1" value="3" required> 3
                                    <input type="radio" name="p1" value="4" required> 4
                                    <input type="radio" name="p1" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>Los requisitos y criterios de inscripción, admisión y matrícula y grado de los estudiantes son claros y transparentes.</label><br>
                                    <input type="radio" name="p2" value="1" required> 1
                                    <input type="radio" name="p2" value="2" required> 2
                                    <input type="radio" name="p2" value="3" required> 3
                                    <input type="radio" name="p2" value="4" required> 4
                                    <input type="radio" name="p2" value="5" required> 5
                                </div>
                                <h4 class="mt-3">MECANISMOS DE SELECCIÓN Y EVALUACIÓN DE PROFESORES		
                                </h4>
                                <div class="likert">
                                    <label>El grupo profesores, en términos de dedicación, vinculación y disponibilidad, permite el desarrollo de las labores formativas, académicas, docentes, científicas, culturales y extensión.
                                    </label><br>
                                    <input type="radio" name="p3" value="1" required> 1
                                    <input type="radio" name="p3" value="2" required> 2
                                    <input type="radio" name="p3" value="3" required> 3
                                    <input type="radio" name="p3" value="4" required> 4
                                    <input type="radio" name="p3" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>Los docentes evalúan a los estudiantes de acuerdo con los criterios de evaluación establecidos para identificar el logro de los resultados de aprendizaje.</label><br>
                                    <input type="radio" name="p4" value="1" required> 1
                                    <input type="radio" name="p4" value="2" required> 2
                                    <input type="radio" name="p4" value="3" required> 3
                                    <input type="radio" name="p4" value="4" required> 4
                                    <input type="radio" name="p4" value="5" required> 5
                                </div>
                                <h4 class="mt-3">ESTRUCTURA ACADÉMICO ADMINISTRATIVA					
                                </h4>
                                <div class="likert">
                                    <label>Los estudiantes tienen la oportunidad de participar en las decisiones institucionales mediante su representatividad en los diferentes estamentos establecidos para ello.
                                    </label><br>
                                    <input type="radio" name="p5" value="1" required> 1
                                    <input type="radio" name="p5" value="2" required> 2
                                    <input type="radio" name="p5" value="3" required> 3
                                    <input type="radio" name="p5" value="4" required> 4
                                    <input type="radio" name="p5" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>CIAF dispone de canales de comunicación para que los estudiantes manifiesten sus inquietudes y sugerencias y se responden de manera satid¡sfactoria y oportuna.
                                    </label><br>
                                    <input type="radio" name="p6" value="1" required> 1
                                    <input type="radio" name="p6" value="2" required> 2
                                    <input type="radio" name="p6" value="3" required> 3
                                    <input type="radio" name="p6" value="4" required> 4
                                    <input type="radio" name="p6" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>CIAF mantiene a la comunidad académica actualizada a través de sus diferentes medios de comunicación institucionales.
                                    </label><br>
                                    <input type="radio" name="p7" value="1" required> 1
                                    <input type="radio" name="p7" value="2" required> 2
                                    <input type="radio" name="p7" value="3" required> 3
                                    <input type="radio" name="p7" value="4" required> 4
                                    <input type="radio" name="p7" value="5" required> 5
                                </div>
                                
                                <div class="likert">
                                    <label>El Campus Virtual de CIAF es accesible y funcional.
                                    </label><br>
                                    <input type="radio" name="p8" value="1" required> 1
                                    <input type="radio" name="p8" value="2" required> 2
                                    <input type="radio" name="p8" value="3" required> 3
                                    <input type="radio" name="p8" value="4" required> 4
                                    <input type="radio" name="p8" value="5" required> 5
                                </div>
                                <h4 class="mt-3">CULTURA DE AUTOEVALUACIÓN 				
                                </h4>
                                <div class="likert">
                                    <label>Los procesos de autoevaluación en CIAF contribuyen a la mejora institucional.
                                    </label><br>
                                    <input type="radio" name="p9" value="1" required> 1
                                    <input type="radio" name="p9" value="2" required> 2
                                    <input type="radio" name="p9" value="3" required> 3
                                    <input type="radio" name="p9" value="4" required> 4
                                    <input type="radio" name="p9" value="5" required> 5
                                </div>
                                
                                <h4 class="mt-3">MODELO DE BIENESTAR			
                                </h4>
                                <div class="likert">
                                    <label>
                                    Los programas y servicios de bienestar se divulgan a través de los medios de comunicación de CIAF.
                                    </label><br>
                                    <input type="radio" name="p10" value="1" required> 1
                                    <input type="radio" name="p10" value="2" required> 2
                                    <input type="radio" name="p10" value="3" required> 3
                                    <input type="radio" name="p10" value="4" required> 4
                                    <input type="radio" name="p10" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>
                                    Bienestar Universitario brinda asesoría a los estudiantes en riesgo académico y de deserción , orientación psicologica entre otros
                                    </label><br>
                                    <input type="radio" name="p11" value="1" required> 1
                                    <input type="radio" name="p11" value="2" required> 2
                                    <input type="radio" name="p11" value="3" required> 3
                                    <input type="radio" name="p11" value="4" required> 4
                                    <input type="radio" name="p11" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>
                                    La comunidad de CIAF cuenta con mecanismos para evaluar los servicios de bienestar.
                                    </label><br>
                                    <input type="radio" name="p12" value="1" required> 1
                                    <input type="radio" name="p12" value="2" required> 2
                                    <input type="radio" name="p12" value="3" required> 3
                                    <input type="radio" name="p12" value="4" required> 4
                                    <input type="radio" name="p12" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>
                                    Los estudiantes conocen y participan en las estrategias para fomentar su promoción y graduación.
                                    </label><br>
                                    <input type="radio" name="p13" value="1" required> 1
                                    <input type="radio" name="p13" value="2" required> 2
                                    <input type="radio" name="p13" value="3" required> 3
                                    <input type="radio" name="p13" value="4" required> 4
                                    <input type="radio" name="p13" value="5" required> 5
                                </div>
                                <h4 class="mt-3">RECURSOS SUFICIENTES				
                                </h4>
                                <div class="likert">
                                    <label>
                                    CIAF dispone de infraestructura adecuada para el desarrollo de actividades administrativas y académicas, incluyendo áreas de dirección, oficinas de directores de programa, salas de reuniones y ambientes de aprendizaje.
                                    </label><br>
                                    <input type="radio" name="p14" value="1" required> 1
                                    <input type="radio" name="p14" value="2" required> 2
                                    <input type="radio" name="p14" value="3" required> 3
                                    <input type="radio" name="p14" value="4" required> 4
                                    <input type="radio" name="p14" value="5" required> 5
                                </div>
                                <div class="likert">
                                    <label>
                                    Las herramientas tecnológicas disponibles en CIAF son suficientes para el desarrollo de las actividades académicas.
                                    </label><br>
                                    <input type="radio" name="p15" value="1" required> 1
                                    <input type="radio" name="p15" value="2" required> 2
                                    <input type="radio" name="p15" value="3" required> 3
                                    <input type="radio" name="p15" value="4" required> 4
                                    <input type="radio" name="p15" value="5" required> 5
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    <?php


    } elseif ($estado_ciafi == 0) {
    ?>
        <div class="content-wrapper mt-5">
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title mt-3">Acceso bloqueado</h5>
                                <p class="card-text mt-5"> ¡Por favor contáctanos al 📞 3126814341 para encontrar una solución
                                    en conjunto!

                                    Queremos seguir ofreciéndote el beneficio de la financiación directa para que cumplas tu
                                    sueño de ser profesional. ¡Ayúdanos a cuidarla!🌞</p>
                                <a href="financiacion.php" class="btn btn-warning btn-lg text-dark">Realizar Pago</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- /.content-wrapper -->

    <?php

    }

    ?>

<?php
    require 'footer_estudiante.php';
}
ob_end_flush();
?>

<script src='../public/js/sly.min.js'></script> <!-- calendario de ventos -->
<!-- <script type="text/javascript" src="../public/js/educacion-continuada.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script> -->
<script type="text/javascript" src="scripts/panel_estudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>




</body>

</html>