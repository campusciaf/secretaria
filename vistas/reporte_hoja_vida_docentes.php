<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 28;
    $submenu = 2806;
    require 'header.php';
    if ($_SESSION['reporte_hoja_vida_docentes'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte Hoja vida</span><br>
                                <span class="fs-16 f-montserrat-regular">Da un vistazo a la información del Reporte de Hoja de Vida</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Hoja vida</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 p-4 tono-3">
                                    <div class="row align-items-center">
                                        <div class="pl-4">
                                            <span class="rounded bg-light-blue p-3 text-primary ">
                                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="col-10">
                                            <div class="col-5 fs-14 line-height-18">
                                                <span class="text-semibold fs-20">Reporte</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 py-4 pr-4 text-right tono-3">
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card card-primary" style="padding: 2%">
                                            <div>
                                                <?php
                                                $botones = array("Identificación","Nombres","Apellidos","Fecha Nacimiento","Estado Civil","Departamento","Ciudad","Foto","Dirección","Celular","Nacionalidad","Página Web","Género","Tipo Vivienda","Estrato","Número Hijos","Hijos menores de 10","Personas a Cargo","Nivel Escolaridad","Nombre Contacto Emergencia","Parentesco","Teléfono Contacto Emergencia","Título Profesional","Categoría Profesión","Situación Laboral","Resumen Perfil","Experiencia Docente","Políticamente Expuesta");
                                                for ($i = 0; $i < count($botones); $i++) {
                                                ?>
                                                    <a data-column="<?= $i ?>" onclick="activarBotonDt(this)" class="toggle-vis btn btn-info btn-flat btn-xs mt-2 mx-1 <?= ($i >= 9) ? "btn-danger" : "" ?>">
                                                        <i class="text-white"> <?= $botones[$i] ?></i>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </div><br>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="table_datos" style="padding-top: 10px;">
                                                <table class="table table-striped compact table-sm table-responsive" id="dtl_docente_hoja_vida">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Identificación</th>
                                                            <th scope="col">Nombres</th>
                                                            <th scope="col">Apellidos</th>
                                                            <th scope="col">Fecha Nacimiento</th>
                                                            <th scope="col">Estado Civil</th>
                                                            <th scope="col">Departamento</th>
                                                            <th scope="col">Ciudad</th>
                                                            <th scope="col">Foto</th>
                                                            <th scope="col">Dirección</th>
                                                            <th scope="col">Celular</th>
                                                            <th scope="col">Nacionalidad</th>
                                                            <th scope="col">Página Web</th>
                                                            <th scope="col">Género</th>
                                                            <th scope="col">Tipo Vivienda</th>
                                                            <th scope="col">Estrato</th>
                                                            <th scope="col">Número Hijos</th>
                                                            <th scope="col">Hijos menores de 10</th>
                                                            <th scope="col">Personas a Cargo</th>
                                                            <th scope="col">Nivel Escolaridad</th>
                                                            <th scope="col">Nombre Contacto Emergencia</th>
                                                            <th scope="col">Parentesco</th>
                                                            <th scope="col">Teléfono Contacto Emergencia</th>
                                                            <th scope="col">Título Profesional</th>
                                                            <th scope="col">Categoría Profesión</th>
                                                            <th scope="col">Situación Laboral</th>
                                                            <th scope="col">Resumen Perfil</th>
                                                            <th scope="col">Experiencia Docente</th>
                                                            <th scope="col">Políticamente Expuesta</th>
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
                    </div>
                </div>
            </section>
            
        <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
        ?>
        <script type="text/javascript" src="scripts/reporte_hoja_vida_docentes.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <?php
}
ob_end_flush();
    ?>