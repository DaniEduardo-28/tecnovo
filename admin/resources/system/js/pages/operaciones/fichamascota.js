
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
      "targets": [1,3],
      "visible": false,
      "searchable": false
    }
  ]
});

var table1 = $('#example1').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  ordering : false,
  paging : false,
  columns: [
    { 'data': 'options' },
    { 'data': 'num' },
    { 'data': 'id_mascota_vacuna' },
    { 'data': 'id_vacuna' },
    { 'data': 'name_vacuna' },
    { 'data': 'fecha_minima' },
    { 'data': 'fecha_maxima' },
    { 'data': 'observaciones' },
    { 'data': 'flag_vacuna' },
    { 'data': 'name_sucursal' },
    { 'data': 'name_user' },
    { 'data': 'fecha_aplicacion' }
  ],
  columnDefs: [
    {
      "targets": [2,3],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function(){

  $("#HTMLtoPDF").addClass("d-none");

  showLista();

  $('#cboTipoBuscar').change(function(){
    showLista();
  });

  $('#btnSearch').click(function(){
    showLista();
  });

  $('#btnImprimir').click(function(){
    var id_mascota = $('#id_mascota').val();
    var url = '?view=fichamascotaprint&id_mascota=' + id_mascota;
    window.open(url, "Ficha de Mascota");
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_mascota").val("0");
    $("#accion").val("add");
    $("#id_tipo_mascota").val("");
    $("#nombre_mascota").val("");
    $("#raza").val("");
    $("#color").val("");
    $("#peso").val("");
    $("#sexo").val("");
    $("#observaciones").val("");
    $("#estado").prop('checked', false);
  });

  $('#example1 tbody').on( 'click', '#btnVacunar', function () {

    try {

      var data = table1.row($(this).parents('tr')).data();
      var id_mascota_vacuna = data["id_mascota_vacuna"];
      var name_vacuna = data["name_vacuna"];
      var observaciones = $(this).parents('tr').find('input').val();

      var parametros = {
        "id_mascota_vacuna" : id_mascota_vacuna,
        "observaciones" : observaciones
      };

      Swal.fire({
        title: '¿Seguro de registrar esta vacuna : ' + name_vacuna + '?',
        text: "Al realizar la operación, no podrá deshacer los cambios realizados.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Registrar ahora!'
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=registrarVacuna",
            datatype: "json",
            data: parametros,
            success: function(data){
              try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  runAlert("Oh No...!!!",response['message'],"warning");
                }else {
                  showDetalle();
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

  });

});

function addClassDiv(){
  $("#HTMLtoPDF").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
}

function removeClassDiv(){
  $("#HTMLtoPDF").addClass("d-none");
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
    url: "ajax.php?accion=showMascotaFicha",
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
    title: '¿Seguro de registrar la vacuna?',
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
        url: "ajax.php?accion=goRegistrarVacuna",
        contentType: false,
        processData: false,
        data: formdata,
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              showDetalle();
              $('#modalRegistrarVacuna').modal('hide');
              $('#frmDatos')[0].reset();
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
          $("#id_mascota_edit").val(o[0].id_mascota);
          $("#flag_imagen").val("0");
          $('#img_destino').attr('src', o[0].src_imagen);
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
      showDetalle();
      cargarTiposMascotas();
    }
  });
}

function cargarTiposMascotas(){
  $('#id_vacuna_edit').empty();
  var id_tipo_mascota = $("#id_tipo_mascota").val();
  $.ajax({
    url: "ajax.php?accion=showVacuna",
    type: "POST",
    data:{
      id_tipo_mascota: id_tipo_mascota
    },
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            $('#id_vacuna_edit').append('<option value="' + o[i].id_vacuna + '">' + o[i].name_vacuna + '</option>');
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

function showDetalle(){
  table1.clear().draw();
  var id_mascota = $("#id_mascota").val();
  $.ajax({
    url: "ajax.php?accion=showDetalleVacunas",
    method: "POST",
    data:{
  		id_mascota: id_mascota
		},
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table1.row.add({
              "num": o[i].num,
              "id_mascota_vacuna": o[i].id_mascota_vacuna,
              "id_vacuna": o[i].id_vacuna,
              "name_vacuna": o[i].name_vacuna,
              "fecha_minima": o[i].fecha_minima,
              "fecha_maxima": o[i].fecha_maxima,
              "observaciones": o[i].observaciones,
              "name_sucursal": o[i].name_sucursal,
              "name_user": o[i].name_user,
              "fecha_aplicacion": o[i].fecha_aplicacion,
              "flag_vacuna": o[i].flag_vacuna,
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
