<?php

  Route::filter('login_check',function()
  {
      session_start();
      //$_SESSION['user_id']=67916;
      if(empty($_SESSION['user_id'])){

	  if(App::environment('local'))
	      return Redirect::to('http://localhost/makeadiff.in/home/makeadiff/public_html/madapp/index.php/auth/login/' . base64_encode(Request::url()));
	  else
	      return Redirect::to('http://makeadiff.in/madapp/index.php/auth/login/' . base64_encode(Request::url()));

      }
  });
  
  Route::filter('cs_check',function(){
    
    $user_id = $_SESSION['user_id'];
    $user = DB::table('User')->find($user_id);
    $groups = DB::table('UserGroup')->join('Group','Group.id','=','UserGroup.group_id')->select('Group.name')->where('user_id',$user_id)->get(); 
    
    $flag = false;
  
    $_SESSION['groups']=$groups;
    
    foreach($groups as $group) {
      if($group->name == 'CS Intern' || $group->name == 'Center Support Fellow' || $group->name == 'City Team Lead' || $group->name == 'All Access' || $group->name == 'Leadership Team' || $group->name == 'Ed Support Fellow' || $group->name == 'Teacher' || $group->name == 'Mentor') {
	  $flag = true;
      }
    }

    if($flag == false)
	return View::make('content.errorAccess')->with('message','Only Center Support Fellows and Interns are allowed to access the page');
  });


  Route::group(array('before'=>'login_check|cs_check'),function()
  {
    Route::get('/','HomeController@edHome');
    Route::get('/manage','EdControl@index');
    Route::get('/manage/update','EdControl@update');
    Route::post('/manage/fetchYear','EdControl@fetchYear');
    Route::post('/manage/fetchLevel','EdControl@fetchLevel');
    Route::post('/manage/assessment','EditController@getListOfStudents');
    Route::get('/manage/assessment','EditController@index');
    Route::post('/manage/assessment/update','EditController@updateData');
    Route::get('/manage/assessment/update','EditController@index');
    Route::get('/manage/report','ReportController@index');
    Route::get('/manage/report/class-progress','ReportController@classProgress');
    Route::post('/manage/report/fetchListOfCentres', 'ReportController@cityList');
    Route::post('/manage/report/fetchYear', 'ReportController@fetchYear');
    Route::post('/manage/report/class-progress/check-report','ReportController@generateReport');
    Route::get('/manage/report/generatecsv','ReportController@generateRawDump');
    Route::get('/manage/report/annual-impact','ReportController@generateAnnualImpact');
  });
    
  
  