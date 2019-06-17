<?php namespace App\Http\Controllers;
?>
<?php
// Start the session
ini_set('max_execution_time', 300);
session_start();
?>
<?php

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MailHelpers\phpMailer;
use Mail;
use Request;
use DateTime;
use \Input as Input;
use File;
use App\Http\Controllers\ZipArchive;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use PDF;
use Exception;
use DB;

class MomController extends Controller {

	private $count = 0;

	public function index()
	{
		//return view('mom.momLanding');
	}
	public function is_autenticated(){

		if(isset($_SESSION['dashboard_user_id'])){
			//$_SESSION['dashboard_user_id'] = 'ali.mehraj';
			$userId = $_SESSION['dashboard_user_id'];
			$_SESSION['testCount'] = 0;
			$adminQuery = "select * from mom_db.admintable where user_id='$userId'";
			$adminLists = \DB::select(\DB::raw($adminQuery));
			if($adminLists != null){
				$_SESSION["USERTYPE"] = 'admin';
				return 'admin';
			}
			else{
				$superAdminQuery = "select * from mom_db.super_table where user_id='$userId'";
				$superAdminLists = \DB::select(\DB::raw($superAdminQuery));
				//return $superAdminQuery;
				if($superAdminLists != null){
					$_SESSION["USERTYPE"] = 'superAdmin';
					return 'superAdmin';
				}
				else{
					$_SESSION["USERTYPE"] = 'user';
					return 'user';
				}
			}
		}
		else{
			return 'nopass';
		}
	}
	//get everything from meeting table if active and attendee is the current user 
	public function dashboard(){
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}
		$input_year_month = Request::get('yearMonth');
		$input_month_date = date('m',strtotime($input_year_month));
		$input_year_date = date('Y',strtotime($input_year_month));

		$meeting_schedule_type = Request::get('meeting_schedule_type');
		$initiator_dept = Request::get('initiator_dept');
		$attended_dept = Request::get('attended_dept');
		$initiator_dept_all = Request::get('initiator_dept_all');
		$meeting_type = Request::get("meeting_type");
		if($meeting_schedule_type == null){
			$initiator_dept = $_SESSION['dept'];
			$attended_dept = $_SESSION['dept'];
			$meeting_schedule_type = 'AD-HOC';
		}
		$dept_lists = \DB::select(\DB::raw("SELECT DISTINCT(dept) FROM login_plugin_db.login_table ;"));
		$meeting_schedule_type_list = ["AD-HOC","Weekly","Monthly","Bi-Weekly"];

		if($val == "superAdmin"){
			$initiator_dept = Request::get('initiator_dept');
		}
		else{
			$initiator_dept = addslashes($_SESSION['dept']);
		}

		// $ddate = "2012-10-18";
		// $date = new DateTime($ddate);
		// $week = $date->format("W");

		

		$meeting_lists_query = "SELECT * FROM mom_db.meeting_table  WHERE initiator_dept like '%".$initiator_dept."%' AND attendee_dept like '%".addslashes($attended_dept)."%' AND meeting_schedule_type like '%".$meeting_schedule_type."%' AND YEAR(meeting_datetime)='".$input_year_date."' AND meeting_type='".$meeting_type."'" ;
		$meeting_lists = \DB::select(\DB::raw($meeting_lists_query));

		//return $meeting_lists_query;
		$week_list_arr = array();
		$count = 0;
		if($meeting_schedule_type == 'Weekly' || $meeting_schedule_type == 'AD-HOC' || $meeting_schedule_type =='Bi-Weekly')
		{
			foreach($meeting_lists as $meeting_list){
				$date = new DateTime($meeting_list->meeting_datetime);
				$date->modify('+1 day');
				$week = $date->format("W");
				$temp_week = 'week'.$count;
				$temp_title = 'title'.$count;
				$temp_datetime = 'datetime'.$count;
				$meeting_id = 'meeting_id'.$count;
				$temp_mother_id = 'mother_id'.$count;
				$temp_meeting_type = 'meeting_type'.$count;
				$week_list_arr["$temp_week"]=$week;
				$week_list_arr["$temp_title"]=$meeting_list->meeting_title;
				$week_list_arr["$temp_datetime"]=$meeting_list->meeting_datetime;
				$week_list_arr["$temp_mother_id"]=$meeting_list->mother_meeting_id;
				$week_list_arr["$meeting_id"]=$meeting_list->meeting_id;
				$week_list_arr["$temp_meeting_type"]=$meeting_list->meeting_type;
				$count++;
			
			}

		}
		if($meeting_schedule_type == 'Monthly'){
			foreach($meeting_lists as $meeting_list){
				$date = new DateTime($meeting_list->meeting_datetime);

				$month = $date->format("m");
				$temp_month = 'month'.$count;
				$temp_title = 'title'.$count;
				$temp_datetime = 'datetime'.$count;
				$meeting_id = 'meeting_id'.$count;
				$temp_mother_id = 'mother_id'.$count;
				$temp_meeting_type = 'meeting_type'.$count;
				$week_list_arr["$temp_month"]=$month;
				$week_list_arr["$temp_title"]=$meeting_list->meeting_title;
				$week_list_arr["$temp_datetime"]=$meeting_list->meeting_datetime;
				$week_list_arr["$temp_mother_id"]=$meeting_list->mother_meeting_id;
				$week_list_arr["$meeting_id"]=$meeting_list->meeting_id;
				$week_list_arr["$temp_meeting_type"]=$meeting_list->meeting_type;
				$count++;
			
			}
		}
		$meeting_schedule_type_list_all = ["All-Weekly","All-Monthly","All-Bi-Weekly"];
		$dept_id_list ='';

		//return $val;
		//return $week_list_arr;
		return view('mom.dashboard',compact('meeting_schedule_type_list','dept_lists','week_list_arr','count','meeting_schedule_type','initiator_dept','attended_dept','meeting_schedule_type_list_all','dept_id_list','initiator_dept_all','val'));
	}

	public function dashboard_dept_wise(){
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}
		$input_year_month = Request::get('yearMonth');
		$input_month_date = date('m',strtotime($input_year_month));
		$input_year_date = date('Y',strtotime($input_year_month));
		
		$dept_id_list = ['Planning Architecture & Design'=>'1','Implementation'=>'2','Operations & Maintenance - 1'=>'3','Operations & Maintenance - 2'=>'4','NOC'=>'5','Power & Projects'=>'6','Gateway Operations'=>'7','IIG'=>'8','ICX'=>'9','ITC'=>'10','IIG&ITC'=>'11','Coordination'=>'12','Revenue Assurance'=>'13','Service Assurance'=>'14','Sales & Marketing'=>'15','Mobile Financial Services'=>'16','Business Devlopment'=>'17','Treasury'=>'18','Accounts'=>'19','Billing'=>'20','Internal Control & Audit'=>'21','Finance'=>'22','N/A'=>'23','Company Secretariat'=>'24','Supply Chain'=>'25','IT'=>'26'];

		$dept = $_SESSION['dept'];
		$initiator_dept = $_SESSION['dept'];
		$attended_dept = '';
		$meeting_schedule_type = Request::get('meeting_schedule_type');
		$initiator_dept_all = Request::get('initiator_dept_all');
		

		$dept_lists = \DB::select(\DB::raw("SELECT DISTINCT(dept) FROM login_plugin_db.login_table ;"));
		$meeting_schedule_type_list = ["AD-HOC","Weekly","Monthly"];
		$meeting_schedule_type_list_all = ["All-Weekly","All-Monthly","All-Bi-Weekly"];

		if($meeting_schedule_type == '')
		{
			$meeting_schedule_type_converted = 'Weekly';
		}

		if($meeting_schedule_type == 'All-Weekly'){
			$meeting_schedule_type_converted = 'Weekly';
		}
		if($meeting_schedule_type == 'All-Monthly'){
			$meeting_schedule_type_converted = 'Monthly';
		}
		if($meeting_schedule_type == 'All-Bi-Weekly'){
			$meeting_schedule_type_converted = 'Bi-Weekly';
		}

		$meeting_lists_query = "SELECT * FROM mom_db.meeting_table  WHERE initiator_dept='".addslashes($initiator_dept_all)."' AND meeting_schedule_type ='".addslashes($meeting_schedule_type_converted)."' AND YEAR(meeting_datetime)='".$input_year_date."'" ;
		$meeting_lists = \DB::select(\DB::raw($meeting_lists_query));

		//return $meeting_lists;
		$week_list_arr = array();
		$count = 0;
		$dept_meeting_attended_count = array();
		
		if($meeting_schedule_type == 'All-Weekly' || $meeting_schedule_type == 'All-Bi-Weekly'){
			foreach($meeting_lists as $meeting_list){
				

					$temp_attendee_dept_arr = explode(',',$meeting_list->attendee_dept);
					//return $temp_attendee_dept_arr;
					if(count($temp_attendee_dept_arr)==0){
						$date = new DateTime($meeting_list->meeting_datetime);
						$date->modify('+1 day');
						$week = $date->format("W");

						$temp_week = 'week__'.$count;
						$temp_dept_attended = 'attended_dept__'.$count;
						$week_list_arr["$temp_week"]=$week.",".$dept_id_list[$meeting_list->attendee_dept];		
						//$week_list_arr["$temp_dept_attended"]=$dept_id_list[$meeting_list->attendee_dept];
						$dept_meeting_attended_count["$temp_dept_attended"] = $dept_id_list[$meeting_list->attendee_dept];
						$count++;
					}
					else{
						for($s=0;$s<count($temp_attendee_dept_arr);$s++){
							$date = new DateTime($meeting_list->meeting_datetime);
							$date->modify('+1 day');
							$week = $date->format("W");

							$temp_week = 'week__'.$count;
							$temp_dept_attended = 'attended_dept__'.$count;
							$week_list_arr["$temp_week"]=$week.",".$dept_id_list[$temp_attendee_dept_arr[$s]];		
							//$week_list_arr["$temp_dept_attended"]=$dept_id_list[$meeting_list->attendee_dept];
							$dept_meeting_attended_count["$temp_dept_attended"] = $dept_id_list[$temp_attendee_dept_arr[$s]];
							$count++;
						}
					}

					
					//return 	$week_list_arr;

			}
			$week_list_arr = array_unique($week_list_arr);
			$week_list_arr_values = array_values($week_list_arr);
			//$week_list_arr = array();
			unset($week_list_arr);
			for($i=0;$i<count($week_list_arr_values);$i++){
				$week_list_arr['week__'.$i] = $week_list_arr_values[$i];
			}
		}

		if($meeting_schedule_type == 'All-Monthly'){
			$count = 0;
			foreach($meeting_lists as $meeting_list){


				$temp_attendee_dept_arr = explode(',',$meeting_list->attendee_dept);
				//return $temp_attendee_dept_arr;

				if(count($temp_attendee_dept_arr)==0){
					$date = new DateTime($meeting_list->meeting_datetime);
					$month = $date->format("m");
					//echo $month;
					$temp_month = 'month__'.$count;
					$temp_dept_attended = 'attended_dept__'.$count;
					$week_list_arr["$temp_month"]=$month.','.$dept_id_list[$meeting_list->attendee_dept];		
					// $week_list_arr["$temp_dept_attended"]=$dept_id_list[$meeting_list->attendee_dept];
					$dept_meeting_attended_count["$temp_dept_attended"] = $dept_id_list[$meeting_list->attendee_dept];
					$count++;
				}
				else{
					for($s=0;$s<count($temp_attendee_dept_arr);$s++){
						$date = new DateTime($meeting_list->meeting_datetime);
						$month = $date->format("m");
						//echo $month;
						$temp_month = 'month__'.$count;
						$temp_dept_attended = 'attended_dept__'.$count;
						$week_list_arr["$temp_month"]=$month.','.$dept_id_list[$temp_attendee_dept_arr[$s]];		
						// $week_list_arr["$temp_dept_attended"]=$dept_id_list[$temp_attendee_dept_arr[$s]];
						$dept_meeting_attended_count["$temp_dept_attended"] = $dept_id_list[$temp_attendee_dept_arr[$s]];
						$count++;
						//print_r($week_list_arr);
					}
				}
				
				//echo "count : ".$count." list:".$$dept_meeting_attended_count["$temp_dept_attended"];
			}
			$week_list_arr = array_unique($week_list_arr);
			$week_list_arr_values = array_values($week_list_arr);
			//return $week_list_arr_values;
			//$week_list_arr = array();
			unset($week_list_arr);
			for($i=0;$i<count($week_list_arr_values);$i++){
				$week_list_arr['month__'.$i] = $week_list_arr_values[$i];
			}
		}
		//return $dept_meeting_attended_count;
		


		//print_r($week_list_arr);

		$count_arr = array();
		$actual_count_arr = array_count_values($dept_meeting_attended_count);
		//print_r($actual_count_arr);
		for($i=1;$i<27;$i++){
			if(array_key_exists($i,$actual_count_arr)){
				$count_arr[$i] = $actual_count_arr[$i];
			}
			else{
				$count_arr[$i] = 0;
			}
		}
		//return $count;
		//return $week_list_arr;
		$count = count($week_list_arr);
		return view('mom.dashboard',compact('meeting_schedule_type_list','dept_lists','week_list_arr','count','meeting_schedule_type','dept_id_list','meeting_schedule_type_list_all','initiator_dept','attended_dept','count','val','initiator_dept_all','count_arr'));

	}

	public function landing_view()
	{
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$showAll = Request::get('showAll');


		$currentUser = $_SESSION['dashboard_user_id'];
		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date = $current_date_obj->format('Y-m-d');
		//return 'asdf';
		// $meeting_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_status='active' AND meeting_attendee LIKE '%$currentUser%' 	OR mail_recipient LIKE '%$currentUser%' ORDER BY meeting_id DESC;"));
		$meeting_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_status='active' AND  mail_recipient LIKE '%$currentUser%' ORDER BY meeting_id DESC;"));

		if($showAll != null){
			if($val == "admin"){
				$meeting_query = "SELECT * FROM mom_db.meeting_table WHERE meeting_status='active' AND initiator_dept='%".addslashes($_SESSION["dept"])."%' OR attendee_dept like '%".addslashes($_SESSION["dept"])."%' ORDER BY meeting_id DESC ;";
				$meeting_lists = \DB::select(\DB::raw($meeting_query));
				//return $meeting_query;
			}
			if($val == "superAdmin"){
				$meeting_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_status='active' ORDER BY meeting_id DESC ;"));
			}
		}

		$meeting_lists_with_responsible = array();
		$mom_name_list = array();
		$green_meeting_lists_responsible = array();
		$mom_furthest_endtime_list = array();


		if($meeting_lists != null){
			$meeting_id_put = array();
		$i=0;
		$meeting_id_str = '';
		foreach($meeting_lists as $meeting_list)
		{
			$meeting_id_put[$i] = $meeting_list->meeting_id;
			$meeting_id_str .= $meeting_list->meeting_id.',';
			$i++;
		}
		
		
		$preg_id = $_SESSION["dashboard_user_id"];

		for($j=0;$j<count($meeting_id_put);$j++)
		{
			$mom_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id=".$meeting_id_put[$j].";"));
			$min_date = null;
			$mom_name = null;
			foreach($mom_lists as $mom_list)
			{
				//$mom_title = 
				if($min_date==null)
				{
					$min_date = $mom_list->end_time;
					$mom_name = $mom_list->mom_title;
					
					if (preg_match("/$preg_id/", $mom_list->responsible)){
						array_push($meeting_lists_with_responsible, $meeting_id_put[$j]);
						if($mom_list->mom_status == 'closed'){
							array_push($green_meeting_lists_responsible, $meeting_id_put[$j]);
						}
					}
				}
				else
				{
					if($mom_list->end_time < $min_date)
					{
						$min_date = $mom_list->end_time;
						$mom_name = $mom_list->mom_title;
						if (preg_match("/$preg_id/", $mom_list->responsible)){
							array_push($meeting_lists_with_responsible, $meeting_id_put[$j]);
							if($mom_list->mom_status == 'closed'){
								array_push($green_meeting_lists_responsible, $meeting_id_put[$j]);
							}
						}
					}
					else
					{
						$min_date = $min_date;
						$mom_name = $mom_name;
						if (preg_match("/$preg_id/", $mom_list->responsible)){
							array_push($meeting_lists_with_responsible, $meeting_id_put[$j]);
							if($mom_list->mom_status == 'closed'){
								array_push($green_meeting_lists_responsible, $meeting_id_put[$j]);
							}
						}
					}
				}
			}
			$mom_furthest_endtime_list[$j] = $min_date;
			$mom_name_list[$j] = $mom_name;
		}
		$yellow_date1_obj = new DateTime();
		$yellow_date1_obj->setTime(00, 01, 00);
		$yellow_date1_obj->modify('+2 day');
		$yellow_date1 = $yellow_date1_obj->format('Y-m-d');

		$yellow_date2_obj = new DateTime();
		$yellow_date2_obj->setTime(00, 01, 00);
		$yellow_date2_obj->modify('+5 day');
		$yellow_date2 = $yellow_date2_obj->format('Y-m-d');

		$meeting_id_str = trim($meeting_id_str,',');
		//return $meeting_id_str;
		$meeting_lists = DB::table('mom_db.meeting_table')   
	    ->selectRaw('*')
	    ->whereRaw("meeting_id IN ($meeting_id_str)")
	    ->orderBy("meeting_id",'desc')
	    ->paginate(10);
		}
		else{
			// $meeting_id_str = trim($meeting_id_str,',');
			$meeting_lists = DB::table('mom_db.meeting_table')   
		    ->selectRaw('*')
		    ->whereRaw("meeting_id=0")
		    ->paginate(10);
			
		}
		

		
		//return $green_meeting_lists_responsible;

		return view('mom.momLanding',compact('meeting_lists','current_date','mom_furthest_endtime_list','yellow_date1','yellow_date2','mom_name_list','val','meeting_lists_with_responsible','green_meeting_lists_responsible'));
	}
//return a view of the meetings that has the selected mother_meeting_id
	public function follow_up_view()
	{

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$mother_meeting_id = Request::get('mother_meeting_id');
		$currentUser = $_SESSION['dashboard_user_name'];
		$queryString = "SELECT * FROM mom_db.meeting_table WHERE mother_meeting_id=".$mother_meeting_id." ;";
		$meeting_lists = \DB::select(\DB::raw($queryString));

		$meeeting_schedule_type_list = array("AD-HOC","Monthly","Weekly","Bi-Weekly");

		//return $meeting_lists;
		return view('mom.followup_view',compact('meeting_lists','meeeting_schedule_type_list'));
	}

	public function follow_up_action_point_view()
	{

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$mother_mom_id = Request::get('mother_mom_id');
		$currentUser = $_SESSION['dashboard_user_name'];
		$queryString = "SELECT * FROM mom_db.mom_table WHERE mother_mom_id=".$mother_mom_id." ;";
		$mom_lists = \DB::select(\DB::raw($queryString));

		$meeeting_schedule_type_list = array("AD-HOC","Monthly","Weekly","Bi-Weekly");

		//return $mom_lists;
		return view('mom.followup_view_ap',compact('mom_lists','meeeting_schedule_type_list'));
	}
//return to create view 
	public function do_entry()
	{

		
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'projectMeeting'  => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active'
		];
		//$check_mom = Request::get('error');
		//return $meeting_type_drop;
		
		return view('mom.entry',compact('meeting_type_drop','meeting_status_drop'));
	}
//process the data and return to landing after insert
	public function entry()
	{

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$check_meeting_title = Request::get('meeting_title');
		$check_mom_title = Request::get('mom_title1');
		$check_static_mom_title = Request::get('static_mom_title_prev1');
		$meeting_schedule_type = Request::get('meeting_schedule_type');

		$staticLoopCount = Request::get('count_prev');
		//return $staticLoopCount;
		//return '';

		//return $check_mom_title;
		$mail_recipient_arr_total = array();

		$mail_recipient_index_arr = Request::get('mail_recipient_index');
		
		if(count($mail_recipient_index_arr) == 1)
		{
			$mail_recipient = $mail_recipient_index_arr[0];
			array_push($mail_recipient_arr_total, $mail_recipient);
		}
		else
		{
			$mail_recipient = implode (",", $mail_recipient_index_arr);
			foreach($mail_recipient_index_arr as $recipient){
				array_push($mail_recipient_arr_total, $recipient);
			}
		}

		$meeting_attendee_index_arr = Request::get('meeting_attendee_index');
		
		if(count($meeting_attendee_index_arr) == 1)
		{
			$meeting_attendee = addslashes($meeting_attendee_index_arr[0]);
		}
		else
		{
			$meeting_attendee = implode (",", $meeting_attendee_index_arr);
		}




		$attendee_dept_index_arr = Request::get('attendee_dept_index');
		
		if(count($attendee_dept_index_arr) <= 1)
		{
			$attendee_dept = addslashes($attendee_dept_index_arr[0]);
		}
		else
		{
			$temp_arr_attendee = array();
			for($j=0;$j<count($attendee_dept_index_arr);$j++){
				$temp_arr_attendee[$j] = addslashes($attendee_dept_index_arr[$j]);
			}
			$attendee_dept = implode (",", $temp_arr_attendee);
		}
		//$input = Request::all();
		//return $attendee_dept_index_arr;




		if( !$check_mom_title && !$check_static_mom_title )
		{
			//return $staticLoopCount;
			//$_SESSION["MOMADD"] = 'Please Create at least one MoM';
			$meeting_title = Request::get('meeting_title');
			$meeting_datetime = Request::get('meeting_datetime');
			//$meeting_attendee = Request::get('meeting_attendee');
			//$mail_recipient = Request::get('mail_recipient');
			$meeting_type = Request::get('meeting_type');
			$meeting_status = Request::get('meeting_status');
			$completion = '0.0';
			$meeting_decision = Request::get('meeting_decision');
			$meeting_comment_latest = Request::get('meeting_comment');

			$meeting_decision = addslashes($meeting_decision);
			$meeting_decision = str_replace(";","&#59;",$meeting_decision);
			//$files = Request::get('meeting_files');
			
		 	//return $meeting_files;
			date_default_timezone_set('Asia/Dhaka');
			$date_of_comment = date('Y/m/d h:i:s', time());
		
			$meeting_comment = $_SESSION['dashboard_user_id']."[".$date_of_comment."] : ".$meeting_comment_latest;
			$meeting_comment = addslashes($meeting_comment);
			$meeting_comment = str_replace(";","&#59;",$meeting_comment);
			$seen_users = '';
			if(isset($_SESSION['dashboard_user_id']))
			{
				$userId = $_SESSION['dashboard_user_id'];
			}
			
			$queryInsertMeeting = "INSERT INTO mom_db.meeting_table (meeting_title, meeting_datetime, meeting_attendee, mail_recipient, meeting_type,meeting_status,completion, mother_meeting_id,meeting_organizer_id,meeting_decision,seen_users,meeting_comment,meeting_files,initiator_dept,attendee_dept,meeting_schedule_type ) 
			values ('".addslashes($meeting_title)."','".$meeting_datetime."','".$meeting_attendee."','".$mail_recipient."','".$meeting_type."','".$meeting_status."','".$completion."',' ','".$userId."','".addslashes($meeting_decision)."','".$seen_users."','".addslashes($meeting_comment)."','','".addslashes($_SESSION["dept"])."','".$attendee_dept."','".$meeting_schedule_type."')";
			//return $queryInsertMeeting;

			$meetingEntry =\DB::insert(\DB::raw($queryInsertMeeting));
			
			$meetingIdList = \DB::select(\DB::raw("SELECT meeting_id FROM mom_db.meeting_table ORDER BY meeting_id DESC LIMIT 1;"));

			foreach ($meetingIdList as $row) {
				$meetingId = $row->meeting_id;
			}
		
			if(Input::hasFile('meeting_files'))
		 	{
		 		$path = 'MeetingFiles/'.$meetingId;
		 		$meeting_files = $path."/";
				if(!File::exists($path)) 
				{
					$dirPath = '../MeetingFiles/'.$meetingId;
		    		$result = File::makeDirectory($dirPath);
			 		$files = Input::file('meeting_files');
			 		foreach($files as $file)
			 		{
			 			$filename = $file->getClientOriginalName();
			 			$file->move($dirPath,$filename);
			 		}
			 		//return $meeting_files;
		 		}
		 		else
		 		{
		 			$dirPath = '../MeetingFiles/'.$meetingId;
		 			$files = Input::file('meeting_files');
			 		foreach($files as $file)
			 		{
			 			$filename = $file->getClientOriginalName();
			 			$file->move($dirPath,$filename);
			 		}
			 		//return $meeting_files;
		 		}
		 	}
		 	else
		 	{
		 		$meeting_files = null;
		 	}

			$mother_meeting_id = Request::get('mother_meeting_id');
			$mother_meeeting_id_log = $mother_meeting_id;
			if($mother_meeting_id)
			{
				$meeting_update_querystring = "UPDATE mom_db.meeting_table SET mother_meeting_id=".$mother_meeting_id.",meeting_files='".$meeting_files."' WHERE meeting_id=".$meetingId.";" ;
				\DB::update(\DB::raw($meeting_update_querystring));
				$mother_meeeting_id_log = $mother_meeting_id;
			}
			else
			{
				$meeting_update_querystring = "UPDATE mom_db.meeting_table SET mother_meeting_id=".$meetingId.",meeting_files='".$meeting_files."' WHERE meeting_id=".$meetingId.";" ;
				\DB::update(\DB::raw($meeting_update_querystring));
				$mother_meeeting_id_log = $meetingId;
			}

			$queryInsertMeetingLog = "INSERT INTO mom_db.meeting_table_log (meeting_id,meeting_title, meeting_datetime, meeting_attendee, mail_recipient, meeting_type,meeting_status,completion, mother_meeting_id,meeting_organizer_id,meeting_decision,seen_users,meeting_comment,meeting_files,initiator_dept,attendee_dept,meeting_schedule_type ) 
			values ('".$meetingId."','".addslashes($meeting_title)."','".$meeting_datetime."','".$meeting_attendee."','".$mail_recipient."','".$meeting_type."','".$meeting_status."','".$completion."',".$mother_meeeting_id_log.",'".$userId."','".addslashes($meeting_decision)."','".$seen_users."','".addslashes($meeting_comment)."','','".addslashes($_SESSION["dept"])."','".$attendee_dept."','".$meeting_schedule_type."')";
			\DB::insert(\DB::raw($queryInsertMeetingLog));

			$recipient_arr = explode(',', $mail_recipient);
		 	// $mom_mail_responsible = array();
		 	// for($m=0;$m<count($responsible_arr);$m++)
		 	// {
		 	// 	$mail_recipient_single = explode(',', $responsible_arr[$m]);
		 	// 	for($n=0;$n<count($mail_recipient_single);$n++)
		 	// 	{
		 	// 		array_push($mom_mail_responsible, $mail_recipient_single[$n]);
		 	// 	}
		 	// }
		 	// $recipient_arr = array_merge($recipient_arr,$mom_mail_responsible);
		 	$recipient_arr = array_unique($recipient_arr);
		 	$recipient_arr = array_values($recipient_arr);
		 	//print_r($recipient_arr);
		 	$toArr = array();
		 	$login_id_arr = array();
		 	for($i=0;$i<count($recipient_arr);$i++)
		 	{
		 		$toData = $recipient_arr[$i];
		 		$loginData = $recipient_arr[$i];
		 		array_push($login_id_arr, $loginData);
		 		array_push($toArr, $toData);
		 	}
		 	$from = $_SESSION['email'];

		 	$organizer_name = $_SESSION['dashboard_user_name'];

		 	//$this->createMail($from,$toArr,$login_id_arr,$meetingId,$organizer_name);
		 	$meeting_id = $meetingId;
		 	return view('mom.mail_sending_view',compact('from','toArr','login_id_arr','meeting_id','organizer_name'));

			//return redirect('/');
		}
		$_SESSION["MOMADD"] = '';
		$meeting_title = Request::get('meeting_title');
		$meeting_datetime = Request::get('meeting_datetime');
		//$meeting_attendee = Request::get('meeting_attendee');
		//$mail_recipient = Request::get('mail_recipient');
		$meeting_type = Request::get('meeting_type');
		$meeting_status = Request::get('meeting_status');
		$completion = '0.0';
		$meeting_decision = Request::get('meeting_decision');
		$meeting_comment_latest = Request::get('meeting_comment');

		$meeting_decision = addslashes($meeting_decision);
		$meeting_decision = str_replace(";","&#59;",$meeting_decision);
		//$files = Request::get('meeting_files');
		
	 	//return $meeting_files;
		date_default_timezone_set('Asia/Dhaka');
		$date_of_comment = date('Y/m/d h:i:s', time());
	
		$meeting_comment = $_SESSION['dashboard_user_id']."[".$date_of_comment."] : ".$meeting_comment_latest;
		$meeting_comment = addslashes($meeting_comment);
		$meeting_comment = str_replace(";","&#59;",$meeting_comment);
		$seen_users = '';
		if(isset($_SESSION['dashboard_user_id']))
		{
			$userId = $_SESSION['dashboard_user_id'];
		}
		$mom_count = Request::get('count_mom');
		$loopCountTotal = count($mom_count);
		
		if($loopCountTotal >'0'){
			
			for($i = 0;$i<$loopCountTotal; $i++)
			{
				$counter = $i + 1;
				$responsible_val = Request::get('responsible'. $counter);
				if (preg_match("/,/", $responsible_val)){
					$responsible_val_arr = explode(',',$responsible_val);
					foreach($responsible_val_arr as $val_temp){
						array_push($mail_recipient_arr_total, $val_temp);
					}
				}
				else{
					array_push($mail_recipient_arr_total, $responsible_val);
				}
				

				
				//$mom_completion_time[$i] = Request::get('mom_completion_time' . $counter);
			}
		}

		$mail_recipient_arr_totals = array_unique($mail_recipient_arr_total);
		$mail_recipient = implode(',', $mail_recipient_arr_totals);

		//return $mail_recipient_arr_totals;

		$queryInsertMeeting = "INSERT INTO mom_db.meeting_table (meeting_title, meeting_datetime, meeting_attendee, mail_recipient, meeting_type,meeting_status,completion, mother_meeting_id,meeting_organizer_id,meeting_decision,seen_users,meeting_comment,meeting_files,initiator_dept,attendee_dept,meeting_schedule_type ) 
		values ('".addslashes($meeting_title)."','".$meeting_datetime."','".$meeting_attendee."','".$mail_recipient."','".$meeting_type."','".$meeting_status."','".$completion."',' ','".$userId."','".addslashes($meeting_decision)."','".$seen_users."','".addslashes($meeting_comment)."','','".addslashes($_SESSION["dept"])."','".$attendee_dept."','".$meeting_schedule_type."')";
		//return $queryInsertMeeting;

		$meetingEntry =\DB::insert(\DB::raw($queryInsertMeeting));

		


		$meetingIdList = \DB::select(\DB::raw("SELECT meeting_id FROM mom_db.meeting_table ORDER BY meeting_id DESC LIMIT 1;"));

		foreach ($meetingIdList as $row) {
			$meetingId = $row->meeting_id;
		}

		if(Input::hasFile('meeting_files'))
	 	{
	 		$path = 'MeetingFiles/'.$meetingId;
	 		$meeting_files = $path."/";
			if(!File::exists($path)) 
			{
				$dirPath = '../MeetingFiles/'.$meetingId;
	    		$result = File::makeDirectory($dirPath);
		 		$files = Input::file('meeting_files');
		 		foreach($files as $file)
		 		{
		 			$filename = $file->getClientOriginalName();
		 			$file->move($dirPath,$filename);
		 		}
		 		//return $meeting_files;
	 		}
	 		else
	 		{
	 			$dirPath = '../MeetingFiles/'.$meetingId;
	 			$files = Input::file('meeting_files');
		 		foreach($files as $file)
		 		{
		 			$filename = $file->getClientOriginalName();
		 			$file->move($dirPath,$filename);
		 		}
		 		//return $meeting_files;
	 		}
	 	}
	 	else
	 	{
	 		$meeting_files = null;
	 	}

		$mother_meeting_id = Request::get('mother_meeting_id');
		$mother_meeeting_id_log = $mother_meeting_id;
		if($mother_meeting_id)
		{
			$meeting_update_querystring = "UPDATE mom_db.meeting_table SET mother_meeting_id=".$mother_meeting_id.",meeting_files='".$meeting_files."' WHERE meeting_id=".$meetingId.";" ;
			\DB::update(\DB::raw($meeting_update_querystring));
			$mother_meeeting_id_log = $mother_meeting_id;
		}
		else
		{
			$meeting_update_querystring = "UPDATE mom_db.meeting_table SET mother_meeting_id=".$meetingId.",meeting_files='".$meeting_files."' WHERE meeting_id=".$meetingId.";" ;
			\DB::update(\DB::raw($meeting_update_querystring));
			$mother_meeeting_id_log = $meetingId;
		}

		$queryInsertMeetingLog = "INSERT INTO mom_db.meeting_table_log (meeting_id,meeting_title, meeting_datetime, meeting_attendee, mail_recipient, meeting_type,meeting_status,completion, mother_meeting_id,meeting_organizer_id,meeting_decision,seen_users,meeting_comment,meeting_files,initiator_dept,attendee_dept,meeting_schedule_type ) 
			values ('".$meetingId."','".addslashes($meeting_title)."','".$meeting_datetime."','".$meeting_attendee."','".$mail_recipient."','".$meeting_type."','".$meeting_status."','".$completion."',".$mother_meeeting_id_log.",'".$userId."','".addslashes($meeting_decision)."','".$seen_users."','".addslashes($meeting_comment)."','','".addslashes($_SESSION["dept"])."','".$attendee_dept."','".$meeting_schedule_type."')";
		\DB::insert(\DB::raw($queryInsertMeetingLog));

		$loopCount = count($mom_count);
		$responsible_arr = array();
		if($loopCount >'0'){
			$mom_title = array();
			$responsible = array();
			$start_time = array();
			$end_time = array();
			$mom_status = array();
			$mom_completion_status = array();
			$mom_comment = array();
			$mom_completion_time = array();
			
			for($i = 0;$i<$loopCount; $i++)
			{
				$counter = $i + 1;
				$mom_title[$i] = Request::get('mom_title'. $counter);
				$responsible[$i] = Request::get('responsible'. $counter);
				$start_time[$i] = Request::get('start_time'. $counter);
				$end_time[$i] = Request::get('end_time'. $counter);
				$mom_status[$i] = Request::get('mom_status' . $counter);
				$mom_completion_status[$i] = Request::get('mom_completion_status' . $counter);
				$mom_comment[$i] = Request::get('mom_comment' . $counter)."\n";

				$mom_comment[$i] = addslashes($mom_comment[$i]);
				$mom_comment[$i] = str_replace(";","&#59;",$mom_comment[$i]);

				array_push($responsible_arr, $responsible[$i]);
				//$mom_completion_time[$i] = Request::get('mom_completion_time' . $counter);
			}

			for($j=0;$j<count($responsible);$j++)
		 	{
		 		$responsibles_arr = explode(',', $responsible[$j]);

		 		for($k=0;$k<count($responsibles_arr);$k++)
		 		{
			 		$res_arr = explode('@', $responsibles_arr[$k]);
			 		if(count($res_arr)>1){
			 			if($res_arr[1] != 'summitcommunications.net')
				 		{
				 			$organizer_mail =$_SESSION['dashboard_user_id'].'@summitcommunications.net'; 
				 			array_push($responsibles_arr, $organizer_mail);
				 			$responsible[$j] = implode (",", $responsibles_arr);
				 		}
			 		}
			 		
			 	}	
		 	}

			$queryString = "INSERT INTO mom_db.mom_table (meeting_id, mom_title, responsible, start_time, end_time, mom_status,mom_completion_status,comment,mom_completion_time,mom_system_completion_time) 
			values ";
			for($i=0; $i<$loopCount; $i++)
		 	{
		 		$queryString .= "(";

		 		$responsible_temp_arr = explode(',', $responsible[$i]);

		 		$temp_res_arr = array();

		 		for($l=0;$l<count($responsible_temp_arr);$l++){
		 			$responsible_temp_arr_final = explode('|', $responsible_temp_arr[$l]);
		 			if(in_array($responsible_temp_arr[$l], $temp_res_arr)){

		 			}
		 			else{
		 				array_push($temp_res_arr,$responsible_temp_arr_final[0]);
		 			}
		 			
		 		}
		 		$res_str = implode(',',$temp_res_arr);
		 		$queryString .= $meetingId.",'".addslashes($mom_title[$i])."','".$res_str."','".$start_time[$i]."','".$end_time[$i]."','".$mom_status[$i]."','".$mom_completion_status[$i]."','".addslashes($mom_comment[$i])."','',''";	
		 		
		 		if($i == $loopCount - '1')
		 		{
		 			$queryString .= ")";
		 		}
		 		else
		 		{
		 			$queryString .= "),";
		 		}
		 		
		 	}
		 	//return $queryString;
		 	\DB::insert(\DB::raw($queryString));



		 	$queryStringLogMomSelect = "SELECT * FROM mom_db.mom_table ORDER BY mom_id DESC LIMIT 1" ;
		 	$lastMomEntryLists = \DB::select(\DB::raw($queryStringLogMomSelect));

		 	foreach($lastMomEntryLists as $lastMomEntryList){
		 		$mom_id_log = $lastMomEntryList->mom_id;
		 		$meeting_id_log 		= $lastMomEntryList->meeting_id;
		 		$mom_title_log 			= $lastMomEntryList->mom_title;
		 		$responsible_log 		= $lastMomEntryList->responsible;
		 		$start_time_log 		= $lastMomEntryList->start_time;
		 		$end_time_log 			= $lastMomEntryList->end_time;
		 		$mom_status_log 		= $lastMomEntryList->mom_status;
		 		$comment_log 			= $lastMomEntryList->comment;
		 		$mom_completion_time_log 		= $lastMomEntryList->mom_completion_time;
		 		$mom_system_completion_time_log = $lastMomEntryList->mom_system_completion_time;
		 		$mom_completion_status_log 		= $lastMomEntryList->mom_completion_status;
		 	}

		 	$queryMomSelectLastMeeting = "SELECT *  FROM mom_db.mom_table WHERE meeting_id=$mother_meeeting_id_log";
		 	$momOfLastMeetingLists = \DB::select(\DB::raw($queryMomSelectLastMeeting));

		 	foreach($momOfLastMeetingLists as $momOfLastMeetingList)
		 	{
		 		$updateMotherMomId = "UPDATE mom_db.mom_table set mother_mom_id=mom_id WHERE mother_mom_id=0";
		 		\DB::update(\DB::raw($updateMotherMomId));
		 	}
		}

	 	// if(Input::hasFile('userFile'))
	 	// {
	 	// 	//return 'asdf';
	 	// 	$file = Input::file('userFile');
	 	// 	$filename = $file->getClientOriginalName();//$_SESSION['LOGINID']."-".
	 	// 	$file->move('images',$filename);
	 	// }


		if($staticLoopCount > '1'){
			$staticInsertQuery = "INSERT INTO mom_db.mom_table (meeting_id, mom_title, responsible, start_time, end_time, mom_status,mom_completion_status,comment,mom_completion_time,mom_system_completion_time,mother_mom_id) 
			values ";
			//$responsible_arr = array();

		for($k=1;$k<$staticLoopCount;$k++){
			$static_mom_title_prev = Request::get("static_mom_title_prev".$k);
			$static_responsible_prev = Request::get("static_responsible_prev".$k);
			$static_start_time_prev = Request::get("static_start_time_prev".$k);
			$static_end_time_prev = Request::get("static_end_time_prev".$k);
			$static_mom_status_prev = Request::get("static_mom_status_prev".$k);
			$static_mom_completion_status_prev = Request::get("static_mom_completion_status_prev".$k);
			$static_mom_comment_prev = Request::get("static_mom_comment_prev".$k);
			$static_mom_id_prev = Request::get("static_mom_id_prev".$k);
			array_push($responsible_arr, $static_responsible_prev);
			$staticInsertQuery .= "(";
			$staticInsertQuery .= $meetingId.",'".addslashes($static_mom_title_prev)."','".$static_responsible_prev."','".$static_start_time_prev."','".$static_end_time_prev."','".$static_mom_status_prev."','".$static_mom_completion_status_prev."','".addslashes($static_mom_comment_prev)."','','',$static_mom_id_prev";	
			$staticInsertQuery .= "),";
		}

		$staticInsertQuery = trim($staticInsertQuery,",");
		\DB::insert(\DB::raw($staticInsertQuery));

		$queryStringLogMomSelect = "SELECT * FROM mom_db.mom_table ORDER BY mom_id DESC LIMIT 1" ;
		 	$lastMomEntryLists = \DB::select(\DB::raw($queryStringLogMomSelect));

		 	foreach($lastMomEntryLists as $lastMomEntryList){
		 		$mom_id_log = $lastMomEntryList->mom_id;
		 		$meeting_id_log 		= $lastMomEntryList->meeting_id;
		 		$mom_title_log 			= $lastMomEntryList->mom_title;
		 		$responsible_log 		= $lastMomEntryList->responsible;
		 		$start_time_log 		= $lastMomEntryList->start_time;
		 		$end_time_log 			= $lastMomEntryList->end_time;
		 		$mom_status_log 		= $lastMomEntryList->mom_status;
		 		$comment_log 			= $lastMomEntryList->comment;
		 		$mom_completion_time_log 		= $lastMomEntryList->mom_completion_time;
		 		$mom_system_completion_time_log = $lastMomEntryList->mom_system_completion_time;
		 		$mom_completion_status_log 		= $lastMomEntryList->mom_completion_status;
		 	}

		 	$queryMomSelectLastMeeting = "SELECT *  FROM mom_db.mom_table WHERE meeting_id=$mother_meeeting_id_log";
		 	$momOfLastMeetingLists = \DB::select(\DB::raw($queryMomSelectLastMeeting));

		 	foreach($momOfLastMeetingLists as $momOfLastMeetingList)
		 	{
		 		$updateMotherMomId = "UPDATE mom_db.mom_table set mother_mom_id=mom_id WHERE mom_id=0";
		 		\DB::update(\DB::raw($updateMotherMomId));
		 	}
		//return $staticInsertQuery;
		}
		// $queryStringMomLog = "INSERT INTO mom_db.mom_table_log (mom_id,meeting_id, mom_title, responsible, start_time, end_time, mom_status,mom_completion_status,comment,mom_completion_time,mom_system_completion_time) 
		// values (".$mom_id_log.",".$meeting_id_log.",'".addslashes($mom_title_log)."','".$responsible_log."','".$start_time_log."','".$end_time_log."','".$mom_status_log."','".$mom_completion_status_log."','".addslashes($comment_log)."','".$mom_completion_time_log."','".$mom_system_completion_time_log."')";
		// \DB::insert(\DB::raw($queryStringMomLog));



	 	$recipient_arr = explode(',', $mail_recipient);
	 	$mom_mail_responsible = array();
	 	for($m=0;$m<count($responsible_arr);$m++)
	 	{
	 		$mail_recipient_single = explode(',', $responsible_arr[$m]);
	 		for($n=0;$n<count($mail_recipient_single);$n++)
	 		{
	 			array_push($mom_mail_responsible, $mail_recipient_single[$n]);
	 		}
	 	}
	 	$recipient_arr = array_merge($recipient_arr,$mom_mail_responsible);
	 	$recipient_arr = array_unique($recipient_arr);
	 	$recipient_arr = array_values($recipient_arr);
	 	//print_r($recipient_arr);
	 	$toArr = array();
	 	$login_id_arr = array();
	 	for($i=0;$i<count($recipient_arr);$i++)
	 	{
	 		$toData = $recipient_arr[$i];
	 		$loginData = $recipient_arr[$i];
	 		array_push($login_id_arr, $loginData);
	 		array_push($toArr, $toData);
	 	}
	 	$from = $_SESSION['email'];

	 	$organizer_name = $_SESSION['dashboard_user_name'];

	 	$original_meeting_id = Request::get('meeting_id');
	 	if($staticLoopCount > '1'){
	 		$meeting_id_original_query = "UPDATE mom_db.meeting_table SET meeting_status='closed' WHERE meeting_id=$original_meeting_id";
	 		\DB::update(\DB::raw($meeting_id_original_query));
 	
	 		for($m=1;$m<$staticLoopCount;$m++){
	 			$static_mom_id_prev = Request::get("static_mom_id_prev".$m);
	 			$update_original_mom_id_query = "UPDATE mom_db.mom_table SET mom_status='closed',mom_title=CONCAT(mom_title,'[ADDED TO FOLLOW UP MEETING BY TOOL]') WHERE mom_id=$static_mom_id_prev";
	 			\DB::update(\DB::raw($update_original_mom_id_query));
	 		}
	 	}
	 	$meeting_id = $meetingId;
	 	return view('mom.mail_sending_view',compact('from','toArr','login_id_arr','meeting_id','organizer_name'));


	 	//$this->createMail($from,$toArr,$login_id_arr,$meetingId,$organizer_name);

	 	//return redirect('landing');
	 	//return view('mom.mail_sending_view',compact('from','toArr','login_id_arr','meetingId','organizer_name'));

	}


	public function edit_mom_view()
	{

	}

	
//search and return a combine table data to the views
	public function search_post()
	{
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$meeting_title 		= Request::get('search_meeting_title');
		$meeting_datetime1 	= Request::get('search_meeting_datetime1');
		$meeting_datetime2 	= Request::get('search_meeting_datetime2');
		$meeting_attendee 	= Request::get('search_meeting_attendee');
		$mail_recipient 	= Request::get('search_mail_recipient');
		$meeting_type 		= Request::get('search_meeting_type');
		$meeting_status 	= Request::get('search_meeting_status');
		$mom_title 			= Request::get('search_mom_title');
		$responsible 		= Request::get('search_responsible');
		$mom_start_time1 	= Request::get('search_mom_start_time');
		$mom_start_time2 	= Request::get('search_mom_start_time');
		$mom_end_time1 		= Request::get('search_mom_end_time');
		$mom_end_time2		= Request::get('search_mom_end_time');
		$mom_status 		= Request::get('search_mom_status');
		$view_mode   		= Request::get('viewMode');

		//return $meeting_datetime1;
		$meeting_id_str = '';
		$mom_id_str = '';

		$queryString = "SELECT * FROM (SELECT * FROM mom_db.meeting_table  ";
		$flag = 0;

		if($meeting_title)
		{
			if($flag == 1){
				$queryString .= "AND meeting_title LIKE '%".addslashes($meeting_title)."%'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_title LIKE '%".addslashes($meeting_title)."%'";
			}
			
		}
		if($meeting_attendee)
		{
			if($flag == 1){
				$queryString .= "AND meeting_attendee LIKE '%".addslashes($meeting_attendee)."%'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_attendee LIKE '%".addslashes($meeting_attendee)."%'";
			}
			
			//$queryString .= "AND meeting.meeting_attendee LIKE '%".$meeting_attendee."%'";
		}
		if($mail_recipient)
		{
			if($flag == 1){
				$queryString .= "AND mail_recipient LIKE '%".addslashes($mail_recipient)."%'";
			}

			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE mail_recipient LIKE '%".addslashes($mail_recipient)."%'";
			}
			
			//$queryString .= "AND meeting.mail_recipient LIKE '%".$mail_recipient."%'";
		}
		if($meeting_type)
		{
			if($flag == 1){
				$queryString .= "AND meeting_type LIKE '%".addslashes($meeting_type)."%'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_type LIKE '%".addslashes($meeting_type)."%'";
			}
			
			//$queryString .= "AND meeting.meeting_type LIKE '%".$meeting_type."%'";
		}
		if($meeting_status)
		{
			if($flag == 1){
				$queryString .= "AND meeting_status LIKE '%".$meeting_status."%'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_status LIKE '%".$meeting_status."%'";
			}
			
			//$queryString .= "AND meeting.meeting_status LIKE '%".$meeting_status."%'";
		}

		if($meeting_datetime1 && $meeting_datetime2)
		{
			if($flag == 1){
				$queryString .= "AND meeting_datetime between '".$meeting_datetime1."' AND '".$meeting_datetime2."'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_datetime between '".$meeting_datetime1."' AND '".$meeting_datetime2."'";
			}
			
			//$queryString .= "AND meeting.meeting_datetime between '".$meeting_datetime1."' AND '".$meeting_datetime2."'";
		}
		if($meeting_datetime1 && !$meeting_datetime2)
		{
			if($flag == 1){
				$queryString .= "AND meeting_datetime >= '".$meeting_datetime1."'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_datetime >= '".$meeting_datetime1."'";
			}
			
			//$queryString .= "AND meeting.meeting_datetime >= '".$meeting_datetime1."'";
		}
		if($meeting_datetime2 && !$meeting_datetime1)
		{
			if($flag == 1){
				$queryString .= "AND meeting_datetime <= '".$meeting_datetime2."'";
			}
			if($flag == 0){
				$flag = 1;
				$queryString .= "WHERE meeting_datetime <= '".$meeting_datetime2."'";
			}
			
			//$queryString .= "AND meeting.meeting_datetime <= '".$meeting_datetime2."'";
		}
		$queryString .= ") as meeting";
		// if( $flag == 0){
		// 	$queryString .= " meeting.meeting_id > 0" ;
		// }

		if($mom_title || $responsible ||$mom_status || $mom_start_time1 || $mom_start_time2){

			$queryString .= " JOIN (SELECT * from mom_db.mom_table WHERE ";
		
			$flag = 0;
			if($mom_title)
			{
				if($flag == 1){
					$queryString .= "AND mom_title LIKE '%".addslashes($mom_title)."%'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= " mom_title LIKE '%".addslashes($mom_title)."%'";
				}
				
				//$queryString .= "AND mom_title LIKE '%".$mom_title."%'";
			}
			if($responsible)
			{
				if($flag == 1){
					$queryString .= "AND responsible LIKE '%".addslashes($responsible)."%'";
				}
				if($flag == 0){
					$flag = 1;
					//$queryString .= "AND mom_title LIKE '%".addslashes($mom_title)."%'";
					$queryString .= " responsible LIKE '%".addslashes($responsible)."%'";
				}
				
				//$queryString .= "AND responsible LIKE '%".$responsible."%'";
			}
			if($mom_status)
			{
				if($flag == 0){
					$flag = 1;
					$queryString .= " mom_status LIKE '%".$mom_status."%'";
				}
				if($flag == 1){
					$queryString .= "AND mom_status LIKE '%".$mom_status."%'";
				}
				//$queryString .= "AND mom_status LIKE '%".$mom_status."%'";
			}

			

			if($mom_start_time1 && $mom_start_time2)
			{
				if($flag == 1){
					$queryString .= "AND mom_start_time between '".$mom_start_time1."' AND '".$mom_start_time2."'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= " mom_start_time between '".$mom_start_time1."' AND '".$mom_start_time2."'";
				}
				
				//$queryString .= "AND mom_start_time between '".$mom_start_time1."' AND '".$mom_start_time2."'";
			}
			if($mom_start_time1 && !$mom_start_time2)
			{
				if($flag == 1){
					$queryString .= "AND mom_start_time >= '".$mom_start_time1."'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= " mom_start_time >= '".$mom_start_time1."'";
				}
				
				//$queryString .= "AND mom_start_time >= '".$mom_start_time1."'";
			}
			if($mom_start_time2 && !$mom_start_time1)
			{
				if($flag == 1){
					$queryString .= "AND mom_start_time <= '".$mom_start_time2."'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= "mom_start_time <= '".$mom_start_time2."'";
				}
				
				//$queryString .= "AND mom_start_time <= '".$mom_start_time2."'";
			}

			if($mom_end_time1 && $mom_end_time2)
			{
				if($flag == 1){
					$queryString .= "AND end_time between '".$mom_end_time1."' AND '".$mom_end_time2."'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= " end_time between '".$mom_end_time1."' AND '".$mom_end_time2."'";
				}
				
				//$queryString .= "AND meeting.meeting_datetime between '".$mom_end_time1."' AND '".$mom_end_time2."'";
			}
			if($mom_end_time1 && !$mom_end_time2)
			{
				if($flag == 1){
					$queryString .= "AND end_time >= '".$mom_end_time1."'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= " end_time >= '".$mom_end_time1."'";
				}
				
			}
			if($mom_end_time2 && !$mom_start_time1)
			{
				if($flag == 1){
					$queryString .= "AND end_time <= '".$mom_end_time2."'";
				}
				if($flag == 0){
					$flag = 1;
					$queryString .= "end_time <= '".$mom_end_time2."'";
				}
				
				
			}
			$queryString .= " ) as mom on meeting.meeting_id = mom.meeting_id  ";

		}
		else{
			$queryString .=" JOIN (SELECT * from mom_db.mom_table) as mom on meeting.meeting_id = mom.meeting_id "; 
		}
		//return $queryString;
		$query_mom_test = "select * from mom_db.meeting_table";
		$mom_lists_test =  \DB::select(\DB::raw($query_mom_test));
		$combine_lists = array();

		if($mom_lists_test != null){

		$combine_obj_lists =  \DB::select(\DB::raw($queryString));
		//return $combine_obj_lists;
		
		
		foreach ($combine_obj_lists as $row) 
		{
			$meeting_id = $row->meeting_id;
			
			$query_mom = "select * from mom_db.mom_table where meeting_id='$meeting_id'";
			$mom_lists =  \DB::select(\DB::raw($query_mom));
			$is_related = false;
			foreach($mom_lists as $mom_list){
				$resoponsible_persons = $mom_list->responsible;
				if (preg_match('/'.$_SESSION['dashboard_user_id'].'/',$resoponsible_persons)){
					$is_related = true;
				}
			}
			$query_meeting = "select * from mom_db.meeting_table where meeting_id='$meeting_id'";
			$meeting_lists =  \DB::select(\DB::raw($query_meeting));
			//$is_related = false;
			foreach($meeting_lists as $meeting_list){
				$attendee_persons = $meeting_list->meeting_attendee;
				if (preg_match('/'.$_SESSION['dashboard_user_id'].'/',$attendee_persons)){
					$is_related = true;
				}
				$recipient_persons = $meeting_list->mail_recipient;
				if (preg_match('/'.$_SESSION['dashboard_user_id'].'/',$recipient_persons)){
					$is_related = true;
				}
			}
			if($val =='superAdmin' ){
				$is_related = true;
			}
			if($is_related == true){
				$meeting_id_str .= $row->meeting_id.',';
				array_push($combine_lists, $meeting_id);
				
				$meeting_title_row_data = $row->meeting_title;
				array_push($combine_lists, $meeting_title_row_data);
				$meeting_datetime_row_data = $row->meeting_datetime;
				 array_push($combine_lists, $meeting_datetime_row_data);

				

				$meeting_type_row_data = $row->meeting_type;
				array_push($combine_lists, $meeting_type_row_data);
				$meeting_status_row_data = $row->meeting_status;
				array_push($combine_lists, $meeting_status_row_data);
				$meeting_completion = $row->completion;
				array_push($combine_lists, $meeting_completion);
				
				$mother_meeting_id = $row->mother_meeting_id;
				array_push($combine_lists, $mother_meeting_id);	

				if($view_mode == 'momView'){
					//$mom_id = $row->mom_id;
					$mom_id_str .= $row->mom_id.',';
					// array_push($combine_lists, $mom_id);
					// $meeting_attendee_row_data = $row->meeting_attendee;
					// array_push($combine_lists, $meeting_attendee_row_data);
					// $mail_recipient_row_data = $row->mail_recipient;
					// array_push($combine_lists, $mail_recipient_row_data);
					// $mom_title = $row->mom_title;
					// array_push($combine_lists, $mom_title);
					// $responsible = $row->responsible;
					// array_push($combine_lists, $responsible);
					// $start_time = $row->start_time;
					// array_push($combine_lists, $start_time);
					// $end_time = $row->end_time;
					// array_push($combine_lists, $end_time);
					// $mom_status = $row->mom_status;
					// array_push($combine_lists, $mom_status);
					// $comment = $row->comment;
					// array_push($combine_lists, $comment);
				}	
			}

		}
		}
		if($meeting_id_str != ''){
			$meeting_id_str = trim($meeting_id_str,',');
			$mom_id_str = trim($mom_id_str,',');
			
		    if($view_mode == 'momView'){
		    	$items = DB::table('mom_db.meeting_table')
				->rightjoin('mom_db.mom_table',"mom_db.meeting_table.meeting_id","=","mom_db.mom_table.meeting_id")   
			    ->selectRaw('*')
			    ->whereRaw("mom_db.mom_table.mom_id IN ($mom_id_str)")
			    ->paginate(10);
		    }
		    else{
		    	$items = DB::table('mom_db.meeting_table')
			    ->selectRaw('*')
			    ->whereRaw("mom_db.meeting_table.meeting_id IN ($meeting_id_str)")
			    ->paginate(10);
		    }
		}
		else{
			$items = DB::table('mom_db.meeting_table')
			->rightjoin('mom_db.mom_table',"mom_db.meeting_table.meeting_id","=","mom_db.mom_table.meeting_id")   
		    ->selectRaw('*')
		    ->paginate(10);	
		}	

		$search_meeting_title 		= Request::get('search_meeting_title');
		$search_meeting_datetime1 	= Request::get('search_meeting_datetime1');
		$search_meeting_datetime2 	= Request::get('search_meeting_datetime2');
		$search_meeting_attendee 	= Request::get('search_meeting_attendee');
		$search_mail_recipient 	= Request::get('search_mail_recipient');
		$search_meeting_type 		= Request::get('search_meeting_type');
		$search_meeting_status 	= Request::get('search_meeting_status');
		$search_mom_title 			= Request::get('search_mom_title');
		$search_responsible 		= Request::get('search_responsible');
		$search_mom_start_time1 	= Request::get('search_mom_start_time1');
		$search_mom_start_time2 	= Request::get('search_mom_start_time2');
		$search_mom_end_time1 		= Request::get('search_mom_end_time1');
		$search_mom_end_time2		= Request::get('search_mom_end_time2');
		$search_mom_status 		= Request::get('search_mom_status');
		$view_mode   		= Request::get('viewMode');

		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date = $current_date_obj->format('Y-m-d');

		return view('mom.search_mom_result',compact('combine_lists','combine_obj_lists','current_date','items','view_mode','search_meeting_title','search_meeting_datetime1','search_meeting_datetime2','search_meeting_attendee','search_mail_recipient','search_meeting_type','search_meeting_status','search_mom_title','search_responsible','search_mom_start_time1','search_mom_start_time2','search_mom_end_time1','search_mom_end_time2','search_mom_status'));
		//return $combine_lists;//."--".$meeting_datetime."--".$meeting_attendee."--".$responsible."--".$mom_start_time;
	}
	public function search_post_all()
	{

		$searchAll = Request::get('searchAll');
		$view_mode = Request::get('viewMode');
		

		$queryString = "select * from mom_db.meeting_table where meeting_table.meeting_id in (SELECT distinct meeting_id FROM mom_db.meeting_table meeting WHERE  ";

		if($searchAll)
		{
			$queryString .= "meeting.meeting_title LIKE '%".addslashes($searchAll)."%' ";
		}
		if($searchAll)
		{
			$queryString .= "OR meeting.meeting_attendee LIKE '%".addslashes($searchAll)."%' ";
		}
		if($searchAll)
		{

			$queryString .= "OR meeting.mail_recipient LIKE '%".addslashes($searchAll)."%' ";
		}
		if($searchAll)
		{
			$queryString .= "OR meeting.meeting_type LIKE '%".addslashes($searchAll)."%' ";
		}
		if($searchAll)
		{
			$queryString .= "OR meeting.meeting_status LIKE '%".addslashes($searchAll)."%' ";
		}

		if($searchAll)
		{
			$queryString .= "union all SELECT DISTINCT meeting_id FROM  mom_db.mom_table mom where mom.mom_title LIKE '%".addslashes($searchAll)."%' ";
		}
		if($searchAll)
		{
			$queryString .= "OR mom.responsible LIKE '%".addslashes($searchAll)."%' ";
		}
		if($searchAll)
		{
			$queryString .= "OR mom.mom_status LIKE '%".addslashes($searchAll)."%' )";
		}
		else{
	
				$queryString = "select * from mom_db.meeting_table ";			

		}
		//echo $queryString;

		// if($meeting_datetime1 && $meeting_datetime2)
		// {
		// 	$queryString .= "AND meeting.meeting_datetime between '".$meeting_datetime1."' AND '".$meeting_datetime2."'";
		// }
		// if($meeting_datetime1 && !$meeting_datetime2)
		// {
		// 	$queryString .= "AND meeting.meeting_datetime >= '".$meeting_datetime1."'";
		// }
		// if($meeting_datetime2 && !$meeting_datetime1)
		// {
		// 	$queryString .= "AND meeting.meeting_datetime <= '".$meeting_datetime2."'";
		// }

		// if($mom_start_time1 && $mom_start_time2)
		// {
		// 	$queryString .= "AND mom.mom_start_time between '".$mom_start_time1."' AND '".$mom_start_time2."'";
		// }
		// if($mom_start_time1 && !$mom_start_time2)
		// {
		// 	$queryString .= "AND mom.mom_start_time >= '".$mom_start_time1."'";
		// }
		// if($mom_start_time2 && !$mom_start_time1)
		// {
		// 	$queryString .= "AND mom.mom_start_time <= '".$mom_start_time2."'";
		// }

		// if($mom_end_time1 && $mom_end_time2)
		// {
		// 	$queryString .= "AND meeting.meeting_datetime between '".$mom_end_time1."' AND '".$mom_end_time2."'";
		// }
		// if($mom_end_time1 && !$mom_end_time2)
		// {
		// 	$queryString .= "AND meeting.meeting_datetime >= '".$mom_end_time1."'";
		// }
		// if($mom_end_time2 && !$mom_start_time1)
		// {
		// 	$queryString .= "AND meeting.meeting_datetime <= '".$mom_end_time2."'";
		// }

		//return $queryString;
		$query_mom_test = "select * from mom_db.meeting_table";
		$mom_lists_test =  \DB::select(\DB::raw($query_mom_test));
		$combine_lists = array();
		
		if($mom_lists_test != null){
			$combine_obj_lists =  \DB::select(\DB::raw($queryString));
			//return $combine_obj_lists;
			
			$meeting_id_str = '';
			foreach ($combine_obj_lists as $row) 
			{

				$meeting_id = $row->meeting_id;
				
				$query_mom = "select * from mom_db.mom_table where meeting_id='$meeting_id'";
				$mom_lists =  \DB::select(\DB::raw($query_mom));
				$is_related = false;
				foreach($mom_lists as $mom_list){
					$resoponsible_persons = $mom_list->responsible;
					if (preg_match('/'.$_SESSION['dashboard_user_id'].'/',$resoponsible_persons)){
						$is_related = true;
					}
				}
				$query_meeting = "select * from mom_db.meeting_table where meeting_id='$meeting_id'";
				$meeting_lists =  \DB::select(\DB::raw($query_meeting));
				//$is_related = false;
				foreach($meeting_lists as $meeting_list){
					$attendee_persons = $meeting_list->meeting_attendee;
					if (preg_match('/'.$_SESSION['dashboard_user_id'].'/',$attendee_persons)){
						$is_related = true;
					}
					$recipient_persons = $meeting_list->mail_recipient;
					if (preg_match('/'.$_SESSION['dashboard_user_id'].'/',$recipient_persons)){
						$is_related = true;
					}
				}
				if($is_related == true){
					$meeting_id_str .= $row->meeting_id.',';
					array_push($combine_lists, $meeting_id);
					// $mom_id = $row->mom_id;
					// array_push($combine_lists, $mom_id);
					$meeting_title_row_data = $row->meeting_title;
					array_push($combine_lists, $meeting_title_row_data);


					$meeting_datetime_row_data = $row->meeting_datetime;
					 array_push($combine_lists, $meeting_datetime_row_data);


					// $meeting_attendee_row_data = $row->meeting_attendee;
					//array_push($combine_lists, $meeting_attendee_row_data);
					// $mail_recipient_row_data = $row->mail_recipient;
					// array_push($combine_lists, $mail_recipient_row_data);
					$meeting_type_row_data = $row->meeting_type;
					array_push($combine_lists, $meeting_type_row_data);
					$meeting_status_row_data = $row->meeting_status;
					array_push($combine_lists, $meeting_status_row_data);
					$meeting_completion = $row->completion;
					array_push($combine_lists, $meeting_completion);
					// $mom_title = $row->mom_title;
					// array_push($combine_lists, $mom_title);


					// $responsible = $row->responsible;
					// array_push($combine_lists, $responsible);


					// $start_time = $row->start_time;
					// array_push($combine_lists, $start_time);
					// $end_time = $row->end_time;
					// array_push($combine_lists, $end_time);


					// $mom_status = $row->mom_status;
					// array_push($combine_lists, $mom_status);
					$mother_meeting_id = $row->mother_meeting_id;
					array_push($combine_lists, $mother_meeting_id);	
					// $comment = $row->comment;
					// array_push($combine_lists, $comment);	
				}
				

			}
		}
		if($meeting_id_str != ''){
			$meeting_id_str = trim($meeting_id_str,',');
			$items = DB::table('mom_db.meeting_table')   
		    ->selectRaw('*')
		    ->whereRaw("meeting_id IN ($meeting_id_str)")
		    ->paginate(10);
		}
		else{
			$items = DB::table('mom_db.meeting_table')   
		    ->selectRaw('*')
		    ->whereRaw("meeting_id=0")
		    ->paginate(10);
		}	   
		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date = $current_date_obj->format('Y-m-d');

		return view('mom.search_mom_result',compact('combine_lists','combine_obj_lists','current_date','items','view_mode'));
		//return $combine_lists;//."--".$meeting_datetime."--".$meeting_attendee."--".$responsible."--".$mom_start_time;
	}
	public function search_view()
	{

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date = $current_date_obj->format('Y-m-d');
		return view('mom.search_mom',compact('current_date'));
	}
	//get data and return them for edit
	public function edit_view()
	{
		// if(!isset($_SESSION['USERTYPE']))
		// {
		// 	return redirect('/');
		// }
		// if(isset($_SESSION['USERTYPE']))
		// {
		// 	if($_SESSION["USERTYPE"] != 'admin')
		// 	{
		// 		if($_SESSION["USERTYPE"] != 'super_admin')
		// 		{
		// 			return redirect('/');
		// 		}	
		// 	}
		// }

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}
		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date = $current_date_obj->format('Y-m-d');
		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= Request::get('meeting_id');

		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= Request::get('mother_meeting_id');

		$meeting_attendee_arr = array();
		$mail_recipient_arr = array();

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$attendee_dept_str = $meeting_table_list->attendee_dept;
		}
		$meeting_attendee_arr = explode(',', $meeting_attendee_str);
		$mail_recipient_arr   = explode(',', $mail_recipient_str);
		$attendee_dept_arr   = explode(',', $attendee_dept_str);
		

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$organizer_id = $meeting_table_list->meeting_organizer_id;
			$meeting_datetime = $meeting_table_list->meeting_datetime;
			$is_meeting_status_closed = $meeting_table_list->meeting_status;
			$initiator_dept = $meeting_table_list->initiator_dept;
		}
		$t4_later_date_obj = new DateTime($meeting_datetime);
		$t4_later_date_obj->setTime(00, 01, 00);
		$t4_later_date_obj->modify('+2 day');
		$t4_later_date = $t4_later_date_obj->format('Y-m-d');
		if($current_date > $t4_later_date )
		{
			$lockComment = true;
		}
		else
		{
			$lockComment = false;
		}
		
		if($organizer_id == $_SESSION['dashboard_user_id'])
		{
			$is_organizer = true;
		}
		else
		{
			$is_organizer = false;
		}	

		$get_organaizer = \DB::select(\DB::raw("SELECT * FROM login_plugin_db.login_table WHERE user_id ='".$organizer_id."';"));

		foreach($get_organaizer as $name_organizer)	
		{
			$organizer_name =  $name_organizer->user_name;
		}	
		$filePath = '../MeetingFiles/'.$meeting_id;
		if(File::exists($filePath)) 
		{
			$meeting_files = true;
		}
		else
		{
			$meeting_files = false;
		}

		$meeeting_schedule_type_list = 	
		['AD-HOC','Weekly','Monthly','Bi-Weekly'];

		$mom_responsible_view_arr = array();
		foreach($mom_table_lists as $mom_table_list){
			$temp_res_arr = explode(",", $mom_table_list->responsible);
			if(count($temp_res_arr) > 0){
				for($i=0;$i<count($temp_res_arr);$i++){
					array_push($mom_responsible_view_arr, $temp_res_arr[$i]);
				}
			}
			else{
				array_push($mom_responsible_view_arr, $mom_table_list->responsible);
			}
		}

		for($i=0;$i<count($mail_recipient_arr);$i++){
			array_push($mom_responsible_view_arr, $mail_recipient_arr[$i]);
		}
		$mom_responsible_view_arr = array_unique($mom_responsible_view_arr);
		$mom_responsible_view_arr = array_values($mom_responsible_view_arr);

		//return $mail_recipient_arr;
		//return $mom_responsible_view_arr;
		return view('mom.edit_mom',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','lockComment','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','is_meeting_status_closed','organizer_name','attendee_dept_arr','initiator_dept','meeeting_schedule_type_list','mom_responsible_view_arr','organizer_id'));
	}
	//get edited data and update and send to landing
	public function edit_process()
	{
		$mail_recipient_index_arr = array();

		$meeting_id = Request::get('meeting_id');
		$momCount = Request::get('countMom');
		$mail_recipient_index_arr = Request::get('mail_recipient_index');
		
		if(count($mail_recipient_index_arr) == 1)
		{
			$mail_recipient = $mail_recipient_index_arr[0];
		}
		else
		{
			$mail_recipient = implode (",", $mail_recipient_index_arr);
		}

		$meeting_attendee_index_arr = Request::get('meeting_attendee_index');
		
		if(count($meeting_attendee_index_arr) == 1)
		{
			$meeting_attendee = $meeting_attendee_index_arr[0];
		}
		else
		{
			$meeting_attendee = implode (",", $meeting_attendee_index_arr);
		}
		
		$loopCount = count($momCount);
		//echo $meeting_update_querystring;

		date_default_timezone_set('Asia/Dhaka');
		$comment_date = date('Y-m-d h:i:s', time());

		$mom_id = array();
		$mom_title = array();
		$responsible = array();
		$start_time = array();
		$end_time = array();
		$mom_status = array();
		$mom_completion_status = array();
		$mom_completion_time = array();
		$mom_system_completion_time = array();

		for($i = 0;$i<$loopCount; $i++)
		{
			$counter = $i + 1;
			$mom_id[$i] = Request::get('mom_id'. $counter);
			$mom_title[$i] = Request::get('mom_title'. $counter);
			$responsible[$i] = Request::get('responsible'. $counter);
			$start_time[$i] = Request::get('start_time'. $counter);
			$end_time[$i] = Request::get('end_time'. $counter);
			$mom_status[$i] = Request::get('mom_status' . $counter);
			$mom_completion_status[$i] = Request::get('mom_completion_status' . $counter);
			$mom_comment[$i] = Request::get('mom_comment' . $counter);
			if($mom_comment[$i] != ''){
				$mom_comment[$i] = "\n\n".$_SESSION['dashboard_user_id'].'('.$comment_date.') : '.addslashes($mom_comment[$i]);
			}
			else{
				$mom_comment[$i] = "";
			}
			$mom_comment[$i] = str_replace(";","&#59;",$mom_comment[$i]);
			$mom_completion_time[$i] = Request::get('mom_completion_time'.$counter);
		}

		$meetingStatusList = \DB::select(\DB::raw("SELECT mom_status FROM mom_db.mom_table WHERE meeting_id=".$meeting_id.";"));
		$meetingStatusArr = array();
		foreach ($meetingStatusList as $row) {
			$rowData = $row->mom_status;
			array_push($meetingStatusArr, $rowData);
		}
		
		for($i=0; $i<$loopCount; $i++)
	 	{
	 		if($mom_status[$i] != $meetingStatusArr[$i])
	 		{
	 			if($mom_status[$i] == 'closed')
	 			{
		 			$date = date('Y/m/d h:i:s', time());
		 			$mom_system_completion_time[$i] = $date;
	 			}
	 			else
	 			{
	 				$mom_system_completion_time[$i] = '';
	 			}
	 		}
	 		else
	 		{
	 			$mom_system_completion_time[$i] = '';
	 		}
	 	}
	 	//return [$mom_status,$mom_system_completion_time];
	 	

		for($i=0; $i<$loopCount; $i++)
	 	{
			$mom_update_querystring = "UPDATE mom_db.mom_table SET mom_title='".addslashes($mom_title[$i])."',responsible='".$responsible[$i]."',start_time='".$start_time[$i]."',end_time='".$end_time[$i]."',mom_status='".$mom_status[$i]."',mom_completion_status='".$mom_completion_status[$i]."',comment=CONCAT(comment,'".addslashes($mom_comment[$i])."'),mom_completion_time='".$mom_completion_time[$i]."',mom_system_completion_time='".$mom_system_completion_time[$i]."' WHERE mom_id=".$mom_id[$i].";" ;
			//echo $mom_system_completion_time[$i];
			\DB::update(\DB::raw($mom_update_querystring));

			$mom_update_log = "INSERT INTO mom_db.mom_table_log (mom_id, meeting_id,mom_title, responsible,start_time, end_time, mom_status,mom_completion_status,comment,mom_completion_time,mom_system_completion_time) values (".$mom_id[$i].", ".$meeting_id.",'".addslashes($mom_title[$i])."','".$responsible[$i]."','".$start_time[$i]."','".$end_time[$i]."', '".$mom_status[$i]."', '".$mom_completion_status[$i]."','".addslashes($mom_comment[$i])."','".$mom_completion_time[$i]."','".$mom_system_completion_time[$i]."')";
			\DB::insert(\DB::raw($mom_update_log));
			//echo $mom_update_querystring;
		}

		$meeting_title = Request::get('meeting_title');
		$meeting_datetime = Request::get('meeting_datetime');
		//$meeting_attendee = Request::get('meeting_attendee');
		//$mail_recipient = Request::get('mail_recipient');
		$meeting_type = Request::get('meeting_type');
		$meeting_status = Request::get('meeting_status');
		$meeting_decision = Request::get('meeting_decision');

		$meeting_decision = addslashes($meeting_decision);
		$meeting_decision = str_replace(";","&#59;",$meeting_decision);

		$meeting_comment_get_string ="SELECT * FROM mom_db.meeting_table WHERE meeting_id=".$meeting_id.";";
		$comment_get_lists =  \DB::select(\DB::raw($meeting_comment_get_string));
		foreach($comment_get_lists as $comment_get_list)
		{
			$previous_comment = $comment_get_list->meeting_comment;
		}

		date_default_timezone_set('Asia/Dhaka');
		$date_of_comment = date('Y/m/d h:i:s', time());
		$meeting_comment_latest = Request::get('meeting_comment');
		//$meeting_comment_latest = addslashes($meeting_comment_latest);

		$meeting_comment =$previous_comment."\n". $_SESSION['dashboard_user_id']."[".$date_of_comment."] : ".$meeting_comment_latest;
		$meeting_comment = addslashes($meeting_comment);
		$meeting_comment = str_replace(";","&#59;",$meeting_comment);
		// $meeting_comment = str_replace(":",":",$meeting_comment);
		
		//$completion = '0.0';

		//return $meeting_comment;

		$mom_closed_string ="SELECT * FROM mom_db.mom_table WHERE meeting_id=".$meeting_id." AND mom_status='closed'";

		$mom_closed =  \DB::select(\DB::raw($mom_closed_string));
		if($mom_closed)
		{
			$completion = count($mom_closed)/$loopCount * 100;
			$completion = round($completion, 2);
		}
		else
		{
			$completion = '0.0';
		}
		
		
		if(Input::hasFile('meeting_files'))
	 	{
	 		$isMeetingFiles = true;
	 		$path = 'MeetingFiles/'.$meeting_id;
	 		$dirPath = '../MeetingFiles/'.$meeting_id;
	 		$meeting_files = $path."/";
			if(!File::exists($dirPath)) 
			{
				
				$dirPath = '../MeetingFiles/'.$meeting_id;
	    		$result = File::makeDirectory($dirPath);
		 		$files = Input::file('meeting_files');
		 		foreach($files as $file)
		 		{
		 			$filename = $file->getClientOriginalName();
		 			$file->move($dirPath,$filename);
		 		}

	 		}
	 		else
	 		{
	 			$dirPath = '../MeetingFiles/'.$meeting_id;
	 			$files = Input::file('meeting_files');
		 		foreach($files as $file)
		 		{
		 			$filename = $file->getClientOriginalName();
		 			$file->move($dirPath,$filename);
		 		}
		 		//return $meeting_files;
	 		}
	 	}	
	 	else
	 	{
	 		$isMeetingFiles = false;
	 	}
	 	if($isMeetingFiles == true)
	 	{
	 		if($meeting_comment_latest==null)
			{
				$meeting_update_querystring = "UPDATE mom_db.meeting_table SET meeting_title='".addslashes($meeting_title)."',meeting_datetime='".$meeting_datetime."',meeting_attendee='".$meeting_attendee."',mail_recipient='".$mail_recipient."',meeting_type='".$meeting_type."',meeting_status='".$meeting_status."',completion='".$completion."',meeting_decision='".addslashes($meeting_decision)."',meeting_files='".$meeting_files."' WHERE meeting_id=".$meeting_id.";" ;
			}
			else
			{
				$meeting_update_querystring = "UPDATE mom_db.meeting_table SET meeting_title='".addslashes($meeting_title)."',meeting_datetime='".$meeting_datetime."',meeting_attendee='".$meeting_attendee."',mail_recipient='".$mail_recipient."',meeting_type='".$meeting_type."',meeting_status='".$meeting_status."',completion='".$completion."',meeting_decision='".addslashes($meeting_decision)."',meeting_comment='".addslashes($meeting_comment)."',meeting_files='".$meeting_files."' WHERE meeting_id=".$meeting_id.";" ;
			}
	 	}
	 	if($isMeetingFiles == false)
	 	{
			if($meeting_comment_latest==null)
			{
				$meeting_update_querystring = "UPDATE mom_db.meeting_table SET meeting_title='".addslashes($meeting_title)."',meeting_datetime='".$meeting_datetime."',meeting_attendee='".$meeting_attendee."',mail_recipient='".$mail_recipient."',meeting_type='".$meeting_type."',meeting_status='".$meeting_status."',completion='".$completion."',meeting_decision='".addslashes($meeting_decision)."' WHERE meeting_id=".$meeting_id.";" ;
			}
			else
			{
				$meeting_update_querystring = "UPDATE mom_db.meeting_table SET meeting_title='".addslashes($meeting_title)."',meeting_datetime='".$meeting_datetime."',meeting_attendee='".$meeting_attendee."',mail_recipient='".$mail_recipient."',meeting_type='".$meeting_type."',meeting_status='".$meeting_status."',completion='".$completion."',meeting_decision='".addslashes($meeting_decision)."',meeting_comment='".addslashes($meeting_comment)."' WHERE meeting_id=".$meeting_id.";" ;
			}
		}
		//$queryStr = addslashes($meeting_update_querystring);
		//$queryStr = \DB::connection()->getPdo()->quote($meeting_update_querystring);
		//return $queryStr;
		\DB::update(\DB::raw($meeting_update_querystring));

		$queryMeetingSelectLog = "SELECT * FROM mom_db.meeting_table WHERE meeting_id='".$meeting_id."'";

		$queryMeetingLogLists = \DB::select(\DB::raw($queryMeetingSelectLog));

		foreach($queryMeetingLogLists as $queryMeetingLogList){
			$meeting_id_log = $queryMeetingLogList->meeting_id;
			$meeting_title_log = $queryMeetingLogList->meeting_title;
			$meeting_datetime_log = $queryMeetingLogList->meeting_datetime;
			$meeting_attendee_log = $queryMeetingLogList->meeting_attendee;
			$mail_recipient_log = $queryMeetingLogList->mail_recipient;
			$meeting_type_log = $queryMeetingLogList->meeting_type;
			$meeting_status_log = $queryMeetingLogList->meeting_status;
			$completion_log = $queryMeetingLogList->completion;
			$mother_meeting_id_log = $queryMeetingLogList->mother_meeting_id;
			$meeting_organizer_id_log = $queryMeetingLogList->meeting_organizer_id;
			$meeting_decision_log = $queryMeetingLogList->meeting_decision;
			$seen_users_log = $queryMeetingLogList->seen_users;
			$meeting_comment_log = $queryMeetingLogList->meeting_comment;
			$meeting_files_log = $queryMeetingLogList->meeting_files;
			$initiator_dept_log = $queryMeetingLogList->initiator_dept;
			$attendee_dept_log = $queryMeetingLogList->attendee_dept;
			$meeting_schedule_type_log = $queryMeetingLogList->meeting_schedule_type;
		}

		$queryInsertMeetingLog = "INSERT INTO mom_db.meeting_table_log (meeting_id,meeting_title, meeting_datetime, meeting_attendee, mail_recipient, meeting_type,meeting_status,completion, mother_meeting_id,meeting_organizer_id,meeting_decision,seen_users,meeting_comment,meeting_files,initiator_dept,attendee_dept,meeting_schedule_type ) 
			values ('".$meeting_id_log."','".addslashes($meeting_title_log)."','".$meeting_datetime_log."','".$meeting_attendee_log."','".$mail_recipient_log."','".$meeting_type_log."','".$meeting_status_log."','".$completion_log."',".$mother_meeting_id_log.",'".$meeting_organizer_id_log."','".addslashes($meeting_decision_log)."','".$seen_users_log."','".addslashes($meeting_comment_log)."','','".addslashes($initiator_dept_log)."','".addslashes($attendee_dept_log)."','".$meeting_schedule_type_log."')";
		\DB::insert(\DB::raw($queryInsertMeetingLog));

		return redirect('landing');
		
	}
	//get data and return a view to edit a follow up 
	public function edit_followup_process()
	{
		// if(!isset($_SESSION['USERTYPE']))
		// {
		// 	return redirect('/');
		// }
		// if(isset($_SESSION['USERTYPE']))
		// {
		// 	if($_SESSION["USERTYPE"] != 'admin')
		// 	{
		// 		if($_SESSION["USERTYPE"] != 'super_admin')
		// 		{
		// 			return redirect('/');
		// 		}	
		// 	}
		// }


		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$meeting_type_drop = 
		[
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= Request::get('meeting_id');

		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= Request::get('mother_meeting_id');

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));
		$mom_open_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id='".$meeting_id."' AND mom_status='active'"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$attendee_dept_str = $meeting_table_list->attendee_dept;
		}
		$meeting_attendee_arr = explode(',', $meeting_attendee_str);
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	
		$attendee_dept_arr   = explode(',', $attendee_dept_str);	

		$meeeting_schedule_type_list = 	
		['AD-HOC','Weekly','Monthly','Bi-Weekly'];

		//return $meeeting_schedule_type_list;
		return view('mom.edit_followup_mom',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','attendee_dept_arr','meeeting_schedule_type_list','mom_open_lists'));
	}
	public function checker($meeting_id){
		$meeting_table_query = "SELECT * FROM mom_db.meeting_table WHERE meeting_id=".$meeting_id;

		$meeting_table_lists = \DB::select(\DB::raw($meeting_table_query));

		$is_ok = false;

		$val = $this->is_autenticated();

		if($val == 'superAdmin'){
			$is_ok = true;
			return $is_ok;
		}

		foreach($meeting_table_lists as $meeting_table_list){
			if(preg_match('/'.$_SESSION['dashboard_user_id'].'/',$meeting_table_list->mail_recipient)){
				$is_ok = true;
				return $is_ok;
			}
			if(preg_match('/'.$_SESSION['dashboard_user_id'].'/',$meeting_table_list->meeting_attendee)){
				$is_ok = true;
				return $is_ok;
			}
			if($val == 'admin'){
				if(preg_match('/'.$_SESSION['dept'].'/', $meeting_table_list->attendee_dept)){
					$is_ok = true;
					return $is_ok;
				}
			}
		}

		$mom_table_query = "SELECT * FROM mom_db.mom_table WHERE meeting_id=".$meeting_id;

		$mom_table_lists = \DB::select(\DB::raw($mom_table_query));

		foreach($mom_table_lists as $mom_table_list){
			if(preg_match('/'.$_SESSION['dashboard_user_id'].'/',$mom_table_list->responsible)){
				$is_ok = true;
				return $is_ok;
			}
			//$is_ok = true;
		}

		return $is_ok;
	}
	public function mom_view()
	{

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}


		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= Request::get('meeting_id');
		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= Request::get('mother_meeting_id');

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$organizer_id = $meeting_table_list->meeting_organizer_id;
		}
		if($organizer_id == $_SESSION['dashboard_user_id'])
		{
			$is_organizer = true;
		}
		else
		{
			$is_organizer = false;
		}

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$org_id = $meeting_table_list->meeting_organizer_id;

		}
		$meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		$meeting_attendee_arr = array();

		for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
				$u_name = $designation_list->user_name;
			}
			$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
			$meeting_attendee_arr[$j] = $u_name."(".$designation.")|";
		}
		//return $meeting_attendee_arr;
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	

		$count_responsible = 0;
		$mom_responsible_arr_temps = array();
		foreach($mom_table_lists as $mom_table_list)
		{
			$mom_responsible_str = $mom_table_list->responsible;
			$responsible_arr_list = explode(',', $mom_responsible_str);
			//return $responsible_arr_list;
			for($j=0;$j<count($responsible_arr_list);$j++)
			{
				 
				array_push($mom_responsible_arr_temps, $responsible_arr_list[$j]);
			}
			$count_responsible++;			
		}

		$mom_responsible_arr = array();
		//print_r($mom_responsible_arr_temps);

		for($j=0;$j<count($mom_responsible_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE email='".$mom_responsible_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			//echo $mom_responsible_arr_temps[$j];
			$meeting_attendee_temp_id = explode('@', $mom_responsible_arr_temps[$j]);
			$mom_responsible_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $mom_responsible_arr_temps;
		$getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		$designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		foreach($designation_org_lists as $designation_org_list){
			$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		}
		
		$repeated_lists = array();
		foreach($mom_table_lists as $mom_table_list){
			$get_mother_meeting_query = "SELECT mother_meeting_id FROM mom_db.meeting_table WHERE meeting_id='".$mom_table_list->meeting_id."'";
			$get_mother_meeting_lists = \DB::select(\DB::raw($get_mother_meeting_query));

			$moms_mother_meeting_id = '';

			foreach($get_mother_meeting_lists as $get_mother_meeting_list){
				$moms_mother_meeting_id = $get_mother_meeting_list->mother_meeting_id;
			}
			if($moms_mother_meeting_id != $mom_table_list->meeting_id){
				$get_all_mother_moms_query = "SELECT * FROM mom_db.mom_table WHERE meeting_id='".$moms_mother_meeting_id."'";
				$mom_title_lists = \DB::select(\DB::raw($get_all_mother_moms_query));
				//return $mom_title_lists;
				if(count($mom_title_lists) > 0){
					foreach($mom_title_lists as $mom_title_list){
						if($mom_table_list->mom_title == $mom_title_list->mom_title){
							array_push($repeated_lists,$mom_table_list->mom_title);
						}
					}
				}
			}

			
		}
		//return $repeated_lists;
		// $filePath = 'MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		// if(File::exists($filePath)) 
		// {
		// 	$meeting_files = true;
		// 	return $filePath;
		// }
		// else
		// {
		// 	$meeting_files = false;
		// }


		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	
		$mom_responsible_arr = array_unique($mom_responsible_arr);
		$mom_responsible_arr = array_values($mom_responsible_arr);

		//return $mom_responsible_arr;
		return view('mom.view_mom',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible','org_info','repeated_lists'));
	}
	public function warning_view(){
		$msg = "Your are not authorized to access this page";
		return view('mom.warning_view',compact('msg'));
	}
	public function quick_mom_view()
	{

		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= Request::get('meeting_id');

		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= Request::get('mother_meeting_id');

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$organizer_id = $meeting_table_list->meeting_organizer_id;
		}
		if($organizer_id == $_SESSION['dashboard_user_id'])
		{
			$is_organizer = true;
		}
		else
		{
			$is_organizer = false;
		}

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$org_id = $meeting_table_list->meeting_organizer_id;

		}
		$meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		$meeting_attendee_arr = array();

		for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
			$meeting_attendee_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $meeting_attendee_arr;
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	

		$count_responsible = 0;
		$mom_responsible_arr_temps = array();
		foreach($mom_table_lists as $mom_table_list)
		{
			$mom_responsible_str = $mom_table_list->responsible;
			$responsible_arr_list = explode(',', $mom_responsible_str);
			//return $responsible_arr_list;
			for($j=0;$j<count($responsible_arr_list);$j++)
			{
				 
				array_push($mom_responsible_arr_temps, $responsible_arr_list[$j]);
			}
			$count_responsible++;			
		}

		$mom_responsible_arr = array();
		//print_r($mom_responsible_arr_temps);

		for($j=0;$j<count($mom_responsible_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$mom_responsible_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			//echo $mom_responsible_arr_temps[$j];
			$meeting_attendee_temp_id = explode('@', $mom_responsible_arr_temps[$j]);
			$mom_responsible_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $mom_responsible_arr_temps;
		$getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		$designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		foreach($designation_org_lists as $designation_org_list){
			$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		}
		
		$repeated_lists = array();
		foreach($mom_table_lists as $mom_table_list){
			$get_mother_meeting_query = "SELECT mother_meeting_id FROM mom_db.meeting_table WHERE meeting_id='".$mom_table_list->meeting_id."'";
			$get_mother_meeting_lists = \DB::select(\DB::raw($get_mother_meeting_query));

			$moms_mother_meeting_id = '';

			foreach($get_mother_meeting_lists as $get_mother_meeting_list){
				$moms_mother_meeting_id = $get_mother_meeting_list->mother_meeting_id;
			}
			if($moms_mother_meeting_id != $mom_table_list->meeting_id){
				$get_all_mother_moms_query = "SELECT * FROM mom_db.mom_table WHERE meeting_id='".$moms_mother_meeting_id."'";
				$mom_title_lists = \DB::select(\DB::raw($get_all_mother_moms_query));
				//return $mom_title_lists;
				if(count($mom_title_lists) > 0){
					foreach($mom_title_lists as $mom_title_list){
						if($mom_table_list->mom_title == $mom_title_list->mom_title){
							array_push($repeated_lists,$mom_table_list->mom_title);
						}
					}
				}
			}

			
		}
		//return $repeated_lists;
		// $filePath = 'MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		// if(File::exists($filePath)) 
		// {
		// 	$meeting_files = true;
		// 	return $filePath;
		// }
		// else
		// {
		// 	$meeting_files = false;
		// }


		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	
		$mom_responsible_arr = array_unique($mom_responsible_arr);
		$mom_responsible_arr = array_values($mom_responsible_arr);

		//return $mom_table_lists;
		return view('mom.quick_view_mom',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible','org_info','repeated_lists'));
	}
	public function pdf_download(){
		// $val = $this->is_autenticated();
		// //return $val;
		// if($val == 'nopass'){
		// 	header('Location:../../login_plugin/login.php');
  //           exit();
		// }

		// $meeting_type_drop = 
		// [
		// 'firstMeeting'  => 'First Time Meeting',
		// 'followUpMeeting' => 'Follow Up Meeting',
		// 'projectMeeting' => 'Project Meeting'
		// ];
		// $meeting_status_drop = 
		// [
		// 'active'  => 'Active',
		// 'closed' => 'Closed'
		// ];
		// $mom_completion_status_drop = 
		// [
		// '0-50'  => '0-50',
		// '50-80' => '50-80',
		// '80-100' => '80-100'
		// ];
		// $meeting_id		= Request::get('meeting_id');
		// $mother_meeting_id		= Request::get('mother_meeting_id');

		// $meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		// $mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		// foreach($meeting_table_lists as $meeting_table_list)
		// {
		// 	$organizer_id = $meeting_table_list->meeting_organizer_id;
		// }
		// if($organizer_id == $_SESSION['dashboard_user_id'])
		// {
		// 	$is_organizer = true;
		// }
		// else
		// {
		// 	$is_organizer = false;
		// }

		// foreach($meeting_table_lists as $meeting_table_list)
		// {
		// 	$meeting_attendee_str = $meeting_table_list->meeting_attendee;
		// 	$mail_recipient_str = $meeting_table_list->mail_recipient;
		// 	$org_id = $meeting_table_list->meeting_organizer_id;

		// }
		// $meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		// $meeting_attendee_arr = array();

		// for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
		// 	$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
		// 	$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
		// 	foreach($designation_lists as $designation_list){
		// 		$designation  = $designation_list->designation;
		// 	}
		// 	$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
		// 	$meeting_attendee_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		// }
		// $mail_recipient_arr   = explode(',', $mail_recipient_str);	

		// $count_responsible = 0;
		// $mom_responsible_arr = array();
		// foreach($mom_table_lists as $mom_table_list)
		// {
		// 	$mom_responsible_str = $mom_table_list->responsible;
		// 	$responsible_arr_list = explode(',', $mom_responsible_str);
		// 	//return $responsible_arr_list;
		// 	for($j=0;$j<count($responsible_arr_list);$j++)
		// 	{
		// 		//return $responsible_arr_list[$j+1];
		// 		array_push($mom_responsible_arr, $responsible_arr_list[$j]);
		// 	}
		// 	$count_responsible++;			
		// }
		// // $filePath = 'MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		// // if(File::exists($filePath)) 
		// // {
		// // 	$meeting_files = true;
		// // 	//return $filePath;
		// // }
		// // else
		// // {
		// // 	$meeting_files = false;
		// // }
		// $getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		// $designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		// foreach($designation_org_lists as $designation_org_list){
		// 	$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		// }





		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}


		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= Request::get('meeting_id');
		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= Request::get('mother_meeting_id');

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$organizer_id = $meeting_table_list->meeting_organizer_id;
		}
		if($organizer_id == $_SESSION['dashboard_user_id'])
		{
			$is_organizer = true;
		}
		else
		{
			$is_organizer = false;
		}

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$org_id = $meeting_table_list->meeting_organizer_id;

		}
		$meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		$meeting_attendee_arr = array();

		for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
			$meeting_attendee_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $meeting_attendee_arr;
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	

		$count_responsible = 0;
		$mom_responsible_arr_temps = array();
		foreach($mom_table_lists as $mom_table_list)
		{
			$mom_responsible_str = $mom_table_list->responsible;
			$responsible_arr_list = explode(',', $mom_responsible_str);
			//return $responsible_arr_list;
			for($j=0;$j<count($responsible_arr_list);$j++)
			{
				 
				array_push($mom_responsible_arr_temps, $responsible_arr_list[$j]);
			}
			$count_responsible++;			
		}

		$mom_responsible_arr = array();
		//print_r($mom_responsible_arr_temps);

		for($j=0;$j<count($mom_responsible_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$mom_responsible_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			//echo $mom_responsible_arr_temps[$j];
			$meeting_attendee_temp_id = explode('@', $mom_responsible_arr_temps[$j]);
			$mom_responsible_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $mom_responsible_arr_temps;
		$getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		$designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		foreach($designation_org_lists as $designation_org_list){
			$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		}
		
		$repeated_lists = array();
		foreach($mom_table_lists as $mom_table_list){
			$get_mother_meeting_query = "SELECT mother_meeting_id FROM mom_db.meeting_table WHERE meeting_id='".$mom_table_list->meeting_id."'";
			$get_mother_meeting_lists = \DB::select(\DB::raw($get_mother_meeting_query));

			$moms_mother_meeting_id = '';

			foreach($get_mother_meeting_lists as $get_mother_meeting_list){
				$moms_mother_meeting_id = $get_mother_meeting_list->mother_meeting_id;
			}
			if($moms_mother_meeting_id != $mom_table_list->meeting_id){
				$get_all_mother_moms_query = "SELECT * FROM mom_db.mom_table WHERE meeting_id='".$moms_mother_meeting_id."'";
				$mom_title_lists = \DB::select(\DB::raw($get_all_mother_moms_query));
				//return $mom_title_lists;
				if(count($mom_title_lists) > 0){
					foreach($mom_title_lists as $mom_title_list){
						if($mom_table_list->mom_title == $mom_title_list->mom_title){
							array_push($repeated_lists,$mom_table_list->mom_title);
						}
					}
				}
			}

			
		}
		//return $repeated_lists;
		// $filePath = 'MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		// if(File::exists($filePath)) 
		// {
		// 	$meeting_files = true;
		// 	return $filePath;
		// }
		// else
		// {
		// 	$meeting_files = false;
		// }


		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	
		$mom_responsible_arr = array_unique($mom_responsible_arr);
		$mom_responsible_arr = array_values($mom_responsible_arr);





		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	

		//return $mom_table_lists;
	    $html = view('mom.pdf_view',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible','org_info','repeated_lists'))->render();
	    $html = str_replace("/images", public_path()."/images", $html);

	    //return public_path();
	    //return $html;

   		return PDF::load($html)->filename($meeting_id.".pdf")->download();

		// return view('mom.view_mom',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible'));
	}
	public function guest_mom_view(){
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}

		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= Request::get('meeting_id');

		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= Request::get('mother_meeting_id');

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$organizer_id = $meeting_table_list->meeting_organizer_id;
		}
		if($organizer_id == $_SESSION['dashboard_user_id'])
		{
			$is_organizer = true;
		}
		else
		{
			$is_organizer = false;
		}

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$org_id = $meeting_table_list->meeting_organizer_id;

		}
		$meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		$meeting_attendee_arr = array();

		for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
			$meeting_attendee_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	

		$count_responsible = 0;
		$mom_responsible_arr = array();
		foreach($mom_table_lists as $mom_table_list)
		{
			$mom_responsible_str = $mom_table_list->responsible;
			$responsible_arr_list = explode(',', $mom_responsible_str);
			//return $responsible_arr_list;
			for($j=0;$j<count($responsible_arr_list);$j++)
			{
				//return $responsible_arr_list[$j+1];
				array_push($mom_responsible_arr, $responsible_arr_list[$j]);
			}
			$count_responsible++;			
		}
		$filePath = '../MeetingFiles/'.$meeting_id.'/';
		if(File::exists($filePath)) 
		{
			$meeting_files = true;
			//return $filePath.'adf';
		}
		else
		{
			$meeting_files = false;
		}
		$getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		$designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		foreach($designation_org_lists as $designation_org_list){
			$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		}


		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	

		//return $filePath;
		return view('mom.guest_mom_view',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible','meeting_files','org_info'));
	}
	public function createMailOld($from,$to_arr,$login_id_arr,$meeting_id)
	{
		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$meeting_id.";"));
		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_title = $meeting_table_list->meeting_title;
		}
	    // $is_sent = false;
	    $to_arr = array_unique($to_arr);
	    for($i=0;$i<count($to_arr);$i++)
	    {
	    	//$phpMailer   = new phpMailer();
	    	//$phpMailer->phpMailer();
	     //    $phpMailer->set_from($from);
	     
	     //    $phpMailer->add_to($to_arr[$i]);
	        $subject_str = 'MOM Created : '.$meeting_title;
		    //$phpMailer->set_subject($subject_str);
		    $messages = '<html><body>';
		    $messages .= '<br>Dear Concern,<br>';
			$messages .= '<h3>A New MoM created by '.$organizer_name.' please click the below link to see</h3>';
			
			$to_arr_temp = explode('|', $to_arr[$i]);
			if(count($to_arr_temp)>1){
				$toAddress = $to_arr_temp[0];
			}	
			else{
				$toAddress = $to_arr[$i];
			}
			$toAddressArr = explode('@', $toAddress);
			if($toAddressArr[1] == 'summitcommunications.net' || $toAddressArr[1] == 'summit-centre.com'){
				$messages .= "<p><a href='http://103.15.245.166:8005/mom/public/MailView?meeting_id=".$meeting_id."&login_id=".$toAddressArr[0]."'>Click here</a></p>";
			}
			else{
				$messages .= "<p><a href='http://103.15.245.166:8005/mom/public/guestMOM?meeting_id=".$meeting_id."&login_id=".$toAddressArr[0]."'>Click here</a></p>";
			}
			$messages .= '<br>Thanks';
			$messages .= "</body></html>";

			$data = array( 'email' => $toAddress , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $subject_str );
		
			Mail::send(array(), array(), function ($message) use ($data) {
			  $message->from($data['from'], 'MOM');
			  $message->to($data['email'], '')
			    ->subject($data['sub'])
			    ->setBody($data['msg'], 'text/html');
			});

		    // $phpMailer->set_html($message);

		    // $phpMailer->set_smtp_host("webmail.summitcommunications.net");
		  
		    // if ($phpMailer->send())  
		    //   $is_sent = true; 
		    // else
		    //   $is_sent = false;
		}
		// if ($is_sent == true)  
		return redirect()->back();  
		// else
		//     return 'failed Send Mail';

    }
    public function mail_sending_view(){
		$from = "showmen.barua";
		$toArr = array();

		
		
		
		array_push($toArr, "showmen.barua@summitcommunications.net");
		array_push($toArr, "niaz.mithu");
		array_push($toArr, "ali.mehraj@summitcommunications.net");

		$login_id_arr = array();

		array_push($login_id_arr,"showmen.barua");

		$meeting_id = "44";

		$organizer_name = "showmen.barua";
		//return view('mom.mail_sending_view',compact('from','toArr','login_id_arr','meeting_id','organizer_name'));
		return redirect('landing');
		
	}
	public function modal_sending_process(){
		$from = Request::get('from');
		$meeting_id = Request::get('meeting_id');
		$organizer_name = Request::get('organizer_name');
		$to_list = Request::get('to_list');
		$toArr = explode(',', $to_list);
		$login_id_arr = '';

		//return $meeting_id;

		return view('mom.mail_sending_view',compact('from','toArr','login_id_arr','meeting_id','organizer_name'));

	}
  //   public function createMail($counTime,$val){
  //   	$returnArr =  array();
		// $count = $counTime+1;
		// //sleep(1);
		// $str = $val;

		// $strArr = explode(",",$str);

		// $meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$strArr[2].";"));
		// foreach($meeting_table_lists as $meeting_table_list)
		// {
		// 	$meeting_title = $meeting_table_list->meeting_title;
		// }

	
		// try{
		// 	$subject_str = 'MOM Created : '.$meeting_title;
		//     //$phpMailer->set_subject($subject_str);
		//     $messages = '<html><body>';
		//     $messages .= '<br>Dear Concern,<br>';
		// 	$messages .= '<h3>A New MoM created by '.$strArr[3].' please click the below link to see</h3>';
			
		// 	$to_arr_temp = explode('|', $strArr[1]);
		// 	if(count($to_arr_temp)>1){
		// 		$toAddress = $to_arr_temp[0];
		// 	}	
		// 	else{
		// 		$toAddress = $strArr[1];
		// 	}
		// 	$toAddressArr = explode('@', $toAddress);
		// 	if($toAddressArr[1] == 'summitcommunications.net' || $toAddressArr[1] == 'summit-centre.com'){
		// 		$messages .= "<p><a href='http://172.16.136.35/mom/public/MailView?meeting_id=".$strArr[2]."&login_id=".$toAddressArr[0]."'>Click here</a></p>";
		// 	}
		// 	else{
		// 		$messages .= "<p><a href='http://103.15.245.166:8005/mom/public/guestMOM?meeting_id=".$strArr[2]."&login_id=".$toAddressArr[0]."'>Click here</a></p>";
		// 	}
		// 	$messages .= '<br>Thanks';
		// 	$messages .= "</body></html>";

		// 	$data = array( 'email' => $toAddress , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $subject_str );

		// 	//return $toAddress;
		
		// 	Mail::send(array(), array(), function ($message) use ($data) {
		// 	  $message->from($data['from'], 'MOM');
		// 	  $message->to($data['email'], '')
		// 	    ->subject($data['sub'])
		// 	    ->setBody($data['msg'], 'text/html');
		// 	});
		// 	$returnArr["count"] = $count;
		// 	$returnArr["str"] = $strArr[1];
		// 	return $returnArr;
		// }
		// catch(Exception $e){
		// 	$returnArr["count"] = $count;
		// 	$returnArr["str"] = $str;
		// 	return $returnArr;
		// }


		
  //   }
    public function createMail($counTime,$val){
    	$returnArr =  array();
		$count = $counTime+1;
		//sleep(1);
		$str = $val;

		$strArr = explode(",",$str);

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$strArr[2].";"));
		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_title = $meeting_table_list->meeting_title;
			$mother_meeting_id = $meeting_table_list->mother_meeting_id;
		}

	
		try{
			$subject_str = 'MOM Created via SCL MOM TOOL : '.$meeting_title;
		    //$phpMailer->set_subject($subject_str);
		    $messages = '<html><body>';
		    $messages .= '<br>Dear Concern,<br>';
			
			
			$to_arr_temp = explode('|', $strArr[1]);
			if(count($to_arr_temp)>1){
				$toAddress = $to_arr_temp[0];
			}	
			else{
				$toAddress = $strArr[1];
			}
			$toAddressArr = explode('@', $toAddress);
			if($toAddressArr[1] == 'summitcommunications.net' || $toAddressArr[1] == 'summit-centre.com'){
				$messages .= '<h3>A New MoM created by '.$strArr[3].' please click the below link to see</h3>';
				$messages .= "<p><a href='http://103.15.245.166:8005/mom/public/MailView?meeting_id=".$strArr[2]."&login_id=".$toAddressArr[0]."'>Click here</a></p>";

				$messages .= '<br>Thanks';
				$messages .= "</body></html>";

				$data = array( 'email' => $toAddress , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $subject_str );

				//return $toAddress;
			
				Mail::send(array(), array(), function ($message) use ($data) {
				  $message->from($data['from'], 'MOM');
				  $message->to($data['email'], '')
				    ->subject($data['sub'])
				    ->setBody($data['msg'], 'text/html');
				});
				$returnArr["count"] = $count;
				$returnArr["str"] = $strArr[1];
				return $returnArr;
			}
			else{
				$messages .= '<h3>A New MoM created by '.$strArr[3].'. Please see the attached file</h3>';
				$this->guest_pdf_save($strArr[2],$mother_meeting_id,$strArr[4]);
				//$messages .= "<p><a href='http://172.16.136.35/mom/public/guestMOM?meeting_id=".$strArr[2]."&login_id=".$toAddressArr[0]."'>Click here</a></p>";
			
				$messages .= '<br>Thanks';
				$messages .= "</body></html>";
				$dirPath = '../TempFiles/mom.pdf';

				$data = array( 'email' => $toAddress , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $subject_str, 'path' => $dirPath  );

				//return $toAddress;
				
			
				Mail::send(array(), array(), function ($message) use ($data) {
				  $message->from($data['from'], 'MOM');
				  $message->to($data['email'], '')
				    ->subject($data['sub'])
				    ->setBody($data['msg'], 'text/html');
				  $message->attach($data['path']);
				});
				$returnArr["count"] = $count;
				$returnArr["str"] = $strArr[1];
				return $returnArr;
			}
		}
		catch(Exception $e){
			$returnArr["count"] = $count;
			$returnArr["str"] = $str;
			return $returnArr;
		}


		
    }
    public function guest_pdf_save($param_meeting_id,$param_mother_meeting_id,$param_user_id){
		$val = $this->is_autenticated();
		//return $val;
		if($val == 'nopass'){
			header('Location:../../login_plugin/login.php');
            exit();
		}


		$meeting_type_drop = 
		[
		'firstMeeting'  => 'First Time Meeting',
		'followUpMeeting' => 'Follow Up Meeting',
		'projectMeeting' => 'Project Meeting'
		];
		$meeting_status_drop = 
		[
		'active'  => 'Active',
		'closed' => 'Closed'
		];
		$mom_completion_status_drop = 
		[
		'0-50'  => '0-50',
		'50-80' => '50-80',
		'80-100' => '80-100'
		];
		$meeting_id		= $param_meeting_id;
		$is_view_ok = $this->checker($meeting_id);
		if($is_view_ok == false){
			return redirect('warning');
		}

		$mother_meeting_id		= $param_mother_meeting_id;

		$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id ='".$meeting_id."';"));	
		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id ='".$meeting_id."';"));

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$organizer_id = $meeting_table_list->meeting_organizer_id;
		}
		if($organizer_id == $param_user_id)
		{
			$is_organizer = true;
		}
		else
		{
			$is_organizer = false;
		}

		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$org_id = $meeting_table_list->meeting_organizer_id;

		}
		$meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		$meeting_attendee_arr = array();

		for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
			$meeting_attendee_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $meeting_attendee_arr;
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	

		$count_responsible = 0;
		$mom_responsible_arr_temps = array();
		foreach($mom_table_lists as $mom_table_list)
		{
			$mom_responsible_str = $mom_table_list->responsible;
			$responsible_arr_list = explode(',', $mom_responsible_str);
			//return $responsible_arr_list;
			for($j=0;$j<count($responsible_arr_list);$j++)
			{
				 
				array_push($mom_responsible_arr_temps, $responsible_arr_list[$j]);
			}
			$count_responsible++;			
		}

		$mom_responsible_arr = array();
		//print_r($mom_responsible_arr_temps);

		for($j=0;$j<count($mom_responsible_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$mom_responsible_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			//echo $mom_responsible_arr_temps[$j];
			$meeting_attendee_temp_id = explode('@', $mom_responsible_arr_temps[$j]);
			$mom_responsible_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		//return $mom_responsible_arr_temps;
		$getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		$designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		foreach($designation_org_lists as $designation_org_list){
			$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		}
		
		$repeated_lists = array();
		foreach($mom_table_lists as $mom_table_list){
			$get_mother_meeting_query = "SELECT mother_meeting_id FROM mom_db.meeting_table WHERE meeting_id='".$mom_table_list->meeting_id."'";
			$get_mother_meeting_lists = \DB::select(\DB::raw($get_mother_meeting_query));

			$moms_mother_meeting_id = '';

			foreach($get_mother_meeting_lists as $get_mother_meeting_list){
				$moms_mother_meeting_id = $get_mother_meeting_list->mother_meeting_id;
			}
			if($moms_mother_meeting_id != $mom_table_list->meeting_id){
				$get_all_mother_moms_query = "SELECT * FROM mom_db.mom_table WHERE meeting_id='".$moms_mother_meeting_id."'";
				$mom_title_lists = \DB::select(\DB::raw($get_all_mother_moms_query));
				//return $mom_title_lists;
				if(count($mom_title_lists) > 0){
					foreach($mom_title_lists as $mom_title_list){
						if($mom_table_list->mom_title == $mom_title_list->mom_title){
							array_push($repeated_lists,$mom_table_list->mom_title);
						}
					}
				}
			}

			
		}
		//return $repeated_lists;
		// $filePath = 'MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		// if(File::exists($filePath)) 
		// {
		// 	$meeting_files = true;
		// 	return $filePath;
		// }
		// else
		// {
		// 	$meeting_files = false;
		// }


		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	
		$mom_responsible_arr = array_unique($mom_responsible_arr);
		$mom_responsible_arr = array_values($mom_responsible_arr);





		//return $responsible_arr_list;
		// $mom_responsible_arr = explode(',', $mom_responsible_str);	

		//return $mom_table_lists;
	    $html = view('mom.pdf_view',compact('meeting_table_lists','mom_table_lists','meeting_id','meeting_type_drop','meeting_status_drop','mother_meeting_id','is_organizer','mom_completion_status_drop','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible','org_info','repeated_lists'))->render();
	    $html = str_replace("/images", public_path()."/images", $html);

	    $dirPath = '../TempFiles/';

   		PDF::load($html)->filename($dirPath.'mom.pdf')->output();


	}
    public function mail_view()
    {
    	$meeting_id		= Request::get('meeting_id');
    	$login_id 		= Request::get('login_id');

    	$meeting_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$meeting_id.";"));

    	$seen_users = '';
  //   	foreach($meeting_table_lists as $meeting_table_list)
  //   	{
  //   		$seen_users_previous = $meeting_table_list->seen_users;
  //   	}
  //   	if($seen_users_previous !='' && !preg_match('/[$login_id ]/',$seen_users_previous))
  //   	{
  //   		$seen_users = $seen_users_previous.",".$login_id;
  //   	}
  //   	if($seen_users_previous =='')
  //   	{
  //   		$seen_users = $login_id;
  //   	}
		
  //   	if($seen_users !="")
  //   	{
	 //    	$meeting_update_querystring = "UPDATE meeting_table SET seen_users='".$seen_users."' WHERE meeting_id=".$meeting_id.";" ;
		// 	\DB::update(\DB::raw($meeting_update_querystring));
		// }

		$mom_table_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE meeting_id =".$meeting_id.";"));
		//$org_id = '';
		foreach($meeting_table_lists as $meeting_table_list)
		{
			$meeting_attendee_str = $meeting_table_list->meeting_attendee;
			$mail_recipient_str = $meeting_table_list->mail_recipient;
			$org_id = $meeting_table_list->meeting_organizer_id;

		}
		$meeting_attendee_arr_temps = explode(',', $meeting_attendee_str);
		$meeting_attendee_arr = array();

		for($j=0;$j<count($meeting_attendee_arr_temps);$j++){
			$getDesignationQuery = "SELECT dept,designation FROM login_plugin_db.login_table WHERE email='".$meeting_attendee_arr_temps[$j]."'";
			$designation_lists = \DB::select(\DB::raw($getDesignationQuery));
			foreach($designation_lists as $designation_list){
				$designation  = $designation_list->designation;
			}
			$meeting_attendee_temp_id = explode('@', $meeting_attendee_arr_temps[$j]);
			$meeting_attendee_arr[$j] = $meeting_attendee_temp_id[0]."(".$designation.")|";
		}
		$mail_recipient_arr   = explode(',', $mail_recipient_str);	

		$count_responsible = 0;
		$mom_responsible_arr = array();
		foreach($mom_table_lists as $mom_table_list)
		{
			$mom_responsible_str = $mom_table_list->responsible;
			$responsible_arr_list = explode(',', $mom_responsible_str);
			//return $responsible_arr_list;
			for($j=0;$j<count($responsible_arr_list);$j++)
			{
				//return $responsible_arr_list[$j+1];
				array_push($mom_responsible_arr, $responsible_arr_list[$j]);
			}
			$count_responsible ++;			
		}
		$filePath = '../MeetingFiles/'.$meeting_id;
		if(File::exists($filePath)) 
		{
			$meeting_files = true;
		}
		else
		{
			$meeting_files = false;
		}

		$getDesignationOrgQuery = "SELECT dept,designation,user_name FROM login_plugin_db.login_table WHERE user_id='".$org_id."'";
		$designation_org_lists = \DB::select(\DB::raw($getDesignationOrgQuery));

		foreach($designation_org_lists as $designation_org_list){
			$org_info = $designation_org_list->user_name." (".$designation_org_list->designation." , ".$designation_org_list->dept.")";
		}
		//return $count_responsible;

		return view('mom.mom_view_from_mail',compact('meeting_table_lists','mom_table_lists','meeting_id','login_id','meeting_attendee_arr','mail_recipient_arr','mom_responsible_arr','count_responsible','meeting_files','org_info'));
    }
    public function sendReminderMails()
    {
    	
    	//echo "<script>var myWindow = window.open();</script>";
  // 		date_default_timezone_set('Asia/Dhaka');
		// $current_date_obj = new DateTime();
		// $current_date_obj->setTime(9, 00, 00);
		// $current_date = $current_date_obj->format('Y-m-d H:i:s');
		// $current_date_tomorrow_obj = new DateTime();//date('Y/m/d h:i:s', time() - 86400);
		// $current_date_tomorrow_obj->setTime(00, 01, 00);
		// $current_date_tomorrow_obj->modify('+2 day');
		// $current_date_tomorrow = $current_date_tomorrow_obj->format('Y-m-d H:i:s');
  // 		$mom_table_t4_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE mom_status='active' and end_time BETWEEN '".$current_date."' and '".$current_date_tomorrow."'; "));

  // 		$toArr = array();
  // 		$momArr = array();
  // 		$exists = false;
  		

  // 		foreach($mom_table_t4_lists as $mom_table_t4_list)
  // 		{
  // 			$meeting_lists =  \DB::select(\DB::raw("SELECT meeting_organizer_id FROM mom_db.meeting_table WHERE meeting_id =".$mom_table_t4_list->meeting_id."; "));

  // 			foreach($meeting_lists as $meeting_list)
  // 			{
  // 				$organizer_id = $meeting_list->meeting_organizer_id;
  // 			}

  // 			$user_table_t4_lists = \DB::select(\DB::raw("SELECT email FROM login_plugin_db.login_table WHERE user_id ='".$organizer_id."'; "));

  // 			foreach($user_table_t4_lists  as $user_table_t4_list)
  // 			{
  // 				$from = $user_table_t4_list->email;
  // 			}
  // 			//$from = "showmen.barua@summitcommunications.net";
  			
  // 			$temp_responsible_arr = explode(',', $mom_table_t4_list->responsible);
  // 				for($i=0;$i<count($temp_responsible_arr);$i++)
  // 				{
  // 					// $phpMailer   = new phpMailer();
	 //    		// 	$phpMailer->phpMailer();
  // 					// $phpMailer->set_from($from);
  // 					$to_arr_temp = explode('|', $temp_responsible_arr[$i]);
		// 			if(count($to_arr_temp)>1){
		// 				$toAddress = $to_arr_temp[0];
		// 			}	
		// 			else{
		// 				$toAddress = $temp_responsible_arr[$i];
		// 			}

  // 					$toArr[$i] = $toAddress; 

  // 					// $phpMailer->add_to($toArr[$i]);//$phpMailer->add_to($toArr[$i]."@summitcommunications.net");
  // 					$sub = "Pending MoM : ".$mom_table_t4_list->mom_title;
  // 					// $phpMailer->set_subject($sub);
		// 		    $messages = '<html><body>';
		// 		    $messages .= "<p>Pending MoM</p>";
		// 		    $messages .= '<table  style="border:1px solid black;">';
		// 		    $messages .= '<tr style="border:1px solid black;">';
		// 			$messages .= '<td style="border:1px solid black;">Mom Title :</td><td style="border:1px solid black;">'.$mom_table_t4_list->mom_title.'</td>';
		// 			$messages .= '</tr>';
		// 			$messages .= '<tr>';
		// 			$messages .= '<td style="border:1px solid black;">Mom Start Time :</td><td style="border:1px solid black;">'.$mom_table_t4_list->start_time.'</td>';
		// 			$messages .= '</tr>';
		// 			$messages .= '<tr>';
		// 			$messages .= '<td style="border:1px solid black;">Mom End Time :</td><td style="border:1px solid black;">'.$mom_table_t4_list->end_time.'</td>';
		// 			$messages .= '</tr>';
		// 			$messages .= '<tr>';
		// 			$messages .= '<td style="border:1px solid black;">Comment :</td><td style="border:1px solid black;">'.$mom_table_t4_list->comment.'</td>';
		// 			$messages .= '</tr>';
		// 			$messages .= '</table>';
		// 			$messages .= "<p>Do your job</p>";
		// 			$messages .= "</body></html>";

		// 			$data = array( 'email' => $toArr[$i] , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );
		
		// 			Mail::send(array(), array(), function ($message) use ($data) {
		// 			  $message->from($data['from'], 'MOM');
		// 			  $message->to($data['email'], '')
		// 			    ->subject($data['sub'])
		// 			    ->setBody($data['msg'], 'text/html');
		// 			});
		// 		    // $phpMailer->set_html($message);

		// 		    // $phpMailer->set_smtp_host("webmail.summitcommunications.net");
		// 		    // $phpMailer->send();	
		//   		}
  			
  // 			} 



    	




  // 		date_default_timezone_set('Asia/Dhaka');
		// $current_date_obj = new DateTime();
		// $current_date_obj->setTime(00, 01, 00);
		// $current_date = $current_date_obj->format('Y-m-d H:i:s');
		// $current_date_previous_obj = new DateTime();//date('Y/m/d h:i:s', time() - 86400);
		// $current_date_previous_obj->setTime(9, 00, 00);
		// $current_date_previous_obj->modify('-20 day');
		// $current_date_previous = $current_date_previous_obj->format('Y-m-d H:i:s');
  // 		$mom_table_t4_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE mom_status='active' and end_time BETWEEN '".$current_date_previous."' and '".$current_date."'; "));

  // 		$toArr = array();
  // 		$momArr = array();
  // 		$exists = false;
  		

  // 		foreach($mom_table_t4_lists as $mom_table_t4_list)
  // 		{
  // 			$meeting_lists =  \DB::select(\DB::raw("SELECT meeting_organizer_id FROM mom_db.meeting_table WHERE meeting_id =".$mom_table_t4_list->meeting_id."; "));

  // 			foreach($meeting_lists as $meeting_list)
  // 			{
  // 				$organizer_id = $meeting_list->meeting_organizer_id;
  // 			}
  // 			return $organizer_id;
  // 			$user_table_t4_lists = \DB::select(\DB::raw("SELECT email FROM login_plugin_db.login_table WHERE user_id ='".$organizer_id."'; "));

  // 			foreach($user_table_t4_lists  as $user_table_t4_list)
  // 			{
  // 				$from = $user_table_t4_list->email;
  // 			}
  			
  // 			//$from = "showmen.barua@summitcommunications.net";
  			
  // 			$temp_responsible_arr = explode(',', $mom_table_t4_list->responsible);
  // 			for($i=0;$i<count($temp_responsible_arr);$i++)
  // 			{
  // 				// $phpMailer   = new phpMailer();
	 //    	// 	$phpMailer->phpMailer();
  // 				// $phpMailer->set_from($from);
  // 				$to_arr_temp = explode('|', $temp_responsible_arr[$i]);
		// 			if(count($to_arr_temp)>1){
		// 				$toAddress = $to_arr_temp[0];
		// 			}	
		// 			else{
		// 				$toAddress = $temp_responsible_arr[$i];
		// 			}
  // 				$toArr[$i]= $toAddress; 
  // 				// $phpMailer->add_to($toArr[$i]);//$phpMailer->add_to($toArr[$i]."@summitcommunications.net");
  // 				$sub 	  = "Passed MoM : ".$mom_table_t4_list->mom_title;
  // 				// $phpMailer->set_subject($sub);
		// 	    $messages  = '<html><body>';
		// 	    $messages .= "<p>Passed MoM</p>";
		// 	    $messages .= '<table  style="border:1px solid black;">';
		// 	    $messages .= '<tr style="border:1px solid black;">';
		// 		$messages .= '<td style="border:1px solid black;">Mom Title :</td><td style="border:1px solid black;">'.$mom_table_t4_list->mom_title.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '<tr>';
		// 		$messages .= '<td style="border:1px solid black;">Mom Start Time :</td><td style="border:1px solid black;">'.$mom_table_t4_list->start_time.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '<tr>';
		// 		$messages .= '<td style="border:1px solid black;">Mom End Time :</td><td style="border:1px solid black;">'.$mom_table_t4_list->end_time.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '<tr>';
		// 		$messages .= '<td style="border:1px solid black;">Comment :</td><td style="border:1px solid black;">'.$mom_table_t4_list->comment.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '</table>';
		// 		$messages .= "<p>Do your job</p>";
		// 		$messages .= "</body></html>";

		// 		$data = array( 'email' => $toArr[$i] , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );
		
		// 		Mail::send(array(), array(), function ($message) use ($data) {
		// 			  $message->from($data['from'], 'MOM');
		// 			  $message->to($data['email'], '')
		// 			    ->subject($data['sub'])
		// 			    ->setBody($data['msg'], 'text/html');
		// 		});
		// 	 //    $phpMailer->set_html($message);
		// 		// $phpMailer->set_smtp_host("webmail.summitcommunications.net");

		// 	    //$phpMailer->send();	
		//   	}
		//   	// print_r($toArr);
		//   	for($i=0;$i<count($temp_responsible_arr);$i++)
  // 			{
  // 				// $phpMailer   = new phpMailer();
	 //    	// 	$phpMailer->phpMailer();
  // 				// $phpMailer->set_from($from);
  // 				$toArr[$i]= $temp_responsible_arr[$i];

  // 				$email_to =  $toArr[$i];//."@summitcommunications.net";
  // 				$user_table_lists = \DB::select(\DB::raw("SELECT supervisor_id FROM mom_db.user_table WHERE email ='".$email_to."'; "));
  // 				foreach($user_table_lists as $user_table_list)
  // 				{
  // 					$supervisor_id = $user_table_list->supervisor_id; 
  // 				}

  // 				// $phpMailer->add_to($supervisor_id);
  // 				$sub 	  = "Passed MOM : ".$mom_table_t4_list->mom_title;
  // 				// $phpMailer->set_subject($sub);
		// 	    $messages  = '<html><body>';
		// 	    $messages .= "<p>Passed MoM</p>";
		// 	    $messages .= '<table  style="border:1px solid black;">';
		// 	    $messages .= '<tr style="border:1px solid black;">';
		// 		$messages .= '<td style="border:1px solid black;">Mom Title :</td><td style="border:1px solid black;">'.$mom_table_t4_list->mom_title.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '<tr>';
		// 		$messages .= '<td style="border:1px solid black;">Mom Start Time :</td><td style="border:1px solid black;">'.$mom_table_t4_list->start_time.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '<tr>';
		// 		$messages .= '<td style="border:1px solid black;">Mom End Time :</td><td style="border:1px solid black;">'.$mom_table_t4_list->end_time.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '<tr>';
		// 		$messages .= '<td style="border:1px solid black;">Comment :</td><td style="border:1px solid black;">'.$mom_table_t4_list->comment.'</td>';
		// 		$messages .= '</tr>';
		// 		$messages .= '</table>';
		// 		$messages .= "<p>Person failed this mom ".$toArr[$i]."</p>";
		// 		$messages .= "</body></html>";

		// 		$data = array( 'email' => $toArr[$i] , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );
		
		// 		Mail::send(array(), array(), function ($message) use ($data) {
		// 			  $message->from($data['from'], 'MOM');
		// 			  $message->to($data['email'], '')
		// 			    ->subject($data['sub'])
		// 			    ->setBody($data['msg'], 'text/html');
		// 		});
		// 	 //    $phpMailer->set_html($message);
		// 		// $phpMailer->set_smtp_host("webmail.summitcommunications.net");
				
		// 	 //    $phpMailer->send();	

		//   	}		
  // 		} 			





    	//$this->t4Mail();
    	//$this->afterEndTimeMail();

    	//return 'asdf';
  //   	echo  "<script type='text/javascript'>";
  //   	echo "function windowClose() { ";
  //   	echo "window.open('','_parent','');"; 
		// echo "window.close();}";
  //   	echo "</script>";
  //   	echo '<input type="button" value="Close this window" onclick="windowClose();">';
    	return view('mom.closing');
    }
    public function t4Mail()
  	{
  		
  		date_default_timezone_set('Asia/Dhaka');
		$current_date_obj = new DateTime();
		$current_date_obj->setTime(9, 00, 00);
		$current_date = $current_date_obj->format('Y-m-d H:i:s');
		$current_date_tomorrow_obj = new DateTime();//date('Y/m/d h:i:s', time() - 86400);
		$current_date_tomorrow_obj->setTime(00, 01, 00);
		$current_date_tomorrow_obj->modify('+2 day');
		$current_date_tomorrow = $current_date_tomorrow_obj->format('Y-m-d H:i:s');
  		$mom_table_t4_lists = \DB::select(\DB::raw("SELECT * FROM mom_db.mom_table WHERE mom_status='active' and end_time BETWEEN '".$current_date."' and '".$current_date_tomorrow."'; "));

  		$toArr = array();
  		$momArr = array();
  		$exists = false;
  		

  		foreach($mom_table_t4_lists as $mom_table_t4_list)
  		{
  			$meeting_lists =  \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$mom_table_t4_list->meeting_id."; "));

  			foreach($meeting_lists as $meeting_list)
  			{
  				$organizer_id = $meeting_list->meeting_organizer_id;
  				$meeting_title = $meeting_list->meeting_title;
  				$meeting_datetime = $meeting_list->meeting_datetime;
  			}

  			$user_table_t4_lists = \DB::select(\DB::raw("SELECT email FROM login_plugin_db.login_table  WHERE user_id ='".$organizer_id."'; "));

  			foreach($user_table_t4_lists  as $user_table_t4_list)
  			{
  				$from = $user_table_t4_list->email;
  			}
  			//$from = "showmen.barua@summitcommunications.net";
  			
  			$temp_responsible_arr = explode(',', $mom_table_t4_list->responsible);
  				for($i=0;$i<count($temp_responsible_arr);$i++)
  				{
  					// $phpMailer   = new phpMailer();
	    		// 	$phpMailer->phpMailer();
  					// $phpMailer->set_from($from);
  					$to_arr_temp = explode('|', $temp_responsible_arr[$i]);
					if(count($to_arr_temp)>1){
						$toAddress = $to_arr_temp[0];
					}	
					else{
						$toAddress = $temp_responsible_arr[$i];
					}

  					$toArr[$i] = $toAddress; 

  					// $phpMailer->add_to($toArr[$i]);//$phpMailer->add_to($toArr[$i]."@summitcommunications.net");
  					$sub = "Pending MoM : ".$mom_table_t4_list->mom_title;

  					//$meetingInfoQuery = "SELECT * FROM mom_db.meeting_table WHERE meeting_id=""
  					// $phpMailer->set_subject($sub);
				    $messages = '<html><body>';
				    $messages .= '<br>Dear Concern,<br>';
				    $messages .= '<p>Pending MoM of the Meeting titled:'.$meeting_title.' , Meeting time : '.$meeting_datetime.'</p>';
				    $messages .= '<table  style="border:1px solid black;">';
				    $messages .= '<tr style="border:1px solid black;">';
					$messages .= '<td style="border:1px solid black;">Action Point Title :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->mom_title.'</td>';
					$messages .= '</tr>';
					$messages .= '<tr>';
					$messages .= '<td style="border:1px solid black;">Action Point Start Time :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->start_time.'</td>';
					$messages .= '</tr>';
					$messages .= '<tr>';
					$messages .= '<td style="border:1px solid black;">Action Point End Time :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->end_time.'</td>';
					$messages .= '</tr>';
					$messages .= '<tr>';
					$messages .= '<td style="border:1px solid black;">Comment :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->comment.'</td>';
					$messages .= '</tr>';
					$messages .= '</table><br>';
					$messages .= "<p>Thanks</p>";
					$messages .= "</body></html>";

					$data = array( 'email' => $toArr[$i] , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );
		
					// Mail::send(array(), array(), function ($message) use ($data) {
					//   $message->from($data['from'], 'MOM');
					//   $message->to($data['email'], '')
					//     ->subject($data['sub'])
					//     ->setBody($data['msg'], 'text/html');
					// });
				    // $phpMailer->set_html($message);

				    // $phpMailer->set_smtp_host("webmail.summitcommunications.net");
				    // $phpMailer->send();
				    //echo $messages;	
		  		}
  			
  			} 			
  		
  	}
  	public function afterEndTimeMail()
  	{
  		//return 'adf';
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
  		

  		foreach($mom_table_t4_lists as $mom_table_t4_list)
  		{
  			$meeting_lists =  \DB::select(\DB::raw("SELECT * FROM mom_db.meeting_table WHERE meeting_id =".$mom_table_t4_list->meeting_id."; "));

  			foreach($meeting_lists as $meeting_list)
  			{
  				$organizer_id = $meeting_list->meeting_organizer_id;
  				$meeting_title = $meeting_list->meeting_title;
  				$meeting_datetime = $meeting_list->meeting_datetime;
  			}

  			$user_table_t4_lists = \DB::select(\DB::raw("SELECT email FROM login_plugin_db.login_table  WHERE user_id ='".$organizer_id."'; "));

  			foreach($user_table_t4_lists  as $user_table_t4_list)
  			{
  				$from = $user_table_t4_list->email;
  			}
  			
  			//$from = "showmen.barua@summitcommunications.net";
  			
  			$temp_responsible_arr = explode(',', $mom_table_t4_list->responsible);
  			for($i=0;$i<count($temp_responsible_arr);$i++)
  			{
  				// $phpMailer   = new phpMailer();
	    	// 	$phpMailer->phpMailer();
  				// $phpMailer->set_from($from);
  				$to_arr_temp = explode('|', $temp_responsible_arr[$i]);
					if(count($to_arr_temp)>1){
						$toAddress = $to_arr_temp[0];
					}	
					else{
						$toAddress = $temp_responsible_arr[$i];
					}
  				$toArr[$i]= $toAddress; 
  				// $phpMailer->add_to($toArr[$i]);//$phpMailer->add_to($toArr[$i]."@summitcommunications.net");
  				$sub 	  = "Passed MoM : ".$mom_table_t4_list->mom_title;
  				// $phpMailer->set_subject($sub);
			    $messages  = '<html><body>';
			    $messages .= '<br>Dear Concern,<br>';
			    $messages .= '<p>Passed MOM of Meeting titled : '.$meeting_title.' , Meeting time : '.$meeting_datetime.'</p>';
			    $messages .= '<table  style="border:1px solid black;">';
			    $messages .= '<tr style="border:1px solid black;">';
				$messages .= '<td style="border:1px solid black;">Action Point Title :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->mom_title.'</td>';
				$messages .= '</tr>';
				$messages .= '<tr>';
				$messages .= '<td style="border:1px solid black;">Action Point Start Time :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->start_time.'</td>';
				$messages .= '</tr>';
				$messages .= '<tr>';
				$messages .= '<td style="border:1px solid black;">Action Point End Time :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->end_time.'</td>';
				$messages .= '</tr>';
				$messages .= '<tr>';
				$messages .= '<td style="border:1px solid black;">Comment :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->comment.'</td>';
				$messages .= '</tr>';
				$messages .= '</table><br>';
				$messages .= "<p>Thanks</p>";
				$messages .= "</body></html>";

				$data = array( 'email' => $toArr[$i] , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );
		
				// Mail::send(array(), array(), function ($message) use ($data) {
				// 	  $message->from($data['from'], 'MOM');
				// 	  $message->to($data['email'], '')
				// 	    ->subject($data['sub'])
				// 	    ->setBody($data['msg'], 'text/html');
				// });



				// echo 'responsible person info';
				// print_r($data);
			 //    $phpMailer->set_html($message);
				// $phpMailer->set_smtp_host("webmail.summitcommunications.net");

			    //$phpMailer->send();	
			    //echo $messages;	

		  	}
		  	// print_r($toArr);
		  	for($i=0;$i<count($temp_responsible_arr);$i++)
  			{
  				// $phpMailer   = new phpMailer();
	    	// 	$phpMailer->phpMailer();
  				// $phpMailer->set_from($from);
  				$toArr[$i]= $temp_responsible_arr[$i];

  				$email_to =  $toArr[$i];//."@summitcommunications.net";
  				$qeurySupervisorEmail = "select email from login_plugin_db.login_table where user_name = (select supervisor_name from hr_tool_db.employee_table where email='".$email_to."')";
  				$user_table_lists = \DB::select(\DB::raw($qeurySupervisorEmail));
  				foreach($user_table_lists as $user_table_list)
  				{
  					$supervisor_id = $user_table_list->email; 
  				}
  				//print_r($qeurySupervisorEmail);
  				// $phpMailer->add_to($supervisor_id);
  				$sub 	  = "Passed MOM : ".$mom_table_t4_list->mom_title;
  				// $phpMailer->set_subject($sub);
			    $messages  = '<html><body style="padding:10px;">';
			    $messages .= '<br>Dear Concern,<br>';
			    $messages .= '<p>Passed MOM of Meeting titled : '.$meeting_title.' , Meeting time : '.$meeting_datetime.'</p>';
			    $messages .= '<table  style="border:1px solid black;">';
			    $messages .= '<tr style="border:1px solid black;">';
				$messages .= '<td style="border:1px solid black;">Action Point Title :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->mom_title.'</td>';
				$messages .= '</tr>';
				$messages .= '<tr>';
				$messages .= '<td style="border:1px solid black;">Action Point Start Time :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->start_time.'</td>';
				$messages .= '</tr>';
				$messages .= '<tr>';
				$messages .= '<td style="border:1px solid black;">Action Point End Time :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->end_time.'</td>';
				$messages .= '</tr>';
				$messages .= '<tr>';
				$messages .= '<td style="border:1px solid black;">Comment :</td><td style="border:1px solid black;padding:10px;">'.$mom_table_t4_list->comment.'</td>';
				$messages .= '</tr>';
				$messages .= '</table>';
				$messages .= "<p>Person failed this mom : ".$toArr[$i]."</p>";
				$messages .= "<br><p>Thanks</p>";
				$messages .= "</body></html>";

				$data = array( 'email' => $supervisor_id , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );

				// echo 'supervisor person info';
				//print_r($data);
		
				// Mail::send(array(), array(), function ($message) use ($data) {
				// 	  $message->from($data['from'], 'MOM');
				// 	  $message->to($data['email'], '')
				// 	    ->subject($data['sub'])
				// 	    ->setBody($data['msg'], 'text/html');
				// });

				//echo $messages;	


			 //    $phpMailer->set_html($message);
				// $phpMailer->set_smtp_host("webmail.summitcommunications.net");
				
			 //    $phpMailer->send();	

		  	}		
  		} 			
  		
  	}
  	public function login_reason()
  	{
  		return view('mom.reason_view');
  	}
  	public function reason_mail()
  	{

  		$from = $_SESSION['email'];
  		$to = 'showmen.barua@summitcommunications.net';
  		$reason = Request::get('reason');
  		$ip = Request::get('ip_address');
  		
  		$sub 	  = "Super Admin Logged in";
  		
		$messages  = "Super Admin logged in from IP:".$ip."<br> Reason is:".$reason;

		$data = array( 'email' => $to, 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'sub' => $sub );
		
		Mail::send(array(), array(), function ($message) use ($data) {
			 $message->from($data['from'], 'MOM');
			$message->to($data['email'], '')
			->subject($data['sub'])
			->setBody($data['msg'], 'text/html');
		});
		// $phpMailer->set_subject($sub);
		// $phpMailer   = new phpMailer();
	    //  $phpMailer->phpMailer();
  		// $phpMailer->set_from($from);
  		// //$toArr[$i]= $temp_responsible_arr[$i]; 
  		// $phpMailer->add_to($to);
  		// $phpMailer->set_html($message);
		// $phpMailer->set_smtp_host("webmail.summitcommunications.net");
		//$ip = Request::getClientIp();
		//echo $ip;
		// $phpMailer->send();
		return redirect('landing');	  		
  	}
  	public function user_list_api(){
  		$userLists = \DB::select(\DB::raw("SELECT email,designation FROM login_plugin_db.login_table WHERE email !='' AND email !='N/A'"));
  		echo json_encode(array("records"=>$userLists));
  		//return $userLists;
  	}
  	public function responsible_view(){
  		$responsibleID = '';
  		return view('mom.responsible',compact('responsibleID'));
  	}

	public function get_ip_address() {
	    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
	    foreach ($ip_keys as $key) {
	        if (array_key_exists($key, $_SERVER) === true) {
	            foreach (explode(',', $_SERVER[$key]) as $ip) {
	                // trim for safety measures
	                $ip = trim($ip);
	                // attempt to validate IP
	                if (validate_ip($ip)) {
	                    return $ip;
	                }
	            }
	        }
	    }
	    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
	}
	/**
	 * Ensures an ip address is both a valid IP and does not fall within
	 * a private network range.
	 */
	public function validate_ip($ip)
	{
	    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
	        return false;
	    }
	    return true;
	}
	public function test_loading($val){
		// if($val != "static"){
		// 	sleep(10);
		// }
		// sleep(2);
		// $_SESSION['testCount'] = "2";
		// sleep(2);
		// $_SESSION['testCount'] = "3";
		// sleep(2);
		// $_SESSION['testCount'] = "4";
		// sleep(2);
		// $_SESSION['testCount'] = "5";
		// return "asdf";
		$returnArr =  array();
		$count = $val+1;
		sleep(1);

		$returnArr["count"] = $count;
		$returnArr["countTotal"] = "3";
		return $returnArr;
		//array_push($returnArr, "20");

     	//return response()->json($returnArr, 200);
	}
	
}
