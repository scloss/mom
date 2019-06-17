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
		

<script type="application/javascript" src="http://www.telize.com/jsonip?callback=getip"></script>
	</head>

	<body style="background-image:url('{{asset('/image/background.png')}}')">
		<div class="container-fluid">
			<div class="row" style="margin-top:5%;">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading" style="text-align:center;">Login</div>
						<h5 style="color:red;text-align:center;"><b>{{$loginFailed}}</b></h5>
							<h5>
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<strong>Whoops!</strong> There were some problems with your input.<br><br>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<form class="form-horizontal" role="form" method="POST" action="{{ url('goHome') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								<div class="form-group">
									<label class="col-md-4 control-label">User Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="userName" value="{{ old('email') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="password">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="remember"> Remember Me
											</label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary">Login</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>
