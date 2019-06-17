<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
    h4{
    	text-align:center;
    }
    table{
    	/*width:300px !important;*/
    	margin-top:1%;
    }
    table td{
    	border:1px solid #000;
        /*border-collapse: collapse;*/
        overflow:auto;
        word-wrap:break-word;
        
        text-align:center;
        /*padding:5px;*/
        font-size: .7em;

        /*display:block;*/
    }
    table tr{
    	/*border:1px solid black !important;*/
    }
    #header_td{
    	background-color:#3A6380;
    	color:#fff;
    	font-weight:bold;
    }
    #blueTableRow td{
    	text-align:center;
    	color:#000;
    	font-weight:bold;
    }    
</style>
<body>
		<center>
<div>
			<div class="content">
				<div class="formDiv">
					@foreach($meeting_table_lists as $meeting_table_list)
					<?php 
						$meeting_files = $meeting_table_list->meeting_files;
					?>
						<table>
							<tr><td colspan="7"><img src="C:\xampp\htdocs\mom\public\images\logo2.png" alt="logo"></td></tr>
							<tr>
								<td colspan="7">MoM published by <b>{{$org_info}}</b></td>
							</tr>
							<tr id="blueTableRow">
								<td colspan="2">Meeting Title </td><td colspan="2">Meeting DateTime</td><td colspan="3">Meeting Attendee </td>
							</tr>
							<tr>
								<td colspan="2">{{$meeting_table_list->meeting_title}}</td>
							
								<td colspan="2">{{$meeting_table_list->meeting_datetime}}</td>
							
								<td style="min-width:500px !important;" colspan="3">
									<?php 
									for($j=0;$j<count($meeting_attendee_arr);$j++)
									{
										$tempAttendee = $meeting_attendee_arr[$j];
										$tempAttendee = explode('|', $tempAttendee);
										echo $tempAttendee[0].'<br/>';
									}
									?>
									<!-- {{$meeting_table_list->meeting_attendee}} -->
								</td>
								
								
							<tr id="blueTableRow">
								<td>Meeting type</td><td>Meeting status</td><td>Initiator Department</td><td>Schedule Type</td><td colspan="3">Attended Department</td>
							</tr>
							<tr>	
								<td style="text-transform: capitalize;">{{$meeting_table_list->meeting_type}}</td>
							
								<td style="text-transform: capitalize;">{{$meeting_table_list->meeting_status}}</td>
								<td>{{$meeting_table_list->initiator_dept}}</td>
								<td>{{$meeting_table_list->meeting_schedule_type}}</td>
								<td style="text-align:left;" colspan="3"><p>{{$meeting_table_list->attendee_dept}}</p></td>
							</tr>
						<!-- </table>
						<table> -->
							<tr id="blueTableRow"><td colspan="4">Meeting Decision</td><td colspan="3">Mail Recipient</td></tr>
							<tr>
								<td style="text-align:justify;" colspan="4">
									{{$meeting_table_list->meeting_decision}}
								</td>
								<td colspan="3">
									<div style="overflow:auto;">
									<?php 
									for($k=0;$k<count($mail_recipient_arr);$k++)
									{
										echo $mail_recipient_arr[$k].'<br/>';
									}
									?>
									</div>
									<!-- {{$meeting_table_list->mail_recipient}} -->
								</td>
							</tr>
						<!-- </table>
						<table> -->
							<!-- <tr><td colspan="3">Attended Department</td></tr>
							<tr><td style="text-align:left;" colspan="3"><pre style="height:50px;overflow-y:auto;font-weight:bold;font-size:1.2em;text-transform:uppercase;">{{$meeting_table_list->attendee_dept}}</pre></td></tr> -->
						<!-- </table> -->
						
					@endforeach
					<!-- <table class="updateTable">	 -->		
					<?php $counter = 1 ; $counter_res = 0;?>	
					@foreach($mom_table_lists as $mom_table_list)
						<tr>
							<td colspan="7" style="text-align:center;color:#000;font-weight:bold;">
								Action Point - 
								<?php echo $counter;
								$mom_id ="mom_id".$counter; 
								$mom_title = "mom_title".$counter;
								$responsible = "responsible".$counter;
								$start_time = "start_time".$counter;
								$end_time = "end_time".$counter;
								$mom_status = "mom_status".$counter;
								$mom_comment = "mom_comment".$counter;
								$mom_completion_time = "mom_completion_time".$counter;
								$mom_system_completion_time = "mom_system_completion_time".$counter
								?>
							</td>
						</tr>	
						<tr id="blueTableRow">
							<td >Title</td><td>Responsible</td><td>Start Time</td><td>End Time</td><td>Status</td><td>Completion Time</td>
							<td>Comment</td>	
						</tr>
						<tr>
						
							<td>	
								{{$mom_table_list->mom_title}}
							</td>
							<td>
								<?php 
								$mail_res =  explode(',', $mom_table_list->responsible);
								for($i=0;$i<count($mail_res); $i++)
								{
									$tempResponsible = $mail_res[$i];
									$tempResponsible = explode('@', $tempResponsible);
									echo $tempResponsible[0].'<br/>';	
								}
								?>
							</td>
							<td>
								{{$mom_table_list->start_time}}
							</td>
							<td>
								{{$mom_table_list->end_time}}
							</td>
							<td style="text-transform: capitalize;">
								{{$mom_table_list->mom_status}}
							</td>
							<td>
								{{$mom_table_list->mom_completion_time}}
							</td>
							
							<td sylte="text-space-collapse:trim-inner;white-space: pre-line">
								{{$mom_table_list->comment}}
							</td>						
						<?php $counter = $counter + 1; ?>
						</tr>
					@endforeach
					</table>
				</div>	
			</div>
		</div>
</center>
	<div style="bottom:0px;position:fixed;text-align:center;">
		<center>
			<p><b>Powered By SCL OSS</b></p>
		</center>
	</div>
</body>
</html>