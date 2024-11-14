
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_documento' },
    { 'data': 'name_documento' },
    { 'data': 'codigo_sunat' },
    { 'data': 'size' },
    { 'data': 'flag_exacto' },
    { 'data': 'flag_numerico' },
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
  showIdentityDocuments();
  $('#btnSearch').click(function(){
    showIdentityDocuments();
  });

  $('#btnAdd').click(function(){
    $("#id_documento").val("0");
    $("#accion").val("add");
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_documento").val("0");
    $("#accion").val("add");
    $("#name_documento").val("");
    $("#size").val("8");
    $("#estado").prop('checked', false);
  });

  $('#example tbody').on( 'click', '#btnEdit', function () {
    try {
      var data = table.row( $(this).parents('tr') ).data();
      $("#id_documento").val(data["id_documento"]);
      $("#accion").val("edit");
      $("#name_documento").val(data["name_documento"]);
      $("#codigo_sunat").val(data["codigo_sunat"]);
      $("#size").val(data["size"]);
      if ('<label class="badge badge-success">Activo</label>'==data["estado"]) {
        $("#estado").prop('checked', true);
      }else {
        $("#estado").prop('checked', false);
      }
      if ('SOLO NUMEROS'==data["flag_numerico"]) {
        $("#rdbNumero").prop('checked', true);
      }else {
        $("#rdbNumeroLetra").prop('checked', true);
      }
      if ('SI'==data["flag_exacto"]) {
        $("#rdbSi").prop('checked', true);
      }else {
        $("#rdbNo").prop('checked', true);
      }
      addClassDiv();
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  $('#example tbody').on( 'click', '#btnDelete', function () {
    try {

      var data = table.row( $(this).parents('tr') ).data();
      var id_documento = data["id_documento"];
      var name_documento = data["name_documento"];
      var parametros = {
        "id_documento" : id_documento
      };

      Swal.fire({
        title: '¿Seguro de eliminar el documento : ' + name_documento + '?',
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
            url: "ajax.php?accion=deleteIdentityDocument",
            datatype: "json",
            data: parametros,
            success: function(data){
        			try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  runAlert("Oh No...!!!",response['message'],"warning");
                }else {
                  removeClassDiv();
                  showIdentityDocuments();
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

function showIdentityDocuments(){
  $.ajax({
    url: "ajax.php?accion=showIdentityDocument",
    success : function(data) {
      table.clear().draw();
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_documento": o[i].id_documento,
              "name_documento": o[i].name_documento,
              "codigo_sunat": o[i].codigo_sunat,
              "size": o[i].size,
              "flag_exacto": o[i].flag_exacto,
              "flag_numerico": o[i].flag_numerico,
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
        url: "ajax.php?accion=goIdentityDocument",
        datatype: "json",
        data: $("#frmDatos").serialize(),
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              removeClassDiv();
              showIdentityDocuments();
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
