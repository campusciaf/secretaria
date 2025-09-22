$(document).ready(inicio);
function inicio() {
    listarTema2();
    $("#precarga").hide();

}
function listarTema2() {
    $.post("../controlador/perestudiante.php?op=listarTema", function (e) {
       
        var r = JSON.parse(e);
        let element = document.getElementById('switch');
    let compStyles = window.getComputedStyle(element);
    let ancho = compStyles.getPropertyValue('width');
    console.log(ancho);
        
        if(r.conte==1){
            document.documentElement.setAttribute('tema', 'light');
        }else{
            document.documentElement.setAttribute('tema', 'dark');
        }

    });
}

function cambioTema() {
    let element = document.getElementById('switch');
    let compStyles = window.getComputedStyle(element);
    let ancho = compStyles.getPropertyValue('width');
  

    $.post("../controlador/perestudiante.php?op=cambioTema", {ancho:ancho},function (e) {
        var r = JSON.parse(e);
        console.log(ancho);
    });
}

const colorSwitch = document.querySelector('#switch');
function cambiaTema(ev){
    if(ev.target.checked){
        document.documentElement.setAttribute('tema', 'dark');
        
    } else {
        document.documentElement.setAttribute('tema', 'light');
    }
}
colorSwitch.addEventListener('change', cambiaTema);

