$(document).ready(function(){

    $('#btnCancelar').addClass("d-none");

    crearCalendario();

    cargarMedicos();

    $('#cboSucursalBuscar').change(function(){
      cargarMedicos();
    });

    $('#cboMedicoBuscar').change(function(){
      crearCalendario();
      cargarServicios();
    });

    $('#btnCancelar').click(function(){

        try {

          var id_cita = $("#id_cita").val();
          var parametros = {
            "id_cita" : id_cita
          };

          Swal.fire({
            title: '¿Seguro de Cancelar la cita del día : ' + $("#txtFechaInicio").val() + '?',
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
                url: "ajax.php?accion=cancelarCita",
                datatype: "json",
                data: parametros,
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
  var id_sucursal = $('#cboSucursalBuscar').val();
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
    selectOverlap: false,
    eventOverlap: false,
    droppable: true,

    eventSources: [

      // your event source
      {
        url: 'ajax.php?accion=showCitasCliente',
        type: 'POST',
        data: {
          id_medico: id_medico,
          id_sucursal: id_sucursal
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

    //showUnidades();
    $('#btnCancelar').addClass("d-none");
    $('#btnSave').removeClass("d-none");
    $('#txtSintomas').attr('disabled', false);
    $('#cboServicioForm').attr('disabled', false);
    $('#id_mascota').attr('disabled', false);
    $('#modal-calendario').modal('show');

  });
  calendarioEvent.on('eventClick', function(event, jsEvent, view){

    if (event.estado == "NO") {
      return;
    }

    $('#btnSave').addClass("d-none");
    $('#btnCancelar').addClass("d-none");
    $('#id_cita').val(event.id);
    $('#id_mascota').val(event.id_mascota);
    $('#cboServicioForm').val(event.id_servicio);
    $('#txtFechaInicio').val(event.fecha_inicio);
    $('#txtHoraInicio').val(event.hora_inicio);
    $('#txtFechaTermino').val(event.fecha_fin);
    $('#txtHoraFin').val(event.hora_fin);
    $('#txtSintomas').val(event.sintoma);
    $('#txtSintomas').attr('disabled', true);
    $('#cboServicioForm').attr('disabled', true);
    $('#id_mascota').attr('disabled', true);

    if (event.estado == "registrada") {
      $('#btnCancelar').removeClass("d-none");
    }

    $('#modal-calendario').modal('show');

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
        text: "Se enviará un correo al administrador del sistema, el cambio de la cita.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Actualizar ahora!'
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=actualizarCita",
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
        text: "Se enviará un correo al administrador del sistema, el cambio de la cita.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22c63b',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Actualizar ahora!'
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: "ajax.php?accion=actualizarCita",
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
  var id_trabajador = $("#cboMedicoBuscar").val();
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
            if (o[i].flag_igv=='1') {
              $('#cboServicioForm').append('<option value="' + o[i].id_servicio + '">' + o[i].name_servicio + ' - ' + o[i].signo_moneda + ' ' + o[i].precio + '</option>');
            }else {
              var igv = $('#valor_igv').val();
              var precio = o[i].precio;
              var valor_igv = precio * igv / 100;
              var precio_final = parseFloat(precio) + parseFloat(valor_igv);
              precio_final = precio_final.toFixed(2);
              $('#cboServicioForm').append('<option value="' + o[i].id_servicio + '">' + o[i].name_servicio + ' - ' + o[i].signo_moneda + ' ' + precio_final + '</option>');
            }
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

  $('#id_trabajador').val($('#cboMedicoBuscar').val());
  $('#id_sucursal').val($('#cboSucursalBuscar').val());
  $('#name_sucursal').val($('select[name="cboSucursalBuscar"] option:selected').text());

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

function cargarMedicos(){
  $('#cboMedicoBuscar').empty();
  $('#id_servicio').empty();
  var id_sucursal = $("#cboSucursalBuscar").val();
  $.ajax({
    url: "ajax.php?accion=showMedicosSucursal",
    type: "POST",
    data:{
      id_sucursal: id_sucursal
    },
    success : function(data) {
      try {
        var data1 = JSON.parse(data);
        if (data1["error"]=="NO") {
          var o = data1["data"];
          for (var i = 0; i < o.length; i++) {
            $('#cboMedicoBuscar').append('<option value="' + o[i].id_trabajador + '">' + o[i].apellidos + ' ' + o[i].nombres + ' (' + o[i].name_especialidad + ')</option>');
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
      crearCalendario();
      cargarServicios();
    }
  });

}
