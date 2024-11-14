
var table = $('#example').DataTable({
  language: languageSpanish,
  destroy : true,
  searching : false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_moneda' },
    { 'data': 'name_moneda' },
    { 'data': 'name_user' },
    { 'data': 'fecha' },
    { 'data': 'tipo_cambio' }
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

  $('#fecha_inicio').change(function(){
    showData();
  });

  $('#fecha_fin').change(function(){
    showData();
  });

  $('#btnAdd').click(function(){
    $("#frmDatos")[0].reset();
    addClassDiv();
  });

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  $('#btnCancel').click(function(){
    removeClassDiv();
    $("#frmDatos")[0].reset();
  });

});

function addClassDiv(){
  $("#panelForm").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
  $("#panelOptions2").addClass("d-none");
}

function removeClassDiv(){
  $("#panelForm").addClass("d-none");
  $("#panelTabla").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
  $("#panelOptions2").removeClass("d-none");
  $("#frmDatos")[0].reset();
}

function showData(){
  table.clear().draw();
  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_fin = $("#fecha_fin").val();
  $.ajax({
    url: "ajax.php?accion=showTipoCambio",
    datatype: "json",
    data:{
  		fecha_inicio: fecha_inicio,
  		fecha_fin: fecha_fin
		},
    type: "POST",
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
              "name_user": o[i].name_user,
              "fecha": o[i].fecha,
              "tipo_cambio": o[i].tipo_cambio
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
        url: "ajax.php?accion=goTipoCambio",
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
