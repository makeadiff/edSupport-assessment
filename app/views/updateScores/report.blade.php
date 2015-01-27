@extends('master.default')
@section('content')

	<p class="title">
	  <?php
		  echo 'Center Name: '.$centerName->name.', Level Name: '.$levelName->name.', Year: '.$year.'.';
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	<form name="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form" onsubmit="return ValidateMarkForm()">
	  <div class="col-md-12 col-sm-6 text-center">
	    <p class="title">Change Total for all: <input class="markInput total-all" type="number" value="100" max="100" min="0"/></p>
	  </div>
	<table><tr id="header"> <td width="40%">Student Name</td>
	<?php
	  echo '<input type="hidden" name="year" value="'.$year.'"/>';
	  echo '<br/>';
		  
		echo '<td width="20%">ENGLISH</td>'.
		'<td width="20%">MATH</td>'.
		'<td width="20%">SCIENCE</td></tr>';
		if($flag==0){
		  $i = 0;
		  foreach ($classList as $class){
			  echo '<tr class="content">'.
			  '<td>'.$class->name.'</td>';
			  echo '<td>'.
			      '<input class="studentId" type="hidden" value="'.$class->id.'" name="studentId'.$i.'">'.
			      '<input class="markInput math" type="number" value="" max="100" min="0" name="engScore'.$i.'"/>/'.
			      '<input class="markInput" type="number" value="100" max="100" min="0" name="totalEng'.$i.'"/></td>'.
			      '<td><input class="markInput sci" type="number" value="" max="100" min="0" name="mathScore'.$i.'"/>/'.
			      '<input class="markInput" type="number" value="100" max="100" min="0" name="totalMath'.$i.'"/></td>'.
			      '<td><input class="markInput eng" type="number" value="" max="100" min="0" name="sciScore'.$i.'"/>/'.
			      '<input class="markInput" type="number" value="100" max="100" min="0" name="totalSci'.$i.'"/></td>'.
			    '</tr>';
			  $i++;
		  }
		}
		else{
		  $i = -1;
		  $studentId = 0;
// 		  If Marks are already Entered for the list of Students then  ::  Update the Scores;
		  foreach ($classList as $class){
		    if($class->id != $studentId){
		      $i++;
		      echo '<tr class="content">'.'<td>'.$class->name.'</td>';
		      echo '<td>'.'<input class="studentId" type="hidden" value="'.$class->id.'" name="studentId'.$i.'">';		      
		    }
		    if($class->subject_id == 8){
		      if($class->marks<0) $class->marks='';
		      echo '<input class="markInput math" type="number" value="'.$class->marks.'" max="100" min="0" name="engScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalEng'.$i.'"/></td>';
		    }
		    else if($class->subject_id == 9){
		      if($class->marks<0) $class->marks='';
		      echo '<td><input class="markInput sci" type="number" value="'.$class->marks.'" max="100" min="0" name="mathScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalMath'.$i.'"/></td>';
		    }
		    else if($class->subject_id == 10){
		      if($class->marks<0) $class->marks='';
		      echo '<td><input class="markInput eng" type="number" value="'.$class->marks.'" max="100" min="0" name="sciScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalSci'.$i.'"/></td>'.'</tr>';
		    }
		    $studentId=$class->id;
		  }
		}
		
	?>
		</table>
		  <br/>
		  <div class="col-md-12 col-sm-6 text-center">
		    <input type="submit" class="markSubmit" name="submit" value="Update Scores" />
		  </div>
		</form></div>
@stop
