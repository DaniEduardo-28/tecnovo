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

});

function showData(){

  paginador = $(".pagination");
  var items = 6, numeros = 6;
  init_paginator(paginador,items,numeros);
  set_callback(get_data_callback);
  cargaPagina(0);

}

// peticion ajax enviada como callback
function get_data_callback(){
  var valor = $("#txtBuscar").val();
  var id_documento = $("#cboDocumentoBuscar").val();
  var id_grupo = $("#cboGrupoBuscar").val();
  $.ajax({
		data:{
  		limit: itemsPorPagina,
  		offset: desde,
      valor: valor,
      id_documento: id_documento,
      id_grupo: id_grupo
		},
    beforeSend: function (xhr) {
      showHideLoader('block');
    },
    complete: function (jqXHR, textStatus) {
      showHideLoader('none');
      if (totalPaginas==1 && pagina==0) {
        paginador.find(".next_link").hide();
      }
    },
		type:"POST",
		url:'ajax.php?accion=showTrabajador'
	}).done(function(data,textStatus,jqXHR){
    try {
      var data1 = JSON.parse(data);
      if (data1["error"]=="NO") {

        if(pagina==0){
          creaPaginador(data1["cantidad"]);
        }

        // genera el cuerpo de la tabla
        var innerdivHtml = "";
        var o = data1["data"];

        for (var i = 0; i < o.length; i++) {
          innerdivHtml += '<div class="col-xxl-4 col-xl-4  col-sm-6">';
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

      }else {
        console.log(data1["message"]);
        $("#divSinDatos").removeClass("d-none");
        $("#divPaginador").addClass("d-none");
        $("#divDatos").html("");
      }
    }
    catch(err) {
      runAlert("Message",err+data,"warning");
      $("#divSinDatos").removeClass("d-none");
      $("#divPaginador").addClass("d-none");
      $("#divDatos").html("");
    }

	}).fail(function(jqXHR,textStatus,textError){
    runAlert("Oh No...!!!","Error al realizar la petición " + textError,"warning");
	});
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
        url: "ajax.php?accion=goTrabajador",
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

function getDataEdit(id_trabajador){
  $.ajax({
    type: "POST",
    data:{
  		id_trabajador: id_trabajador
		},

    url: "ajax.php?accion=getDataEditTrabajador",
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          $("#id_documento").val(o[0].id_documento);
          $("#num_documento").val(o[0].num_documento);
          $("#nombres").val(o[0].nombres);
          $("#apellidos").val(o[0].apellidos);
          $("#direccion").val(o[0].direccion);
          $("#telefono").val(o[0].telefono);
          $("#correo").val(o[0].correo);
          $("#fecha_nacimiento").val(o[0].fecha_nacimiento);
          $("#id_persona").val(o[0].id_persona);
          $("#id_trabajador").val(o[0].id_trabajador);
          $("#accion").val("edit");
          $("#flag_imagen").val("0");
          $("#pass_user_old").val(o[0].pass_user);
          $("#pass_user").val(o[0].pass_user);
          $("#name_user").val(o[0].name_user);
          $("#id_grupo").val(o[0].id_grupo);
          $("#descripcion").val(o[0].descripcion);
          $("#link_facebook").val(o[0].link_facebook);
          $("#link_instagram").val(o[0].link_instagram);
          $("#link_twitter").val(o[0].link_twitter);
          var sexo = o[0].sexo;
          var estado = o[0].estado;
          var flag_medico = o[0].flag_medico;
          sexo=="masculino" ? $("#rdbM").prop('checked', true) : $("#rdbF").prop('checked', true);
          estado=="activo" ? $("#estado").prop('checked', true) : $("#estado").prop('checked', false);
          flag_medico=="1" ? $("#flag_medico").prop('checked', true) : $("#flag_medico").prop('checked', false);
          $('#img_destino').attr('src', o[0].src_imagen);
          changeOption();
          addClassDiv();
        }else {
          runAlert("Message",data1["message"],"warning");
        }
      } catch (e) {
        runAlert("Oh No...!!!","Error en TryCatch: " + e + data,"error");
        showHideLoader('none');
      }
    },
    beforeSend: function (xhr) {
      showHideLoader('block');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      runAlert("Oh No...!!!","Error de petición: " + jqXHR,"warning");
    },
    complete: function (jqXHR, textStatus) {
      showHideLoader('none');
    }
  });
}

function deleteRegistro(id_trabajador,trabajador){

  try {

    var parametros = {
      "id_trabajador" : id_trabajador
    };

    Swal.fire({
      title: '¿Seguro de eliminar el trabajador : ' + trabajador + '?',
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
          url: "ajax.php?accion=deleteTrabajador",
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
