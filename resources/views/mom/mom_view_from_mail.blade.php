<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'mom_db';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
//$searchTerm = $_GET['term'];
//get matched data from skills table
$id = explode('@', $login_id);
$u_id = '';
if(count($id)==1){
	$u_id = $login_id;
}
else{
	$u_id = $id[0];
}
$sql = "SELECT seen_users FROM mom_db.meeting_table where meeting_id=".$_GET['meeting_id'].";";
$result = mysqli_query($db, $sql);
$is_seen_before = false;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    	$seen_users_arr =  explode(",",$row["seen_users"]);
		for($i=0;$i<count($seen_users_arr);$i++){
			if($seen_users_arr[$i] == $id[0]){
				$is_seen_before = true;
			}
		}
        //echo "id: " . $row["seen_users"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
}

if($is_seen_before == false){
	$db->query("UPDATE mom_db.meeting_table SET seen_users=CONCAT(',".$id[0]."',seen_users) where meeting_id=".$_GET['meeting_id'].";");
}


//return json data
//echo json_encode($data);
?>
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
		
		<style>
			
		#commentArea
		{
			margin-top:2px !important;
			padding-top:2px;
		}
		table#tableMeeting
		{
			width:1280px;
		}
		table.updateTable
		{
			margin-top:2%;
			font-size:18px !important;
			width:1280px;
		}
		table.updateTable td
		{
			border: 1px solid #A3A3A3!important;
		    padding: 5px !important;
		    /*background-color:#F0F5F9 ;*/
		    font-weight:normal;
		    color:#000;
		    text-transform: capitalize;

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
		#redBox
		{
			background-color:#FF9C9C !important;
		}
		#greenBox
		{
			background-color:#ABFF9C !important;
		}
		#yellowBox
		{
			background-color:#FDFF80 !important;
		}
		/*table.updateTable td
		{
			background-color:#949286 !important;
			width:200px;
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
		}*/

		
		</style>
		<script type="text/javascript">
		function printTest(divName,divTitle) {
			//alert(divName);

	       var printContents = document.getElementById(divName).innerHTML;
	       var printContentsTableMeeting = document.getElementById("tableMeeting");
	       var printContents1 = document.getElementById(divTitle).innerHTML;     
	        //var divToPrint = document.getElementById('tableMeeting');
		    var htmlToPrint = '' +
		        '<style type="text/css">' +
		        'h4{text-align:center;margin-top:5%;}'+
		        'table{width:980;}' +
		        'table,table td{' +
		        'border:1px solid #000;' +
		        'border-collapse: collapse;'+
				'overflow:auto;'+
				'word-wrap:break-word;'+
				'margin-top:5%;'+
				'text-align:center;'+
				'page-break-inside:avoid; page-break-after:auto;'+
		        '}' +
		        '</style>';
		    //htmlToPrint += printContents.outerHTML;
		    newWin = window.open("");

		    newWin.document.write(printContents1);
		    newWin.document.write(htmlToPrint);
		    newWin.document.write(printContents);
		    
		    newWin.print();
		    newWin.close();
		   // var originalContents = document.body.innerHTML;  
		   // document.body.innerHTML = printContents1+ printContents+printContentsTableMeeting;       
		        
		   // window.print();      
		   // document.body.innerHTML = originalContents;
	   }
        </script>
	</head>
	<body>
	<center>
		<div id="titleBar" style="height:52px;">
			<h4 style="margin-top:20px;">MOM VIEW</h4>
		</div>

		<div class="container-fluid">
			<div class="content">
				
	
				
					@foreach($meeting_table_lists as $meeting_table_list)
					<?php 
						$meeting_files = $meeting_table_list->meeting_files;
					?>
					<div id="formDiv">
						<table id="tableMeeting" class="meetingTable" >
							<tr>
								<td colspan="4">MoM published by <b>{{$org_info}}</b></td>
							</tr>
							<tr id="blueTableRow">
								<td>Meeting Title </td><td>Meeting DateTime</td><td>Meeting Attendee </td><td>Mail Recipient</td>
							</tr>
							<tr>
								<td>{{$meeting_table_list->meeting_title}}</td>
							
								<td>{{$meeting_table_list->meeting_datetime}}</td>
							
								<td >
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
							
								<td >
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
							<tr id="blueTableRow">
								<td>Meeting type</td><td>Meeting status</td><td>Initiator Department</td><td>Schedule Type</td>
							</tr>
							<tr>	
								<td>{{$meeting_table_list->meeting_type}}</td>
							
								<td>{{$meeting_table_list->meeting_status}}</td>
								<td>{{$meeting_table_list->initiator_dept}}</td>
								<td>{{$meeting_table_list->meeting_schedule_type}}</td>
							</tr>
						</table>
						<table id="tableMeeting" class="meetingTable">
							<tr id="blueTableRow"><td>Meeting Decision</td></tr>
							<tr><td style="text-align:justify;">
									<?php echo stripslashes(stripslashes($meeting_table_list->meeting_decision)); ?>
								</td></tr>
						</table>
					@endforeach
					<table class="updateTable">

					
					<?php $counter = 1 ; $counter_res = 0;?>
					@foreach($mom_table_lists as $mom_table_list)
						<tr>
							<td colspan="8" style="text-align:center;">
								Action Point- 
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
							<td>Title</td><td>Responsible</td><td>Start Time</td><td>End Time</td><td>Status</td><td>Completion Status</td><td>Completion Time</td>
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
									//echo $mail_res[$i].'<br/>'; 
					
									$tempResponsible = $mail_res[$i];
									$tempResponsible = explode('@', $tempResponsible);
									echo $tempResponsible[0].'<br/>';
										// echo $mom_responsible_arr[$i].'<br/>';

									
								}
								?>

								<!-- {{$mom_table_list->responsible}} -->
							</td>
							<td>
								{{$mom_table_list->start_time}}
							</td>
							<td>
								{{$mom_table_list->end_time}}
							</td>
							<?php $matchStr = $u_id; ?>
								<?php if (preg_match("/$matchStr/i",$mom_table_list->responsible)){?>
									@if($mom_table_list->mom_completion_status == '0-50')
										<?php $headerId = 'redBox'; ?> 
									@endif
									@if($mom_table_list->mom_completion_status == '50-80')
										<?php $headerId = 'yellowBox'; ?>
									@endif
									@if($mom_table_list->mom_completion_status == '80-100')
										<?php $headerId = 'greenBox'; ?>
									@endif
									<td id="{{$headerId}}" style="text-transform: capitalize;">
										{{$mom_table_list->mom_status}}
									</td>
									<td id="{{$headerId}}">
										{{$mom_table_list->mom_completion_status}}
									</td>
									<td id="{{$headerId}}">
										{{$mom_table_list->mom_completion_time}}
									</td>
									
									<td id="{{$headerId}}" style="text-align:justify;white-space: pre-line">
										{{$mom_table_list->comment}}
									</td>
							<?php }
								else{ ?>		
									<td style="text-transform: capitalize;">
										{{$mom_table_list->mom_status}}
									</td>
									<td>
										{{$mom_table_list->mom_completion_status}}
									</td>
									<td>
										{{$mom_table_list->mom_completion_time}}
									</td>
									
									<td style="text-align:justify;white-space: pre-line">
										<?php echo stripslashes($mom_table_list->comment); ?>
									</td>
							<?php } ?>							
						<?php $counter = $counter + 1; ?>
						</tr>
					@endforeach
					</table>
				</div>
				
			</div>
			<input type="button" onclick='printTest("formDiv","titleBar")' class="btn" value="Print" >
			@if($meeting_files == true)
			 	<input type="button" onclick="location.href='{{URL('downloadZip?meeting_id='.$meeting_id)}}';" class="btn" value="Download Meeting Files" />		
			@endif
			<input type="button" onclick="location.href='{{URL('/landing')}}';" class="btn" value="Go to Login" />	
			<p>Your Response is sent to the Organizer</p>
		</div>
</center>
	</body>
