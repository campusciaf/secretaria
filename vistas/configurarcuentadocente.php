<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 7;
    require 'header_docente.php';
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper">
        <section class="content" style="padding-top: 0px;">
            <div class="row mx-0">
                <div class="col-12" style="padding: 2%">
                    <h2 class="m-0">
                        Mi perfil
                    </h2>
                </div>
                <div class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding: 2%">
                    <div class="mostrar-uno"></div>
                </div>
                <div class="col-xl-3 pl-4 tono-2 borde-right pt-4 " id="menuperfil">
                    <div class="row">
                        <div class="col-12 timeline align-items-center">
                            <div class="py-3 pl-3" id="caract-1">
                                <span class="coin" id="coin-perfil"><img src="../public/img/coin.webp"> <span class="text-danger"> 40 pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-address-card"></i> </span>
                                <a onclick="mostrarform(1)" class="fs-16 pointer font-weight-bolder">
                                    Mis datos personales
                                </a>
                            </div>
                            <div class="py-3 pl-3" id="caract-2">
                                <span class="coin" id="coin-caracterizacion"><img src="../public/img/coin.webp"> <span class="text-danger"> 100 pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-user"></i> </span>
                                <a onclick="mostrarform(2), listarPreguntas()" class="fs-16 pointer font-weight-bolder">
                                    Caracterización
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 px-4 tono-2 pt-4" id="form1">
                    <form class="guardarDatosPersonales" id="guardarDatosPersonales" method="POST"></form>
                </div>
                <div class="col-xl-9 px-4 tono-2 pt-4" id="form2">
                    <form name="formulariodatos" id="formulariodatos" method="POST" class="row">
                        <div class="col-xl-12" id="preguntas"></div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>
    <div class="modal" id="restrablecer" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restablece la contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="guardarDatos" id="formRestablecerClave" method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contraseña anterior</label>
                            <input type="password" name="anterior" id="anterior" class="form-control" required>
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="form-group confirmaCampodos">
                            <label for="exampleInputPassword1">Nueva contraseña</label>
                            <input type="password" name="nueva" id="nueva" class="form-control" required>
                        </div>
                        <div class="form-group confirmaCampo">
                            <label for="exampleInputPassword1">Confirmar contraseña</label>
                            <input type="password" name="confirma" id="confirma" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success guardarDatos">Editar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Fin-Contenido-->
    <?php
    require 'footer_docente.php';
    ?>
    <script type="text/javascript" src="scripts/configurarcuentadocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>