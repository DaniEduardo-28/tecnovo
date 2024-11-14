
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_especialidad' },
    { 'data': 'name_especialidad' },
    { 'data': 'estado' },
    { 'data': 'options' }
  ],
  columnDefs: [
    {
      "targets": [1],
      "visible": false,
      "searchable": true
    }
  ]
});

$(document).ready(function(){

  $("#panelForm").addClass("d-none");
  showPositionWorker();
  $('#btnSearch').click(function(){
    showPositionWorker();
  });

  $('#btnAdd').click(function(){
    $("#id_especialidad").val("0");
    $("#accion").val("add");
    $("#name_especialidad").val("");
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_especialidad").val("0");
    $("#accion").val("add");
    $("#name_especialidad").val("");
    $("#estado").prop('checked', false);
  });

  $('#example tbody').on( 'click', '#btnEdit', function () {
    try {
      var data = table.row( $(this).parents('tr') ).data();
      $("#id_especialidad").val(data["id_especialidad"]);
      $("#accion").val("edit");
      $("#name_especialidad").val(data["name_especialidad"]);
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
      var id_especialidad = data["id_especialidad"];
      var name_especialidad = data["name_especialidad"];
      var parametros = {
        "id_especialidad" : id_especialidad
      };

      Swal.fire({
        title: '¿Seguro de eliminar la especialidad : ' + name_especialidad + '?',
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
            url: "ajax.php?accion=deleteEspecialidad",
            datatype: "json",
            data: parametros,
            success: function(data){
        			try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  runAlert("Oh No...!!!",response['message'],"warning");
                }else {
                  removeClassDiv();
                  showPositionWorker();
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
  $("#name_cargo").val("");
}

function showPositionWorker(){
  $.ajax({
    url: "ajax.php?accion=showEspecialidad",
    success : function(data) {
      table.clear().draw();
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_especialidad": o[i].id_especialidad,
              "name_especialidad": o[i].name_especialidad,
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
        url: "ajax.php?accion=goEspecialidad",
        datatype: "json",
        data: $("#frmDatos").serialize(),
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              removeClassDiv();
              showPositionWorker();
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
}
