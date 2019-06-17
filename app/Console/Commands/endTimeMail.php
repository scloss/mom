<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use DateTime;
use Mail;

class endTimeMail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mail-super';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){

  		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date_obj->setTime(00, 01, 00);
		$current_date = $current_date_obj->format('Y-m-d H:i:s');
		$current_date_previous_obj = new DateTime();//date('Y/m/d h:i:s', time() - 86400);
		$current_date_previous_obj->setTime(9, 00, 00);
		$current_date_previous_obj->modify('-20 day');
		$current_date_previous = $current_date_previous_obj->format('Y-m-d H:i:s');
  		$mom_table_t4_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE mom_status='active' and end_time BETWEEN '".$current_date_previous."' and '".$current_date."'; "));

  		$toArr = array();
  		$momArr = array();
  		$exists = false;

  		$daily_arr = array();
  		$all_supervisors_query = 'select distinct supervisor_name from hr_tool_db.employee_table';
  		$all_supervisors_lists = \DB::select(\DB::raw($all_supervisors_query));

  		$all_super_names = '';

  		foreach($all_supervisors_lists as $all_supervisors_list){
  			$all_super_names .= "'$all_supervisors_list->supervisor_name'".',';
  		}
  		$all_super_name = trim($all_super_names,',');

  		$all_supervisor_arr = array();
  		
  		$all_supervisor_query = "select email from login_plugin_db.login_table where user_name in ($all_super_name)";
  		$all_supervisor_email_lists = \DB::select(\DB::raw($all_supervisor_query));

  		foreach($all_supervisor_email_lists as $all_supervisor_email_list){
  			array_push($all_supervisor_arr, $all_supervisor_email_list->email);
  		}
  		//return $all_supervisor_arr;

  		foreach($mom_table_t4_lists as $mom_table_t4_list)
  		{
  			$meeting_lists =  \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$mom_table_t4_list->meeting_id."; "));

  			foreach($meeting_lists as $meeting_list)
  			{
  				$organizer_id = $meeting_list->meeting_organizer_id;
  				$meeting_title = $meeting_list->meeting_title;
  				$meeting_datetime = $meeting_list->meeting_datetime;
  				$meeting_id_arr = $meeting_list->meeting_id;
  			}

  			$user_table_t4_lists = \DB::select(\DB::raw("SELECT email,user_name,designation FROM login_plugin_db.login_table  WHERE user_id ='".$organizer_id."'; "));

  			foreach($user_table_t4_lists  as $user_table_t4_list)
  			{
  				$from = $user_table_t4_list->email;
  			}
  			
  			//$from = "showmen.barua@summitcommunications.net";
  			
  			$temp_responsible_arr = explode(',', $mom_table_t4_list->responsible);
  		
		  	
		 //  	$file = fopen('../TempFiles/test.html','a');

		  	$messages = '';

		  	//echo  $temp_responsible_arr;
		  	for($i=0;$i<count($temp_responsible_arr);$i++)
  			{
  				$toArr[$i]= $temp_responsible_arr[$i];


  				$email_to =  $toArr[$i];//."@summitcommunications.net";
  				$qeurySupervisorEmail = "select supervisor_email from hr_tool_db.supervisor_table where supervisor_name = (select supervisor_name from hr_tool_db.employee_table where email='".$email_to."')";
  				$user_table_lists = \DB::select(\DB::raw($qeurySupervisorEmail));
  				//print_r($user_table_lists); 
  				$user_list_names = \DB::select(\DB::raw("SELECT email,user_name,designation FROM login_plugin_db.login_table  WHERE email ='".$email_to."'; "));
  				foreach($user_list_names  as $user_list_name)
	  			{
	  				$u_name = $user_list_name->user_name;
	  				$u_designation = $user_list_name->designation;
	  			}
	  			
  				foreach($user_table_lists as $user_table_list)
  				{	
  					$supervisor_id = $user_table_list->supervisor_email;
  					
						if(array_key_exists($supervisor_id,$daily_arr)){
							$messages .= '<tr>';
							$messages .= "<td><b>(<a href='http://103.15.245.166:8005/mom/public/view?meeting_id=$mom_table_t4_list->meeting_id'>$mom_table_t4_list->meeting_id</a>)</b></td><td> $meeting_title</td>	
											<td>$meeting_datetime</td>
											<td><b>($mom_table_t4_list->mom_id)</b> $mom_table_t4_list->mom_title</td>
											<td>$mom_table_t4_list->start_time</td>
											<td>$mom_table_t4_list->end_time</td>
											<td>$mom_table_t4_list->comment</td>
											<td>$u_name ($u_designation)</td>";
							$messages .= '</tr>';
							$daily_arr[$supervisor_id] .= $messages;

						}
						else{
							$messages .= '<tr>';
							$messages .= "<td><b>(<a href='http://103.15.245.166:8005/mom/public/view?meeting_id=$mom_table_t4_list->meeting_id'>$mom_table_t4_list->meeting_id</a>)</b></td><td> $meeting_title</td>
											<td>$meeting_datetime</td>
											<td><b>($mom_table_t4_list->mom_id)</b> $mom_table_t4_list->mom_title</td>
											<td>$mom_table_t4_list->start_time</td>
											<td>$mom_table_t4_list->end_time</td>
											<td>$mom_table_t4_list->comment</td>
											<td>$u_name ($u_designation)</td>";
							$messages .= '</tr>';
							$daily_arr[$supervisor_id] = $messages;
							//echo "<br>"."<br>"."<br>".$supervisor_id."-----else----".$temp_responsible_arr[$i]."<br>"."<br>"."<br>";
							//$supervisor_id = '';
						}
						
						$messages = '';
					//}
  				}
  				

		  	}
		  	//$keys = array_keys($daily_arr);
		  	 		
  		} 
  		//$file = fopen('TempFiles/test.html','a');	
  		$keys = array_keys($daily_arr);

		//print_r($keys);

  		// for($i=0;$i<count($daily_arr);$i++){
  		foreach($daily_arr as $daily){
  			$messages_header  = "<style>
								table{
									border-collapse:collapse;
								}
								table th{
									background:#efcda2;
								}
								table th,td{
									border:1px solid black;
									font-family:verdana;
									font-size:12px;
								}

								/*table {
								  counter-reset: serial-number;  /* Set the serial number counter to 0 */
								}

								table td:first-child:before {
								  counter-increment: serial-number;  /* Increment the serial number counter */
								  content: counter(serial-number);  /* Display the counter */
								}*/

							  </style>
							  <!--<script type='text/javascript'  src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js'></script>-->
							  <script type='text/javascript'>
							 //  function addRowCount(tableAttr) {
								//   $(tableAttr).each(function(){
								//     $('th:first-child, thead td:first-child', this).each(function(){
								//       var tag = $(this).prop('tagName');
								//       $(this).before('<'+tag+'>#</'+tag+'>');
								//     });
								//     $('td:first-child', this).each(function(i){
								//       $(this).before('<td>'+(i+1)+'</td>');
								//     });
								//   });
								// }

								// Call the function with table attr on which you want automatic serial number
								//addRowCount('.js-serial');
								// $('.transactions tr td:first-child').each(function(i){
								//   $(this).before('<td>'+(i+1)+'</td>');
								// });
							  </script>	
								<html><body style='padding:10px;'>";
				$messages_header .= "<table class='css-serial' border='2'>";				
				$messages_header .= '<tr>';
				$messages_header .= '<th>ID</th>
							  <th>Meeting title</th>
							  <th>Meeting time</th>
							  <th>Action Point Title </th>
							  <th>Action Start Time</th>
							  <th>Action Deadline</th>
							  <th>Comment </th>
							  <th>Responsible</th>';
				$messages_header .= '</tr>';

				$messages_footer = "</table></body></html><br>";
			$from_super = array_search($daily, $daily_arr); 
  			$msg = 'Dear '.$from_super.',<br>Please be informed that below action points of your team members (Total:'.substr_count($daily, '<tr>').') have failed to meet their deadline. <br><br>'.$messages_header.$daily.$messages_footer.'Thanks & Best Regards<br> SCL MoM Tool<br><br><img src="http://103.15.245.166:8005/mom/public/images/mom_logo.jpg"><br><br> <i>This is an auto generated email. Please don’t reply. For any query please email to oss@summitcommunications.net.</i>'; 

  			$sub = 'Deadline missed MoM Action Points';
  			
  			if($from_super !='arif@summit-centre.com' && $from_super !='farid.khan@summitcommunications.net' && $from_super !='fadiah.khan@summit-centre.com' && $from_super !='rony.rashid@summitcommunications.net' && $from_super !='jasim.uddin@summitcommunications.net' && $from_super !='akm.badruddoza@summitcommunications.net')
  			{
  				//echo $msg;

  				$data = array( 'email' => 'showmen.barua@summitcommunications.net' , 'msg' => $msg , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );

				Mail::send(array(), array(), function ($message) use ($data) {
					  $message->from($data['from'], 'MOM TOOL');
					  $message->to($data['email'], '')
					    ->subject($data['sub'])
					    ->setBody($data['msg'], 'text/html');
				});


  				//echo $msg;
  			}

  			//fputs($file,$msg);
  			
			//echo $msg;

  		} 

  		//return $daily_arr;
		//fclose($file);
  	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	// protected function getArguments()
	// {
	// 	return [
	// 		['example', InputArgument::REQUIRED, 'An example argument.'],
	// 	];
	// }

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	// protected function getOptions()
	// {
	// 	return [
	// 		['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
	// 	];
	// }

}
