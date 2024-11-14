<!-- Estados Orden Venta-->
1 -> Registrado
2 -> Pagado
3 -> Anulado



case 'showOrdenCompra':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/operaciones/showOrdenCompra.php");
  break;
case 'goOrdenCompraBorrador':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/operaciones/goOrdenCompraBorrador.php");
  break;
case 'getDataOrdenCompra':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/operaciones/getDataOrdenCompra.php");
  break;
case 'goOrdenCompra':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/operaciones/goOrdenCompra.php");
  break;
case 'eliminarOrdenCompra':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/operaciones/eliminarOrdenCompra.php");
  break;
case 'anularOrdenCompra':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/operaciones/anularOrdenCompra.php");
  break;
case 'showOrdenCompraReporte':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/reportes/showOrdenCompraReporte.php");
  break;
case 'getDataOrdenCompraReporte':
  require("core/models/ClassAccesoOpcion.php");
  require("core/ajax/reportes/getDataOrdenCompraReporte.php");
  break;
