
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_vacuna' },
    { 'data': 'id_tipo_mascota' },
    { 'data': 'name_tipo' },
    { 'data': 'name_vacuna' },
    { 'data': 'descripcion' },
    { 'data': 'edad_minima' },
    { 'data': 'edad_maxima' },
    { 'data': 'estado' },
    { 'data': 'tipo_vacuna' },
    { 'data': 'options' }
  ],
  columnDefs: [
    {
      "targets": [1,2,9],
      "visible": false,
      "searchable": false
    }
  ]
});

$(document).ready(function(){

  $("#panelForm").addClass("d-none");

  showLista();

  $('#cboTipoBuscar').change(function(){
    showLista();
  });

  $('#btnSearch').click(function(){
    showLista();
  });

  $('#btnAdd').click(function(){
    $("#id_vacuna").val("0");
    $("#accion").val("add");
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_vacuna").val("0");
    $("#accion").val("add");
    $("#name_vacuna").val("");
    $("#descripcion").val("");
    $("#edad_maxima").val("1");
    $("#edad_minima").val("1");
    $("#id_tipo_mascota").val("");
    $("#estado").prop('checked', false);
  });

  $('#example tbody').on( 'click', '#btnEdit', function () {
    try {
      var data = table.row( $(this).parents('tr') ).data();
      $("#id_vacuna").val(data["id_vacuna"]);
      $("#id_tipo_mascota").val(data["id_tipo_mascota"]);
      $("#name_vacuna").val(data["name_vacuna"]);
      $("#descripcion").val(data["descripcion"]);
      $("#edad_maxima").val(data["edad_maxima"]);
      $("#edad_minima").val(data["edad_minima"]);
      if ('<label class="badge badge-success">Activo</label>'==data["estado"]) {
        $("#estado").prop('checked', true);
      }else {
        $("#estado").prop('checked', false);
      }
      if ('1'==data["tipo_vacuna"]) {
        $("#tipo_vacuna").prop('checked', true);
      }else {
        $("#tipo_vacuna").prop('checked', false);
      }
      $("#accion").val("edit");
      addClassDiv();
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  $('#example tbody').on( 'click', '#btnDelete', function () {
    try {

      var data = table.row( $(this).parents('tr') ).data();
      var id_vacuna = data["id_vacuna"];
      var name_vacuna = data["name_vacuna"];
      var parametros = {
        "id_vacuna" : id_vacuna
      };

      Swal.fire({
        title: '¿Seguro de eliminar la vacuna : ' + name_vacuna + '?',
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
            url: "ajax.php?accion=deleteVacuna",
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
  var id_tipo_mascota = $("#cboTipoBuscar").val();
  $.ajax({
    url: "ajax.php?accion=showVacuna",
    method: "POST",
    data:{
  		id_tipo_mascota: id_tipo_mascota
		},
    success : function(data) {
      table.clear().draw();
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_vacuna": o[i].id_vacuna,
              "id_tipo_mascota": o[i].id_tipo_mascota,
              "name_vacuna": o[i].name_vacuna,
              "descripcion": o[i].descripcion,
              "name_tipo": o[i].name_tipo,
              "edad_maxima": o[i].edad_maxima,
              "edad_minima": o[i].edad_minima,
              "estado": o[i].estado,
              "tipo_vacuna": o[i].tipo_vacuna,
              "options": o[i].options
            }).draw();
          }
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
      table.clear().draw();
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
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goVacuna",
        datatype: "json",
        data: $("#frmDatos").serialize(),
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
            runAlert("Oh No...!!!",e + ' | data ' + data,"error");
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
