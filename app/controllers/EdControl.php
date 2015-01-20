<?php

class EdControl extends BaseController{

	public function update(){
		$cityId=24;
		$centerList = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.name','Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->get();
		
		$centerFirst = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->first();
		$idFirst =  $centerFirst->id;
		
		$year = DB::table('Level')->select('year')->distinct()->where('center_id',$idFirst)->get();
		$yearFirst = DB::table('Level')->select('year')->distinct()->where('center_id',$idFirst)->first();
		
		$classList = DB::table('Level')->select('id','name','grade')->where('center_id',$idFirst)->where('year',$yearFirst->year)->get();
		return View::make('updateScores.update',['centerList'=>$centerList,'classList'=>$classList,'year'=>$year]);
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
	      $year = DB::table('Level')->select('year')->distinct()->where('center_id',$centerId)->where('status','1')->get();
	      $yearFirst = DB::table('Level')->select('year')->distinct()->where('center_id',$centerId)->first();
	      $classList = DB::table('Level')->select('id','name','grade')->where('center_id',$centerId)->where('year',$yearFirst->year)->get();
	      $data = array('year'=>$year,'class'=>$classList);
	      return json_encode($data);
	      }
 	}
 	
 	public function fetchLevel(){
	  if(Request::ajax()){
	    $centerId = (int)Input::get('centerId');
	    $year = (int)Input::get('year');
	    $levelList = DB::table('Level')->select('id','name')->distinct()->where('center_id',$centerId)->where('year',$year)->where('status','1')->get();
	    return json_encode($levelList);
	  }
 	}

}



