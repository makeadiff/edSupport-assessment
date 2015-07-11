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
    $groups = DB::table('UserGroup')->join('Group','Group.id','=','UserGroup.group_id')->select('Group.name','Group.id')->where('user_id',$user_id)->get(); 
    
    $flag = false;
  
    //$_SESSION['groups']=$groups;
    
    foreach($groups as $group) {
      if($group->id == 1 || $group->id == 3 || $group->id == 4 || $group->id == 358 || $group->id == 19 || $group->id == 355 || $group->id == 9 || $group->id == 8) {
	  $flag = true;
      }
    }

    if($flag == false)
	return View::make('content.errorAccess')->with('message','Only Center Support Fellows and Interns are allowed to access the page');
  });


  Route::group(array('before'=>'login_check|cs_check'),function()
  {
    Route::get('/',['as'=>'home','uses'=>'HomeController@edHome']);
    //Route::get('/','HomeController@edHome');
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
    
  
  