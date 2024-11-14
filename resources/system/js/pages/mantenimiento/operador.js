$(document).ready(function(){

    $("#panelForm").addClass("d-none");
    $("#divSinDatos").addClass("d-none");
    showData();
  
    $('#btnSearch').click(function(){
      showData();
    });
  
    $("#txtBuscar").keypress(function(e) {
      if (e.which == 13 ) {
        showData();
      }
    });
  
    $("#id_documento").change(function(){
      changeOption();
      });
  
    $('#btnAdd').click(function(){
      $('#frmDatos')[0].reset();
      $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
      $("#flag_imagen").val("0");
      $("#pass_user_old").val("");
      $("#accion").val("add");
      changeOption();
      addClassDiv();
    });
  
    $("#frmDatos").submit(function(e) {
      e.preventDefault();
      saveOperation();
    });
  
    $('#btnCancel').click(function(){
      removeClassDiv();
    });

    $("#num_documento").on("keypress", function (event) {
      if (event.which == 13) {
        validarYEnviar();
      }
    });
  
    $("#num_documento").on("blur", function () {
      validarYEnviar();
    });
  
  });
  
  function showData(){
  
    paginador = $(".pagination");
    var items = 6, numeros = 6;
    init_paginator(paginador,items,numeros);
    set_callback(get_data_callback);
    cargaPagina(0);
  
  }
  
  function get_data_callback() {
    var valor = $("#txtBuscar").val();
    var id_documento = $("#cboDocumentoBuscar").val();
    $.ajax({
        data: {
            limit: itemsPorPagina,
            offset: desde,
            valor: valor,
            id_documento: id_documento,
            accion: "show"  // Asegúrate de que el valor de accion sea "show"
        },
        beforeSend: function(xhr) {
            showHideLoader('block');
        },
        complete: function(jqXHR, textStatus) {
            showHideLoader('none');
            if (totalPaginas == 1 && pagina == 0) {
                paginador.find(".next_link").hide();
            }
        },
        type: "POST",
        url: 'ajax.php?accion=showOperador'
    }).done(function(data, textStatus, jqXHR) {
      try {
        console.log("Respuesta del servidor:", data); // Verifica el JSON en la consola
        var data1 = JSON.parse(data);
        console.log("Parsed data:", data1); // Muestra el JSON parseado en la consola
        if (data1["error"] == "NO") {
                if (pagina == 0) {
                    creaPaginador(data1["cantidad"]);
                }

                // genera el cuerpo de la tabla
                var innerdivHtml = "";
                var o = data1["data"];

                for (var i = 0; i < o.length; i++) {
                    innerdivHtml += '<div class="col-xxl-3 col-xl-4  col-sm-6">';
                    innerdivHtml += '<div class="card card-statistics contact-contant">';
                    innerdivHtml += '<div class="card-body py-4">';
                    innerdivHtml += '<div class="d-flex align-items-center">';
                    innerdivHtml += '<div class="bg-img">';
                    innerdivHtml += '<img src="' + o[i].src_imagen + '" alt="" class="img-fluid">';
                    innerdivHtml += '</div>';
                    innerdivHtml += '<div class="ml-3">';
                    innerdivHtml += '<h5 class="mb-0">' + o[i].apellidos + ' ' + o[i].nombres + '</h5>';
                    innerdivHtml += '<p>' + o[i].estado;
                    innerdivHtml += o[i].options;
                    innerdivHtml += '</p>';
                    innerdivHtml += '</div>';
                    innerdivHtml += '</div>';
                    innerdivHtml += '<div>';
                    innerdivHtml += '<ul class="nav">';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<div class="img-icon"><i class="fa fa-id-card"></i></div>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<p>' + o[i].name_documento + ' ' + o[i].num_documento + '</p>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '</ul>';
                    innerdivHtml += '<ul class="nav">';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<div class="img-icon"><i class="fa fa-map"></i></div>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<p>' + o[i].direccion + '</p>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '</ul>';
                    innerdivHtml += '<ul class="nav">';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<div class="img-icon"><i class="fa fa-phone"></i></div>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<p>' + o[i].telefono + '</p>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '</ul>';
                    innerdivHtml += '<ul class="nav">';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<div class="img-icon"><i class="fa fa-envelope-o"></i></div>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '<li class="nav-item">';
                    innerdivHtml += '<p>' + o[i].correo + '</p>';
                    innerdivHtml += '</li>';
                    innerdivHtml += '</ul>';
                    innerdivHtml += '</div>';
                    innerdivHtml += '</div>';
                    innerdivHtml += '</div>';
                    innerdivHtml += '</div>';
                }

                $("#divDatos").html(innerdivHtml);
                $("#divSinDatos").addClass("d-none");
                $("#divPaginador").removeClass("d-none");

              } else {
                console.log(data1["message"]);
                $("#divSinDatos").removeClass("d-none");
                $("#divPaginador").addClass("d-none");
                $("#divDatos").html("");
            }
        } catch (err) {
            console.error("Error en TryCatch:", err, " - Data:", data);
            runAlert("Message", err + data, "warning");
            $("#divSinDatos").removeClass("d-none");
            $("#divPaginador").addClass("d-none");
            $("#divDatos").html("");
        }
    }).fail(function(jqXHR, textStatus, textError) {
        runAlert("Oh No...!!!", "Error al realizar la petición " + textError, "warning");
    });
}


  function validarYEnviar() {
    var number_document = $("#num_documento").val();
    var id_document = $("#id_documento").val();
  
    // Validar que tenga 8 o 11 dígitos
    if (number_document.length === 8 || number_document.length === 11) {
      // Verificar si el tipo de documento es válido
      if (id_document != 1 && id_document != 3) {
        return false;
      }
  
      // Determinar el tipo de documento: DNI o RUC
      var tipo = id_document == 1 ? "dni" : "ruc";
  
      // Validar si la acción es 'add'
      if ($("#accion").val() == "add" && id_document) {
        // Realizar la solicitud AJAX
        $.ajax({
          url: "ajax.php?accion=buscar-" + tipo, // Cambia por la ruta correcta
          method: "POST",
          dataType: "json", // Especifica que la respuesta será JSON
          data: { dni: number_document, ruc: number_document },
          success: function (response) {
            if (response.success) {
              let nombres =
                id_document == 1
                  ? response.data.nombres
                  : response.data.nombre_o_razon_social;
              let apellidos =
                id_document == 1
                  ? response.data.apellido_paterno +
                    " " +
                    response.data.apellido_materno
                  : "";
              let direccion =
                id_document == 3 ? response.data.direccion_completa : "";
  
              // Mostrar los datos en los campos correspondientes
              $("#nombres").val(nombres);
              $("#apellidos").val(apellidos);
              $("#direccion").val(direccion);
            } else {
              console.log("Error en la API: " + response.error);
            }
          },
          error: function (xhr, status, error) {
            console.log("Error en la solicitud AJAX: " + error);
          },
        });
      }
    } else {
      alert("El número de documento debe tener 8 o 11 dígitos.");
    }
  }

  
  function changeOption(){
    var name_documento = $('select[name="id_documento"] option:selected').text();
    if (name_documento.toUpperCase().trim()=="RUC") {
      $("#lblSexo1").addClass("d-none");
      $("#lblSexo2").addClass("d-none");
      $("#lblNombres").html("Razón Social");
      $("#lblApellidos").html("Nombre Comercial");
      $("#lblFechaNacimiento").html("Fecha Creación");
    }else {
      $("#lblSexo1").removeClass("d-none");
      $("#lblSexo2").removeClass("d-none");
      $("#lblNombres").html("Nombres");
      $("#lblApellidos").html("Apellidos");
      $("#lblFechaNacimiento").html("Fecha Nacimiento");
    }
  }
  
  function addClassDiv(){
    $("#panelForm").removeClass("d-none");
    $("#panelTabla").addClass("d-none");
    $("#panelOptions").addClass("d-none");
  }
  
  function removeClassDiv(){
    $("#panelForm").addClass("d-none");
    $("#panelTabla").removeClass("d-none");
    $("#panelOptions").removeClass("d-none");
    $("#frmDatos")[0].reset();
  }
  
  function mostrarImagen(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#img_destino').attr('src', e.target.result);
        $("#flag_imagen").val("1");
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
    $("#src_imagen").change(function(){
    mostrarImagen(this);
  });
  
  function saveOperation(){
  
    Swal.fire({
      title: '¿Seguro de confirmar la operación?',
      text: "No podrás revertir esta operación.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Realizar ahora!'
    }).then(function(result) {
      if (result.value) {
        var form = $("#frmDatos");
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=goOperador",
          contentType: false,
          processData: false,
          data: formdata,
          success: function(data){
                  try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
                removeClassDiv();
                showData();
                runAlert("Bien hecho...!!!",response['message'],"success");
              }
            } catch (e) {
              runAlert("Oh No...!!!",e + data,"error");
            }
              },
              error: function(data){
            runAlert("Oh No...!!!",data,"error");
              },
          beforeSend: function (xhr) {
            showHideLoader('block');
          },
          complete: function (jqXHR, textStatus) {
            showHideLoader('none');
          }
        });
      }
    });
  }
  
  function getDataEdit(id_operador) {
    // Aquí puedes configurar la solicitud AJAX para obtener los detalles del operador
    $.ajax({
        type: "POST",
        data: { id_operador: id_operador },
        url: "ajax.php?accion=getDataEditOperador",
        success: function(data) {
            try {
                var data1 = JSON.parse(data);
                if (data1["error"] == "NO") {
                    var o = data1["data"];
                    // Llenar los campos del formulario con los datos obtenidos
                    $("#id_documento").val(o[0].id_documento);
                    $("#num_documento").val(o[0].num_documento);
                    $("#nombres").val(o[0].nombres);
                    $("#apellidos").val(o[0].apellidos);
                    $("#direccion").val(o[0].direccion);
                    $("#telefono").val(o[0].telefono);
                    $("#correo").val(o[0].correo);
                    $("#fecha_nacimiento").val(o[0].fecha_nacimiento);
                    $("#id_persona").val(o[0].id_persona);
                    $("#id_operador").val(o[0].id_operador);
                    $("#accion").val("edit");
                    $("#flag_imagen").val("0");
                    $("#pass_user_old").val(o[0].pass_user);
                    $("#pass_user").val(o[0].pass_user);
                    $("#name_user").val(o[0].name_user);
                    var sexo = o[0].sexo;
                    var estado = o[0].estado;
                    sexo == "masculino" ? $("#rdbM").prop("checked", true) : $("#rdbF").prop("checked", true);
                    estado == "activo" ? $("#estado").prop("checked", true) : $("#estado").prop("checked", false);
                    $('#img_destino').attr('src', o[0].src_imagen);
                    changeOption();
                    addClassDiv();
                } else {
                    runAlert("Message", data1["message"], "warning");
                }
            } catch (e) {
                console.error("Error en TryCatch:", e, " - Data:", data);
                runAlert("Oh No...!!!", "Error en TryCatch: " + e + data, "error");
            }
        },
        beforeSend: function(xhr) {
            showHideLoader("block");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error de petición:", jqXHR);
            runAlert("Oh No...!!!", "Error de petición: " + jqXHR, "warning");
        },
        complete: function(jqXHR, textStatus) {
            showHideLoader("none");
        }
    });
}

  
  function deleteRegistro(id_operador,operador){
  
    try {
  
      var parametros = {
        "id_operador" : id_operador
      };
  
      Swal.fire({
        title: '¿Seguro de eliminar el operador : ' + operador + '?',
        text: "No podrás revertir esta operación.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar ahora!'
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=deleteOperador",
            datatype: "json",
            data: parametros,
            success: function(data){
              try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  runAlert("Oh No...!!!",response['message'],"warning");
                }else {
                  removeClassDiv();
                  showData();
                  runAlert("Bien hecho...!!!",response['message'],"success");
                }
              } catch (e) {
                runAlert("Oh No...!!!",e,"error");
              }
            },
            error: function(data){
              runAlert("Oh No...!!!",data,"error");
            },
            beforeSend: function (xhr) {
              showHideLoader('block');
            },
            complete: function (jqXHR, textStatus) {
              showHideLoader('none');
            }
          });
        }
      });
  
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  }
  