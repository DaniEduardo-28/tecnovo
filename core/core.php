<?php

  session_start();

  //NUCLEO DE LA APP
  define('HTML_DIR','views/');
  define('APP_TITLE','PetSpace | Sistema para clínicas veterinarias ');
  define('APP_COPY','Copyright © ' . date('Y',time()));
  define('AUTOR','Zhaúl Valdera');
  define('APP_VERSION','1.0.0.2');
  //define('APP_URL','http://clinicaveterinaria.test:8080/');
  define('APP_URL','https://veterinaria.tecnovoperu.com/');
  define('CORREO_RECIBE','zhaulvaldera.sistemas@hotmail.com');
  define('ID_EMPRESA',1);

  /*define('HOST_DB','localhost');
  define('USER_DB','root');
  define('DB','mican');
  define('PASS_DB','');
  define('CHARSET','utf8');*/

  define('HOST_DB','db5000108902.hosting-data.io');
  define('USER_DB','dbu152091');
  define('DB','dbs103397');
  define('PASS_DB','Veterin@ria123');
  define('CHARSET','utf8');

  require('admin/core/models/Conexion.php');
  require('admin/core/functions/overall.php');
  require('admin/core/functions/encript.php');

 ?>
