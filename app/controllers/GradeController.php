<?php

  class GradeController extends BaseController{
    
    public function index(){
      return View::make('grade.index');
    }

    public function createTemplate(){
      $city_id = $_SESSION['city_id'];
	  //return $city_id;      
	  $centers = DB::table('Center')->select('name','id')->where('city_id',$city_id)->where('status','1')->get();
	  //return $centers;
      return View::make('grade.create')->with('centers',$centers);
    }

    public function findSimilarTemplates(){
      if(Request::ajax()){
        $input = Input::get('centerName');
        $input = '%'.$input.'%';
        if(!empty($input)){
          $value = DB::table('Grade_Template')->select('id','name')->where('name','like',$input)->get();
          return json_encode($value);
        }
      } 
    }

    public function create(){
      $data = Input::all();
      $templateName = Input::get('gradeNameConcated');
      //return $templateName;
      $grade_template_id = DB::table('Grade_Template')->select('id')->where('name',$templateName)->first();
      //return $grade_template_id->id;
      if(empty($grade_template_id)){
        $grade_template_id = DB::table('Grade_Template')->insertGetId(
          array('id'=>'','name'=>$templateName,'status'=>'1')
        );
      }
      else{
        //return 'A template with this name already exist';
      }

      
      $count = Input::get('count');

      if($count>0){
        for ($i=0;$i<$count;$i++){
          $lower = Input::get('lower'.$i);
          $upper = Input::get('upper'.$i);
          $grade = Input::get('grade'.$i);

          $id = DB::table('Grade_Template_Grade')->insertGetId(
            array('id'=>'','grade'=>$grade,'from_mark'=>$lower,'to_mark'=>$upper)
          );
          //return $grade_template_id;
          $id_collection = DB::table('Grade_Template_Collection')->insertGetId(
            array('id'=>'','grade_id'=>$id,'grade_template_id'=>$grade_template_id)
          ); 

        }
      }
    }
  }


