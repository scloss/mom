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
$App = "appUserSearch";
?>

@extends($App)
@section('content')
<html>
	<head>

		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<script src="{{ asset('/js/datetimepicker_css.js') }}" type="text/javascript"></script>
		<script language="JavaScript" src="{{ asset('/js/datetimepicker_css.js?random=20060118') }}"></script>
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>
		<script src="{{ asset('/js/jquery.table2excel.js') }}"></script>
		<style>
			td
			{
				/*border:1px solid black;*/
			}
			tr
			{
				/*border:1px solid black;*/
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
		function printTest(divName,divTitle) {
			//alert(divName);
			 $(".noExl").hide();  
			 $(".pagination").hide();

	       var printContents = document.getElementById(divName).innerHTML;
	       var printContentsTableMeeting = document.getElementById("momTable");
	       var printContents1 = document.getElementById(divTitle).innerHTML;
	       // document.getElementById("buttonsDiv").style.display = "none";
	       // document.getElementById("buttonHeaderDiv").style.display = "none";   
	      
	        //var divToPrint = document.getElementById('tableMeeting');
		    var htmlToPrint = '' +
		        '<style type="text/css">' +
		        'h4{text-align:center;}'+
		        'table{width:980;}' +
		        'table,table td{' +
		        'border:1px solid #000;' +
		        'font-size:15px !important;' +
		        'border-collapse: collapse;'+
				'overflow:auto;'+
				'word-wrap:break-word;'+
				'margin-top:5%;'+
				'text-align:center;'+
				'page-break-inside:auto'+
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
		     $(".noExl").show();  
			 $(".pagination").show();
		   // var originalContents = document.body.innerHTML;  
		   // document.body.innerHTML = printContents1+ printContents+printContentsTableMeeting;       
		        
		   // window.print();      
		   // document.body.innerHTML = originalContents;
	   }
			function exportExcel(){
				$(".noExl").hide();  
			 	$(".pagination").hide();
		    	$("#momTable").table2excel({
						exclude: ".noExl",
						name: "Excel Document Name",
						filename: "excelFile",
						fileext: ".xls",
						exclude_img: true,
						exclude_links: true,
						exclude_inputs: true
					});
		    }
			$(document).ready(function(){
			$("#formDiv").hide();
			$("#normalSearchBtn").css("background-color", "#E8BE40");
			$("#advancedSearchBtn").click(function(){
			    $("#formDivAll").hide();
			    $("#formDiv").show();
			    $("#advancedSearchBtn").css("background-color", "#E8BE40");
			    $("#normalSearchBtn").css("background-color", "#F0F5F9");
			});
			$("#normalSearchBtn").click(function(){
			    $("#formDiv").hide();
			    $("#formDivAll").show();
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
		<div class="container-fluid">
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
									<td>Meeting Title:	</td><td>{!! Form::text('search_meeting_title',$search_meeting_title,array('class'=>'w3-input w3-border')) !!}</td>
								</tr>
								<tr style="background-color:#D6D6D8;">
									<td colspan='2'>Search Between Two Meeting Dates</td>
								</tr>
								<tr>
									<td>Meeting Time From: </td>
			        				<td>
			        					@if($search_meeting_datetime1 != '' || $search_meeting_datetime1 != $current_date)
			        						<input type="Text" name="search_meeting_datetime1" id="search_meeting_datetime1" value="{{$search_meeting_datetime1}}"  maxlength="25" size="25"/>
			        					@else
			        						<input type="Text" name="search_meeting_datetime1" id="search_meeting_datetime1" value="{{$current_date}}"  maxlength="25" size="25"/>
			        					@endif
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_meeting_datetime1','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer;float:right"/></td>
								</tr>
								<tr>
									<td>Meeting Time To: </td>
			        				<td>
			        					@if($search_meeting_datetime2 != '' || $search_meeting_datetime2 != $current_date)
			        						<input type="Text" name="search_meeting_datetime2" id="search_meeting_datetime2" value="{{$search_meeting_datetime2}}"  maxlength="25" size="25"/>
			        					@else
			        						<input type="Text" name="search_meeting_datetime2" id="search_meeting_datetime2" value="{{$current_date}}"  maxlength="25" size="25"/>
			        					@endif	
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_meeting_datetime2','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>Meeting Attendee: </td><td>{!! Form::text('search_meeting_attendee',$search_meeting_attendee) !!}</td>
								</tr>
								<tr>
									<td>Mail Recipient: </td><td>{!! Form::text('search_mail_recipient',$search_mail_recipient) !!}</td>
								</tr>
								<tr>
									<td>Meeting type : </td><td>{!! Form::text('search_meeting_type',$search_meeting_type) !!}</td>
								</tr>
								<tr>
									<td>Meeting status :</td> <td>{!! Form::text('search_meeting_status',$search_meeting_status) !!}</td>
								</tr>
								<tr>
									<td colspan='2' style="text-align:right;">
										<b>View Mode  :  </b>Meeting 
											@if($view_mode == 'meetingView')
												{!! Form::radio('viewMode', 'meetingView', true) !!} Action Point {!! Form::radio('viewMode', 'momView') !!}
											@else
												{!! Form::radio('viewMode', 'meetingView') !!} Action Point {!! Form::radio('viewMode', 'momView', true) !!}
											@endif

											<br>{!! Form::checkbox('searchForExport', 'yes') !!} Search For Export {!! Form::submit('&nbsp;&nbsp; SEARCH &nbsp;&nbsp;' , array('class'=>'btn')); !!}</td>
								</tr>
								
							</table>
							</div>	
							<div id="meetingDiv" class="col-md-6">
							<table class="meetingTable">
								<tr>
									<td>MoM Title:	</td><td>{!! Form::text('search_mom_title',$search_mom_title) !!}</td>
								</tr>
								<tr>
									<td>Responsible: </td><td> {!! Form::text('search_responsible',$search_responsible) !!}</td>
								</tr>
								<tr style="background-color:#D6D6D8;">
									<td colspan='2'>
									Search Between Two MoM Start Dates
									</td>
								</tr>
								<tr>
									<td>MoM Start Time From: </td>
			        				<td><input type="Text" name="search_mom_start_time1" id="search_mom_start_time1" value="{{$search_mom_start_time1}}" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_start_time1','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>MoM Start Time To: </td>
			        				<td><input type="Text" name="search_mom_start_time2" id="search_mom_start_time2" value="{{$search_mom_start_time2}}" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_start_time2','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr style="background-color:#D6D6D8;">
									<td colspan='2'>
									Search Between Two MoM End Dates
									</td>
								</tr>
								<tr>
									<td>MoM End Time From: </td>
			        				<td><input type="Text" name="search_mom_end_time1" id="search_mom_end_time1" value="{{$search_mom_end_time1}}" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_end_time1','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>MoM End Time To: </td>
			        				<td><input type="Text" name="search_mom_end_tim2e" id="search_mom_end_time2" value="{{$search_mom_end_time2}}" maxlength="25" size="25"/>
			        				<img src="{{ asset('/js/images/cal.gif') }}" onclick="javascript:NewCssCal ('search_mom_end_time2','yyyyMMdd','dropdown',true,'24',true);" style="cursor:pointer"/></td>
								</tr>
								<tr>
									<td>MoM Status:</td>	<td>{!! Form::text('search_mom_status',$search_mom_status) !!}</td>
								</tr>
							</table>
							<br>
				{!! Form::close() !!}
				</div>
			</div>
		    </center>
			<center>
			<div id="formDivAll" class="col-md-12">
					{!! Form::open(array('url' => 'searchProcessAll', 'method' => 'GET')) !!}
					<center>
						<table class="meetingTable">
							<tr><td>Search</td><td><input type="Text" name="searchAll"/></td><td>{!! Form::submit('search' , array('class'=>'btn')); !!}</td></tr>
						</table>
					</center>
					{!! Form::close() !!}
				</div>
			</center>		
			<div style="margin-top:5%;">

				<center>
				<!-- <table id="momTable">
					<tr class="trHeader">
						<td>Meeting ID</td><td>Meeting Title</td><td>Meeting DateTime</td>
						<td>Meeting Type</td><td>Meeting Status</td>
						<td>Completion</td>
						<td>Mother Meeting Id</td><td>View</td> <td class="noExl">Edit</td><td class="noExl">Create Follow Up Meeting</td>
					</tr>
					<?php $counter = 0; $limit = '7'; ?>
					@for($i=0; $i < count($combine_lists)/$limit;$i++)	
					{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}	
					{!! Form::hidden('meeting_id', $combine_lists[$counter]) !!}

					<?php $follow = $combine_lists[$counter+6];$status = $combine_lists[$counter+4]; $id_meeting=$combine_lists[$counter]?>				
						<tr>{!! Form::hidden('mother_meeting_id', $follow) !!}
							@for($j=0;$j<$limit;$j++)
							<td>{{$combine_lists[$counter]}}</td>
							<?php $counter++; ?> 						
							@endfor
							<td><input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$id_meeting}}&mother_meeting_id={{$follow}}';" style="color:#fff !important;" class="btn" value="View" />	</td>
							@if($status == 'active')
								<td class="noExl"><input type="submit"  value="EDIT" class="btn" style="color:#fff !important;"/></td>
							@endif
							@if($status == 'closed')
								<td class="noExl"><input type="submit"  value="EDIT" class="btn" style="color:#fff !important;" disabled/></td>
							@endif
							<td style="color:#fff;" class="noExl">
								<input type="button" onclick="location.href='{{ url('followUp') }}?mother_meeting_id={{$follow}}';" class="btn"  value="Show Thread" style="color:#fff !important;"/>
								<input type="button" onclick="location.href='{{ url('editFollowUpProcess') }}?meeting_id={{$id_meeting}}&&mother_meeting_id={{$follow}}';"  class="btn" value="Follow Up"  style="color:#fff !important;"/>	</td>

						</tr>
						
						{!! Form::close() !!}	
					@endfor

				</table> -->
				<div id="printDiv">
					<table id="momTable">
					<div class="pagination"> {!! str_replace('/?', '?', $items->appends(Input::except('page'))->render()) !!} </div>
					<tr class="trHeader">
							<td>Meeting ID</td><!-- <td>MoM ID</td> --><td>Meeting Title</td><td>Meeting DateTime</td>
							<!-- <td>Meeting Attendee</td><td>Mail Recipient</td> -->
							@if($view_mode !='momView')
							<td>Meeting Type</td><td>Meeting Status</td>
							<td>Completion</td><!--<td>Mom Title</td> --><!-- <td>Responsible</td> --><!-- <td>Start Time</td><td>End Time</td> -->
							<!-- <td>Mom Status</td> --> <td>Mother Meeting Id</td>
							@endif
							@if($view_mode=='momView')
							<td>AP ID</td><td>AP Title</td><td>AP Responsible</td><td>AP Start Time</td><td>AP End Time</td><td>AP Status</td><td style="max-width:85px;">AP Completion Status</td><td>AP Comment</td>
							@endif
							<div >
							<td class="noExl">View</td> <td class="noExl">Edit</td><!-- <td>MoM Comment</td> --><td class="noExl">Create Follow Up Meeting</td>
							</div>
						</tr>
					@foreach($items as $item)
						<tr>
							<td>{{$item->meeting_id}}</td>
							<td>{{$item->meeting_title}}</td>
							<td>{{$item->meeting_datetime}}</td>
							@if($view_mode !='momView')
								<td style="text-transform: capitalize;">{{$item->meeting_type}}</td>
								<td style="text-transform: capitalize;">{{$item->meeting_status}}</td>
								<td>{{$item->completion}}</td>
								<td>{{$item->mother_meeting_id}}</td>
							@endif
							@if($view_mode=='momView')
							<td>{{$item->mom_id}}</td>
							<td>{{$item->mom_title}}</td>
							<td>
								<div style="width:200px;word-wrap: break-word;">
									{{$item->responsible}}
								</div>
							</td>
							<td>{{$item->start_time}}</td>
							<td>{{$item->end_time}}</td>
							<td style="text-transform: capitalize;">{{$item->mom_status}}</td>
							<td>{{$item->mom_completion_status}}</td>
							<td>
								<div style="width:250px;word-wrap: break-word;">
								{{$item->comment}}
								</div>
							</td>
							
							@endif
							<div id="buttonsDiv">
							<td class="noExl"><input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$item->meeting_id}}&mother_meeting_id={{$item->mother_meeting_id}}';" style="color:#fff !important;" class="btn" value="View" />	</td>
								
								@if($item->meeting_status == 'active')
									<td class="noExl">
									{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}
										{!! Form::hidden('meeting_id', $item->meeting_id) !!}
										{!! Form::hidden('mother_meeting_id', $item->mother_meeting_id) !!}
									    {!! Form::submit('EDIT', array('class'=>'btn')) !!}
									{!! Form::close() !!}
									</td>	
									<!-- <td ><input type="submit"  value="EDIT" class="btn" style="color:#fff !important;"/></td> -->
								@endif
								@if($item->meeting_status == 'closed')
									<td class="noExl"><input type="submit"  value="EDIT" class="btn" style="color:#fff !important;" disabled/></td>
								@endif
								<td style="color:#fff;" class="noExl">
									<input type="button" onclick="location.href='{{ url('followUp') }}?mother_meeting_id={{$item->mother_meeting_id}}';" class="btn"  value="Show Thread" style="color:#fff !important;"/>
									<input type="button" onclick="location.href='{{ url('editFollowUpProcess') }}?meeting_id={{$item->meeting_id}}&&mother_meeting_id={{$item->mother_meeting_id}}';"  class="btn" value="Follow Up"  style="color:#fff !important;"/>	</td>
							</div>		
						</tr>
					@endforeach
					</table>
				</div>
				<table id="buttonBox">
						<tr>
							<td>
								<button onclick="exportExcel()" class="btn" >Export</button>
							</td>
							<td><input type="button" onclick='printTest("printDiv","titleBar")' style="color:#fff;"  class="btn" value="Print" ></td>
						</tr>
					</table>
				
				</center>
			</div>
		</div>
		<div>
			
			
		</div>
		
	</body>
</html>
@endsection