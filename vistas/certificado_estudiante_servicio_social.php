<?php
require_once "../controlador/certificado_estudiante_servicio_social.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Servicio social</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css?001"> -->
    <link rel="shortcut icon" type="image/png" href="../cv/public/images/icon_cv.png" />
    <style>
        @media print {
            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url('../public/img/fondo_servicios_social.png');
                background-size: 100% 100%;
                background-position: center;
                background-repeat: no-repeat;
                z-index: -1;
            }

            /* mantener la imagen para la pantalla completa */
            @page {
                margin: 0;
            }


            .contenido {
                margin: 4cm 3cm 2.25cm 3cm !important;
                /* Superior, Derecho, Inferior, Izquierdo */
            }

            .salto-linea {
                page-break-before: always;
                margin-top: 210px;
                margin-bottom: 0;
                padding: 0;
            }

            .salto-linea2 {
                page-break-before: always;
                margin-top: 100px;
                margin-bottom: 0;
                padding: 0;
            }

            .salto-linea-titulo {
                page-break-before: always;
                margin-top: 70px;
                margin-bottom: 0;
                padding: 0;
            }
        }

        .contenido {
            margin: 4cm 3cm 2.25cm 3cm !important;
            /* Superior, Derecho, Inferior, Izquierdo */
        }
    </style>


</head>

<body>
    <div class="container">
        <div class="contenido">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="salto-linea-titulo"></div>
                    <h5>CERTIFICACIÓN PRESTACIÓN SERVICIO SOCIAL EMPRESARIAL <?= $_SESSION["periodo_actual"] ?></h5>
                </div>
                <br>
                <div class="col-xs-12 mt-2" style="text-align: justify;">
                    <p>
                        En mi calidad de director del programa de <?= $fo_programa ?> de CIAF, me permito certificar el
                        cumplimiento de las 40 horas de servicio social establecidas en el convenio de “Súmale a la
                        educación”, correspondientes al semestre <?= $semestre_estudiante ?>, realizado por el estudiante
                        <?= $nombre_estudiante ?>.
                    </p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>Lugar de ejecución:</strong> <?= $nombre_empresa ?> <br><br></br>

                        <strong>Actividades:</strong> <?= $ac_realizadas ?><br><br>

                        <strong>Competencias:</strong> <?=$actividades_competencias?>.<br><br>

                        Firmado en Pereira, <?= $fecha_actual ?>.
                        <br><br>
                        Cordialmente,
                    </p>
                </div>
            </div>
            <br><br><br>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>__________________________</strong><br>
                        <strong>Paula Andrea Rengifo Briñez</strong><br>
                        <strong>Coordinadora académica de CIAF</strong><br>
                        <strong>CC: 1088319997</strong><br>
                        <strong>Tel: 3212004180</strong><br>
                    </p>
                </div>
            </div>
        </div>
        <script src="../public/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/certificado_estudiante_servicio_social.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

</body>
<script>

    </script>
</html>
<?php
ob_end_flush();
