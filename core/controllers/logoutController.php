<?php

    unset($_SESSION["id_persona"]);
    unset($_SESSION["id_trabajador"]);
    unset($_SESSION["id_grupo"]);
    unset($_SESSION["id_especialidad"]);
    unset($_SESSION["name_user"]);
    unset($_SESSION["nombres"]);
    unset($_SESSION["apellidos"]);
    unset($_SESSION["name_grupo"]);
    unset($_SESSION["name_especialidad"]);
    unset($_SESSION["src_image"]);
    unset($_SESSION["id_fundo"]);
    unset($_SESSION["id_empresa"]);
    unset($_SESSION["nombre_sucursal"]);
    header('location: ' . APP_URL);

 ?>
