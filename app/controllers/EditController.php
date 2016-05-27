<?php

class EditController extends BaseController{
    
    public function getListOfStudents(){
    	$centerId = Input::get('centerId');
      	$year = Input::get('year');
      	$exam_id = DB::select(DB::raw("select id,exam_type_id from Exam where EXTRACT(year from Exam_on)='$year' and status='1' limit 1"));
      	$exam_id =  $exam_id[0]->id;
      	$centerName = DB::table('Center')->select('id','name')->where('id',$centerId)->first();
      	$dataClass = DB::table('Student')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Center','Center.id','=','Student.center_id')->join('Level','Level.id','=','StudentLevel.level_id');
      	$dataSelect = $dataClass->select('Student.name','Student.id','StudentLevel.level_id','Level.grade')->where('Student.center_id','=',$centerId)->orderby('Level.grade','ASC')->orderby('Student.name','ASC')->where('Level.grade','>','0')->where('Level.year','=',$year);
      	$classList = $dataSelect->get();
      	$className = $dataClass->select('Level.grade')->where('Student.center_id','=',$centerId)->orderby('Level.grade','ASC')->where('Level.grade','>','0')->groupby('Level.grade')->get();

      	//return $classList;
	    //$className is fetching all the grades available in the selected Center.
      
      	$marks = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->join('Center','Center.id','=','Student.center_id')->select('Student.name','Student.id','StudentLevel.level_id','Mark.marks','Mark.subject_id','Mark.total','Level.grade')->distinct()->orderby('Level.grade','ASC')->orderby('Student.name','ASC')->orderby('Student.id','ASC')->orderby('Mark.subject_id','ASC')->where('Level.grade','>','0')->where('Level.year','=',$year)->where('Student.center_id','=',$centerId)->where('Mark.exam_id',$exam_id)->get();
      
      	$cityId = $_SESSION['city_id'];
	  	$centerList = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.name','Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->get();

		$grading_templates = DB::table('Grade_Template')->select('id','name')->where('status',1)->get(); 
	    		  

		$center_reason = DB::table('Mark_Reason')->where('center_id','=',$centerId)->first();


  	//Information 01: If the data set is empty, without marks, we fetch the list of students only. Else we fetch the data from the MARK table.

      if(empty($classList)){
		return View::make('updateScores.nodata')->with('message','No Data is avaiable for the selected Center and Level.');
 	  echo count($classArray);    
 	  }
      
      if(empty($marks)){
		$flag = 0;
		return View::make('updateScores.report',['centerName'=>$centerName,'year'=>$year,'classList'=>$classList,'flag'=>$flag,'className'=>$className,'centerList'=>$centerList,'grading_templates'=>$grading_templates,'center_reason'=>$center_reason]);
	  }
	  
	  else{
		$flag = 1;
		return View::make('updateScores.report',['centerName'=>$centerName,'year'=>$year,'classList'=>$marks,'flag'=>$flag,'className'=>$className,'centerList'=>$centerList,'grading_templates'=>$grading_templates,'center_reason'=>$center_reason]);
	  }
	     
    }
  
    public function index(){
      return View::make('content.errorAccess')->with('message','This page cannot be accessed directly');
    }
    
    public function updateData(){
   		if(Request::ajax()){
		  	$data = Input::all();
		  	//return $data;
		    $year = Input::get('year');
		    $exam_id = DB::select(DB::raw("select id,exam_type_id from Exam where EXTRACT(year from Exam_on)='$year' and status='1' limit 1"));
		    $exam_id =  $exam_id[0]->id;
		    $size = sizeof(Input::all());
		    $j = 0;

		    for ($i=3;$i<($size-7);$i+= 7){
				$templateID = 'template'.$j;
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
				$template = Input::get($templateID);

				$statusEng = 'updated';
				$statusMath = 'updated';
				$statusSci = 'updated';

				if(empty($studentId)) break;

				if($template==-2){
					if (is_nan($marksEng)) $marksEng = $marksEng*9.5;
					if (is_nan($marksMath)) $marksMath = $marksMath*9.5;
					if (is_nan($marksSci)) $marksSci = $marksSci*9.5;

					$totalSci = $totalEng = $totalMath = 100;
				}
				elseif ($template>=0) {

					$grades = DB::table('Grade_Template as A')->join('Grade_Template_Collection as B','A.id','=','B.grade_template_id')->join('Grade_Template_Grade as C','C.id','=','B.grade_id')->select('C.grade as grade','C.id','C.from_mark as lower','C.to_mark as upper')->where('A.id',$template)->where('A.status',1)->get();

					foreach ($grades as $grade) {
						if($grade->grade == $marksEng){
							$marksEng = (float)((float)$grade->upper + (float)$grade->lower)/2;
						}
						if($grade->grade == $marksMath){
							$marksMath = (float)((float)$grade->upper + (float)$grade->lower)/2;
						}
						if($grade->grade == $marksSci){
							$marksSci = (float)((float)$grade->upper + (float)$grade->lower)/2;
						}
					}

				}		
				
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
				else if($marksEng == "P" || $marksEng == "p"){
				  $marksEng = -5;
				  $statusEng = 'pass';
				}
				else if($marksEng == "F" || $marksEng == "f"){
				  $marksEng = -6;
				  $statusEng = 'fail';
				}
				else if($marksEng == "RE" || $marksEng == "re"){
				  $marksEng = -7;
				  $statusEng = 're-exam';
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
				else if($marksMath == "P" || $marksMath == "p"){
				  $marksMath = -5;
				  $statusMath = 'pass';
				}
				else if($marksMath == "F" || $marksMath == "f"){
				  $marksMath = -6;
				  $statusMath = 'fail';
				}
				else if($marksMath == "RE" || $marksMath == "re"){
				  $marksMath = -7;
				  $statusMath = 're-exam';
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
				else if($marksSci == "P" || $marksSci == "p"){
				  $marksSci = -5;
				  $statusSci = 'pass';
				}
				else if($marksSci == "F" || $marksSci == "f"){
				  $marksSci = -6;
				  $statusSci = 'fail';
				}
				else if($marksSci == "RE" || $marksSci == "re"){
				  $marksSci = -7;
				  $statusSci = 're-exam';
				}
				



				$value1 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',8)->where('exam_id',$exam_id)->get();
				$value2 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',9)->where('exam_id',$exam_id)->get();
				$value3 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',10)->where('exam_id',$exam_id)->get();


			    
			  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones

				if(empty($value1)){
				    DB::table('Mark')->insert(
				      array('student_id'=>$studentId,'subject_id'=>8,'exam_id'=>$exam_id,'marks'=> $marksEng,'total'=>$totalEng,'status'=>$statusEng,'template_id'=>$template)
				    );
				}
				else{
				  DB::table('Mark')->where('id',(int)($value1[0]->id))->limit(1)->update(array('marks'=> $marksEng,'total'=>$totalEng,'status'=>$statusEng,'template_id'=>$template)
				  );
				}
				
			  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones      

				if(empty($value2)){
				    DB::table('Mark')->insert(
				      array('student_id'=>$studentId,'subject_id'=>9,'exam_id'=>$exam_id,'marks'=>$marksMath,'total'=>$totalMath,'status'=>$statusMath,'template_id'=>$template)
				    );
				}
				else{
				  DB::table('Mark')->where('id',(int)($value2[0]->id))->update(array('marks'=>$marksMath,'total'=>$totalMath,'status'=>$statusMath,'template_id'=>$template)
				  );
				}
				
			  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones      
			  
				if(empty($value3)){
				    DB::table('Mark')->insert(
				      array('student_id'=>$studentId,'subject_id'=>10,'exam_id'=>$exam_id,'marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci,'template_id'=>$template)
				    );
				}
				else{
				  DB::table('Mark')->where('id',(int)($value3[0]->id))->update(array('marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci,'template_id'=>$template)
				  	);
				}
				
					$j++;
			}

			$center_id = Input::get('center_id');
			$reason = Input::get('reason');

			$center_reason = DB::table('Mark_Reason')->select('id')->where('center_id','=',$center_id)->first();
			
			if(empty($center_reason) && !empty($reason)){
				DB::table('Mark_Reason')->insert(array('center_id'=>$center_id,'reason'=>$reason));	
			}
			elseif (!empty($center_reason) && !empty($reason)) {
				DB::table('Mark_Reason')->where('id','=',$center_reason->id)->update(array('reason'=>$reason));
			}
			

		    return 'Changes updated successful in the Database';
		}
	}
}

