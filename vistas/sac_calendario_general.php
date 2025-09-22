<?php
    session_start();
    ob_start();
    if (!isset($_SESSION["usuario_nombre"])) {
        header('Location: ../');
        exit();
    } else {
        $menu = 2;
        $submenu = 217;
        require 'header.php';
        if ($_SESSION['sac_calendario_general'] == 1) {
?>

            <div id="precarga" class="precarga"></div>
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                                <h2 class="m-0 line-height-16">
                                    <span class="titulo-2 fs-18 text-semibold">Calendario Sac General</span><br>
                                    <span class="fs-16 f-montserrat-regular"> Ver la Ejecución del plan por mes </span>
                                </h2>
                            </div>
                            <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                                <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                            </div>
                            <div class="col-12 migas">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                    <li class="breadcrumb-item active">Calendario Sac</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content px-3">
                    <div class="row">
                        <div class="col-12 tono-3 col-12 p-0 m-0 hidden" role="group" aria-label="Basic example"  id="tour_mostrar_meses">
                            <ul class="nav nav-tabs pt-2"  id="custom-tabs-one-tab" role="tablist">
                                <form action="#" method="post" class="row" name="check_list" id="check_list">
                                    <?php
                                        $meses = array( "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre","noviembre","diciembre");
                                        for ($i = 0; $i < 12; $i++) {
                                    ?>
                                    <li class="nav-item">
                                    <label for="<?=$meses[$i] ?>" class="button-prueba text-center" onclick="cambiarEstilo(this, '<?= $meses[$i] ?>')"><?= ucfirst($meses[$i])?></label> 
                                    <input style="display:none" id="<?= $meses[$i] ?>" type="checkbox" name="check_list[]" value="<?=($i + 1)?>"  onchange="mostrarcheckbox()">
                                    </li>
                                    <?php 
                                        } 
                                    ?>
                                </form>
                            </ul>
                        </div>
                        <div class="info-mes col-xl-12 col-sm-12">
                        </div>
                    </div>
                </section>
            </div>


        <?php
        } else {
            require 'noacceso.php';
        }
        require 'footer.php';
        ?>
        <script type="text/javascript" src="scripts/sac_calendario_general.js"></script>

        
    
    <?php
    }
    ob_end_flush();
    ?>