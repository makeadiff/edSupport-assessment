@extends('master.default')
@section('link')
  
@stop

@section('content')

  <!-- "> -->
  <div class="containter">
    <form id="grade-template" name="grade-template" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/grading/createTemplate/')}}}" onsubmit="return validate()">
      <div class="row">
        <p class="title center">Create Grading Template</p>
        <div class="input-field col s12 m4 text-center">
          <p class="title">State</p>
          <select name="centerName" id="centerName" class="assessmentInput" onchange="concat()">
            <option value="" disabled selected>--Select--</option>
            <?php 
              foreach ($states as $state){ //Populating List of States.
                echo '<option value="'.$state->name.'">'.$state->name.'</option>';
              }
            ?>
          </select>
        </div>
        <div class="input-field col s12 m4 text-center">
            <p class="title">Board</p>
            <input class="assessmentInput" placeholder="CBSE" onchange="concat()" id="boardName" required="required" />
        </div>
        <div class="input-field col s12 m4 text-center">
            <p class="title">Grade</p>
            <input class="assessmentInput" placeholder="7 to 10" onchange="concat()" id="gradeName" required="required" />
        </div>
      </div>

      <div class="row">
        <p class="title">Grade Template Name</p>
        <input type="text" style="color:#000;" class="center" readonly="readonly" id="gradeNameConcated" name="gradeNameConcated">
      </div>

      <div class="row">
        <table class="footable" id="gradeTable">
          <thead id="header" class="TextCenter center">
            <th>Lower Mark Limit</th>
            <th>Upper Mark Limit</th>
            <th>Grade</th>
          </thead>
          <tbody id="tableBody">
            <tr class="content">
              <td>
                <input type="number" name="lower0" value="" placeholder="90" min="0" required>
              </td>
              <td>
                <input type="number" name="upper0" value="" placeholder="100" min="0" required>
              </td>
              <td>
                <input type="text" name="grade0" maxlength="2" required>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="row">
          <div class="col s12 m12 text-center">
            <br/>
              <input type="hidden" value="1" name="count" id="count">
              <button class="btn cyan" type="button" id="addMoreRows">Add more rows</button>
              <button class="btn cyan" type="button" id="removeRows">Remove rows</button>
              <button class="btn teal" type="submit" class="markSubmit" name="submit" >Create Template</button>
          </div>
          <br/><br/>
        </div>
        </div>
      </div>
    </form>
  </div>  
@stop