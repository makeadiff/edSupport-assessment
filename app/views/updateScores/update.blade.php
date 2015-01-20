@extends('master.default')

@section('content')
	<div id="childForm">	
	  <form id="select-class" name="selectClass" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/assessment/')}}}">
		  <div class="col-md-4 col-sm-6 text-center">
		  <p class="title">Center</p>
		  <select name="centerId" class="edSelect" id="select-center">
			  <!-- Center list will be populated from the city table "<option value="centerId">CenterName</option>" -->
			  <?php 
			    foreach ($centerList as $center){
			      echo '<option value="'.$center->id.'">'.$center->name.'</option>';
			    }
			  ?>
		  </select>
		  </div>
		  <div class="col-md-4 col-sm-6 text-center">
		  <p class="title">Year</p>
		  <select name="year" class="edSelect" id="select-year">
			  <?php 
			    foreach ($year as $yr){
			      echo '<option value="'.$yr->year.'">'.$yr->year.'-'.($yr->year+1).'</option>';
			    }
			  ?> 
		  </select>
		  </div>
		  <div class="col-md-4 col-sm-6 text-center">
		  <p class="title">Class</p>
		  <select name="levelId" class="edSelect" id="classSelected">
			  <?php 
			    foreach ($classList as $class){
				echo '<option value="'.$class->id.'">'.$class->name.'</option>';
			    }
			  ?> 
		  </select>
		  </div>
		  
		  <br/>
	  </div>
	</div>	
	<div class="row">
		<br/><br/>
		<div class="col-md-12 col-sm-6 text-center"><p><input type="submit" class="markSubmit" value="Proceed"/></p></div>
	{{Form::close()}}
	
@stop
