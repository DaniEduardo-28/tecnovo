<?php

  session_start();
  date_default_timezone_set('America/Lima');
  setlocale(LC_ALL,"es_ES");

  // server local
  define('APP_URL','http://syscos.test/');

  // server produccion
  // define('APP_URL','https://syscos.bsgperu.com/');

  define('APP_TITLE','SysCos | Sistema para gestión de cosechas ');
  define('APP_COPY','Copyright © ' . date('Y',time()) . ' <a href="https://www.oxerva.com.pe" target="_blank">Oxerva SRL</a>');
  define('APP_VERSION','1.0.1.1');
  define('AUTOR','-');
  define('DESCRIPTION_SYSTEM','Esto es una breve descripción del sistema....');
  define('AUTOR_URL','https://www.oxerva.com.pe');
  define('CREATION',2024);
  define('SRC_GLOBAL',$_SERVER['DOCUMENT_ROOT']);
  define('ID_EMPRESA',1);

  // conexion local
  define('HOST_DB','localhost');
  define('USER_DB','root');
  define('DB','syscos');
  define('PASS_DB','');
  define('CHARSET','utf8');

  // conexion server
  // define('HOST_DB','localhost');
  // define('USER_DB','syscos');
  // define('DB','syscos');
  // define('PASS_DB','u&{$IrR$6;0a');
  // define('CHARSET','utf8');

  //CLASES GLOBALES
  require('core/models/Conexion.php');
  require('core/functions/encript.php');
  require('core/functions/overall.php');
  require('core/functions/PermitsOptions.php');

 ?>