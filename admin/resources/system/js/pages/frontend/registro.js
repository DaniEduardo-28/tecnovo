$("#id_documento").change(function(){
  changeOption();
});

function changeOption(){
  var name_documento = $('select[name="id_documento"] option:selected').text();
  if (name_documento.toUpperCase().trim()=="RUC") {
    $('#nombres').attr('placeholder','Razón Social');
    $('#apellidos').attr('placeholder','Nombre Comercial');
  }else {
    $('#nombres').attr('placeholder','Nombres');
    $('#apellidos').attr('placeholder','Apellidos');
  }
}

function goRegistro(e){
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=goResgistro",
    datatype: "json",
    data: $("#frmRegistro").serialize(),
    success: function(data){
			try {
        var response = JSON.parse(data);
        if (response['error']=="SI") {
          runAlert("¡Advertencia!",response['message'],"warning");
        }else {
          $("#__ajax__").html('<h3 style="color: #5bfa1a; text-align: center;" class="label-control">¡Gracias por Registrarte!</h3>');
          setTimeout(function () {
            location.href='?view=login';
          }, 1500);
        }
      } catch (e) {
        runAlert("¡Advertencia!",e + data,"warning");
      }
		},
		error: function(data){
			runAlert("¡Advertencia!",data,"warning");
		}
  });
}
