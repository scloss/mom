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
		<script type="text/javascript" src="{{ asset('/js/test.js') }}"></script>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	 
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<style>
			
		#commentArea
		{
			margin-top:2px !important;
			padding-top:2px;
		}
		table.updateTable
		{
			margin-top:2%;
			font-size:16px !important;
		}
		table.updateTable td
		{
			border: 1px solid #A3A3A3!important;
		    border-radius: 5px !important;
		    padding: 5px !important;
		    /*background-color:#F0F5F9 ;*/
		    font-weight:normal;
		    color:#000;

		}
		table.updateTable td input[type="text"]
		{

			color:#000 !important;
		}
		table.updateTable select
		{

			color:#000 !important;
		}
		table.updateTable input[type="textarea"]
		{

			color:#000 !important;
		}
		/*table.meetingTable td
		{
			border: 2px solid #fff!important;
		    border-radius: 5px !important;
		    padding: 5px !important;
		    font-weight:normal;
		    color:#fff;
			background-color:#D6D4D4;
		}
		table.meetingTable td{

			color:#000 !important;
		}*/
		table.DisableTable td{
			border: 1px solid #D4CDCD!important;
		    border-radius: 5px !important;
		    padding: 5px !important;
		    /*background-color:#F0F5F9 ;*/
		    font-weight:normal;
		    color:#000;
			/*border: 2px solid #fff!important;
		    border-radius: 5px !important;
		    padding: 5px !important;
		    font-weight:normal;
			color:#000 !important;*/
		}
		#commentBox
		{
			margin-left: 507px !important;
    		margin-top: -391px !important;
		}
		#DisableHeader td
		{
			border-radius:0px !important;
		}
		#DisableHeader td input[type="text"]
		{
			background-color:#D4CDCD !important;
			/*width:88% !important;*/
		}
		#DisableHeader input[type="textarea"]
		{
			background-color:#D4CDCD !important;
		}
		#DisableHeader td select
		{
			background-color:#D4CDCD !important;
		}
		#EnableHeader
		{
			background-color:#8DCAA2 !important;
		}
		#redBox
		{
			background-color:#FBE4D5 !important;
		}
		#greenBox
		{
			background-color:#E2EFD9 !important;
		}
		#yellowBox
		{
			background-color:#FFF2CC !important;
		}
		.modal-content {
		    /*width:180% !important;
		    float: left;
   			margin-left: -50%;
*/		}
		#myModal{
			float:left;
		}
		.modal-dialog{
		    position: relative;
		    display: table;
		    overflow-y: auto;    
		    overflow-x: auto;
		    /*width: auto;*/
		    /*min-width: 300px; */
		    width:60% !important;
		    height:400px !important;  
		}
		
		</style>
		<script type="text/javascript">
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
		var emailValues='';
		function emailfunction(id,value){
		  
		  
		  if(value == 'add'){
		  	document.getElementById(id).style.backgroundColor = "#3cb0fd";
		  	document.getElementById(id).style.color = "#fff";
		  	//emailValues += id+',';
		  	var checkList = document.getElementById("checkList");
		  	$(checkList).append('<option value="'+id+'">'+id+'</option>');
		  }
		  if(value == 'submit'){
		  	$('#checkList option').each(function() { 
		  		emailValues += $(this).text()+',';
			});
		  	emailValues = emailValues.slice(0,-1);
		  	document.getElementById("to_list").value = emailValues;
		  	//alert(emailValues);
		  	document.getElementById("modalForm").submit();
		  }
		  
		    // alert(empname);


		  }
		  function removeResponsible() {
			    var x = document.getElementById("checkList");
			    x.remove(x.selectedIndex);
			}
        </script>
	</head>
	<body>
		<div id="titleBar">
			<h4>MOM EDIT</h4>
		</div>
		<div class="container-fluid">
			<div class="content">

				<div style="margin-top:2%;">
				{!! Form::open(array('url' => 'editFollowUpProcess', 'method' => 'GET')) !!}
				{!! Form::hidden('meeting_id', $meeting_id) !!}
				{!! Form::hidden('mother_meeting_id', $mother_meeting_id) !!}
				{!! Form::submit('Create Follow Up Meeting',array('class'=>'btn')) !!}
				{!! Form::close() !!}
				</div>
				<form action="{{ url('editProcess') }}" id="meetingForm" method="post" enctype="multipart/form-data">
				<!-- {!! Form::open(array('url' => 'editProcess', 'method' => 'GET','class'=>'meetingForm','id' => 'meetingForm')) !!} -->
				
					@foreach($meeting_table_lists as $meeting_table_list)
					<?php 
						$meeting_files = $meeting_table_list->meeting_files;
					?>
					<div id="formDiv">
						<div id="meetingDiv" >
							<table class="meetingTable">
							{!! Form::hidden('meeting_id', $meeting_table_list->meeting_id) !!}
							@if($is_meeting_status_closed == 'closed')
								<table class="DisableTable">
									<tr id="organizerHeader">
										<td>Organizer Name :</td>
										<td>{{$organizer_name}}</td>
										<td>Initiator Department</td>
										<td>{{$initiator_dept}}</td>
									</tr>
									<tr id="DisableHeader">
									<td>Meeting Title:	</td><td>{!! Form::text('meeting_title',$meeting_table_list->meeting_title, array('class'=>'demoClass','readonly')) !!}</td>
									<td>Meeting Schedule</td>	
										<td>
											<center>
												<select id="meeting_schedule_type" name="meeting_schedule_type">
													@for($i=0;$i<count($meeeting_schedule_type_list);$i++)
														<?php if($meeting_table_list->meeting_schedule_type == $meeeting_schedule_type_list[$i]){?>
															<option value="{{$meeeting_schedule_type_list[$i]}}" selected >{{$meeeting_schedule_type_list[$i]}}</option>    
														<?php
														}   
									            		else{ ?>
									            			<option value="{{$meeeting_schedule_type_list[$i]}}" disabled>{{$meeeting_schedule_type_list[$i]}}</option>    
									            		<?php
									            		} ?> 
									            	@endfor
												</select>
											</center>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting DateTime:</td> 
				        				<td><input type="Text" name="meeting_datetime" id="meeting_datetime" value="{{$meeting_table_list->meeting_datetime}}" maxlength="25" size="25" readonly />
				        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
				        				<td>Attach File:</td>
										<td>
											<input type="file" name="meeting_files[]" id="meeting_files" multiple="multiple" disabled >
										</td>
									</tr>
									
									<tr id="DisableHeader">
										<td>Meeting Attendee select:</td>
										<td>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="" id="attendeeAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="attendeeDelete" value="<<">
											</div>	
										</td>
										<td>
											<select id="meeting_attendee_index[]" name="meeting_attendee_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($meeting_attendee_arr);$i++)    
								            	<option value="{{$meeting_attendee_arr[$i]}}">{{$meeting_attendee_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									
									<tr id="DisableHeader">
										<td>Mail Recipient select:</td>
										<td>{!! Form::text('mail_recipient_select','',array('class'=>'demoClass','id'=>'mail_recipient_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="" id="recipientAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="recipientDelete" value="<<"  tabindex="1" >
											</div>	
										</td>
										<td>
											<select id="mail_recipient_index[]" name="mail_recipient_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($mail_recipient_arr);$i++)    
								            	<option value="{{$mail_recipient_arr[$i]}}">{{$mail_recipient_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Attendee Department select:</td>
										<td>{!! Form::text('attendee_dept_select','',array('class'=>'demoClass','id'=>'attendee_dept_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="addDept()" id="deptAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="deleteDept()" id="deptDelete" value="<<"  tabindex="1" >
											</div>	
										</td>
										<td>
											<select id="attendee_dept_index[]" name="attendee_dept_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($attendee_dept_arr);$i++)    
								            	<option value="{{$attendee_dept_arr[$i]}}">{{$attendee_dept_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Attendee Department select:</td>
										<td>{!! Form::text('attendee_dept_select','',array('class'=>'demoClass','id'=>'attendee_dept_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="" id="deptAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="deptDelete" value="<<"  tabindex="1" >
											</div>	
										</td>
										<td>
											<select id="attendee_dept_index[]" name="attendee_dept_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($attendee_dept_arr);$i++)    
								            	<option value="{{$attendee_dept_arr[$i]}}">{{$attendee_dept_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting type :</td> <td>{!! Form::select('meeting_type', $meeting_type_drop,$meeting_table_list->meeting_type, array('class'=>'demoClass','readonly')) !!}</td>	
										{!! Form::hidden('meeting_type', $meeting_table_list->meeting_type) !!}</td>
										<td rowspan="3">Comment<br>Logs</td> 
										<td rowspan="3">
											<textarea rows="8" cols="51" >{{$meeting_table_list->meeting_comment}}</textarea>	
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting status :</td> <td>{!! Form::select('meeting_status', $meeting_status_drop,$meeting_table_list->meeting_status, array('class'=>'demoClass','readonly')) !!}</td>
										{!! Form::hidden('meeting_status', $meeting_table_list->meeting_status) !!}
									</tr>
									<tr id="DisableHeader">
										<td >Meeting Decision : </td> 
										<td>
											<textarea name="meeting_decision" rows="3" cols="35" style="margin-left:10px;" readonly >{{$meeting_table_list->meeting_decision}}</textarea>
										</td>
									</tr>
									<tr>
										<td>Meeting Comment : </td> 
										<td>
											<textarea name="meeting_comment" rows="3" cols="35" style="margin-left:10px;"></textarea>
										</td>
										
									</tr>
									


							@else
								@if($is_organizer == true)
									<tr id="organizerHeader">
										<td>Organizer Name :</td>
										<td>{{$organizer_name}}</td>
										<td>Initiator Department</td>
										<td>{{$initiator_dept}}</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting Title:</td><td>{!! Form::text('meeting_title',$meeting_table_list->meeting_title,array('class'=>'demoClass','readonly')) !!}</td>
										<td>Meeting Schedule</td>	
										<td>
											<center>
												<select id="meeting_schedule_type" name="meeting_schedule_type">
													@for($i=0;$i<count($meeeting_schedule_type_list);$i++)
														<?php if($meeting_table_list->meeting_schedule_type == $meeeting_schedule_type_list[$i]){?>
															<option value="{{$meeeting_schedule_type_list[$i]}}" selected >{{$meeeting_schedule_type_list[$i]}}</option>    
														<?php
														}   
									            		else{ ?>
									            			<option value="{{$meeeting_schedule_type_list[$i]}}" disabled>{{$meeeting_schedule_type_list[$i]}}</option>    
									            		<?php
									            		} ?> 
									            	@endfor
												</select>
											</center>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting DateTime:</td> 
				        				<td><input type="Text" name="meeting_datetime" id="meeting_datetime" value="{{$meeting_table_list->meeting_datetime}}" readonly maxlength="25" size="25" />
				        				<!-- <img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/> --></td>
				        				<td>Attach File:</td>
										<td>
											<input type="file" name="meeting_files[]" id="meeting_files" multiple="multiple" >
										
										@if($meeting_files == true)
										
											<input type="button" onclick="location.href='{{URL('downloadZip?meeting_id='.$meeting_id)}}';" style="color:#fff;float:right;margin-top:-5%;" class="btn" value="Download Meeting Files" />	
										
										</td>
										@endif
									</tr>
									<tr id="DisableHeader">
										<td>Meeting Attendee select:</td>
										<td>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="addAttendee()" id="attendeeAdd" value=">>"  tabindex="1" ><br>
												<input type="button"  class="btnArrow" onclick="deleteAttendee()" id="attendeeDelete" value="<<">
											</div>
										</td>
										<td>
											<select id="meeting_attendee_index[]" name="meeting_attendee_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($meeting_attendee_arr);$i++)    
								            	<option value="{{$meeting_attendee_arr[$i]}}">{{$meeting_attendee_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Mail Recipient select:</td>
										<td>{!! Form::text('mail_recipient_select','',array('class'=>'demoClass','id'=>'mail_recipient_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="addRecipient()" id="recipientAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="deleteRecipient()" id="recipientDelete" value="<<"  tabindex="1" >
											</div>
										</td>
										<td>
											<select id="mail_recipient_index[]" name="mail_recipient_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($mail_recipient_arr);$i++)    
								            	<option value="{{$mail_recipient_arr[$i]}}">{{$mail_recipient_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>								
									<tr id="DisableHeader">
										<td>Attendee Department select:</td>
										<td>{!! Form::text('attendee_dept_select','',array('class'=>'demoClass','id'=>'attendee_dept_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="" id="deptAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="deptDelete" value="<<"  tabindex="1" >
											</div>	
										</td>
										<td>
											<select id="attendee_dept_index[]" name="attendee_dept_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($attendee_dept_arr);$i++)    
								            	<option value="{{$attendee_dept_arr[$i]}}">{{$attendee_dept_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting type :</td>
										<td>
											<select id="meeting_type" name="meeting_type">>
												<option value="{{$meeting_table_list->meeting_type}}">{{$meeting_table_list->meeting_type}}</option>
											</select>
										</td>
										<!-- <td>{!! Form::select('meeting_type', $meeting_type_drop,$meeting_table_list->meeting_type,array('class'=>'demoClass','readonly')) !!}</td>	 -->
										<td rowspan="3">Comment<br>Logs</td> 
										<td rowspan="3">
											<textarea rows="8" cols="51" >{{$meeting_table_list->meeting_comment}}</textarea>	
										</td>
									</tr>
									<tr>
										<td>Meeting status :</td> 
										<td>{!! Form::select('meeting_status', $meeting_status_drop,$meeting_table_list->meeting_status) !!}</td>
									</tr>

									<tr id="DisableHeader">
									<td>Meeting Decision : </td> 
									<td>
										<textarea name="meeting_decision" rows="3" cols="35" style="margin-left:10px;"  >{{$meeting_table_list->meeting_decision}}</textarea>
									</td>
									</tr>
									<tr>
										<td>Meeting Comment : </td> 
										<td>
											<textarea name="meeting_comment" rows="3" cols="35" style="margin-left:10px;"></textarea>
										</td>
										<td>Seen Users</td>
										<td>
											<textarea name="seen_users" rows="3" cols="52" style="margin-left:10px;" readonly width="100%;">{{$meeting_table_list->seen_users}}</textarea>
										</td>
									</tr>
									
									
								</table>		
									
								
								@else
								<table class="DisableTable">
									<tr id="organizerHeader">
										<td>Organizer Name :</td>
										<td>{{$organizer_name}}</td>
										<td>Initiator Department</td>
										<td>{{$initiator_dept}}</td>
									</tr>
									<tr id="DisableHeader">
									<td>Meeting Title:	</td><td>{!! Form::text('meeting_title',$meeting_table_list->meeting_title, array('class'=>'demoClass','readonly')) !!}</td>
									<td>Meeting Schedule</td>	
										<td>
											<center>
												<select id="meeting_schedule_type" name="meeting_schedule_type">
													@for($i=0;$i<count($meeeting_schedule_type_list);$i++)
														<?php if($meeting_table_list->meeting_schedule_type == $meeeting_schedule_type_list[$i]){?>
															<option value="{{$meeeting_schedule_type_list[$i]}}" selected>{{$meeeting_schedule_type_list[$i]}}</option>    
														<?php
														}   
									            		else{ ?>
									            			<option value="{{$meeeting_schedule_type_list[$i]}}" disabled>{{$meeeting_schedule_type_list[$i]}}</option>    
									            		<?php
									            		} ?> 
									            	@endfor
												</select>
											</center>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting DateTime:</td> 
				        				<td><input type="Text" name="meeting_datetime" id="meeting_datetime" value="{{$meeting_table_list->meeting_datetime}}" maxlength="25" size="25" readonly />
				        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting Attendee select:</td>
										<td>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div>
												<input type="button" class="btnArrow" onclick="" id="attendeeAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="attendeeDelete" value="<<">
											</div>
										</td>
										<td>
											<select id="meeting_attendee_index[]" name="meeting_attendee_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($meeting_attendee_arr);$i++)    
								            	<option value="{{$meeting_attendee_arr[$i]}}">{{$meeting_attendee_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									
									<tr id="DisableHeader">
										<td>Mail Recipient select:</td>
										<td>{!! Form::text('mail_recipient_select','',array('class'=>'demoClass','id'=>'mail_recipient_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="" id="recipientAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="recipientDelete" value="<<"  tabindex="1" >
											</div>
										</td>
										<td>
											<select id="mail_recipient_index[]" name="mail_recipient_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($mail_recipient_arr);$i++)    
								            	<option value="{{$mail_recipient_arr[$i]}}">{{$mail_recipient_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Attendee Department select:</td>
										<td>{!! Form::text('attendee_dept_select','',array('class'=>'demoClass','id'=>'attendee_dept_select','readonly')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="" id="deptAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="" id="deptDelete" value="<<"  tabindex="1" >
											</div>	
										</td>
										<td>
											<select id="attendee_dept_index[]" name="attendee_dept_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($attendee_dept_arr);$i++)    
								            	<option value="{{$attendee_dept_arr[$i]}}">{{$attendee_dept_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
									</tr>

									<tr id="DisableHeader">
										<td>Meeting type :</td> <td>{!! Form::select('meeting_type', $meeting_type_drop,$meeting_table_list->meeting_type, array('class'=>'demoClass','disabled')) !!}</td>	
										{!! Form::hidden('meeting_type', $meeting_table_list->meeting_type) !!}</td>
										<td rowspan="3">Comment<br>Logs</td> 
										<td rowspan="3">
											<textarea rows="8" cols="51" >{{$meeting_table_list->meeting_comment}}</textarea>	
										</td>
									</tr>
									<tr id="DisableHeader">
										<td>Meeting status :</td> <td>{!! Form::select('meeting_status', $meeting_status_drop,$meeting_table_list->meeting_status, array('class'=>'demoClass','disabled')) !!}</td>
										{!! Form::hidden('meeting_status', $meeting_table_list->meeting_status) !!}
									</tr>
									<tr id="DisableHeader">
										<td >Meeting Decision : </td> 
										<td>
											<textarea name="meeting_decision" rows="3" cols="35" style="margin-left:10px;" readonly >{{$meeting_table_list->meeting_decision}}</textarea>
										</td>
									</tr>
									<tr>
										<td>Attach File:</td>
										<td>
											<input type="file" name="meeting_files[]" id="meeting_files" multiple="multiple" disabled>
										</td>
										
									</tr>
									@if($lockComment == true)									
										<tr id="DisableHeader">
											<td>Meeting Comment : </td> 
											<td>
												<textarea name="meeting_comment" rows="3" cols="35" style="margin-left:10px;" ></textarea>
											</td>
										</tr>
									@else
										<tr style="height:84px !important;" id="EnableHeader">
											<td >Meeting Comment : </td> 
											<td>
												<textarea name="meeting_comment" rows="3" cols="35" style="margin-left:10px;" ></textarea>
											</td>
										</tr>
									@endif
									
								@endif
							@endif
							</table>
						</div>
					@endforeach
					<table class="updateTable">

					
					<?php $counter = 1 ?>	
					@foreach($mom_table_lists as $mom_table_list)
					<!-- <?php echo $mom_table_list->mom_completion_status; ?> -->
						<tr>
							<td colspan="8">
								<h4 style="font-size:17px;" >Action Point - 
								<?php echo $counter;
								$mom_id ="mom_id".$counter; 
								$mom_title = "mom_title".$counter;
								$responsible = "responsible".$counter;
								$start_time = "start_time".$counter;
								$end_time = "end_time".$counter;
								$mom_status = "mom_status".$counter;
								$mom_completion_status = "mom_completion_status".$counter;
								$mom_comment = "mom_comment".$counter;
								$mom_completion_time = "mom_completion_time".$counter;
								$mom_system_completion_time = "mom_system_completion_time".$counter
								?></h4>
							</td>
						</tr>	
						<tr>
							<td>Title</td><td>Responsible</td><td>Start Time</td><td>End Time</td><td>Status</td><td>Completion Status</td><td>Completion Time</td>
							<td>Comment</td>	
						</tr>
						<tr>
						@if($is_meeting_status_closed == 'closed')
								<td id="DisableHeader" >	
									{!! Form::text($mom_title,$mom_table_list->mom_title, array('class'=>'inputTitle','readonly')) !!}
								</td>
								<td id="DisableHeader" >
									{!! Form::textarea($responsible,$mom_table_list->responsible, array('class'=>'inputTitle','id'=>$responsible,'readonly', 'rows' => 3, 'cols' => 20)) !!}
								</td>
								<td id="DisableHeader">
		        					<input type="Text" name="<?php echo $start_time; ?>" id="<?php echo $start_time; ?>" readonly value="{{$mom_table_list->start_time}}" readonly maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
								</td>
								<td id="DisableHeader">
		        					<input type="Text" name="<?php echo $end_time; ?>" id="<?php echo $end_time; ?>" readonly value="{{$mom_table_list->end_time}}" readonly maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
								</td>
								<?php $matchStr = $_SESSION['email']; ?>
							<td id="DisableHeader">
									{!! Form::select('mom_status_select', $meeting_status_drop,$mom_table_list->mom_status, array('class'=>'demoClass','disabled')) !!}
									{!! Form::hidden($mom_status, $mom_table_list->mom_status) !!}
									</td>
									<td id="DisableHeader">
									{!! Form::select($mom_completion_status, $mom_completion_status_drop,$mom_table_list->mom_completion_status, array('class'=>'demoClass','disabled')) !!}
									{!! Form::hidden($mom_completion_status, $mom_table_list->mom_completion_status) !!}
									</td>
									<td id="DisableHeader">
			        					<input type="Text" name="<?php echo $mom_completion_time; ?>" id="<?php echo $mom_completion_time; ?>"  readonly value="{{$mom_table_list->mom_completion_time}}" maxlength="25" size="25" />
			        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
									</td>
									
									<td id="DisableHeader">
										<textarea name="<?php echo $mom_comment; ?>" readonly cols="20" rows="2" id="commentArea" style="vertical-align:middle;color:#000 !important;background:#D4CDCD !important;"><?php echo $mom_table_list->comment; ?></textarea>
									</td>	

						@else
							@if($is_organizer == true)
								<td style="input[type="text"]{width:88% !important;} ">	
									{!! Form::text($mom_title,$mom_table_list->mom_title,array('class' => 'inputTitle')) !!}
								</td>
								<td>
									{!! Form::textarea($responsible,$mom_table_list->responsible, array('class'=>'inputTitle','id'=>$responsible, 'rows' => 3, 'cols' => 20)) !!}
								</td>
								<td>
		        					<input type="Text" name="<?php echo $start_time; ?>" id="<?php echo $start_time; ?>" readonly value="{{$mom_table_list->start_time}}" maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
								</td>
								<td>
		        					<input type="Text" name="<?php echo $end_time; ?>" id="<?php echo $end_time; ?>" readonly value="{{$mom_table_list->end_time}}" maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('<?php echo $end_time; ?>','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer;"/>
								</td>

								@if($mom_table_list->mom_completion_status == '0-50')
										<?php $headerId = 'redBox'; ?> 
									@endif
									@if($mom_table_list->mom_completion_status == '50-80')
										<?php $headerId = 'yellowBox'; ?>
									@endif
									@if($mom_table_list->mom_completion_status == '80-100')
										<?php $headerId = 'greenBox'; ?>
									@endif	
								<td id="{{$headerId}}">
									{!! Form::select($mom_status, $meeting_status_drop,$mom_table_list->mom_status) !!}
								</td>
								<td id="{{$headerId}}">
									{!! Form::select($mom_completion_status, $mom_completion_status_drop,$mom_table_list->mom_completion_status) !!}
								</td>
								<td id="{{$headerId}}">
		        					<input type="Text" name="<?php echo $mom_completion_time; ?>" readonly id="<?php echo $mom_completion_time; ?>" value="{{$mom_table_list->mom_completion_time}}" maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('<?php echo $mom_completion_time; ?>','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/>
								</td>
								
								<td id="{{$headerId}}">
									<textarea name="prevComment" cols="25" rows="2" id="commentArea" readonly style="vertical-align:middle;color:#000 !important;background:#D4CDCD !important;"><?php echo $mom_table_list->comment; ?></textarea><br>
										<textarea name="<?php echo $mom_comment; ?>" cols="25" rows="2" id="commentArea" placeholder="Please type new comment here" style="vertical-align:middle;color:#000 !important;"></textarea>
								</td>
								
							@else

								<td id="DisableHeader">	
									{!! Form::text($mom_title,$mom_table_list->mom_title, array('class'=>'inputTitle','readonly')) !!}
								</td>
								<td id="DisableHeader">
									{!! Form::textarea($responsible,$mom_table_list->responsible, array('class'=>'inputTitle','id'=>$responsible,'readonly', 'rows' => 3, 'cols' => 20)) !!}
								</td>
								<td id="DisableHeader">
		        					<input type="Text" name="<?php echo $start_time; ?>" readonly id="<?php echo $start_time; ?>" value="{{$mom_table_list->start_time}}" readonly maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
								</td>
								<td id="DisableHeader">
		        					<input type="Text" name="<?php echo $end_time; ?>" readonly id="<?php echo $end_time; ?>" value="{{$mom_table_list->end_time}}" readonly maxlength="25" size="25" />
		        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
								</td>
								<?php $matchStr = $_SESSION['email']; ?>
								<?php if (strpos($mom_table_list->responsible, $matchStr ) !== false){?>
									@if($mom_table_list->mom_completion_status == '0-50')
										<?php $headerId = 'redBox'; ?> 
									@endif
									@if($mom_table_list->mom_completion_status == '50-80')
										<?php $headerId = 'yellowBox'; ?>
									@endif
									@if($mom_table_list->mom_completion_status == '80-100')
										<?php $headerId = 'greenBox'; ?>
									@endif
									<td id="{{$headerId}}">
									{!! Form::select($mom_status, $meeting_status_drop,$mom_table_list->mom_status) !!}
									</td>
									<td id="{{$headerId}}">
									{!! Form::select($mom_completion_status, $mom_completion_status_drop,$mom_table_list->mom_completion_status) !!}
									</td>
									<td id="{{$headerId}}">
			        					<input type="Text" name="<?php echo $mom_completion_time; ?>" readonly id="<?php echo $mom_completion_time; ?>" value="{{$mom_table_list->mom_completion_time}}" maxlength="25" size="25" />
			        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('<?php echo $mom_completion_time; ?>','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/>
									</td>
									
									<td id="EnableHeader">
										<textarea name="prevComment" cols="20" rows="2" id="commentArea" readonly placeholder="Please type new comment here" style="vertical-align:middle;color:#000 !important;"><?php echo $mom_table_list->comment; ?></textarea>
										<textarea name="<?php echo $mom_comment; ?>" cols="20" rows="2" id="commentArea" style="vertical-align:middle;color:#000 !important;"></textarea>

									</td>
									
								<?php }
								else{ ?>

									<td id="DisableHeader">
									{!! Form::select('mom_status_select', $meeting_status_drop,$mom_table_list->mom_status, array('class'=>'demoClass','disabled')) !!}
									{!! Form::hidden($mom_status, $mom_table_list->mom_status) !!}
									</td>
									<td id="DisableHeader">
									{!! Form::select($mom_completion_status, $mom_completion_status_drop,$mom_table_list->mom_completion_status, array('class'=>'demoClass','disabled')) !!}
									{!! Form::hidden($mom_completion_status, $mom_table_list->mom_completion_status) !!}
									</td>
									<td id="DisableHeader">
			        					<input type="Text" name="<?php echo $mom_completion_time; ?>" id="<?php echo $mom_completion_time; ?>"  readonly value="{{$mom_table_list->mom_completion_time}}" maxlength="25" size="25" />
			        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
									</td>
									
									<td id="DisableHeader">
										<textarea name="<?php echo $mom_comment; ?>" disabled cols="20" rows="2" id="commentArea" style="vertical-align:middle;color:#000 !important;"><?php echo $mom_table_list->comment; ?></textarea>
									</td>
								<?php } ?>
								    


							@endif
						@endif							
						<!--  {!! Form::textarea($mom_comment,$mom_table_list->comment, ['size' => '15x2'],array('class'=>'commentArea')) !!}</h5> -->
						{!! Form::hidden($mom_id, $mom_table_list->mom_id) !!}
						{!! Form::hidden('countMom[]', $counter) !!}
						<?php $counter = $counter + 1; ?>
						</tr>
					@endforeach
					</table>
				</div>
				<table id="buttonBox" style="float:left;">
					<tr>
						<td>
							<input type="button" onclick='validateMom()'  class="btn" value="Update" id="submitMomBtn" style="float:left;margin-top:2%;margin-bottom:2%;color:#fff;" >
						</td>
						<td>
							<a class="btn" data-toggle="modal" data-target="#myModal">RESEND MAIL</a>
						</td>
						<!-- <td>
							<form action="{{ url('testLoading') }}" id="testForm" method="get" enctype="multipart/form-data">
								<button onclick="testLoading()" data-toggle="modal" data-target="#loading">show</button>
								<button onclick="timer()">test</button>
							</form>
							
						</td> -->
					</tr>
				</table>
				<input type="hidden" value="{{csrf_token()}}" name="_token">

				
				
				</form>
				<!-- {!! Form::submit('Update'); !!} -->
				<!-- {!! Form::close() !!} -->
				
			</div>
		</div>
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
										    
										      <!-- Modal content-->
				<div class="modal-content" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Select the persons you want to send mail</h4>
					</div>
					<div class="modal-body" style="height:400px; overflow-y:auto;">
						<div class="container">
							<div class="col-md-6">
								<div>								 
									<table>						
										<?php for($i=0;$i<count($mom_responsible_view_arr);$i++){?>
											<tr>
												<td id="{{$mom_responsible_view_arr[$i]}}" onclick="emailfunction(this.id,'add');" style="border:1px solid grey;padding:10px;cursor:pointer;">
													{{$mom_responsible_view_arr[$i]}}
												</td>
											</tr>
										<?php 
										}?> 									
									</table>								 
								</div>
							</div>
							<div class="col-md-6">
								<form id="modalForm" action="{{ url('modalMailSend') }}"  method="post">
									<input type="hidden" id="from" name="from" value="{{$organizer_id}}">
									<input type="hidden" id="meeting_id" name="meeting_id" value="{{$meeting_id}}">
									<input type="hidden" id="organizer_name" name="organizer_name" value="{{$organizer_name}}">
									<input type="hidden" id="to_list" name="to_list" value="">
								</form>
								<table>
									<tr>
										<td>
											<select id="checkList" name="checkList[]" multiple style="height:220px !important;width:380px;">		   
											</select>
										</td>

									</tr>
									<tr>
										<td>
											<center>
												<button id="submit" onclick="emailfunction(this.id,'submit');">SUBMIT</button>
												<button onclick="removeResponsible()">Remove Selected Person</button>
											</center>
										</td>  
									</tr>
								</table>
							</div>
						</div>				          
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
										      
			</div>
		</div>
	</body>
@endsection	