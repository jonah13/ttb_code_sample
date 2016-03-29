<div class="fluid-container">          
	<div class="row">
        <div class="col-xs=12 col-sm-10 col-md-8 col-lg-6">
            <h2><i class="fa fa-phone"></i>&nbsp;Test SMS</h2>
<!--             <input name="ID" type="hidden" value="<?php echo !empty($location['ID']) ? $location['ID'] : '0'; ?>"/> -->
			<?php echo form_error('feedback'); ?>
			<form id="sms_form" method="post" action="<?php echo site_url('sms/index/1'); ?>">
	            <div class="form-group">
	                <label for="phone_number">Phone number</label>
	                <input name="phone_number"  type="text" class="form-control" id="phone_number" placeholder="Enter phone number">
	            </div>
	            <div class="form-group">
	                <label for="sms">Text</label>
	                <textarea rows="2" name="sms"  class="form-control" id="sms"></textarea>
	            </div>


				<button type="submit" class="btn btn-ttb">Send</button>
			</form>
        </div>
	</div>

	<div class="row">
        <div class="col-xs=12 col-sm-10 col-md-8 col-lg-6">
			<h2>Server replies:</h2>
			<button id="cls" class="btn btn-default">Clear</button>
			<div id="replies">
			</div>
        </div>
	</div>
</div>

<script>
$(document).ready(function() 
{
	$('#cls').click(function(){
		$('#replies').empty();
		return false;
	});

	$('form#sms_form').submit(function(e){
		var sms = $('#sms').val();
		e.preventDefault();
		while(sms.length > 0)
		{
			send_sms(sms.substring(0, 160));
			sms = sms.substring(160);
		}
	});
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
</script>