@extends('master.default')
@section('link')
  
@stop

@section('content')

  <!-- "> -->
  @if(!isset($message))
  <div class="containter">
    <form id="grade-template" name="grade-template" role="form" method="post" enctype="multipart/form-data" action="{{{URL::to('manage/grading/createTemplate/')}}}" onsubmit="return validate()">
      <div class="row">
        <p class="title center">Grading Templates</p>
      </div>

      <div class="row">
        <table class="footable" id="gradeTable">
          <thead id="header" class="TextCenter center">
            <th>#</th>
            <th>Template Name</th>
            <th>Actions</th>
          </thead>
          <tbody id="tableBody">
            <?php
            $i = 1;
            foreach ($templates as $template) {
              
              echo '<tr class="content">
              <td width="10%" style="color:#039be5;">
                '.$i.'
              </td>
              <td width="70%" class="fancybox" id="'.$template->id.'"><a href="'.URL::to('/manage/grading/view/'.$template->id).'"> 
                '.$template->name.'</a>
              </td>
              <td width="20%" style="text-align:center;">
                <a href="'.URL::to('/manage/grading/view/'.$template->id).'"><i class="material-icons">open_in_new</i></a>
                &nbsp; &nbsp; &nbsp;  
                <a href="'.URL::to('/manage/grading/modify/'.$template->id).'"><i class="material-icons">mode_edit</i></a>
                &nbsp; &nbsp; &nbsp; 
                <a href="'.URL::to('/manage/grading/modify/delete/'.$template->id).'"><i class="material-icons">delete</i></a>
              </td>
            </tr>';
            $i++;  
            }
            
            ?>
          </tbody>
        </table>
        </div>
      </div>
    </form>
  </div>  
  @else
  <p class="center">{{$message}}</p>
  @endif
@stop