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
                width: 100%;
                height: 100%;
                background-image: url('../public/img/template_contrato.webp');
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
                    <h5>CONTRATO TERMINO FIJO</h5>
                </div>
                <div class="col-xs-12 mt-2" style="text-align: justify;">
                    <p>
                        Entre los suscritos a saber, de una parte,<strong> JAIRO RODRÍGUEZ VALDERRAMA</strong>, mayor de edad, identificado con cédula de ciudadanía Nº 79.291.743 expedida en Bogotá, actuando en calidad de representante legal de <strong>CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS – CIAF-,</strong> con domicilio principal en la ciudad de Pereira, identificada con NIT. 891.408.248-5, quien en adelante se denominará <strong>EL EMPLEADOR</strong> y <u><?php echo mb_strtoupper($nombre_completo, 'UTF-8'); ?></u>, mayor de edad, identificado con cédula de
                        ciudadanía número <u><?php echo $documento_docente; ?></u>, quien en adelante se denominará <strong>EL TRABAJADOR</strong>, acuerdan celebrar el presente <strong>CONTRATO DE TRABAJO TERMINO FIJO </strong> que se regirá por las
                        siguientes cláusulas:
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>PRIMERA.- OBJETO:</strong> EL EMPLEADOR contrata los servicios personales de EL TRABAJADOR, para desempeñar el cargo de
                        <strong>DOCENTE TIEMPO COMPLETO </strong> y éste se obliga: a) A poner al servicio de EL EMPLEADOR toda su capacidad y experiencia profesional de trabajo, en forma exclusiva en el desempeño de las funciones propias del oficio mencionado y en las labores anexas y complementarias del mismo, de conformidad con las órdenes e instrucciones que le imparta EL EMPLEADOR directamente o a través de sus representantes. b) A guardar absoluta reserva sobre los hechos, documentos, información y en general, sobre todos los asuntos y materias que lleguen a su conocimiento por causa o con ocasión de su contrato de trabajo. <strong><u>PARÁGRAFO PRIMERO:</u></strong> La descripción anterior es general y no excluye ni limita para ejecutar labores conexas complementarias, asesorías o similares y en general aquellas que sean necesarias para un mejor resultado en la ejecución de la causa que dio origen al contrato. <strong><u>PARÁGRAFO SEGUNDO:</u></strong> Hace parte integral del presente contrato, las funciones detalladas en el manual de competencias del presente cargo.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>SEGUNDA.- LUGAR DE PRESTACIÓN DE SERVICIOS:</strong>
                        EL TRABAJADOR cumplirá las labores para las cuales fue contratado en las Instalaciones de EL EMPLEADOR, sin embargo, EL EMPLEADOR de acuerdo a la naturaleza de los servicios podrá destinarle otros sitios, por tanto, EL TRABAJADOR deberá presentarse a prestar servicios en el lugar y fecha señalada, obligación que acepta en este acto, configurando su incumplimiento como inasistencia injustificada al trabajo. PARAGRAFO PRIMERO: Las partes podrán convenir que el trabajo se preste en un lugar distinto del inicialmente contratado, siempre que tales traslados no desmejoren las condiciones laborales o de remuneración del TRABAJADOR, o impliquen perjuicios para él. Los gastos que se originen con el traslado serán cubiertos por el EMPLEADOR de conformidad con el numeral 8º del artículo 57 del Código Sustantivo del Trabajo. El trabajador se obliga a aceptar los cambios de oficio que decida el EMPLEADOR dentro de su poder subordinante, siempre que se respeten las condiciones laborales del trabajador y no se le causen perjuicios. Todo ello sin que se afecte el honor, la dignidad y los derechos mínimos del TRABAJADOR, de conformidad con el artículo 23 del código sustantivo del Trabajo, modificado por el artículo 1º de la ley 50 de l990
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>TERCERA. - RESPONSABILIDAD DEL TRABAJADOR:</strong> EL TRABAJADOR se comprometerá a:
                    </p>
                    <ol>
                        <li>Cumplir con el horario de Trabajo definido por la Corporación.</li>
                        <li>Cumplir con las obligaciones señaladas en el reglamento de trabajo, manual de funciones, circulares y directrices, emitidas por la Corporación en transcurso del desarrollo del Contrato Laboral.</li>
                        <li>Mantener relaciones respetuosas con sus compañeros de trabajo, comunidad estudiantil y en la ejecución de su labor, favoreciendo un clima cordial, culto e igualitario.</li>
                        <li>Suscribir el acuerdo de Confidencialidad y tratamiento de datos personales, determinado por la Corporación.</li>
                        <li>No ejercer actos de Competencia desleal frente a la Corporación.</li>
                        <li>Respetar los sitios de trabajo asignados por la Corporación.</li>
                        <li>Rendir informe general de actividades a su jefe inmediato.</li>
                        <li>Responder por daños ocasionados a los implementos de trabajo, herramientas, y/o materias primas, por mal uso, negligencia y falta de cuidado.</li>
                        <li>Manejar correctamente los implementos de trabajo, materia prima e inventario que se entregue bajo su custodia, cuidado y responsabilidad.</li>
                        <div class="salto-linea"></div>
                        <li>Vigilar y ayudar a prevenir riesgos de accidente laboral reportando todos los aspectos de riesgo a su jefe inmediato.</li>
                        <li>Verificar todas las medidas de seguridad industrial antes de ejecutar las tareas asignadas y cuidar su integridad personal.</li>
                        <li>Dedicar la totalidad de su jornada de trabajo a cumplir a cabalidad con sus funciones.</li>
                        <li>Utilizar diariamente el huellero, o cualquier otro medio de control que se adopte para verificar la asistencia.</li>
                        <li>Notificar oportunamente el estado de salud en que se encuentra y presentar las incapacidades a que haya lugar.</li>
                        <li>Cumplir con el procedimiento de permiso y no ausentarse sin permiso del sitio de trabajo.</li>
                        <li>Programar diariamente su trabajo y asistir puntualmente a las reuniones a las que haya sido citado por parte de la Corporación y/o sus superiores jerárquicos.</li>
                        <li>Conservar y restituir en buen estado, salvo el deterioro natural, los instrumentos y herramientas que le hayan sido facilitados para desarrollar su puesto de trabajo.</li>
                        <li>Informar oportunamente las dificultades o inconsistencias que se presenten para la ejecución de las actividades a su cargo.</li>
                        <li>Presentarse al sitio de trabajo asignado, en óptimas condiciones para prestar el servicio, no alterado por estado de embriaguez o bajo la influencia de narcóticos u otras sustancias que afecten su buen desempeño.</li>
                        <li>Concurrir a prestar el servicio, teniendo en cuenta las recomendaciones de presentación personal que señala la Corporación y la normatividad legal vigente.</li>
                        <li>Acatar las órdenes e instrucciones que le sean encomendadas por su jefe inmediato y superiores jerárquicos.</li>
                        <li>Cumplir con el Reglamento de trabajo y manual de funciones, así como con todas las labores anexas y complementarias del presente cargo, de conformidad con las órdenes e instrucciones que le imparta la Corporación, directamente o a través de sus representantes.</li>
                        <li>Utilizar las plataformas tecnológicas de la Institución (Campus Virtual, página web, WhatsApp y demás aplicativos que se empleen en CIAF. </li>
                        <li>Todas las demás obligaciones consagradas en el Artículo 58 del C.S.T.</li>
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
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong> QUINTA. - OBLIGACIONES DE EL EMPLEADOR: </strong> Son Obligaciones especiales de EL EMPLEADOR: a) Colocar a disposición de los Trabajadores, salvo estipulaciones en contrario, los instrumentos adecuados para la realización de las labores encomendadas. b) Efectuar la afiliación, cotización, descuento a EL TRABAJADOR y realizar el respectivo pago al sistema de seguridad social en Salud, Pensiones, Riesgos laborales. c) Realizar la Afiliación y pago a la caja de compensación familiar. d) Pagar los salarios y demás prestaciones sociales a que haya lugar. e) Todas las demás consagradas en el Art. 57 del C.S.T.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>SEXTA.- REMUNERACION:</strong> La remuneración de EL TRABAJADOR será la suma mensual de
                        <span> <?php echo $contrato_docente->numero_a_letras($valor_contrato); ?> pesos m/c. (<?php echo "$" . number_format($valor_contrato, 0, ',', '.'); ?>) </span> <span> <?php echo ($auxilio_transporte == 1) ? ',más auxilio de transporte,' : ''; ?></span> suma que serán liquidada y pagada proporcionalmente por períodos quincenales.
                        <strong><u>PARÁGRAFO PRIMERO:</u></strong> Los valores antes mencionados serán liquidados y pagados en la respectiva cuenta bancaria que para tal fin indique EL TRABAJADOR.
                        <strong><u>PARÁGRAFO SEGUNDO:</u></strong> Dentro de este pago se encuentra incluida la remuneración de los descansos dominicales y festivos de que tratan los capítulos I y II del título VII del Código Sustantivo del Trabajo.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>SÉPTIMA. - TRABAJO NOCTURNO, SUPLEMENTARIO, DOMINICAL Y/O FESTIVO:</strong> Todo trabajo suplementario o en horas extras y todo trabajo en día domingo o festivo en los que legalmente debe concederse descanso, se remunerará conforme a la Ley, así como los correspondientes recargos nocturnos. Para el reconocimiento y pago del trabajo suplementario, nocturno, dominical o festivo, EL EMPLEADOR o sus representantes deberán haberlo autorizado previamente y por escrito. Cuando la necesidad de este trabajo se presente de manera imprevista o inaplazable, deberá ejecutarse y darse cuenta de él por escrito, a la mayor brevedad, a EL EMPLEADOR, o a sus representantes para su aprobación. EL EMPLEADOR, en consecuencia, no reconocerá ningún trabajo suplementario, o trabajo nocturno, o en días de descanso legalmente obligatorio que no haya sido autorizado previamente o que, habiendo sido avisado inmediatamente, no haya sido aprobado como queda dicho.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>OCTAVA. - JORNADA DE TRABAJO:</strong> EL TRABAJADOR , se obliga a laborar la jornada de tiempo completo, equivalente a 44 horas semanales laboradas, salvo estipulación expresa y escrita en contrario, en los turnos y dentro de las horas señalados por La Corporación, pudiendo hacer éste los ajustes o cambios de horario cuando lo estime conveniente. Por el acuerdo expreso o tácito de las partes, podrán repartirse las horas de la jornada ordinaria en la forma prevista en la Ley, teniendo en cuenta que los tiempos de descanso entre las secciones de la jornada no se computan dentro de la misma. <strong>PARAGRAFO PRIMERO: </strong> De acuerdo a lo establecido en la Ley 2101 de 2021, se estableció la reducción de la jornada laboral semanal de manera gradual, por lo que a partir del día 15 de julio de 2026, se reducirá dos (2) hora de la jornada laboral semanal, quedando la jornada semanal en 42 horas semanales.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>NOVENA. - BENEFICIOS EXTRALEGALES:</strong> EL EMPLEADOR podrá reconocer beneficios, bonos, incentivos, primas, prestaciones de naturaleza extra legal, lo que se hace a título de mera liberalidad y estos subsistirán hasta que EL EMPLEADOR, decida su modificación o supresión, atendiendo su capacidad, todos los cuales se otorgan y reconocen y EL TRABAJADOR así lo acuerdan, sin que tengan carácter salarial y por lo tanto no tienen efecto prestacional o incidencia en la base de aportes en la seguridad social o parafiscal en especial éste acuerdo se refiere a auxilios en dinero o en especie, primas periódicas o de antigüedad o en general beneficios de esa naturaleza los que podrán ser modificados o suprimidos por el Empleador de acuerdo con su determinación unilateral tal como fue otorgado.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA. - DESCUENTOS:</strong> EL TRABAJADOR autoriza para que EL EMPLEADOR descuente cualquier suma de dinero que se cause dentro de la existencia y terminación del contrato de trabajo ya sea por concepto de préstamos, alimentación a bajo costo, bonos de alimentación, vivienda, utilización de medios de comunicación, bienes dados a cargo y no reintegrados, u otros que se presenten en ejercicio de la labor que desarrolla. Este descuento se podrá realizar de la nómina mensual o de las prestaciones sociales, indemnizaciones, descansos o cualquier beneficio que resulte con ocasión de la existencia o terminación del contrato por cualquier motivo.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>UNDÉCIMA. - PERIODO DE PRUEBA:</strong> Se considera como período de prueba la quinta parte del término inicialmente pactado para el presente contrato, el cual bajo ninguna circunstancia podrá exceder de dos meses. Por consiguiente, cualquiera de las partes podrá terminar el contrato unilateralmente en cualquier momento durante dicho período, sin que se cause el pago de indemnización alguna.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DUODÉCIMA. - DURACION DEL CONTRATO:</strong> El presente contrato tendrá un término fijo contado a partir del día <?php echo htmlspecialchars($dia_inicio); ?> de <?php echo htmlspecialchars($mes_inicio_texto); ?> del <?php echo $contrato_docente->convertirAnioALetrasSimple($anio_inicio); ?> (<?php echo htmlspecialchars($anio_inicio); ?>), hasta el día <?php echo htmlspecialchars($dia_final); ?> de <?php echo htmlspecialchars($mes_final_texto); ?> del <?php echo $contrato_docente->convertirAnioALetrasSimple($anio_final); ?> (<?php echo htmlspecialchars($anio_final); ?>),
                        <strong><u>PARÁGRAFO PRIMERO:</u></strong> Si antes de la fecha de vencimiento del término estipulado, ninguna de las partes avisare por escrito a la otra su determinación de no prorrogar el contrato, con una antelación no inferior a treinta (30) días, éste se entenderá renovado por un período igual al inicialmente pactado.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA TERCERA. - TERMINACION UNILATERAL:</strong> Son justas causas para dar por terminado unilateralmente este contrato, por cualquiera de las partes, las que establece la Ley, el reglamento, manual de funciones, el presente contrato y/o las circulares que a lo largo de la ejecución del presente contrato establezcan conductas no previstas en virtud de hechos o tecnologías o cambios de actividad diferentes a las consideradas en el presente contrato. Se trata de reglamentaciones, ordenes instrucciones de carácter general o particular que surjan con posterioridad al presente acuerdo, cuya violación sea calificada como grave. Expresamente se califican en este acto como faltas graves la violación a las obligaciones y prohibiciones descritas y además las siguientes:
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <ol>
                        <li>El incumplimiento de normas y políticas que tenga la Corporación para el uso de los sistemas, informática, software, claves de seguridad, materia prima, herramientas de trabajo, inventarios, útiles de oficina, que la Corporación entrega a EL TRABAJADOR para la mejor ejecución de sus funciones.</li>
                        <li>La utilización para fines distintos a los considerados por EL EMPLEADOR para el cumplimiento de su objeto social de las bases de datos o cualquier documento de su propiedad.</li>
                        <li>Desatender las actividades de capacitación programadas por EL EMPLEADOR.</li>
                        <li>La inadecuada atención y desinterés para con los clientes internos y externos.</li>
                        <li>En caso de laborar en turnos, efectuar cambios sin la debida autorización del jefe inmediato.</li>
                        <li>Llegar tarde o no presentarse al sitio de trabajo.</li>
                        <li>Desatender la obligación de identificación y control de peligros y riesgos en su puesto de trabajo que puedan prevenir accidentes de trabajo y enfermedades laborales.</li>
                        <li>Negarse a cumplir con los protocolos y procesos para la prestación de servicios encomendados, y demás establecidos por la Corporación en desarrollo de su objeto social.</li>
                        <li>Violar el acuerdo de confidencialidad determinado por la Corporación, en cuanto a entregar información a terceros.</li>
                        <li>Toda pérdida, desvío, daño, mal uso que se haga de los instrumentos de trabajo o de dineros de propiedad de la Corporación, se tendrá como causal justa para dar por terminado unilateralmente el contrato de trabajo. Para tales efectos en todo contrato de trabajo va envuelta la condición resolutiva por incumplimiento de lo pactado, con indemnización de perjuicios a cargo de la parte responsable. Esta indemnización comprende el lucro cesante y el daño emergente (numeral 1 del Art. 64 del C.S.T.).</li>
                        <li>Cualquier acto de irrespeto o discriminación.</li>
                        <li>Presentarse al sitio de trabajo asignado, alterado por estado de embriaguez o bajo la influencia de narcóticos u otras sustancias que afecten su buen desempeño.</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA CUARTA. - CONCILIACIÓN:</strong> Las partes manifiestan expresamente que las diferencias que surjan entre EL EMPLEADOR y EL TRABAJADOR, en razón del desarrollo y ejecución de este contrato, se someterán en primera medida a conciliación previa entre las partes y de acuerdo a lo estipulado en el reglamento interno de trabajo.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA QUINTA. - MODIFICACION DE LAS CONDICIONES LABORALES:</strong> EL TRABAJADOR acepta desde ahora expresamente todas las modificaciones determinadas por EL EMPLEADOR, en ejercicio de su poder subordinante, de sus condiciones laborales, tales como la jornada de trabajo, el lugar de prestación de servicio, el cargo u oficio y/o funciones y la forma de remuneración, siempre que tales modificaciones no afecten su honor, dignidad o sus derechos mínimos ni impliquen desmejoras sustanciales o graves perjuicios para él, de conformidad con lo dispuesto por el Art.23 del C.S.T., modificado por el Art.1o. de la Ley 50/90. Los gastos que se originen con el traslado de lugar de prestación del servicio serán cubiertos por EL EMPLEADOR de conformidad con el numeral 8o. del Art.57 del C.S.T.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA SEXTA. - CONFIDENCIALIDAD:</strong> Las partes reconocen expresamente que las funciones que desarrollarán con relación a los servicios a que se refiere el presente contrato, lo pondrán en contacto con los secretos industriales, técnicos, operacionales y comerciales de la otra PARTE, así como aquellos pertenecientes a sus socios, asociados, accionistas, filiales, subsidiarias, clientes, contratistas y cualesquiera otras personas relacionadas, además de la información privilegiada y confidencial de las operaciones de las partes.

                        Por lo anterior, y para fines del presente contrato, serán considerados “secretos” incluyendo, de manera enunciativa mas no limitativa, todos aquellos conocimientos industriales, técnicos, comerciales y operacionales, diseños, modelos, base de datos, listas de precios, registros, datos, materiales, planes y proyectos de comercialización y ventas, publicidad e información de cualquier tipo relacionada con los negocios y operaciones de las PARTES, y/o de las demás personas relacionadas directa o indirectamente con ésta. <strong>PARÁGRAFO PRIMERO:</strong> Las partes se obligan a mantener en secreto y bajo estricta confidencialidad toda la documentación e información, que cada PARTE reciba de la otra, sea con relación a los servicios prestados en función de su cargo conferido con el presente contrato, o cualquier otra información que directa o indirectamente tuviera conexión con los negocios y operaciones de la otra PARTE, independientemente de la forma y medio en que dicha información sea proporcionada, difundida o expuesta. Igualmente, queda obligado a no revelar ni a divulgar en forma alguna la información relacionada con los servicios, incluyendo aquella información identificada por cualquier instrumento o medio, como “confidencial”, “reservada”, “privilegiada”, “privada” o bajo cualquier otro término similar, sea propiedad de las PARTES o cualquier otra persona que tuviera relación directa o indirecta con la misma, independientemente del medio o instrumento en que dicha información estuviera contenida. Ambas partes reconocen y se obligan a que el acuerdo de propiedad intelectual y confidencialidad a que se refiere esta cláusula y demás disposiciones relativas contenidas en el presente contrato, continuarán vigentes por un período de cinco años más después de finalizada la presente relación comercial.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA SÉPTIMA: PROPIEDAD INTELECTUAL E INVENCIONES:</strong> Las invenciones realizadas por EL TRABAJADOR le pertenecen a la Corporación, siempre y cuando estas sean realizadas con ocasión y dentro de la ejecución del contrato de trabajo, y como parte del cumplimiento de las obligaciones del cargo. También lo son aquellas que se obtienen mediante los datos y medios conocidos o utilizados en razón de la labor desempeñada. En tal virtud, EL TRABAJADOR, accederá a facilitar el cumplimiento oportuno de las respectivas formalidades y firmará y otorgará los poderes y documentos necesarios en orden a reconocer la propiedad de la Corporación cuando ésta lo solicite a EL TRABAJADOR. <strong><u>PARÁGRAFO PRIMERO:</u></strong><strong> DERECHOS DE AUTOR:</strong> Los derechos patrimoniales sobre las obras, diseños invenciones, investigaciones etc. creadas por EL TRABAJADOR, en ejercicio de sus funciones o con ocasión ellas pertenecen a la Corporación.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DECIMA OCTAVA: ANEXOS:</strong> Hacen parte integral del presente contrato, todos y cada uno de los documentos que con causa o con ocasión a la relación de trabajo deben socializarse y conocerse entre las partes, así como los que deban incluirse por el cambio y/o expedición de normas legales, en especial: a. Manual de funciones. b. Reglamento de Trabajo. c. Acuerdo de propiedad intelectual y confidencialidad. d. Autorización tratamiento de datos personales. e. Procedimientos, circulares, directrices y demás documentos que provengan de EL EMPLEADOR, para emitir instrucciones y/o dar claridad al trabajo desempeñado. f. Demás documentos que deban ser parte del presente contrato.
                    </p>
                </div>
            </div>
            <div class="salto-linea"></div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>DÉCIMA NOVENA: PROTECCIÓN Y TRATAMIENTO DE DATOS PERSONALES:</strong> En cumplimiento de lo dispuesto por la Ley 1581 de 2012, Decreto 1377 de 2013 Toda persona tiene derecho a 1- Conocer. 2- Actualizar. 3- Rectificar, las informaciones que se hayan recogido sobre ellas, en base de datos o archivos. Este es un derecho Constitucional consagrado en el artículo 15 y 20 de la Constitución Política y desarrollado en la Ley 1581 de 2012, conocida como la ley de protección de datos personales (Habeas Data) y reglamentada por el Decreto 1074 de 2015 capítulo 25.
                        <strong><u>PARÁGRAFO PRIMERO:</u></strong> EL EMPLEADOR, como responsable del Tratamiento de datos Durante La Relación Laboral: deberá almacenar los datos personales e información personal obtenida del proceso de selección de los empleados en una carpeta identificada con el nombre de cada uno de ellos. Esta carpeta física o digital solo será accedida y tratada por el Área Administrativa, con la finalidad de administrar la relación contractual entre la Corporación y el colaborador. El uso de la información de los empleados para fines diferentes a la administración de la relación contractual, está prohibido en CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-. El uso diferente de los datos e información personal de los empleados solo procederá por orden de autoridad competente, siempre que en ella radique tal facultad. Corresponderá al Representante Legal, evaluar la competencia y eficacia de la orden de la autoridad competente, con el fin de prevenir una cesión no autorizada de datos personales.
                        <strong><u>PARÁGRAFO SEGUNDO:</u></strong> Terminada la relación laboral, cualquiera que fuere la causa, CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-, procederá a almacenar los datos personales obtenidos del proceso de selección y documentación generada en el desarrollo de la relación laboral, en un archivo central, sometiendo tal información a medidas y niveles de seguridad altas, en virtud de la potencialidad de que la información laboral pueda contener datos sensibles. CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-, tiene prohibido ceder tal información a terceras partes, pues tal hecho puede configurar una desviación en la finalidad para la cual fueron entregados los datos personales por sus titulares. Lo anterior, salvo autorización previa y escrita que documente el consentimiento por parte del titular del dato personal.
                        <strong><u>PARÁGRAFO TERCERO:</u></strong> <strong>USO DE LA IMAGEN:</strong> EL TRABAJADOR autoriza a EL EMPLEADOR para hacer uso y tratamiento de su derecho de imagen para incluirlos sobre fotografías, procedimientos análogos a la fotografía, producciones audiovisuales y todos aquellos conexos que tengan que ver con el derecho de imagen en medio electrónico, magnético, óptico, en redes, mensaje de datos o similares. Sin limitación geográfica o territorial alguna en vigencia o no del presente contrato para uso institucional, comercial o mercadeo que beneficie a la institución.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>VIGESIMA. - EFECTOS:</strong> El presente contrato reemplaza en su integridad y deja sin efecto cualquiera otro contrato, verbal o escrito, celebrado entre las partes con anterioridad, pudiendo las partes convenir por escrito modificaciones al mismo, las que formarán parte integrante de este contrato.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="text-align: justify;">
                    <p>
                        <strong>VÍGESIMA PRIMERA: - AUTORIZACIÓN DE NOTIFICACIÓN:</strong> En virtud del presente contrato EL TRABAJADOR autoriza a EL EMPLEADOR a realizar cualquier notificación relacionada con la relación laboral a través del correo electrónico institucional que se le proporcionará AL TRABAJADOR y/o al correo personal <?php echo htmlspecialchars($usuario_email_p); ?>.
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
            <div class="mt-4" style="width: 100%; border: 1px solid black; border-collapse: collapse; display: table;">
                <div style="display: table-row;">
                    <div style="display: table-cell; border: 1px solid black; padding: 5px; text-align: center;">
                        <strong>Elaboró</strong><br>
                        <?php echo $nombre_usuario_creo_contrato; ?>
                        <br>
                        <?php echo $cargo_usuario; ?>
                    </div>
                    <div style="display: table-cell; border: 1px solid black; padding: 5px; text-align: center;">
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
