@extends('master.default')
@section('link')
  
@stop

@section('content')

	<div class="row center">
		<p class="center title" >{{$message}}</p>
		<a class="center" href="{{{URL::to('/manage/grading/view/'.$id->id)}}}"><button class="btn teal" type="submit" class="markSubmit" name="submit" >View Template</button></a>
		<a class="center" href="{{{URL::to('/manage/')}}}"><button class="btn cyan" type="submit" class="markSubmit" name="submit" >Go Back</button></a>
	</div>
@stop