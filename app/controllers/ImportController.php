<?php

class ImportController extends BaseController{

  public function importfromcsv(){
    $totalFiles = count($_FILES["file_upload"]["name"]);
    for($k=0;$k<$totalFiles;$k++){
      $target_dir = "./";
      $target_file = $target_dir . basename($_FILES["file_upload"]["name"][$k]);
      $uploadOk = 1;

      $csvFile = pathinfo($target_file,PATHINFO_EXTENSION);

      if (move_uploaded_file($_FILES["file_upload"]["tmp_name"][$k], $target_file)) {
          echo "The file ". basename( $_FILES["file_upload"]["name"][$k]). " has been uploaded. <br/>".PHP_EOL;
      } else {
          echo "Sorry, there was an error uploading your file. <br/>".PHP_EOL;
      }

      // exec()

      $score_data = array();
      $i=0;
      $flag=true;
      $f = fopen($target_file,'r');
      while(($line = fgetcsv($f)) !== FALSE){

        if(is_numeric($line[0])){
          $flag = true;
        }
        else{
          $flag = false;
        }

        if($flag==true){
          $score_data[$i] = $line;
          $i++;
        }
        /*
          Fields
          0. ID
          1. Name
          2. Shelter Name
          4. Level
          5. City
          6. Math Marks
          7. Math Total
          8. English Marks
          9. English Total
          10. Science Marks
          11. Science Total
          14. Math Percentage
          15. Science Percentage
          16. English Percentage

          Subject ID:
            English: 8;
            Math: 9;
            Science: 10

          Exam ID: 4 (External Exams 2016-17)
        */
      }
      fclose($f);
      exec ('rm '.$target_file);

      $scores = array();
      $i = 0;
      $exam_id = 4; //Change for every year.
      foreach ($score_data as $score) {
        // English Scores
        $scores[$i]['student_id']=$score[0];
        $scores[$i]['subject_id']=8;
        if(is_numeric($score[8])){
          $scores[$i]['marks']=$score[8];
          $scores[$i]['input']=$score[8];
          $scores[$i]['status']='updated';
        }
        else{
          $scores[$i]['marks']=-1;
          $scores[$i]['input']=-1;
          $scores[$i]['status']='not updated';
        }
        $scores[$i]['total']=$score[9];
        $scores[$i]['template_id']=-1;
        $i++;

        //Math Scores
        $scores[$i]['student_id']=$score[0];
        $scores[$i]['subject_id']=9;
        if(is_numeric($score[6])){
          $scores[$i]['marks']=$score[6];
          $scores[$i]['input']=$score[6];
          $scores[$i]['status']='updated';
        }
        else{
          $scores[$i]['marks']=-1;
          $scores[$i]['input']=-1;
          $scores[$i]['status']='not updated';
        }
        $scores[$i]['total']=$score[7];
        $scores[$i]['template_id']=-1;
        $i++;

        // Science Scores
        $scores[$i]['student_id']=$score[0];
        $scores[$i]['subject_id']=10;
        if(is_numeric($score[10])){
          $scores[$i]['marks']=$score[10];
          $scores[$i]['input']=$score[10];
          $scores[$i]['status']='updated';
        }
        else{
          $scores[$i]['marks']=-1;
          $scores[$i]['input']=-1;
          $scores[$i]['status']='not updated';
        }
        $scores[$i]['total']=$score[11];
        $scores[$i]['template_id']=-1;
        $i++;
      }

      // return $scores;

      foreach ($scores as $score) {
        $value = DB::table('Mark')->select('id')->where('student_id',$score['student_id'])->where('subject_id',$score['subject_id'])->where('exam_id',$exam_id)->get();
        if(empty($value)){
            $insert = DB::table('Mark')->insert(
              array(
                'student_id'=>$score['student_id'],
                'subject_id'=>$score['subject_id'],
                'exam_id'=>$exam_id,
                'input_data'=>$score['input'],
                'marks'=>$score['marks'],
                'total'=>$score['total'],
                'status'=>$score['status'],
                'template_id'=>$score['template_id'])
            );
        }
        else{
            $insert = DB::table('Mark')
              ->where('id',(int)($value[0]->id))
              ->update(
                array(
                  'input_data'=>$score['input'],
                  'marks'=>$score['marks'],
                  'total'=>$score['total'],
                  'status'=>$score['status'])
                );
        }

        if($insert >= 0){
          echo $insert.". Data for ID:".$score['student_id']." is Updated on the Database <br/>";
        }
        else{
          echo $insert.". Data Update Error, ID: ".$score['student_id']." <br/>";
        }
      }
    }
  }

  public function selectFile(){
    return View::make('content.importfile');
  }

}
