@extends('master.update')
@section('content')

	<p class="title">
	  <?php
		  echo 'Center Name: '.$centerName->name.' | Level Name:'.$levelName->grade.' - '.$levelName->name.' | Year: '.$year.'-'.($year+1);
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	  <!-- <div class="col-md-12 col-sm-6 text-center">
	    <p class="title">Change Total for all: <input class="markInput total-all" type="number" value="100" max="100" min="0"/></p>
	  </div> -->
	<p class="title">In case marks are not available, please enter the abbreviations from the table below.</p>
	
	<table class="footable" width="50%">
	  <thead id="header">
	    <th width="25%">Abbreviations</th>
	    <th width="25%">Meaning</th>
	  </thead>
	  <tr id="header">
	    <td width="10%">AB</td>
	    <td width="10%">Student Absent</td>
	  </tr>
	  <tr id="header">
	    <td width="10%">NA</td>
	    <td width="10%">Not Applicable</td>
	  </tr>
	  <tr id="header">
	    <td width="10%">OT</td>
	    <td width="10%">Other Reasons</td>
	  </tr>
	  <tr id="header">
	    <td width="10%">NU</td>
	    <td width="10%">Not Updated</td>
	  </tr>
	</table>
	<table class="footable">
	  <form name="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form" onsubmit="return ValidateMarkForm()">
	    <?php
	      echo '<input type="hidden" name="year" value="'.$year.'"/>';
	      echo '<br/>';
		?> 
		<thead id="header">      
		    <th width="40%">Student Name</th>
		    <th data-hide="phone" data-name="English" width="20%">ENGLISH</th>
		    <th data-hide="phone" data-name="Math" width="20%">MATH</th>
		    <th data-hide="phone" data-name="Science" width="20%">SCIENCE</th>
		</thead>
		<?php
		    if($flag==0){
		      $i = 0;
		      foreach ($classList as $class){
			      echo '<tr class="content">'.
			      '<td>'.$class->name.'</td>';
			      echo '<td>'.
				  '<input class="studentId" type="hidden" value="'.$class->id.'" name="studentId'.$i.'">'.
				  '<input class="markInput secured math" type="text" value="" name="engScore'.$i.'"/>/'.
				  '<input class="markInput" type="number" value="100" max="100" min="0" name="totalEng'.$i.'"/></td>'.
				  '<td><input class="markInput secured sci" type="text" value="" name="mathScore'.$i.'"/>/'.
				  '<input class="markInput" type="number" value="100" max="100" min="0" name="totalMath'.$i.'"/></td>'.
				  '<td><input class="markInput secured eng" type="text" value="" name="sciScore'.$i.'"/>/'.
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
			  if($class->marks == '-1' ) $class->marks='';
			  if($class->marks == '-2' ) $class->marks='AB';
			  if($class->marks == '-3' ) $class->marks='NA';
			  if($class->marks == '-4' ) $class->marks='OT';

			  echo '<input class="markInput secured math" type="text" value="'.$class->marks.'" name="engScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalEng'.$i.'"/></td>';
			}
			else if($class->subject_id == 9){
			  if($class->marks == '-1') $class->marks='';
			  if($class->marks == '-2' ) $class->marks='AB';
			  if($class->marks == '-3' ) $class->marks='NA';
			  if($class->marks == '-4' ) $class->marks='OT';
			  
			  echo '<td><input class="markInput secured sci" type="text" value="'.$class->marks.'" name="mathScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalMath'.$i.'"/></td>';
			}
			else if($class->subject_id == 10){
			  if($class->marks == '-1' ) $class->marks='';
			  if($class->marks == '-2' ) $class->marks='AB';
			  if($class->marks == '-3' ) $class->marks='NA';
			  if($class->marks == '-4' ) $class->marks='OT';
			  
			  echo '<td><input class="markInput secured eng" type="text" value="'.$class->marks.'" name="sciScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalSci'.$i.'"/></td>'.'</tr>';
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
		  </form>
	</div>
@stop
