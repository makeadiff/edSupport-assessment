@extends('master.report')

@section('content')
	
	<div class="row">
	    <div class="col s12 m6 text-center item">
	    	<div class="card-panel">
	            <a href="{{{URL::to('/manage/report/class-progress')}}}" class='btn btn-primary btn-dash transparent black'><img src="{{{URL::to('/img/reports.png')}}}"><br>Class Progress <br/>Report </a>
	        </div>
	    </div>
	    <div class="col s12 m6 text-center item">
	    	<div class="card-panel">
	            <a href="{{{URL::to('manage/report/generatecsv')}}}" class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/sheet.png')}}}"> <br>Generate Report</a>
	        </div>
	    </div>
  	</div>
	
@stop
