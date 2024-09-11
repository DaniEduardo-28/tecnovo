<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: logout');
    exit();
  }
?>
<!DOCTYPE html>
<html>
  <head>

    <?php include("views/overall/header.php"); ?>
    <title>Grupos de Usuario | <?=APP_TITLE;?> </title>

  </head>
  <body>

    <?php include("views/overall/topnav.php"); ?>

    <div class="d-flex align-items-stretch">

      <?php include("views/overall/leftNav.php"); ?>

      <div class="page-content">
        <div class="page-header">
          <div class="row">
            <div class="col-sm-6">
              <h4>Grupos de Usuario</h4>
            </div>
            <div class="col-sm-6" id="panelOptions" name="panelOptions">
              <?php
                  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("grupousuario"));
                  if ($access_options[0]['error']=="NO") {

                    if ($access_options[0]['flag_agregar']) {
                      ?>
                      <a href="#" class="tooltip-wrapper float-right" data-toggle="tooltip" data-placement="top"
                        title="" data-original-title="Agregar" id="btnAdd">
                        <i class="fa fa-plus-circle btn btn-icon text-success"></i>
                      </a>
                      <?php
                    }
                    if ($access_options[0]['flag_buscar']) {
                      ?>
                      <a href="#" class="tooltip-wrapper float-right" data-toggle="tooltip" data-placement="top"
                      title="" data-original-title="Actualizar listado" id="btnSearch">
                        <i class="fa fa-refresh btn btn-icon text-primary"></i>
                      </a>
                      <?php
                    }
                  }
               ?>
            </div>
          </div>
        </div>

        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="col-xs-12">
              <div class="user-block block">

                <div class="col-md-12" id="panelForm"> <!-- d-none -->
                  <div class="ser-block block">
                    <form action="#" method="post" id="frmDatos" name="frmDatos">

                      <input type="hidden" name="id_grupo" id="id_grupo" value="">
                      <input type="hidden" name="accion" id="accion" value="add">

                      <div class="row">
                        <div class="form-group col-md-4 col-sm-6">
                          <label for="name_grupo" class="label-control">Grupo Usuario</label>
                          <input id="name_grupo" type="text" name="name_grupo" class="form-control"
                          autocomplete="off" required data-msg="Campo obligatorio...">
                        </div>
                        <div class="form-group col-md-2 col-sm-6">
                          <br>
                          <div class="form-check">
                            <input id="estado" name="estado" type="checkbox"
                            class="form-check-input" checked>
                            <label for="estado" class="form-check-label">Estado</label>
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <button type="submit" name="btnSave" id="btnSave" name="button" class="btn btn-success float-right"> <span class="fa fa-save"></span> Guardar</button>
                          <button type="reset" name="btnCancel" id="btnCancel" name="button" class="btn btn-danger float-right"> <span class="fa fa-close"></span> Cancelar</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>

                <div class="col-md-12" id="panelTabla">
                  <div class="user-block block">
                    <div class="table-responsive">
                      <table id="example" class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width:50px; text-align: center;">#</th>
                            <th>Id</th>
                            <th>Grupo Usuario</th>
                            <th style="width:30px; text-align: center;">Estado</th>
                            <th style="width:90px;">Options</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>

        <?php include("views/overall/footer.php"); ?>

      </div>

    </div>

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/seguridad/grupousuario.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#tabmenuSeguridad").attr("aria-expanded",true);
      $("#tabmenuSeguridad1").addClass('show');
      $("#tabmenuSeguridad1").parent().addClass('active');
      $("#grupousuario").addClass('active');
    </script>

  </body>
</html>
