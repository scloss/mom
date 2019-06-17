<?php
if(isset($_SESSION["USERNAME"] ))
{
	$userID = $_SESSION["USERID"];
	$userName = $_SESSION["USERNAME"];
	$userDate = $_SESSION["USERDATE"];
}

?>
@extends('appUser')

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
		<div class="container-fluid">
			<div class="col-md-4">
			</div>
			<div style="margin-left: auto; margin-right: auto;box-shadow: 10px 10px 5px #888888;border-radius:5px;border:2px solid black;" class="col-md-4">
			<h5 style="text-align:center;">Dept : NOC</h5>
			<h5 style="text-align:center;">User ID : {{ $userID }}</h5>	
			<h5 style="text-align:center;">Welcome, {{ $userName }}</h5>
			<h3 style="text-align:center;">Last Date Of Roster : {{ $userDate }}</h3>
			</div>
			<div class="col-md-4">
			</div>
		</div>
	</body>
</html>
@endsection