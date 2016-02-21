@extends('master.update')

@section('content')
	<div class="col s12 m12 text-center">
	    <p class="title">Select the Center and Class and Enter Marks for the Selected Academic Year</p>
	    <br/><br/>
	</div>
	
	<div id="childForm">	
	<div class="row">  
	    <form id="select-class" name="selectClass" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/assessment/')}}}">
	    <div class="input-field col s12 m6 text-center">
	    	<p class="title">Center</p>
	      	<select name="centerId">
			<?php 
		  	foreach ($centerList as $center){
			    echo '<option value="'.$center->id.'">'.$center->name.'</option>';
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
	
@stop
