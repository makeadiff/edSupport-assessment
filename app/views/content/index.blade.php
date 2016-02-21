@extends('master.default')
@section('link')
  
@stop

@section('content')

  <!-- "> -->
  <div class="row">
    <div class="col s12 m12 text-center">
                <a href='manage' class='black transparent'><img src="{{{URL::to('/img/reports.png')}}}"/> <br>Manage Scores</a>
    </div>
  </div>
  
@stop