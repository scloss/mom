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
		<!--<script src="{{ asset('/js/exitAlert.js') }}"></script>-->
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>
		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
		<script type="text/javascript" src="{{ asset('/js/test.js?v=1') }}"></script>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		
	 
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<style>
			body
		{
			
			/*font-family: 'Gill Sans', 'Gill Sans MT', Calibri, sans-serif !important;*/
		}
		.submit_button
		{
			float:right;
		}

		table.DisableTable td{
			border: 1px solid #A3A3A3!important;
			color:#000 !important;
			font-weight:normal;
		}
		table.momTable tr:nth-child(odd) {
	      background-color: #f1f1f1;
	    }
	    table.momTable tr:nth-child(even) {
	      background-color: #ffffff;
	    } 
		</style>
		<script >
		$( document ).ready(function() {
		    $(function() {
		    $( "#meeting_attendee_select" ).autocomplete({
		      source: 'testSearch'
		    });
		  });
		    $(function() {
		    $( "#mail_recipient_select" ).autocomplete({
		      source: 'testSearch'
		    });
		  });
		    $(function() {
		    	
		    $( "#attendee_dept_select" ).autocomplete({
		      source: 'testSearchDeptEmailAuto'
		    });
		  });
		});

		// function printTest() {
		//     //
		//     ('#meetingDiv').printElement();
		//     window.print();
		// }
		function printTest(divName,divTitle) {
			alert(divName);

	       var printContents = document.getElementById(divName).innerHTML;
	       var printContents1 = document.getElementById(divTitle).innerHTML;       
		   var originalContents = document.body.innerHTML;  
		   document.body.innerHTML = printContents1+ printContents;       
		        
		   window.print();      
		   document.body.innerHTML = originalContents;
	   }
	   	

		  
 		</script>
	</head>
	<body>
		<div id="titleBar" style="text-align:center;">
			<h4>CREATE MOM</h4>
		</div>
		<div class="container-fluid">
			<div class="content">
				<form action="{{ url('entry') }}" id="meetingForm" method="post" enctype="multipart/form-data" >
				<!-- {!! Form::open(array('url' => 'entry','class'=>'meetingForm','id' => 'meetingForm','novalidate' => 'novalidate','files' => true)) !!} -->

					<div id="formDiv" >
						<div id="meetingDiv">
							<!-- <h5>
								<span>Meeting Title:	</span><i>{!! Form::text('meeting_title') !!}</i>
							</h5>
							<h5>
								<span>Meeting DateTime: </span>
		        				<i><input type="Text" name="meeting_datetime" id="meeting_datetime" maxlength="25" size="25" />
		        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></i>
							</h5>
							<h5 style="width:900px !important;">
								<span>Meeting Attendee select:</span><i>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select')) !!}</i><input type="button" onclick="addAttendee()" id="attendeeAdd" value=">>"  tabindex="1" style="float:left;margin-left:15px;margin-right:18px;padding-left:20px;"><span>Meeting Attendee: </span><i>{!! Form::text('meeting_attendee','',array('class'=>'demoClass','id'=>'meeting_attendee')) !!}</i>
							</h5>
							<h5>
								<span>Mail Recipient: </span>
								<i>{!! Form::text('mail_recipient','',array('class'=>'demoClass','id'=>'mail_recipient')) !!}</i>

							</h5>
							<h5>
								<span>Meeting type : </span><i>{!! Form::select('meeting_type', $meeting_type_drop,'firstMeeting') !!}	</i>
								<!-- Meeting type : {!! Form::text('meeting_type') !!} -->
							<!-- </h5>
							<h5>
								<span>Meeting status :</span> <i>{!! Form::select('meeting_status', $meeting_status_drop,'active') !!}</i>	
							</h5>
							<h5 style="height:84px !important;">
								<span style="margin-top: -9px !important;height: 84px !important;">Meeting Decision : </span> 
								<i>
									<textarea name="meeting_decision" rows="4" cols="35" style="margin-left:10px;"></textarea>
								</i>
							</h5>
							<h5 style="height:84px !important;">
								<span style="margin-top: -9px !important;height: 84px !important;">Meeting Comment : </span> 
								<i>
									<textarea name="meeting_comment" rows="4" cols="35" style="margin-left:10px;"></textarea>
								</i>
							</h5> -->
							<table class="meetingTable">
								<tr>
									<td id="title_td">Meeting Title:</td><td>{!! Form::text('meeting_title','',array('class'=>'demoClass','id'=>'meeting_title','required')) !!}</td>
								</tr>
								<tr>
									<td id="title_td">Meeting DateTime:</td> 
			        				<td><input type="Text" name="meeting_datetime" id="meeting_datetime"  maxlength="25" size="25" readonly style="margin-left:18px;" />
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer;"/></td>
								</tr>
								<tr>
									<td id="title_td">Meeting Attendee select:</td>
									<td>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select')) !!}</td>
									<td style="width:100px;">
										<div >
											<input type="button" class="btnArrow" onclick="addAttendee()" id="attendeeAdd" value=">>"  tabindex="1" ><br>
											<input type="button" class="btnArrow" onclick="deleteAttendee()" id="attendeeDelete" value="<<">
										</div>
									</td>
									<td>
										<select id="meeting_attendee_index[]" name="meeting_attendee_index[]" multiple style="height:60px !important;width:380px;">
									   
										</select>*
									</td>
								</tr>
								<tr>
									<td id="title_td">Mail Recipient select:</td>
									<td>{!! Form::text('mail_recipient_select','',array('class'=>'demoClass','id'=>'mail_recipient_select')) !!}</td>
									<td style="width:100px;">
										<div >
											<input type="button" class="btnArrow" onclick="addRecipient()" id="recipientAdd" value=">>"  tabindex="1" ><br>
											<input type="button" class="btnArrow" onclick="deleteRecipient()" id="recipientDelete" value="<<"  tabindex="1" >
										</div>
									</td>
									<td>
										<select id="mail_recipient_index[]" name="mail_recipient_index[]" multiple style="height:60px !important;width:380px;">
									   
										</select>*
									</td>
								</tr>	

								<tr>
									<td id="title_td">Attendee Department:</td>
									<td>{!! Form::text('attendee_dept_select','',array('class'=>'demoClass1','id'=>'attendee_dept_select')) !!}</td>
									<td style="width:100px;">
										<div >
											<input type="button" class="btnArrow" onclick="addDept()" id="deptAdd" value=">>"  tabindex="1" ><br>
											<input type="button" class="btnArrow" onclick="deleteDept()" id="deptDelete" value="<<"  tabindex="1" >
										</div>
									</td>
									<td>
										<select id="attendee_dept_index[]" name="attendee_dept_index[]" multiple style="height:60px !important;width:380px;">
									   
										</select>*
									</td>
								</tr>								
								
								<tr>
									<td id="title_td">Meeting type :</td>
									<td>{!! Form::select('meeting_type', $meeting_type_drop) !!}</td>
									<td>Meeting Schedule</td>	
									<td>
										<center>
											<select id="meeting_schedule_type" name="meeting_schedule_type">
												<option value="AD-HOC">AD-HOC</option>
												<option value="Weekly">Weekly</option>
												<option value="Monthly">Monthly</option>
												<option value="Bi-Weekly">Bi-Weekly</option>
											</select>
										</center>
									</td>
								</tr>
								<tr>
									<td id="title_td">Meeting status :</td> 
									<td>{!! Form::select('meeting_status', $meeting_status_drop) !!}</td>
									<td id="title_td">Attach File:</td>
									<td>
										<input type="file" name="meeting_files[]" id="meeting_files" multiple="multiple" >
									</td>
								</tr>

								<tr>
								<td id="title_td">Decision & Discussion : </td> 
								<td colspan="3">
									<textarea name="meeting_decision" rows="6" cols="100" style="margin-left:10px;margin-right:12px;" ></textarea>
								</td>
								</tr>
								<!-- <tr>
									<td>Meeting Comment : </td> 
									<td>
										<textarea name="meeting_comment" rows="3" cols="35" style="margin-left:10px;"></textarea>
									</td>
								</tr> -->
								<input type="hidden" name="meeting_comment">
								<tr>
									
								</tr>
								
							</table>
							
						</div>
			
					</div>
					<input type="hidden" value="{{csrf_token()}}" name="_token">
					
					
					<!-- <input type="button" onclick="fileAdd()" class="add" value="Add File" id="add_File" style="float:right;" > -->
					<!-- <input type="file" name="meeting_files" id="meeting_files"> -->
					<table id="buttonBox">
						<tr>
							<td>
								<input type="button" onclick='validateMom()'  class="btn" value="Create" id="submitMomBtn" style="float:left;margin-right:2px;font-weight:bold;color:#fff;" >
								<input type="button" onclick="createMom()" class="btn" value="Add Action Point" id="createMomBtn" style="float:left;margin-right:2px;color:#fff;" >	
							</td>
						</tr>
					</table>
					
				</form>
				
			</div>
		</div>
		<!-- {!! Form::open(array('url' => 'testMail', 'method' => 'GET')) !!}
				{!! Form::submit('mail',array('class'=>'submit_button')); !!}
		{!! Form::close() !!} -->
				<!-- <input type="button" onclick='printTest("formDiv","titleBar")' class="add" value="Print" > -->
	</body>
</html>
@endsection