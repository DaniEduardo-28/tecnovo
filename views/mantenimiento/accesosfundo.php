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
  <title>Acceso a Fundos | <?= APP_TITLE; ?> </title>
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
    .container-label:hover input~.checkmark {
      background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-label input:checked~.checkmark {
      background-color: #f7440c;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .container-label input:checked~.checkmark:after {
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

    /* Estilo para el nuevo input de búsqueda */
    .search-input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
    }

    /* Estilo para los resultados de la búsqueda */
    .search-results {
      position: absolute;
      width: 100%;
      max-height: 200px;
      overflow-y: auto;
      background-color: white;
      z-index: 1000;
    }

    .search-result-item {
      padding: 10px;
      cursor: pointer;
    }

    .search-result-item:hover {
      background-color: #f0f0f0;
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
                          Fundos por clientes
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                          Acceso a Fundos
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
                      <h4 class="card-title">Acceso a Fundos</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      <div class="form-group col-sm-6">
                        <label for="cboCliente" class="label-control">Cliente</label>
                        <select class="form-control" name="cboCliente" id="cboCliente">
                          <?php
                          $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("accesofundo"));
                          if ($access_options[0]['error'] == "NO") {
                            if ($access_options[0]['flag_editar']) {
                              require("core/models/ClassCliente.php");
                              $dataTrabajador = $OBJ_CLIENTE->listarClientes();
                              if ($dataTrabajador['error'] == "NO") {
                                foreach ($dataTrabajador['data'] as $key) {
                          ?>
                                  <option value="<?= $key['id_cliente']; ?>">
                                    <?= $key['apellidos_cliente'] . ' ' . $key['nombres_cliente'] . ' - ' . $key['name_documento'] . ' ' . $key['num_documento'] . '(' . $key['apodo'] . ')'; ?>
                                  </option>
                          <?php
                                }
                              }
                            }
                          }
                          ?>
                        </select>
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
                                  <th>Fundo</th>
                                  <th style="width:100px; text-align: center;">Cantidad HC</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                require("core/models/ClassFundo.php");
                                $dataFundos = $OBJ_FUNDO->show(1, "all");
                                if ($dataFundos['error'] == "NO") {
                                  $num = 1;
                                  foreach ($dataFundos['data'] as $key) {
                                ?>
                                    <tr>
                                      <td><?= $num; ?></td>
                                      <td><?= $key['id_fundo']; ?></td>
                                      <td><?= strtoupper($key['nombre']); ?></td>
                                      <td><input type="number" class="form-control cantidad-hc" min="0" step="1" value="0">
                                      </td>
                                    </tr>
                                <?php
                                    $num++;
                                  }
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

                      <div class="float-right">
                        <div class="col-sm-2 col-xs-6">
                          <br>
                          <?php
                          if ($access_options[0]['error'] == "NO") {
                            if ($access_options[0]['flag_editar']) {
                          ?>
                              <button type="button" name="btnSave" id="btnSave" class="btn btn-primary" style="color:#fff;">
                                GRABAR
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

          </div>

        </div>

      </div>
      <!-- end container-fluid -->

      <!-- begin footer -->
      <?php include("views/overall/footer.php"); ?>
      <!-- end footer -->

    </div>
    <!-- end app-main -->
  </div>
  <!-- end app-container -->

  <!-- JavaScript files-->
  <?php include("views/overall/js.php"); ?>
  <script src="resources/system/js/pages/mantenimiento/accesofundo.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menumantenimiento").addClass('active');
    $("#menuaccesofundo").addClass('active');
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchCliente');
      const searchResults = document.getElementById('searchResults');
      const cboCliente = document.getElementById('cboCliente');

      searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const options = cboCliente.options;

        searchResults.innerHTML = '';

        for (let i = 0; i < options.length; i++) {
          if (options[i].text.toLowerCase().includes(searchTerm)) {
            const div = document.createElement('div');
            div.className = 'search-result-item';
            div.textContent = options[i].text;
            div.addEventListener('click', function() {
              cboCliente.value = options[i].value;
              searchInput.value = options[i].text;
              searchResults.innerHTML = '';
            });
            searchResults.appendChild(div);
          }
        }
      });

      // Cerrar resultados de búsqueda al hacer clic fuera
      document.addEventListener('click', function(e) {
        if (e.target !== searchInput && e.target !== searchResults) {
          searchResults.innerHTML = '';
        }
      });
    });

    $('#cboCliente').select2({
      placeholder: "Seleccione un cliente",
      allowClear: true
    });

  </script>
</body>

</html>