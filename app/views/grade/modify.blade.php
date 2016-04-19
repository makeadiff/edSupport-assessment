@extends('master.default')
@section('link')
  
@stop

@section('content')

	<div class="row center">
		<p class="title">Template Name: {{$templateName->name}}</p>
    <form id="grade-template" name="grade-template" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/grading/editTemplate/')}}}" onsubmit="return validate()">
      <table class="footable" id="gradeTable">
        <thead id="header" class="TextCenter center">
          <th>Lower Mark Limit</th>
          <th>Upper Mark Limit</th>
          <th>Grade</th>
        </thead>
        <tbody id="tableBody">
          <?php 
          	$i = 0;
          	foreach ($template as $value) {
              echo '<td>
              <input type="number" name="lower'.$i.'" placeholder="90" min="0" required value="'.$value->from_mark.'">
            </td>
            <td>
              <input type="number" name="upper'.$i.'" placeholder="100" min="0" required value="'.$value->to_mark.'">
            </td>
            <td>
              <input type="text" name="grade'.$i.'" maxlength="2" required value="'.$value->grade.'">
            </td>
          </tr>';
            $i++;
          	}
          echo '<input type="hidden" value="'.$i.'" name="count" id="count">';
          ?>
        </tbody>
      </table>
  </div>
  <div class="row">
    <div class="col s12 m12 text-center">
      <br/>
        <input type="hidden" style="color:#000;" class="center" readonly="readonly" id="gradeNameConcated" name="gradeNameConcated" value="{{$templateName->name}}">
        <button class="btn cyan" type="button" id="addMoreRows">Add more rows</button>
        <button class="btn cyan" type="button" id="removeRows">Remove rows</button>
        <button class="btn teal" type="submit" class="markSubmit" name="submit" >Update Template</button>
    </div>
    </form>
    <br/><br/>
  </div>

	</div>
@stop