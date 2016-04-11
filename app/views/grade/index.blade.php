@extends('master.default')
@section('link')
  
@stop

@section('content')

  <!-- "> -->
  <div class="row">
    <div class="col s12 m6 text-center item">
    	<div class="card-panel">
            <a href="{{{URL::to('manage/grading/create')}}}" class='black transparent'><img src="{{{URL::to('/img/subjects.png')}}}"><br>Create Grade Template</a>
        </div>
    </div>
    <div class="col s12 m6 text-center item">
    	<div class="card-panel">
            <a href="{{{URL::to('manage/grading/modify')}}}" class='black transparent'><img src="{{{URL::to('/img/subjects.png')}}}"><br>Update/Modify Grading Template</a>
        </div>
    </div>
  </div>
  
@stop