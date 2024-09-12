
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_mascota' },
    { 'data': 'cliente' },
    { 'data': 'name_tipo' },
    { 'data': 'nombre' },
    { 'data': 'raza' },
    { 'data': 'color' },
    { 'data': 'peso' },
    { 'data': 'fecha_nacimiento' },
    { 'data': 'estado' },
    { 'data': 'options' }
  ],
  columnDefs: [
    {
      "targets": [1],
      "visible": false,
      "searchable": false
    }
  ]
});

function mostrarImagen(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#img_destino').attr('src', e.target.result);
      $("#flag_imagen").val("1");
    }
    reader.readAsDataURL(input.files[0]);
  }else {
    $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
    $("#flag_imagen").val("0");
  }
}

$("#src_imagen").change(function(){
  mostrarImagen(this);
});

$(document).ready(function(){

  $("#num_documento").keypress(function(event) {
    if (event.which==13) {

     event.preventDefault();

     if ($("#id_documento").val()=="") {
      runAlert("Advertencia","Seleccione un documento.","warning");
      return;
     }

     if ($("#num_documento").val()=="") {
      runAlert("Advertencia","Ingrese un número de documento.","warning");
      return;
     }

     /* Start Ajax */
     $.ajax({
       type: "POST",
       data:{
        id_documento: $("#id_documento").val(),
        num_documento: $("#num_documento").val()
      },
       url: "ajax.php?accion=getDataClienteForDocumento",
       success : function(data) {
         try {
           var data1 = JSON.parse(data);
           if (data1["error"]=="NO") {
             var o = data1["data"];
             $("#nombres").val(o[0].nombres);
             $("#apellidos").val(o[0].apellidos);
           } else {
             console.log(data1["message"]);
             $("#nombres").val("");
             $("#apellidos").val("");
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
     /* End Ajax */

    }
  });

  $("#panelForm").addClass("d-none");

  showLista();

  $('#cboTipoBuscar').change(function(){
    showLista();
  });

  $('#btnSearch').click(function(){
    showLista();
  });

  $('#btnAdd').click(function(){
    $('#img_destino').attr('src', "resources/global/images/sin_imagen.png");
    $("#flag_imagen").val("0");
    $("#id_mascota").val("0");
    $("#accion").val("add");
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_mascota").val("0");
    $("#flag_imagen").val("0");
    $("#accion").val("add");
    $("#id_documento").val("");
    $("#num_documento").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#id_tipo_mascota").val("");
    $("#nombre_mascota").val("");
    $("#raza").val("");
    $("#color").val("");
    $("#peso").val("");
    $("#sexo").val("");
    $("#observaciones").val("");
    $("#estado").prop('checked', false);
  });

});

function addClassDiv(){
  $("#panelForm").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
}

function removeClassDiv(){
  $("#panelForm").addClass("d-none");
  $("#panelTabla").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
  $('#frmDatos')[0].reset();
}

function showLista(){
  table.clear().draw();
  var id_tipo_mascota = $("#cboTipoBuscar").val();
  var id_documento = $("#cboDocumentoBuscar").val();
  var valor = $("#txtBuscar").val();
  $.ajax({
    url: "ajax.php?accion=showMascota",
    method: "POST",
    data:{
  		id_tipo_mascota: id_tipo_mascota,
      id_documento: id_documento,
      valor: valor
		},
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_mascota": o[i].id_mascota,
              "cliente": o[i].cliente,
              "name_tipo": o[i].name_tipo,
              "nombre": o[i].nombre,
              "raza": o[i].raza,
              "color": o[i].color,
              "peso": o[i].peso,
              "fecha_nacimiento": o[i].fecha_nacimiento,
              "estado": o[i].estado,
              "options": o[i].options
            }).draw();
          }
        }else {
          console.log(data1["message"]);
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
        url: "ajax.php?accion=goMascota",
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
              showLista();
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

function getDataEdit(id_mascota){
  $.ajax({
    type: "POST",
    data:{
  		id_mascota: id_mascota
		},
    url: "ajax.php?accion=getDataEditMascota",
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          $("#id_mascota").val(o[0].id_mascota);
          $("#flag_imagen").val("0");
          $("#accion").val("edit");
          $('#img_destino').attr('src', o[0].src_imagen);
          $("#id_documento").val(o[0].id_documento);
          $("#num_documento").val(o[0].num_documento);
          $("#nombres").val(o[0].nombres);
          $("#apellidos").val(o[0].apellidos);
          $("#id_tipo_mascota").val(o[0].id_tipo_mascota);
          $("#nombre_mascota").val(o[0].nombre_mascota);
          $("#raza").val(o[0].raza);
          $("#color").val(o[0].color);
          $("#peso").val(o[0].peso);
          $("#sexo").val(o[0].sexo);
          $("#fecha_nacimiento").val(o[0].fecha_nacimiento);
          $("#observaciones").val(o[0].observaciones);
          var estado = o[0].estado;
          estado=="activo" ? $("#estado").prop('checked', true) : $("#estado").prop('checked', false);
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

function deleteRegistro(id_mascota,mascota){

  try {

    var parametros = {
      "id_mascota" : id_mascota
    };

    Swal.fire({
      title: '¿Seguro de eliminar la Mascota : ' + mascota + '?',
      text: "Al realizar la operación se eliminarán todos sus registros de vacunas, atenciones y todo lo correspondiente con esta mascota.",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar ahora!'
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "ajax.php?accion=deleteMascota",
          datatype: "json",
          data: parametros,
          success: function(data){
            try {
              var response = JSON.parse(data);
              if (response['error']=="SI") {
                runAlert("Oh No...!!!",response['message'],"warning");
              }else {
                removeClassDiv();
                showLista();
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
