<?php
session_start();

require_once "../modelos/Idiomas.php";
$idiomas = new Idiomas();
switch ($_GET['op']) {
    case 'listar':
        $niveles = $idiomas->listar_niveles();
        $data['conte'] = '';
        $data['valor'] = 0;
        $data['cant'] = 0;
        $data['texto_materias_g'] = 0;
        $data['id_estudiante_ing'] = 0;
        $cant = 0;
        $programa = '';
        $data['nivel'] = '';
        $mensaje = '';
        $todosPagados = true;  // Asumimos que todos están pagados al principio
        $puedeAvanzar = false;  // Variable para determinar si el usuario puede avanzar al siguiente curso
        $haPerdido = false;     // Variable para determinar si el usuario ha perdido el curso
        $data['conte'] .= '<table class="table">
    <thead>
    <tr>';
        if (!$todosPagados) {
            // Mostrar la columna "Cantidad a pagar"
            $data['conte'] .= '<th scope="col">Cantidad a pagar</th>';
        }
        $data['conte'] .= '<th scope="col">Nivel</th>
        <th scope="col">Valor</th>
        <th scope="col">Estado</th>
        </tr>
        </thead>
        <tbody>';
        $bandera = false;
        $estudiantes_ids = array(); // Crear un arreglo para almacenar todos los IDs de estudiantes
        for ($i = 0; $i < count($niveles); $i++) {
            $id_credencial = $_SESSION['id_usuario'];
            $traer_id_estudiante = $idiomas->traeridestudiante($id_credencial, $niveles[$i]['id_programa']);
            $id_estudiante = null; // Inicializa $id_estudiante como null

            // Verifica si la función traeridestudiante devolvió un resultado
            if ($traer_id_estudiante && is_array($traer_id_estudiante)) {
                // Acceder al id_estudiante si existe en el resultado
                if (isset($traer_id_estudiante['id_estudiante'])) {
                    $id_estudiante = $traer_id_estudiante['id_estudiante'];
                    // Agregar el id_estudiante al arreglo de estudiantes
                    $estudiantes_ids[] = $id_estudiante;
                }
            }
            $data['id_estudiante_ing'] = $id_estudiante;
            $data['id_programa_estudiante'] = $niveles[$i]['id_programa'];
            //entra al condicional cuando el estudiante no este registrando 
            if (empty($id_estudiante)) {
                $consulta_pagos = $idiomas->consulta_pagos($niveles[$i]['id_programa'], $id_estudiante);
                $valor_nivel = $idiomas->valor_cursos($niveles[$i]['id_programa']);
                // Crear un array para almacenar mensajes por materia
                $mensajesPorMateria = [];
                // Usamos un array asociativo para agrupar los pagos por nombre_materia
                $pagosAgrupados = [];
                $total_notas_2 = $idiomas->contar_cursos_ingles($niveles[$i]['id_programa'], $id_estudiante);
                $total_notas_2 = $total_notas_2["total_notas"];
                $sumaTotal = 0; // Inicializa la variable para la suma total
                foreach ($consulta_pagos as $pago) {
                    $notaPlataforma = (int)$pago['promedio']; // Convierte el valor a entero
                    $sumaTotal += $notaPlataforma; // Suma el valor a la suma total
                }
                // Verificar si $total_notas_2 es igual a cero
                if ($total_notas_2 == 0) {
                    $resultado_nota2 = 0; // O cualquier otro valor o acción que consideres apropiado
                } else {
                    $resultado_nota2 = $sumaTotal / $total_notas_2;
                }
                $puedeAvanzar = $resultado_nota2 >= 3; // 3 es el 60% de 5, que es la nota mínima para avanzar
                // Generamos el mensaje correspondiente
                $mensaje = $puedeAvanzar ? "Puedes avanzar" : "No puedes avanzar";
                // Almacenamos el mensaje en el array de mensajes por materia
                foreach ($consulta_pagos as $pago) {
                    // $notaPlataforma = $pago['promedio'];
                    $nombreMateria = $pago['nombre_materia'];
                    if (!isset($pagosAgrupados[$nombreMateria])) {
                        $pagosAgrupados[$nombreMateria] = [];
                    }
                    $pagosAgrupados[$nombreMateria][] = $pago;
                    $mensajesPorMateria[$nombreMateria] = $mensaje;
                }
                if ($consulta_pagos) {
                    $nombresDeMaterias = [];
                    foreach ($consulta_pagos as $pago) {
                        $nombresDeMaterias[] = $pago['nombre_materia'];
                    }
                    // condicional para pasar la tabla si todos los cursos estan aprovados
                    if ($mensaje == "Puedes avanzar") {
                    } else {
                        $bandera = true;
                        $programa = $niveles[$i]['id_programa'];
                        //trae la cantidad de asignaturas que tiene el curso de ingles
                        $nivel = explode(" ", $niveles[$i]['nombre']);
                        // muestra el nombre de la tabla (Inglés A1)
                        $data['nivel'] = "Idiomas " . $nivel[1];
                        $data['nivel_ingles'] = "Idiomas " . $nivel[1];
                        // trae la cantidad de las asignaturas y las resta con la cantidad de los pagos de ingles
                        $cant = $niveles[$i]['cant_asignaturas'];
                        // consulta el nivel de ingles Inglés A1
                        if ($data['nivel'] == "Idiomas A1") {
                            $e_start = 1; // Para ocultar "Idiomas A1-1"
                        } else {
                            //Muestra en las otras tablas los idiomas que comienzan desde "A2-1" menos en la tabla "Idiomas A1-1"
                            $e_start = 0;
                        }
                        $nombre_materias = array();
                        if (!empty($consulta_pagos)) { // Si hay pagos previos, los procesamos.
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']);
                                }
                            }
                            $nombre_materias = array_values(array_unique($nombre_materias));
                        }
                        for ($p = 0; $p < count($consulta_pagos); $p++) {
                            $nombre_materia = $consulta_pagos[$p]['nombre_materia'];
                        }
                        $nombre_materias = array();
                        if ($consulta_pagos) {
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']);
                                }
                            }
                        }
                        $nombre_materias = array_values(array_unique($nombre_materias));
                        $checkbox_list = 0;
                        for ($e = $e_start, $x = 1; $e < $cant; $e++, $x++) {
                            $levelIdCell = ($e + 1);
                            // $data['curso_ingles'] = ($e + 1);
                            $currentCursoFull = $niveles[$i]['nombre'];
                            $parts = explode(' ', $currentCursoFull);
                            //tomamos el ultimo array que seria el curso del nivel de ingles donde esta la tabla 
                            $nombre_nivel_ingles = end($parts);
                            $currentCurso = $nombre_nivel_ingles . '-' . $levelIdCell;
                            $isPaid = in_array($currentCurso, $nombre_materias);  // Verifica si el curso actual está en la matriz
                            $mensajeActual = isset($mensajesPorMateria[$currentCurso]) ? $mensajesPorMateria[$currentCurso] : "El curso no esta pagado";
                            if (!$isPaid) {
                                $todosPagados = false;
                            }
                            $ciclo = 6;
                            $jornada_matriculada = $niveles[$i]['nombre'] . "-" . $e + 1;
                            $paymentStatus = $isPaid ? '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Pagada</span>' : '<span class="bg-danger p-1"><i class="fas fa-times"></i> No está pagada</span>';
                            $checkedAttr = '';
                            $dataPaidAttr = $isPaid ? 'data-paid="true"' : '';
                            $checkbox_list = $isPaid ? $checkbox_list : $checkbox_list + 1;
                            $ocultar_checbox = $isPaid ? '' : '<input type="checkbox" disabled class="nivel-checkbox" id="checkbox_' . $checkbox_list . '" data-valor="' . $valor_nivel['valor'] . '" data-materia="' . $currentCurso . '" data-toggle="tooltip" title="Debes pagar los cursos en orden secuencial">';

                            $mostrar_promedio_estudiante = $idiomas->mosrtarpromediotabla($data['id_estudiante_ing'],  $data['id_programa_estudiante']);

                            $promedio_estudiante = array();
                            if ($mostrar_promedio_estudiante['estado'] == 5) {
                                $data['conte'] .= '';
                            } else {

                                $data['conte'] .= ' <tr>
                                <td>' . $ocultar_checbox . " <label class='h6' for='checkbox_$e'>" . $niveles[$i]['nombre'] . " - " . ($e + 1) . "</label> " . '</td>
                                <td>$ ' . $valor_nivel['valor'] . '</td>
                                <td>' . $paymentStatus;
                                '</td>
                                </tr>';

                                // if (!$todosPagados) {

                                // }
                            }
                        }


                        $valor_cantidad_cursos = $e - 1;  // Decrementa el valor de $e en 1
                        $data['cantidad_cursos'] = $valor_cantidad_cursos;
                        $data['valor'] = $valor_nivel['valor'];
                        $data['cant'] = $cant;
                    }
                } else {
                    if (!$bandera) {
                        // echo($bandera);
                        $nivel = explode(" ", $niveles[$i]['nombre']);
                        $programa = $niveles[$i]['id_programa'];
                        $data['nivel'] = "Idiomas " . $nivel[1];
                        $programa = $niveles[$i]['id_programa'];
                        //trae la cantidad de asignaturas que tiene el curso de ingles
                        $nivel = explode(" ", $niveles[$i]['nombre']);
                        // muestra el nombre de la tabla (Inglés A1)
                        $data['nivel'] = "Idiomas " . $nivel[1];
                        $data['nivel_ingles'] = "Idiomas " . $nivel[1];
                        // trae la cantidad de las asignaturas y las resta con la cantidad de los pagos de ingles
                        $cant = $niveles[$i]['cant_asignaturas'];
                        // consulta el nivel de ingles Inglés A1
                        if ($data['nivel'] == "Idiomas A1") {
                            $e_start = 1; // Para ocultar "Idiomas A1-1"
                        } else {
                            $e_start = 0; // Muestra en las otras tablas los idiomas que comienzan desde "Idiomas A2-1" menos en la tabla "Idiomas A1-1"
                        }
                        $nombre_materias = array();
                        if (!empty($consulta_pagos)) { // Si hay pagos previos, los procesamos.
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']);
                                }
                            }
                            $nombre_materias = array_values(array_unique($nombre_materias));
                        }
                        for ($p = 0; $p < count($consulta_pagos); $p++) {
                            $nombre_materia = $consulta_pagos[$p]['nombre_materia'];
                        }
                        $nombre_materias = array();
                        if ($consulta_pagos) {
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']); // Usando trim() aquí
                                }
                            }
                        }
                        $nombre_materias = array_values(array_unique($nombre_materias));
                        $checkbox_list = 0;
                        for ($e = $e_start, $x = 1; $e < $cant; $e++, $x++) {
                            $levelIdCell = ($e + 1);
                            // $data['curso_ingles'] = ($e + 1);
                            $currentCursoFull = $niveles[$i]['nombre'];
                            $parts = explode(' ', $currentCursoFull);
                            //tomamos el ultimo array que seria el curso del nivel de ingles donde esta la tabla 
                            $nombre_nivel_ingles = end($parts);
                            $currentCurso = $nombre_nivel_ingles . '-' . $levelIdCell;
                            $isPaid = in_array($currentCurso, $nombre_materias);  // Verifica si el curso actual está en la matriz
                            $mensajeActual = isset($mensajesPorMateria[$currentCurso]) ? $mensajesPorMateria[$currentCurso] : "El curso no esta pagado";
                            if (!$isPaid) {
                                $todosPagados = false;
                            }
                            $ciclo = 6;
                            $jornada_matriculada = $niveles[$i]['nombre'] . "-" . $e + 1;
                            $paymentStatus = $isPaid ? '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Pagada</span>' : '<span class="bg-danger p-1"><i class="fas fa-times"></i> No está pagada</span>';
                            $checkedAttr = '';
                            $dataPaidAttr = $isPaid ? 'data-paid="true"' : '';
                            $checkbox_list = $isPaid ? $checkbox_list : $checkbox_list + 1;
                            $ocultar_checbox = $isPaid ? '' : '<input type="checkbox" disabled class="nivel-checkbox" id="checkbox_' . $checkbox_list . '" data-valor="' . $valor_nivel['valor'] . '" data-materia="' . $currentCurso . '" data-toggle="tooltip" title="Debes pagar los cursos en orden secuencial">';

                            @$mostrar_promedio_estudiante = $idiomas->mosrtarpromediotabla($data['id_estudiante_ing'],  $data['id_programa_estudiante']);

                            $promedio_estudiante = array();
                            if (@$mostrar_promedio_estudiante['estado'] == 5) {
                                $data['conte'] .= '';
                            } else {

                                $data['conte'] .= ' <tr>
                                <td>' . $ocultar_checbox . " <label class='h6' for='checkbox_$e'>" . $niveles[$i]['nombre'] . " - " . ($e + 1) . "</label> " . '</td>
                                <td>$ ' . $valor_nivel['valor'] . '</td>
                                <td>' . $paymentStatus;
                                '</td>
                                </tr>';

                                // if (!$todosPagados) {
                                //     $data['conte'] .= '
                                // <td>

                                // </td>';
                                // }

                            }
                        }

                        $valor_cantidad_cursos = $e - 1;  // Decrementa el valor de $e en 1
                        $data['cantidad_cursos'] = $valor_cantidad_cursos;
                        $data['valor'] = $valor_nivel['valor'];
                        $data['cant'] = $cant;
                    }
                }

                break;
                // aqui entra cuando el estudiante ya esta registrado 
            } else {
                $consulta_pagos = $idiomas->consulta_pagos($niveles[$i]['id_programa'], $id_estudiante);
                $resultado_nota = "";
                $total_notas = $idiomas->contar_cursos_ingles($niveles[$i]['id_programa'], $id_estudiante);
                $total_notas1 = $total_notas["total_notas"];
                $sumaTotal = 0; // Inicializa la variable para la suma total
                foreach ($consulta_pagos as $pago) {
                    $notaPlataforma = (int)$pago['promedio']; // Convierte el valor a entero
                    $sumaTotal += $notaPlataforma; // Suma el valor a la suma total
                }
                $resultado_nota = $sumaTotal / $total_notas1;
                $valor_nivel = $idiomas->valor_cursos($niveles[$i]['id_programa']);
                // Crear un array para almacenar mensajes por materia
                $mensajesPorMateria = [];
                // Usamos un array asociativo para agrupar los pagos por nombre_materia
                $pagosAgrupados = [];
                $puedeAvanzar = $resultado_nota >= 3; // 3 es el 60% de 5, que es la nota mínima para avanzar
                // Generamos el mensaje correspondiente
                $mensaje = $puedeAvanzar ? "Puedes avanzar" : "No puedes avanzar";
                foreach ($consulta_pagos as $pago) {
                    $nombreMateria = $pago['nombre_materia'];
                    if (!isset($pagosAgrupados[$nombreMateria])) {
                        $pagosAgrupados[$nombreMateria] = [];
                    }
                    $pagosAgrupados[$nombreMateria][] = $pago;
                    // Almacenamos el mensaje en el array de mensajes por materia
                    $mensajesPorMateria[$nombreMateria] = $mensaje;
                }
                if ($consulta_pagos) {
                    $nombresDeMaterias = [];
                    foreach ($consulta_pagos as $pago) {
                        $nombresDeMaterias[] = $pago['nombre_materia'];
                    }
                    // aqui vamos hacer el condicional para por medio de la cantidad verificar si es igual a las que tiene el estudiante registradas para que pueda avanzar
                    $nivel = explode(" ", $niveles[$i]['nombre']);
                    $prueba_nivel = "Idiomas " . $nivel[1];
                    if ($prueba_nivel === "Idiomas A1") {
                        $cantindad_asignaturas = $niveles[$i]['cant_asignaturas'] - 1;
                    } else {
                        $cantindad_asignaturas = $niveles[$i]['cant_asignaturas'];
                    }
                    // condicional para pasar la tabla si todos los cursos estan aprovados
                    if ($total_notas1 == $cantindad_asignaturas and $mensaje === "Puedes avanzar") {
                    } else {
                        $bandera = true;
                        $programa = $niveles[$i]['id_programa'];
                        //trae la cantidad de asignaturas que tiene el curso de ingles
                        $nivel = explode(" ", $niveles[$i]['nombre']);
                        // muestra el nombre de la tabla (Inglés A1)
                        $data['nivel'] = "Idiomas " . $nivel[1];
                        $data['nivel_ingles'] = "Idiomas " . $nivel[1];
                        // trae la cantidad de las asignaturas y las resta con la cantidad de los pagos de ingles
                        $cant = $niveles[$i]['cant_asignaturas'];
                        // consulta el nivel de ingles Inglés A1
                        if ($data['nivel'] == "Idiomas A1") {
                            $e_start = 1; // Para ocultar "Idiomas A1-1"
                        } else {
                            //Muestra en las otras tablas los idiomas que comienzan desde "A2-1" menos en la tabla "Idiomas A1-1"
                            $e_start = 0;
                        }
                        $nombre_materias = array();
                        if (!empty($consulta_pagos)) { // Si hay pagos previos, los procesamos.
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']);
                                }
                            }
                            $nombre_materias = array_values(array_unique($nombre_materias));
                        }
                        for ($p = 0; $p < count($consulta_pagos); $p++) {
                            $nombre_materia = $consulta_pagos[$p]['nombre_materia'];
                        }
                        $nombre_materias = array();
                        if ($consulta_pagos) {
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']);
                                }
                            }
                        }
                        $nombre_materias = array_values(array_unique($nombre_materias));
                        $checkbox_list = 0;
                        for ($e = $e_start, $x = 1; $e < $cant; $e++, $x++) {
                            $levelIdCell = ($e + 1);
                            // $data['curso_ingles'] = ($e + 1);
                            $currentCursoFull = $niveles[$i]['nombre'];
                            $parts = explode(' ', $currentCursoFull);
                            //tomamos el ultimo array que seria el curso del nivel de ingles donde esta la tabla 
                            $nombre_nivel_ingles = end($parts);
                            $currentCurso = $nombre_nivel_ingles . '-' . $levelIdCell;
                            $isPaid = in_array($currentCurso, $nombre_materias);  // Verifica si el curso actual está en la matriz
                            $mensajeActual = isset($mensajesPorMateria[$currentCurso]) ? $mensajesPorMateria[$currentCurso] : "El curso no esta pagado";
                            if (!$isPaid) {
                                $todosPagados = false;
                            }
                            $ciclo = 6;
                            $jornada_matriculada = $niveles[$i]['nombre'] . "-" . $e + 1;
                            $paymentStatus = $isPaid ? '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Pagada</span>' : '<span class="bg-danger p-1"><i class="fas fa-times"></i> No está pagada</span>';
                            $checkedAttr = '';
                            $dataPaidAttr = $isPaid ? 'data-paid="true"' : '';
                            $checkbox_list = $isPaid ? $checkbox_list : $checkbox_list + 1;
                            $ocultar_checbox = $isPaid ? '' : '<input type="checkbox" disabled class="nivel-checkbox" id="checkbox_' . $checkbox_list . '" data-valor="' . $valor_nivel['valor'] . '" data-materia="' . $currentCurso . '" data-toggle="tooltip" title="Debes pagar los cursos en orden secuencial">';


                            $mostrar_promedio_estudiante = $idiomas->mosrtarpromediotabla($data['id_estudiante_ing'],  $data['id_programa_estudiante']);

                            $promedio_estudiante = array();
                            if ($mostrar_promedio_estudiante['estado'] == 5) {
                                $data['conte'] .= '';
                            } else {

                                $data['conte'] .= ' <tr>
                                <td>' . $ocultar_checbox . " <label class='h6' for='checkbox_$e'>" . $niveles[$i]['nombre'] . " - " . ($e + 1) . "</label> " . '</td>
                                <td>$ ' . $valor_nivel['valor'] . '</td>
                                <td>' . $paymentStatus;
                                '</td>
                                </tr>';

                                // if (!$todosPagados) {
                                //     $data['conte'] .= '
                                // <td>
                                // <button type="button" id="btnPagar" onclick="generarBotones()" disabled class="btn btn-sm bg-navy btn-flat btn-block" data-toggle="modal" data-target=".exampleModal_una">
                                //     <i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"> Pagar </i></i>
                                // </button>
                                // </td>';
                                // }

                            }
                        }


                        $valor_cantidad_cursos = $e - 1;  // Decrementa el valor de $e en 1
                        $data['cantidad_cursos'] = $valor_cantidad_cursos;
                        $data['valor'] = $valor_nivel['valor'];
                        $data['cant'] = $cant;
                    }
                } else {
                    if (!$bandera) {
                        // echo($bandera);
                        $nivel = explode(" ", $niveles[$i]['nombre']);
                        $programa = $niveles[$i]['id_programa'];
                        $data['nivel'] = "Idiomas " . $nivel[1];
                        $programa = $niveles[$i]['id_programa'];
                        //trae la cantidad de asignaturas que tiene el curso de ingles
                        $nivel = explode(" ", $niveles[$i]['nombre']);
                        // muestra el nombre de la tabla (Inglés A1)
                        $data['nivel'] = "Idiomas " . $nivel[1];
                        $data['nivel_ingles'] = "Idiomas " . $nivel[1];
                        // trae la cantidad de las asignaturas y las resta con la cantidad de los pagos de ingles
                        $cant = $niveles[$i]['cant_asignaturas'];
                        // consulta el nivel de ingles Inglés A1
                        if ($data['nivel'] == "Idiomas A1") {
                            $e_start = 1; // Para ocultar "Idiomas A1-1"
                        } else {
                            $e_start = 0; // Muestra en las otras tablas los idiomas que comienzan desde "Idiomas A2-1" menos en la tabla "Idiomas A1-1"
                        }
                        $nombre_materias = array();
                        if (!empty($consulta_pagos)) { // Si hay pagos previos, los procesamos.
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']);
                                }
                            }
                            $nombre_materias = array_values(array_unique($nombre_materias));
                        }
                        for ($p = 0; $p < count($consulta_pagos); $p++) {
                            $nombre_materia = $consulta_pagos[$p]['nombre_materia'];
                        }
                        $nombre_materias = array();
                        if ($consulta_pagos) {
                            foreach ($consulta_pagos as $pago) {
                                if (isset($pago['nombre_materia'])) {
                                    $nombre_materias[] = trim($pago['nombre_materia']); // Usando trim() aquí
                                }
                            }
                        }
                        $nombre_materias = array_values(array_unique($nombre_materias));
                        $checkbox_list = 0;
                        for ($e = $e_start, $x = 1; $e < $cant; $e++, $x++) {
                            $levelIdCell = ($e + 1);
                            $currentCursoFull = $niveles[$i]['nombre'];
                            $parts = explode(' ', $currentCursoFull);
                            //tomamos el ultimo array que seria el curso del nivel de ingles donde esta la tabla 
                            $nombre_nivel_ingles = end($parts);
                            $currentCurso = $nombre_nivel_ingles . '-' . $levelIdCell;
                            $isPaid = in_array($currentCurso, $nombre_materias);  // Verifica si el curso actual está en la matriz
                            $mensajeActual = isset($mensajesPorMateria[$currentCurso]) ? $mensajesPorMateria[$currentCurso] : "El curso no esta pagado";
                            if (!$isPaid) {
                                $todosPagados = false;
                            }
                            $ciclo = 6;
                            $jornada_matriculada = $niveles[$i]['nombre'] . "-" . $e + 1;
                            $paymentStatus = $isPaid ? '<span class="bg-success p-1"><i class="fas fa-check-double"></i> Pagada</span>' : '<span class="bg-danger p-1"><i class="fas fa-times"></i> No está pagada</span>';
                            $checkedAttr = '';
                            $dataPaidAttr = $isPaid ? 'data-paid="true"' : '';
                            $checkbox_list = $isPaid ? $checkbox_list : $checkbox_list + 1;
                            $ocultar_checbox = $isPaid ? '' : '<input type="checkbox" disabled class="nivel-checkbox" id="checkbox_' . $checkbox_list . '" data-valor="' . $valor_nivel['valor'] . '" data-materia="' . $currentCurso . '" data-toggle="tooltip" title="Debes pagar los cursos en orden secuencial">';

                            $mostrar_promedio_estudiante = $idiomas->mosrtarpromediotabla($data['id_estudiante_ing'],  $data['id_programa_estudiante']);

                            $promedio_estudiante = array();
                            if ($mostrar_promedio_estudiante['estado'] == 5) {
                                $data['conte'] .= '';
                            } else {

                                $data['conte'] .= ' <tr>
                                <td>' . $ocultar_checbox . " <label class='h6' for='checkbox_$e'>" . $niveles[$i]['nombre'] . " - " . ($e + 1) . "</label> " . '</td>
                                <td>$ ' . $valor_nivel['valor'] . '</td>
                                <td>' . $paymentStatus;
                                '</td>
                                </tr>';

                                // if (!$todosPagados) {
                                //     $data['conte'] .= '
                                // <td>
                                // <button type="button" id="btnPagar" onclick="generarBotones()" disabled class="btn btn-sm bg-navy btn-flat btn-block" data-toggle="modal" data-target=".exampleModal_una">
                                //     <i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"> Pagar </i></i>
                                // </button>
                                // </td>';
                                // }

                            }
                        }


                        $valor_cantidad_cursos = $e - 1;  // Decrementa el valor de $e en 1
                        $data['cantidad_cursos'] = $valor_cantidad_cursos;
                        $data['valor'] = $valor_nivel['valor'];
                        $data['cant'] = $cant;
                    }
                    break;
                }
            }
        }

        $data['conte'] .= '</tbody></table>';

        if (!$isPaid) {
            $todosPagados = false;
        }
        if (!$todosPagados) {
            $data['conte'] .= '
            <button type="button" id="btnPagar" onclick="generarBotones()" disabled class="btn btn-sm bg-navy btn-flat btn-block" data-toggle="modal" data-target=".exampleModal_una">
            <i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"> Pagar </i></i>
        </button>';
        } else {
            $data['conte'] .= '';
        }
        echo json_encode($data);
        break;
    case 'generarBotones':
        $nivel_cantidad = $_POST["nivel_cantidad"];
        $texto_materias = $_POST["texto_materias"];
        $nivel_global = $_POST["nivel_global"];
        $jornada_e = $_POST["jornada"];
        $traervalorcursos = $idiomas->traervalocursos($nivel_global);
        $id_programa = $traervalorcursos['id_programa'];
        $precio_curso = $idiomas->valor_cursos($id_programa);
        $valor = $precio_curso['valor'];
        $total_curso_ingles = $valor * $nivel_cantidad;

        $datos_personales_estudiante = $idiomas->consultar_datos_estudiante($_SESSION['id_usuario']);
        $credencial_identificacion = $datos_personales_estudiante['credencial_identificacion'];
        $id_credencial_ing = $datos_personales_estudiante['id_credencial'];

        $data["info"] = '<!-- =====================================================================
        ///////////   Este es su botón de Botón de pago ePayco gateway   ///////////
        ===================================================================== -->
        <form class="col-6">
            <script src="https://checkout.epayco.co/checkout.js" 
                data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
                class="epayco-button" 
                data-epayco-amount="' . $total_curso_ingles . '" 
                data-epayco-tax="0"
                data-epayco-tax-base="' . $total_curso_ingles  . '"
                data-epayco-name="Pago Nivel Idiomas ' . $texto_materias . '" 
                data-epayco-description=" ' . $texto_materias . '" 
                data-epayco-extra1="' . $id_credencial_ing . '"
                data-epayco-extra2="' . $credencial_identificacion . '"
                data-epayco-extra3="' . $id_programa . '"
                data-epayco-extra4="' . $nivel_global . '"
                data-epayco-extra5="' . $jornada_e . '"
                data-epayco-currency="cop"    
                data-epayco-country="CO" 
                data-epayco-test="false" 
                data-epayco-external="true" 
                data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                data-epayco-confirmation="https://ciaf.digital/vistas/pagosnivelidiomas.php" 
                data-epayco-button="https://ciaf.digital/public/img/btn-enlinea.png"> 
            </script> 
        </form> 
        <!-- ================================================================== -->    
        
        <!-- =====================================================================
            ///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
            ===================================================================== -->
        <form class="col-6">
            <script src="https://checkout.epayco.co/checkout.js" 
                data-epayco-key="8b4e82b040c208b31bc5be3f33830392" 
                class="epayco-button" 
                data-epayco-amount="' . $total_curso_ingles . '" 
                data-epayco-tax="0"
                data-epayco-tax-base="' . $total_curso_ingles  . '"
                data-epayco-name="Pago Nivel Idiomas ' . $texto_materias . '" 
                data-epayco-description=" ' . $texto_materias . '" 
                data-epayco-extra1="' . $id_credencial_ing . '"
                data-epayco-extra2="' . $credencial_identificacion . '"
                data-epayco-extra3="' . $id_programa . '"
                data-epayco-extra4="' . $nivel_global . '"
                data-epayco-extra5="' . $jornada_e . '"
                data-epayco-currency="cop"    
                data-epayco-country="CO" 
                data-epayco-test="false" 
                data-epayco-external="true"
                data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                data-epayco-confirmation="https://ciaf.digital/vistas/pagosnivelidiomas.php" 
                data-epayco-button="https://ciaf.digital/public/img/btn-efectivo.png">
            </script> 
        </form> 
        <!-- ================================================================== --> ';
        echo json_encode($data);
        break;

    case "selectJornada":
        $rspta = $idiomas->selectJornada();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["codigo"] . "</option>";
        }
        break;
}
