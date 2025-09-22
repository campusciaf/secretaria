function init() {
   $("#precarga").hide();
   buscar(); 
}
function buscar() {

        $.post("../controlador/carnetdocente.php?op=buscar", {  }, function (e) {
            
            var r = JSON.parse(e);
 
            if (r.status == "ok") {
                $(".conte").html(r.conte);
                mostrarconvenios();
            } else {
                $(".conte").html("");
                // $(".cad").html("");
                alertify.error("Error, no se encuentra el estudiante");
            }
        });
    } 

    function mostrarconvenios() {

        $(".moverconvenioslider").slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                    }
            ]
        });
    }

    function iniciarTour(){
        introJs().setOptions({
            nextLabel: 'Siguiente',
            prevLabel: 'Anterior',
            doneLabel: 'Terminar',
            showBullets:false,
            showProgress:true,
            showStepNumbers:true,
            steps: [ 
                {
                    title: 'Horarios',
                    intro: 'Módulo para consultar los horarios por salones creados en el periodo actual.'
                },
                {
                    title: 'Docente',
                    element: document.querySelector('#t-programa'),
                    intro: "Campo de opciones que contiene los nombres de los salones activos en plataforma para consultar."
                },
    
            ]
                
        },

        
        ).start();
    
    }

init();