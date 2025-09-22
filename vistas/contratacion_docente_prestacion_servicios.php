<?php
require("../controlador/contratacion_docente.php");
?>
<?php
//CONTRATO TERMINO FIJO-----

$valor_contrato = isset($valor_contrato) ? $valor_contrato : 0; // Valor predeterminado
$valor_contrato = str_replace('.', '', $valor_contrato); // Eliminar puntos
$periodo = isset($periodo) ? $periodo : 2025;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Trabajo</title>

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
                /* font-size: 10px; */
                width: 100%;
                height: 100%;
                background-image: url('../public/img/template_contrato.webp');
                background-size: 100% 100%;
                background-position: center;
                background-repeat: no-repeat;
                z-index: -1;
            }

            ol,
            ul {
                padding-left: 20px;
                /* Espaciado para la numeración o viñetas */
            }

            li {
                text-align: justify;
                /* Justifica el texto dentro de los elementos de la lista */
                margin-bottom: 10px;
                /* Espacio entre elementos de la lista */
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
                    <h5>CONTRATO PRESTACIÓN DE SERVICIOS</h5>
                </div>
                <div class="col-xs-12 mt-2" style="text-align: justify;">
                    <p>
                        Entre los suscritos a saber, de una parte,<strong> JAIRO RODRÍGUEZ VALDERRAMA</strong>,actuando en calidad de representante legal de <strong>CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS – CIAF,</strong> con domicilio principal en la ciudad de Pereira, identificada con NIT. 891.408.248-5, quien en adelante se denominará <strong>EL CONTRANTE</strong> y <u><?php echo mb_strtoupper($nombre_completo, 'UTF-8'); ?></u>, mayor de edad, identificado con cédula de ciudadanía número <?php echo $documento_docente; ?> quien en adelante se denominará EL CONTRATISTA, acuerdan celebrar el presente <strong>CONTRATO DE PRESTACIÓN DE SERVICIOS,</strong>que se regirá por las siguientes cláusulas:
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>PRIMERA: OBJETO. OBJETO.</strong>
                        EL CONTRATISTA, en su calidad de trabajador independiente, obrando por su cuenta y riesgo, con libertad, autonomía técnica, administrativa y financiera, se compromete para con EL CONTRATANTE a prestar sus servicios como en calidad de <strong>DOCENTE <?php echo $materia_docente; ?> </strong>, para lo cual deberá cumplir sus actividades y ejecutarlas de acuerdo a su experiencia y a las capacidades para hacerlo.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>SEGUNDA: OBLIGACIONES DE EL CONTRATISTA.</strong> Son obligaciones de EL CONTRATISTA las siguientes:
                    </p>
                    <ol>
                        <li>Cumplir de manera eficiente y oportuna el objeto del presente contrato de acuerdo con las capacidades reconocidas para ejecutarlo. </li>
                        <li>Iniciar, ejecutar y terminar las actividades propias del objeto del presente Contrato en las fechas esperadas y en cumplimiento de los cronogramas propuestos de acuerdo a las previamente convenidas con EL CONTRATANTE. </li>
                        <li>Cumplir con los lineamientos definidos en el pensum académico y por las directrices del programa. </li>
                        <li>Mantener relaciones respetuosas con todas las personas con las que tenga relación contractual, en especial con la comunidad estudiantil, favoreciendo un clima cordial, culto e igualitario.</li>
                        <li>No ejercer actos de Competencia desleal frente a la Corporación</li>
                        <li>Rendir informe general de actividades que debe cumplir, sin que estas actividades, puedan catalogarse como de dependencia laboral.</li>
                        <li>Afiliarse al régimen de seguridad social, tanto en salud, pensiones y riesgos laborales, y asumir en su totalidad, el pago de las cotizaciones fijadas en la ley, en calidad de trabajador independiente y de acuerdo a los montos fijados por la normatividad legal existente.</li>
                        <li>Reportar en forma oportuna a EL CONTRATANTE los inconvenientes o anomalías que se presenten en relación con la ejecución y buena marcha del presente contrato.</li>
                        <li>Observar rigurosamente las medidas de seguridad y salud en el trabajo, así como procurar el auto cuidado en la prestación del servicio para conservar y mantener su salud, de acuerdo a lo establecido en el Decreto 1072 de 2015.</li>
                        <li>Tomar en consideración, las recomendaciones u observaciones que se efectúen por parte de EL CONTRATANTE, en cuanto a la ejecución y buena marcha del contrato, sin que estas actividades, puedan catalogarse como de dependencia laboral.</li>
                        <li>Reportar de manera inmediata, los accidentes o incidentes que se presenten al momento de la prestación de los servicios, sin sobrepasar las 48 horas a dicho evento.</li>
                        <li>12. Recibir oportunamente las capacitaciones que EL CONTRATANTE proponga para la ejecución y buena marcha del contrato.</li>
                        </ul>
                    </ol>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>TERCERA: OBLIGACIONES DE EL CONTRATANTE.</strong> EL CONTRATANTE se obliga con EL CONTRATISTA a:
                    </p>
                    <ol>
                        <li>Pagar el valor pactado por concepto de honorarios, siempre y cuando EL CONTRATISTA cumpla en forma eficiente el objeto del presente contrato. </li>
                        <li>Facilitarle la información que sea necesaria para la debida ejecución del presente contrato. </li>
                        <li>Cumplir con lo contemplado en las cláusulas y condiciones previstas en este contrato. </li>
                        <li>Realizar las deducciones de los honorarios de EL CONTRATISTA, en relación con el pago a la seguridad social y a la alimentación y EPP.</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>CUARTA. - OBLIGACIONES EN MATERIA DE PREVENCIÓN DE LAVADO DE ACTIVOS Y FINANCIAMIENTO DEL TERRORISMO (LA/FT):</strong>

                    <ol>
                        <li><strong>Obligación de Abstención:</strong> El Trabajador se obliga a abstenerse de realizar, facilitar, ocultar o participar directa o indirectamente en cualquier conducta relacionada con el Lavado de Activos, Financiamiento del Terrorismo o delincuencia organizada, conforme a lo establecido en los artículos 323 y 345 del Código Penal Colombiano (Ley 599 de 2000), así como en las normas complementarias (Ley 1908 de 2018, Decreto 1674 de 2020 y demás regulaciones aplicables).</li>
                        <li><strong>Deber de Reporte:</strong> El Trabajador deberá informar de manera inmediata al empleador, cualquier hecho, indicio o sospecha de actividades relacionadas con LA/FT de las que tenga conocimiento en el marco de sus funciones, incluyendo aquellas realizadas por otros trabajadores, terceros vinculados o clientes. Este reporte se realizará a través de los canales establecidos en el Sistema de Gestión del Riesgo de LA/FT de la empresa.</li>
                        <li><strong>Capacitación y Conocimiento:</strong> El Trabajador se compromete a participar en los programas de capacitación y actualización en materia de prevención de LA/FT que imparta el empleador, así como a conocer y aplicar las políticas y procedimientos internos adoptados por la empresa para mitigar estos riesgos.</li>
                        <li><strong>Consecuencias por Incumplimiento:</strong> La violación de las obligaciones previstas en esta cláusula se considerará falta grave conforme al artículo 62 del Código Sustantivo del Trabajo, dando lugar a las sanciones disciplinarias correspondientes, sin perjuicio de las acciones legales que puedan derivarse ante las autoridades competentes.</li>
                        <li><strong>Marco Normativo Aplicable:</strong> Esta cláusula se rige por las disposiciones de la Unidad de Información y Análisis Financiero (UIAF), la Superintendencia de Sociedades, y demás autoridades de vigilancia y control en materia de prevención de LA/FT en Colombia.</li>
                    </ol>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>QUINTA: VALOR DEL CONTRATO Y FORMA DE PAGO.</strong> Los honorarios pactados con ocasión a la ejecución y cumplimiento de este contrato, se calculan por la hora catedra dictada, para lo cual se establecen,<strong> <?php echo $contrato_docente->numero_a_letras($cantidad_horas); ?> (<?php echo $cantidad_horas; ?>)</strong> horas, a un valor de <strong><?php echo $contrato_docente->numero_a_letras($valor_horas); ?> pesos m/cte. ($<?php echo $valor_horas; ?>)</strong> cada hora. <strong><u>PARÁGRAFO PRIMERO:</u></strong> El valor de los honorarios del servicio prestado se consignarán en la cuenta bancaria que señale EL CONTRATISTA y que se encuentre a su nombre. <strong><u>PARÁGRAFO SEGUNDO:</u></strong> El pago de los honorarios se realizará mensualmente.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>SEXTA: DURACIÓN O PLAZO DEL CONTRATO.</strong> El periodo de tiempo durante el cual EL CONTRATISTA, se obliga a ejecutar sus servicios como DOCENTE <strong><?php echo $materia_docente; ?> </strong>se empezará a ejecutar desde el día <?php echo $contrato_docente->numero_a_letras($dia_inicio); ?> (<?php echo htmlspecialchars($dia_inicio); ?>) del mes de <?php echo htmlspecialchars($mes_inicio_texto); ?> del año <?php echo $contrato_docente->convertirAnioALetrasSimple($anio_inicio); ?> (<?php echo htmlspecialchars($anio_inicio); ?>), hasta el día <?php echo $contrato_docente->numero_a_letras($dia_final); ?> (<?php echo htmlspecialchars($dia_final); ?>) de <?php echo htmlspecialchars($mes_final_texto); ?> del año <?php echo $contrato_docente->convertirAnioALetrasSimple($anio_final); ?> (<?php echo htmlspecialchars($anio_final); ?>). <strong>PARÁGRAFO PRIMERO:</strong> Este contrato no se renovará automáticamente y finalizará en la fecha antes mencionada.<strong>PARÁGRAFO SEGUNDO:</strong> Sin perjuicio de lo anteriormente dispuesto, cualquiera de las partes, podrá terminar en cualquier momento y de manera unilateral y sin justa causa, el presente Contrato, para lo cual solo bastará la respectiva comunicación que una parte haga a la otra, sin que haya lugar a pago de ningún tipo de sanción o de clausula penal al respecto.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>SÉPTIMA: RESPONSABILIDAD Y GARANTÍA DE CALIDAD.</strong> EL CONTRATISTA prestará los servicios con plena autonomía técnica, administrativa y financiera, bajo criterios de eficiencia, diligencia, responsabilidad y calidad, sin restricciones, límites ni formalidades que puedan reñir con el libre ejercicio de su actividad que debe ejecutar, por lo tanto, EL CONTRATISTA, asume la responsabilidad que le sea imputable por los actos y omisiones que se presenten durante la prestación de los Servicios.
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>OCTAVA: PROTECCION DE DATOS PERSONALES.</strong> En cumplimiento de lo dispuesto por la Ley 1581 de 2012, Decreto 1377 de 2013, Toda persona tiene derecho a: 1- Conocer. 2- Actualizar. 3- Rectificar, las informaciones que se hayan recogido sobre ellas, en base de datos o archivos. Este es un derecho Constitucional consagrado en el artículo 15 y 20 de la Constitución Política y desarrollado en la Ley 1581 de 2012, conocida como la Ley de protección de datos personales (Habeas Data) y reglamentada por el Decreto1377 de 2013 y Decreto 1074 de 2015 capítulo 25, por tanto, los datos personales que en virtud del presente Contrato, EL CONTRATISTA comparta con EL CONTRATANTE, serán conservados con especial cuidado, de conformidad con los parámetros establecidos en la normatividad legal vigente. <strong>PARÁGRAFO PRIMERO:</strong> EL CONTRATISTA, autoriza por este medio a EL CONTRATANTE, para que realice tratamiento de sus datos personales conforme a las finalidades descritas en la política de tratamiento de datos personales de EL CONTRATANTE. <strong>PARÁGRAFO SEGUNDO:</strong> AUTORIZACIÓN DE CONSULTA: EL CONTRATISTA, con la suscripción del presente contrato, emite consentimiento expreso e irrevocable a EL CONTRATISTA, para: (i) Consultar en las centrales de riesgo la información para conocer su desempeño como deudor y capacidad de pago, (ii) reportar a las centrales de riesgo datos tratados, así como datos sobre cumplimiento o incumplimiento de sus obligaciones, (iii) Suministrar a las centrales de información datos relativos a sus relaciones comerciales, financieras y en general socio económicas, que no haya entregado o no consten en registros públicos, bases de datos públicas o documentos públicos, (iv) solicitar información, (v) conservar y procesar en la entidad que sea acreedora y en las centrales de riesgo, la información indicada en los literales anteriores, y (vi) Consultar en las listas internacionales
                        expedidas por el Consejo de Seguridad de las Naciones Unidas y las demás que tengan carácter vinculante para Colombia o en los registros o listados nacionales de personas señaladas de tener vínculos con los delitos de lavado de activos financiación del terrorismo o sus delitos fuente u otras emitidas por organismos judiciales y de control.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>NOVENA. INDEPENDENCIA:</strong> Para todos los efectos legales se declara que EL CONTRATISTA asume todos los riesgos que se deriven de la realización de la prestación del servicio, los cuales deberá realizar íntegramente con sus propios medios, con autonomía técnica, administrativa y financiera y directiva respecto de EL CONTRATANTE. En virtud de lo anterior, EL CONTRATISTA actuará por su propia cuenta, con absoluta autonomía y no estará sometido a subordinación laboral con EL CONTRATANTE y sus derechos se limitarán, de acuerdo con la naturaleza del contrato, a exigir el cumplimiento de las obligaciones de EL CONTRATANTE y al pago de los honorarios estipulados por la prestación del servicio, por lo tanto, y en calidad de CONTRATISTA debe asumir bajo su cargo las afiliaciones y cotizaciones a salud, pensión y Administradora de Riesgos Laborales (ARL) <strong>PARÁGRAFO PRIMERO:</strong> Si por cualquier circunstancia, EL CONTRATANTE pagare alguna suma de dinero por concepto de salarios, prestaciones o indemnizaciones que deba asumir de EL CONTRATISTA o efectuare otro gasto que según este contrato corresponda a EL CONTRATISTA, podrá EL CONTRATANTE descontar de las sumas que adeude a EL CONTRATISTA y/o repetir contra él, por el monto pagado más los gastos y costos ocasionados. <strong>PARÁGRAFO SEGUNDO:</strong> EL CONTRATISTA en calidad de trabajador independiente, manifiesta de manera expresa que, para la fecha de suscripción de este Contrato, se encuentra afiliado al Sistema de Riesgos Laborales y mantendrá vigentes dichas afiliaciones durante todo término de duración; además, autoriza desde ya a EL CONTRATANTE para que realice verificaciones a las afiliaciones y en caso de incumplimiento, se descuente de los valores pendientes de pago las sumas correspondientes a los aportes a que haya lugar para ser cancelados a la ARL respectiva. <strong>PARÁGRAFO TERCERO:</strong> En el evento en que EL CONTRATISTA, incumpla con sus obligaciones de pago ante el sistema de seguridad social integral de este Contrato, éste asumirá consiente y directamente todos los riesgos generados por tal decisión y, desde luego, exonerará a EL CONTRATANTE de cualquier responsabilidad derivada de dicho incumplimiento. <strong>PARÁGRAFO CUARTO:</strong> Las recomendaciones u observaciones que se efectúen a EL CONTRATISTA por parte de EL CONTRATANTE, en cuanto a la ejecución y buena marcha del contrato, no constituyen por sí solas, actividades de dependencia laboral.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA. RESERVA DE LA INFORMACION:</strong> EL CONTRATISTA se compromete a mantener en reserva toda la información que le sea suministrada por EL CONTRATANTE en desarrollo del presente contrato, durante y después de la ejecución del mismo, para lo cual se compromete en cumplir con el acuerdo de confidencialidad que es un anexo al presente contrato. <strong>PARÁGRAFO PRIMERO:</strong> EL CONTRATISTA acepta y declaran que: a) Toda información de EL CONTRATANTE, tiene el carácter de confidencial. b) Que la información entregada por parte de EL CONTRATANTE es de propiedad exclusiva de esta. c) Que la información ha sido o será revelada únicamente con el propósito de permitir el cabal cumplimiento del presente Contrato. <strong>PARÁGRAFO SEGUNDO:</strong> EL CONTRATISTA acepta que, cualquier información suministrada por EL CONTRATANTE, previa a la suscripción y/o durante la ejecución de este Contrato, deberá mantenerse en reserva y, por lo tanto, no podrá ser revelada a terceros so pena de que EL CONTRATANTE pueda exigir la indemnización de los perjuicios que le sean causados como consecuencia del incumplimiento de lo establecido anteriormente. <strong>PARÁGRAFO TERCERO:</strong> La información a la que se hace referencia en la presente cláusula, solamente podrá ser utilizada por EL CONTRATISTA para el cumplimiento del objeto del presente Contrato. <strong>PARÁGRAFO CUARTO:</strong> En todo caso, la obligación de confidencialidad no será aplicable a aquella información sobre la cual no exista ningún deber de confidencialidad, sea de público conocimiento, o aquella información que ha dejado de ser confidencial por ser revelada por el propietario o usuario autorizado de la misma, y con la facultad para divulgarla al público, y/o ha sido divulgada por orden de autoridad competente.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>UNDÉCIMA. ACUERDO DE CONFIDENCIALIDAD Y KNOW HOW:</strong> EL CONTRATISTA reconoce expresamente que, las actividades que desarrollará en relación a los servicios a que se refiere el presente contrato, lo pondrán en contacto con los secretos industriales, técnicos, operacionales y comerciales de EL CONTRATANTE, así como aquellos pertenecientes a sus socios, asociados, accionistas, filiales,
                        subsidiarias, clientes, contratistas, proveedores o cualquier persona natural o jurídica relacionada en la cadena de producción, abastecimiento y comercialización y además de la información privilegiada y confidencial de EL CONTRATANTE.
                        <strong>PARÁGRAFO PRIMERO:</strong> Para fines del presente contrato, serán considerados “secretos” incluyendo, de manera enunciativa mas no limitativa, todos aquellos conocimientos industriales, técnicos, comerciales y operacionales, diseños, modelos, base de datos, listas de precios, registros, datos, materiales, planes y proyectos de comercialización y ventas, publicidad, lista de clientes y proveedores, bases de datos e información de cualquier tipo relacionada con los negocios y operaciones de EL CONTRATANTE y/o de las demás personas relacionadas directa o indirectamente con ésta. <strong>PARÁGRAFO SEGUNDO:</strong>
                        EL CONTRATISTA se obliga a mantener en secreto y bajo estricta confidencialidad toda la documentación e información, que EL CONTRATANTE, le suministre, sea en relación con los servicios prestados en función de del presente contrato, o cualquier otra información que directa o indirectamente tuviera conexión con los negocios y operaciones de EL CONTRATANTE, independientemente de la forma y medio en que dicha información sea proporcionada, difundida o expuesta. Igualmente, queda obligado a no revelar ni a divulgar en forma alguna la información relacionada con los servicios, incluyendo aquella información identificada por cualquier instrumento o medio, como “confidencial”, “reservada”, “privilegiada”, “privada” o bajo cualquier otro término similar, sea propiedad de EL CONTRATANTE o de cualquier otra persona que tuviera relación directa o indirecta con la misma, independientemente del medio o instrumento en que dicha información estuviera contenida. <strong>PARÁGRAFO TERCERO:</strong> EL CONTRATISTA reconoce que, todos los desarrollos, invenciones, creaciones, innovaciones e ideas y similares que, se produzcan durante la ejecución del presente contrato, son de propiedad exclusiva de EL CONTRANTE y le pertenecen en su totalidad, por lo que no deberá pagar ni cubrir sumas adicionales a EL CONTRATISTA por esta situación. <strong>PARÁGRAFO CUARTO:</strong>Ambas partes reconocen y se obligan a que el acuerdo de propiedad intelectual y confidencialidad a que se refiere esta cláusula y demás disposiciones relativas contenidas en el presente contrato, continuarán vigentes por un período de tres (03) años más después de finalizada la presente relación comercial.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DUODÉCIMA. CAUSALES DE TERMINACION DEL CONTRATO:</strong> Cualquiera de las partes, podrá dar por terminado el presente contrato en cualquiera de sus etapas, en los siguientes casos:
                        a). Por incumplimiento de cualquiera de las partes en las condiciones definidas en el presente contrato. En este caso, la parte cumplida, informará a la parte incumplida su decisión de dar por terminado el contrato. b). Por mutuo acuerdo de las partes. c). Decisión unilateral de cualquiera de las partes, que deberá ser informada a la otra parte de manera inmediata, sin que tal determinación implique para ninguna de las partes pago de indemnización alguna.
                        d). Por fuerza mayor y caso fortuito.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA TERCERA. DOCUMENTOS DEL CONTRATO:</strong> Hacen parte integral del presente contrato, los siguientes documentos: a). Hoja de vida de EL CONTRATISTA. b) Fotocopia de la cédula del CONTRATISTA. c) Fotocopia de RUT de EL CONTRATISTA. d) Constancia de afiliación, cotización y pago mensual a Seguridad Social. e) Certificación bancaria. f) Todas aquellas comunicaciones entre las partes que por ley deban formar parte integral del presente documento.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA CUARTA. CESION DEL CONTRATO:</strong> EL CONTRATISTA se obliga al cumplir directamente las obligaciones que contrae por este contrato y bajo ninguna circunstancia podrá cederlo en todo ni en parte.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMO QUINTA. CONCILIACIÓN:</strong>Toda diferencia o conflicto que surja entre EL CONTRATANTE Y EL CONTRATISTA con ocasión a la ejecución, cumplimiento, terminación y/o liquidación se resolverá inicialmente entre las partes en un periodo que no supere quince (15) días calendario y en caso contrario podrán acudir ante un Centro de Conciliación o ante la autoridad competente.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA SEXTA. CLAUSULA DE NO EXCLUSIVIDAD:</strong> La aceptación ni el desarrollo del presente contrato de prestación de servicios suscrito entre las partes, en ningún caso generan vínculos de exclusividad de EL CONTRATANTE respecto EL CONTRATISTA ni viceversa.
                    </p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA SÉPTIMA. EXCLUSION RELACION LABORAL</strong> Las partes declaran expresamente que, el presente contrato no tiene el carácter de contrato laboral y, en consecuencia, no crea ningún tipo de vínculo laboral alguno, entre EL CONTRATISTA y EL CONTRATANTE, así como tampoco entre el personal que éste llegare a utilizar en la ejecución del objeto del presente contrato.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA OCTAVA. LEGISLACION APLICABLE.</strong> En caso de presentarse algún conflicto respecto de la interpretación o ejecución del presente contrato, la legislación aplicable será la contenida en el Código Civil y Código de Comercio, y demás normas concordantes de la República de Colombia.
                    </p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA NOVENA. ESTIPULACIONES ANTERIORES.</strong> Las partes manifiestan que no reconocerán validez a estipulaciones verbales o escritas celebrados con anterioridad al otorgamiento del presente contrato, por tanto, el presente documento, constituye acuerdo completo y total acerca de su objeto.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>. MODIFICACIONES.</strong> Cualquier modificación que las partes acuerden hacer al presente contrato, requerirá para su validez, el que consten por escrito a continuación de este documento.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>VIGÉSIMA. PERFECCIONAMIENTO Y LEGALIZACIÓN:</strong> El presente contrato se entiende perfeccionado con la firma de este instrumento por las partes de este.
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>VIGESIMA PRIMERA: - AUTORIZACIÓN DE NOTIFICACIÓN:</strong> En virtud del presente contrato, EL TRABAJADOR autoriza a EL EMPLEADOR a realizar cualquier notificación relacionada con la relación laboral a través del correo electrónico proporcionado personal <?php echo htmlspecialchars($usuario_email_p); ?>.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        Para constancia, se firma el presente documento en un ejemplar del mismo tenor y valor, a los <?php echo htmlspecialchars($dia_inicio); ?> días del mes de <?php echo htmlspecialchars($mes_inicio_texto); ?> del año <?php echo $contrato_docente->convertirAnioALetrasSimple($anio_inicio); ?> (<?php echo htmlspecialchars($anio_inicio); ?>).

                    </p>
                </div>
            </div>
            <div class="row" style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="width: 45%; text-align: left;">
                    <p class="mt-3">
                        <strong style="display: block; margin-bottom: 100px;">EL EMPLEADOR</strong><br>
                        <strong>JAIRO RODRÍGUEZ VALDERRAMA<br>
                            Representante legal<br>
                            CORPORACIÓN INSTITUTO<br>
                            DE ADMINISTRACIÓN Y FINANZAS –CIAF</strong>
                    </p>
                </div>
                <div style="width: 45%; text-align: left;">
                    <p class="mt-3">
                        <strong style="display: block; margin-bottom: 100px;">EL TRABAJADOR</strong><br>
                        <strong><span><?php echo mb_strtoupper($nombre_completo, 'UTF-8'); ?></span><br>
                            C.C. N°. <span><?php echo $documento_docente; ?> </span></strong>
                    </p>
                </div>
            </div>
            <br>
            <br>
            <div class="mt-4" style="width: 100%; border: 1px solid black; border-collapse: collapse; display: table;">
                <div style="display: table-row;">
                    <div style="display: table-cell; border: 1px solid black; padding: 10px; text-align: center;">
                        <strong>Elaboró</strong><br>
                        <?php echo $nombre_usuario_creo_contrato; ?>
                        <br>
                        <?php echo $cargo_usuario; ?>
                    </div>
                    <div style="display: table-cell; border: 1px solid black; padding: 10px; text-align: center;">
                        <strong>Revisó</strong><br>
                        Jairo Rodríguez Valderrama<br>
                        Secretario General
                    </div>
                    <!-- <div style="display: table-cell; border: 1px solid black; padding: 10px; text-align: center;">
                        <strong>Aprobó</strong><br>
                        Gina Marcela Barreto Moreno<br>
                        Rectora
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <script src="../public/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/contratodocentes.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>





</body>

</html>


<?php

ob_end_flush();
