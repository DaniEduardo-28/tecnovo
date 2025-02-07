var table = $('#example').DataTable({
    language: languageSpanish,
    destroy: true,
    columns: [
        { 'data': 'num' },
        { 'data': 'id_tipo_gasto' },
        { 'data': 'desc_gasto' },
        { 'data': 'name_tipo'},
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
        editData(data.id_tipo_gasto);
    });
  
    $('#example tbody').on('click', '#btnDelete', function() {
        var data = table.row($(this).parents('tr')).data();
        deleteRegistro(data["id_tipo_gasto"], data["desc_gasto"]);
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
    $("#id_tipo_gasto").val("0");
    $("#accion").val("add");
    $("#desc_gasto").val("");
    $("#id_tipo_servicio").val("");
    $("#estado").prop('checked', false);
}

function showData() {
    $.ajax({
        url: "ajax.php?accion=showTipoGasto",
        type: "POST",
        success: function(data) {
            table.clear().draw();
            try {
                var response = typeof data === "string" ? JSON.parse(data) : data;
                console.log(response);
                if (response.error === "NO") {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(row) {
                            table.row.add(row).draw();
                        });
                    } else {
                        runAlert("Mensaje", "No se encontraron datos.", "warning");
                    }
                } else {
                    runAlert("Mensaje", response.message, "warning");
                }
            } catch (e) {
                runAlert("Error", "Error al procesar los datos: " + e.message, "error");
                console.error("Datos recibidos:", data);
            }
        },
        error: function(jqXHR) {
            runAlert("Error", "Error de petición: " + jqXHR.responseText, "error");
        },
        complete: function() {
            showHideLoader('none');
        }
    });
}

function saveOperation() {
    console.log("Acción:", $("#accion").val());
    console.log("ID Tipo Gasto:", $("#id_tipo_gasto").val());
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
                url: "ajax.php?accion=goTipoGasto",
                data: $("#frmDatos").serialize(),
                success: function(data) {
                    try {
                        var response = typeof data === "string" ? JSON.parse(data) : data;

                        if (response.error === "SI") {
                            runAlert("Error", response.message, "warning");
                        } else {
                            removeClassDiv();
                            showData();
                            runAlert("Éxito", response.message, "success");
                        }
                    } catch (e) {
                        runAlert("Error", "Error al procesar la respuesta: " + e.message, "error");
                    }
                },
                error: function(jqXHR) {
                    runAlert("Error", "Error en la operación: " + jqXHR.responseText, "error");
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
  
function editData(id_tipo_gasto) {
    $.ajax({
        type: "POST",
        data: { id_tipo_gasto: id_tipo_gasto },
        url: "ajax.php?accion=getDataEditTipoGasto",
        success: function(data) {
            try {
                var response = JSON.parse(data);

                if (response.error === "NO") {
                    var o = response.data[0];
                    $("#id_tipo_gasto").val(o.id_tipo_gasto);
                    $("#desc_gasto").val(o.desc_gasto);
                    $("#id_tipo_servicio").val(o.id_tipo_servicio ? o.id_tipo_servicio : ""); 
                    $("#estado").prop('checked', o.estado === "activo");
                    $("#accion").val("edit");
                    addClassDiv();
                } else {
                    runAlert("Mensaje", response.message, "warning");
                }
            } catch (e) {
                runAlert("Error", "Error al cargar los datos: " + e.message, "error");
            }
        },
        beforeSend: function() {
            showHideLoader('block');
        },
        error: function(jqXHR) {
            runAlert("Error", "Error al obtener los datos: " + jqXHR.responseText, "error");
        },
        complete: function() {
            showHideLoader('none');
        }
    });
}
  

function deleteRegistro(id_tipo_gasto, desc_gasto) {
    Swal.fire({
        title: '¿Seguro de eliminar ' + desc_gasto + '?',
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
                url: "ajax.php?accion=deleteTipoGasto",
                data: { id_tipo_gasto: id_tipo_gasto },
                success: function(data) {
                    try {
                        var response = JSON.parse(data);

                        if (response.error === "SI") {
                            runAlert("Error", response.message, "warning");
                        } else {
                            showData();
                            runAlert("Éxito", response.message, "success");
                        }
                    } catch (e) {
                        runAlert("Error", "Error al procesar la respuesta: " + e.message, "error");
                    }
                },
                error: function(jqXHR) {
                    runAlert("Error", "Error al eliminar: " + jqXHR.responseText, "error");
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
  
  
  