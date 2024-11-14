<?php

  session_start();
  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL,"es_ES");

  //NUCLEO DE LA APP
  define('APP_URL','http://syscos.test/');
  // define('APP_URL','https://veterinaria.oxerva.com/admin/');
  define('APP_TITLE','PetSpace | Sistema para clínicas veterinarias ');
  define('APP_COPY','Copyright © ' . date('Y',time()) . ' <a href="https://www.oxerva.com" target="_blank">Tecnovo Perú</a>');
  define('APP_VERSION','1.0.0.2');
  define('AUTOR','Zhaúl Valdera');
  define('DESCRIPTION_SYSTEM','Esto es una breve descripción del sistema....');
  define('AUTOR_URL','https://www.oxerva.com');
  define('CREATION',2019);
  define('SRC_GLOBAL',$_SERVER['DOCUMENT_ROOT']);
  define('ID_EMPRESA',1);

  //CONSTANTES BASE DE CONEXIÓN

  define('HOST_DB','localhost');
  define('USER_DB','root');
  define('DB','syscos');
  define('PASS_DB','');
  define('CHARSET','utf8');

  // define('HOST_DB','db5000108902.hosting-data.io');
  // define('USER_DB','dbu152091');
  // define('DB','dbs103397');
  // define('PASS_DB','Veterin@ria123');
  // define('CHARSET','utf8');

  //CLASES GLOBALES
  require('core/models/Conexion.php');
  require('core/functions/encript.php');
  require('core/functions/overall.php');
  require('core/functions/PermitsOptions.php');

 ?>
