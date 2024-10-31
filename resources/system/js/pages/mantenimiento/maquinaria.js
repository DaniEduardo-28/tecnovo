var table = $('#example').DataTable({
  language: languageSpanish,
  destroy: true,
  columns: [
      { 'data': 'num' },
      { 'data': 'id_maquinaria' },
      { 'data': 'descripcion' },
      { 'data': 'observaciones' },
      { 'data': 'nombre_operador' },
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

$(document).ready(function() {
  $("#panelForm").addClass("d-none");
  showData();

  $('#btnSearch').click(function() {
      showData();
  });

  $('#btnAdd').click(function() {
      resetForm();
      $("#accion").val("add");
      addClassDiv();
  });

  $('#btnSave').click(function(e) {
      e.preventDefault();
      saveOperation();
  });

  $('#btnCancel').click(function() {
      removeClassDiv();
      resetForm();
  });

  $('#example tbody').on('click', '#btnEdit', function() {
      var data = table.row($(this).parents('tr')).data();
      editData(data);
  });

  $('#example tbody').on('click', '#btnDelete', function() {
      var data = table.row($(this).parents('tr')).data();
      deleteRegistro(data["id_maquinaria"], data["descripcion"]);
  });
});

function addClassDiv() {
  $("#panelForm").removeClass("d-none");
  $("#panelTabla").addClass("d-none");
  $("#panelOptions").addClass("d-none");
}

function removeClassDiv() {
  $("#panelForm").addClass("d-none");
  $("#panelTabla").removeClass("d-none");
  $("#panelOptions").removeClass("d-none");
}

function resetForm() {
  $("#id_maquinaria").val("0");
  $("#accion").val("add");
  $("#descripcion").val("");
  $("#observaciones").val("");
  $("#id_operador").val("");
  $("#estado").prop('checked', false);
}

function showData() {
  $.ajax({
      url: "ajax.php?accion=showMaquinaria",
      type: "POST",
      success: function(data) {
          table.clear().draw();
          try {
              var data1 = JSON.parse(data);
              if (data1["error"] == "NO") {
                  var o = data1["data"];
                  o.forEach(function(row) {
                      table.row.add(row).draw();
                  });
              } else {
                  runAlert("Mensaje", data1["message"], "warning");
              }
          } catch (e) {
              runAlert("Oh No...!!!", "Error en TryCatch: " + e + data, "error");
          }
      },
      beforeSend: function() {
          showHideLoader('block');
      },
      error: function(jqXHR) {
          runAlert("Oh No...!!!", "Error de petición: " + jqXHR, "warning");
      },
      complete: function() {
          showHideLoader('none');
      }
  });
}

function saveOperation() {
  console.log("Acción:", $("#accion").val());
  console.log("ID Maquinaria:", $("#id_maquinaria").val());
  Swal.fire({
      title: '¿Seguro de confirmar la operación?',
      text: "No podrás revertir esta operación.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, Realizar ahora!'
  }).then(function(result) {
      if (result.value) {
          $.ajax({
              type: "POST",
              url: "ajax.php?accion=goMaquinaria",
              data: $("#frmDatos").serialize(),
              success: function(data) {
                  try {
                      var response = JSON.parse(data);
                      if (response['error'] == "SI") {
                          runAlert("Oh No...!!!", response['message'], "warning");
                      } else {
                          removeClassDiv();
                          showData(); // Recargar la lista tras agregar/editar
                          runAlert("Bien hecho...!!!", response['message'], "success");
                      }
                  } catch (e) {
                      runAlert("Oh No...!!!", e, "error");
                  }
              },
              error: function(data) {
                  runAlert("Oh No...!!!", data, "error");
              },
              beforeSend: function() {
                  showHideLoader('block');
              },
              complete: function() {
                  showHideLoader('none');
              }
          });
      }
  });
}

function editData(id_maquinaria) {
  $.ajax({
      type: "POST",
      data: { id_maquinaria: id_maquinaria },
      url: "ajax.php?accion=getDataEditMaquinaria",
      success: function(data) {
          try {
              var data1 = JSON.parse(data);
              if (data1["error"] == "NO") {
                  var o = data1["data"][0];
                  $("#id_maquinaria").val(o.id_maquinaria);
                  $("#descripcion").val(o.descripcion);
                  $("#observaciones").val(o.observaciones);
                  $("#id_operador").val(o.id_operador);
                  $("#estado").prop('checked', o.estado === "activo");
                  $("#accion").val("edit");
                  addClassDiv();
              } else {
                  runAlert("Mensaje", data1["message"], "warning");
              }
          } catch (e) {
              runAlert("Oh No...!!!", "Error en TryCatch: " + e, "error");
          }
      },
      beforeSend: function() {
          showHideLoader('block');
      },
      error: function(jqXHR) {
          runAlert("Oh No...!!!", "Error de petición: " + jqXHR, "warning");
      },
      complete: function() {
          showHideLoader('none');
      }
  });
}


function deleteRegistro(id_maquinaria, descripcion) {
  Swal.fire({
      title: '¿Seguro de eliminar ' + descripcion + '?',
      text: "No podrás revertir esta operación.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#22c63b',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, Eliminar ahora!'
  }).then(function(result) {
      if (result.value) {
          $.ajax({
              type: "POST",
              url: "ajax.php?accion=deleteMaquinaria",
              data: { id_maquinaria: id_maquinaria },
              success: function(data) {
                  try {
                      var response = JSON.parse(data);
                      if (response['error'] == "SI") {
                          runAlert("Oh No...!!!", response['message'], "warning");
                      } else {
                          showData(); // Recargar la lista tras la eliminación
                          runAlert("Bien hecho...!!!", response['message'], "success");
                      }
                  } catch (e) {
                      runAlert("Oh No...!!!", e, "error");
                  }
              },
              error: function(data) {
                  runAlert("Oh No...!!!", data, "error");
              },
              beforeSend: function() {
                  showHideLoader('block');
              },
              complete: function() {
                  showHideLoader('none');
              }
          });
      }
  });
}


