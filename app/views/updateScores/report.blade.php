
@extends('master.update')

@section('content')

<div class="cover"></div>

<?php

	$tableHeaders = '<table class="footable">
			<thead id="header" class="TextCenter center">      
		    <th width="40%">Student Name</th>
		    <th class="center" data-hide="phone" data-name="English" width="20%">ENGLISH  <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    <th class="center" data-hide="phone" data-name="Math" width="20%">MATH <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    <th class="center" data-hide="phone" data-name="Science" width="20%">SCIENCE <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    
		</thead><tbody>';
		/*<th class="center" data-hide="phone" data-name="Biology" width="13%">BIOLOGY  <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    <th class="center" data-hide="phone" data-name="Chemistry" width="13%">CHEMISTRY <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>
		    <th class="center" data-hide="phone" data-name="Physics" width="14%">PHYSICS <br/> Total: <input class="markInput" type="number" value="100" max="200" min="0" name="totalEng"/></th>*/
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

			  
		</p/>

	    <div class="input-field col s12 m6 text-center">
		    <p class="title">Center</p>
	      	<select name="centerId" id="centerId">
			<?php 
		  	foreach ($centerList as $center){
			    echo '<option value="'.$center->id.'" '.($centerName->id == $center->id?'selected':'').'>'.$center->name.'</option>';
		  	}
			?>
	      	</select>
	  	</div>
	    <div class="input-field col s12 m6 text-center">
	      	<p class="title">Year</p>
	      	<select name="year" id="year">
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
					<p>*While using any of the abbreviations above, change the Grade Template to 'MARKS'</p>
				</div>
			</div>
		</div>
	</div>

	<!--
		Fetching the data for all the students in the mentioned center.
	 -->
	
	<div class="container center" id="updateSuccess"></div>

	<form name="updateScores" id="updateScores" action="{{{URL::to('/manage/assessment/update')}}}" method="post" role="form">
	    <?php
	      echo '<input type="hidden" name="year" value="'.$year.'"/>';
	      echo '<br/>';
		?> 

		<input type="hidden" name="center_id" value="{{$centerName->id}}">
	
		<?php
		    $i = 0;
		    $lastGrade = 0;
		    
		    foreach ($classList as $class){
	      	 	switch ($class['english_mark']) {
	      			case '-1':
	      				$class['english_mark'] = '';
	      				break;
	      			case '-2':
	      				$class['english_mark'] = 'AB';
	      				break;
	      			case '-3':
	      				$class['english_mark'] = 'NA';
	      				break;
	      			case '-4':
	      				$class['english_mark'] = 'OT';
	      				break;
	      			case '-5':
	      				$class['english_mark'] = 'P';
	      				break;
	      			case '-6':
	      				$class['english_mark'] = 'F';
	      				break;
	      			case '-7':
	      				$class['english_mark'] = 'RE';
	      				break;
	      			default:
	      				break;
	      		}

	      		switch ($class['math_mark']) {
					case '-1':
						$class['math_mark'] = '';
						break;
					case '-2':
						$class['math_mark'] = 'AB';
						break;
					case '-3':
						$class['math_mark'] = 'NA';
						break;
					case '-4':
						$class['math_mark'] = 'OT';
						break;
					case '-5':
						$class['math_mark'] = 'P';
						break;
					case '-6':
						$class['math_mark'] = 'F';
						break;
					case '-7':
						$class['math_mark'] = 'RE';
						break;
					default:
						break;
				}

				switch ($class['science_mark']) {
					case '-1':
						$class['science_mark'] = '';
						break;
					case '-2':
						$class['science_mark'] = 'AB';
						break;
					case '-3':
						$class['science_mark'] = 'NA';
						break;
					case '-4':
						$class['science_mark'] = 'OT';
						break;
					case '-5':
						$class['science_mark'] = 'P';
						break;
					case '-6':
						$class['science_mark'] = 'F';
						break;
					case '-7':
						$class['science_mark'] = 'RE';
						break;
					default:
						break;
				}

		      	$grade = $class['grade'];
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
				        	<select class="masterSelect" name="grade_template'.$grade.'" id="grade_template'.$grade.'">
				        	<option value="0" disabled selected>--Select Grading Template--</option>'
				        	.'<option value="-1" selected>Marks</option>'
				        	.'<option value="-2">CGPA</option>';
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
				        	<select class="masterSelect" name="grade_template'.$grade.'" id="grade_template'.$grade.'">
				        	<option value="0"disabled selected>--Select Grading Template--</option>'
				        	.'<option value="-1" selected>Marks</option>'
				        	.'<option value="-2">CGPA</option>';
				        	foreach ($grading_templates as $template) { 
				        		echo '<option value='.$template->id.'>'.$template->name.'</option>';
				        	}
				        	echo '</select>
				        </div>';
		      			echo $tableHeaders;
		      	  }

			    echo '<tr class="content">'.
			      '<td><strong>'.ucwords(strtolower($class['name'])).''.PHP_EOL.
			      '<select class="gradeSelect studentGrade grade_template'.$grade.'" name="template'.$i.'" id="template'.$i.'">'.PHP_EOL.
				        '<option value="0" disabled>--Select Grading Template--</option>'.PHP_EOL
				        .'<option value="-1" '.($class['template_id']==-1?'selected':'').'>Marks</option>'.PHP_EOL
				        .'<option value="-2"'.($class['template_id']==-2?'selected':'').'>CGPA</option>'.PHP_EOL;
				        foreach ($grading_templates as $template) { 
				        	echo '<option value="'.$template->id.'"'.($class['template_id']==$template->id?'selected':'').'>'.$template->name.'</option>'.PHP_EOL;
				        }
				echo '</select>'.'</strong></td>';
			    echo '<td class="mark_data">'.
				  '<input type="hidden" value="'.$class['name'].'" id="studentName'.$i.'" name="studentName'.$i.'">'.PHP_EOL.
				  '<input type="hidden" value="'.$class['id'].'" name="studentId'.$i.'">'.PHP_EOL.
				  '<input class="markInput secured " type="text" value="'.$class['english_mark'].'" id="engScore'.$i.'" name="engScore'.$i.'"/>
				  <span class="total'.$i.'">/</span>'.
				  '<input class="markInput" type="number" value="'.$class['english_total'].'" max="100" min="0" id="totalEng'.$i.'" name="totalEng'.$i.'"/></td>'.
				  '<td class="mark_data"><input class="markInput secured " type="text" value="'.$class['math_mark'].'" id="mathScore'.$i.'" name="mathScore'.$i.'"/><span class="total'.$i.'">/</span>'.
				  '<input class="markInput" type="number" value="'.$class['math_total'].'" max="100" min="0" id="totalMath'.$i.'" name="totalMath'.$i.'"/></td>'.
				  '<td class="mark_data"><input class="markInput secured " type="text" value="'.$class['science_mark'].'" id="sciScore'.$i.'" name="sciScore'.$i.'"/><span class="total'.$i.'">/</span>'.
				  '<input class="markInput" type="number" value="'.$class['science_total'].'" max="100" min="0" id="totalSci'.$i.'" name="totalSci'.$i.'"/></td>'.
				'</tr>';
			      $i++;

			     $lastGrade = $grade;
		      }
		    echo $tableFooter;
		    
	    ?>

	    <div class="row">
	    <br/><br/>
	    	<p class="center">Incase of unavailability of marks, please update a detailed reason here. (Press TAB once you update the Reason)</p>
	    	<textarea name="reason" placeholder="Reason" rows="5"><?php
	    			if(isset($center_reason)) echo $center_reason->reason;
	    		?></textarea>
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
		    <noscript>-->
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
