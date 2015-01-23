@extends('master.default')
@section('content')

	<p class="title">
	  <?php
		  echo 'City Name: '.$city->name.', Center Name: '.$center->name.', Level Name: '.$level->name.'.';
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	<table><tr id="header"> <td width="40%" rowspan="2">Student Name</td>
	  <td width="20%" colspan="2">English</td>
	  <td width="20%" colspan="2">Maths</td>
	  <td width="20%" colspan="2">Science</td>
	</tr>
	<tr id="header">
	  <td width="10%" colspan="1">2013-2014</td>
	  <td width="10%" colspan="1">2014-2015</td>
	  <td width="10%" colspan="1">2013-2014</td>
	  <td width="10%" colspan="1">2014-2015</td>
	  <td width="10%" colspan="1">2013-2014</td>
	  <td width="10%" colspan="1">2014-2015</td>
	</tr>
	
	<?php
	  echo '<br/>';
	  foreach($data as $value){
	    echo'<tr class="content"><td width="40%" colspan="1">'.$value['name'].'</td>'.
		'<td width="10%" colspan="1">'.$value['eng13'].'</td>'.
		'<td width="10%" colspan="1">'.$value['eng14'].'</td>'.
		'<td width="10%" colspan="1">'.$value['math13'].'</td>'.
		'<td width="10%" colspan="1">'.$value['math14'].'</td>'.
		'<td width="10%" colspan="1">'.$value['sci13'].'</td>'.
		'<td width="10%" colspan="1">'.$value['sci14'].'</td></tr>';
	  }
	?>
		</table>
		  <br/>
		  <div class="col-md-12 col-sm-6 text-center">
		    <input type="submit" class="markSubmit" name="submit" value="Update Scores" />
		  </div>
		</div>
@stop
