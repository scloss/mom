
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
if(isset($_SESSION["is_first_time"])){
	$is_first = "true";
	$_SESSION["is_first_time"] = 'true';
}
else{
	$is_first = "false";
	$_SESSION["is_first_time"] = 'true';
}
//print_r($_SESSION);
?>
<!-- {{ var_dump(Session::all()) }} -->

@extends($App)
@section('content')
<html>
	<head>
		<title>MOM</title>
		
		<!-- <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'> -->
		<link href="{{ asset('/css/momStyle.css') }}" rel='stylesheet' type='text/css'>

  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  		<script src="{{ asset('/js/jquery.easing.1.3.min.js') }}" type="text/javascript"></script>
  		<script src="{{ asset('/js/jquery.easing.compatibility.js') }}" type="text/javascript"></script>
  		<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

  		<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
		<!--[if !IE | (gt IE 8)]><!-->

	
	</head>
	<body >
	<!-- <div id="loading"></div>
	<div id="page"> -->
	<div class="fadeMe">
		<div id="innerDiv" class="container">

			<div class="container">
				
				<div class="row">
					<div class="col-md-12" >
						<div class="col-md-4"></div>
						<div class="col-md-4" id="topCenterDiv">
							<!-- <h1>SCL MOM TOOL</h1> -->
						</div>
						<div class="col-md-2">
						</div>
						<div class="col-md-2"></div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" id="mainSplashDiv">
						<div class="col-md-3"></div>
						<div class="col-md-2" id="leftDiv">
							<div id="box1" class="row"></div>
							<div id="box2" class="row"></div>
							<div id="box3" class="row"></div>
							<div id="box7" class="row"></div>
						</div>
						<div class="col-md-2" id="centerDiv">
							<!-- <div id="rocket" class="row"></div> -->
							<div id="emptyDiv"></div>
							<div id="momWriting" class="row"></div>
						</div>
						<div class="col-md-2" id="rightDiv">
							<div id="box4"></div>
							<div id="box5"></div>
							<div id="box6"></div>
							<div id="box8"></div>
							<div id="box9"></div>
						</div>
						<div class="col-md-3"></div>
					</div>
				</div>
			</div>
			
			
		</div>
		<center>
				<div id="logoMom">
					
				</div>
			</center>
		<center>
				<div id="rocket"></div>
			</center>
	</div>
	<div>
		<div id="titleBar">
			<h4>MOM HOME</h4>
		</div>
		
		<div class="container" style="height:100% !important;">

			<div class="col-md-12">
				<div id="landingInfoDiv">
					<div class="col-md-4">
					</div>
					<div id="testlanding" class="col-md-4">
					<h5 style="text-align:center;font-size:18px !important;font-weight:bold;">DEPT : {{$_SESSION['dept']}}</h5>
					<h5 style="text-align:center;font-size:18px !important;font-weight:bold;">USER ID : {{ $userID }}</h5>	
					<h5 style="text-align:center;font-size:18px !important;font-weight:bold;">WELCOME, {{ $userName }}</h5>
					<h5 style="text-align:center;font-size:18px !important;font-weight:bold;">TYPE : <?php if($val == "superAdmin"){ echo "Super Admin";
																							}
																							elseif($val == "admin"){
																								echo "Admin"; 
																								$selectDeptLists = explode(",",$_SESSION['ADMIN_DEPT_LISTS']);
																							}
																							else{
																								echo "User";
																							}?></h5>
					<h5 style="text-align:center;font-size:18px !important;"><?php if($val == "superAdmin" || $val =="admin"){ ?>
					@if($_SESSION['ADMIN_DEPT_LISTS'] != 'false')
					{!! Form::open(array('url' => 'changeDept', 'method' => 'POST')) !!}
					<select name="sessionDept" required="">
						<option disabled selected> Select Dept</option>
						@for($i=0;$i<count($selectDeptLists);$i++)
							<option value="{{$selectDeptLists[$i]}}">{{$selectDeptLists[$i]}}</option>
						@endfor
					</select>
					{!! Form::submit('Change Dept' , array('class'=>'btn')); !!}
					{!! Form::close() !!}
					@endif
				{!! Form::open(array('url' => 'landing', 'method' => 'GET')) !!}

					<input type="hidden" name="showAll" value="showAll">
					{!! Form::submit('Show All' , array('class'=>'btn')); !!}

				{!! Form::close() !!}
			<?php } ?></h5>
					</div>
					<div class="col-md-4">
					</div>
				</div>
			
				<div id="landingTableDiv" style="margin-top:10%;margin-left:5%;padding-top:2%;">
					<div class="col-md-2">
					</div>
					<div class="col-md-6" >	
						<table class="landingTable" style="box-shadow: 0px 0px 18px #888888;">
							<tr class="trHeader" >
								<td>ID</td><td>MEETING TITLE</td><td>COMPLETION PERCENTAGE</td><td>SCHEDULE TYPE</td><td>ACTION POINT</td><td>EDIT MEETING</td><td>VIEW MOM</td><td>QUICK VIEW</td><td></td>
							</tr>

							<?php $i = 0; ?>	
							@foreach($meeting_lists as $meeting_list)
								@if($meeting_list->completion <= '25')
								<tr id="rowRed">					
								@endif
								@if($meeting_list->completion > '25' && $meeting_list->completion < '75')
								<tr id="rowYellow">			
								@endif
								@if($meeting_list->completion >= '75' && $meeting_list->completion < '100')
								<tr id="rowAllmostGreen">
								@endif	
								@if($meeting_list->completion == '100')
								<tr id="rowGreen">
								@endif
									<td>{{$meeting_list->meeting_id}}</td>	
									<td>{{$meeting_list->meeting_title}}</td><td>{{$meeting_list->completion}}%</td><td>{{$meeting_list->meeting_schedule_type}}</td>
									<td>
										<?php 
										// print_r($meeting_lists_with_responsible);
										if($meeting_lists_with_responsible != null){
											if(in_array($meeting_list->meeting_id, $meeting_lists_with_responsible)){
												if(in_array($meeting_list->meeting_id, $red_meeting_lists_responsible)){
													?><span class="glyphicon glyphicon-ok" style="color:red"></span><?php
												}
												else{
													?><span class="glyphicon glyphicon-ok" style="color:green"></span><?php
												}
											}
										}?>
									</td>
									<td>
										{!! Form::open(array('url' => 'editView', 'method' => 'GET')) !!}
											{!! Form::hidden('meeting_id', $meeting_list->meeting_id) !!}
											{!! Form::hidden('mother_meeting_id', $meeting_list->mother_meeting_id) !!}
								    		{!! Form::submit('EDIT', array('class'=>'btn')) !!}
										{!! Form::close() !!}
									</td>
									<td>
										<input type="button" onclick="location.href='{{ url('view') }}?meeting_id={{$meeting_list->meeting_id}}&mother_meeting_id={{$meeting_list->mother_meeting_id}}';" style="color:#fff;" class="btn" value="View" />	
									</td>
									
									<td>
										  <a class="quickView" href="{{ url('quickView') }}?meeting_id={{$meeting_list->meeting_id}}&mother_meeting_id={{$meeting_list->mother_meeting_id}}" data-toggle="modal" data-target="#myModal{{$meeting_list->meeting_id}}" style="color:#000;font-weight:normal"><span class="glyphicon glyphicon-zoom-in" ></span></a>

										  
									</td>
									<td>
									@if(count($mom_furthest_endtime_list) != 0)
										@if($mom_furthest_endtime_list[$i]<= $yellow_date1)
											
											<img src="{{asset('/images/red.gif')}}" data-toggle="tooltip" data-placement="right" title="[Action point : {{$mom_name_list[$i]}}],[Remaining time: less than 2 days]" alt="Red Alert" style="width:20px;height:20px;display: block;margin-left: auto;margin-right: auto;">
										@endif
										@if($mom_furthest_endtime_list[$i] > $yellow_date1 && $mom_furthest_endtime_list[$i] < $yellow_date2)
											
											<img src="{{asset('/images/yellow.gif')}}" alt="Yellow Alert"  data-toggle="tooltip" data-placement="right" title="[Action point : {{$mom_name_list[$i]}}],[Remaining time: less than 5 days]" style="width:20px;height:20px;display: block;margin-left: auto;margin-right: auto">
										@endif
										@if($mom_furthest_endtime_list[$i]> $yellow_date2)
											
											<img src="{{asset('/images/green.gif')}}" alt="Green Alert" data-toggle="tooltip" data-placement="right" title="[Action point : {{$mom_name_list[$i]}}],[Remaining time: more than 5 days]" style="width:20px;height:20px;display: block;margin-left: auto;margin-right: auto">
										@endif
									@endif
									</td>	
								</tr>
								<div class="modal fade" id="myModal{{$meeting_list->meeting_id}}" role="dialog">
										    <div class="modal-dialog">
										    
										      <!-- Modal content-->
										      <div class="modal-content" >
										        <!-- <div class="modal-header">
										          <button type="button" class="close" data-dismiss="modal">&times;</button>
										          <h4 class="modal-title">Modal Header</h4>
										        </div> -->
										        <div class="modal-body" style="height:400px; overflow-y:auto;">
										          <!-- <div id="modal_body"></div> -->
										        </div>
										        <!-- <div class="modal-footer">
										          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										        </div> -->
										      </div>
										      
										    </div>
									    </div>
								<?php $i++; ?>
							@endforeach

						</table>
						
						
						</div>
					
					<div class="col-md-4">
					</div>
				</div>
				<div class="col-md-12">
					<center>
							<div class="pagination"> {!! str_replace('/?', '?', $meeting_lists->appends(Input::except('page'))->render()) !!} </div>
						</center>
				</div>
			</div>
		</div>
		</div>
		<!-- </div> -->
			
	</body>
		<script>
			$(document).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip();  
			    var isOk="<?php echo $is_first; ?>";
			    //isOk = 'false';
			    if(isOk == 'false'){

			    //alert(isOk);	
			    $('#momWriting').delay(0).animate({marginTop:'210%'}, 1000, 'easeOutQuart');
			    $('#rocket').delay(1200).show("scale",{}, 2500);
			    $('#box1').delay(1200).show("scale",{}, 1500);
			    $('#box2').delay(1300).show("scale",{}, 1500);
			    $('#box3').delay(1400).show("scale",{}, 1500);
			    $('#box4').delay(1500).show("scale",{}, 1500);
			    $('#box5').delay(1600).show("scale",{}, 1500);
			    $('#box6').delay(1700).show("scale",{}, 1500);
			    $('#box7').delay(1800).show("scale",{}, 1500);
			    $('#box8').delay(1900).show("scale",{}, 1500);
			    $('#box9').delay(2000).show("scale",{}, 1500);
			    $('#logoMom').delay(3000).show("scale",{}, 3500);
			    $('#topCenterDiv').delay(600).show("scale",{}, 1500);
			    
			    $('#rocket').delay(0).animate({marginTop:'-40%'}, 5000, 'easeInCirc');
			    $("#box1").delay(0).animate({left: '-=120', top: '-=70'}, 2000, 'easeOutQuart');//calender
			    $("#box2").delay(0).animate({left: '-=140', top: '-=0'}, 2500, 'easeOutQuart');//letter
			    $("#box3").delay(0).animate({left: '-=60', top: '+=150'}, 2500, 'easeOutQuart');//clock
			    $("#box7").delay(0).animate({left: '-=80', top: '+=50'}, 2500, 'easeOutQuart');//glass
			    $("#box4").delay(0).animate({left: '+=120', top: '-=50'}, 2500, 'easeOutQuart');//lock
			    $("#box5").delay(0).animate({left: '+=120', top: '-=00'}, 2500, 'easeOutQuart');//schedule
			    $("#box6").delay(0).animate({left: '+=120', top: '+=190'}, 2500, 'easeOutQuart');//notebook
			    $("#box8").delay(0).animate({left: '+=20', top: '+=50'}, 2500, 'easeOutQuart');//smallletter
			    $("#box9").delay(0).animate({left: '+=100', top: '-=170'}, 2500, 'easeOutQuart');//pencil
			    //$("#rocket").css("z-index", "2000");
			    //document.getElementById('#rocket').style.position = "absolute";
			    //scroll();
			    //$("#rocket").delay(0).animate({left: '-=0', top: '-=0'}, 1500, 'easeOutElastic');
			    
			    // $("#box1").animate({height: 30,width: 80},1000,'easeOutBounce' );

			    // $("#box2").animate({height: "300px"});
			    // $("#box3").animate({height: "300px"});
			        // .animate({height: '100px'}, 1000, 'easeOutElastic')
			    //$(".fadeMe").delay(4000).hide();
			    setTimeout(function(){
			      $('.fadeMe').fadeOut('slow', function(){ $('.fadeMe').remove(); });
				  //$('.fadeMe').remove();
				}, 8000);
				}
				else{
					$('.fadeMe').remove();
				}
			});
			$('#myModal').on('shown.bs.modal', function () {
			    $(this).find('.modal-dialog').css({width:'auto',
			                               height:'auto', 
			                              'max-height':'100%'});
			});
			// function scroll() {
			    
			// }


			// function onReady(callback) {
			//     var intervalID = window.setInterval(checkReady, 1000);

			//     function checkReady() {
			//         if (document.getElementsByTagName('body')[0] !== undefined) {
			//             window.clearInterval(intervalID);
			//             callback.call(this);
			//         }
			//     }
			// }

			// function show(id, value) {
			//     document.getElementById(id).style.display = value ? 'block' : 'none';
			// }

			// onReady(function () {
			//     show('page', true);
			//     show('loading', false);
			// });

		</script>

		<style type="text/css">
		/*#page {
		    display: none;
		}
		#loading {
		    display: block;
		    position: absolute;
		    top: 0;
		    left: 0;
		    z-index: 100;
		    width: 100vw;
		    height: 100vh;
		    background-color: rgba(192, 192, 192, 0.5);
		    background-image: url("http://i.stack.imgur.com/MnyxU.gif");
		    background-repeat: no-repeat;
		    background-position: center;
		}*/	
		body{
			background:#fff;
		}
		#rocket{
			background:url('images/rocket.png');
			background-size: contain;
			background-repeat:no-repeat;
			margin-top:40%;
			height:280px;
			width:300px;
			margin-left:8%;
			/*display:none;
			position: relative;*/
			/*z-index: 6;*/
		}
		#momWriting{
			background:url('images/hand.png');
			background-size: contain;
			background-repeat:no-repeat;
			margin-top:1020px;
			height:300px;
			width:250px;
			margin-left:-52% !important;
		}
		#box1,#box2,#box3,#box7{
			height:100px;
			width:100px;
			/*border:1px solid black;*/
			display:none;
			
			position: relative;
		}
		#box4,#box5,#box6,#box8{
			height:100px;
			width:100px;
			/*border:1px solid black;*/
			display:none;
			/*margin-top:50px;
			margin-left:-150px;*/
			position: relative;
		}
		#mom_tool_word{
			display:none;
			height:40px;
			width:200px;
		}
		#box1{
			background:url('images/calender.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:10;
			margin-top:90%;
			margin-left:40%;
		}
		#box2{
			background:url('images/letter.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:20;
			margin-top:0%;
			margin-left:40%;
		}
		#box3{
			background:url('images/clock.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:30;
			margin-top:-90%;
			margin-left:40%;
		}
		#box7{
			background:url('images/glass.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:70;
			margin-top:-90%;
			margin-left:40%;
			height:120px;
			width:120px;
		}
		#box4{
			background:url('images/lock.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:40;
			margin-top:70%;
			margin-left:-40%;
		}
		#box5{
			background:url('images/schedule.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:50;
			margin-top:0%;
			margin-left:-40%;
		}
		#box6{
			background:url('images/notebook.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:60;
			margin-top:-90%;
			margin-left:-40%;
			height:120px;
			width:120px;
		}
		#box8{
			background:url('images/smallletter.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:80;
			margin-top:0%;
			margin-left:-40%;
		}
		#box9{
			background:url('images/pencil.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:80;
			margin-top:0%;
			margin-left:-40%;
			height:50px;
			width:50px;
			/*border:1px solid black;*/
			display:none;
			/*margin-top:50px;
			margin-left:-150px;*/
			position: relative;
		}
		
		.tooltip-inner {
		    min-width: 150px; 
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
		    width:70% !important;
		    height:400px !important;  
		}
		
		
	  #centerDiv{
	  	/*padding-top:40%;*/
	  }
	  #mainSplashDiv{
	  	
	  }
	  #leftDiv{
	  	padding-top:5%;
	  }
	  #rightDiv{
	  	padding-top:5%;
	  }
	  #topCenterDiv
	  {
	  	margin-top:3%;
	  	/*margin-left:40%;*/
	  	/*margin-left:-5%;*/
	  	color:#fff;
	  	font-family: Gill Sans, Verdana;
		 line-height: 14px;
		 text-transform: uppercase;
		 letter-spacing: 2px;
		 font-weight: bold;
/*		 background:url('images/logo1.png');
			background-size: contain;
			background-repeat:no-repeat;
			height:220px;
			width:220px;*/
		/*text-shadow: 0px 1px 1px #000;*/
		/*text-shadow: 4px 3px 0px #b2a98f, 9px 8px 0px rgba(0,0,0,0.15);        
/*	  	display:none;
		position: relative;*/
	  }
	  #emptyDiv{
	  	height:180px;
	  	/*background-color:red;*/
	  }
	  #logoMom{
	  	background:url('images/logo1.png');
			background-size: contain;
			background-repeat:no-repeat;
			z-index:100;
			margin-top:-32%;
			margin-left:-4%;
			height:250px;
			width:250px;
			/*border:1px solid black;*/
			display:none;
			/*margin-top:50px;
			margin-left:-150px;*/
			position: relative;
	  }
		
		@media only screen
		and (min-width : 1200px) {
			#logoMom{
			  	margin-top:-32%;
			}
			#emptyDiv{
			  	height:5px;
			  	/*background-color:green;*/
			}
			#leftDiv{
			  	padding-top:0%;
			}
			#rightDiv{
			  	padding-top:0%;
			}
			#innerDiv{
				height:95%;
			}
		}
		@media only screen and (min-width : 1824px) {
			#logoMom{
			  	margin-top:-32%;
			}
			#emptyDiv{
			  	height:150px;
			  	/*background-color:red;*/
			}
			#leftDiv{
			  	padding-top:0%;
			}
			#rightDiv{
			  	padding-top:0%;
			}
			#innerDiv{
				height:75%;
			}
		}
		div.fadeMe {
	    opacity:1.0;
	    filter: alpha(opacity=20);
	    background-color:#0090A5;/*19aabf;*/ 
	    width:100%; 
	    height:100%; 
	    z-index:5;
	    top:0; 
	    left:0; 
	    position:fixed; 
	    overflow:hidden !important;

	    
	  }
		#innerDiv{
			background-color:#19aabf;
			border-radius:50%;
			border-top-right-radius: 0%;
			border-top-left-radius: 0%;
			
			z-index:7;
			height:85%;
			width:140%;
			margin-left:-20%;
		}

		</style>
</html>
@endsection
