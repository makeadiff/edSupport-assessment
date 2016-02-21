@extends('master.report')

@section('content')
	<div id="childForm">
	  <div class="row">
	  <div class="col-md-4 col-sm-6 text-center">
		      <a href="{{{URL::to('/manage/report/class-progress')}}}" class='btn btn-primary btn-dash transparent black'><img src="{{{URL::to('/img/reports.png')}}}"><br>Class Progress <br/>Report </a>
	  </div>
	  <!--<div class="col-md-4 col-sm-6 text-center">
		      <a href="{{{URL::to('manage/report/annual-impact')}}}" class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/reports.png')}}}"> <br>Annual Impact</a>
	  </div>-->
	  <div class="col-md-4 col-sm-6 text-center">
		      <a href="{{{URL::to('manage/report/generatecsv')}}}" class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/sheet.png')}}}"> <br>Generate Report</a>
	  </div>
	</div>
	
@stop
