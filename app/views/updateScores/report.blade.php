
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

	<div class="row center" id="fixed-top-div">
		
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
		<div class="container center" id="updateSuccess"></div>
	</div>

	<div class="row" style="padding-top:50px;">  
	    <form id="select-class" name="selectClass" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/assessment/')}}}">
	    <p class="title">
			  <?php
				  echo 'Center Name: '.ucwords($centerName->name).' | Year: '.$year.'-'.($year+1);
			  ?>
		</p>

	    <div class="input-field col s12 m6 text-center">
		    <p class="title">Center</p>
	      	<select name="centerId">
			<?php 
		  	foreach ($centerList as $center){
			    echo '<option value="'.$center->id.'" '.($centerName->id == $center->id?'selected':'').'>'.$center->name.'</option>';
		  	}
			?>
	      	</select>
	  	</div>
	    <div class="input-field col s12 m6 text-center">
	      	<p class="title">Year</p>
	      	<select name="year">
				<option value="2015">2015-2016</option>
				<option value="2014">2014-2015</option>
				<option value="2013">2013-2014</option>
	      	</select>
	    </div>
		    
		    <br/>
	</div>
		<div class="col s12 m12 text-center"><p><button class="btn light-waves" type="submit" class="markSubmit">Proceed</button></p></div>
	</form>
	

	


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
					    <td width="10%">Not Available</td>
					  </tr>
					  <tr id="header">
					    <td width="10%">OT</td>
					    <td width="10%">Other Reasons</td>
					  </tr>
					  <tr id="header">
					    <td width="10%">P</td>
					    <td width="10%">Pass</td>
					  </tr>
					  <tr id="header">
					    <td width="10%">F</td>
					    <td width="10%">Fail</td>
					  </tr>
					  <tr id="header">
					    <td width="10%">RE</td>
					    <td width="10%">Re-Exams</td>
					  </tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!--
		Fetching the data for all the students in the mentioned center.
	 -->
	
	<div class="container center" id="updateSuccess"></div>

	<form name="updateScores" id="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form" onsubmit="return ValidateMarkForm()">
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
				        </div>'.
				        '<div class="col s12 m4">
				        	<br/>
				        	<select name="grade_template'.$grade.'">
				        	<option value="0" disabled selected>--Select Grading Template--</option>'
				        	.'<option value="-1" selected>Marks</option>'
				        	.'<option value="-2">GPA</option>';
				        	foreach ($grading_templates as $template) { 
				        		echo '<option value='.$template->id.'>'.$template->name.'</option>';
				        	}
				        	echo '</select>
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
				        </div>'.
				        '<div class="col s12 m4">
				        	<br/>
				        	<select name="grade_template'.$grade.'">
				        	<option value="0"disabled selected>--Select Grading Template--</option>'
				        	.'<option value="-1" selected>Marks</option>'
				        	.'<option value="-2">GPA</option>';
				        	foreach ($grading_templates as $template) { 
				        		echo '<option value='.$template->id.'>'.$template->name.'</option>';
				        	}
				        	echo '</select>
				        </div>';
		      			echo $tableHeaders;
		      	  }

			      echo '<tr class="content">'.
			      '<td><strong>'.ucwords(strtolower($class->name)).''.PHP_EOL.
			      '<select class="gradeSelect" name="grade_template'.$grade.'" id="template'.$i.'">'.PHP_EOL.
				        	'<option value="0" disabled selected>--Select Grading Template--</option>'.PHP_EOL
				        	.'<option value="-1" selected>Marks</option>'.PHP_EOL
				        	.'<option value="-2">GPA</option>'.PHP_EOL;
				        	foreach ($grading_templates as $template) { 
				        		echo '<option value='.$template->id.'>'.$template->name.'</option>'.PHP_EOL;
				        	}
				        	echo '</select>'.'</strong></td>';
			      echo '<td>'.
				  '<input class="studentId" type="hidden" value="'.$class->id.'" name="studentId'.$i.'">'.
				  '<input class="markInput secured " type="text" value="" name="engScore'.$i.'"/>/'.
				  '<input class="markInput" type="number" value="100" max="100" min="0" name="totalEng'.$i.'"/></td>'.
				  '<td><input class="markInput secured " type="text" value="" name="mathScore'.$i.'"/>/'.
				  '<input class="markInput" type="number" value="100" max="100" min="0" name="totalMath'.$i.'"/></td>'.
				  '<td><input class="markInput secured " type="text" value="" name="sciScore'.$i.'"/>/'.
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
				        </div>'.
				        '<div class="col s12 m4">
				        	<br/>
				        	<select name="grade_template'.$grade.'">
				        	<option value="0"disabled selected>--Select Grading Template--</option>'
				        	.'<option value="-1" selected>Marks</option>'
				        	.'<option value="-2">GPA</option>';
				        	foreach ($grading_templates as $template) { 
				        		echo '<option value='.$template->id.'>'.$template->name.'</option>';
				        	}
				        	echo '</select>
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
				        </div>'.
				        '<div class="col s12 m4">
				        	<br/>
				        	<select name="grade_template'.$grade.'">
				        	<option value="0"disabled selected>--Select Grading Template--</option>'
				        	.'<option value="-1" selected>Marks</option>'
				        	.'<option value="-2">GPA</option>';
				        	foreach ($grading_templates as $template) { 
				        		echo '<option value='.$template->id.'>'.$template->name.'</option>';
				        	}
				        	echo '</select>
				        </div>';
		      			echo $tableHeaders;
		      		}

		      		if($class->id != $studentId){
					  $i++;
					  echo '<tr class="content">'.
			      		'<td><strong>'.ucwords(strtolower($class->name)).''.PHP_EOL.
			      		'<select class="gradeSelect" name="grade_template'.$grade.'" id="template'.$i.'">'.PHP_EOL.
				        '<option value="0" disabled selected>--Select Grading Template--</option>'.PHP_EOL
				        .'<option value="-1" selected>Marks</option>'.PHP_EOL
				        .'<option value="-2">GPA</option>'.PHP_EOL;
				        foreach ($grading_templates as $template) { 
				        	echo '<option value='.$template->id.'>'.$template->name.'</option>'.PHP_EOL;
				        }
				        	
				      echo '</select>'.'</strong></td>';
					  echo '<td>'.'<input class="studentId" type="hidden" value="'.$class->id.'" name="studentId'.$i.'"/>';		      
					}
					if($class->subject_id == 8){
					  if($class->marks == '-1' ) $class->marks='';
					  if($class->marks == '-2' ) $class->marks='AB';
					  if($class->marks == '-3' ) $class->marks='NA';
					  if($class->marks == '-4' ) $class->marks='OT';

					  echo '<input class="markInput secured" type="text" value="'.$class->marks.'" name="engScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalEng'.$i.'"/></td>';
					}
					else if($class->subject_id == 9){
					  if($class->marks == '-1') $class->marks='';
					  if($class->marks == '-2' ) $class->marks='AB';
					  if($class->marks == '-3' ) $class->marks='NA';
					  if($class->marks == '-4' ) $class->marks='OT';
					  
					  echo '<td><input class="markInput secured" type="text" value="'.$class->marks.'" name="mathScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalMath'.$i.'"/></td>';
					}
					else if($class->subject_id == 10){
					  if($class->marks == '-1' ) $class->marks='';
					  if($class->marks == '-2' ) $class->marks='AB';
					  if($class->marks == '-3' ) $class->marks='NA';
					  if($class->marks == '-4' ) $class->marks='OT';
					  
					  echo '<td><input class="markInput secured" type="text" value="'.$class->marks.'" name="sciScore'.$i.'" maxlength="3"/>/'.'<input class="markInput total" type="number" value="'.$class->total.'" max="100" min="0" name="totalSci'.$i.'"/></td>'.'</tr>';
					}
					$studentId=$class->id;
					$lastGrade = $grade;
			  	}	
			  	echo $tableFooter;
		    }
		    
	    ?>

	    <div class="row">
	    <br/><br/>
	    	<p class="center">Incase of unavailability of marks, please update a detailed reason here.</p>
	    	<textarea name="reason" placeholder="Reason" rows="5"></textarea>
	    </div>

		<!--	    <tfoot class="hide-if-no-paging">
				<tr>
					<td colspan="4">
						<div class="pagination pagination-centered hide-if-no-paging"></div>
					</td>
				</tr>
			</tfoot>-->
		</table>
		    <br/>
		    <noscript>
		    <div class="row">
			    <div class="col s12 m12 text-center">
			      <input type="hidden" name="count" id="input_count" value="1"/>
			      <button class="btn" type="submit" class="markSubmit" name="submit" >Update Scores</button>
			    </div>
			    <br/><br/>
			</div>
			</noscript>
		</form>
	</div>
@stop
