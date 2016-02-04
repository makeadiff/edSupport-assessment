@extends('master.default')

@section('content')

  <div class="container-fluid">
      <div class="centered">
	  <br>
	  <br>
	  <h1 class="title"></h1>
	  <br>
	  <div class="row">
	      <p class="success">
		  {{$message}}
	      </p>
	  </div>
	  <br>
		  <div class="row">
			  <div class="row">
			      <a href="http://makeadiff.in/madapp/index.php/edsupport/dashboard_view" class='btn btn-primary btn-lg transparent'>Back to Home</a> &nbsp; <a href="{{{URL::to('/manage/update')}}}" class='btn btn-primary btn-lg transparent'>Update Scores</a>
			  </div>
	      </div>
      </div>
  </div>

@stop
