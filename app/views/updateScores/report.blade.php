@extends('master.default')
@section('content')

	<p class="title">
	  <?php
		  //$yearText = $year.'-'.($year+1);
		  echo 'Center Name: '.$centerName->name.', Level Name: '.$levelName->name.', Year: '.$year.'.';
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	<form name="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form">
	<table><tr id="header"> <td width="40%">Student Name</td>
	<?php
		echo '<td width="20%">MATH</td>'.
		'<td width="20%">SCIENCE</td>'.
		'<td width="20%">ENGLISH</td></tr>';		
		foreach ($classList as $class){
			echo '<tr id="content">'.
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
			'<input class="markInput" type="text" value="" name="mathScore" maxlength="3"/></td>'.
			'<td><input class="markInput" type="text" value="" name="sciScore" maxlength="3"/></td>'.
			'<td><input class="markInput" type="text" value="" name="engScore"maxlength="3"/></td>'.
			'</tr>';
		}?>
		</table>
		  <div class="col-md-12 col-sm-6 text-center">
		    <input type="submit" class="markSubmit" name="submit" value="Update Scores" />
		  </div>
		</form></div>
@stop
