<?php

class HomeController extends BaseController {

	public function edHome(){
	  return View::make('content.index');
	}

	/*public static function checkEdSupport(){
	  $user_id = $_SESSION['user_id'];
	  $user = Volunteer::find($user_id);
	  $groups = $user->group()->get();
	  $flag = false;

	  foreach($groups as $group) {
	      if($group->name == 'Propel Fellow' || $group->name == 'Propel Wingman' || $group->name == 'Propel Strat' || $group->name == 'Program Director, Propel') {
		  $flag = true;
	      }

	  }
	  if($flag == true)
	      return true;
	  else
	      return false;
	}*/
	
	public function showWelcome()
	{
		return View::make('hello');
	}

}
