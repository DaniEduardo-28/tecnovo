<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
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
        background-color: #f7440c;
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


        <!-- begin app -->
        <div class="app">
            <!-- begin app-wrap -->
            <div class="app-wrap">

              <!-- begin pre-loader -->
              <?php include("views/overall/loader.php"); ?>
              <!-- end pre-loader -->

              <!-- begin app-top-nav -->
              <?php include("views/overall/topNav.php"); ?>
              <!-- end app-top-nav -->

              <!-- begin app-container -->
              <div class="app-container">

                <!-- begin app-nabar -->
                <?php include("views/overall/leftNav.php"); ?>
                <!-- end app-navbar -->

                <!-- begin app-main -->
                  <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                      <!-- begin row -->
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <!-- begin page title -->
                            <div class="d-block d-lg-flex flex-nowrap align-items-center">
                              <div class="page-title mr-4 pr-4 border-right">
                                 
                              </div>
                              <div class="breadcrumb-bar align-items-center">
                                <nav>
                                  <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                      <a href="?view=home"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                      Seguridad
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">
                                      Acceso a Opciones
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                            </div>
                                    <!-- end page title -->
                          </div>
                        </div>

                        <div class="row">

                            <div class="col-xl-12">
                              <div class="card card-statistics">
                                <div class="card-header">
                                    <div class="card-heading">
                                        <h4 class="card-title">Acceso a Opciones</h4>
                                    </div>
                                </div>
                                <div class="card-body">

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

                                  <div class="float-right">
                                    <div class="col-sm-2 col-xs-6">
                                      <br>
                                      <?php
                                        if ($access_options[0]['error']=="NO") {
                                          if ($access_options[0]['flag_editar']) {
                                            ?>
                                            <button type="button" name="btnSave" id="btnSave"
                                             class="btn btn-primary" style="color:#fff;">
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

                          </div>

                      </div>
                        <!-- end container-fluid -->
                    </div>
                    <!-- end app-main -->
                </div>
                <!-- end app-container -->

                <!-- begin footer -->
                <?php include("views/overall/footer.php"); ?>
                <!-- end footer -->

            </div>
            <!-- end app-wrap -->
        </div>
        <!-- end app -->

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/seguridad/accesogrupo.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menuseguridad").addClass('active');
      $("#menuaccesogrupo").addClass('active');
    </script>

  </body>

</html>
