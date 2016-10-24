//adapted from https://www.formget.com/jquery-registration-form/
$(document).ready(function() {
	$("#register").click(function() {
		var name = $("#userName").val();
		var password = $("#newPassword").val();
		if (name === '' || password === '') {
			alert("you must fill in both fields");
		} 
		else if ((password.length) < 8) {
			alert("Password should atleast 8 character in length");
		} 
		else {
			$.post("add_new_user.php", {
				newname: name,
				newpass: password
			}, 
			function(data) {
				if (data === 'You have registered') {
					
					$("form")[0].reset();
				}
				else if(data === 'username already exists')
				{
					alert("username already exists");
				}
				else{
					alert(data);
				}
			});
		}
	});
});