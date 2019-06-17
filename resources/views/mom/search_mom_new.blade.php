<?php $App = 'app' ?>
<?php
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
		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>
		
		<style>
		#meetingDiv input[type="text"] {
				padding: 0px !important;
			    height: 28px !important;
			    margin-top: 0px !important;
			    margin-left: 17px !important;
			    font-weight: normal;
			    width: 85% !important;
			}
		#advancedSearchBtn{
			cursor:pointer;
			padding:10px !important;
		}	
		#normalSearchBtn{
			cursor:pointer;
			padding:10px !important;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#formDiv").hide();
			$("#normalSearchBtn").css("background-color", "#E8BE40");
			$("#advancedSearchBtn").click(function(){
			    $("#formDivAll").hide("slow");
			    $("#formDiv").show("slow");
			    $("#advancedSearchBtn").css("background-color", "#E8BE40");
			    $("#normalSearchBtn").css("background-color", "#F0F5F9");
			});
			$("#normalSearchBtn").click(function(){
			    $("#formDiv").hide("slow");
			    $("#formDivAll").show("slow");
			    $("#normalSearchBtn").css("background-color", "#E8BE40");
			    $("#advancedSearchBtn").css("background-color", "#F0F5F9");
			});
			
		});
        </script>
	</head>
	<body>
		<div id="titleBar">
			<h4>MOM SEARCH</h4>
		</div>

		<div class="container-fluid" style="min-height:457px;">
			<div class="content">
					<center>
						<table class="meetingTable">
							<tr><td id="advancedSearchBtn">Advanced Search</button></td><td id="normalSearchBtn">Normal Search</button></td></tr>
						</table>
					</center>
					<center>
					<div id="formDiv" class="col-md-12">
						{!! Form::open(array('url' => 'searchProcess', 'method' => 'GET')) !!}
						<div id="meetingDiv" class="col-md-6">
							<table class="meetingTable">
								<tr>
									<td>Meeting Title:	</td><td>{!! Form::text('search_meeting_title','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
<!-- 								<tr style="background-color:#D6D6D8;">
									<td colspan='2'>Search Between Two Meeting Dates</td>
								</tr> -->
								<tr>
									<td>Meeting Time From: </td>
			        				<td><input type="Text" name="meeting_datetime1" id="meeting_datetime1" value="{{$current_date}}" class="w3-input w3-border" readonly maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime1','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>Meeting Time To: </td>
			        				<td><input type="Text" name="meeting_datetime2" id="meeting_datetime2" value="{{$current_date}}" class="w3-input w3-border" readonly maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime2','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>Meeting Attendee: </td><td>{!! Form::text('search_meeting_attendee','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<tr>
									<td>Mail Recipient: </td><td>{!! Form::text('search_mail_recipient','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<tr>
									<td>Meeting type : </td><td>{!! Form::text('search_meeting_type','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<tr>
									<td>Meeting status :</td> <td>{!! Form::text('search_meeting_status','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<tr>
									<td colspan='2' style="text-align:right;"><b>View Mode  :  </b>Meeting {!! Form::radio('viewMode', 'meetingView', true) !!} Action Point {!! Form::radio('viewMode', 'momView') !!}<br>{!! Form::submit('search' , array('class'=>'editBtn')); !!}</td>
								</tr>
								
							</table>
							</div>	
							<div id="meetingDiv" class="col-md-6">
							<table class="meetingTable">
								<tr>
									<td>MoM Title:	</td><td>{!! Form::text('search_mom_title','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<tr>
									<td>Responsible: </td><td> {!! Form::text('search_responsible','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<!-- <tr style="background-color:#D6D6D8;">
									<td colspan='2'>
									Search Between Two MoM Start Dates
									</td>
								</tr> -->
								<tr>
									<td>MoM Start Time From: </td>
			        				<td><input type="Text" name="search_mom_start_time1" id="search_mom_start_time1" class="w3-input w3-border" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_start_time1','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>MoM Start Time To: </td>
			        				<td><input type="Text" name="search_mom_start_time2" id="search_mom_start_time2" class="w3-input w3-border" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_start_time2','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<!-- <tr style="background-color:#D6D6D8;">
									<td colspan='2'>
									Search Between Two MoM End Dates
									</td>
								</tr> -->
								<tr>
									<td>MoM End Time From: </td>
			        				<td><input type="Text" name="search_mom_end_time1" id="search_mom_end_time1" class="w3-input w3-border" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_end_time1','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>MoM End Time To: </td>
			        				<td><input type="Text" name="search_mom_end_time2" id="search_mom_end_time2" class="w3-input w3-border" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_end_time2','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>MoM Status:</td><td>{!! Form::text('search_mom_status','',array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
							</table>
						</div>
						{!! Form::close() !!}
					</div>
					</center>
				<div id="formDivAll" class="col-md-12">
					{!! Form::open(array('url' => 'searchProcessAll', 'method' => 'GET')) !!}
					<center>
						<table class="meetingTable">
							<tr><td>Search</td><td><input type="Text" name="searchAll"/></td><td>{!! Form::submit('search' , array('class'=>'btn')); !!}</td></tr>
						</table>
					</center>
					{!! Form::close() !!}
				</div>		
				
				
			</div>
		</div>
		
	</body>
</html>
@endsection