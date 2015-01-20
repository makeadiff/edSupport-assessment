@extends('master.default')
@section('title')
  
@stop

@section('content')

  <!--  -->
  <div class="row">
    <div class="col-md-6 col-sm-6 text-center">
                <a href='manage/update' class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/subjects.png')}}}"><br>Update Class <br/>Scores</a>
    </div>
    <div class="col-md-6 col-sm-6 text-center">
                <a href='manage/report' class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/reports.png')}}}"> <br>Reports</a>
    </div>
  </div>
  
@stop