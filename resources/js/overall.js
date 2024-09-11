var languageSpanish = {
  "decimal": "",
  "emptyTable": "No hay información",
  "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
  "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
  "infoFiltered": "(Filtrado de _MAX_ total registros)",
  "infoPostFix": "",
  "thousands": ",",
  "lengthMenu": "Mostrar _MENU_ Registros",
  "loadingRecords": "Cargando...",
  "processing": "Procesando...",
  "search": "Buscar:",
  "zeroRecords": "Sin resultados encontrados",
  "paginate": {
    "first": "Primero",
    "last": "Ultimo",
    "next": "Siguiente",
    "previous": "Anterior"
  }
};

function showHideLoader(display) {
  $('#loading-ajax').css('display', display);
}

showHideLoader('none');

function dosDecimales(id) {
  return parseFloat(id.val()).toFixed(2);
}

function generateAlert(type, text) {

    var n = noty({
        text        : text,
        type        : type,
        title       : 'Prueba..!!',
        dismissQueue: true,
        progressBar : true,
        timeout     : 3000,
        layout      : 'bottomLeft',
        closeWith   : ['button', 'click'],
        theme       : 'metroui',
        maxVisible  : 6,
        animation   : {
            open  : 'animated bounceInLeft',
            close : 'animated bounceOutLeft',
            easing: 'swing',
            speed : 5000
        }
    });
    return n;
}

function runAlert(title,text,icon){
  Swal.fire({
    type: icon,
    title: title,
    text: text
  });
}

$(document).ready(function(){

  $("#frmSuscribirseFooter").validate();
  $("#correo_suscribirse").rules("add", {
      required: true,
      email: true,
      messages: {
        required: "Por favor ingrese un correo válido.",
        email:"Por favor ingrese un correo válido."
      }
  });

  $("#frmSuscribirseFooter").submit(function(event) {
    event.preventDefault();
    if (!$("#frmSuscribirseFooter").valid()){
      return;
    }
    saveSuscriptor();
  });

});

function saveSuscriptor(){
  var form = $("#frmSuscribirseFooter");
  var formdata = false;
  if (window.FormData){
    formdata = new FormData(form[0]);
  }
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=goSuscribirse",
    contentType: false,
    processData: false,
    data: formdata,
    success: function(data){
      try {
        var response = JSON.parse(data);
        if (response["error"]=="SI") {
          runAlert("Oh No...!!!",response['message'],"warning");
        }else {
          runAlert("Bien hecho...!!!",response['message'],"success");
          $('#frmSuscribirseFooter')[0].reset();
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
