//adapted from https://www.formget.com/jquery-registration-form/
$(document).ready(function() {
	$("#register").click(function() {
		var name = $("#name").val();
		var password = $("#password").val();
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
				if (data == 'You have registered') {
					$("form")[0].reset();
				}
				alert(data);
			});
		}
	});
});