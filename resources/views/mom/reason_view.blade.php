<?php
if(isset($_SESSION["LOGIN_FAILED"] ))
{
	$loginFailed = $_SESSION["LOGIN_FAILED"];
}
else
{
	$loginFailed = '';
}

?>
<html>
	<head>
		<title>MOM</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		<style>
			.createBtn
			{				
				background-color: #3399CC;
				color:#fff;
				font-weight: 800;
				border-radius: 5px;
			}
		</style>
		<script type="application/javascript">
		var ipValue = '';
		    function getip(json){
		     // alert(json.ip);
		      //var ip = document.getElement // alerts the ip address
		      // var ip = document.getElementById('ip_address');
		      // ip.value =json.ip 
		      ipValue = json.ip;

		    }
		    function sendReason()
		    {
		    	//alert(ipValue);
		    	var ip = document.getElementById("ip_address");
		    	ip.value = ipValue;
		    	//alert(ip.value);
		    	document.getElementById("reason_id").submit();
		    }


		</script>

		<script type="application/javascript" src="http://www.telize.com/jsonip?callback=getip"></script>
	</head>

	<body style="background-image:url('{{asset('/image/background.png')}}')">
		<div class="container-fluid">
			<form action="{{ url('reasonMail') }}" id="reason_id" method="get" enctype="multipart/form-data">
				<h3>Login Reason</h3>
				{!! Form::textarea('reason') !!}
				<input type="hidden" name="ip_address" id="ip_address">
			<input type="button" onclick="sendReason()" class="add" value="Submit" id="sendReasonForm" style="float:right;" >

		</div>
	</body>
</html>
