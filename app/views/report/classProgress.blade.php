@extends('master.report')

@section('content')
	<div id="childForm">	
	<div class="col-md-12 col-sm-6 text-center"><p class="title">Select the Center and Class and Generate the Academic Report for the Selected Academic Year</p></div>
	  <form id="select-class" name="getReport" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/report/class-progress/check-report')}}}">
		  <div class="col-md-4 col-sm-6 text-center">
		  <p class="title">City</p>
		  <select name="cityId" class="edSelect" id="select-city">
			  <!-- Center list will be populated from the city table "<option value="centerId">CenterName</option>" -->
			  <?php 
			    foreach ($cityList as $city){
			      echo '<option value="'.$city->id.'">'.$city->name.'</option>';
			    }
			  ?>
		  </select>
		  </div>
		  <div class="col-md-4 col-sm-6 text-center">
		  <p class="title">Center</p>
		  <select name="centerId" class="edSelect" id="select-center-report">
			  <!-- Center list will be populated from the city table "<option value="centerId">CenterName</option>" -->
			  <?php 
			    foreach ($centerList as $center){
			      echo '<option value="'.$center->id.'">'.$center->name.'</option>';
			    }
			  ?>
		  </select>
		  </div>
		  <div class="col-md-4 col-sm-6 text-center">
		  <p class="title">Class</p>
		  <select name="levelId" class="edSelect" id="select-class-list">
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
		<br/><br/><br/>
		<div class="col-md-12 col-sm-6 text-center"><p><input type="submit" class="markSubmit" value="Generate Report"/></p></div>
	{{Form::close()}}
	
@stop
