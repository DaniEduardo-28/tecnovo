<?php

    unset($_SESSION["id_persona_cliente"]);
    unset($_SESSION["id_cliente"]);
    unset($_SESSION["name_user_cliente"]);
    unset($_SESSION["nombres_cliente"]);
    unset($_SESSION["apellidos_cliente"]);
    unset($_SESSION["src_imagen_cliente"]);

    header('location: ' . APP_URL);

 ?>
