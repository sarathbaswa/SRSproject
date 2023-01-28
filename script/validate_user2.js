$(document).ready(function() {
	//validdate the field values
	$('#username').on('input', function() {
		//check the name value
		var input_value=$(this);
		var is_valid_name=input_value.val();
		if(is_valid_name)
		{
			input_value.removeClass("invalid").addClass("valid");
			input_value.parent().next().next().hide();
		}
		else
		{
			input_value.removeClass("valid").addClass("invalid");
			input_value.parent().next().next().show();
		}
	});
	$('#passwd').on('input', function() {
		//check the password value
		var input_value=$(this);
		var is_pwd=input_value.val();
		if(is_pwd)
		{
			input_value.removeClass("invalid").addClass("valid");
			input_value.parent().next().hide();
		}
		else
		{
			input_value.removeClass("valid").addClass("invalid");
			input_value.parent().next().show();
		}
	});
	$('#first_ame').on('input', function() {
		var input_value=$(this);
		var is_fn=input_value.val();
		if(is_fn)
		{
			input_value.removeClass("invalid").addClass("valid");
			input_value.parent().next().hide();
		}
		else
		{
			input_value.removeClass("valid").addClass("invalid");
			input_value.parent().next().show();
		}
	});
	$('#last_name').on('input', function() {
		var input_value=$(this);
		var is_ln=input_value.val();
		if(is_ln)
		{
			input_value.removeClass("invalid").addClass("valid");
			input_value.parent().next().hide();
		}
		else
		{
			input_value.removeClass("valid").addClass("invalid");
			input_value.parent().next().show();
		}
	});
	$('#email_id').on('input', function() {
		var input_value=$(this);
		var is_email=input_value.val();
		if(is_email)
		{
			input_value.removeClass("invalid").addClass("valid");
			input_value.parent().next().hide();
		}
		else
		{
			input_value.removeClass("valid").addClass("invalid");
			input_value.parent().next().show();
		}
	});
	$('#phone').on('input', function() {
		var input_value=$(this);
		var is_phone=input_value.val();
		if(is_phone)
		{
			input_value.removeClass("invalid").addClass("valid");
			input_value.parent().next().hide();
		}
		else
		{
			input_value.removeClass("valid").addClass("invalid");
			input_value.parent().next().show();
		}
	});
});
