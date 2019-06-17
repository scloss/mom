<?php
if(isset($_SESSION["USERNAME"] ))
{
	$userID = $_SESSION["USERID"];
	$userName = $_SESSION["USERNAME"];
	$userDate = $_SESSION["USERDATE"];
}

?>

@extends('app')

@section('content')
<html>
	<head>
		<title>MOM</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			.createBtn
			{	
				background-color: #3399CC;
				color:#fff;
				font-weight: 800;
				border-radius: 5px;
				padding:5px;
				text-decoration: none;
			}
			.createBtn:hover
			{
				background-color: #194256;
			}
		</style>
	</head>
	<body style="background-image:url('{{asset('/image/background.png')}}')">
		<div class="container-fluid" style="margin-top:10%;">
			<div class="col-md-4">
			</div>
			<div style="box-shadow: 10px 10px 5px #888888;border-radius:5px;border:2px solid black;margin-left: auto; margin-right: auto;border:1px solid black;" class="col-md-4">
			<h5 style="text-align:center;"><b>Dept : NOC</b></h5>
			<h5 style="text-align:center;"><b>User ID : {{ $userID }}</b></h5>	
			<h5 style="text-align:center;"><b>Welcome, {{ $userName }}</b></h5>
			<h3 style="text-align:center;"><b>Last Date Of Roster : {{ $userDate }}</b></h3>
			</div>
			<div class="col-md-4">
			</div>
		</div>
	</body>
</html>
@endsection