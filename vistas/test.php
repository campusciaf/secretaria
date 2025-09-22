    <?php
    //Activamos el almacenamiento en el buffer
    ob_start();
    session_start();
    if (!isset($_SESSION["usuario_nombre"])) {
        header("Location: ../");
    } else {
        $menu = 2;
        $submenu = 217;
        require 'header.php';
        if ($_SESSION['sac_calendario_general'] == 1) {
    ?>
            
            

        <?php
        } else {
            require 'noacceso.php';
        }
        require 'footer.php';
        ?>
        <script type="text/javascript" src="scripts/sac_calendario_general.js"></script>
        <!-- estilos para la tabla calendario sac general -->
        <style>

            .current{
                background: #363062 !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                
                padding: 2 !important;
                margin-left: 3 !important;
                color: #172b4d !important;
                border-radius: 21px !important;
                color: #736e93 !important;
                /* background-color:white  !important; */
                background:-webkit-linear-gradient(top, #363062 0%, #363062 100%)  !important;
                background: linear-gradient(to bottom, #ebe9f4 0%, #ebe9f4 100%) !important;
                background:-o-linear-gradient(top, #e3e3e3 0%, #ebe9f4 100%)  !important;
                background:-moz-linear-gradient(top, #e3e3e3 0%, #dcdcdc 100%)  !important; 
                /* background:-webkit-gradient(linear, left top, left bottom, color-stop(0%, #e3e3e3), 
                color-stop(100%, #e3e3e3)) !important; */
                

            }


            .paginate_button.current:hover{
                color:#363062 !important;
                border:1px 
                solid #363062 !important;
                background-color:white !important;
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0%, #363062), color-stop(100%, #363062)) !important;
                background:-webkit-linear-gradient(top, #363062 0%, #363062 100%) !important;
                background:-moz-linear-gradient(top, #fff 0%, #363062 100%) !important;
                /* background:-ms-linear-gradient(top, #fff 0%, #363062 100%) !important; */
                background:-o-linear-gradient(top, #fff 0%, #363062 100%) !important;
            }


            .btn-secondary{
                color: #a5a5a5 !important;
                background-color: #f4f4f4 !important;
                border-color: #f4f4f4 !important;
                box-shadow: none !important;

            }

            .dataTables_wrapper .dataTables_length,.dataTables_wrapper .dataTables_filter,.dataTables_wrapper .dataTables_info,.dataTables_wrapper .dataTables_processing,.dataTables_wrapper .dataTables_paginate{color:#c1c6d1 !important}  


            
        </style>
        
    
    <?php
    }
    ob_end_flush();
    ?>