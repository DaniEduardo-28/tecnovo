
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_moneda' },
    { 'data': 'name_moneda' },
    { 'data': 'cod_sunat' },
    { 'data': 'signo' },
    { 'data': 'abreviatura' },
    { 'data': 'tipo_cambio' },
    { 'data': 'estado' },
    { 'data': 'flag_principal' },
    { 'data': 'options' }
  ],
  columnDefs: [
    {
      "targets": [1,6],
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
    $("#id_moneda").val("0");
    $("#accion").val("add");
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#id_moneda").val("0");
    $("#accion").val("add");
    $("#frmDatos")[0].reset();
    $("#estado").prop('checked', false);
  });

  $('#example tbody').on( 'click', '#btnEdit', function () {
    try {
      var data = table.row( $(this).parents('tr') ).data();
      $("#id_moneda").val(data["id_moneda"]);
      $("#accion").val("edit");
      $("#name_moneda").val(data["name_moneda"]);
      $("#cod_sunat").val(data["cod_sunat"]);
      $("#signo").val(data["signo"]);
      $("#abreviatura").val(data["abreviatura"]);
      $("#tipo_cambio").val(data["tipo_cambio"]);
      if ('<label class="badge badge-success">Activo</label>'==data["estado"]) {
        $("#estado").prop('checked', true);
      }else {
        $("#estado").prop('checked', false);
      }
      if ('SI'==data["flag_principal"]) {
        $("#flag_principal").prop('checked', true);
      }else {
        $("#flag_principal").prop('checked', false);
      }
      addClassDiv();
    } catch (e) {
      runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
    }
  });

  $('#example tbody').on( 'click', '#btnDelete', function () {
    try {

      var data = table.row( $(this).parents('tr') ).data();
      var id_moneda = data["id_moneda"];
      var name_moneda = data["name_moneda"];
      var parametros = {
        "id_moneda" : id_moneda
      };

      Swal.fire({
        title: '¿Seguro de eliminar moneda : ' + name_moneda + '?',
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
            url: "ajax.php?accion=deleteMoneda",
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

function showData(){
  $.ajax({
    url: "ajax.php?accion=showMoneda",
    success : function(data) {
      table.clear().draw();
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_moneda": o[i].id_moneda,
              "name_moneda": o[i].name_moneda,
              "cod_sunat": o[i].cod_sunat,
              "signo": o[i].signo,
              "abreviatura": o[i].abreviatura,
              "tipo_cambio": o[i].tipo_cambio,
              "estado": o[i].estado,
              "flag_principal": o[i].flag_principal,
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
        url: "ajax.php?accion=goMoneda",
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
