<?php

  class EditController extends BaseController{
    
    public function getListOfStudents(){
      $centerId = Input::get('centerId');
      $year = Input::get('year');
      $exam_id = DB::select(DB::raw("select id,exam_type_id from Exam where EXTRACT(year from Exam_on)='$year' and status='1' limit 1"));
      $exam_id =  $exam_id[0]->id;
      $levelId = Input::get('levelId');
      $centerName = DB::table('Center')->select('name')->where('id',$centerId)->first();
      $levelName = DB::table('Level')->select('name')->where('id',$levelId)->first();
      
//       $classList = DB::table('Student')->join('StudentClass','StudentClass.student_id','=','Student.id')->join('Class','Class.id','=','StudentClass.class_id')->join('Level','Level.id','=','Class.level_id')->select('Student.name','Student.id','Class.level_id')->distinct()->where('level_id',$levelId)->get();
//       
      $classList = DB::table('Student')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','StudentLevel.level_id')->distinct()->where('level_id',$levelId)->get();
      
//       $marks = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentClass','StudentClass.student_id','=','Student.id')->join('Class','Class.id','=','StudentClass.class_id')->join('Level','Level.id','=','Class.level_id')->select('Student.name','Student.id','Class.level_id','Mark.marks','Mark.subject_id','Mark.total')->distinct()->where('level_id',$levelId)->where('Mark.exam_id',$exam_id)->get();

      $marks = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','StudentLevel.level_id','Mark.marks','Mark.subject_id','Mark.total')->distinct()->where('level_id',$levelId)->where('Mark.exam_id',$exam_id)->get();
      
//       return $marks; /* Marks is the Array with student marks against their names and Subject Ids. */
      
      if(empty($classList)){
	return View::make('updateScores.nodata')->with('message','No Data is avaiable for the selected Center and Level.');
      }
      
      if(empty($marks)){
	$flag = 0;
	return View::make('updateScores.report',['centerName'=>$centerName,'year'=>$year,'levelName'=>$levelName,'classList'=>$classList,'flag'=>$flag]);
      }
      else{
	$flag = 1;
	return View::make('updateScores.report',['centerName'=>$centerName,'year'=>$year,'levelName'=>$levelName,'classList'=>$marks,'flag'=>$flag]);
      }
      
  // // // //  $classList is the list of students
     
    }
  
    public function index(){
      return View::make('content.errorAccess')->with('message','This page cannot be accessed directly');
    }
    
    public function updateData(){
      $total = Input::get('totalMarks');
      $year = Input::get('year');
  //     return $year;
  //     $query = '';
      $exam_id = DB::select(DB::raw("select id,exam_type_id from Exam where EXTRACT(year from Exam_on)='$year' and status='1' limit 1"));
      $exam_id =  $exam_id[0]->id;
  //     return $exam_id;
      $size = sizeof(Input::all());
      $j = 0;
      for ($i=2;$i<($size-1);$i+= 7){
	$e = 'engScore'.$j;
	$m = 'mathScore'.$j;
	$s = 'sciScore'.$j;
	$te = 'totalEng'.$j;
	$tm = 'totalMath'.$j;
	$ts = 'totalSci'.$j;
	$student_id = 'studentId'.$j;
	$studentId = Input::get($student_id);
	$marksEng = Input::get($e);
	$marksMath = Input::get($m);
	$marksSci = Input::get($s);
	$totalMath = Input::get($tm);
	$totalEng = Input::get($te);
	$totalSci = Input::get($ts);
	
	if(empty($marksEng)) $marksEng = -1;
	if(empty($marksMath)) $marksMath = -1;
	if(empty($marksSci)) $marksSci = -1;
	
	
	$value1 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',8)->where('exam_id',$exam_id)->get();
	$value2 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',9)->where('exam_id',$exam_id)->get();
	$value3 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',10)->where('exam_id',$exam_id)->get();
    
  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones

	if(empty($value1)){
	    DB::table('Mark')->insert(
	      array('student_id'=>$studentId,'subject_id'=>8,'exam_id'=>$exam_id,'marks'=> $marksEng,'total'=>$totalEng)
	    );
	}
	else{
	  DB::table('Mark')->where('id',(int)($value1[0]->id))->limit(1)->update(array('marks'=> $marksEng,'total'=>$totalEng));
	}
	
  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones      

	if(empty($value2)){
	    DB::table('Mark')->insert(
	      array('student_id'=>$studentId,'subject_id'=>9,'exam_id'=>$exam_id,'marks'=>$marksMath,'total'=>$totalMath)
	    );
	}
	else{
	  DB::table('Mark')->where('id',(int)($value2[0]->id))->update(array('marks'=>$marksMath,'total'=>$totalMath)
	  );
	}
	
  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones      
  
	if(empty($value3)){
	    DB::table('Mark')->insert(
	      array('student_id'=>$studentId,'subject_id'=>10,'exam_id'=>$exam_id,'marks'=>$marksSci,'total'=>$totalSci)
	    );
	}
	else{
	  DB::table('Mark')->where('id',(int)($value3[0]->id))->update(array('marks'=>$marksSci,'total'=>$totalSci));
	}
	
	$j++;
      }
      
      return View::make('updateScores.nodata')->with('message','Data Entry/Updation Successful');
    }
    
  }