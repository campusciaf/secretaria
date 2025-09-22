<?php

require_once "../modelos/Consultagraduados2012.php";

$consulta = new Consulta();

switch ($_GET['op']) {
    case 'consultaDatos':
        $periodoBus = $_POST['periodoBus'];
        /* variables formulario */        
            $identificacion =  (isset($_POST['identificacion']))? "si":"no"; //--
            $programa =  (isset($_POST['programa']))? "si":"no"; //--
            $estado =  (isset($_POST['estado']))? "si":"no";
            $numer_acta =  (isset($_POST['numer_acta']))? "si":"no";
            $folio =  (isset($_POST['folio']))? "si":"no";
            $ano_gradu =  (isset($_POST['ano_gradu']))? "si":"no";
            $escuela =  (isset($_POST['escuela']))? "si":"no";

            $nombre1 =  (isset($_POST['nombre1']))? "si":"no"; //--
            $nombre2 =  (isset($_POST['nombre2']))? "si":"no"; //--
            $fecha_expe =  (isset($_POST['fecha_expe']))? "si":"no"; //--
            $jornada =  (isset($_POST['jornada']))? "si":"no";
            $discapacidad =  (isset($_POST['discapacidad']))? "si":"no";
            $apellido1 =  (isset($_POST['apellido1']))? "si":"no"; //--
            $apellido2 =  (isset($_POST['apellido2']))? "si":"no"; //--
            $tipo_docu =  (isset($_POST['tipo_docu']))? "si":"no"; //--
            $genero =  (isset($_POST['genero']))? "si":"no"; //--
            $lugar_naci =  (isset($_POST['lugar_naci']))? "si":"no";
            $tipo_sangre =  (isset($_POST['tipo_sangre']))? "si":"no";
            $periodo =  (isset($_POST['periodo']))? "si":"no";
            $nombre_dis =  (isset($_POST['nombre_dis']))? "si":"no";
            $lugar_expe =  (isset($_POST['lugar_expe']))? "si":"no";
            $Fecha_naci =  (isset($_POST['Fecha_naci']))? "si":"no";
            $nombre_et =  (isset($_POST['nombre_et']))? "si":"no";
            
            $direc_resi =  (isset($_POST['direc_resi']))? "si":"no";
            $barrio_resi =  (isset($_POST['barrio_resi']))? "si":"no";
            $tele1 =  (isset($_POST['tele1']))? "si":"no";
            $tele2 =  (isset($_POST['tele2']))? "si":"no";
            $celular =  (isset($_POST['celular']))? "si":"no";
            $correo =  (isset($_POST['correo']))? "si":"no";
            $ciudad_resi =  (isset($_POST['ciudad_resi']))? "si":"no";
            $todoacademi =  (isset($_POST['todoacademi']))? "si":"no";
            $nom_cole =  (isset($_POST['nom_cole']))? "si":"no";
            $jor_inst =  (isset($_POST['jor_inst']))? "si":"no";
            $ano_termi =  (isset($_POST['ano_termi']))? "si":"no";
            $ciudad_colegio =  (isset($_POST['ciudad_colegio']))? "si":"no";
            $fecha_icfes =  (isset($_POST['fecha_icfes']))? "si":"no";
            $codigo_icfes =  (isset($_POST['codigo_icfes']))? "si":"no";
            $tipo_inst =  (isset($_POST['tipo_inst']))? "si":"no";
            
            $traba_actu =  (isset($_POST['traba_actu']))? "si":"no";
            $cargo_desem =  (isset($_POST['cargo_desem']))? "si":"no";
            $nombre_empre =  (isset($_POST['nombre_empre']))? "si":"no";
            $sec_empre =  (isset($_POST['sec_empre']))? "si":"no";
            $tele_empre =  (isset($_POST['tele_empre']))? "si":"no";
            $correo_empre =  (isset($_POST['correo_empre']))? "si":"no";
            
            $segun_idioma =  (isset($_POST['segun_idioma']))? "si":"no";
            $aficiones =  (isset($_POST['aficiones']))? "si":"no";
            $tiene_compu =  (isset($_POST['tiene_compu']))? "si":"no";
            $tiene_inter =  (isset($_POST['tiene_inter']))? "si":"no";
            $tiene_hijos =  (isset($_POST['tiene_hijos']))? "si":"no";
            $estado_civil =  (isset($_POST['estado_civil']))? "si":"no";
            $cual_idiomas =  (isset($_POST['cual_idiomas']))? "si":"no";
        /* variables formulario */

        $datos = $consulta->consultaGraduados($periodoBus);
        $data['conte'] = "";
        $data['conte'] .= '<div class="modal-body">
                <table class="table table-striped" id="tbl-consulta">
                    <thead>
                        <tr>';
        /* Inicio segunda seccion del formulario */
            switch ($tipo_docu) {case 'si': $data['conte'] .= '<th scope="col">Tipo docuemnto</th>'; break;}
            switch ($identificacion) {case 'si': $data['conte'] .= '<th scope="col">Identificación</th>'; break;}
            switch ($programa) {case 'si': $data['conte'] .= '<th scope="col">Programa</th>'; break;}
            switch ($nombre1) {case 'si': $data['conte'] .= '<th scope="col">Primer nombre</th>'; break;}
            switch ($nombre2) {case 'si': $data['conte'] .= '<th scope="col">Segundo nombre</th>'; break;}
            switch ($apellido1) {case 'si': $data['conte'] .= '<th scope="col">Primer apellido</th>'; break;}
            switch ($apellido2) {case 'si': $data['conte'] .= '<th scope="col">Segundo apellido</th>'; break;}
            switch ($lugar_expe) {case 'si': $data['conte'] .= '<th scope="col">Lugar expedicion</th>'; break;}
            switch ($fecha_expe) {case 'si': $data['conte'] .= '<th scope="col">Fecha expedicion</th>'; break;}
            switch ($genero) {case 'si': $data['conte'] .= '<th scope="col">Género</th>'; break;}
            switch ($Fecha_naci) {case 'si': $data['conte'] .= '<th scope="col">Fecha nacimineto</th>'; break;}
            switch ($discapacidad) {case 'si': $data['conte'] .= '<th scope="col">Discapacidad</th>'; break;}
            switch ($nombre_dis) {case 'si': $data['conte'] .= '<th scope="col">Nombre discapacidad</th>'; break;}
            switch ($lugar_naci) {case 'si': $data['conte'] .= '<th scope="col">Lugar de nacimiento</th>'; break;}
            switch ($nombre_et) {case 'si': $data['conte'] .= '<th scope="col">Nombre étnico</th>'; break;}
            switch ($jornada) {case 'si': $data['conte'] .= '<th scope="col">Jornada</th>'; break;}
            switch ($tipo_sangre) {case 'si': $data['conte'] .= '<th scope="col">Tipo de sangre</th>'; break;}
            switch ($periodo) {case 'si': $data['conte'] .= '<th scope="col">Periodo</th>'; break;}
        /* Fin segunda seccion del formulario */

        /* Inicio primera seccion del formulario */
            switch ($estado) {case 'si': $data['conte'] .= '<th scope="col">Estado</th>'; break;}
            switch ($numer_acta) {case 'si': $data['conte'] .= '<th scope="col">Número de acta</th>'; break;}
            switch ($folio) {case 'si': $data['conte'] .= '<th scope="col">Folio</th>'; break;}
            switch ($ano_gradu) {case 'si': $data['conte'] .= '<th scope="col">Año graduación</th>'; break;}
            switch ($escuela) {case 'si': $data['conte'] .= '<th scope="col">Escuela</th>'; break;}
        /* Fin primera seccion del formulario */

        /* Inicio tercera seccion del formulario */
            switch ($direc_resi) {case 'si': $data['conte'] .= '<th scope="col">Dirección residencia</th>'; break;}
            switch ($barrio_resi) {case 'si': $data['conte'] .= '<th scope="col">Barrio residencia</th>'; break;}
            switch ($ciudad_resi) {case 'si': $data['conte'] .= '<th scope="col">Municipio residencia</th>'; break;}
            switch ($tele1) {case 'si': $data['conte'] .= '<th scope="col">Teléfono</th>'; break;}
            switch ($tele2) {case 'si': $data['conte'] .= '<th scope="col">Teléfono 2</th>'; break;}
            switch ($celular) {case 'si': $data['conte'] .= '<th scope="col">Celular</th>'; break;}
            switch ($correo) {case 'si': $data['conte'] .= '<th scope="col">Correo</th>'; break;}
        /* Fin tercera seccion del formulario */

        /* Inicio cuarta seccion del formulario */
            switch ($nom_cole) {case 'si': $data['conte'] .= '<th scope="col">Nombre colegio</th>'; break;}
            switch ($tipo_inst) {case 'si': $data['conte'] .= '<th scope="col">Tipo institución</th>'; break;}
            switch ($jor_inst) {case 'si': $data['conte'] .= '<th scope="col">Jornada institución</th>'; break;}
            switch ($ano_termi) {case 'si': $data['conte'] .= '<th scope="col">Año terminación</th>'; break;}
            switch ($ciudad_colegio) {case 'si': $data['conte'] .= '<th scope="col">Municipio colegio</th>'; break;}
            switch ($fecha_icfes) {case 'si': $data['conte'] .= '<th scope="col">Fecha ICFES</th>'; break;}
            switch ($codigo_icfes) {case 'si': $data['conte'] .= '<th scope="col">Código ICFES</th>'; break;}
        /* Fin cuarta seccion del formulario */

        /* Inicio quinta seccion del formulario */
            switch ($traba_actu) {case 'si': $data['conte'] .= '<th scope="col">Trabaja actualmente</th>'; break;}
            switch ($nombre_empre) {case 'si': $data['conte'] .= '<th scope="col">Empresa</th>'; break;}
            switch ($cargo_desem) {case 'si': $data['conte'] .= '<th scope="col">Cargo desempeña</th>'; break;}
            switch ($sec_empre) {case 'si': $data['conte'] .= '<th scope="col">Sector empresa</th>'; break;}
            switch ($tele_empre) {case 'si': $data['conte'] .= '<th scope="col">Teléfono empresa</th>'; break;}
            switch ($correo_empre) {case 'si': $data['conte'] .= '<th scope="col">Correo empresa</th>'; break;}
        /* Fin quinta seccion del formulario */

        /* Inicio sexta seccion del formulario */
            switch ($segun_idioma) {case 'si': $data['conte'] .= '<th scope="col">Segundo idioma</th>'; break;}
            switch ($cual_idiomas) {case 'si': $data['conte'] .= '<th scope="col">Cuál idioma</th>'; break;}
            switch ($aficiones) {case 'si': $data['conte'] .= '<th scope="col">Aficiones</th>'; break;}
            switch ($tiene_compu) {case 'si': $data['conte'] .= '<th scope="col">Tiene PC</th>'; break;}
            switch ($tiene_inter) {case 'si': $data['conte'] .= '<th scope="col">Tiene internet</th>'; break;}
            switch ($tiene_hijos) {case 'si': $data['conte'] .= '<th scope="col">Tiene hijos</th>'; break;}
            switch ($estado_civil) {case 'si': $data['conte'] .= '<th scope="col">Estado civil</th>'; break;}
        /* Fin sexta seccion del formulario */


        $data['conte'] .= '</tr></thead>
                    <tbody>';

        for ($i=0; $i < count($datos) ; $i++) {
            $data['conte'] .= '<tr>';
            /* Inicio segunda seccion del formulario */
                switch ($tipo_docu) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tipo_documento'].'</td>'; break;}
                switch ($identificacion) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['identificacion'].'</td>'; break;}
                switch ($programa) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['fo_programa'].'</td>'; break;}
                switch ($nombre1) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['nombre'].'</td>'; break;}
                switch ($nombre2) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['nombre_2'].'</td>'; break;}
                switch ($apellido1) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['apellidos'].'</td>'; break;}
                switch ($apellido2) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['apellidos_2'].'</td>'; break;}
                switch ($lugar_expe) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['expedido_en'].'</td>'; break;}
                switch ($lugar_expe) {case 'si': $data['conte'] .= '<td>'.$consulta->convertir_fecha($datos[$i]['fecha_expedicion']).'</td>'; break;}
                switch ($genero) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['genero'].'</td>'; break;}
                switch ($Fecha_naci) {case 'si': $data['conte'] .= '<td>'.$consulta->convertir_fecha($datos[$i]['fecha_nacimiento']).'</td>'; break;}
                switch ($discapacidad) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['discapacidad'].'</td>'; break;}
                switch ($nombre_dis) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['nombre_discapacidad'].'</td>'; break;}
                switch ($lugar_naci) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['lugar_nacimiento'].'</td>'; break;}
                switch ($nombre_et) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['nombre_etnico'].'</td>'; break;}
                switch ($jornada) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['jornada_e'].'</td>'; break;}
                switch ($tipo_sangre) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tipo_sangre'].'</td>'; break;}
                switch ($periodo) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['periodo'].'</td>'; break;}

            /* Fin segunda seccion del formulario */

            /* Inicio primera seccion del formulario */

                switch ($estado) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['estado'].'</td>'; break;}
                switch ($numer_acta) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['numero_acta'].'</td>'; break;}
                switch ($folio) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['folio'].'</td>'; break;}
                switch ($ano_gradu) {case 'si': $data['conte'] .= '<td>'.$consulta->convertir_fecha($datos[$i]['ano_graduacion']).'</td>'; break;}
                switch ($escuela) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['escuela_ciaf'].'</td>'; break;}

            /* Fin primera seccion del formulario */

            /* Inicio tercera seccion del formulario */
                switch ($direc_resi) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['direccion'].'</td>'; break;}
                switch ($barrio_resi) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['barrio'].'</td>'; break;}
                switch ($ciudad_resi) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['municipio'].'</td>'; break;}
                switch ($tele1) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['telefono'].'</td>'; break;}
                switch ($tele2) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['telefono2'].'</td>'; break;}
                switch ($celular) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['celular'].'</td>'; break;}
                switch ($correo) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['email'].'</td>'; break;}
            /* Fin tercera seccion del formulario */

            /* Inicio cuarta seccion del formulario */
                switch ($nom_cole) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['nombre_colegio'].'</td>'; break;}
                switch ($tipo_inst) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tipo_institucion'].'</td>'; break;}
                switch ($jor_inst) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['jornada_institucion'].'</td>'; break;}
                switch ($ano_termi) {case 'si': $data['conte'] .= '<td>'.$consulta->convertir_fecha($datos[$i]['ano_terminacion']).'</td>'; break;}
                switch ($ciudad_colegio) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['ciudad_institucion'].'</td>'; break;}
                switch ($fecha_icfes) {case 'si': $data['conte'] .= '<td>'.$consulta->convertir_fecha($datos[$i]['fecha_presen_icfes']).'</td>'; break;}
                switch ($codigo_icfes) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['codigo_icfes'].'</td>'; break;}
            /* Fin cuarta seccion del formulario */

            /* Inicio quinta seccion del formulario */
                switch ($traba_actu) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['trabaja_actualmente'].'</td>'; break;}
                switch ($nombre_empre) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['empresa_trabaja'].'</td>'; break;}
                switch ($cargo_desem) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['cargo_en_empresa'].'</td>'; break;}
                switch ($sec_empre) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['sector_empresa'].'</td>'; break;}
                switch ($tele_empre) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tel_empresa'].'</td>'; break;}
                switch ($correo_empre) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['email_empresa'].'</td>'; break;}
            /* Fin quinta seccion del formulario */
            
            /* Inicio sexta seccion del formulario */
                switch ($segun_idioma) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['segundo_idioma'].'</td>'; break;}
                switch ($cual_idiomas) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['cual_idioma'].'</td>'; break;}
                switch ($aficiones) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['aficiones'].'</td>'; break;}
                switch ($tiene_compu) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tiene_pc'].'</td>'; break;}
                switch ($tiene_inter) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tiene_internet'].'</td>'; break;}
                switch ($tiene_hijos) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['tiene_hijos'].'</td>'; break;}
                switch ($estado_civil) {case 'si': $data['conte'] .= '<td>'.$datos[$i]['estado_civil'].'</td>'; break;}
            /* Fin sexta seccion del formulario */
            
            $data['conte'] .= '</tr>';
        }

        echo json_encode($data);

        break;
}

?>