<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class ProbabilidadReRiesgo
{
    public function consultar_resultado($probabilidad_desercion)
    {
        global $mbd;
        // para cuando se filtra todos
        if ($probabilidad_desercion === 'Todos') {
            $sql = "SELECT * FROM `credencial_estudiante`";
            $consulta = $mbd->prepare($sql);
            $consulta->execute();
        } else {
            // si seleccionamos el valor de 80, mostramos el rango entre 80% y 100%
            if ($probabilidad_desercion == 80) {
                $sql = "SELECT * FROM `credencial_estudiante` WHERE `probabilidad_desercion` BETWEEN 80 AND 100";
                $consulta = $mbd->prepare($sql);
                $consulta->execute();
            // si seleccionamos el valor de 60, mostramos el rango entre 20% y 60%
            } else if ($probabilidad_desercion == 60) {
                $sql = "SELECT * FROM `credencial_estudiante` WHERE `probabilidad_desercion` BETWEEN 20 AND 60";
                $consulta = $mbd->prepare($sql);
                $consulta->execute();
            // si seleccionamos el valor de 20, mostramos el rango entre 0% y 20%
            } else if ($probabilidad_desercion == 20) {
                $sql = "SELECT * FROM `credencial_estudiante` WHERE `probabilidad_desercion` BETWEEN 0 AND 20";
                $consulta = $mbd->prepare($sql);
                $consulta->execute();
            }
        }
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    function getBarraProgreso($porcentaje)
    {
        if ($porcentaje === null || $porcentaje === '') {
            return '
            <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-secondary" role="progressbar" style="width:100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>';
        }

        $color = 'bg-success';
        if ($porcentaje >= 80) {
            $color = 'bg-danger';
        } elseif ($porcentaje >= 60) {
            $color = 'bg-warning';
        } elseif ($porcentaje >= 40) {
            $color = 'bg-info';
        }
        return '
        <div class="progress" style="height: 20px;">
            <div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $porcentaje . '%;" aria-valuenow="' . $porcentaje . '" aria-valuemin="0" aria-valuemax="100">
                ' . $porcentaje . '%
            </div>
        </div>';
    }

    // public function selectPeriodo()
    // {
    //     global $mbd;
    //     $sentencia = $mbd->prepare("SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
    //     $sentencia->execute();
    //     $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //     return $registro;
    // }

}
