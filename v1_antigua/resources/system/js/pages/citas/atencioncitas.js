$(document).ready(function(){

    $('#panelDetalle').addClass('d-none');

    crearCalendario();

    $('#cboDocumentoBuscar').change(function(){
      crearCalendario();
    });

    $('#btnSearch').click(function(){
      crearCalendario();
    });

    $('#btnCancel').click(function(){
      $('#panelDetalle').addClass('d-none');
      $('#panelCalendario').removeClass('d-none');
      $('#calendario').removeClass('d-none');
    });

    $('#btnAtenderCita').click(function(){

        try {

          var id_cita = $("#id_cita").val();
          var parametros = {
            "id_cita" : id_cita
          };

          Swal.fire({
            title: '¿Seguro de atender esta cita : ' + $("#fecha_inicio").val() + '?',
            text: "No podrás revertir esta operación.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c63b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Atender ahora!'
          }).then(function(result) {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: "ajax.php?accion=getDetalleCita",
                datatype: "json",
                data: parametros,
                success: function(data){
            			try {
                    var response = JSON.parse(data);
                    if (response['error']=="SI") {
                      runAlert("Oh No...!!!",response['message'],"warning");
                    } else {
                      var o = response['data'];
                      $('#id_tipo_mascota').val(o[0]['id_tipo_mascota']);
                      $('#nombre_mascota').val(o[0]['name_mascota']);
                      $('#raza').val(o[0]['raza']);
                      $('#color').val(o[0]['color']);
                      $('#peso').val(o[0]['peso']);
                      $('#sexo').val(o[0]['sexo']);
                      $('#fecha_nacimiento').val(o[0]['fecha_nacimiento']);
                      $('#estado').val(o[0]['estado']);
                      $('#motivo').val(o[0]['sintoma']);
                      $('#img_destino').attr('src', o[0]['src_imagen']);
                      $('#sintomas_edit').val(o[0]['detalle_sintomas']);
                      $('#observaciones_edit').val(o[0]['detalle_observaciones']);
                      $('#tratamiento_edit').val(o[0]['detalle_tratamiento']);
                      $('#vacunas_edit').val(o[0]['detalle_vacunas_aplicadas']);
                      $('#panelDetalle').removeClass('d-none');
                      $('#panelCalendario').addClass('d-none');
                      $('#calendario').addClass('d-none');
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

    $('#btnSave').click(function(){

        try {

          var id_cita = $("#id_cita").val();
          var peso = $("#peso").val();
          var observaciones = $("#observaciones_edit").val();
          var sintomas = $("#sintomas_edit").val();
          var tratamiento = $("#tratamiento_edit").val();
          var vacunas = $("#vacunas_edit").val();
          var motivo = $("#motivo").val();
          var parametros = {
            "id_cita" : id_cita,
            "peso" : peso,
            "observaciones" : observaciones,
            "sintomas" : sintomas,
            "tratamiento" : tratamiento,
            "vacunas" : vacunas,
            "motivo" : motivo,
          };
          Swal.fire({
            title: '¿Seguro de registrar la atención de esta cita?',
            text: "No podrás revertir esta operación.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c63b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Registrar ahora!'
          }).then(function(result) {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: "ajax.php?accion=goRegistrarAtencion",
                datatype: "json",
                data: parametros,
                success: function(data){
            			try {
                    var response = JSON.parse(data);
                    if (response['error']=="SI") {
                      runAlert("Oh No...!!!",response['message'],"warning");
                    } else {
                      runAlert("¡Bien Hecho!",response['message'],"success");
                      $('#panelDetalle').addClass('d-none');
                      $('#panelCalendario').removeClass('d-none');
                      $('#calendario').removeClass('d-none');
                      crearCalendario();
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

});

function crearCalendario(){

  $('#calendario').fullCalendar('destroy');
  var id_documento = $('#cboDocumentoBuscar').val();
  var valor = $('#txtBuscar').val();
  var calendario = $('#calendario').fullCalendar({  // assign calendar
    defaultView: 'agendaWeek',
    editable: false,
    selectable: false,
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
    selectHelper: false,
    selectOverlap: false,
    eventOverlap: false,
    droppable: false,

    eventSources: [

      // your event source
      {
        url: 'ajax.php?accion=showCitasTrabajador',
        type: 'POST',
        data: {
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

    $('#modal-calendario-show').modal('show');

  });

}
