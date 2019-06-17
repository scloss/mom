<?php $App = 'app' ?>
<?php
if(isset($_SESSION["dashboard_user_name"] ))
{
	$userID = $_SESSION["dashboard_user_id"];
	$userName = $_SESSION["dashboard_user_name"];
	$userType = $_SESSION["USERTYPE"];
}
if(isset($_SESSION["USERTYPE"]))
{
	if($_SESSION["USERTYPE"] == 'admin' || $_SESSION["USERTYPE"] == 'superAdmin')
	{
		$App = 'app';
	}
	else
	{
		$App = 'appUser';
	}
	
}
?>
@extends($App)
@section('content')
<html>
	<head>
		<title>MOM</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>
		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
		<!--<script type="text/javascript" src="{{ asset('/js/test.js') }}"></script>-->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	 
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		<style type="text/css">

		table.landingTable
		{
		    width: 900px;
		    padding-top: 3%;
		    margin-top: 4%;
		    margin-left: 6%;
		    font-size:15px;
		    text-align: center;
		}

		table.landingTable td
		{  
		    border: 1px solid #fff!important;
		    border-radius: 5px !important;
		    padding: 5px !important;
		    background-color:#B2D6DA  ;
		    font-weight:normal;
		    color:#000;
		}
		
		table.landingTable tr
		{  
		    border: 1px solid black ;
		    /*background-color: ;*/
		}
		#test:hover
	    {
	      -moz-transition: all .51s;
	      -o-transition: all .51s;
	      -webkit-transition: all .51s;
	      transition: all .51s;
	        border-radius: 0% !important;
	    }
		#test{
		     /* background-color: rgb(211,211,211);*/
		      /*background-image: repeating-linear-gradient(45deg, 
		      transparent, transparent 10px, rgb(199,199,199) 0px, 
		      rgb(200,200,200) 30px);*/
		      border-radius:50%;
		      font-size:18px !important;box-shadow: 0px 0px 18px #888888;border-radius:10%;margin-top:2%;border:2px solid black;margin-left: auto; margin-right: auto;border:2px solid #fff;color:#000;background:url("{{url('/images/boxbg.jpg')}}");font-weight:bold;
		    }
		 #test h5{
		      text-align:center;
		      font-size:18px !important;
		      font-weight:bold;
		      color:#000;
		 }  
		</style>
	</head>
	<body>
		<div id="titleBar">
			<h4>MOM THREAD</h4>
		</div>
		<div class="container">
			<div class="col-md-12">
				<div id="landingInfoDiv">
					<div class="col-md-4">
					</div>
					<div id="test" style="box-shadow: 0px 0px 18px #888888;border-radius:5px;margin-top:2%;border:2px solid black;margin-left: auto; margin-right: auto;border:2px solid #fff;color:#000" class="col-md-4">
					<h5 style="text-align:center;">Dept : NOC</h5>
					<h5 style="text-align:center;">User ID : {{ $userID }}</h5>	
					<h5 style="text-align:center;">Welcome, {{ $userName }}</h5>
					<h5 style="text-align:center;">Type: {{ $userType }}</h5>
					</div>
					<div class="col-md-4">
					</div>
				</div>
				<div id="landingTableDiv" style="margin-top:15%;margin-left:3%;">
					
					<div class="col-md-8" >	
						<table class="landingTable" style="box-shadow: 10px 10px 5px #888888;">
							<tr class="trHeader">
								<td>Meeting ID</td><td>Meeting Title</td><td>Completion percentage </td><td>Meeting Datetime</td>
								<td>Meeting Type</td><td>Current Status</td><td>View Meeting</td>
							</tr>	
							@foreach($meeting_lists as $meeting_list)
								<tr>
									<td>{{$meeting_list->meeting_id}}</td>
									<td>{{$meeting_list->meeting_title}}</td>
									<td>{{$meeting_list->completion}}%</td>
									<td>{{$meeting_list->meeting_datetime}}</td>
									<td><?php 
										if($meeting_list->meeting_type == 'firstMeeting')
										{
											echo "First Meeting";
										}
										else
										{
											echo "Follow Up Meeting";
										}
										?>
									</td>
									<td>{{$meeting_list->meeting_status}}</td>
									<!-- <td>
										{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}
											{!! Form::hidden('meeting_id', $meeting_list->meeting_id) !!}
							    			{!! Form::submit('EDIT',array('class'=>'btn')) !!}
										{!! Form::close() !!}
									</td> -->
									<td>
										<input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$meeting_list->meeting_id}}&mother_meeting_id={{$meeting_list->mother_meeting_id}}';" style="color:#fff;" class="btn" value="View" />	
									</td>
								</tr>
							@endforeach
						</table>
					</div>
					<div class="col-md-4">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
@endsection
