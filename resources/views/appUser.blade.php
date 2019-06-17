<?php $App = 'app' ?>
<?php
//echo $_SESSION["USERTYPE"];
if(isset($_SESSION["dashboard_user_name"] ))
{
	$userID = $_SESSION["dashboard_user_id"];
	$userName = $_SESSION["dashboard_user_name"];
}
if(isset($_SESSION["USERTYPE"]))
{
	if($_SESSION["USERTYPE"] == 'admin')
	{
		$App = 'app';
	}
	else
	{
		$App = 'app';
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MoM Management</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	
	<link href="{{ asset('/css/styles.css') }}" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="{{ asset('/js/script.js') }}" type="text/javascript"></script>
	<link rel="shortcut icon" href="{{asset('/images/favicon.ico')}}">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<script type="text/javascript">
		function onReady(callback) {
			    var intervalID = window.setInterval(checkReady, 1000);

			    function checkReady() {
			        if (document.getElementsByTagName('body')[0] !== undefined) {
			            window.clearInterval(intervalID);
			            callback.call(this);
			        }
			    }
			}

			function show(id, value) {
			    document.getElementById(id).style.display = value ? 'block' : 'none';
			}

			onReady(function () {
			    show('outer', true);
			    show('loading', false);
			});
	</script>
	<style type="text/css">
		#page {
		    display: none;
		}
		#loading {
		    display: block;
		    position: absolute;
		    top: 0;
		    left: 0;
		    z-index: 100;
		    width: 100vw;
		    height: 100vh;
		    background-color: #fff;
		    background-image: url("{{asset('/images/loaderpre.gif')}}");
		    background-repeat: no-repeat;
		    background-position: center;
		}
	</style>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body style="">
	<div id="loading"></div>
	<div id="outer">
		<!-- <div id='cssmenu'>
			<ul>
			   <li><a href='#'>Home</a></li>
			   <li><a href='#'>Products</a></li>
			   <li><a href='#'>Company</a></li>
			   <li><a href='#'>Contact</a></li>
			</ul>
		</div> -->
	<nav class="navbar navbar-default" style="min-width:1338px;">
		<div class="container-fluid" >
			<div class="navBarClass">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div id="tool_name" style="background:#A94343; height:5.5em;width:5.8em; color:#fff;float:left;text-align:left;margin-top:-1.3em;margin-left:-15px"><h6 style="padding-left: 17px;
    margin-top: 14px;font-size:16px;font-weight:bold;font-style:italic;
    /* font-weight: bold; */">SCL MOM TOOL</h6></div>
					<div id="logoImg" style="float:right"><a class="navbar-brand" href="{{ url('landing') }}" ><img src="{{asset('/images/logo.png') }}" alt="logo"></a></div>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<div id='cssmenu' style="margin-top:1.5%;">
							<ul>
								<li><a href="{{ url('landing') }}">Home</a></li>
							    <li><a href="{{ url('doentry') }}">Create MoM</a></li>
								<li><a href="{{ url('search') }}">Search</a></li>
								<li><a href="{{ url('contact') }}">Contact</a></li>
								<li><a href="{{ url('faq') }}">FAQ</a></li>
							</ul>
						</div>
					</ul>
					<!-- 
						<li><a href="{{ url('doentry') }}">Create New Meeting</a></li>
						<li><a href="{{ url('search') }}">Search</a></li>
						<li><a href="{{ url('contact') }}">Contact</a></li>
						<li><a href="{{ url('faq') }}">FAQ</a></li>
					</ul>-->
					<ul class="nav navbar-nav navbar-right">
						<div id='cssmenu' style="margin-top:1.5%;">
							<ul>
								<li><a href="{{ url('landing') }}">Welcome, <?php 
								$userNameArr = explode(' ', $userName);
								echo $userNameArr[0]; 
								?></a></li>
								<li><a href="{{ url('logout') }}">Logout</a></li>
							</ul> 
						</div>
					</ul> 
					
				</div>
			</div>

		</div>

	</nav>

	
	@yield('content')

	<!-- Scripts -->
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<footer class="footer">
      <div class="footDiv">
        <h5>SCL MOM TOOL v1.1 © 2016 SCL NOC | All rights reserved | Summit Communications Ltd.</h5>
      </div>
    </footer>
</body>
</html>