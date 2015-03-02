<?php

  class ReportController extends BaseController{
    
    public function index(){
      return View::make('report.index');
    }
    
//     select Student.Name,Center.name,City.name,Mark.marks,Subject.name,Mark.Total,EXTRACT(year from Exam.Exam_on) from Mark inner join Student on Student.id = Mark.student_id inner join Subject on Subject.id = Mark.subject_id inner join Exam on Exam.id = Mark.exam_id inner join Center on Student.center_id = Center.id inner join City on City.id = Center.city_id where marks > 0;
    
    public function generateRawDump(){
      $datas = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->join('Subject','Subject.id','=','Mark.subject_id')->join('Exam','Exam.id','=','Mark.Exam_id')->join('Center','Center.id','=','Student.center_id')->join('City','City.id','=','Center.city_id')->select('Student.name as Student_Name','Student.sex as Sex','Level.name as Section','Center.name as Center_Name','City.name as City_Name','Mark.marks as Marks','Subject.name as Subject_Name','Mark.Total as Total','Exam.Exam_on as Year','Mark.status as status')->get();
      
      
//       'Student.name as Student_Name','Center.name as Center_Name','City.name as City_Name','Mark.marks as Marks','Subject.name as Subject_Name','Mark.Total','EXTRACT(year from Exam.Exam_on)'
//       return $datas;
      
      $file = fopen('AssessmentReport.csv','w');
      $header = 'Student Name,Sex,Section,Center,City,Marks,Subject,Total,Year,Grade'.PHP_EOL;
      fwrite($file,$header);
      foreach($datas as $data){
	$value = (float)$data->Marks/$data->Total*100;
	$grade = getGrade($value);
	$marks = $data->Marks;
	if($marks<0){
	  $marks = $data->status;
	}
	$year = strstr($data->Year, '-', true);
	$string = $data->Student_Name.','.$data->Sex.','.$data->Section.','.$data->Center_Name.','.$data->City_Name.','.$marks.','.$data->Subject_Name.','.$data->Total.','.$year.','.$grade.PHP_EOL;
	fwrite($file,$string);
      }
      
      fclose($file);
      $file='AssessmentReport.csv';
      $headers = array(
              'Content-Type: application/csv',
            );
      return Response::download($file,'Annual_Assessment_Report_Data',$headers);
      
    }
    
    public function classProgress(){
      
      
      $cityList = DB::table('City')->select('id','name')->where('id','<=',25)->orderBy('name','ASC')->get();
      $cityFirst = DB::table('City')->select('id','name')->where('id','<=',25)->orderBy('name','ASC')->first();
      $cityId = $cityFirst->id;
      
      $centerList = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.name','Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->get();
	  
      $centerFirst = DB::table('Center')->join('City','Center.city_id','=','City.id')->select('Center.id')->where('Center.city_id',$cityId)->where('Center.status','=','1')->first();
      $idFirst =  $centerFirst->id;
	
      $year = 2014;		  
      $classList = DB::table('Level')->select('id','name','grade')->where('center_id',$idFirst)->where('year',$year)->get();
      return View::make('report.classProgress',['cityList'=>$cityList,'centerList'=>$centerList,'classList'=>$classList]);
    }
   
  public function cityList(){
    if(Request::ajax()){
      $cityId =  (int)Input::get('cityId');
//       return($cityId);
      $centerList = DB::table('Center')->select('id','name')->where('city_id',$cityId)->where('status','1')->get();
      $centerFirst = DB::table('Center')->select('id','name')->where('city_id',$cityId)->where('status','1')->first();
      $centerId = $centerFirst->id;
//       return $centerId;
      $classList = DB::table('Level')->select('id','name','grade')->where('center_id',$centerId)->where('year',2014)->get();
      $data = array('center'=>$centerList,'classList'=>$classList);
      return json_encode($data);
    }
   }
   
   public function fetchYear(){
    if(Request::ajax()){
      $centerId =  (int)Input::get('centerId');
      $classList = DB::table('Level')->select('id','name','grade')->where('center_id',$centerId)->where('year',2014)->get();
      $data = array('class'=>$classList);
      return json_encode($data);
    }
   }
   
  public function generateReport(){
    
    $cityId = Input::get('cityId');
    $centerId = Input::get('centerId');
    $levelId = Input::get('levelId');
    
    $cityName = DB::table('City')->select('name')->where('id',$cityId)->first();
    $centerName = DB::table('Center')->select('name')->where('id',$centerId)->first();
    $levelName = DB::table('Level')->select('name')->where('id',$levelId)->first();
    
    $classList = DB::table('Student')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','StudentLevel.level_id')->distinct()->where('level_id',	$levelId)->get();
    
      
    $marks = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','StudentLevel.level_id','Mark.marks','Mark.subject_id','Mark.total')->distinct()->where('level_id',$levelId)->get();
    
    if(empty($classList)||empty($marks)){
      return View::make('updateScores.nodata')->with('message','No Data is avaiable for the selected Center and Level.');
    }
    
    $students = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.id')->distinct()->where('level_id',$levelId)->get();
    
//     return $students;
    
    $data = array();
    $i = 0;
    foreach($students as $student){
      $studentId = $student->id;
      $marks = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->select('Student.name','Student.id','Level.id','Mark.marks','Mark.subject_id','Mark.total','Mark.exam_id')->distinct()->where('level_id',$levelId)->where('Student.id',$studentId)->get();
//       return $marks;
      $tempId = 0;
      foreach($marks as $mark){
	  if(!($mark->id==$tempId)){
	    $data[$i]['name'] = $mark->name;
	  }
	  if($mark->subject_id==8 && $mark->exam_id==1){
	    $value = (float)$mark->marks/$mark->total*100;
	    $data[$i]['eng13'] = getGrade($value);
	  }
	  else if($mark->subject_id==9 && $mark->exam_id==1){
	    $value = (float)$mark->marks/$mark->total*100;
	    $data[$i]['math13'] = getGrade($value);
	  }
	  else if($mark->subject_id==10 && $mark->exam_id==1){
	    $value = (float)$mark->marks/$mark->total*100;
	    $data[$i]['sci13'] = getGrade($value);
	  }
	  else if($mark->subject_id==8 && $mark->exam_id==2){
	    $value = (float)$mark->marks/$mark->total*100;
	    $data[$i]['eng14'] = getGrade($value);
	  }
	  else if($mark->subject_id==9 && $mark->exam_id==2){
	    $value = (float)$mark->marks/$mark->total*100;
	    $data[$i]['math14'] = getGrade($value);
	  }
	  else if($mark->subject_id==10 && $mark->exam_id==2){
	    $value = (float)$mark->marks/$mark->total*100;
	    $data[$i]['sci14'] = getGrade($value);
	  }
	  $tempId = $mark->id;
      }
      $i++;
    }
    
//     return $data;
    return View::make('report.showReport',['data'=>$data,'city'=>$cityName,'center'=>$centerName,'level'=>$levelName]);
    
   }
   
   
      
   
   
  }
  
// Function to Calculate the Grades from given input of Marks  
  
function getGrade($value){
    if($value>=91&&$value<=100){
      return("A1");
    }
    else if($value>=81&&$value<=90){
      return("A2");
    }
    else if($value>=71&&$value<=80){
      return("B1");
    }
    else if($value>=61&&$value<=70){
      return("B2");
    }
    else if($value>=51&&$value<=60){
      return("C1");
    }
    else if($value>=41&&$value<=50){
      return("C2");
    }
    else if($value>=33&&$value<=40){
      return("D");
    }
    else if($value>=21&&$value<=32){
      return("E1");
    }
    else if($value>=0&&$value<=20){
      return("E2");
    }
  }