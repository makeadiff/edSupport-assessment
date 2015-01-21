@extends('master.default')
@section('content')

	<p class="title">
	  <?php
		  //$yearText = $year.'-'.($year+1);
		  echo 'Center Name: '.$centerName->name.', Level Name: '.$levelName->name.', Year: '.$year.'.';
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	<form name="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form" onsubmit="return ValidateMarkForm()">
	<table><tr id="header"> <td width="40%">Student Name</td>
	<?php
	  echo '<input type="hidden" name="year" value="'.$year.'"/>';
	  echo '<div class="col-md-12 col-sm-6 text-center">
		      Total Marks: <input type="number" class="totalMarks" name="totalMarks" value="100" max="100" min="0" />
		    </div><br/><br/>';
		  
		echo '<td width="20%">MATH</td>'.
		'<td width="20%">SCIENCE</td>'.
		'<td width="20%">ENGLISH</td></tr>';
		$i = 0;
// 		foreach ($marks as $mark){
// 		  echo $mark->
// 		}
		foreach ($classList as $class){
			echo '<tr class="content">'.
			'<td>'.$class->name.'</td>';
				
				/*if($user->scoreMath==0){
					$math = "";			
				}
				else{
					$math = $user->scoreMath;		
				}
				if($user->scoreEng==0){
					$eng = "";			
				}
				else{
					$eng = $user->scoreEng;		
				}
				if($user->scoreScience==0){
					$sci = "";			
				}
				else{
					$sci = $user->scoreScience;		
				}*/
				
			echo '<td>'.
			  '<input class="studentId" type="hidden" value="'.$class->id.'" name="studentId'.$i.'">'.
			  '<input class="markInput math" type="number" value="" max="100" min="0" name="mathScore'.$i.'" maxlength="3"/></td>'.
			  '<td><input class="markInput sci" type="number" value="" max="100" min="0" name="sciScore'.$i.'" maxlength="3"/></td>'.
			  '<td><input class="markInput eng" type="number" value="" max="100" min="0" name="engScore'.$i.'" maxlength="3"/></td>'.
			'</tr>';
		$i++;
		}
		
	?>
		</table>
		  <br/>
		  <div class="col-md-12 col-sm-6 text-center">
		    <input type="submit" class="markSubmit" name="submit" value="Update Scores" />
		  </div>
		</form></div>
@stop
