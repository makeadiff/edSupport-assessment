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
      
      $classList = DB::table('Student')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','StudentLevel.level_id')->distinct()->where('level_id',	
      $levelId)->get();
      
      $marks = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','StudentLevel.level_id','Mark.marks','Mark.subject_id','Mark.total')->distinct()->where('level_id',$levelId)->where('Mark.exam_id',$exam_id)->get();
      
  
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
	$statusEng = 'updated';
	$statusMath = 'updated';
	$statusSci = 'updated';
	
	if(empty($marksEng)){
	  $marksEng = -1;
	  $statusEng = 'not updated';
	}
	else if($marksEng == "AB" || $marksEng ==  "ab"){
	  $marksEng = -2;
	  $statusEng = 'absent';
	}
	else if($marksEng == "NA" || $marksEng == "na"){
	  $marksEng = -3;
	  $statusEng = 'not available';
	}
	else if($marksEng == "OT" || $marksEng == "ot"){
	  $marksEng = -4;
	  $statusEng = 'others';
	}
	 
	if(empty($marksMath)){
	  $marksMath = -1;
	  $statusMath = 'not updated';
	}
	else if($marksMath == "AB" || $marksMath ==  "ab"){
	  $marksMath = -2;
	  $statusMath = 'absent';
	}
	else if($marksMath == "NA" || $marksMath == "na"){
	  $marksMath = -3;
	  $statusMath = 'not available';
	}
	else if($marksMath == "OT" || $marksMath == "ot"){
	  $marksMath = -4;
	  $statusMath = 'others';
	}
	
	if(empty($marksSci)){
	  $marksSci = -1;
	  $statusSci = 'not updated';
	}
	else if($marksSci == "AB" || $marksSci ==  "ab"){
	  $marksSci = -2;
	  $statusSci = 'absent';
	}
	else if($marksSci == "NA" || $marksSci == "na"){
	  $marksSci = -3;
	  $statusSci = 'not available';
	}
	else if($marksSci == "OT" || $marksSci == "ot"){
	  $marksSci = -4;
	  $statusSci = 'others';
	}
	
	$value1 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',8)->where('exam_id',$exam_id)->get();
	$value2 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',9)->where('exam_id',$exam_id)->get();
	$value3 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',10)->where('exam_id',$exam_id)->get();
    
  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones

	if(empty($value1)){
	    DB::table('Mark')->insert(
	      array('student_id'=>$studentId,'subject_id'=>8,'exam_id'=>$exam_id,'marks'=> $marksEng,'total'=>$totalEng,'status'=>$statusEng)
	    );
	}
	else{
	  DB::table('Mark')->where('id',(int)($value1[0]->id))->limit(1)->update(array('marks'=> $marksEng,'total'=>$totalEng,'status'=>$statusEng));
	}
	
  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones      

	if(empty($value2)){
	    DB::table('Mark')->insert(
	      array('student_id'=>$studentId,'subject_id'=>9,'exam_id'=>$exam_id,'marks'=>$marksMath,'total'=>$totalMath,'status'=>$statusMath)
	    );
	}
	else{
	  DB::table('Mark')->where('id',(int)($value2[0]->id))->update(array('marks'=>$marksMath,'total'=>$totalMath,'status'=>$statusMath)
	  );
	}
	
  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones      
  
	if(empty($value3)){
	    DB::table('Mark')->insert(
	      array('student_id'=>$studentId,'subject_id'=>10,'exam_id'=>$exam_id,'marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci)
	    );
	}
	else{
	  DB::table('Mark')->where('id',(int)($value3[0]->id))->update(array('marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci));
	}
	
	$j++;
      }
      
      return View::make('updateScores.sucess')->with('message','Data Entry/Updation Successful');
    }
    
  }