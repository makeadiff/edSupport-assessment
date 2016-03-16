@extends('master.update')
@section('content')


<?php

	$tableHeaders = '<table class="footable">
			<thead id="header" class="TextCenter center">      
		    <th width="30%">Student Name</th>
		    <th class="center" data-hide="phone" data-name="English" width="20%">ENGLISH  <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    <th class="center" data-hide="phone" data-name="Math" width="20%">MATH <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    <th class="center" data-hide="phone" data-name="Science" width="20%">SCIENCE <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		</thead><tbody>';

	$tableFooter = '</tbody></table></div>'; 

?>

	<p class="title">
	  <?php
		  echo 'Center Name: '.$centerName->name.' | Year: '.$year.'-'.($year+1);
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	  <!-- <div class="col-md-12 col-sm-6 text-center">
	    <p class="title">Change Total for all: <input class="markInput total-all" type="number" value="100" max="100" min="0"/></p>
	  </div> -->
	<div class="row center">
		<div class="col s12 m12">
			<div class="card cyan ">
				<div class="card-content white-text">
		            <span class="card-title">Abbreviation Legend</span>
		            <p>In case marks are not available, please enter the abbreviations from the table below.</p>
					<table class="footable" width="50%">
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
				</div>
			</div>
		</div>
	</div>

	<!--
		Fetching the data for all the students in the mentioned center.
	 -->
	<div class="row center">
		<div class="container" id="updateSuccess">
		    
		</div>
		<div class="btn-group" role="group" aria-label="...">
		  <p>
		  	Select Grade
		  </p>
		  <?php

		  	foreach ($className as $grade) {
		  	  echo '<a href="#'.$grade->grade.'"><button type="button" class="btn cyan btn-default">'.$grade->grade.'</button></a>';
			}
		  ?>
		</div>	
	</div>

	<form name="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form" onsubmit="return ValidateMarkForm()">
	    <?php
	      echo '<input type="hidden" name="year" value="'.$year.'"/>';
	      echo '<br/>';
		?> 
	
		<?php
		    if($flag==0){
		      $i = 0;
		      $lastGrade = 0;
		      
		      foreach ($classList as $class){
		      	 $grade = $class->grade;
		      		if($lastGrade == 0){
		      			echo'<div class="row" id="'.$grade.'">
		      			<div class="col s12 m2">
					        <div class="card-panel green">
					          <span class="white-text">
					          Grade: '
					          .$grade.
					          '</span>
					        </div>
				        </div>';
		      			echo $tableHeaders;
		      		} 
		      		elseif ($grade > $lastGrade) {
		      			echo $tableFooter;
		      			echo'<div class="row" id="'.$grade.'">
		      			<div class="col s12 m2">
					        <div class="card-panel green">
					          <span class="white-text">
					          Grade: '
					          .$grade.
					          '</span>
					        </div>
				        </div>';
		      			echo $tableHeaders;
		      	  }

			      echo '<tr class="content">'.
			      '<td><strong>'.ucwords(strtolower($class->name)).'</strong></td>';
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

			     $lastGrade = $grade;
		      }
		      echo $tableFooter;
		    }
		    else{
		      $i = -1;
		      $studentId = 0;
		      $lastGrade = 0;
		      //If Marks are already Entered for the list of Students then  ::  Update the Scores;
		      	foreach ($classList as $class){
		      		
		      		//Segregating Class Data with respect to the Grade.

		      		$grade = $class->grade;
		      		if($lastGrade == 0){
		      			echo'<div class="row" id="'.$grade.'">
		      			<div class="col s12 m2">
					        <div class="card-panel green">
					          <span class="white-text">
					          Grade: '
					          .$grade.
					          '</span>
					        </div>
				        </div>';
		      			echo $tableHeaders;
		      		} 
		      		elseif ($grade > $lastGrade) {
		      			echo $tableFooter;
		      			echo'<div class="row" id="'.$grade.'">
		      			<div class="col s12 m2">
					        <div class="card-panel green">
					          <span class="white-text">
					          Grade: '
					          .$grade.
					          '</span>
					        </div>
				        </div>';
		      			echo $tableHeaders;
		      		}

		      		if($class->id != $studentId){
					  $i++;
					  echo '<tr class="content">'.'<td>'.ucwords(strtolower($class->name)).'</td>';
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
					$lastGrade = $grade;
			  	}	
			  	echo $tableFooter;
		    }
		    
	    ?>
		<!--	    <tfoot class="hide-if-no-paging">
				<tr>
					<td colspan="4">
						<div class="pagination pagination-centered hide-if-no-paging"></div>
					</td>
				</tr>
			</tfoot>-->
		</table>
		    <br/>
		    <div class="row">
			    <div class="col s12 m12 text-center">
			      <button class="btn" type="submit" class="markSubmit" name="submit" >Update Scores</button>
			    </div>
			    <br/><br/>
			</div>
		</form>
	</div>
@stop
