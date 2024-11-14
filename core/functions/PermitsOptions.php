<?php

function  printCodeOption($controller)
{
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
      case 'especialidad':
        $VD = 105;
        break;
      case 'categoriaaccesorio':
        $VD = 106;
        break;
      case 'tiposervicio':
        $VD = 107;
        break;
      case 'tipomascota':
        $VD = 108;
        break;
      case 'tipomedicamento':
        $VD = 109;
        break;
      case 'formapago':
        $VD = 110;
        break;
      case 'tipocambio':
        $VD = 111;
        break;
      case 'documentoventa':
        $VD = 112;
        break;
      case 'unidadmedida':
        $VD = 113;
        break;
      case 'metodoenvio':
        $VD = 114;
        break;
      case 'cliente':
        $VD = 201;
        break;
      case 'servicio':
        $VD = 202;
        break;
      case 'accesorio':
        $VD = 203;
        break;
      case 'medicamento':
        $VD = 204;
        break;
      case 'medicoservicio':
        $VD = 205;
        break;
      case 'vacuna':
        $VD = 206;
        break;
      case 'mascota':
        $VD = 207;
        break;
      case 'proveedor':
        $VD = 208;
        break;
      case 'fundos':
        $VD = 209;
        break;
        case 'operador':
          $VD = 210;
          break;
          case 'maquinaria':
            $VD = 211;
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
      case 'webcabezera':
        $VD = 401;
        break;
      case 'webredessociales':
        $VD = 402;
        break;
      case 'webgaleria':
        $VD = 403;
        break;
      case 'websocio':
        $VD = 404;
        break;
      case 'webtestimonio':
        $VD = 405;
        break;
      case 'webcontacto':
        $VD = 406;
        break;
      case 'citas':
        $VD = 501;
        break;
      case 'atencioncitas':
        $VD = 502;
        break;
      case 'historialclinico':
        $VD = 503;
        break;
      case 'fichamascota':
        $VD = 601;
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
      case 'vistareporteordencompra':
        $VD = 701;
        break;
      case 'vistareporteordenventa':
        $VD = 702;
        break;
      case 'vistareporteaccesorios':
        $VD = 703;
        break;
      case 'vistareportemedicamentos':
        $VD = 704;
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
