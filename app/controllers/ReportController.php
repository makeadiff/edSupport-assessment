<?php

  class ReportController extends BaseController{
    
    public function index(){
      return View::make('report.index');
    }
    
//     select Student.Name,Center.name,City.name,Mark.marks,Subject.name,Mark.Total,EXTRACT(year from Exam.Exam_on) from Mark inner join Student on Student.id = Mark.student_id inner join Subject on Subject.id = Mark.subject_id inner join Exam on Exam.id = Mark.exam_id inner join Center on Student.center_id = Center.id inner join City on City.id = Center.city_id where marks > 0;
    
    public function generateRawDump(){

      $datas = DB::table('Mark')->join('Student','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->join('Subject','Subject.id','=','Mark.subject_id')->join('Exam','Exam.id','=','Mark.Exam_id')->join('Center','Center.id','=','Student.center_id')->join('City','City.id','=','Center.city_id')->select('Student.name as Student_Name','Student.sex as Sex','Level.grade as Class','Center.name as Center_Name','City.name as City_Name','Mark.marks as Marks','Subject.name as Subject_Name','Mark.Total as Total','Exam.Exam_on as Year','Mark.status as status')->get();
      
      
//       'Student.name as Student_Name','Center.name as Center_Name','City.name as City_Name','Mark.marks as Marks','Subject.name as Subject_Name','Mark.Total','EXTRACT(year from Exam.Exam_on)'
//       return $datas;
      
      $file = fopen('AssessmentReport.csv','w');
      $header = 'Student Name,Sex,Class,Center,City,Marks,Subject,Total,Year,Grade'.PHP_EOL;
      fwrite($file,$header);
      foreach($datas as $data){
  	    $value = (float)$data->Marks/$data->Total*100;
  	    $grade = getGrade($value);
  	    $marks = $data->Marks;
  	    if($marks<0){
  	       $marks = $data->status;
  	    }
        $year = strstr($data->Year, '-', true);
  	    $string = $data->Student_Name.','.$data->Sex.','.$data->Class.','.str_replace(",","-",$data->Center_Name).','.$data->City_Name.','.$marks.','.str_replace(",","-",$data->Subject_Name).','.$data->Total.','.$year.','.$grade.PHP_EOL;
  	    fwrite($file,$string);
      }
      
      fclose($file);
      $file='AssessmentReport.csv';
      $headers = array(
              'Content-Type: application/csv',
            );
      return Response::download($file,'Annual_Assessment_Report_Data.csv',$headers);
      
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
      if($mark->marks==-1){
        $data[$i]['eng13'] = 'NU';
      }
      else if($mark->marks ==-2){
        $data[$i]['eng13'] = 'AB';
      } 
      else if($mark->marks ==-3){
        $data[$i]['eng13'] = 'NA';
      } 
      else if($mark->marks ==-4){
        $data[$i]['eng13'] = 'OT';
      }
      else{
  	    $value = (float)$mark->marks/$mark->total*100;
  	    $data[$i]['eng13'] = getGrade($value);
      }
	  }
	  else if($mark->subject_id==9 && $mark->exam_id==1){
	    if($mark->marks==-1){
        $data[$i]['math13'] = 'NU';
      }
      else if($mark->marks ==-2){
        $data[$i]['math13'] = 'AB';
      } 
      else if($mark->marks ==-3){
        $data[$i]['math13'] = 'NA';
      } 
      else if($mark->marks ==-4){
        $data[$i]['math13'] = 'OT';
      }
      else{
        $value = (float)$mark->marks/$mark->total*100;
        $data[$i]['math13'] = getGrade($value);
      }
	  }
	  else if($mark->subject_id==10 && $mark->exam_id==1){
	    if($mark->marks==-1){
        $data[$i]['sci13'] = 'NU';
      }
      else if($mark->marks ==-2){
        $data[$i]['sci13'] = 'AB';
      } 
      else if($mark->marks ==-3){
        $data[$i]['sci13'] = 'NA';
      } 
      else if($mark->marks ==-4){
        $data[$i]['sci13'] = 'OT';
      }
      else{
        $value = (float)$mark->marks/$mark->total*100;
        $data[$i]['sci13'] = getGrade($value);
      }
	  }
	  else if($mark->subject_id==8 && $mark->exam_id==2){
	    if($mark->marks==-1){
        $data[$i]['eng14'] = 'NU';
      }
      else if($mark->marks ==-2){
        $data[$i]['eng14'] = 'AB';
      } 
      else if($mark->marks ==-3){
        $data[$i]['eng14'] = 'NA';
      } 
      else if($mark->marks ==-4){
        $data[$i]['eng14'] = 'OT';
      }
      else{
        $value = (float)$mark->marks/$mark->total*100;
        $data[$i]['eng14'] = getGrade($value);
      }
	  }
	  else if($mark->subject_id==9 && $mark->exam_id==2){
	    if($mark->marks==-1){
        $data[$i]['math14'] = 'NU';
      }
      else if($mark->marks ==-2){
        $data[$i]['math14'] = 'AB';
      } 
      else if($mark->marks ==-3){
        $data[$i]['math14'] = 'NA';
      } 
      else if($mark->marks ==-4){
        $data[$i]['math14'] = 'OT';
      }
      else{
        $value = (float)$mark->marks/$mark->total*100;
        $data[$i]['math14'] = getGrade($value);
      }
    }
	  else if($mark->subject_id==10 && $mark->exam_id==2){
	    if($mark->marks==-1){
        $data[$i]['sci14'] = 'NU';
      }
      else if($mark->marks ==-2){
        $data[$i]['sci14'] = 'AB';
      } 
      else if($mark->marks ==-3){
        $data[$i]['sci14'] = 'NA';
      } 
      else if($mark->marks ==-4){
        $data[$i]['sci14'] = 'OT';
      }
      else{
        $value = (float)$mark->marks/$mark->total*100;
        $data[$i]['sci14'] = getGrade($value);
      }
	  }
	  $tempId = $mark->id;
      }
      $i++;
    }
    
//     return $data;
    return View::make('report.showReport',['data'=>$data,'city'=>$cityName,'center'=>$centerName,'level'=>$levelName]);
    
   }
   
   
   public function generateAnnualImpact(){
    return View::make('report.annualImpact');
   }    
   
   public function getCSV($year){

      header("Content-type: text/plain");

      $datas = DB::table('Student')->leftjoin('Mark','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->leftJoin('BatchLevel as B','B.level_id','=','Level.id')->leftJoin('UserBatch as C','C.batch_id','=','B.batch_id')->leftJoin('User','User.id','=','C.user_id')->leftJoin('Subject as D','D.id','=','User.subject_id')->leftJoin('Subject','Subject.id','=','Mark.subject_id')->leftJoin('Exam','Exam.id','=','Mark.Exam_id')->join('Center','Center.id','=','Student.center_id')->join('City','City.id','=','Center.city_id')->select('Student.id as student_id','Student.name as student_name','Student.sex as sex','Level.grade as class','Center.name as center_name','City.name as city_name','Mark.marks as marks','Subject.name as subject_name','Mark.Total as total','Mark.subject_id as subject_id_mark','Exam.Exam_on as Year','Mark.status as status','D.name as subjects','D.id as subject_id')->distinct()->orderBy('City.name','ASC')->orderBy('Center.name','ASC')->orderBy('student_id','ASC')->where('Level.year','=',$year)->where('Student.status','=',1)->get();

      //return $datas;

      $i = -1;
      $prev_student = 0;

      $data_array = array();      

      foreach ($datas as $data) {

        $patternMath = '/^Math/';
        $patternEng = '/^English/';
        $patternSci = '/^Science/';

      //------------- general data -------------------------------
        $student_id = $data->student_id;
        $center_name = $data->center_name;
        $city_name = $data->city_name;
        $class = $data->class;
        $student_name = $data->student_name;
        $student_sex = $data->sex;
        $subject_id = $data->subject_id;
        $subject_name = $data->subjects;
        $subject_name_mark = $data->subject_name;
        $subject_id_mark = $data->subject_id_mark;
        $mark = $data->marks;
        $total = $data->total;

        //var_dump($data);

        if($student_id != $prev_student){
          $i++;
          $prev_student = $student_id;
        }
      //----------------------------------------------------------
        $data_array[$i]['student_id'] = $student_id;
        $data_array[$i]['student_name'] = $student_name;
        $data_array[$i]['city'] = $city_name;
        $data_array[$i]['center'] = str_replace(',','',$center_name);
        $data_array[$i]['student_grade'] = $class;
      //----------------------------------------------------------
        
        if($subject_id==2 || $subject_id==5 || $subject_id==8 ){
          $data_array[$i]['english'] = 1;
        }
        else if($subject_id==3 || $subject_id==6 ||$subject_id==9){
          $data_array[$i]['math'] = 1; 
        }
        else if($subject_id==4 || $subject_id==7 || $subject_id==10){
          $data_array[$i]['science'] = 1;  
        }

        if(!isset($data_array[$i]['english'])){
          $data_array[$i]['english'] = 1;
        }
        if(!isset($data_array[$i]['math'])){
          $data_array[$i]['math'] = 1;
        }
        if(!isset($data_array[$i]['science'])){
          $data_array[$i]['science'] = 1;
        }


        if($subject_id_mark==8){          
          if($mark>=0){
            $data_array[$i]['english_mark'] = $mark/$total*100;
          }
          elseif ($mark=="NULL" || $mark == "null") {
            $data_array[$i]['english_mark'] = 'not updated';
          }
          else{
            $data_array[$i]['english_mark'] = $data->status;
          }
        }
        else if($subject_id_mark==9){
          if($mark>=0){
            $data_array[$i]['math_mark'] = $mark/$total*100;
          }
          elseif ($mark=="NULL" || $mark == "null") {
            $data_array[$i]['math_mark'] = 'not updated';
          }
          else{
            $data_array[$i]['math_mark'] = $data->status;
          }
        }
        else if($subject_id_mark == 10){
          if($mark>=0){
            $data_array[$i]['science_mark'] = $mark/$total*100;
          }
          elseif ($mark=="NULL" || $mark == "null") {
            $data_array[$i]['science_mark'] = 'not updated';
          }
          else{
            $data_array[$i]['science_mark'] = $data->status;
          }
        }
        
        
        if(!isset($data_array[$i]['english_mark'])){
          $data_array[$i]['english_mark'] = 'not updated';
        }
        if(!isset($data_array[$i]['math_mark'])){
          $data_array[$i]['math_mark'] = 'not updated';
        }
        if(!isset($data_array[$i]['science_mark'])){
          $data_array[$i]['science_mark'] = 'not updated';
        }

        /*
        if($subject_id==8){
          if($mark>=0){
            $data_array[$i]['english_mark'] = $mark/$total*100;
          }
          else{
            $data_array[$i]['english_mark'] = $data->status;
          }

        }
        else if($subject_id==9){
          if($mark>=0){
            $data_array[$i]['math_mark'] = $mark/$total*100;
          }
          else{
            $data_array[$i]['math_mark'] = $data->status;
          }
        }
        else if($subject_id==10){
          if($mark>=0){
            $data_array[$i]['science_mark'] = $mark/$total*100;
          }
          else{
            $data_array[$i]['science_mark'] = $data->status;
          }
        }
        */
                
    }

      //var_dump($data_array);
      //return 'Hi';
      //$file = fopen('AssessmentReport.csv','w');
      $header = 'Student ID,Student Name,City,Center,Grade,Math,English,Science,Marks_Math,Marks_English,Marks_Science'.PHP_EOL;
      
      print ($header);
      //fwrite($file,$header);
      foreach($data_array as $data){
        $string = $data['student_id'].','.$data['student_name'].','.$data['city'].','.$data['center'].','.$data['student_grade'].','.$data['math'].','.$data['english'].','.$data['science'].','.$data['math_mark'].','.$data['english_mark'].','.$data['science_mark'].PHP_EOL;
        //fwrite($file,$string);
        print($string);
      }
      //$mime = i($QUERY, 'mime', 'csv');
      //
      //echo array2csv($data_array);

      //fclose($file);
   }


   public function downloadCSV(){

      $datas = DB::table('Student')->leftjoin('Mark','Student.id','=','Mark.student_id')->join('StudentLevel','StudentLevel.student_id','=','Student.id')->join('Level','Level.id','=','StudentLevel.level_id')->join('BatchLevel as B','B.level_id','=','Level.id')->join('UserBatch as C','C.batch_id','=','B.batch_id')->join('User','User.id','=','C.user_id')->join('Subject as D','D.id','=','User.subject_id')->leftJoin('Subject','Subject.id','=','Mark.subject_id')->leftJoin('Exam','Exam.id','=','Mark.Exam_id')->join('Center','Center.id','=','Student.center_id')->join('City','City.id','=','Center.city_id')->select('Student.id as student_id','Student.name as student_name','Student.sex as sex','Level.grade as class','Center.name as center_name','City.name as city_name','Mark.marks as marks','Subject.name as subject_name','Mark.Total as total','Mark.subject_id as subject_id_mark','Exam.Exam_on as Year','Mark.status as status','D.name as subjects','D.id as subject_id')->distinct()->orderBy('City.name','ASC')->orderBy('Center.name','ASC')->orderBy('student_id','ASC')->where('Student.status','=',1)->get();

      //return $datas;

      $i = -1;
      $prev_student = 0;

      $data_array = array();      

      foreach ($datas as $data) {

        $patternMath = '/^Math/';
        $patternEng = '/^English/';
        $patternSci = '/^Science/';

      //------------- general data -------------------------------
        $student_id = $data->student_id;
        $center_name = $data->center_name;
        $city_name = $data->city_name;
        $class = $data->class;
        $student_name = $data->student_name;
        $student_sex = $data->sex;
        $subject_id = $data->subject_id;
        $subject_name = $data->subjects;
        $subject_name_mark = $data->subject_name;
        $subject_id_mark = $data->subject_id_mark;
        $mark = $data->marks;
        $total = $data->total;

        //var_dump($data);

        if($student_id != $prev_student){
          $i++;
          $prev_student = $student_id;
        }
      //----------------------------------------------------------
        $data_array[$i]['student_id'] = $student_id;
        $data_array[$i]['student_name'] = $student_name;
        $data_array[$i]['city'] = $city_name;
        $data_array[$i]['center'] = str_replace(',','',$center_name);
        $data_array[$i]['student_grade'] = $class;
      //----------------------------------------------------------
        
        if($subject_id==2 || $subject_id==5 || $subject_id==8 ){
          $data_array[$i]['english'] = 1;
        }
        else if($subject_id==3 || $subject_id==6 ||$subject_id==9){
          $data_array[$i]['math'] = 1; 
        }
        else if($subject_id==4 || $subject_id==7 || $subject_id==10){
          $data_array[$i]['science'] = 1;  
        }

        if(!isset($data_array[$i]['english'])){
          $data_array[$i]['english'] = 0;
        }
        if(!isset($data_array[$i]['math'])){
          $data_array[$i]['math'] = 0;
        }
        if(!isset($data_array[$i]['science'])){
          $data_array[$i]['science'] = 0;
        }


        if($subject_id_mark==8){          
          if($mark>=0){
            $data_array[$i]['english_mark'] = $mark/$total*100;
          }
          elseif ($mark=="NULL" || $mark == "null") {
            $data_array[$i]['english_mark'] = 'not updated';
          }
          else{
            $data_array[$i]['english_mark'] = $data->status;
          }
        }
        else if($subject_id_mark==9){
          if($mark>=0){
            $data_array[$i]['math_mark'] = $mark/$total*100;
          }
          elseif ($mark=="NULL" || $mark == "null") {
            $data_array[$i]['math_mark'] = 'not updated';
          }
          else{
            $data_array[$i]['math_mark'] = $data->status;
          }
        }
        else if($subject_id_mark == 10){
          if($mark>=0){
            $data_array[$i]['science_mark'] = $mark/$total*100;
          }
          elseif ($mark=="NULL" || $mark == "null") {
            $data_array[$i]['science_mark'] = 'not updated';
          }
          else{
            $data_array[$i]['science_mark'] = $data->status;
          }
        }
        
        
        if(!isset($data_array[$i]['english_mark'])){
          $data_array[$i]['english_mark'] = 'not updated';
        }
        if(!isset($data_array[$i]['math_mark'])){
          $data_array[$i]['math_mark'] = 'not updated';
        }
        if(!isset($data_array[$i]['science_mark'])){
          $data_array[$i]['science_mark'] = 'not updated';
        }

        /*
        if($subject_id==8){
          if($mark>=0){
            $data_array[$i]['english_mark'] = $mark/$total*100;
          }
          else{
            $data_array[$i]['english_mark'] = $data->status;
          }

        }
        else if($subject_id==9){
          if($mark>=0){
            $data_array[$i]['math_mark'] = $mark/$total*100;
          }
          else{
            $data_array[$i]['math_mark'] = $data->status;
          }
        }
        else if($subject_id==10){
          if($mark>=0){
            $data_array[$i]['science_mark'] = $mark/$total*100;
          }
          else{
            $data_array[$i]['science_mark'] = $data->status;
          }
        }
        */
                
    }

      //var_dump($data_array);
      //return 'Hi';
      $file = fopen('AssessmentReport.csv','w');
      $header = 'Student ID,Student Name,City,Center,Child,Grade,Math,English,Science,Marks_Math,Marks_English,Marks_Science'.PHP_EOL;
      fwrite($file,$header);
      foreach($data_array as $data){
        $string = $data['student_id'].','.$data['student_name'].','.$data['city'].','.$data['center'].','.$data['student_grade'].','.$data['math'].','.$data['english'].','.$data['science'].','.$data['math_mark'].','.$data['english_mark'].','.$data['science_mark'].PHP_EOL;
        fwrite($file,$string);
      }

      fclose($file);
      $file='AssessmentReport.csv';
      $headers = array(
              'Content-Type: application/csv',
            );
      return Response::download($file,'Annual_Assessment_Report_Data.csv',$headers);
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

function array2csv(array &$array)
  {
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
  }