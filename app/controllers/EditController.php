<?php

class EditController extends BaseController{
  
  public function getListOfStudents(){
    $centerId = Input::get('centerId');
    $year = Input::get('year');
    $levelId = Input::get('levelId');
    $centerName = DB::table('Center')->select('name')->where('id',$centerId)->first();
    $levelName = DB::table('Level')->select('name')->where('id',$levelId)->first();
    
    $classList = DB::table('Student')->join('StudentClass','StudentClass.student_id','=','Student.id')->join('Class','Class.id','=','StudentClass.class_id')->join('Level','Level.id','=','Class.level_id')->select('Student.name','Class.level_id')->distinct()->where('level_id',$levelId)->get();
    
    return View::make('updateScores.report',['centerName'=>$centerName,'year'=>$year,'levelName'=>$levelName,'classList'=>$classList]);
//     ->where('Level.id',$levelId)
//     ->join('StudentClass','StudentClass.student_id','=','Student.id')
  }
 
  public function index(){
    return View::make('content.errorAccess');
  }
  
  public function updateData(){
    $validator = Validator::make(
      
    );
  }
}
  