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
    <title>Documentos de Identidad | <?=APP_TITLE;?> </title>

  </head>
  <body>

    <?php include("views/overall/topnav.php"); ?>

    <div class="d-flex align-items-stretch">

      <?php include("views/overall/leftNav.php"); ?>

      <div class="page-content">
        <div class="page-header">
          <div class="row">
            <div class="col-sm-6">
              <h4>Documentos de Identidad</h4>
            </div>
            <div class="col-sm-6" id="panelOptions" name="panelOptions">
              <?php
                  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("identitydocuments"));
                  if ($access_options[0]['error']=="NO") {

                    if ($access_options[0]['flag_agregar']) {
                      ?>
                      <a href="#" class="tooltip-wrapper float-right" data-toggle="tooltip" data-placement="top"
                        title="" data-original-title="Agregar" id="btnAdd">
                        <i class="fa fa-plus btn btn-icon text-success"></i>
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

                    <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos">

                      <input type="hidden" name="id_documento" id="id_documento" value="">
                      <input type="hidden" name="accion" id="accion" value="add">

                      <div class="row">
                        <div class="form-group col-md-4 col-sm-6">
                          <label for="name_documento" class="label-control">Documento</label>
                          <input id="name_documento" type="text" name="name_documento" class="form-control"
                          autocomplete="off" required data-msg="Campo obligatorio...">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                          <label for="codigo_sunat" class="label-control">Código Sunat</label>
                          <input id="codigo_sunat" type="text" name="codigo_sunat" class="form-control"
                          autocomplete="off" required data-msg="Campo obligatorio...">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                          <label for="size" class="label-control" id="labelSize"># Caracteres</label>
                          <input id="size" type="number" name="size" class="form-control"
                          autocomplete="off" required min="1" max="30" value="8">
                        </div>
                        <div class="form-group col-md-2 col-sm-6">
                          <br>
                          <div class="form-check">
                            <input id="estado" name="estado" type="checkbox"
                            class="form-check-input" checked>
                            <label for="estado" class="form-check-label">Estado</label>
                          </div>
                        </div>
                        <div class="form-group col-md-2 col-sm-6">
                          <label for="" class="label-control">Tipo de Documento</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="flag_numerico" id="rdbNumero"
                            value="1" required>
                            <label class="form-check-label" for="rdbNumero">
                              Sólo Números
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="flag_numerico" id="rdbNumeroLetra"
                            value="0" required>
                            <label class="form-check-label" for="rdbNumeroLetra">
                              Números y Letras
                            </label>
                          </div>
                        </div>
                        <div class="form-group col-md-2 col-sm-6">
                          <label for="" class="label-control">Longitud Exacta</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="flag_exacto" id="rdbSi"
                            value="1" required>
                            <label class="form-check-label" for="rdbSi">
                              SI
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="flag_exacto" id="rdbNo"
                            value="0" required>
                            <label class="form-check-label" for="rdbNo">
                              NO
                            </label>
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
                            <th>Id Documento</th>
                            <th>Documento</th>
                            <th style="width:30px; text-align: center;">Código SUNAT</th>
                            <th style="width:30px; text-align: center;">Tamaño</th>
                            <th style="width:30px; text-align: center;">Exacto</th>
                            <th style="width:30px; text-align: center;">Tipo</th>
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
    <script src="resources/system/js/pages/configuration/identitydocuments.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#tabmenuConfiguracion").attr("aria-expanded",true);
      $("#tabmenuConfiguracion1").addClass('show');
      $("#tabmenuConfiguracion1").parent().addClass('active');
      $("#identitydocuments").addClass('active');
    </script>

  </body>
</html>
