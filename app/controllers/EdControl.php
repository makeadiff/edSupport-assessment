<?php

  class EdControl extends BaseController{

	  public function update(){
		  $user_id = $_SESSION['user_id'];
		  //$cityId = DB::table('User')->select('city_id')->where('id',$user_id)->first();
		  $cityId = $_SESSION['city_id'];
		  $centerList = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.name','Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->get();
		  
		  $centerFirst = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->first();
		  $idFirst =  $centerFirst->id;
		  
// 		  $year = DB::table('Level')->select('year')->distinct()->where('center_id',$idFirst)->get();
// 		  $yearFirst = DB::table('Level')->select('year')->distinct()->where('center_id',$idFirst)->first();
		  
		  $year = date('Y');		  
		  $classList = DB::table('Level')->select('id','name','grade')->where('center_id',$idFirst)->where('year',$year)->orderby('grade','ASC')->get();
		  return View::make('updateScores.update',['centerList'=>$centerList,'classList'=>$classList]);
	  }
	  
	  public function index(){
	  	return View::make('content.manage');
	  }

	  public function store(){
		  
		  return View::make('content.report',['cityName'=>$cityName]);
	  }
	  
	  public function fetchYear(){
	      if(Request::ajax()){
		$centerId =  (int)Input::get('centerId');
// 		$yearFirst = DB::table('Level')->select('year')->distinct()->where('center_id',$centerId)->first();
		$year = date('Y');
		$classList = DB::table('Level')->select('id','name','grade')->where('center_id',$idFirst)->where('year',$year)->orderby('grade','ASC')->get();
		$data = array('class'=>$classList);
		return json_encode($data);
		}
	  }
	  
// 	  public function fetchLevel(){
// 	    if(Request::ajax()){
// 	      $centerId = (int)Input::get('centerId');
// 	      $year = (int)Input::get('year');
// 	      $levelList = DB::table('Level')->select('id','name')->distinct()->where('center_id',$centerId)->where('year',$year)->where('status','1')->get();
// 	      return json_encode($levelList);
// 	    }
// 	  }

  }



