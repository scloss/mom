<?php namespace App\Http\Controllers;

?>

<?php
// Start the session
session_start();
?>
<?php

use Illuminate\Support\Facades\Request;


use App\Http\Controllers\Controller;
use Mail;
// use App\MailHelpers\phpMailer;
use App\MailHelpers\PHPMailer;
use App\MailHelpers\PHPMailerAutoload;
use \Input as Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;
use ZipArchive;
use Zipper;
use Illuminate\Support\Facades\Redirect;
use Response;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	//clear session variables and redirect to login page
	public function logout()//clear session variables and 
	{

		$_SESSION["USERID"] = '';
		$_SESSION["USERTYPE"] = '';
		$_SESSION["USERNAME"] = '';
		$_SESSION["LOGINID"] = '';
		$_SESSION["EMAIL"] = '';
		header('Location:../../login_plugin/login.php');
            exit();
		return redirect('landing');	
	}
	//check the posted login information and if everything checks out then redirect to home index method. so that we can come back
	//to home page without posting any information
	public function goIndex()
	{
		$userName = Request::get('userName');
		$userPassword = Request::get('password');
		$checUserkLists = \DB::select(\DB::raw("select * from user_table where login_id='".$userName."' and user_password='".$userPassword."'"));

		 if(!$checUserkLists)
		 {
		 	$_SESSION["LOGIN_FAILED"] = '*Invalid User Name or Password';	
		 	return view('welcome');
		 }
		 else
		 {
			
			foreach($checUserkLists as $row)
			{
				$userType = $row->user_type;
				$loginId = $row->login_id;
				$userName = $row->user_name;
				$userID = $row->user_id;
				$emailID = $row->email;	
			}
			$_SESSION["USERID"] = $userID;
			$_SESSION["USERTYPE"] = $userType;
			$_SESSION["USERNAME"] = $userName;
			$_SESSION["LOGINID"] = $loginId;
			$_SESSION["LOGIN_FAILED"] = ' ';
			$_SESSION["EMAIL"] = $emailID;

			return redirect('home');
		}

	}
	//redirect to different pages depending on the type
	public function index()
	{	
		if(isset($_SESSION["LOGINID"] ))
		{
			if($_SESSION["USERTYPE"] == 'admin')
			{
				return redirect('landing');
				//return view('mom.momLanding');
			}
			if($_SESSION["USERTYPE"] == 'super_admin')
			{
				return redirect('loginReason');
			}
			else
			{
				return redirect('landing');
			}
		}
		else
		{
			return view('welcome');
		}
			
		
		
	}
	public function testAuto()
	{
		return view('mom.test');
	}
	public function testSearchAuto()
	{
		$dataArr = array();
		$str = '';
		$strData = '';
		//get search term
		$searchTermGet = Request::get('term');
		if (preg_match('/,/',$searchTermGet)) 
		{

		    $searchArray = explode(',', $searchTermGet);
			$searchTerm = $searchArray[count($searchArray)-1];
			array_pop($searchArray);
			$str = implode (",", $searchArray);		

		}
		else
		{
			$searchTerm = $searchTermGet;
		}

		//get matched data from skills table
		//$query = $db->query("SELECT * FROM user_table WHERE user_name LIKE '%".$searchTerm."%' ORDER BY user_id ASC");
		$dataList = \DB::select(\DB::raw("SELECT email,dept,designation FROM login_plugin_db.login_table WHERE user_id LIKE '%".$searchTerm."%' AND account_status !='blocked'"));
		

		foreach ($dataList as $row) 
		{
			$rowData = $row->email;
			if(empty($searchArray))
			{	
				$strData = $rowData."|".$row->dept."(".$row->designation.")";
			}
			else
			{
				$strData = $str.",".$rowData."|".$row->dept."(".$row->designation.")";
			}
			//$strDataArr = $rowData;
			array_push($dataArr, $strData);
		}
		
		// while ($row = $query->fetch_assoc())
		//  {
		//     $data[] = $row['user_name'];
		// }
		//$checUserkLists = \DB::select(\DB::raw("select * from user_table where login_id='".$userName."' and user_password='".$userPassword."'"));
		//return json data
		//return json_encode($data);

		return $dataArr;
	}
	public function testSearchEmailAuto()
	{
		$dataArr = array();
		$str = '';
		$strData = '';
		//get search term
		$searchTermGet = Request::get('term');
		// if (preg_match('/,/',$searchTermGet)) 
		// {

		//     $searchArray = explode(',', $searchTermGet);
		// 	$searchTerm = $searchArray[count($searchArray)-1];
		// 	array_pop($searchArray);
		// 	$str = implode (",", $searchArray);		

		// }
		// else
		// {
			$searchTerm = $searchTermGet;
		//}

		//get matched data from skills table
		//$query = $db->query("SELECT * FROM user_table WHERE user_name LIKE '%".$searchTerm."%' ORDER BY user_id ASC");
		$dataList = \DB::select(\DB::raw("SELECT email,dept,designation FROM login_plugin_db.login_table WHERE user_id LIKE '%".$searchTerm."%' AND account_status !='blocked' "));
		

		foreach ($dataList as $row) 
		{
			$rowData = $row->email;
			// if(empty($searchArray))
			// {	
				$strData = $rowData.",".$row->$dept;
			// }
			// else
			// {
			// 	$strData = $str.",".$rowData;
			// }
			//$strDataArr = $rowData;
			array_push($dataArr, $strData);
		}
		
		// while ($row = $query->fetch_assoc())
		//  {
		//     $data[] = $row['user_name'];
		// }
		//$checUserkLists = \DB::select(\DB::raw("select * from user_table where login_id='".$userName."' and user_password='".$userPassword."'"));
		//return json data
		//return json_encode($data);

		return $dataArr;
	}
	public function testSearchDeptEmailAuto()
	{
		$dataArr = array();
		$str = '';
		$strData = '';

		$searchTermGet = Request::get('term');

		$searchTerm = $searchTermGet;

		$dataList = \DB::select(\DB::raw("SELECT dept_name FROM hr_tool_db.department_table WHERE dept_name LIKE '%".$searchTerm."%'  "));
		

		foreach ($dataList as $row) 
		{
			$rowData = $row->dept_name;

			$strData = $rowData;

			array_push($dataArr, $strData);
		}

		return $dataArr;
	}
	public function mailTest()
	{
		$messages = '<html><body>';
		$messages .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
		$messages .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>Test</td></tr>";
		$messages .= "<tr><td><strong>Email:</strong> </td><td>Test</td></tr>";
		$messages .= "<tr><td><strong>Type of Change:</strong> </td><td>Test</td></tr>";
		$messages .= "<tr><td><strong>Urgency:</strong> </td><td>Test</td></tr>";
		$messages .= "<tr><td><strong>URL To Change (main):<a href='http://172.16.136.35/mom/public/'>Click here</a></strong> </td><td>Test</td></tr>";
		
		$messages .= "<tr><td><strong>NEW Content:</strong> </td><td>Test</td></tr>";
		$messages .= "</table>";
		$messages .= "</body></html>";
		// Mail::raw($message, function($message) {
		//     $message->from('summit77mail@gmail.com', 'Laravel');
		//     $message->to('summit77mail@gmail.com')->cc('showmen.barua@summitcommunications.net');
		// });
		$toAdd = 'summit77mail@gmail.com';
		$data = array( 'email' => $toAdd , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'from_name' => 'Vel' );
		
		Mail::send(array(), array(), function ($message) use ($data) {
		  $message->from($data['from'], 'MOM');
		  $message->to($data['email'], 'showmen')
		    ->subject('Welcome!')
		    ->setBody($data['msg'], 'text/html');
		});

		// Mail::send($message, ['key' => 'value'], function($message)
		// {
		// 	$message->from('summitmomtool@gmail.com', 'Biplob');
		//     $message->to('summit77mail@gmail.com', 'showmen')->subject('Welcome!');
		// });
		// return redirect()->back();
		// Mail::send([], [], function ($message) {
		// $message->from('summitmomtool@gmail.com', 'MOM');
		//   $message->to('summit77mail@gmail.com', 'showmen')
		//     ->subject('Welcome!')
		//     // here comes what you want
		//     ->setBody($message);
		// });

		// $phpMailer   = new phpmailer();
	 //    // if(count($from))
	 //    //   foreach($from as $email => $fullname)
	 //        $phpMailer->From ='raihan.parvez@summitcommunications.net';
	 //  	echo $phpMailer->From;
	 //  	$phpMailer->FromName ='asdf';
	 //    // if(count($to))
	 //    //   foreach($to as $email => $fullname)
	 //        $phpMailer->to='showmen.barua@summitcommunications.net';
	  
	 //    // if(count($cc))
	 //    //   foreach($cc as $email => $fullname)
	 //    //     $phpMailer->add_cc($cc);
	  
	 //    // // if(count($bcc))
	 //    // //   foreach($bcc as $email => $fullname)
	 //    //     $phpMailer->add_bcc($bcc);
	  
	 //    $phpMailer->Subject = 'test Mail ';
	 //    $phpMailer->Body = 'test Mail ';
	 //    //$phpMailer->set_html(nl2br('mail sent'));
	  
	 //    // if(count($attach))
	 //    //   foreach($attach as $attachment)      
	 //        //$phpMailer->add_attachment($attach, basename($attach),'');
	  
	 //    //$phpMailer->set_smtp_host("10.10.20.194");smtp.
	 //    $phpMailer->Host = "webmail.summitcommunications.net";


	 //    $phpMailer   = new phpMailer();
	 //    $phpMailer->phpMailer();
    
  //       $phpMailer->set_from('showmen77barua@gmail.com');
  
    
  //       $phpMailer->add_to('showmen.barua@summitcommunications.net');
  
 
  
	 //    $phpMailer->set_subject('zcron-2');
	 //    $message = '<html><body>';
		// $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
		// $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>Test</td></tr>";
		// $message .= "<tr><td><strong>Email:</strong> </td><td>Test</td></tr>";
		// $message .= "<tr><td><strong>Type of Change:</strong> </td><td>Test</td></tr>";
		// $message .= "<tr><td><strong>Urgency:</strong> </td><td>Test</td></tr>";
		// $message .= "<tr><td><strong>URL To Change (main):<a href='http://localhost:8080/mom/public/'>Click here</a></strong> </td><td>Test</td></tr>";
		
		// $message .= "<tr><td><strong>NEW Content:</strong> </td><td>Test</td></tr>";
		// $message .= "</table>";
		// $message .= "</body></html>";
	 //    $phpMailer->set_html($message);
	 
	  
	 //    //$phpMailer->set_smtp_host("10.10.20.194");smtp.
	 //    $phpMailer->set_smtp_host("smtp.gmail.com");
	  
	 //    if ($phpMailer->send())  
	 //      echo "<script>window.close();</script>";
	 //    else
	 //      echo "<script>window.close();</script>";

		// $mail = new PHPMailer();
		// $mail->IsSMTP(); // set mailer to use SMTP
		// $mail->SMTPDebug  = 2; 
		// $mail->From = "showmen.barua@summitcommunications.net";
		// $mail->FromName = "showmen";
		// $mail->Host = "smtp.gmail.com"; // specif smtp server
		// $mail->SMTPSecure= "ssl"; // Used instead of TLS when only POP mail is selected
		// $mail->Port = 465; // Used instead of 587 when only POP mail is selected
		// $mail->SMTPAuth = true;
		// $mail->Username = "summitmomtool"; // SMTP username
		// $mail->Password = "summit123"; // SMTP password
		// $mail->AddAddress("summit77mail@gmail.com", "showmen"); //replace myname and mypassword to yours
		// $mail->AddReplyTo("showmen.barua@summitcommunications.net", "showmen");
		// $mail->WordWrap = 50; // set word wrap
		// //$mail->AddAttachment("c:\\temp\\js-bak.sql"); // add attachments
		// //$mail->AddAttachment("c:/temp/11-10-00.zip");

		// $mail->IsHTML(true); // set email format to HTML
		// $mail->Subject = 'tests';
		// $mail->Body = 'tests';

		// if($mail->Send()) {echo "Send mail successfully";}
		// else {echo "Send mail fail";} 

		
  	}
  	
	public function contact_view()
	{
	  	return view('mom.mom_contact');
	}
	public function contact_process(){
		$msg = Request::get("message");
		$user_id = Request::get("user_id");
		 
		$messages = '<html><body>';
		$messages .= '<br>Dear Concern,<br>';
		$messages .= '<h3>'.$msg.'</h3>';
		$messages .= '<br>Thanks';
		$messages .= "</body></html>";


		$data = array( 'email' => 'oss@summitcommunications.net' , 'msg' => $messages , 'from' => 'summitmomtool@gmail.com', 'from_name' => $user_id, 'sub' =>$user_id );

			//return $toAddress;
		
			Mail::send(array(), array(), function ($message) use ($data) {
			  $message->from($data['from'], 'MOM');
			  $message->to($data['email'], '')
			    ->subject($data['sub'])
			    ->setBody($data['msg'], 'text/html');
			});

		return redirect('landing');		
	}
	public function faq_view()
	{
	  	return view('mom.mom_faq');
	} 
	public function file_upload()
	{
		//return 'asdf';
		// $path = 'images/folder';
		
		// if(!File::exists($path)) {
  //   		// path does not exist

  //   		$result = File::makeDirectory($path);

		// 	}
		if(Input::hasFile('userFile'))
	 	{
	 		//return 'asdf';
	 		$file = Input::file('userFile');
	 		$filename = $file->getClientOriginalName();
	 		$file->move('images',$filename);
	 	}

	}
	public function zip_download()
	{
		$meeting_id = Request::get('meeting_id');
		$pathCheck1 = '../MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		// /File::delete($pathCheck);
		File::delete($pathCheck1);
		$pathCheck = '../MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		$meeting_files = $pathCheck."/";
		if(!File::exists($pathCheck)) 
		{
			$path = '../MeetingFiles/'.$meeting_id.'/*';
			$files = glob($path);
			$makepath = '../MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
			Zipper::make($makepath)->add($files);
	    }
	    $url_path = 'fileDownload?meeting_id='.$meeting_id;
	    return redirect('fileDownload?meeting_id='.$meeting_id);
	    //return Redirect::route('fileDownload')->with('meeting_id', $meeting_id);
	    //return response()->download($pathCheck);
	  //   else
	  //   {

	  //   	$path = '../MeetingFiles/'.$meeting_id.'/*';
			// $files = glob($path);
			// $makepath = '../MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
			// Zipper::make($makepath)->add($files);
	  //   }
	    
	    //return 
	    //$fileName = $meeting_id.'.zip';
		

		
		// $zip = new ZipArchive();
		// $zip_name = time().".zip"; // Zip name
		// $zip->open($zip_name,  ZipArchive::CREATE);
		// foreach ($files as $file) {
		//   echo $path = "http://localhost:8080/mom/MeetingFiles/Outing/".$file;
		//   if(file_exists($path)){
		//   $zip->addFromString(basename($path),  file_get_contents($path));
		//   }
		//   else{
		//    echo"file does not exist";
		//   }
		// }
		// $zip->close();
	} 
	public function downloadFile()
	{
		$meeting_id = Request::get('meeting_id');
		$pathCheck = '../MeetingFiles/'.$meeting_id.'/'.$meeting_id.'.zip';
		//$pathCheck = '../MeetingFiles/5/asdf.zip';
		//return $pathcheck;
		ob_end_clean();
		return Response::download($pathCheck);


		//return $response;
	}
	public function upgradeLoginPlugin(){
		//return "test";
		// Commented out by Ahnaf
		// $login_db_select_query = "SELECT hr.email,hr.department,hr.phone,hr.designation,hr.name
		// 								FROM   hr_tool_db.employee_table hr
		// 									WHERE  NOT EXISTS (SELECT lg.email
  //                  													FROM   login_plugin_db.login_table lg
  //                  															WHERE  lg.email = hr.email)";

		//Added by Ahnaf
		//-------------------------------------------------------------------
		$login_db_select_query = "SELECT *
										FROM   hr_tool_db.employee_table hr
											WHERE  NOT EXISTS (SELECT lg.email
                   													FROM   login_plugin_db.login_table lg
                   															WHERE  lg.email = hr.email) and hr.status != 'Disabled'";

		$department_table_50_select_query = "SELECT * from hr_tool_db.department_table";
		$department_lists = \DB::connection('mysql2')->select(\DB::raw($department_table_50_select_query));

		//return $department_lists;
		//--------------------------------------------------------------------
		$login_db_lists = \DB::select(\DB::raw($login_db_select_query));

		//return $login_db_lists;
		//return count($login_db_lists);
		$insert_login_db_query ="INSERT INTO login_plugin_db.login_table(user_id,user_name,user_password,email,phone,designation,dept,access_type,permitted_tool_id,account_status) 
			VALUES ";

		//Added by ahnaf
		//---------------------------------------------------
		$insert_hr_db_50_query="INSERT INTO hr_tool_db.employee_table(hr_id,name,designation,joining_date,division,department,section,gender,email,phone,blood_group,marital_status,job_location,office_location,supervisor_name,date_of_birth,religion,emergency_contact_name,emergency_contact_phone,relation,home_district,present_address,permanent_address,leaving_date,image_path,status) 
			VALUES ";

		$insert_phoenix_access_query = "INSERT INTO phoenix_tt_db.access_table(user_id,dept_id,type,page_access) 
			VALUES ";

		//---------------------------------------------------
		$is_updated = true;
		if($login_db_lists != null){
			foreach($login_db_lists as $login_db_list){
				//------------------------------------
				$login_db_list->department = addslashes($login_db_list->department);
				$login_db_list->job_location = addslashes($login_db_list->job_location);
				$login_db_list->permanent_address = addslashes($login_db_list->permanent_address);
				$login_db_list->present_address = addslashes($login_db_list->present_address);
				$login_db_list->office_location = addslashes($login_db_list->office_location);
				$login_db_list->division = addslashes($login_db_list->division);


				$user_id_temp_arr = explode('@', $login_db_list->email);
				$user_id_temp = $user_id_temp_arr[0];
				if($user_id_temp != 'N/O'){
				$default_password = '$2y$10$vYZR9tr3g6dohYiZw/h6XOmKLF44VdenjOGFSP7et8OmPY1Ihr6Wy';
				$default_access = '5,8,10,12,13,14,15,17,18,19';
				$insert_login_db_query .= "('$user_id_temp','$login_db_list->name','$default_password','$login_db_list->email','$login_db_list->phone','$login_db_list->designation','$login_db_list->department','','$default_access','active'),";
				
				//Added by Ahnaf
				

				$insert_hr_db_50_query .= "('$login_db_list->hr_id','$login_db_list->name','$login_db_list->designation','$login_db_list->joining_date','$login_db_list->division','$login_db_list->department','$login_db_list->section','$login_db_list->gender','$login_db_list->email','$login_db_list->phone','$login_db_list->blood_group','$login_db_list->marital_status','$login_db_list->job_location','$login_db_list->office_location','$login_db_list->supervisor_name','$login_db_list->date_of_birth','$login_db_list->religion','$login_db_list->emergency_contact_name','$login_db_list->emergency_contact_phone','$login_db_list->relation','$login_db_list->home_district','$login_db_list->present_address','$login_db_list->permanent_address','$login_db_list->leaving_date','$login_db_list->image_path','$login_db_list->status'),";
				

				$dept_id = "";
				$type = "";
				$page_access = "";
				foreach($department_lists as $department_list){
					if($department_list->dept_name == $login_db_list->department){
						$dept_id = $department_list->dept_row_id;
					}
				}
				if($login_db_list->department == 'NOC'){
					$type = "A";
					$page_access = "all";
				}
				elseif ($login_db_list->department == 'Regional Implementation & Operations 1'
					||$login_db_list->department == 'Regional Implementation & Operations 2'
					||$login_db_list->department == 'Regional Implementation & Operations 3'
					||$login_db_list->department == 'Regional Implementation & Operations 4'
					||$login_db_list->department == 'Central Power'
					||$login_db_list->department == 'I&C- Implementation'
					||$login_db_list->department == 'OH- Implementation'
					||$login_db_list->department == 'UG- Implementation'
					||$login_db_list->department == 'Gateway Operations'
					||$login_db_list->department == 'COS') {
					# code...
					$type = "B";
					$page_access = "view,reporting";
				}
				else{
					$type = "C";
					$page_access = "view";
				}



				$insert_phoenix_access_query .= "('$user_id_temp','$dept_id','$type','$page_access'),"; 

				//------------------------------------

				$is_updated = false;
				}
			
			}


			$insert_login_db_query = trim($insert_login_db_query,',');
			
			//------------------------Added BY Ahnaf
			$insert_hr_db_50_query = trim($insert_hr_db_50_query,',');
			$insert_phoenix_access_query = trim($insert_phoenix_access_query,',');
			//------------------------------------------------------------------------

			if($is_updated == true){
				return "Database is Up to Date";
			}
			else{
				// echo $insert_hr_db_50_query."<br>";
				// echo $insert_phoenix_access_query."<br>";
				//return $login_db_lists;
				//return $insert_login_db_query;
				\DB::insert(\DB::raw($insert_login_db_query));

				//-------------------------Added by Ahnaf
				\DB::connection('mysql2')->insert(\DB::raw($insert_hr_db_50_query));
				\DB::connection('mysql3')->insert(\DB::raw($insert_phoenix_access_query));
				//-----------------------------------------------------------------------



				


				return 'Upgraded Successfully';
			}
		}

	}


	public function upgradeLoginPluginFromEzone(){
		//echo "function reached";
		
		//Added by Ahnaf
		//-------------------------------------------------------------------
		$login_db_select_query = "SELECT *
										FROM   hr_tool_ezone.employee_table hr
											WHERE  NOT EXISTS (SELECT lg.email
                   													FROM   login_plugin_db.login_table lg
                   															WHERE  lg.email = hr.email)";

		$department_table_50_select_query = "SELECT * from hr_tool_db.department_table";
		$department_lists = \DB::connection('mysql2')->select(\DB::raw($department_table_50_select_query));

		//--------------------------------------------------------------------
		$login_db_lists = \DB::select(\DB::raw($login_db_select_query));

		//print_r($login_db_lists);
		$insert_login_db_query ="INSERT INTO login_plugin_db.login_table(user_id,user_name,user_password,email,phone,designation,dept,access_type,permitted_tool_id,account_status) 
			VALUES ";

		// //Added by ahnaf
		// //---------------------------------------------------
		$insert_hr_db_50_query="INSERT INTO hr_tool_db.employee_table(hr_id,name,designation,joining_date,division,department,section,gender,email,phone,blood_group,marital_status,job_location,office_location,supervisor_name,date_of_birth,religion,emergency_contact_name,emergency_contact_phone,relation,home_district,present_address,permanent_address,leaving_date,image_path,status) 
			VALUES ";

		$insert_phoenix_access_query = "INSERT INTO phoenix_tt_db.access_table(user_id,dept_id,type,page_access) 
			VALUES ";

		// //---------------------------------------------------
		$is_updated = true;
		if($login_db_lists != null){
			//echo "login db list exists";
			foreach($login_db_lists as $login_db_list){
				$user_id_temp_arr = explode('@', $login_db_list->email);
				$user_id_temp = $user_id_temp_arr[0];
				if($user_id_temp != 'N/O'){

				//------------------------------------
				$login_db_list->department = addslashes($login_db_list->department);
				$login_db_list->job_location = addslashes($login_db_list->job_location);
				$login_db_list->permanent_address = addslashes($login_db_list->permanent_address);
				$login_db_list->present_address = addslashes($login_db_list->present_address);
				$login_db_list->office_location = addslashes($login_db_list->office_location);
				$login_db_list->division = addslashes($login_db_list->division);

				$default_password = '$2y$10$vYZR9tr3g6dohYiZw/h6XOmKLF44VdenjOGFSP7et8OmPY1Ihr6Wy';
				$default_access = '5,8,10,12,13,14,15,17,18,19';
				$insert_login_db_query .= "('$user_id_temp','$login_db_list->name','$default_password','$login_db_list->email','$login_db_list->phone','$login_db_list->designation','$login_db_list->department','','$default_access','active'),";
				
				//Added by Ahnaf
				

				$insert_hr_db_50_query .= "('$login_db_list->hr_id','$login_db_list->name','$login_db_list->designation','$login_db_list->joining_date','$login_db_list->division','$login_db_list->department','$login_db_list->section','$login_db_list->gender','$login_db_list->email','$login_db_list->phone','$login_db_list->blood_group','$login_db_list->marital_status','$login_db_list->job_location','$login_db_list->office_location','$login_db_list->supervisor_name','$login_db_list->date_of_birth','$login_db_list->religion','$login_db_list->emergency_contact_name','$login_db_list->emergency_contact_phone','$login_db_list->relation','$login_db_list->home_district','$login_db_list->present_address','$login_db_list->permanent_address','$login_db_list->leaving_date','$login_db_list->image_path','$login_db_list->status'),";
				

				$dept_id = "";
				$type = "B";
				$page_access = "view,reporting";
				foreach($department_lists as $department_list){
					if($department_list->dept_name == $login_db_list->department){
						$dept_id = $department_list->dept_row_id;
					}
				}
				
				
				$insert_phoenix_access_query .= "('$user_id_temp','$dept_id','$type','$page_access'),"; 

				//------------------------------------

				$is_updated = false;
				
				}
			
			}


			$insert_login_db_query = trim($insert_login_db_query,',');
			
			//------------------------Added BY Ahnaf
			$insert_hr_db_50_query = trim($insert_hr_db_50_query,',');
			$insert_phoenix_access_query = trim($insert_phoenix_access_query,',');
			//------------------------------------------------------------------------

			if($is_updated == true){
				return "Database is Up to Date";
			}
			else{
				// echo $insert_hr_db_50_query."<br>";
				// echo $insert_phoenix_access_query."<br>";

				\DB::insert(\DB::raw($insert_login_db_query));

				//-------------------------Added by Ahnaf
				\DB::connection('mysql2')->insert(\DB::raw($insert_hr_db_50_query));
				\DB::connection('mysql3')->insert(\DB::raw($insert_phoenix_access_query));
				//-----------------------------------------------------------------------



				


				return 'Upgraded Successfully';
			}
		}
		return "Database is Up to Date";

		// echo "<br>";
		// echo "if not reched";

	}

	public function pdfDownload(){
		$meeting_id = 5;
		$mother_meeting_id = 5;
		// $html = view('mom.mom_view',compact('meeting_id','mother_meeting_id'))->render();

  //  		return PDF::load($html)->download();
	}
	public function runtime_update(){
		return view('mom.testLoading');
		

	}

	public function testQuery(){
		// $department_table_50_select_query = "SELECT * from hr_tool_db.department_table";
		// $department_lists = \DB::connection('mysql2')->select(\DB::raw($department_table_50_select_query));

		$login_db_select_query = "SELECT *
										FROM   hr_tool_db.employee_table hr
											WHERE  NOT EXISTS (SELECT lg.email
                   													FROM   login_plugin_db.login_table lg
                   															WHERE  lg.email = hr.email)";


		$login_db_lists = \DB::select(\DB::raw($login_db_select_query));


		foreach ($login_db_lists as $login_db_list) {
			print_r($login_db_list);
			echo "<p>";
		}

		

		//print_r($department_lists);
		return "test success";
	}
}