<?php

class HomeController extends BaseController {

	public function edHome(){
	  return View::make('content.index');
	}

	public function showWelcome()
	{
		return View::make('hello');
	}

}
