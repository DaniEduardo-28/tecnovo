$(document).ready(function(){

    crearCalendario();

    cargarServicios();

    $('#cboMedicoBuscar').change(function(){
      crearCalendario();
    });

    $('#id_trabajador').change(function(){
      cargarServicios();
    });

    $('#cboDocumentoBuscar').change(function(){
      crearCalendario();
    });

    $('#btnSearch').click(function(){
      crearCalendario();
    });

    $('#btnBuscarMascotas').click(function(){
      cargarMascotas();
    });

    $("#num_documento").keypress(function() {
      $('#id_mascota').empty();
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
      registrarCita();
    });

});

function crearCalendario(){

  $('#calendario').fullCalendar('destroy');
  var id_medico = $('#cboMedicoBuscar').val();
  var id_documento = $('#cboDocumentoBuscar').val();
  var valor = $('#txtBuscar').val();
  var calendario = $('#calendario').fullCalendar({  // assign calendar
    defaultView: 'agendaWeek',
    editable: true,
    selectable: true,
    allDaySlot: false,
    locale: 'es', // Idioma
    //titleFormat: '[Horario Carrera, Semestre y Sección]', //Título
    weekends: true, // Oculta fin de semana
    minTime: '07:00:00', //Hora Mínima Mostrada
    maxTime: '22:00:00', //Hora Máxima Mostrada
    slotDuration : '00:15:00', //Intervalo de Tiempo entre Horas
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

    var fecha_inicio_Obj = new Date(start);
    var momentObj_1 = moment(fecha_inicio_Obj);
    var fecha_inicio = momentObj_1.format('YYYY-MM-DD');

    var fecha_fin_Obj = new Date(end);
    var momentObj_2 = moment(fecha_fin_Obj);
    var fecha_fin = momentObj_2.format('YYYY-MM-DD');

    var hora_inicio = start.format('HH:mm');
    var hora_fin = end.format('HH:mm');

    var fecha_actual = new Date();
    var fecha_compara = new Date(fecha_inicio + ' ' + hora_inicio);

    if (fecha_actual.getTime() > fecha_compara.getTime()) {
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
  $('#cboServicioForm').empty();
  var id_trabajador = $("#id_trabajador").val();
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
          for (var i = 0; i < o.length; i++) {
            $('#cboServicioForm').append('<option value="' + o[i].id_servicio + '">' + o[i].name_servicio + '</option>');
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

function cargarMascotas(){
  $('#id_mascota').empty();
  var id_documento = $("#id_documento").val();
  var num_documento = $("#num_documento").val();
  $.ajax({
    url: "ajax.php?accion=showMascotasDocumento",
    type: "POST",
    data:{
      id_documento: id_documento,
      num_documento: num_documento,
    },
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            $('#id_mascota').append('<option value="' + o[i].id_mascota + '">' + o[i].nombre + '</option>');
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

function registrarCita(){

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
