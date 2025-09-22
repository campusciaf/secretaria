<?php 
session_start(); 
require_once "../modelos/Idiomas_precios.php";

$idioPreci = new IdioPreci();

switch ($_GET['op']) {
    case 'listar':
        $datos = $idioPreci->listar();
        $data['conte'] = '';
        $color = array(
            0 => "primary",
            1 => "success",
            2 => "danger",
            3 => "warning",
            4 => "info",
        );
        for ($i=0; $i < count($datos); $i++) {

            $n = rand(0, 4);

            $data['conte'] .= '
            
                        <div class="card card-'.$color[$n].'">
                            <div class="card-header">
                                <h3 class="card-title">'.$datos[$i]['nombre'].'</h3>
                            </div>
                            <form class="fomr_edi" action="#" id="form'.$datos[$i]['id'].'" data-nombre="form'.$datos[$i]['id'].'" method="post">
                                <div class="card-body row">
                                    <div class="form-group col-sm-6">
                                        <label>Niveles</label>
                                        <input type="hidden" name="id" class="form-control" value="'.$datos[$i]['id'].'">
                                        <input type="text" class="form-control" value="'.$datos[$i]['cant_asignaturas'].'" disabled>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Valor por nivel</label>
                                        <input type="number" name="valor" class="form-control" value="'.$datos[$i]['valor'].'">
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
            
            ';
        }

        echo json_encode($data);

    break;

    case 'editar_val':

            $id = $_POST['id'];
            $valor = $_POST['valor'];                       

            $idioPreci->editar_val($id,$valor);
    break;
}

?>