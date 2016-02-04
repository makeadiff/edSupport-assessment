@extends('master.update')

@section('content')
	<div class="col-md-12 col-sm-6 text-center">
	    <p class="title">Select the Center and Class and Enter Marks for the Selected Academic Year</p>
	    <br/><br/>
	</div>
	
	<div id="childForm">	
	  
	    <form id="select-class" name="selectClass" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/assessment/')}}}">
		  <div class="col-md-6 col-sm-6 text-center">
		    <p class="title">Center</p>
		      <select name="centerId" class="edSelect" id="select-center">
			<?php 
			  foreach ($centerList as $center){
			    echo '<option value="'.$center->id.'">'.$center->name.'</option>';
			  }
			?>
		      </select>
		  </div>
		    <div class="col-md-6 col-sm-6 text-center">
		      <p class="title">Year</p>
		      <select name="year" class="edSelect" id="select-year">
				<option value="2013">2013-2014</option>
				<option value="2014">2014-2015</option>
				<option value="2015">2015-2016</option>
		      </select>
		    </div>
		    <!--<div class="col-md-4 col-sm-6 text-center">
		      <p class="title">Class</p>
		      <select name="levelId" class="edSelect" id="classSelected">
			<?php 
			  /*foreach ($classList as $class){
			      echo '<option value="'.$class->id.'">'.$class->grade.' - '.$class->name.'</option>';
			  }*/
			?> 
		      </select>
		    </div>-->
		    
		    <br/>
	</div>
		<div class="col-md-12 col-sm-6 text-center"><p><input type="submit" class="markSubmit" value="Proceed"/></p></div>
	{{Form::close()}}
	
@stop
