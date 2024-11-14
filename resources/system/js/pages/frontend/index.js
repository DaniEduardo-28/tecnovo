function goLogin(e){
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "ajax.php?accion=goLogin",
    datatype: "json",
    data: $("#frmLogin").serialize(),
    success: function(data){
			try {
        var response = JSON.parse(data);
        if (response['error']=="SI") {
          runAlert("¡Advertencia!",response['message'],"warning");
        }else {
          $("#__ajax__").html('<h3 style="color: #5bfa1a; text-align: center;" class="label-control">Acceso correcto...</h3>');
          setTimeout(function () {
            location.href='?view=index';
          }, 2000);
        }
      } catch (e) {
        runAlert("¡Advertencia!",e + data,"warning");
      }
		},
		error: function(data){
			alert(data);
		}
  });
}
