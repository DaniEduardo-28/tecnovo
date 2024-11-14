
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_unidad_medida' },
    { 'data': 'name_unidad' },
    { 'data': 'cod_sunat' },
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

$(document).ready(function(){

  $("#panelForm").addClass("d-none");
  showData();
  $('#btnSearch').click(function(){
    showData();
  });

  $('#btnAdd').click(function(){
    $("#id_unidad_medida").val("0");
    $("#accion").val("add");
    $("#frmDatos")[0].reset();
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_unidad_medida").val("0");
    $("#accion").val("add");
    $("#frmDatos")[0].reset();
  });

  $('#example tbody').on( 'click', '#btnEdit', function () {
    try {
      var data = table.row( $(this).parents('tr') ).data();
      $("#id_unidad_medida").val(data["id_unidad_medida"]);
      $("#accion").val("edit");
      $("#name_unidad").val(data["name_unidad"]);
      $("#cod_sunat").val(data["cod_sunat"]);
      if ('<label class="badge badge-success">Activo</label>'==data["estado"]) {
        $("#estado").prop('checked', true);
      }else {
        $("#estado").prop('checked', false);
      }
      addClassDiv();
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  $('#example tbody').on( 'click', '#btnDelete', function () {
    try {

      var data = table.row( $(this).parents('tr') ).data();
      var id_unidad_medida = data["id_unidad_medida"];
      var name_unidad = data["name_unidad"];
      var parametros = {
        "id_unidad_medida" : id_unidad_medida
      };

      Swal.fire({
        title: '¿Seguro de eliminar la unidad de medida : ' + name_unidad + '?',
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
            url: "ajax.php?accion=deleteUnidadMedida",
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
  $("#frmDatos")[0].reset();
}

function showData(){
  $.ajax({
    url: "ajax.php?accion=showUnidadMedida",
    success : function(data) {
      table.clear().draw();
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_unidad_medida": o[i].id_unidad_medida,
              "name_unidad": o[i].name_unidad,
              "cod_sunat": o[i].cod_sunat,
              "estado": o[i].estado,
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
        url: "ajax.php?accion=goUnidadMedida",
        datatype: "json",
        data: $("#frmDatos").serialize(),
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
            runAlert("Oh No...!!!",e+data,"error");
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
