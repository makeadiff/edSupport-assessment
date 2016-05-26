<?php

  class GradeController extends BaseController{
    
    public function index(){
      return View::make('grade.index');
    }

    public function createTemplate(){
      $city_id = $_SESSION['city_id'];
	  //return $city_id;      
	  $states = DB::table('State')->select('name','id')->get();
	  //return $centers;
      return View::make('grade.create')->with('states',$states);
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

    public function showList(){
      $templates =  DB::table('Grade_Template')->select('id','name')->where('status','1')->get();
      if(empty($templates)){
        return View::make('grade.view')->with('message','No Data Available');
      }
      else{
        return View::make('grade.view')->with('templates',$templates);
      }
    }

    public function deleteTemplate($template_id){
      $template = DB::table('Grade_Template')->where('id',$template_id)->update(['status' => '0']);
      return Redirect::back();
    }

    //Controller Function to Create a new Template
    
    public function create(){
      $data = Input::all();
      $templateName = Input::get('gradeNameConcated');
      //return $templateName;
      $template_id = DB::table('Grade_Template')->select('id')->where('name',$templateName)->first();
      //return $grade_template_id->id;
      if(empty($template_id)){
        $grade_template_id = DB::table('Grade_Template')->insertGetId(
          array('id'=>'','name'=>$templateName,'status'=>'1')
        );
      }
      else{
        return View::make('grade.success')->with('message','A Grade Template with the same name exists')->with('id',$template_id);
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
      $template_id = DB::table('Grade_Template')->select('id')->where('name',$templateName)->first();
      return View::make('grade.success')->with('message','The Grade Template has been created successfully')->with('id',$template_id);
    }

    //Controller Function to Edit an Existing Template

    public function edit(){
      $data = Input::all();
      $templateName = Input::get('gradeNameConcated');
      //return $templateName;
      $template_id = DB::table('Grade_Template')->select('id')->where('name',$templateName)->first();
      //return $grade_template_id->id;
      if(empty($template_id)){
        return View::make('grade.success')->with('message','Grade Template does not exist')->with('id',$template_id);
      }
      else{

        $grade_id = DB::table('Grade_Template_Collection')->select('grade_id')->where('grade_template_id',$template_id->id)->get();
          
        foreach ($grade_id as $id) {
          DB::table('Grade_Template_Grade')->where('id',$id->grade_id)->delete();
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
              array('id'=>'','grade_id'=>$id,'grade_template_id'=>$template_id->id)
            ); 

          }
        }   
      }

      
     
      $template_id = DB::table('Grade_Template')->select('id')->where('name',$templateName)->first();
      return View::make('grade.success')->with('message','The Grade Template has been modified successfully')->with('id',$template_id);
    }

    public function viewTemplate($template_id){
      $url =  $_SERVER['REQUEST_URI'];
      //return $url;

      //Fetching Details for the Grade Template;
      $templateName = DB::table('Grade_Template')->select('name')->where('id',$template_id)->first();

      $template = DB::table('Grade_Template as A')->join('Grade_Template_Collection as B','A.id','=','B.grade_template_id')->join('Grade_Template_Grade as C','C.id','=','B.grade_id')->select('A.id','A.name','C.grade','C.id','C.from_mark','C.to_mark')->where('A.id',$template_id)->where('A.status',1)->get();
      //return $template;
      

      if(empty(!$template) && substr_compare($url,'view',16)>0){
        return View::make('grade.template')->with('template',$template)->with('templateName',$templateName);
      }
      else if(empty(!$template) && substr_compare($url,'modify',17)>0){
        return View::make('grade.modify')->with('template',$template)->with('templateName',$templateName);
      } 
    }

    public function fetchTemplate($template_id){
      if(Request::ajax()){
        $templateName = DB::table('Grade_Template')->select('name')->where('id',$template_id)->first();

        $grades = DB::table('Grade_Template as A')->join('Grade_Template_Collection as B','A.id','=','B.grade_template_id')->join('Grade_Template_Grade as C','C.id','=','B.grade_id')->select('C.grade')->where('A.id',$template_id)->where('A.status',1)->get();

        $data = array('grade'=>$grades);
        return json_encode($data);
      }
    }

  }


