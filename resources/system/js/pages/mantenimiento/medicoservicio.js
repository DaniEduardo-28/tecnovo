
var table = $('#example').DataTable({
  language: languageSpanish,
  searching: false,
  ordering: false,
  lengthChange: false,
  paging: false,
  destroy : true,
  info: false,
  columns: [
    { 'data': 'num' },
    { 'data': 'id_servicio' },
    { 'data': 'name_tipo' },
    { 'data': 'name_servicio' },
    { 'data': 'flag_check' },
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

  $('#btnSave').click(function(e){
    e.preventDefault();
    saveOperation();
  });

  showPermisos();

  $("#cboTrabajador").change(function(e){
    e.preventDefault();
    showPermisos();
  });

  $("#chkMarcarTodos").change(function() {

    var state = false;
    if(this.checked) {
      state = true;
    }
    try {
      $('#example > tbody  > tr').each(function(){
        $(this).find("td").eq(3).find("input").prop("checked",state);
      });
    } catch (e) {
      console.log(e);
    }
  });

});

function eliminar_checks(){
  try {
    $('#example > tbody  > tr').each(function(){
      $(this).find("td").eq(3).find("input").prop("checked",false);
    });
  } catch (e) {
    console.log(e);
  }
}

function showPermisos(){

  eliminar_checks();
  var id_trabajador = $("#cboTrabajador").val();
  $.ajax({
    url: "ajax.php?accion=showServicioMedico",
    type: "POST",
    data:{
      id_trabajador: id_trabajador
    },
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          var count = table.data().count();
          if (count>0) {
            var num = 1;
            $('#example > tbody  > tr').each(function(){
              var data = table.row($(this)).data();
              var id_servicio = data['id_servicio'];
              for (var i = 0; i < o.length; i++) {
                if (id_servicio == o[i].id_servicio) {
                  table.cell(num-1,4).data(o[i].opcion).draw();
                }
              }
              num++;
            });
          }
          console.log(o);
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

  if (!table.data().count()) {
    runAlert("Oh No...!!!","La tabla no contiene datos para registrar.","warning");
    return;
  }

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
      var id_trabajador = $("#cboTrabajador").val();
      var datos = [];
      var objeto = {};
      try {
        $('#example > tbody  > tr').each(function(){
          var data = table.row($(this)).data();
          var flag_agregar = $(this).find("td").eq(3).find("input").prop('checked') ? true : false;
          if (flag_agregar) {
            datos.push({
              "id_servicio" : data["id_servicio"],
            });
          }
        });
      } catch (e) {
        runAlert("Oh No...!!!",e,"warning");
        return;
      }

      objeto.datos = datos;
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goMedicoServicio",
        datatype: "json",
        data: {
          id_trabajador: id_trabajador,
          datos: JSON.stringify(objeto)
        },
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
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
