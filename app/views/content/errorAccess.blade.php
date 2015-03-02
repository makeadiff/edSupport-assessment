@extends('master.default')

@section('content')

  <div class="container-fluid">
      <div class="centered">
	  <br>
	  <br>
	  <h1 class="title">Oops!</h1>
	  <br>
	  <div class="row">
	      <p class="success">
		  {{$message}}
	      </p>
	  </div>
	  <br>
	  <div class="row">
	      <a href="{{{URL::to('/manage/update')}}}" class='btn btn-primary btn-lg transparent'>Back to Home</a>
	  </div>
      </div>
  </div>

@stop
