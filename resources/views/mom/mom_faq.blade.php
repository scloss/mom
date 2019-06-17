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
		<!--<script type="text/javascript" src="{{ asset('/js/test.js') }}"></script>-->
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	 
	    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<style>
		table td{
				text-align: left !important;
				padding:10px;
			}
		</style>
		<script type="text/javascript">
		
        </script>
	</head>
	<body>
		<div id="titleBar">
			<h4>MOM FAQ</h4>
		</div>
		<div class="container-fluid" style="min-height:457px;">
			<div class="content">
				<table>
					<tr><td colspan="2"><b>1. What is the color red, green, yellow row color means in dashboard?</b></td></tr>
					<tr>
						<td>
							<tr>
								<td style="background:#82DA4A;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Green</b></td><td>When Completion Percentage (100) %</td>
							</tr>
							<tr>
								<td style="background:#C7CA33;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Olive</b></td><td>When Completion Percentage (>66) %</td>
							</tr>
							<tr>
								<td style="background:#FDFF80;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Yellow</b></td><td>When Completion Percentage (33-66) %</td>
							</tr>
							<tr>
								<td style="background:#FF9C9C;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Red</b></td><td>When Completion Percentage (0-33) %</td>
							</tr>
						</td>
					</tr>
					<tr><td colspan="2"><b>2. What is the blinking red, green, yellow means?</b></td></tr>
					<tr>
						<td>
							<tr>
								<td style="background:#82DA4A;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Green</b></td><td>When Nearest MOM end time > 5 days</td>
							</tr>
							<tr>
								<td style="background:#FDFF80;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Yellow</b></td><td>When Nearest MOM end time < 5 days</td>
							</tr>
							<tr>
								<td style="background:#FF9C9C;color:#000;text-align:center !important;width:50px;border-radius:50%;padding:25px;"><b>Red</b></td><td>When Nearest MOM end time < 2 days</td>
							</tr>
						</td>
					</tr>
					<tr><td colspan="2"><b>3.In Dashboard Admin vs Super Admin</b></td></tr>
					<tr>
						<td colspan="2">In Dashboard <b>Admin</b> can see <b>all his department's</b> weekly, monthly, ad-hoc meetings with other Departments</td>
					</tr>
					<tr>	
						<td colspan="2">But <b>Super Admin</b> can select the Initiator Departments which enables him to see <b>every department's</b> weekly, monthly, ad-hoc meetings.</td>

					</tr>
					<tr><td colspan="2"><b>4. How to create MOM?</b></td></tr>
					<tr>
						<td colspan="2">First go to Create New Meeting Page</td>
					</tr>
					<tr>	
						<td colspan="2">Then user must fill all the fields</td>
					</tr>
					<tr>	
						<td colspan="2"><b>Input method for Meeting Attendee :</b> User can type in the Meeting Attendee select box and it will suggest the email ids and user can press the  <b> >> </b>       button
						and fill the Meeting Attendee and Mail Recipient and Attendee Department input fields.
						</td>
					</tr>
					<tr>	
						<td colspan="2"><b>Add Action Point :</b> On the bottom left corner there is a button name add action point. It will generate a form where user can assign an action point. User can create multiple action points.</td>
					</tr>
					<tr>
						<td colspan="2"><b>Add Responsible :</b>When you click the responsible field you will see a page opens which contains all the users of SCL you can search and click to add them in the checklist and when you think you added all the responsibles hit submit.</td>
					</tr>

					<tr><td colspan="2"><b>5. How to resend MoM to persons who missed the MoM mail?</b></td></tr>
					<tr>
						<td colspan="2">Go to edit view of that MoM then hit resend mail button and select the persons you want to send mail and hit submit.</td>
					</tr>
					<tr><td colspan="2"><b>6. Want to send message to OSS</b></td></tr>
					<tr>
						<td colspan="2">Go to contact page then type your message and hit submit to send mail to OSS</td>
					</tr>
					<tr><td colspan="2"><b>7. Green and Red right mark</b></td></tr>
					<tr>
						<td colspan="2">Green right mark means you have action point on that MoM and you closed(finished) all of them. Red right mark means your action points are still open(undone)</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
@endsection	