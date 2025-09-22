<?php

require_once "../modelos/Movilizacion.php";

class ControlMovilizacion
{
    
    public function listarMunicipios(){
        $obj = new Movilizacion();
        $obj->listarMunicipios();
    }
    public function consultaMunicipio($id)
    {
        Movilizacion::consultaMunicipio($id);
    }
    public function editarMunicipio($id,$nombre)
    {
        Movilizacion::editarMunicipio($id,$nombre);
    }
    public function deleteMunicipio($id)
    {
        Movilizacion::deleteMunicipio($id);
    }
    public function aggcolegio($id_muni,$nombre,$valor)
    {
        Movilizacion::aggColegio($id_muni,$nombre,$valor);
    }
    public function listarColegios($id)
    {
        Movilizacion::listarColegios($id);
    }
    public function consultarColegios($id)
    {
        Movilizacion::consultarColegios($id);
    }
    public function editarColegios($id,$nombre,$tarifa)
    {
        Movilizacion::editarColegios($id,$nombre,$tarifa);
    }
    public function aggMunicipio($nombre)
    {
        Movilizacion::aggMunicipio($nombre);
    }
    public function deletColegio($id)
    {
        Movilizacion::deletColegio($id);
    }

}


switch ($_GET['op']) {
    case 'listar_municipios':
        $obj = new ControlMovilizacion();
        $obj->listarMunicipios();
        break;
    case 'consulta_municipios':
        $municipio = $_POST['id'];
        $obj = new ControlMovilizacion();
        $obj->consultaMunicipio($municipio);
        break;
    case 'editar_municipios':
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        $obj = new ControlMovilizacion();
        $obj->editarMunicipio($id,$nombre);
        break;
    case 'delete_municipios':
        $id = $_POST['id'];
        $obj = new ControlMovilizacion();
        $obj->deleteMunicipio($id);
        break;
    case 'aggcolegio':
        $valor = $_POST['valor'];
        $nombre = $_POST['nombre'];
        $id_muni = $_POST['id_municipio'];

        $obj = new ControlMovilizacion();
        $obj->aggColegio($id_muni,$nombre,$valor);
        break;
    case 'listarColegios':
        $id = $_GET['municipio'];
        $obj = new ControlMovilizacion();
        $obj->listarColegios($id);
        break;
    case 'consulta_colegio':
        $id = $_POST['id'];
        $obj = new ControlMovilizacion();
        $obj->consultarColegios($id);
        break;
    case 'editar_colegio':
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $tarifa = $_POST['tarifa'];
        $obj = new ControlMovilizacion();
        $obj->editarColegios($id,$nombre,$tarifa);
        break;
    case 'aggMunicipio':
        $nombre = $_POST['nombre'];
        $obj = new ControlMovilizacion();
        $obj->aggMunicipio($nombre);
        break;
    case 'delete_colegio':
        $id = $_POST['id'];
        $obj = new ControlMovilizacion();
        $obj->deletColegio($id);
        break;
}


?>