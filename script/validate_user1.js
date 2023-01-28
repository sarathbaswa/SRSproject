function validateDetails() {
	var a1 = document.forms["registerForm"]["username"].value;
	var is_valid= 1;
	if(a1 == null || a1 == "") {
		alert("user name cannot be empty");
		is_valid= 0;
	}
	var a2 = document.forms["registerForm"]["passwd"].value;
	if(a2 == null || a2 == "") {
		alert("password cannot be empty");
		is_valid= 0;
	}

	var pwd_re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*[^a-zA-Z0-9])(.{6,})$/;
	if(!pwd_re.test(y)){
			alert("password should match all rules");
			is_valid= 0;
	}

	var a3 = document.forms["registerForm"]["first_name"].value;
	if(a3 == null || a3 == "") {
		alert("first name cannot be empty");
		is_valid= 0;
	}
	var a4 = document.forms["registerForm"]["last_name"].value;
	if(a4 == null || a4 == "") {
		alert("last name cannot be empty");
		is_valid= 0;
	}
	var a5 = document.forms["registerForm"]["email_id"].value;
	if(a5 == null || a5 == "") {
		alert("email cannot be empty");
		is_valid= 0;
	}
	var a6 = document.forms["registerForm"]["phone"].value;
	if(a6 == null || a6 == "") {
		alert("phone number cannot be empty");
		is_valid= 0;
	}
	if(is_valid== 0)
		return false;
	else
		return true;
}
