<?php

class HomeController extends BaseController {

	public function edHome(){
	  return View::make('content.index');
	}

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function changeCity(){
	  	$city_id = Input::get('select_city');
	  	
	  	$_SESSION['city_id']=$city_id;
	  	//return $_SESSION['city_id'];
	  	return Redirect::to('/manage');
  	}
}
