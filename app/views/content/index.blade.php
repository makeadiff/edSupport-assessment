@extends('master.default')
@section('title')
  
@stop

@section('content')

  <!-- "> -->
  <div class="row">
    <div class="col-md-12 col-sm-6 text-center">
                <a href='manage' class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/reports.png')}}}"/> <br>Managing<br>Scores</a>
    </div>
  </div>
  
@stop