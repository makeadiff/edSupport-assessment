@extends('master.default')
@section('link')
  
@stop

@section('content')

  <!-- "> -->
  <div class="row">
    <div class="col-md-12 col-sm-6 text-center">
                <a href='manage' class='btn btn-primary btn-dash transparent'><img src="{{{URL::to('/img/reports.png')}}}"/> <br>Manage<br>Scores</a>
    </div>
  </div>
  
@stop