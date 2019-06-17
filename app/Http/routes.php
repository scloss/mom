<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MomController@landing_view');
//Route::get('/', 'MomController@index');

Route::get('doentry', 'MomController@do_entry');
Route::get('landing', 'MomController@landing_view');
Route::get('searchProcess', 'MomController@search_post');
Route::get('searchProcessAll', 'MomController@search_post_all');
Route::get('search', 'MomController@search_view');
Route::post('entry', 'MomController@entry');
Route::get('editView', 'MomController@edit_view');
Route::post('editProcess', 'MomController@edit_process');
Route::get('editFollowUpProcess', 'MomController@edit_followup_process');
Route::get('followUp', 'MomController@follow_up_view');
Route::get('followUpAP', 'MomController@follow_up_action_point_view');
Route::get('view', 'MomController@mom_view');
Route::get('quickView', 'MomController@quick_mom_view');
Route::get('MailView', 'MomController@mail_view');
Route::get('reminderMails', 'MomController@sendReminderMails');
Route::get('endTimeMail', 'MomController@afterEndTimeMail');
Route::get('reasonMail', 'MomController@reason_mail');
Route::get('loginReason', 'MomController@login_reason');
Route::get('dashboard', 'MomController@dashboard');
Route::get('dashboardAll', 'MomController@dashboard_dept_wise');
Route::get('upgradedb', 'HomeController@upgradeLoginPlugin');
Route::get('upgradedbezone', 'HomeController@upgradeLoginPluginFromEzone');


Route::get('userApi', 'MomController@user_list_api');
Route::get('responsiblePage','MomController@responsible_view');
Route::get('testLoading/{val}','MomController@test_loading');
Route::get('mailSendingView','MomController@mail_sending_view');
Route::get('createMail/{countTime}/{val}','MomController@createMail');
Route::get('runtimeUpdate','HomeController@runtime_update');
Route::get('warning','MomController@warning_view');
Route::post('modalMailSend','MomController@modal_sending_process');
Route::post('changeDept','MomController@change_dept');

//Route::get('home', 'HomeController@index');

//Route::get('/', 'WelcomeController@index');
Route::get('welcome', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
//Route::post('goHome', 'HomeController@goIndex');
Route::get('test','HomeController@testAuto');
Route::get('testSearch','HomeController@testSearchAuto');
Route::get('testSearchEmail','HomeController@testSearchEmailAuto');
Route::get('testSearchDeptEmailAuto','HomeController@testSearchDeptEmailAuto');
Route::get('testMail','HomeController@mailTest');
Route::get('printTest','HomeController@printTest');
Route::get('logout','HomeController@logout');
Route::get('contact','HomeController@contact_view');
Route::post('contactProcess','HomeController@contact_process');
Route::get('faq','HomeController@faq_view');
Route::post('uploads','HomeController@file_upload');
Route::get('downloadZip','HomeController@zip_download');
Route::get('fileDownload','HomeController@downloadFile');
Route::get('pdfDownload','MomController@pdf_download');
Route::get('guestMOM','MomController@guest_mom_view');
Route::get('t4Mail','MomController@t4Mail');

Route::get('test','HomeController@testQuery');
// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);
