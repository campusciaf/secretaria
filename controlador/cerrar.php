<?php
session_start();
session_destroy();

echo "cerrando sesion";
echo "<script languaje='javascript'>window.location='admin.php'</script>";	

?>