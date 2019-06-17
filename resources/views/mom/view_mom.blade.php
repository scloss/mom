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
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>
		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
		<!-- <script type="text/javascript" src="{{ asset('/js/jspdf.js') }}"></script> -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
		<script type="text/javascript" src="{{ asset('/js/pdfFromHTML.js') }}"></script>
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
			width:1280px;
		}
		table.updateTable td
		{
			border: 1px solid #a3a3a3!important;
			/*border-radius: 5px !important;*/
			padding: 5px !important;
			font-weight:normal;
			color:#000;
			/*background-color:#F0F5F9;*/
			/*width:200px;*/
			font-size: 16px;
			/*text-transform: capitalize;*/
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
		/*table.meetingTable td
		{
			border: 2px solid #fff!important;
		    border-radius: 5px !important;
		    padding: 5px !important;
		    background-color:#686868  ;
		    font-weight:normal;
		    color:#fff;
			width:200px;
		}*/
		</style>
		<script type="text/javascript">
		var count = 0;
		var totalCount = 0;
		function getMessage(){
			var temp = 0;
			if(count == 0){
				$.ajax({
	               type:'GET',
	               url:'/mom/public/testLoading/'+count,
	               data:'_token = <?php echo csrf_token() ?>',
	               success:function(data){
	                  testFunc(data.count,data.countTotal);
	               }
	            });

			}

         }
         function returnVal(val)
         {
         	count = val;
         }
         function testFunc(countVal,totalCountVal){
         	//alert(totalCountVal);
         	var tempValue = document.getElementById("msg").value;
         	if(tempValue == totalCountVal){

         	}
         	else{
         		$.ajax({
		               type:'GET',
		               url:'/mom/public/testLoading/'+countVal,
		               data:'_token = <?php echo csrf_token() ?>',
		               success:function(data){
		               	  document.getElementById("msg").value = data.count;
		                  //$("#msg").html(data.count);
		                  testFunc(data.count,data.countTotal);
		                  //count = data.count;
		               }
		            });
         	}
			
         }
		function printTest(divName,divTitle) {
			//alert(divName);
			 $(".noExcel").hide(); 
	       var printContents = document.getElementById(divName).innerHTML;
	       var printContentsTableMeeting = document.getElementById("tableMeeting");
	       var printContents1 = document.getElementById(divTitle).innerHTML;     
	        //var divToPrint = document.getElementById('tableMeeting');
		    var htmlToPrint = '' +
		        '<style type="text/css">' +
		        'h4{text-align:center;}'+
		        'table{width:980;}' +
		        'table,table td{' +
		        'border:1px solid #000;' +
		        'font-size:16px !important;' +
		        'border-collapse: collapse;'+
				'overflow:auto;'+
				'word-wrap:break-word;'+
				'margin-top:5%;'+
				'text-align:center;'+
		        '}' +
		        'tr{'+
		        'page-break-inside:avoid; page-break-after:auto;'+
		        '}'+
		        '</style>';
		    //htmlToPrint += printContents.outerHTML;
		    newWin = window.open("");

		    newWin.document.write(printContents1);
		    newWin.document.write(htmlToPrint);
		    newWin.document.write(printContents);
		    
		    newWin.print();
		    newWin.close();
		     $(".noExcel").show(); 
		   // var originalContents = document.body.innerHTML;  
		   // document.body.innerHTML = printContents1+ printContents+printContentsTableMeeting;       
		        
		   // window.print();      
		   // document.body.innerHTML = originalContents;
	   }
	 //   var url;
	 //   var counter = 0;
	 //   setTimeout(timerCount(), 2000);
	 //   	function testLoading(){
	 //   		//
			
	 //   		document.getElementById("testForm").submit();
	   		

			  
	 //   	}
	 //   	function timerCount(){
	 //   		//var counter = "<?php echo $_SESSION['testCount'] ?>";
	 //   		counter++; 
	 //   		//document.getElementById("testInput").value = counter;
	 //   	}
	 //   	function readTextFile(file)
		// {
		//     var rawFile = new XMLHttpRequest();
		//     rawFile.open("GET", file, false);
		//     rawFile.onreadystatechange = function ()
		//     {
		//         if(rawFile.readyState === 4)
		//         {
		//             if(rawFile.status === 200 || rawFile.status == 0)
		//             {
		//                 var allText = rawFile.responseText;
		//                 alert(allText);
		//             }
		//         }
		//     }
		//     rawFile.send(null);
		// }
	 //   	function timer(){
	   		
	 //   		url = 'http://localhost/mom/public/runtimeUpdate/static';

		// 	  var getJSON = function(url) {
		// 	  return new Promise(function(resolve, reject) {
		// 	    var xhr = new XMLHttpRequest();
		// 	    xhr.open('get', url, true);
		// 	    xhr.responseType = 'json';
		// 	    xhr.onload = function() {
		// 	      var status = xhr.status;
		// 	      if (status == 200) {
		// 	        resolve(xhr.response);
		// 	      } else {
		// 	        reject(status);
		// 	      }
		// 	    };
		// 	    xhr.send();
		// 	  });
		// 	};

		// 	getJSON(url).then(function(data) {
		// 		//alert(data);
		// 		document.getElementById("testInput").value = data;
		// 	    // var tempData;
		// 	    // for(var i=0;i<105;i++){
		// 	    //   tempData = data.records[i].dropbox; 
		// 	    //   if(tempData != ''){
		// 	    //     var tempDataArr = tempData.split(",");
		// 	    //     for(var j=0;j<tempDataArr.length;j++){
			          
		// 	    //     }
			        
		// 	    //   }
			      
		// 	    // }

		// 	    //alert(JSON.stringify(data));
		// 	    //tempData = data.records[1].dropbox; 
		// 	    //createAutoButton(tempData,1);
		// 	    //alert(tempData);
		// 	}, function(status) { 
			  
		// 	});
	 //   	}
        </script>
	</head>
	<body id="body_id">
		<div id="titleBar">
			<h4>MOM VIEW</h4>
		</div>
		<center>
		<div id="modal_body" class="container-fluid" style="min-height:417px;">
			<div class="content">
				
	
				<div id="formDiv">
					@foreach($meeting_table_lists as $meeting_table_list)
					<?php 
						$meeting_files = $meeting_table_list->meeting_files;
					?>
						<table id="tableMeeting" class="meetingTable" >
							<tr>
								<td colspan="4">MoM published by <b>{{$org_info}}</b></td>
							</tr>
							<tr id="blueTableRow">
								<td>Meeting Title </td><td>Meeting DateTime</td><td colspan="2">Meeting Attendee </td>
							</tr>
							<tr>
								<td>{{$meeting_table_list->meeting_title}}</td>
							
								<td>{{$meeting_table_list->meeting_datetime}}</td>
							
								<td style="min-width:500px !important;" colspan="2">
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
								<td>Meeting type</td><td>Meeting status</td><td>Initiator Department</td><td>Schedule Type</td>
							</tr>
							<tr>	
								<td style="text-transform: capitalize;">{{$meeting_table_list->meeting_type}}</td>
							
								<td style="text-transform: capitalize;">{{$meeting_table_list->meeting_status}}</td>
								<td>{{$meeting_table_list->initiator_dept}}</td>
								<td>{{$meeting_table_list->meeting_schedule_type}}</td>
							</tr>
						</table>
						<table id="tableMeeting" class="meetingTable">
							<tr id="blueTableRow"><td>Meeting Decision</td><td>Mail Recipient</td></tr>
							<tr>
								<td >
								<div style="text-align:justify;overflow-y:auto;height:150px;min-width:50px;">
									<?php echo stripslashes(stripslashes($meeting_table_list->meeting_decision)); ?>
								</div>	
								</td>
								<td>
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
						</table>
						<table id="tableMeeting" class="meetingTable">
							<tr id="blueTableRow"><td>Attended Department</td></tr>
							<tr><td style="text-align:left;"><p style="font-weight:bold;font-size:1.2em;text-transform:uppercase;word-wrap:break;width:980px;">{{$meeting_table_list->attendee_dept}}</p></td></tr>
						</table>
					@endforeach
					<table class="updateTable">

					
					<?php $counter = 1 ; $counter_res = 0;?>	
					@foreach($mom_table_lists as $mom_table_list)
						<tr>
							<td colspan="9" style="text-align:center;">
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
								$mom_system_completion_time = "mom_system_completion_time".$counter;
								$is_repeated = false;
								?>
								@if(count($repeated_lists)<1)
									
								@else
									@for($j=0;$j<count($repeated_lists);$j++)
									@if($repeated_lists[$j] == $mom_table_list->mom_title)
										<?php $is_repeated = true; ?>
									@endif
									@endfor
									@if($is_repeated == true)
										 (repeated)
									@endif
								@endif
							</td>
						</tr>	
						<tr id="blueTableRow">
							<td>Title</td><td>Responsible</td><td>Start Time</td><td>End Time</td><td>Status</td><td>Completion Status</td><td>Completion Time</td>
							<td>Comment</td><td class="noExcel">Show Thread</td>	
						</tr>
						<tr>
						
							<td>
								{{$mom_table_list->mom_title}}
							</td>
							<td>
								<?php 
								$mail_res =  explode(',', $mom_table_list->responsible);
								//print_r($mom_responsible_arr);// $mom_table_list->responsible;
								// /if($mom_table_list->responsible)
								for($i=0;$i<count($mail_res); $i++)
								{
									//echo $mail_res[$i].'<br/>'; 			
									$tempResponsible = $mail_res[$i];
									$tempResponsible = explode('@', $tempResponsible);
									//echo $tempResponsible[0].'<br/>';
									for($j=0;$j<count($mom_responsible_arr);$j++){
										$tempResArr = explode('(', $mom_responsible_arr[$j]);
										if($tempResArr[0] == $tempResponsible[0]){
											$res_temp = explode('|',$mom_responsible_arr[$j]) ;
											echo $res_temp[0]."<br/>";
										}
										// echo $mom_responsible_arr[$i].'<br/>';
									}									
								}
								// for($i=$counter_res;$i<$count_responsible;$i++)
								// {
								// 	$tempResponsible = $mom_responsible_arr[$i];
								// 	$tempResponsible = explode('@', $tempResponsible);
								// 	echo $tempResponsible[0].'<br/>';
								// 	// echo $mom_responsible_arr[$i].'<br/>';

								// }
								// $counter_res = $i;
								?>
							</td>
							<td>
								{{$mom_table_list->start_time}}
							</td>
							<td>
								{{$mom_table_list->end_time}}
							</td>
							<?php $matchStr = $_SESSION['email']; ?>
								<?php if (preg_match("/$matchStr/i",$mom_table_list->responsible)){ ?>
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
										<?php echo stripslashes($mom_table_list->comment); ?>
									</td>
									<td class="noExcel">
										<input type="button" onclick="location.href='{{ url('followUpAP') }}?mother_mom_id={{$mom_table_list->mother_mom_id}}';" class="btn" value="Show Thread" style="color:#fff !important;"/>
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
									<td class="noExcel">
										<input type="button" onclick="location.href='{{ url('followUpAP') }}?mother_mom_id={{$mom_table_list->mother_mom_id}}';" class="btn" value="Show" style="color:#fff !important;"/>
									</td>
							<?php } ?>						
						<?php $counter = $counter + 1; ?>
						</tr>
					@endforeach
					</table>
				</div>
				
			</div>
		</div>
		

		
		
		</center>
		<div class="container">
			<table id="buttonBox" style="float:left;">
				<tr>
					<td>
						<input type="button" onclick='printTest("formDiv","titleBar")' style="color:#fff;"  class="btn" value="Print" >
					</td>
					<td>
						<input type="button" onclick="location.href='{{ url('pdfDownload') }}?meeting_id={{$meeting_id}}&mother_meeting_id={{$mother_meeting_id}}';" style="color:#fff;"  class="btn" value="PDF"  >
					</td>
					
					@if($meeting_files == true)
					<td>
						<input type="button" onclick="location.href='{{URL('downloadZip?meeting_id='.$meeting_id)}}';" style="color:#fff;" class="btn" value="Download Meeting Files" />
					</td>	
					@endif
					
					
				</tr>
			</table>
			<table id="buttonBox" style="float:right;">
				<tr>
					<td>
						<input type="button" onclick="location.href='{{ url('followUp') }}?mother_meeting_id={{$mother_meeting_id}}';" class="btn"  value="Show Thread" style="color:#fff !important;"/>
					</td>
					<!-- <td>
						<form action="{{ url('testLoading') }}" id="testForm" method="get" enctype="multipart/form-data">
							<button onclick="testLoading()" data-toggle="modal" data-target="#loading">show</button>
							<button onclick="timer()">test</button>
						</form>
						
					</td> -->
				</tr>
			</table>
		</div>	
		<!-- <div class="modal fade" id="loading" role="dialog">
			<div class="modal-dialog">

				<div class="modal-content" >

					<div class="modal-body">
						<input type="text" name="testInput" id="testInput" value="0">
						<!-- <img src="{{asset('/images/loading.gif') }}" width="570px" height="400px" alt="logo"> -->
					</div>
				</div>
			</div>											      
		</div>
		<!--<input type="text" name="msg" id="msg" value="0"> -->
		<!-- <div id = 'msg'>This message will be replaced using Ajax. 
         Click the button to replace the message.</div> -->
	      <?php
	         //echo Form::button('Replace Message',['onClick'=>'getMessage()']);
	      ?>
	</body>
@endsection	