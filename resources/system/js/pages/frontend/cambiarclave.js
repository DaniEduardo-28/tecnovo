function UpdatePassword(e){
  e.preventDefault();

  Swal.fire({
    title: '¿Seguro de actualizar su clave de acceso?',
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
        url: "ajax.php?accion=changePassword",
        datatype: "json",
        data: $("#frmDatos").serialize(),
        success: function(data){
    			try {
            var response = JSON.parse(data);
            if (response['error']=="SI") {
              runAlert("Oh No...!!!",response['message'],"warning");
            }else {
              runAlert("Bien hecho...!!!",response['message'],"success");
              $("#frmDatos")[0].reset();
            }
          } catch (e) {
            runAlert("Oh No...!!!",e,"error");
          }
    		},
    		error: function(data){
          runAlert("Oh No...!!!",data,"error");
    		}
      });
    }
  });
}
