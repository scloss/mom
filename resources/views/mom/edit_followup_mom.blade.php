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
			color:#000 !important;
		}
		.disabledLook{
			background-color:#E4DEDE;
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
        </script>
	</head>
	<body>
		<div id="titleBar">
			<h4>CREATE FOLLOW UP MOM</h4>
		</div>
		<div class="container-fluid">
			<div class="content">
				
				<form action="{{ url('entry') }}" id="meetingForm" method="post" enctype="multipart/form-data">
<!-- 				{!! Form::open(array('url' => 'entry','class'=>'meetingForm','id' => 'meetingForm')) !!} -->
					{!! Form::hidden('mother_meeting_id', $mother_meeting_id) !!}
					@foreach($meeting_table_lists as $meeting_table_list)
					<div id="formDiv">
						<div id="meetingDiv">
							<!-- {!! Form::hidden('meeting_id', $meeting_table_list->meeting_id) !!}
							<h5>
								<span>Meeting Title:</span>	<i>{!! Form::text('meeting_title','Follow UP: '.$meeting_table_list->meeting_title) !!}</i>
							</h5>
							<h5>
								<span>Meeting DateTime: </span>
		        				<i><input type="Text" name="meeting_datetime" id="meeting_datetime" value="{{$meeting_table_list->meeting_datetime}}" maxlength="25" size="25"/>
		        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></i>
							</h5>
							<h5 style="width:900px !important;">
								<span>Meeting Attendee select:</span><i>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select')) !!}</i><input type="button" onclick="addAttendee()" id="attendeeAdd" value=">>"  tabindex="1" style="float:left;margin-left:15px;margin-right:18px;padding-left:20px;"><span>Meeting Attendee: </span><i>{!! Form::text('meeting_attendee',$meeting_table_list->meeting_attendee,array('class'=>'demoClass','id'=>'meeting_attendee')) !!}</i>
							</h5>
							<h5>
								<span>Mail Recipient: </span><i>{!! Form::text('mail_recipient',$meeting_table_list->mail_recipient,array('class'=>'demoClass','id'=>'mail_recipient')) !!}</i>
							</h5>
							<h5>
								<span>Meeting type :</span> <i>{!! Form::select('meeting_type', $meeting_type_drop,'followUpMeeting') !!}	</i>
							</h5>
							<h5>
								<span>Meeting status :</span><i>{!! Form::select('meeting_status', $meeting_status_drop,$meeting_table_list->meeting_status) !!}</i>
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
							{!! Form::hidden('meeting_id', $meeting_table_list->meeting_id) !!}
							
								<tr>
									<td>Meeting Title:</td><td>{!! Form::text('meeting_title','Follow UP: '.$meeting_table_list->meeting_title) !!}</td>
								</tr>
								<tr>
									<td>Meeting DateTime:</td> 
			        				<td><input type="Text" name="meeting_datetime" readonly id="meeting_datetime" value="{{$meeting_table_list->meeting_datetime}}" readonly maxlength="25" size="25" style="margin-left:17px;"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('meeting_datetime','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>Meeting Attendee select:</td>
									<td>{!! Form::text('meeting_attendee_select','',array('class'=>'demoClass','id'=>'meeting_attendee_select')) !!}</td>
									<td style="width:100px;">
										<div>
											<input type="button" class="btnArrow" onclick="addAttendee()" id="attendeeAdd" value=">>"  tabindex="1" ><br>
											<input type="button" class="btnArrow" onclick="deleteAttendee()" id="attendeeDelete" value="<<">
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
								<tr>
									<td>Mail Recipient select:</td>
									<td>{!! Form::text('mail_recipient_select','',array('class'=>'demoClass','id'=>'mail_recipient_select')) !!}</td>
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
								<tr>
										<td>Attendee Department select:</td>
										<td>{!! Form::text('attendee_dept_select','',array('class'=>'demoClass','id'=>'attendee_dept_select')) !!}</td>
										<td style="width:100px;">
											<div >
												<input type="button" class="btnArrow" onclick="addDept()" id="deptAdd" value=">>"  tabindex="1" ><br>
												<input type="button" class="btnArrow" onclick="deleteDept()" id="deptDelete" value="<<"  tabindex="1" >
											</div>	
										</td>
										<td>
											<select id="attendee_dept_index[]" name="attendee_dept_index[]" multiple style="height:60px !important;width:380px;">
										    @for($i=0;$i<count($attendee_dept_arr);$i++)    
								            	<option value="{{$attendee_dept_arr[$i]}}" >{{$attendee_dept_arr[$i]}}</option>       
								            @endfor
											</select>
										</td>
								</tr>
								<tr>
									<td>Meeting type :</td>
									<td>{!! Form::select('meeting_type', $meeting_type_drop,$meeting_table_list->meeting_type) !!}</td>	
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
								            			<option value="{{$meeeting_schedule_type_list[$i]}}" >{{$meeeting_schedule_type_list[$i]}}</option>    
								            		<?php
								            		} ?> 
								            	@endfor
											</select>
										</center>
									</td>
									
								</tr>
								<tr>
									<td>Meeting status :</td> 
									<td>{!! Form::select('meeting_status', $meeting_status_drop,$meeting_table_list->meeting_status) !!}</td>
								</tr>

								<tr>
								<td>Meeting Decision : </td> 
								<td>
									<textarea name="meeting_decision" rows="3" cols="35" style="margin-left:10px;" ><?php echo stripslashes($meeting_table_list->meeting_decision); ?></textarea>
								</td>
								</tr>
								<tr>
									<td>Meeting Comment : </td> 
									<td>
										<textarea name="meeting_comment" rows="3" cols="35" style="margin-left:10px;"></textarea>
									</td>
								</tr>
								<tr>
									<td>Attach File:</td>
									<td>
										<input type="file" name="meeting_files[]" id="meeting_files" multiple="multiple" >
									</td>
								</tr>
								
							</table>	
						</div>

					@endforeach
					<table class="staticUpdateTable">
						<?php $counterPrev = 1; ?>	
						@foreach($mom_open_lists as $mom_open_list)
							<tr>
								<td colspan="7" style="text-align:center;">
							Previous Action Point - 
								<?php echo $counterPrev;
								$static_mom_id_prev ="static_mom_id_prev".$counterPrev; 
								$static_mom_title_prev = "static_mom_title_prev".$counterPrev;
								$static_responsible_prev = "static_responsible_prev".$counterPrev;
								$static_start_time_prev = "static_start_time_prev".$counterPrev;
								$static_end_time_prev = "static_end_time_prev".$counterPrev;
								$static_mom_status_prev = "static_mom_status_prev".$counterPrev;
								$static_mom_completion_status_prev = "static_mom_completion_status_prev".$counterPrev;
								$static_mom_comment_prev = "static_mom_comment_prev".$counterPrev;
								?>
								</td>
							</tr>
							<tr>
								<td>Title</td><td>Responsible</td><td>Start Time</td><td>End Time</td><td>Status</td><td>Completion Status</td><td>Comment</td>
							</tr>
							<tr>
								<td>
									<!-- <input type="text" name="$mom_title_prev" value="$mom_table_list->mom_title"  class="$mom_title_prev" id="$mom_title_prev" readonly> -->
									{!! Form::text($static_mom_title_prev,$mom_open_list->mom_title, array('class'=>'disabledLook','id'=>$static_mom_title_prev,'readonly' => 'true')) !!}
								</td>
								<td>
									{!! Form::textarea($static_responsible_prev,$mom_open_list->responsible, array('class'=>'disabledLook','id'=>$static_responsible_prev,'readonly' => 'true','cols'=>25,'rows'=>'3')) !!}
								</td>
								<td>
		        					<input type="Text" name="<?php echo $static_start_time_prev; ?>" readonly id="<?php echo $static_start_time_prev; ?>" value="{{$mom_open_list->start_time}}" maxlength="25" size="25"  class="disabledLook" />
								</td>
								<td>
		        				<input type="Text" name="<?php echo $static_end_time_prev; ?>" readonly id="<?php echo $static_end_time_prev; ?>" value="{{$mom_open_list->end_time}}" maxlength="25" size="25" />
		        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('{{$static_end_time_prev}}','yyyyMMdd','dropdown',true,'24',true);"  style="cursor:pointer"/>
								</td>
								<td>
									{!! Form::select($static_mom_status_prev, $meeting_status_drop,$mom_open_list->mom_status, array('class'=>$static_mom_status_prev,'id'=>$static_mom_status_prev)) !!}
								</td>
								<td>
									{!! Form::select($static_mom_completion_status_prev, $mom_completion_status_drop,$mom_open_list->mom_completion_status, array('class'=>$static_mom_completion_status_prev,'id'=>$static_mom_completion_status_prev)) !!}
								</td>
								<td>
									<textarea  style="color:#000 !important;" name="<?php echo $static_mom_comment_prev; ?>" cols="20" rows="2" id="<?php echo $static_mom_comment_prev; ?>" style="vertical-align:middle;"><?php echo stripslashes($mom_open_list->comment);  ?></textarea>
								</td>

								{!! Form::hidden($static_mom_id_prev, $mom_open_list->mother_mom_id) !!}
								
								<?php $counterPrev = $counterPrev + 1; ?>
							</tr>
						@endforeach
						<input type="hidden" name="count_prev" value="{{$counterPrev}}">

					</table>
					<!-- <table class="updateTable">
					<?php $counter = 1 ?>	
					@foreach($mom_table_lists as $mom_table_list)
						<tr>
							<td colspan="8" style="text-align:center;">
						Action Point - 
							<?php echo $counter;
							$mom_id_prev ="mom_id_prev".$counter; 
							$mom_title_prev = "mom_title_prev".$counter;
							$responsible_prev = "responsible_prev".$counter;
							$start_time_prev = "start_time_prev".$counter;
							$end_time_prev = "end_time_prev".$counter;
							$mom_status_prev = "mom_status_prev".$counter;
							$mom_completion_status_prev = "mom_completion_status_prev".$counter;
							$mom_comment_prev = "mom_comment_prev".$counter;
							?>
							</td>
						</tr>
						<tr>
							<td>Title</td><td>Responsible</td><td>Start Time</td><td>End Time</td><td>Status</td><td>Completion Status</td><td>Comment</td>
							<td>Copy MoM</td>	
						</tr>
						<tr>
							<td>
								{!! Form::text($mom_title_prev,$mom_table_list->mom_title, array('class'=>$mom_title_prev,'id'=>$mom_title_prev,'disabled' => 'disabled')) !!}
							</td>
							<td>
								{!! Form::text($responsible_prev,$mom_table_list->responsible, array('class'=>$responsible_prev,'id'=>$responsible_prev,'disabled' => 'disabled')) !!}
							</td>
							<td>
	        					<input type="Text" name="<?php echo $start_time_prev; ?>" readonly id="<?php echo $start_time_prev; ?>" value="{{$mom_table_list->start_time}}" maxlength="25" size="25" />
	        					<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
							</td>
							<td>
	        				<input type="Text" name="<?php echo $end_time_prev; ?>" readonly id="<?php echo $end_time_prev; ?>" value="{{$mom_table_list->end_time}}" maxlength="25" size="25" />
	        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="" style="cursor:pointer"/>
							</td>
							<td>
								{!! Form::select($mom_status_prev, $meeting_status_drop,$mom_table_list->mom_status, array('class'=>$mom_status_prev,'id'=>$mom_status_prev,'disabled' => 'disabled')) !!}
							</td>
							<td>
								{!! Form::select($mom_completion_status_prev, $mom_completion_status_drop,$mom_table_list->mom_completion_status, array('class'=>$mom_completion_status_prev,'id'=>$mom_completion_status_prev,'disabled' => 'disabled')) !!}
							</td>
							<td>
								<textarea  style="color:#000 !important;" name="<?php echo $mom_comment_prev; ?>" cols="20" rows="2" id="<?php echo $mom_comment_prev; ?>"readonly style="vertical-align:middle;"><?php echo $mom_table_list->comment;  ?></textarea>
							</td>
							<td>
								<input onclick="copyMom(this.id)" type="button" value="copy" id="<?php echo $counter ?>">
							</td>
							{!! Form::hidden($mom_id_prev, $mom_table_list->mom_id) !!}
							
							<?php $counter = $counter + 1; ?>
						</tr>
					@endforeach
				
					
					</table> -->
				</div>
				<input type="hidden" value="{{csrf_token()}}" name="_token">
				<table id="buttonBox">
					<tr>
						<td>
				
						<input type="button" onclick='validateMom()'  class="btn" value="Create" id="submitMomBtn" style="float:left;color:#fff;" >
						<input type="button" onclick="createMom()"  class="btn" value="Add Action Point"  style="color:#fff;">
						</td>
					</tr>
				</table>
				<!-- {!! Form::close() !!} -->
				</form>
				
			</div>
		</div>
	</body>
@endsection	