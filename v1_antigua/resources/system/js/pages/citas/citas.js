$(document).ready(function(){

    crearCalendario();

    cargarServicios();

    $("#id_documento").change(function () {
      changeOption();
    });

    $("#num_documento").on("keypress", function (event) {
      if (event.which == 13) {
        validarYEnviar();
      }
    });
  
    $("#num_documento").on("blur", function () {
      validarYEnviar();
    });

    $('#cboMedicoBuscar').change(function(){
      crearCalendario();
    });

    // $('#id_trabajador').change(function(){
    //   cargarServicios();
    // });

    $('#cboDocumentoBuscar').change(function(){
      crearCalendario();
    });

    $('#cboFundoBuscar').change(function(){
      crearCalendario();
    });

    $('#btnSearch').click(function(){
      crearCalendario();
    });

    $('#btnBuscarMascotas').click(function(){
      cargarMascotas();
    });

    $('#btnCancelarCita').click(function(){

        try {

          var id_cita = $("#id_cita").val();
          var parametros = {
            "id_cita" : id_cita,
            "estado" : "cancelada"
          };

          Swal.fire({
            title: '¿Seguro de Cancelar la cita del día : ' + $("#fecha_inicio").val() + '?',
            text: "No podrás revertir esta operación.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c63b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Cancelar ahora!'
          }).then(function(result) {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: "ajax.php?accion=actualizarEstadoCita",
                datatype: "json",
                data: parametros,
                success: function(data){
            			try {
                    var response = JSON.parse(data);
                    if (response['error']=="SI") {
                      runAlert("Oh No...!!!",response['message'],"warning");
                    }else {
                      crearCalendario();
                      runAlert("Bien hecho...!!!","La cita fue cancelada correctamente.","success");
                      $('#frmDatos')[0].reset();
                      $('#modal-calendario-show').modal('hide');
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
        } catch (e){
          runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
        }

    });

    $('#btnAceptarCita').click(function(){

        try {

          var id_cita = $("#id_cita").val();
          var parametros = {
            "id_cita" : id_cita,
            "estado" : "aceptada"
          };

          Swal.fire({
            title: '¿Seguro de Aceptar la cita para el día : ' + $("#fecha_inicio").val() + '?',
            text: "No podrás revertir esta operación.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c63b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Aceptar ahora!'
          }).then(function(result) {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: "ajax.php?accion=actualizarEstadoCita",
                datatype: "json",
                data: parametros,
                success: function(data){
            			try {
                    var response = JSON.parse(data);
                    if (response['error']=="SI") {
                      runAlert("Oh No...!!!",response['message'],"warning");
                    }else {
                      crearCalendario();
                      runAlert("Bien hecho...!!!","La cita fue aceptada correctamente.","success");
                      $('#frmDatos')[0].reset();
                      $('#modal-calendario-show').modal('hide');
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
        } catch (e){
          runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
        }

    });

    $('#btnAnularCita').click(function(){

        try {

          var id_cita = $("#id_cita").val();
          var parametros = {
            "id_cita" : id_cita,
            "estado" : "anulada"
          };

          Swal.fire({
            title: '¿Seguro de anular la cita del día : ' + $("#fecha_inicio").val() + '?',
            text: "No podrás revertir esta operación.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c63b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Anular ahora!'
          }).then(function(result) {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: "ajax.php?accion=actualizarEstadoCita",
                datatype: "json",
                data: parametros,
                success: function(data){
            			try {
                    var response = JSON.parse(data);
                    if (response['error']=="SI") {
                      runAlert("Oh No...!!!",response['message'],"warning");
                    }else {
                      crearCalendario();
                      runAlert("Bien hecho...!!!","La cita fue anulada correctamente.","success");
                      $('#frmDatos')[0].reset();
                      $('#modal-calendario-show').modal('hide');
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
        } catch (e){
          runAlert("Oh No...!!!","Error en TryCatch: " + e,"error");
        }

    });

    $('#frmDatos').submit(function(e){
      e.preventDefault();
      registrarCita(); // Ahora esta función debería ejecutarse al enviar el formulario
    });
    

});

function validarYEnviar() {
  var number_document = $("#num_documento").val();
  var id_document = $("#id_documento").val();

  // Validar que tenga 8 o 11 dígitos
  if (number_document.length == 8 || number_document.length == 11) {
      // Verificar si el tipo de documento es válido
      console.log("paso 1");
      if (id_document != 1 && id_document != 3) {
        console.log("paso 2");
          return false;
      }
      // Determinar el tipo de documento: DNI o RUC
      var tipo = id_document == 1 ? 'dni' : 'ruc';
      
      $.ajax({
        url: "ajax.php?accion=buscar-" + tipo, // Cambia por la ruta correcta
        method: "POST",
        dataType: "json", // Especifica que la respuesta será JSON
        data: { dni: number_document, ruc: number_document },
        success: function(response) {
          console.log(response);
            if (response.success) {
                let nombres = id_document == 1 ? response.data.nombres : response.data.nombre_o_razon_social;
                let apellidos = id_document == 1 ? response.data.apellido_paterno + " " + response.data.apellido_materno : '';
                let direccion = id_document == 3 ? response.data.direccion_completa : '';

                // Mostrar los datos en los campos correspondientes
                $("#nombres").val(nombres);
                $("#apellidos").val(apellidos);
                $("#direccion").val(direccion);
            } else {
                console.log("Error en la API: " + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error en la solicitud AJAX: " + error);
        },
    });
  } else {
      alert("El número de documento debe tener 8 o 11 dígitos.");
  }
}

function changeOption() {
  var name_documento = $('select[name="id_documento"] option:selected').text();
  if (name_documento.toUpperCase().trim() == "RUC") {
    $("#lblNombres").html("Razón Social");
    $("#lblApellidos").html("Nombre Comercial");
  } else {
    $("#lblNombres").html("Nombres");
    $("#lblApellidos").html("Apellidos");
  }
}

function crearCalendario(){

  $('#calendario').fullCalendar('destroy');
  var id_medico = $('#cboMedicoBuscar').val();
  var id_documento = $('#cboDocumentoBuscar').val();
  var id_fundo = $('#cboFundoBuscar').val();
  var valor = $('#txtBuscar').val();
  var calendario = $('#calendario').fullCalendar({  // assign calendar
    defaultView: 'month',
    editable: true,
    selectable: true,
    allDaySlot: false,
    locale: 'es', // Idioma
    //titleFormat: '[Horario Carrera, Semestre y Sección]', //Título
    weekends: false, // Oculta fin de semana
    displayEventTime: true,
    displayEventEnd: true,
    columnHeader: true,
    columnHeaderText: function(mom) {
      switch (mom.weekday()) {
        case 0:
          return 'Lunes';
          break;
        case 1:
          return 'Martes';
          break;
        case 2:
          return 'Miércoles';
          break;
        case 3:
          return 'Jueves';
          break;
        case 4:
          return 'Viernes';
          break;
        case 5:
          return 'Sábado';
          break;
        case 6:
          return 'Domingo';
          break;
        default:
          return 'Lunes XD';
      }
    },
    slotLabelFormat: 'hh:mm',
    slotLabelInterval: '01:00:00',
    selectHelper: true,
    selectOverlap: true,
    eventOverlap: true,
    droppable: true,

    eventSources: [

      // your event source
      {
        url: 'ajax.php?accion=showCitas',
        type: 'POST',
        data: {
          id_medico: id_medico,
          id_documento: id_documento,
          id_fundo: id_fundo,
          valor: valor
        },
        error: function(e) {
          console.log(e);
          runAlert('there was an error while fetching events!');
        },
        color: 'yellow',   // a non-ajax option
        textColor: 'black' // a non-ajax option
      }

      // any other sources...

    ],
    eventRender: function(event, element) {
      element.find('.fc-title').append("<br/>" + event.description);
    },
    loading: function( isLoading, view ) {
      if(isLoading) {
        showHideLoader('block');
      } else {
        showHideLoader('none');
      }
    }

  });
  date = new Date();
  $('#calendario').fullCalendar('gotoDate', date);

  var calendarioEvent = $('#calendario').fullCalendar('getCalendar');
  calendarioEvent.on('select', function(start, end, jsEvent, view) {

    // Convertir las fechas de inicio y fin a objetos Date
var fecha_inicio_Obj = new Date(start);
var momentObj_1 = moment(fecha_inicio_Obj);
var fecha_inicio = momentObj_1.format('YYYY-MM-DD');

var fecha_fin_Obj = new Date(end);
var momentObj_2 = moment(fecha_fin_Obj);
var fecha_fin = momentObj_2.format('YYYY-MM-DD');

// Obtener horas de inicio y fin
var hora_inicio = momentObj_1.format('HH:mm');
var hora_fin = momentObj_2.format('HH:mm');

// Obtener la fecha y hora actual
var fecha_actual = new Date();
var fecha_compara = new Date(fecha_inicio + ' ' + hora_inicio);

// Para incluir la fecha de hoy, se ajusta la fecha_compara a medianoche
var fecha_hoy = new Date();
fecha_hoy.setHours(0, 0, 0, 0); // Establecer la hora a las 00:00:00 para comparar solo la fecha

// Comparar si la fecha de comparación es menor que la fecha de hoy
if (fecha_compara.getTime() < fecha_hoy.getTime()) {
    new PNotify({
        title: 'Advertencia',
        text: 'No puedes separar una cita con fecha pasada.',
        type: 'warning',
        styling: 'bootstrap3',
        addclass: ''
    });
    return;
} 

    $('#txtFechaInicio').val(fecha_inicio);
    $('#txtFechaTermino').val(fecha_fin);
    $('#txtHoraInicio').val(hora_inicio);
    $('#txtHoraFin').val(hora_fin);
    $('#modal-calendario').modal('show');

  });
  calendarioEvent.on('eventClick', function(event, jsEvent, view){

    $('#id_cita').val(event.id);
    $('#name_mascota').val(event.id_mascota);
    $('#name_servicio').val(event.id_servicio);
    $('#fecha_inicio').val(event.fecha_inicio);
    $('#fecha_fin').val(event.fecha_fin);
    $('#sintomas').val(event.sintoma);
    $('#num_documento_show').val(event.num_documento);
    $('#name_documento').val(event.name_documento);
    $('#name_medico').val(event.name_medico);

    $('#btnAceptarCita').addClass("d-none");
    $('#btnCancelarCita').addClass("d-none");
    $('#btnAnularCita').addClass("d-none");

    if (event.estado == "registrada") {
      $('#btnAceptarCita').removeClass("d-none");
      $('#btnCancelarCita').removeClass("d-none");
    }

    if (event.estado == "aceptada") {
      $('#btnAnularCita').removeClass("d-none");
    }

    $('#modal-calendario-show').modal('show');

  });
  calendarioEvent.on('eventDrop', function(event, delta, revertFunc, jsEvent, ui, view){

    var id_cita = event.id;
    var fecha_inicio_Obj = new Date(event.start);
    var momentObj_1 = moment(fecha_inicio_Obj);
    var fecha_inicio = momentObj_1.format('YYYY-MM-DD');

    var fecha_fin_Obj = new Date(event.end);
    var momentObj_2 = moment(fecha_fin_Obj);
    var fecha_fin = momentObj_2.format('YYYY-MM-DD');

    var hora_inicio = event.start.format('HH:mm');
    var hora_fin = event.end.format('HH:mm');

    var fecha_actual = new Date();
    var fecha_compara = new Date(fecha_inicio + ' ' + hora_inicio);

    if (fecha_actual.getTime() > fecha_compara.getTime()) {
      //runAlert('Advertencia','No puedes separar una cita con fecha pasada.','warning');
      new PNotify({
          title: 'Advertencia',
          text: 'No puedes separar una cita con fecha pasada.',
          type: 'warning',
          styling: 'bootstrap3',
          addclass: ''
      });
      revertFunc();
      return;
    }

    try {

      var parametros = {
        "id_cita" : id_cita,
        "fecha_inicio" : fecha_inicio,
        "fecha_fin" : fecha_fin,
        "hora_inicio" : hora_inicio,
        "hora_fin" : hora_fin
      };

      Swal.fire({
        title: '¿Seguro de Actualizar la fecha de la cita?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Actualizar ahora!'
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=actualizarFechaCita",
            datatype: "json",
            data: parametros,
            success: function(data){
              try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  new PNotify({
                      title: 'Oh No...!!!',
                      text: response['message'],
                      type: 'error',
                      styling: 'bootstrap3',
                      addclass: ''
                  });
                  revertFunc();
                }else {
                  crearCalendario();
                  new PNotify({
                      title: 'Bien hecho...!!!',
                      text: response['message'],
                      type: 'success',
                      styling: 'bootstrap3',
                      addclass: ''
                  });
                }
              } catch (e) {
                new PNotify({
                    title: 'Error',
                    text: e,
                    type: 'error',
                    styling: 'bootstrap3',
                    addclass: ''
                });
                revertFunc();
              }
            },
            error: function(data){
              new PNotify({
                  title: 'Error',
                  text: data,
                  type: 'error',
                  styling: 'bootstrap3',
                  addclass: ''
              });
              revertFunc();
            },
            beforeSend: function (xhr) {
              showHideLoader('block');
            },
            complete: function (jqXHR, textStatus) {
              showHideLoader('none');
            }
          });
        }else {
          revertFunc();
        }
      });
    } catch (e){

      new PNotify({
          title: 'Error',
          text: e,
          type: 'error',
          styling: 'bootstrap3',
          addclass: ''
      });
      revertFunc();
    }

  });
  calendarioEvent.on('eventResize', function(event, delta, revertFunc, jsEvent, ui, view){

    var id_cita = event.id;
    var fecha_inicio_Obj = new Date(event.start);
    var momentObj_1 = moment(fecha_inicio_Obj);
    var fecha_inicio = momentObj_1.format('YYYY-MM-DD');

    var fecha_fin_Obj = new Date(event.end);
    var momentObj_2 = moment(fecha_fin_Obj);
    var fecha_fin = momentObj_2.format('YYYY-MM-DD');

    var hora_inicio = event.start.format('HH:mm');
    var hora_fin = event.end.format('HH:mm');

    var fecha_actual = new Date();
    var fecha_compara = new Date(fecha_inicio + ' ' + hora_inicio);

    if (fecha_actual.getTime() > fecha_compara.getTime()) {
      //runAlert('Advertencia','No puedes separar una cita con fecha pasada.','warning');
      new PNotify({
          title: 'Advertencia',
          text: 'No puedes separar una cita con fecha pasada.',
          type: 'warning',
          styling: 'bootstrap3',
          addclass: ''
      });
      revertFunc();
      return;
    }

    try {

      var parametros = {
        "id_cita" : id_cita,
        "fecha_inicio" : fecha_inicio,
        "fecha_fin" : fecha_fin,
        "hora_inicio" : hora_inicio,
        "hora_fin" : hora_fin
      };

      Swal.fire({
        title: '¿Seguro de Actualizar la fecha de la cita?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Actualizar ahora!'
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=actualizarFechaCita",
            datatype: "json",
            data: parametros,
            success: function(data){
              try {
                var response = JSON.parse(data);
                if (response['error']=="SI") {
                  new PNotify({
                      title: 'Oh No...!!!',
                      text: response['message'],
                      type: 'error',
                      styling: 'bootstrap3',
                      addclass: ''
                  });
                  revertFunc();
                }else {
                  crearCalendario();
                  new PNotify({
                      title: 'Bien hecho...!!!',
                      text: response['message'],
                      type: 'success',
                      styling: 'bootstrap3',
                      addclass: ''
                  });
                }
              } catch (e) {
                new PNotify({
                    title: 'Error',
                    text: e,
                    type: 'error',
                    styling: 'bootstrap3',
                    addclass: ''
                });
                revertFunc();
              }
            },
            error: function(data){
              new PNotify({
                  title: 'Error',
                  text: data,
                  type: 'error',
                  styling: 'bootstrap3',
                  addclass: ''
              });
              revertFunc();
            },
            beforeSend: function (xhr) {
              showHideLoader('block');
            },
            complete: function (jqXHR, textStatus) {
              showHideLoader('none');
            }
          });
        }else {
          revertFunc();
        }
      });
    } catch (e){

      new PNotify({
          title: 'Error',
          text: e,
          type: 'error',
          styling: 'bootstrap3',
          addclass: ''
      });
      revertFunc();
    }

  });

}



function cargarServicios(){
  // $('#cboServicioForm').empty();
  // var id_trabajador = $("#id_trabajador").val();
  // $.ajax({
  //   url: "ajax.php?accion=showServicioMedico",
  //   type: "POST",
  //   data:{
  //     id_trabajador: id_trabajador
  //   },
  //   success : function(data) {
  //     try {
  //       var data1 = JSON.parse(data);
  //       if (data1["error"]=="NO") {
  //         var o = data1["data"];
  //         for (var i = 0; i < o.length; i++) {
  //           $('#cboServicioForm').append('<option value="' + o[i].id_servicio + '">' + o[i].name_servicio + '</option>');
  //         }
  //       }else {
  //         console.log(data1["message"]);
  //       }
  //     } catch (e) {
  //       runAlert("Oh No...!!!","Error en TryCatch: " + e + data,"error");
  //       showHideLoader('none');
  //     }
  //   },
  //   beforeSend: function (xhr) {
  //     showHideLoader('block');
  //   },
  //   error: function (jqXHR, textStatus, errorThrown) {
  //     runAlert("Oh No...!!!","Error de petición: " + jqXHR,"warning");
  //   },
  //   complete: function (jqXHR, textStatus) {
  //     showHideLoader('none');
  //   }
  // });

}

function cargarMascotas(){
  // $('#id_mascota').empty();
  // var id_documento = $("#id_documento").val();
  // var num_documento = $("#num_documento").val();
  // $.ajax({
  //   url: "ajax.php?accion=showMascotasDocumento",
  //   type: "POST",
  //   data:{
  //     id_documento: id_documento,
  //     num_documento: num_documento,
  //   },
  //   success : function(data) {
  //     try {
  //       var data1 = JSON.parse(data);
  //       if (data1["error"]=="NO") {
  //         var o = data1["data"];
  //         for (var i = 0; i < o.length; i++) {
  //           $('#id_mascota').append('<option value="' + o[i].id_mascota + '">' + o[i].nombre + '</option>');
  //         }
  //       }else {
  //         console.log(data1["message"]);
  //       }
  //     } catch (e) {
  //       runAlert("Oh No...!!!","Error en TryCatch: " + e + data,"error");
  //       showHideLoader('none');
  //     }
  //   },
  //   beforeSend: function (xhr) {
  //     showHideLoader('block');
  //   },
  //   error: function (jqXHR, textStatus, errorThrown) {
  //     runAlert("Oh No...!!!","Error de petición: " + jqXHR,"warning");
  //   },
  //   complete: function (jqXHR, textStatus) {
  //     showHideLoader('none');
  //   }
  // });

}

function registrarCita(){
  console.log("Función registrarCita ejecutada");
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
      var form = $("#frmDatos");
      var formdata = false;
      if (window.FormData){
        formdata = new FormData(form[0]);
      }
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goCita",
        contentType: false,
        processData: false,
        data: formdata,
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              crearCalendario();
              runAlert("Bien hecho...!!!",response['message'],"success");
              $('#frmDatos')[0].reset();
              $('#modal-calendario').modal('hide');
              cargarServicios();
              $('#id_mascota').empty();
            }
          } catch (e) {
            runAlert("Oh No...!!!",e + data,"error");
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
