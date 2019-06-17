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
//$id = explode('@', $login_id);
$login_id = $_GET["login_id"];
$sql = "SELECT seen_users FROM mom_db.meeting_table where meeting_id=".$_GET['meeting_id'].";";
$result = mysqli_query($db, $sql);
$is_seen_before = false;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    	$seen_users_arr =  explode(",",$row["seen_users"]);
		for($i=0;$i<count($seen_users_arr);$i++){
			if($seen_users_arr[$i] == $login_id){
				$is_seen_before = true;
			}
		}
        //echo "id: " . $row["seen_users"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
}

if($is_seen_before == false){
	$db->query("UPDATE mom_db.meeting_table SET seen_users=CONCAT(',".$login_id."',seen_users) where meeting_id=".$_GET['meeting_id'].";");
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
		    background-color:#F0F5F9 ;
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
			background-color:#F0F5F9;
			/*width:200px;*/
			font-size: 18px;
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
		    background-color:#686868  ;
		    font-weight:normal;
		    color:#fff;
			width:200px;
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
		        'h4{text-align:center;}'+
		        'table{width:980;}' +
		        'table,table td{' +
		        'border:1px solid #000;' +
		        'border-collapse: collapse;'+
				'overflow:auto;'+
				'word-wrap:break-word;'+
				'margin-top:5%;'+
				'text-align:center;'+
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
	<body id="body_id">

		<center>
		<h3>Hello, Thanks for attending the meeting. You can download the MOM details from below links</h3>
		<!--<input type="button" onclick='printTest("formDiv","titleBar")' class="btn" value="Print" /> -->
		<input type="button" onclick="location.href='{{ url('pdfDownload') }}?meeting_id={{$meeting_id}}&mother_meeting_id={{$mother_meeting_id}}';"  class="btn" value="PDF" >
		@if($meeting_files == true)
			<input type="button" onclick="location.href='{{URL('downloadZip?meeting_id='.$meeting_id)}}';" class="btn" value="Download Meeting Files" />	
		@endif	
		</center>
	</body>
			<!-- <input type="button" onclick="location.href='{{URL('/landing')}}';" class="btn" value="Go to Login" />	
			<p>Your Response is sent to the Organizer</p> -->
		

	</body>