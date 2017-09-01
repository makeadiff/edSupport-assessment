@extends('master.default')
@section('link')
  
@stop

@section('content')

	<div class="row center">
		<p class="title">Template Name: {{$templateName->name}}</p>

		<table class="footable" id="gradeTable">
          <thead id="header" class="TextCenter center">
            <th>Lower Mark Limit</th>
            <th>Upper Mark Limit</th>
            <th>Grade</th>
          </thead>
          <tbody id="tableBody">
            <?php 
            	
            	foreach ($template as $value) {
		            echo '<tr class="content">
		              <td>'.$value->from_mark.'</td>
		              <td>'.$value->to_mark.'</td>
		              <td>'.$value->grade.'</td>
		            </tr>';
            	}
            ?>
          </tbody>
        </table>

	</div>
@stop