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
