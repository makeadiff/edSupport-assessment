<?php

  Route::filter('login_check',function()
  {
      session_start();
      // $_SESSION['user_id']=57184;//50423;//9006;//5828; //9006;//57184;//46174;//;//57184;
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

    $user_id = $_SESSION['user_id'];
    $cityId = DB::table('User')->select('city_id')->where('id',$user_id)->first();
    $_SESSION['city_id']=$cityId->city_id;

    $flag = false;

    //$_SESSION['group_id']=0;

    foreach($groups as $group) {
      if($group->id == 1 || $group->id == 3 || $group->id == 4 || $group->id == 358 || $group->id == 19 || $group->id == 355 || $group->id == 9 || $group->id == 8 || $group->id == 350) {
	  $flag = true;
      }
      if($group->id == 1 || $group->id == 3 || $group->id == 358 || $group->id == 350) $_SESSION['group_id']=1;
    }

    if($flag == false)
    return View::make('content.errorAccess')->with('message','Only Center Support & Ed Support Fellows and Volunteers sare allowed to access the page');
  });


  Route::group(array('before'=>'login_check|cs_check'),function()
  {
    Route::get('/',['as'=>'home','uses'=>'HomeController@edHome']);
    //Route::get('/','HomeController@edHome');
    Route::get('/manage','EdControl@index');
    Route::post('/selectCity','HomeController@changeCity');
    Route::get('/manage/update','EdControl@update');
    Route::post('/manage/fetchYear','EdControl@fetchYear');
    Route::post('/manage/fetchLevel','EdControl@fetchLevel');
    Route::post('/manage/assessment','EditController@getListOfStudents');
    Route::get('/manage/assessment','EditController@index');
    Route::post('/manage/assessment/update','EditController@updateData');
    Route::post('/manage/assessment/fetchTemplate/{template_id}','GradeController@fetchTemplate');
    Route::get('/manage/assessment/update','EditController@index');
    Route::get('/manage/report','ReportController@index');
    Route::get('/manage/grading','GradeController@index');
    Route::get('/manage/grading/create','GradeController@createTemplate');
    Route::post('/manage/grading/createTemplate','GradeController@create');
    Route::post('/manage/grading/editTemplate','GradeController@edit');
    Route::get('/manage/grading/modify','GradeController@showList');
    Route::get('/manage/grading/view/{template_id}','GradeController@viewTemplate');
    Route::get('/manage/grading/modify/{template_id}','GradeController@viewTemplate');
    Route::get('/manage/grading/modify/delete/{template_id}','GradeController@deleteTemplate');
    Route::post('/manage/grading/suggestions','GradeController@findSimilarTemplates');
    Route::get('/manage/report/class-progress','ReportController@classProgress');
    Route::post('/manage/report/fetchListOfCentres', 'ReportController@cityList');
    Route::post('/manage/report/fetchYear', 'ReportController@fetchYear');
    Route::post('/manage/report/class-progress/check-report','ReportController@generateReport');
    Route::get('/manage/report/generatecsv','ReportController@generateRawDump');
    Route::get('/manage/report/downloadcsv','ReportController@downloadCSV');
    Route::get('/manage/report/annual-impact','ReportController@generateAnnualImpact');

  });

Route::get('/manage/report/getcsv/{year}','ReportController@getCSV');
Route::get('/manage/update/inputdata','EditController@updateInputData');
Route::get('/importcsv',"ImportController@selectFile");
Route::post('/importcsv',"ImportController@importfromcsv");
