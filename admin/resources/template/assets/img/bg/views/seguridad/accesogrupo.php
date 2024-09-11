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
    <title>Acceso a Opciones | <?=APP_TITLE;?> </title>
    <style media="screen">

      .container-label {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 25px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

        /* Hide the browser's default checkbox */
      .container-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
      }

        /* Create a custom checkbox */
      .checkmark {
        position: absolute;
        left: 10px;
        top: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
      }

        /* On mouse-over, add a grey background color */
      .container-label:hover input ~ .checkmark {
        background-color: #ccc;
      }

        /* When the checkbox is checked, add a blue background */
      .container-label input:checked ~ .checkmark {
        background-color: #379392;
      }

        /* Create the checkmark/indicator (hidden when not checked) */
      .checkmark:after {
        content: "";
        position: absolute;
        display: none;
      }

        /* Show the checkmark when checked */
      .container-label input:checked ~ .checkmark:after {
        display: block;
      }

        /* Style the checkmark/indicator */
      .container-label .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
      }
    </style>

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
          </div>
        </div>

        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="col-xs-12">
              <div class="user-block block">

                <div class="row">

                  <div class="form-group col-md-4 col-sm-6">
                    <label for="cboModulo" class="label-control">Módulo</label>
                    <select class="form-control" name="cboModulo" id="cboModulo">
                      <?php
                          $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesogrupo"));
                          if ($access_options[0]['error']=="NO") {
                            if ($access_options[0]['flag_editar']) {
                              $dataModulos = $OBJ_ACCESO_OPCION->getModulos();
                              if ($dataModulos['error']=="NO") {
                                foreach ($dataModulos['data'] as $key) {
                                  ?>
                                    <option value="<?=$key['id_opcion'];?>"><?=$key['name_opcion'];?></option>
                                  <?php
                                }
                              }
                            }
                          }
                       ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4 col-sm-6">
                    <label for="cboGrupo" class="label-control">Grupo de Usuario</label>
                    <select name="cboGrupo" id="cboGrupo" class="form-control" required>
                      <?php
                        include("core/models/ClassGrupoUsuario.php");
                        $dataCargo = $OBJ_GRUPO_USUARIO->show("all");
                        if ($dataCargo["error"]=="NO") {
                          foreach ($dataCargo["data"] as $key) {
                            echo '<option value="' . $key['id_grupo'] . '">' . $key['name_grupo'] . '</option>';
                          }
                        }
                       ?>
                    </select>
                  </div>

                  <div class="col-md-4 col-sm-12">
                    <br><br>
                    <label class="container-label"> &nbsp;&nbsp;Marcar Todos
                      <input type="checkbox" id="chkMarcarTodos">
                      <span class="checkmark"></span>
                    </label>
                  </div>

                </div>

                <div class="row">

                  <div class="col-md-12" id="panelTabla">
                    <div class="user-block block">
                      <div class="table-responsive">
                        <table id="example" class="table table-bordered">
                          <thead>
                            <tr>
                              <th style="width:50px; text-align: center;">#</th>
                              <th>Id</th>
                              <th>Opción</th>
                              <th style="width:40px; text-align: center;">Agregar</th>
                              <th style="width:40px; text-align: center;">Editar</th>
                              <th style="width:40px; text-align: center;">Eliminar</th>
                              <th style="width:40px; text-align: center;">Anular</th>
                              <th style="width:40px; text-align: center;">Buscar</th>
                              <th style="width:40px; text-align: center;">Ver</th>
                              <th style="width:40px; text-align: center;">Descargar</th>
                            </tr>
                          </thead>

                        </table>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-xs-12">
                    <?php
                      if ($access_options[0]['error']=="NO") {
                        if ($access_options[0]['flag_editar']) {
                          ?>
                          <button type="button" name="btnSave" id="btnSave"
                           class="btn btn-primary float-right" style="color:#fff;">
                            Guardar Cambios
                          </button>
                          <?php
                        }
                      }
                     ?>
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
    <script src="resources/system/js/pages/seguridad/accesogrupo.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#tabmenuSeguridad").attr("aria-expanded",true);
      $("#tabmenuSeguridad1").addClass('show');
      $("#tabmenuSeguridad1").parent().addClass('active');
      $("#accesogrupo").addClass('active');
    </script>

  </body>
</html>
