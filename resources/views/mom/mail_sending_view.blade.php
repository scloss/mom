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
	    <style type="text/css">
	    	.loader {
			  border: 16px solid #f3f3f3;
			  border-radius: 50%;
			  border-top: 16px solid #3498db;
			  width: 120px;
			  height: 120px;
			  -webkit-animation: spin 2s linear infinite;
			  animation: spin 2s linear infinite;
			}

			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
	    </style>
	    <script type="text/javascript">
	    var count = 0;
		var totalCount = 0;
		var toArr = <?php echo json_encode($toArr); ?>;
		var login_id_arr = <?php echo json_encode($login_id_arr); ?>;
		var fromAdd = <?php echo json_encode($from); ?>;
		var meeting_id = <?php echo json_encode($meeting_id); ?>;
		var organizer_name = <?php echo json_encode($organizer_name); ?>;
		totalCount = toArr.length;
		//alert(toArr[0]);
		$(document).ready(function(){
			testFunc(0);
			//document.getElementById("counterDiv").style.display='hidden';
			$("#successDiv").hide();
		});	
		
		// function getMessage(){
		// 	var temp = 0;
		// 	if(count == 0){
		// 		$.ajax({
	 //               type:'GET',
	 //               url:'/mom/public/testLoading/'+count,
	 //               data:'_token = <?php echo csrf_token() ?>',
	 //               success:function(data){
	 //                  testFunc(data.count);
	 //               }
	 //            });

		// 	}

  //        }
         function returnVal(val){
         	count = val;
         }
         function testFunc(countVal){
         	//alert(totalCountVal);
         	var tempValue = document.getElementById("msg").value;
         	if(tempValue == totalCount){
         		document.getElementById("counterDiv").style.display='none';
         		$("#successDiv").show(1000);
         	}
         	else{
         		var str = fromAdd+','+toArr[countVal]+','+meeting_id+','+organizer_name+','+countVal+','+fromAdd;
         		//alert(str);
         		$.ajax({
		               type:'GET',
		               url:'/mom/public/createMail/'+countVal+'/'+str,
		               data:'_token = <?php echo csrf_token() ?>',
		               success:function(data){
		               	  document.getElementById("msgs").innerText  = data.count;
		               	  document.getElementById("testStr").innerText = data.str;
		               	  document.getElementById("msg").value = data.count;
		                  //$("#msg").html(data.count);
		                  testFunc(data.count);
		                  //alert(data.count);
		                  //count = data.count;
		               }
		            });
         	}
			
         }
	    </script>
	</head>
	<body>
		<center>
			<div id="counterDiv">
				<h3 style="margin-top:9.0%;z-index:5;position:absolute;margin-left:48.5%;" id="msgs">0</h3>
				<div>			
					<div class="loader" style="z-index:1;margin-top:5%;position:absolute;margin-left:45%;"></div>
					<h4 id="testStr" style="margin-top:17%;position:absolute;margin-left:40%;"></h4>
				</div>
			</div>
			
		</center>
		<center>
			<div id="successDiv" style="margin-top:10%;">
				<h3 style="color:#5cb85c">Congratulations. Mail sent.</h3>
				<a href="{{ url('landing') }}" class="btn" style="color:#fff;">OK</a>
			</div>
		</center>
		<!-- <div class="modal fade" id="loading" role="dialog">
			<div class="modal-dialog">

				<div class="modal-content" >

					<div class="modal-body">
						<input type="text" name="testInput" id="testInput" value="0"> -->
						
						<!-- <img src="{{asset('/images/loading.gif') }}" width="570px" height="400px" alt="logo"> -->
					<!-- </div>
				</div>
			</div>											      
		</div> -->
		<input type="hidden" name="msg" id="msg" value="0">
		<!-- <input type="hidden" name="textStr" id="testStr" value=""> -->
		<!-- <div id = 'msg'>This message will be replaced using Ajax. 
         Click the button to replace the message.</div> -->
	      <?php
	         //echo Form::button('Send Mail',['onClick'=>'testFunc(0)']);
	      ?>
	     <!--  @for($i=0;$i<count($toArr);$i++)
	      	{{$toArr[$i]}}
	      @endfor -->
	</body>
</html>	

@endsection	