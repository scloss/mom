<?php $App = 'app' ?>
<?php
if(isset($_SESSION["USERTYPE"]))
{
	if($_SESSION["USERTYPE"] == 'admin' || $_SESSION["USERTYPE"] == 'admin')
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
	<title>Dashboard</title>
	<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>

		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
		<!--<script type="text/javascript" src="{{ asset('/js/test.js') }}"></script>-->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	    <script src="{{ asset('/js/jquery.table2excel.js') }}"></script>
	    <style type="text/css">
	    table#dashboardHeaderTable{
	    	border:1px solid black;
	    }
	    table#dashboardHeaderTable {
		    border-collapse: collapse;
		    width: 70%;
		    margin-top:2%;
		}

		th, td {
		    text-align: left;
		    padding: 5px;
		    border:1px solid grey;
		    text-align: center;
		}
		tr:nth-child(odd){
			background-color:#fff;
		}
		tr:nth-child(even){background-color: #f2f2f2 !important;}

		th {
		    background-color: #4CAF50 !important;
		    color: white;
		}
	    </style>
	    <script type="text/javascript">
	    function exportExcel(){
	    	$("#test").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "excelFile",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
	    }
	    $(function() {
		    $('.date-picker').datepicker( {
		        changeMonth: true,
		        changeYear: true,
		        showButtonPanel: true,
		        dateFormat: 'yy',
		        onClose: function(dateText, inst) { 
		            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
		        }
		    });
		    $('.date-picker1').datepicker( {
		        changeMonth: true,
		        changeYear: true,
		        showButtonPanel: true,
		        dateFormat: 'yy',
		        onClose: function(dateText, inst) { 
		            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
		        }
		    });
		    
		});	

	    </script>
</head>
<body>
	<div id="titleBar" style="text-align:center;">
		<h4>MOM DASHBOARD</h4>
	</div>
	<center>
	<div class="container-fluid">
		<div class="content">
			<table id="dashboardHeaderTable">
				{!! Form::open(array('url' => 'dashboard', 'method' => 'GET')) !!}
				<tr><td><b>MEETING SCHEDULE TYPE</b></td>
					<td>
						<center>
							<select id="meeting_schedule_type" name="meeting_schedule_type">
								@for($i=0;$i<count($meeting_schedule_type_list);$i++)
									<?php if($meeting_schedule_type == $meeting_schedule_type_list[$i]){?>
										<option value="{{$meeting_schedule_type_list[$i]}}" selected>{{$meeting_schedule_type_list[$i]}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$meeting_schedule_type_list[$i]}}" >{{$meeting_schedule_type_list[$i]}}</option>    
								    <?php
								    } ?> 
								@endfor
							</select>
						</center>
					</td>
					<td><b>INITIATOR DEPARTMENT</b></td>
					<?php 
					if($val == "superAdmin"){?>
					<td>
						<center>
							<select id="initiator_dept" name="initiator_dept">
								@foreach($dept_lists as $dept_list)
									<?php if($initiator_dept== $dept_list->dept){?>
										<option value="{{$dept_list->dept}}" selected>{{$dept_list->dept}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$dept_list->dept}}" >{{$dept_list->dept}}</option>    
								    <?php
								    } ?> 
								@endforeach
							</select>
						</center>
					</td>
					<?php }
					else{ ?>
					<td>Department</td>
					<td>
						<center>
							<select id="initiator_dept" name="initiator_dept">
								@foreach($dept_lists as $dept_list)
									<?php if($_SESSION["dept"]== $dept_list->dept){?>
										<option value="{{$dept_list->dept}}" selected>{{$dept_list->dept}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$dept_list->dept}}" disabled>{{$dept_list->dept}}</option>    
								    <?php
								    } ?> 
								@endforeach
							</select>
						</center>
					</td>

			<?php	} ?>
					<td>
						<b>Select year</b>
					</td>
					<td>
						<center>
							
							<input name="yearMonth" id="yearMonth" class="date-picker" />
						</center>
					</td>
					<td><b>ATTENDED DEPARTMENT</b></td>
					<td>
						<center>
							<select id="attended_dept" name="attended_dept">
								@foreach($dept_lists as $dept_list)
									<?php if($attended_dept == $dept_list->dept){?>
										<option value="{{$dept_list->dept}}" selected>{{$dept_list->dept}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$dept_list->dept}}" >{{$dept_list->dept}}</option>    
								    <?php
								    } ?> 
								@endforeach
							</select>
						</center>
					</td>
				</tr>
				<tr>	
					<td>
						<center>
							Meeting Type
						</center>
					</td>
					<td>
						<center>
							<select id="meeting_type" name="meeting_type">
								<option value="firstMeeting">First Meeting</option>
								<option value="projectMeeting">Project Meeting</option>
								<option value="followUpMeeting">Follow Up Meeting</option>
							</select>
						</center>
					</td>
					<td>{!! Form::submit('SUBMIT', array('class'=>'btn')) !!}</td>
				</tr>

				{!! Form::close() !!}
			</table>
			<table id="dashboardHeaderTable">
				{!! Form::open(array('url' => 'dashboardAll', 'method' => 'GET')) !!}
				<tr>
					<?php 
					// echo $initiator_dept_all;
					//echo $val;
					if($val == "superAdmin"){?>
					<td><b>DEPARTMENT</b></td>
					<td>
						<center>
							<select id="initiator_dept_all" name="initiator_dept_all">
								@foreach($dept_lists as $dept_list)
									<?php if($initiator_dept_all == $dept_list->dept){?>
										<option value="{{$dept_list->dept}}" selected>{{$dept_list->dept}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$dept_list->dept}}" >{{$dept_list->dept}}</option>    
								    <?php
								    } ?> 
								@endforeach
							</select>
						</center>
					</td>
					<?php }
					else{ ?>
					<td><b>DEPARTMENT</b></td>
					<td>
						<center>
							<select id="initiator_dept_all" name="initiator_dept_all">
								@foreach($dept_lists as $dept_list)
									<?php if($_SESSION["dept"] == $dept_list->dept){?>
										<option value="{{$dept_list->dept}}" selected>{{$dept_list->dept}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$dept_list->dept}}" disabled>{{$dept_list->dept}}</option>    
								    <?php
								    } ?> 
								@endforeach
							</select>
						</center>
					</td>

			<?php	} ?>
					
					<td><b>MEETING SCHEDULE TYPE</b></td>
					<td>
						<center>
							<select id="meeting_schedule_type" name="meeting_schedule_type">
								@for($i=0;$i<count($meeting_schedule_type_list_all);$i++)
									<?php if($meeting_schedule_type == $meeting_schedule_type_list_all[$i]){ ?>
										<option value="{{$meeting_schedule_type_list_all[$i]}}" selected>{{$meeting_schedule_type_list_all[$i]}}</option>    
									<?php
									}   
								    else{ ?>
								        <option value="{{$meeting_schedule_type_list_all[$i]}}" >{{$meeting_schedule_type_list_all[$i]}}</option>    
								    <?php
								    } ?> 
								@endfor
							</select>
						</center>
					</td>
					<td>
						<b>Select year
						</b>
					</td>
					<td>
						<center>
							<input name="yearMonth" id="yearMonth1" class="date-picker1" />
						</center>
					</td>
					<td>{!! Form::submit('SUBMIT', array('class'=>'btn')) !!}</td>
				</tr>
				{!! Form::close() !!}
			</table>
			
			<table id="test">
				<?php if($meeting_schedule_type == 'Weekly' || $meeting_schedule_type == 'Bi-Weekly')
					{ ?>
				<tr><th>Week</th><th>Status</th><th>Meeting Title</th><th>Meeting Datetime</th><th>Meeting Type</th><th>EDIT</th><th>View</th></tr>
				
					<?php 
					
						for($i=1;$i<53;$i++){
							$is_done = false;
						?>
						<tr>
							<td><?php echo $i; ?></td>	
						<?php	
							for($k=0;$k<$count;$k++){
								if($i == $week_list_arr["week".$k]){
									$is_done = true;
								 ?>
									<td><span class="glyphicon glyphicon-ok"></span></td>
									<td><?php echo  $week_list_arr["title".$k];?></td>
									<td><?php echo  $week_list_arr["datetime".$k];?></td>	
									<td><?php echo  $week_list_arr["meeting_type".$k];?></td>	
									<td>
										{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}
											{!! Form::hidden('meeting_id', $week_list_arr["meeting_id".$k]) !!}
											{!! Form::hidden('mother_meeting_id', $week_list_arr["mother_id".$k]) !!}
									    	{!! Form::submit('EDIT', array('class'=>'btn')) !!}
										{!! Form::close() !!}
									</td>
									<td><input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$week_list_arr["meeting_id".$k]}}&mother_meeting_id={{$week_list_arr["mother_id".$k]}}'" style="color:#fff;" class="btn" value="View MoM" /></td>		
								<?php 
									break;
							}	

							}
							if($is_done == false){
							?>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							<?php
								$is_done = false;
							}
							//$key = array_search('green', $array);
							?></tr><?php
						}
					}
					if($meeting_schedule_type == 'Monthly')
					{ ?>
					<tr><th>Month</th><th>Status</th><th>Meeting Title</th><th>Meeting Datetime</th><th>Meeting Type</th><th>EDIT</th><th>View</th></tr>
				
					<?php 
					
						for($i=1;$i<13;$i++){
							$is_done = false;
						?>
						<tr>
							<td><?php
								$dateObj   = DateTime::createFromFormat('!m', $i);
								$monthName = $dateObj->format('F'); 
								echo $monthName;
							 ?>
							</td>	
						<?php	
							for($k=0;$k<$count;$k++){
								if($i == $week_list_arr["month".$k]){
									$is_done = true;
								 ?>
									<td><span class="glyphicon glyphicon-ok"></span></td>
									<td><?php echo  $week_list_arr["title".$k];?></td>
									<td><?php echo  $week_list_arr["datetime".$k];?></td>
									<td><?php echo  $week_list_arr["meeting_type".$k];?></td>	
									<td>
										{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}
											{!! Form::hidden('meeting_id', $week_list_arr["meeting_id".$k]) !!}
											{!! Form::hidden('mother_meeting_id', $week_list_arr["mother_id".$k]) !!}
									    	{!! Form::submit('EDIT', array('class'=>'btn')) !!}
										{!! Form::close() !!}
									</td>
									<td><input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$week_list_arr["meeting_id".$k]}}&mother_meeting_id={{$week_list_arr["mother_id".$k]}}'" style="color:#fff;" class="btn" value="View MoM" /></td>		
								<?php 
									break;
							}	

							}
							if($is_done == false){
							?>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							<?php
								$is_done = false;
							}
							//$key = array_search('green', $array);
							?></tr><?php
						}
					}
					if($meeting_schedule_type == 'AD-HOC'){
					?>
					<tr><th>Meeting Title</th><th>Meeting Datetime</th><th>Meeting Type</th><th>EDIT</th><th>View</th></tr>
					<?php
						for($j=0;$j<$count;$j++){
						?>
						<tr>	
									<td><?php echo  $week_list_arr["title".$j];?></td>
									<td><?php echo  $week_list_arr["datetime".$j];?></td>	
									<td><?php echo  $week_list_arr["meeting_type".$j];?></td>
									<td>
										{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}
											{!! Form::hidden('meeting_id', $week_list_arr["meeting_id".$j]) !!}
											{!! Form::hidden('mother_meeting_id', $week_list_arr["mother_id".$j]) !!}
									    	{!! Form::submit('EDIT', array('class'=>'btn')) !!}
										{!! Form::close() !!}
									</td>
									<td><input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$week_list_arr["meeting_id".$j]}}&mother_meeting_id={{$week_list_arr["mother_id".$j]}}'" class="btn" style="color:#fff;" value="View MoM" /></td>		
								</tr><?php

						}
					}
					
					if($meeting_schedule_type == 'All-Weekly' || $meeting_schedule_type == 'All-Bi-Weekly'){
					?>
					<tr>
						<th>Week</th>
						<th>Planning Architecture & Design<br>[{{$count_arr[1]}}]</th>
						<th>Implementation<br>[{{$count_arr[2]}}]</th>
						<th>Operations & Maintenance - 1<br>[{{$count_arr[3]}}]</th>
						<th>Operations & Maintenance - 2<br>[{{$count_arr[4]}}]</th>
						<th>NOC<br>[{{$count_arr[5]}}]</th> 
						<th>Power & Projects<br>[{{$count_arr[6]}}]</th>
						<th>Gateway Operations<br>[{{$count_arr[7]}}]</th>
						<th>IIG<br>[{{$count_arr[8]}}]</th>
						<th>ICX<br>[{{$count_arr[9]}}]</th>
						<th>ITC<br>[{{$count_arr[10]}}]</th>
						<th>IIG&ITC<br>[{{$count_arr[11]}}]</th>
						<th>Coordination<br>[{{$count_arr[12]}}]</th>
						<th>Revenue Assurance<br>[{{$count_arr[13]}}]</th>
						<th>Service Assurance<br>[{{$count_arr[14]}}]</th>
						<th>Sales & Marketing<br>[{{$count_arr[15]}}]</th>
						<th>Mobile Financial Services<br>[{{$count_arr[16]}}]</th>
						<th>Business Devlopment<br>[{{$count_arr[17]}}]</th>
						<th>Treasury<br>[{{$count_arr[18]}}]</th>
						<th>Accounts<br>[{{$count_arr[19]}}]</th>
						<th>Billing<br>[{{$count_arr[20]}}]</th>
						<th>Internal Control & Audit<br>[{{$count_arr[21]}}]</th>
						<th>Finance<br>[{{$count_arr[22]}}]</th>
						<th>N/A<br>[{{$count_arr[23]}}]</th>
						<th>Company Secretariat<br>[{{$count_arr[24]}}]</th>
						<th>Supply Chain<br>[{{$count_arr[25]}}]</th>
						<th>IT<br>[{{$count_arr[26]}}]</th>
					</tr>
					<?php
					//print_r($week_list_arr);
					//exit();
						$is_found = false;
						for($i=1;$i<53;$i++){
							$is_done = false;
						?>
						<tr>
							<td><?php echo $i; ?></td>	
							<?php 
							for($j=1;$j<27;$j++){
								for($k=0;$k<$count;$k++){
									$week_arr = explode(",",$week_list_arr["week__".$k]);
									//echo $week_arr[0];
									if($i == $week_arr[0]){
								 		if($week_arr[1] == $j){
								 			$is_found = true;
											?><td><span class="glyphicon glyphicon-ok"></span><span style="visibility:hidden;">Done</span></td><?php
										}
									}
								}
								if($is_found == false){
									?><td></td><?php
								}
								$is_found = false;
							}
							?>
						</tr><?php
						}
					}

					if($meeting_schedule_type == 'All-Monthly'){
					?>
					<tr>
						<th>Month</th><th>Planning Architecture & Design</th><th>Implementation</th><th>Operations & Maintenance - 1</th><th>Operations & Maintenance - 2</th><th>NOC</th> <th>Power & Projects</th><th>Gateway Operations</th><th>IIG</th><th>ICX</th><th>ITC</th><th>IIG&ITC</th><th>Coordination</th><th>Revenue Assurance</th><th>Service Assurance</th><th>Sales & Marketing</th><th>Mobile Financial Services</th><th>Business Devlopment</th><th>Treasury</th><th>Accounts</th><th>Billing</th><th>Internal Control & Audit</th><th>Finance</th><th>N/A</th><th>Company Secretariat</th><th>Supply Chain</th><th>IT</th>

					</tr>
					<?php
						$is_found = false;
						for($i=1;$i<13;$i++){
							$is_done = false;
						?>
						<tr>
							<td>
								<?php
									$dateObj   = DateTime::createFromFormat('!m', $i);
									$monthName = $dateObj->format('F'); 
									echo $monthName;
								 ?>
							</td>
							<?php 
							for($j=1;$j<27;$j++){
								for($k=0;$k<$count;$k++){
									$week_arr = explode(",",$week_list_arr["month__".$k]);
									if($i == $week_arr[0]){
								 		if($week_arr[1] == $j){
								 			$is_found = true;
											?><td><span class="glyphicon glyphicon-ok"></span><span style="visibility:hidden;">Done</span></td><?php
										}
									}
									// if($i == $week_list_arr["month__".$k]){
								 // 		if($week_list_arr['attended_dept__'.$k] == $j){
								 // 			$is_found = true;
											?><!--<td><span class="glyphicon glyphicon-ok"></span></td>--><?php
									// 	}	
									// }
								
								}
								if($is_found == false){
									?><td></td><?php
								}
								$is_found = false;
							}
							?>
						</tr><?php
						}
					}
					?>	
				
			</table>
			
		</div>
	</div>	
	<table id="buttonBox" style="width:7%">
		<tr>
			<td>
				<button onclick="exportExcel()" class="btn" >Export</button>
			</td>
		</tr>
	</table>
	</center>
</body>
</html>

@endsection