<?php if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'SUPER') == 0)	{ ?>

<div class="fluid-container">
	<h1>Test SMS</h1>
	<p>Enter a text to simulate sending SMS:</p>
	
	<form role="form" id="sms_form" method="post" action="<?php echo site_url('sms/index/1'); ?>">
		<?php echo form_error('feedback'); ?>

        <div class="form-group">
            <label for="PhoneNumber">Phone Number:</label>
            <input id="phone_number" name="phone_number" type="text" class="form-control" id="PhoneNumber" placeholder="Enter phone number">
        </div>

        <div class="form-group">
            <label for="SMS">Text:</label>
            <input id="sms" name="sms" type="text" class="form-control" id="SMS" placeholder="Enter sms message">
        </div>
		<a id="btn_submit" class="btn btn-ttb" href="#">Submit</a>
		<a class="btn btn-ttb" id="cls">clear</a>
	</form>

	<h2>Server replies:</h2>
	<div id="replies">
	</div>
</div>

<?php } else { redirect('error/must_sign_up_as_admin'); } ?>

<script>
$(function () { 
	$('#cls').click(function(){
		$('#replies').empty();
		return false;
	});


	$('#btn_submit').click(function(e){
		var sms = $('#sms').val();
		e.preventDefault();
		while(sms.length > 0)
		{
			send_sms(sms.substring(0, 160));
			//alert(sms.substring(0, 160));
			sms = sms.substring(160);
		}
	});
	
function send_sms(sms)
{
	var params = { 
		'Message': sms, 
		'OriginatorAddress':$('input#phone_number').val(),
		'Carrier': 'Test from simulating SMS texts', 
		'NetworkType': 'TTB web form', 
	};
			
	$.ajax({
		type: "POST",
		url: $('form#sms_form').attr('action'),
		data: params,
		
		success: function(response) 
		{
			$('#replies').prepend(response);
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			$('#replies').prepend('<br/>********************************************************<br/>error contacting the server<br/>********************************************************<br/>');
		}
	});
}

});

</script>