
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
    { 'data': 'id_opcion' },
    { 'data': 'name_opcion' },
    { 'data': 'flag_agregar' },
    { 'data': 'flag_editar' },
    { 'data': 'flag_eliminar' },
    { 'data': 'flag_anular' },
    { 'data': 'flag_buscar' },
    { 'data': 'flag_ver' },
    { 'data': 'flag_descargar' },
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

  showOptions();

  $("#cboGrupo").change(function(e){
    e.preventDefault();
    showOptions();
  });

  $("#cboModulo").change(function(e){
    e.preventDefault();
    showOptions();
  });

  $("#chkMarcarTodos").change(function() {

    var state = false;
    if(this.checked) {
      state = true;
    }

    try {

      $('#example > tbody  > tr').each(function(){
        $(this).find("td").eq(2).find("input").prop("checked",state);
        $(this).find("td").eq(3).find("input").prop("checked",state);
        $(this).find("td").eq(4).find("input").prop("checked",state);
        $(this).find("td").eq(5).find("input").prop("checked",state);
        $(this).find("td").eq(6).find("input").prop("checked",state);
        $(this).find("td").eq(7).find("input").prop("checked",state);
        $(this).find("td").eq(8).find("input").prop("checked",state);
      });

    } catch (e) {
      console.log(e);
    }

});

});

function showOptions(){
  table.clear().draw();
  var id_grupo = $("#cboGrupo").val();
  var id_modulo = $("#cboModulo").val();
  $.ajax({
    url: "ajax.php?accion=showOpcionesSistema",
    type: "POST",
    data:{
      id_grupo: id_grupo,
      id_modulo: id_modulo
    },
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          var activo = '<label class="container-label"><input type="checkbox" checked="checked"><span class="checkmark"></span></label>';
          var inactivo = '<label class="container-label"><input type="checkbox"><span class="checkmark"></span></label>';
          for (var i = 0; i < o.length; i++) {
            table.row.add({
              "num": o[i].num,
              "id_opcion": o[i].id_opcion,
              "name_opcion": o[i].name_opcion,
              "flag_ver": o[i].flag_ver=="1" ? activo : inactivo,
              "flag_editar": o[i].flag_editar=="1" ? activo : inactivo,
              "flag_anular": o[i].flag_anular=="1" ? activo : inactivo,
              "flag_buscar": o[i].flag_buscar=="1" ? activo : inactivo,
              "flag_agregar": o[i].flag_agregar=="1" ? activo : inactivo,
              "flag_eliminar": o[i].flag_eliminar=="1" ? activo : inactivo,
              "flag_descargar": o[i].flag_descargar=="1" ? activo : inactivo
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
      var id_grupo = $("#cboGrupo").val();
      var datos = [];
      var objeto = {};
      try {
        $('#example > tbody  > tr').each(function(){
          var data = table.row($(this)).data();
          var flag_agregar = $(this).find("td").eq(2).find("input").prop('checked') ? '1' : '0';
          var flag_editar = $(this).find("td").eq(3).find("input").prop('checked') ? '1' : '0';
          var flag_eliminar = $(this).find("td").eq(4).find("input").prop('checked') ? '1' : '0';
          var flag_anular = $(this).find("td").eq(5).find("input").prop('checked') ? '1' : '0';
          var flag_buscar = $(this).find("td").eq(6).find("input").prop('checked') ? '1' : '0';
          var flag_ver = $(this).find("td").eq(7).find("input").prop('checked') ? '1' : '0';
          var flag_descargar = $(this).find("td").eq(8).find("input").prop('checked') ? '1' : '0';
          datos.push({
            "id_opcion" : data["id_opcion"],
            "flag_agregar" : flag_agregar,
            "flag_editar" : flag_editar,
            "flag_eliminar" : flag_eliminar,
            "flag_anular" : flag_anular,
            "flag_buscar" : flag_buscar,
            "flag_ver" : flag_ver,
            "flag_descargar" : flag_descargar
          });
        });
      } catch (e) {
        runAlert("Oh No...!!!",e,"warning");
        return;
      }
      objeto.datos = datos;
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goAccesoGrupo",
        datatype: "json",
        data: {
          id_grupo: id_grupo,
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
