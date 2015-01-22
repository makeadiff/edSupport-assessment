<?php

  class ReportController extends BaseController{
    
    public function index(){
      $cityId=24;
      $centerList = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.name','Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->get();
	  
      $centerFirst = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->first();
      $idFirst =  $centerFirst->id;
	
      $year = 2014;		  
      $classList = DB::table('Level')->select('id','name','grade')->where('center_id',$idFirst)->where('year',$year)->get();
      return View::make('report.index',['centerList'=>$centerList,'classList'=>$classList]);
    }
   
   public function generateReport(){
    
   }
   
  }