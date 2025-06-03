<?php

require('core/core.php');

try {

  if (isset($_POST)) {
    switch (isset($_GET['accion']) ? $_GET['accion'] : null) {
      case 'goLogin':
        require("core/ajax/index/goLogin.php");
        break;
      case 'goUpdateImageProfile':
        require("core/ajax/home/goUpdateImageProfile.php");
        break;
      case 'goMyProfile':
        require("core/ajax/home/goMyProfile.php");
        break;
      case 'changePassword':
        require("core/ajax/home/changePassword.php");
        break;
      case 'goMyBusiness':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goMyBusiness.php");
        break;
      case 'showIdentityDocument':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showIdentityDocument.php");
        break;
      case 'goIdentityDocument':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goIdentityDocument.php");
        break;
      case 'deleteIdentityDocument':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteIdentityDocument.php");
        break;
      case 'showEspecialidad':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showEspecialidad.php");
        break;
      case 'goEspecialidad':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goEspecialidad.php");
        break;
      case 'deleteEspecialidad':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteEspecialidad.php");
        break;
      case 'showGrupoUsuario':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/showGrupoUsuario.php");
        break;
      case 'goGrupoUsuario':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/goGrupoUsuario.php");
        break;
      case 'deleteGrupoUsuario':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/deleteGrupoUsuario.php");
        break;
      case 'showCategoriaAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showCategoriaAccesorio.php");
        break;
      case 'goCategoriaAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goCategoriaAccesorio.php");
        break;
      case 'deleteCategoriaAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteCategoriaAccesorio.php");
        break;
      case 'showTipoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showTipoServicio.php");
        break;
      case 'goTipoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goTipoServicio.php");
        break;
      case 'deleteTipoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteTipoServicio.php");
        break;

      case 'showTipoCosecha':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showTipoCosecha.php");
        break;
      case 'goTipoCosecha':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goTipoCosecha.php");
        break;
      case 'deleteTipoCosecha':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteTipoCosecha.php");
        break;
      case 'showTipoMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showTipoMascota.php");
        break;
      case 'goTipoMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goTipoMascota.php");
        break;
      case 'deleteTipoMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteTipoMascota.php");
        break;
      case 'showTipoMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showTipoMedicamento.php");
        break;
      case 'goTipoMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goTipoMedicamento.php");
        break;
      case 'deleteTipoMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteTipoMedicamento.php");
        break;
      case 'showTipoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showTipoGasto.php");
        break;
      case 'goTipoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goTipoGasto.php");
        break;
      case 'deleteTipoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteTipoGasto.php");
        break;
      case 'getDataEditTipoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/getDataEditTipoGasto.php");
        break;
      case 'getTipoGastoPorUnidad':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/getTipoGastoPorUnidad.php");
        break;
      case 'showCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showCliente.php");
        break;
      case 'goCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goCliente.php");
        break;
      case 'deleteCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteCliente.php");
        break;
      case 'getDataEditCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditCliente.php");
        break;
      case 'showOperador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showOperador.php");
        break;
      case 'goOperador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goOperador.php");
        break;
      case 'deleteOperador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteOperador.php");
        break;
      case 'getDataEditOperador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditOperador.php");
        break;
      case 'showMaquinaria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showMaquinaria.php");
        break;
      case 'goMaquinaria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goMaquinaria.php");
        break;
      case 'deleteMaquinaria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteMaquinaria.php");
        break;
      case 'getDataEditMaquinaria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditMaquinaria.php");
        break;
      case 'getMaquinariasActivas':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getMaquinariasActivas.php");
        break;
      case 'getMaquinariasPorUnidad':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getMaquinariasPorUnidad.php");
        break;
      case 'showTrabajador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showTrabajador.php");
        break;
      case 'goTrabajador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goTrabajador.php");
        break;
      case 'deleteTrabajador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteTrabajador.php");
        break;
      case 'getDataEditTrabajador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditTrabajador.php");
        break;
      case 'showOpcionesSistema':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/showOpcionesSistema.php");
        break;
      case 'goAccesoGrupo':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/goAccesoGrupo.php");
        break;
      case 'showServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showServicio.php");
        break;
      case 'goServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goServicio.php");
        break;
      case 'deleteServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteServicio.php");
        break;
      case 'getDataEditServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditServicio.php");
        break;
      case 'showAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showAccesorio.php");
        break;
      case 'goAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goAccesorio.php");
        break;
      case 'deleteAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteAccesorio.php");
        break;
      case 'getDataEditAccesorio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditAccesorio.php");
        break;
      case 'showMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showMedicamento.php");
        break;
      case 'goMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goMedicamento.php");
        break;
      case 'deleteMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteMedicamento.php");
        break;
      case 'getDataEditMedicamento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditMedicamento.php");
        break;
      case 'showServicioMedico':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showServicioMedico.php");
        break;
      case 'goMedicoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goMedicoServicio.php");
        break;
      case 'showVacuna':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showVacuna.php");
        break;
      case 'goVacuna':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goVacuna.php");
        break;
      case 'deleteVacuna':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteVacuna.php");
        break;
      case 'goWebCabezera':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/goWebCabezera.php");
        break;
      case 'goWebRedesSociales':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/goWebRedesSociales.php");
        break;
      case 'showGaleria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/showGaleria.php");
        break;
      case 'goGaleria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/goGaleria.php");
        break;
      case 'deleteGaleria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/deleteGaleria.php");
        break;
      case 'getDataEditGaleria':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/getDataEditGaleria.php");
        break;
      case 'showSocio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/showSocio.php");
        break;
      case 'goSocio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/goSocio.php");
        break;
      case 'deleteSocio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/deleteSocio.php");
        break;
      case 'getDataEditSocio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/getDataEditSocio.php");
        break;
      case 'showTestimonio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/showTestimonio.php");
        break;
      case 'goTestimonio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/goTestimonio.php");
        break;
      case 'deleteTestimonio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/deleteTestimonio.php");
        break;
      case 'getDataEditTestimonio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/getDataEditTestimonio.php");
        break;
      case 'goWebContacto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/paginaweb/goWebContacto.php");
        break;
      case 'showMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showMascota.php");
        break;
      case 'goMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goMascota.php");
        break;
      case 'deleteMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteMascota.php");
        break;
      case 'getDataEditMascota':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditMascota.php");
        break;
      case 'getDataClienteForDocumento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataClienteForDocumento.php");
        break;
      case 'showCitas':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showCitas.php");
        break;
      case 'showMascotasDocumento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showMascotasDocumento.php");
        break;
      case 'goCita':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/goCita.php");
        break;
      case 'actualizarEstadoCita':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/actualizarEstadoCita.php");
        break;
      case 'actualizarFechaCita':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/actualizarFechaCita.php");
        break;
      case 'showCitasTrabajador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showCitasTrabajador.php");
        break;
      case 'showSucursal':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showSucursal.php");
        break;
      case 'goSucursal':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goSucursal.php");
        break;
      case 'deleteSucursal':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteSucursal.php");
        break;
      case 'showFundo':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showFundo.php");
        break;
      case 'goFundo':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goFundo.php");
        break;
      case 'deleteFundo':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteFundo.php");
        break;
      case 'showSucursalTrabajador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/showSucursalTrabajador.php");
        break;
      case 'goAccesoSucursal':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/seguridad/goAccesoSucursal.php");
        break;
      case 'showFundoCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showFundoCliente.php");
        break;
      case 'goAccesoFundo':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goAccesoFundo.php");
        break;
      case 'showMoneda':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showMoneda.php");
        break;
      case 'goMoneda':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goMoneda.php");
        break;
      case 'deleteMoneda':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteMoneda.php");
        break;
      case 'showMetodoPago':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showMetodoPago.php");
        break;
      case 'goMetodoPago':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goMetodoPago.php");
        break;
      case 'deleteMetodoPago':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteMetodoPago.php");
        break;
      case 'showTipoCambio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showTipoCambio.php");
        break;
      case 'goTipoCambio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goTipoCambio.php");
        break;
      case 'showDocumentoVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showDocumentoVenta.php");
        break;
      case 'goDocumentoVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goDocumentoVenta.php");
        break;
      case 'deleteDocumentoVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteDocumentoVenta.php");
        break;
      case 'showUnidadMedida':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showUnidadMedida.php");
        break;
      case 'goUnidadMedida':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goUnidadMedida.php");
        break;
      case 'deleteUnidadMedida':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteUnidadMedida.php");
        break;
      case 'showMascotaFicha':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showMascotaFicha.php");
        break;
      case 'showDetalleVacunas':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showDetalleVacunas.php");
        break;
      case 'registrarVacuna':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/registrarVacuna.php");
        break;
      case 'goRegistrarVacuna':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goRegistrarVacuna.php");
        break;
      case 'getDetalleCita':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getDetalleCita.php");
        break;
      case 'goRegistrarAtencion':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/goRegistrarAtencion.php");
        break;
      case 'showHistorialClinico':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showHistorialClinico.php");
        break;
      case 'showOrdenVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showOrdenVenta.php");
        break;
      case 'showDetalleParaOrden':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showDetalleParaOrden.php");
        break;
      case 'goOrdenVentaBorrador':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goOrdenVentaBorrador.php");
        break;
      case 'getDataOrdenVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataOrdenVenta.php");
        break;
      case 'goOrdenVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goOrdenVenta.php");
        break;
      case 'eliminarOrdenVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/eliminarOrdenVenta.php");
        break;
      case 'anularOrdenVenta':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/anularOrdenVenta.php");
        break;
      case 'showOrdenVentaReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showOrdenVentaReporte.php");
        break;
      case 'showCitaReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showCitaReporte.php");
        break;
      case 'showOrdenServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showOrdenServicio.php");
        break;
      case 'getOperadoresMaquinariasByCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getOperadoresMaquinariasByCronograma.php");
        break;
      case 'actualizarOperadorMaquinariaCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/actualizarOperadorMaquinariaCronograma.php");
        break;
      case 'goOperadorMaquinariaCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/goOperadorMaquinariaCronograma.php");
        break;
      case 'deleteOperadorMaquinariaCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/deleteOperadorMaquinariaCronograma.php");
        break;
      case 'getOperadorMaquinariaById':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getOperadorMaquinariaById.php");
        break;
      case 'getUnidadMedida':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getUnidadMedida.php");
        break;
      case 'getMaquinariasByCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getMaquinariasByCronograma.php");
        break;
      case 'actualizarMaquinariaCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/actualizarMaquinariaCronograma.php");
        break;
      case 'goMaquinariaCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/goMaquinariaCronograma.php");
        break;
      case 'deleteMaquinariaCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/deleteMaquinariaCronograma.php");
        break;
      case 'getCantidadDisponible':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getCantidadDisponible.php");
        break;
      case 'getMaquinariaById':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/getMaquinariaById.php");
        break;
      case 'showClienteReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showClienteReporte.php");
        break;
      case 'showProveedorReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showProveedorReporte.php");
        break;
      case 'showProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/showProveedor.php");
        break;
      case 'goProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/goProveedor.php");
        break;
      case 'deleteProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/deleteProveedor.php");
        break;
      case 'getDataEditProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/maintenance/getDataEditProveedor.php");
        break;
      case 'showProveedorReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showProveedorReporte.php");
        break;
      case 'addObservacionProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/addObservacionProveedor.php");
        break;
      case 'showObservacionesProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showObservacionesProveedor.php");
        break;
      case 'eliminarObservacionProveedor':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/eliminarObservacionProveedor.php");
        break;
      case 'getDataProveedorForDocumento':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataProveedorForDocumento.php");
        break;
      case 'getDataOrdenVentaReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/getDataOrdenVentaReporte.php");
        break;
      case 'showClienteReporte':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showClienteReporte.php");
        break;
      case 'showReportePagar':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showReportePagar.php");
        break;
      case 'showReporteCobrar':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/reportes/showReporteCobrar.php");
        break;
      case 'goPromocionCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goPromocionCliente.php");
        break;
      case 'showPromocionesCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showPromocionesCliente.php");
        break;
      case 'eliminarPromocionCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/eliminarPromocionCliente.php");
        break;
      case 'showMetodoEnvio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/showMetodoEnvio.php");
        break;
      case 'goMetodoEnvio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/goMetodoEnvio.php");
        break;
      case 'deleteMetodoEnvio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/configuration/deleteMetodoEnvio.php");
        break;
      case 'showDetalleParaOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showDetalleParaOrdenCompra.php");
        break;
      case 'deleteGastoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/deleteGastoServicio.php");
        break;
      case 'eliminarGastoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/eliminarGastoServicio.php");
        break;
      case 'getDataEditGastoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataEditGastoServicio.php");
        break;
      case 'getDataVerGastoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataVerGastoServicio.php");
        break;
      case 'goGastoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goGastoServicio.php");
        break;
      case 'showGastoServicio':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showGastoServicio.php");
        break;
      case 'deletePagoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/deletePagoGasto.php");
        break;
      case 'goPagoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goPagoGasto.php");
        break;
      case 'showPagoGasto':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showPagoGasto.php");
        break;
      case 'showOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showOrdenCompra.php");
        break;
      case 'goOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goOrdenCompra.php");
        break;
      case 'getDataVerOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataVerOrdenCompra.php");
        break;
      case 'getDataEditOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataEditOrdenCompra.php");
        break;
      case 'deleteOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/deleteOrdenCompra.php");
        break;
      case 'eliminarOrdenCompra':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/eliminarOrdenCompra.php");
        break;
      case 'showOrdenCompraIngreso':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showOrdenCompraIngreso.php");
        break;
      case 'getDataEditOrdenCompraIngreso':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataEditOrdenCompraIngreso.php");
        break;
      case 'goIngreso':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goIngreso.php");
        break;
      case 'showIngreso':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showIngreso.php");
        break;
      case 'getDataVerIngreso':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/getDataVerIngreso.php");
        break;
      case 'deleteIngreso':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/deleteIngreso.php");
        break;
      case 'deletePago':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/deletePago.php");
        break;
      case 'showPago':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/showPago.php");
        break;
      case 'goPago':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/operaciones/goPago.php");
        break;
      case 'deletePagoCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/deletePagoCliente.php");
        break;
      case 'showPagoCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showPagoCliente.php");
        break;
      case 'goPagoCliente':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/goPagoCliente.php");
        break;
      case 'buscar-dni':
        require("core/ajax/utils/buscarDNI.php");
        break;
      case 'buscar-ruc':
        require("core/ajax/utils/buscarRUC.php");
        break;
      case 'showCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/showCronograma.php");
        break;
        case 'showAuditoria':
          require("core/models/ClassAccesoOpcion.php");
          require("core/ajax/reportes/showAuditoria.php");
          break;
      case 'registrarCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/registrarCronograma.php");
        break;
      case 'actualizarCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/actualizarCronograma.php");
        break;
      case 'eliminarCronograma':
        require("core/models/ClassAccesoOpcion.php");
        require("core/ajax/citas/eliminarCronograma.php");
        break;
      case 'getCronograma':
        require("core/models/ClassAccesoOpcion.php");
        include("core/ajax/citas/getCronograma.php");
        break;
      case 'cambiarEstadoCronograma':
        require("core/models/ClassAccesoOpcion.php");
        include("core/ajax/citas/cambiarEstadoCronograma.php");
        break;
      case 'actualizarFechasHoras':
        require("core/models/ClassAccesoOpcion.php");
        include("core/ajax/citas/actualizarFechasHoras.php");
        break;
      default:
        $data["error"] = "SI";
        $data["message"] = "No se encontró el ajax especificado.";
        $data["data"] = null;
        echo json_encode($data);
        break;
    }
  } else {
    $data["error"] = "SI";
    $data["message"] = "No se recibieron los valores válidos.";
    $data["data"] = null;
    echo json_encode($data);
  }
} catch (\Exception $e) {
  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
}
