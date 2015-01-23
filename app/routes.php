<?php

/*Route::filter('login_check',function()
{
    session_start();

    if(empty($_SESSION['user_id'])){

        if(App::environment('local'))
            return Redirect::to('http://localhost/makeadiff.in/home/makeadiff/public_html/madapp/index.php/auth/login/' . base64_encode(Request::url()));
        else
            return Redirect::to('http://makeadiff.in/madapp/index.php/auth/login/' . base64_encode(Request::url()));

    }


});

Route::filter('edSupport_check',function(){

    if(!HomeController::checkEdSupport())
        return Redirect::to('error')->with('message','Only Center Support Fellows and Center Support Interns can access Ed Support Assessment App');

});

Route::group(array('before'=>'login_check|edSupport_check'),function()
{
    Route::get('/','HomeController@showHome');
    Route::get('/success','CommonController@showSuccess');



});*/
  
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
  
  