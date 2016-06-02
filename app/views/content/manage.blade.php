@extends('master.default')
@section('title')
  
@stop

@section('content')

  <!--  -->
  <div class="row" style="margin-top:50px">
    <div class="col s12 m6 text-center item">
    	<div class="card-panel">
            <a href="{{{URL::to('manage/update')}}}" class='black transparent'><img src="{{{URL::to('/img/subjects.png')}}}"><br>Update ClassScores</a>
        </div>
    </div>
    <div class="col s12 m6 text-center item">
    	<div class="card-panel">
            <a href="{{{URL::to('manage/grading')}}}" class='black transparent'><img src="{{{URL::to('/img/subjects.png')}}}"><br>Grading Templates</a>
        </div>
    </div>
    <!--<div class="col s12 m4 text-center item">
    	<div class="card-panel">
            <a href="{{{URL::to('manage/report')}}}" class='black transparent'><img src="{{{URL::to('/img/reports.png')}}}"> <br>Reports</a>
        </div>
    </div>-->
  </div>
  
@stop