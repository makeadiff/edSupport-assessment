@extends('master.default')

@section('content')
	<div id="childForm">
	  <div class="row">
	  <div class="col-md-6 col-sm-6 text-center">
		      <a href="{{{URL::to('/manage/report/class-progress')}}}" class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/reports.png')}}}"><br>Class Progress <br/>Report </a>
	  </div>
	  <div class="col-md-6 col-sm-6 text-center">
		      <a href="{{{URL::to('manage/report')}}}" class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/reports.png')}}}"> <br>Annual Impact</a>
	  </div>
	</div>
	
@stop
