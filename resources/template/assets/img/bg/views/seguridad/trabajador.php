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
    <title>Usuarios del Sistema | <?=APP_TITLE;?> </title>
    <style media="screen">
      .pagination {
        display: inline-block;
      }
      .pagination li {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        cursor: pointer;
      }
      .pagination li.active {
        background-color: #379392;
        color: white;
      }
      .pagination li:hover:not(.active) {
        background-color: #ddd;
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
              <h4>Usuarios del Sistema</h4>
            </div>
            <div class="col-sm-6" id="panelOptions" name="panelOptions">
              <?php
                  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("trabajador"));
                  if ($access_options[0]['error']=="NO") {

                    if ($access_options[0]['flag_agregar']) {
                      ?>
                      <a href="#" class="tooltip-wrapper float-right" data-toggle="tooltip" data-placement="top"
                        title="" data-original-title="Agregar" id="btnAdd">
                        <i class="fa fa-plus-circle btn btn-icon text-success"></i>
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
                    <form id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                      <input type="hidden" name="id_trabajador" id="id_trabajador" value="0">
                      <input type="hidden" name="id_persona" id="id_persona" value="0">
                      <input type="hidden" name="flag_imagen" id="flag_imagen" value="0">
                      <input type="hidden" name="pass_user_old" id="pass_user_old" value="">
                      <input type="hidden" name="accion" id="accion" value="add">

                      <div class="row">

                        <div class="form-group col-sm-1">
                          &nbsp;
                        </div>

                        <div class="form-group col-sm-4">
                          <img id="img_destino" src="resources/global/images/sin_imagen.png"
                          alt="Logo / Imagen Perfil" class="img-fluid rounded-circle"
                          style="width:200px;height:200px;">
                          <br>
                          <label for="">Logo / Imagen Perfil</label>
                          <br>
                          <div class="form-group">
                            <input type="file" name="src_imagen" id="src_imagen" accept="image/jpeg"
                            class="is-valid" aria-invalid="false">
                          </div>
                        </div>

                        <div class="form-group col-sm-1">
                          &nbsp;
                        </div>

                        <div class="form-group col-sm-6">

                          <div class="form-group col-xs-12">
                            <label for="id_documento" class="label-material">Tipo Documento</label>
                            <select name="id_documento" id="id_documento" class="form-control" required>
                              <option value="">Seleccione</option>
                              <?php
                                include("core/models/ClassDocumentoIdentidad.php");
                                $dataDocumento = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                                if ($dataDocumento["error"]=="NO") {
                                  foreach ($dataDocumento["data"] as $key) {
                                    echo '<option value="' . $key['id_documento'] . '">' . $key['name_documento'] . '</option>';
                                  }
                                }
                               ?>
                            </select>
                          </div>

                          <div class="form-group col-xs-12">
                            <label for="num_documento" class="label-control">Número Documento</label>
                            <input id="num_documento" type="number" name="num_documento" class="form-control"
                            autocomplete="off" required data-msg="Campo obligatorio...">
                          </div>

                          <div class="form-group col-xs-12">
                            <label for="nombres" class="label-control" id="lblNombres">Nombres</label>
                            <input id="nombres" type="text" name="nombres" class="form-control"
                            autocomplete="off" required data-msg="Campo obligatorio...">
                          </div>

                          <div class="form-group col-xs-12">
                            <label for="apellidos" class="label-control" id="lblApellidos">Apellidos</label>
                            <input id="apellidos" type="text" name="apellidos" class="form-control"
                            autocomplete="off" required data-msg="Campo obligatorio...">
                          </div>

                        </div>


                      </div>

                      <div class="row">

                        <div class="form-group col-md-12 col-sm-6">
                          <label for="direccion" class="label-control">Dirección</label>
                          <input id="direccion" type="text" name="direccion" class="form-control"
                          autocomplete="off">
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                          <label for="telefono" class="label-control">Teléfono</label>
                          <input id="telefono" type="tel" name="telefono" class="form-control"
                          autocomplete="off">
                        </div>

                        <div class="form-group col-md-8 col-sm-6">
                          <label for="correo" class="label-control">Correo</label>
                          <input id="correo" type="email" name="correo" class="form-control"
                          autocomplete="off">
                        </div>

                        <div class="form-group col-md-6">
                          <label for="id_especialidad" class="label-control">Cargo</label>
                          <select name="id_especialidad" id="id_especialidad" class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php
                              include("core/models/ClassEspecialidad.php");
                              $dataEspecialidad = $OBJ_ESPECIALIDAD->show("activo");
                              if ($dataEspecialidad["error"]=="NO") {
                                foreach ($dataEspecialidad["data"] as $key) {
                                  echo '<option value="' . $key['id_especialidad'] . '">' . $key['name_especialidad'] . '</option>';
                                }
                              }
                             ?>
                          </select>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="id_grupo" class="label-material">Grupo de Usuario</label>
                          <select name="id_grupo" id="id_grupo" class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php
                              include("core/models/ClassGrupoUsuario.php");
                              $dataCargo = $OBJ_GRUPO_USUARIO->show("activo");
                              if ($dataCargo["error"]=="NO") {
                                foreach ($dataCargo["data"] as $key) {
                                  echo '<option value="' . $key['id_grupo'] . '">' . $key['name_grupo'] . '</option>';
                                }
                              }
                             ?>
                          </select>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="name_user" class="label-control">Usuario</label>
                          <input id="name_user" type="text" name="name_user" class="form-control"
                          autocomplete="off" required data-msg="Campo obligatorio...">
                        </div>

                        <div class="form-group col-md-6">
                          <label for="pass_user" class="label-control">Contraseña</label>
                          <input id="pass_user" type="password" name="pass_user" class="form-control"
                          autocomplete="off" required data-msg="Campo obligatorio...">
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                          <label for="fecha_nacimiento" class="label-control" id="lblFechaNacimiento">Fecha Nacimiento</label>
                          <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" class="form-control"
                          autocomplete="off" value="<?=date("Y-m-d",strtotime(date("Y-m-d")."- 30 years")); ?>">
                        </div>

                        <div class="form-group col-md-2 col-sm-4" id="lblSexo1">
                          <label for="" class="label-control">Sexo</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexo"
                            id="rdbM" value="M">
                            <label class="form-check-label" for="rdbM">
                              Masculino
                            </label>
                          </div>
                        </div>

                        <div class="form-group col-md-2 col-sm-4" id="lblSexo2">
                          <label for="" class="label-control">&nbsp;</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexo"
                            id="rdbF" value="F">
                            <label class="form-check-label" for="rdbF">
                              Femenino
                            </label>
                          </div>
                        </div>

                        <div class="form-group col-md-2 col-sm-4">
                          <label for="">&nbsp;</label>
                          <div class="form-check">
                            <input id="flag_medico" name="flag_medico" type="checkbox" class="form-check-input" checked="">
                            <label for="flag_medico" class="form-check-label">Mostrar en la Web</label>
                          </div>
                        </div>

                        <div class="form-group col-md-2 col-sm-4">
                          <label for="">&nbsp;</label>
                          <div class="form-check">
                            <input id="estado" name="estado" type="checkbox" class="form-check-input" checked="">
                            <label for="estado" class="form-check-label">Estado</label>
                          </div>
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                          <label for="link_facebook" class="label-control">Facebook</label>
                          <input type="text" name="link_facebook" id="link_facebook" class="form-control">
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                          <label for="link_instagram" class="label-control">Instagram</label>
                          <input type="text" name="link_instagram" id="link_instagram" class="form-control">
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                          <label for="link_twitter" class="label-control">Twitter</label>
                          <input type="text" name="link_twitter" id="link_twitter" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                          <label for="descripcion" class="label-control">Descripción</label>
                          <input type="text" name="descripcion" id="descripcion" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                          <button type="submit" name="btnSave" id="btnSave" name="button"
                            class="btn btn-success float-right"> <span class="fa fa-save"></span> Guardar</button>
                          <button type="reset" name="btnCancel" id="btnCancel" name="button"
                            class="btn btn-danger float-right"> <span class="fa fa-close"></span> Cancelar</button>
                        </div>

                      </div>

                    </form>
                  </div>
                </div>

                <div class="col-md-12" id="panelTabla">

                  <!-- START CONTENT -->
                  <div class="row">

                    <div class="col-md-2 col-sm-4">
                      <div class="form-group">
                        <label for="cboEspecialidadBuscar" class="label-control">Cargo  </label>
                        <select name="cboEspecialidadBuscar" id="cboEspecialidadBuscar" class="form-control">
                          <option value="">Todos</option>
                          <?php
                            $dataEspecialidad = $OBJ_ESPECIALIDAD->show("all");
                            if ($dataEspecialidad["error"]=="NO") {
                              foreach ($dataEspecialidad["data"] as $key) {
                                echo '<option value="' . $key['id_especialidad'] . '">' . $key['name_especialidad'] . '</option>';
                              }
                            }
                           ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2 col-sm-4">
                      <div class="form-group">
                        <label for="cboGrupoBuscar" class="label-material">Grupo de Usuario</label>
                        <select name="cboGrupoBuscar" id="cboGrupoBuscar" class="form-control">
                          <option value="">Todos</option>
                          <?php
                            $dataCargo = $OBJ_GRUPO_USUARIO->show("all");
                            if ($dataCargo["error"]=="NO") {
                              foreach ($dataCargo["data"] as $key) {
                                echo '<option value="' . $key['id_grupo'] . '">' . $key['name_grupo'] . '</option>';
                              }
                            }
                           ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2 col-sm-4">
                      <div class="form-group">
                        <label for="cboDocumentoBuscar" class="label-control">Documento</label>
                        <select class="form-control" name="cboDocumentoBuscar" id="cboDocumentoBuscar">
                          <option value="">Todos...</option>
                          <?php
                            $dataDocumento = $OBJ_DOCUMENTO_IDENTIDAD->show("all");
                            if ($dataDocumento["error"]=="NO") {
                              foreach ($dataDocumento["data"] as $key) {
                                echo '<option value="' . $key['id_documento'] . '">' . $key['name_documento'] . '</option>';
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                      <label for="">&nbsp;</label>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search..."
                        aria-label="Recipient's username" aria-describedby="basic-addon2"
                        id="txtBuscar" name="txtBuscar">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary" id="btnSearch" type="button">Buscar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row" id="divDatos">

                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 text-center" id="divPaginador">
                    <ul class="pagination pagination-split" id="paginador">

                    </ul>
                  </div>

                  <div class="container" id="divSinDatos">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-md-8 text-center">
                        <div class="error-text">
                          <h3 class="m-t-30">No se encontraron datos</h3>
                          <p>Posiblemente no tiene ningún trabajador registrado con los parametros de busqueda</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END CONTENT -->

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
    <script src="resources/system/js/pages/seguridad/trabajador.js?v=<?=APP_VERSION;?>"></script>
    <script>
    $("#tabmenuSeguridad").attr("aria-expanded",true);
    $("#tabmenuSeguridad1").addClass('show');
    $("#tabmenuSeguridad1").parent().addClass('active');
    $("#trabajador").addClass('active');
    </script>

  </body>
</html>
