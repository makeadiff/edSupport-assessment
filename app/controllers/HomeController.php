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
	  	//return Redirect::to($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	  	//return $_SERVER['HTTP_REFERER'];
	  	return Redirect::to('/manage/update');
  	}

  	public function get_year() { /* Function get_year(): Source: madapp/system/helper/misc_helper.php Line 123 */
		$this_month = intval(date('m'));
		$months = array();
		$start_month = 5; // April
		$start_year = date('Y');
		if($this_month < $start_month) $start_year = date('Y')-1;
		return $start_year;
	}

}
