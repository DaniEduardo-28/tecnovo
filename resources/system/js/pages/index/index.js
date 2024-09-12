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
          Swal.fire({
            title: response['message'],
            animation: false,
            customClass: {
              popup: 'animated tada'
            }
          });
        }else {
          $("#__ajax__").html('<label style="color: #9e61da" class="label-control">Accediendo al sistema ...</label>');
          setTimeout(function () {
            location.href='?view=home';
          }, 2000);
        }
      } catch (e) {
        Swal.fire({
          title: "Error",
          text: e + data,
          animation: false,
          customClass: {
            popup: 'animated tada'
          }
        });
      }
		},
		error: function(data){
			alert(data);
		}
  });
}
