
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

$(document).ready(function(){

  showLista();

  $('#cboTipoBuscar').change(function(){
    showLista();
  });

  $('#btnSearch').click(function(){
    showLista();
  });

});

function showLista(){
  table.clear().draw();
  var id_tipo_mascota = $("#cboTipoBuscar").val();
  var id_documento = $("#cboDocumentoBuscar").val();
  var valor = $("#txtBuscar").val();
  $.ajax({
    url: "ajax.php?accion=showHistorialClinico",
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
