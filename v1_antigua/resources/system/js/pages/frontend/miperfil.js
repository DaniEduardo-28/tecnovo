
$('#txtDateNac').datepicker({
  format: "dd/mm/yyyy",
  clearBtn: false,
  language: "es",
  autoclose: true,
  keyboardNavigation: false,
  todayHighlight: true
});

function UpdateDataProfile(e){
  e.preventDefault();
  Swal.fire({
    title: '¿Seguro de actualizar sus datos de perfil?',
    text: "No podrás revertir esta operación.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#22c63b',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Actualizar ahora!'
  }).then(function(result) {
    if (result.value) {
      $.ajax({
        type: "POST",
        url: "ajax.php?accion=goMyProfile",
        datatype: "json",
        data: $("#frmDatos").serialize(),
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              runAlert("Bien hecho...!!!",response['message'],"success");
            }
          } catch (e) {
            runAlert("Oh No...!!!",data,"error");
          }
    		},
    		error: function(data){
          runAlert("Oh No...!!!",data,"error");
    		}
      });
    }
  });
}

function UpdateImageProfile(e){
  e.preventDefault();
  Swal.fire({
    title: '¿Seguro de actualizar la imagen de perfil?',
    text: "No podrás revertir esta operación.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#22c63b',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Actualizar ahora!'
  }).then(function(result) {
    if (result.value) {
      var formData = new FormData($("#frmSubirImagen")[0]);
      try {
        $.ajax({
            type:'POST',
            url:'ajax.php?accion=goUpdateImageProfile',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
              try {
                var response = JSON.parse(data);
                if (response["error"]=="SI") {
                  runAlert("Oh No...!!!",response["message"],"warning");
                }else {
                  runAlert("Bien hecho...!!!",response["message"],"success");
                }
              } catch (e) {
                runAlert("Oh No...!!!",e,"error");
              }
            },
            error: function(data){
              runAlert("Oh No...!!!",data,"error");
        		}
        });
      } catch (e) {
        runAlert("Oh No...!!!",e.toString(),"error");
      }
    }
  });
}
