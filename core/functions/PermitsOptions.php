<?php

  function  printCodeOption($controller){
    $VD = 0;

    try {

      switch ($controller) {
        case 'mybusiness':
          $VD = 101;
          break;
        case 'sucursales':
          $VD = 102;
          break;
        case 'monedas':
          $VD = 103;
          break;
        case 'identitydocuments':
          $VD = 104;
          break;
        case 'tiposervicio':
          $VD = 107;
          break;
        case 'tipocosecha':
          $VD = 115;
          break;
        case 'cliente':
          $VD = 201;
          break;
        case 'servicio':
          $VD = 202;
          break;
        case 'operador':
          $VD = 209;
          break;
        case 'maquinaria':
          $VD = 210;
          break;
          case 'tipogasto':
            $VD = 211;
            break;
        case 'gasto':
          $VD = 212;
          break;
        case 'grupousuario':
          $VD = 301;
          break;
        case 'accesogrupo':
          $VD = 302;
          break;
        case 'accesosucursal':
          $VD = 303;
          break;
        case 'trabajador':
          $VD = 304;
          break;
          case 'accesofundo':
            $VD = 305;
            break;
        case 'ordenventa':
          $VD = 602;
          break;
        case 'ordencompra':
          $VD = 603;
          break;
        case 'promocion':
          $VD = 604;
          break;
        case 'ingreso':
          $VD = 605;
          break;
        case 'vistareporteordenventa':
          $VD = 702;
          break;
        case 'vistaestadisticas':
          $VD = 705;
          break;
        case 'observacionesproveedor':
          $VD = 706;
          break;

        default:
          $VD = 0;
          break;
      }

    } catch (\Exception $e) {
      $VD = $e;
    }

    return $VD;

  }

 ?>
