<?php

class EditController extends BaseController{

    public function getListOfStudents(){

    	$centerId = Input::get('centerId');
      	$year = Input::get('year');
      	$exam_id = DB::select(DB::raw("select id,exam_type_id from Exam where EXTRACT(year from Exam_on)='$year' and status='1' limit 1"));
      	$exam_id =  $exam_id[0]->id;
      	$centerName = DB::table('Center')->select('id','name')->where('id',$centerId)->first();

      	$dataClass = DB::table('Student')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Center','Center.id','=','Student.center_id')->join('Level','Level.id','=','StudentLevel.level_id');

      	$className = $dataClass->select('Level.grade')->where('Student.center_id','=',$centerId)->orderby('Level.grade','ASC')->where('Level.grade','>','0')->groupby('Level.grade')->get();


      	$datas = DB::table('Student')->leftjoin('Mark','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->leftJoin('Subject','Subject.id','=','Mark.subject_id')->leftJoin('Exam','Exam.id','=','Mark.Exam_id')->join('Center','Center.id','=','Student.center_id')->join('City','City.id','=','Center.city_id')->select('Student.id as student_id','Student.name as student_name','Level.grade as class','Mark.input_data as marks','Mark.template_id as grade_template','Subject.name as subject_name','Mark.Total as total','Mark.subject_id as subject_id_mark','Exam.Exam_on as Year')->distinct()->orderBy('Level.grade','ASC')->orderBy('student_id','ASC')->where('Center.status','=',1)->where('Level.year','=',$year)->where('Center.id','=',$centerId)->get();

      	if(empty($datas)){
      		return View::make('updateScores.nodata')->with('message','No data available for selected Shelter and Year');
      	}

      	$i = -1;
	    $prev_student = 0;

	    $data_array = array();

	    foreach ($datas as $data) {

	        $patternMath = '/^Math/';
	        $patternEng = '/^English/';
	        $patternSci = '/^Science/';

	      //------------- general data -------------------------------
	        $student_id = $data->student_id;
	        $class = $data->class;
	        $student_name = $data->student_name;
	        $subject_name_mark = $data->subject_name;
	        $subject_id_mark = $data->subject_id_mark;
	        $mark = $data->marks;
	        $total = $data->total;
	        $grade_template_id = $data->grade_template;

	        //var_dump($data);

	        if($mark == '-1' ) $mark='';
		  	if($mark == '-2' ) $mark='AB';
		  	if($mark == '-3' ) $mark='NA';
		  	if($mark == '-4' ) $mark='OT';
		  	if($mark == '-5' ) $mark='P';
		  	if($mark == '-6' ) $mark='F';
		  	if($mark == '-7' ) $mark='RE';

	        if($student_id != $prev_student){
	          $i++;
	          $prev_student = $student_id;
	        }
	      //----------------------------------------------------------
	        $data_array[$i]['id'] = $student_id;
	        $data_array[$i]['name'] = $student_name;
	        $data_array[$i]['grade'] = $class;

	        if(isset($grade_template_id)){
	        	$data_array[$i]['template_id'] = $grade_template_id;
	        }
	        else{
	        	$data_array[$i]['template_id'] = '-1';
	        }

	      //----------------------------------------------------------

	        if($subject_id_mark==8){
	          if(!empty($mark)){
	            $data_array[$i]['english_mark'] = $mark;
	            $data_array[$i]['english_total'] = $total;
	          }
	          else{
	            $data_array[$i]['english_mark'] = '-1';
	            $data_array[$i]['english_total'] = '100';
	          }
	        }
	        else if($subject_id_mark==9){
	          if(!empty($mark)){
	            $data_array[$i]['math_mark'] = $mark;
	            $data_array[$i]['math_total'] = $total;
	          }
	          else{
	            $data_array[$i]['math_mark'] = '-1';
	            $data_array[$i]['math_total'] = '100';
	          }
	        }
	        else if($subject_id_mark == 10){
	          if(!empty($mark)){
	            $data_array[$i]['science_mark'] = $mark;
	            $data_array[$i]['science_total'] = $total;
	          }
	          else{
	            $data_array[$i]['science_mark'] = '-1';
	            $data_array[$i]['science_total'] = '100';
	          }
	        }

	        if(!isset($data_array[$i]['english_mark'])){
	          $data_array[$i]['english_mark'] = '-1';
	          $data_array[$i]['english_total'] = '100';
	        }
	        if(!isset($data_array[$i]['math_mark'])){
	          $data_array[$i]['math_mark'] = '-1';
	          $data_array[$i]['math_total'] = '100';
	        }
	        if(!isset($data_array[$i]['science_mark'])){
	          $data_array[$i]['science_mark'] = '-1';
	          $data_array[$i]['science_total'] = '100';
	        }
	    }

      	$cityId = $_SESSION['city_id'];
	  	  $centerList = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.name','Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->get();

    		$grading_templates = DB::table('Grade_Template')->select('id','name')->where('status',1)->get();


    		$center_reason = DB::table('Mark_Reason')->where('center_id','=',$centerId)->first();


  	  	return View::make('updateScores.report',['centerName'=>$centerName,'year'=>$year,'classList'=>$data_array,'className'=>$className,'centerList'=>$centerList,'grading_templates'=>$grading_templates,'center_reason'=>$center_reason]);
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

				$inputMath = $marksMath;
				$inputEng = $marksEng;
				$inputSci = $marksSci;


				if(empty($studentId)) break;

				if($template==-2){
					if (!is_nan((float)$marksEng)){
						if((float)$marksEng <= 10){
							$marksEng = (float) $marksEng * 9.5;
						}
						else{
							$marksEng = (float)$marksEng;
						}
					}
					if (!is_nan((float)$marksMath)){
						if((float)$marksMath <= 10){
							$marksMath = (float)$marksMath*9.5;
						}
						else{
							$marksMath = (float)$marksMath;
						}
					}
					if (!is_nan((float)$marksSci)){
						if((float)$marksSci <= 10){
							$marksSci = (float)$marksSci*9.5;
						}
						else{
							$marksSci = (float)$marksSci;
						}
					}

					$totalSci = $totalEng = $totalMath = 100;
				}
				elseif ($template>=0) { //Selecting Grades from Grading Template

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

				$value1 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',8)->where('exam_id',$exam_id)->get();
				$value2 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',9)->where('exam_id',$exam_id)->get();
				$value3 = DB::table('Mark')->select('id')->where('student_id',$studentId)->where('subject_id',10)->where('exam_id',$exam_id)->get();



			  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones

				if(empty($value1)){
				    DB::table('Mark')->insert(
				      array('student_id'=>$studentId,'subject_id'=>8,'exam_id'=>$exam_id,'input_data'=>$inputEng,'marks'=> $marksEng,'total'=>$totalEng,'status'=>$statusEng,'template_id'=>$template)
				    );
				}
				else{
				  DB::table('Mark')->where('id',(int)($value1[0]->id))->limit(1)->update(array('input_data'=>$inputEng,'marks'=> $marksEng,'total'=>$totalEng,'status'=>$statusEng,'template_id'=>$template)
				  );
				}

			  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones

				if(empty($value2)){
				    DB::table('Mark')->insert(
				      array('student_id'=>$studentId,'subject_id'=>9,'exam_id'=>$exam_id,'input_data'=>$inputMath,'marks'=>$marksMath,'total'=>$totalMath,'status'=>$statusMath,'template_id'=>$template)
				    );
				}
				else{
				  DB::table('Mark')->where('id',(int)($value2[0]->id))->update(array('input_data'=>$inputMath,'marks'=>$marksMath,'total'=>$totalMath,'status'=>$statusMath,'template_id'=>$template)
				  );
				}

			  //       If table already had entry for the same kid and for the same id, update the current values instead of inserting new ones

				if(empty($value3)){
				    DB::table('Mark')->insert(
				      array('student_id'=>$studentId,'subject_id'=>10,'exam_id'=>$exam_id,'input_data'=>$inputSci,'marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci,'template_id'=>$template)
				    );
				}
				else{
				  DB::table('Mark')->where('id',(int)($value3[0]->id))->update(array('input_data'=>$inputSci,'marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci,'template_id'=>$template)
				  	);
				}

					$j++;
			}

			//Updating reason for not being able to update marks for Shelter.

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

	/* Updating Input Data Field where it's not there already */

	public function updateInputData(){
		$data = DB::table('Mark')->get();

		foreach ($data as $dataset) {
			$id = $dataset->id;
			$student_id = $dataset->student_id;
			$subject_id = $dataset->subject_id;
			$exam_id = $dataset->exam_id;
			$marks = $dataset->marks;
			$total = $dataset->total;
			$input_data = $dataset->input_data;
			$template_id = $dataset->template_id;

			if($template_id==-1 && ($input_data == 0 || $input_data == null)){
				$input_data = $marks;
				//echo 'Mark '.$marks.' - '.$input_data.'<br/>';
				//DB::table('Mark')->where('id',(int)($value3[0]->id))->update(array('input_data'=>$inputSci,'marks'=>$marksSci,'total'=>$totalSci,'status'=>$statusSci,'template_id'=>$template));
				DB::table('Mark')->where('id','=',$id)->update(['input_data'=>$input_data]);
			}
			else if($template_id==-2 && ($input_data == 0 || $input_data == null)){
				if($marks>=0){
					$input_data = (float)$marks/9.5;
					//echo 'GPA '.$marks.' - '.$input_data.'<br/>';
					DB::table('Mark')->where('id','=',$id)->update(['input_data'=>$input_data]);
				}
				else if($marks<0){
					$input_data = $marks;
					//echo 'GPA '.$marks.' - '.$input_data.'<br/>';
					DB::table('Mark')->where('id','=',$id)->update(['input_data'=>$input_data]);
				}
			}
			else if($template_id>0 && ($input_data == 0 || $input_data == null)){
				$template_id = $dataset->template_id;
		        $grade_templates = DB::table('Grade_Template as A')->join('Grade_Template_Collection as B','A.id','=','B.grade_template_id')->join('Grade_Template_Grade as C','C.id','=','B.grade_id')->select('C.from_mark','C.to_mark','C.grade')->where('A.id',$template_id)->where('A.status',1)->get();

		        foreach ($grade_templates as $template) {
		        	if($marks >= $template->from_mark && $marks<=$template->to_mark){
		            	$input_data = $template->grade;
		            	//echo 'Grade '.$marks.' - '.$input_data.'<br/>';
		            	DB::table('Mark')->where('id','=',$id)->update(['input_data'=>$input_data]);
		            }
		        }
			}
		}
	}
}
