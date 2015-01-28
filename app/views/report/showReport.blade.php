@extends('master.default')
@section('content')

	<p class="title">
	  <?php
		  echo 'City Name: '.$city->name.', Center Name: '.$center->name.', Level Name: '.$level->name.'.';
	  ?>
	</p>
	<div class="row" id="scoreUpdate">
	<table class="footable" width="100%">
	  <thead id="header">
	    <th width="10%">Grade</th>
	    <th data-hide="phone" width="10%">A1</th>
	    <th data-hide="phone" width="10%">A2</th>
	    <th data-hide="phone" width="10%">B1</th>
	    <th data-hide="phone" width="10%">B2</th>
	    <th data-hide="phone" width="10%">C1</th>
	    <th data-hide="phone" width="10%">C2</th>
	    <th data-hide="phone" width="10%">D</th>
	    <th data-hide="phone" width="10%">E1</th>
	    <th data-hide="phone" width="10%">E2</th>
	  </thead>
	  <tr id="header">
	    <td width="10%">Mark Range</td>
	    <td width="10%">91-100</td>
	    <td width="10%">81-90</td>
	    <td width="10%">71-80</td>
	    <td width="10%">61-70</td>
	    <td width="10%">51-60</td>
	    <td width="10%">41-50</td>
	    <td width="10%">33-40</td>
	    <td width="10%">21-32</td>
	    <td width="10%">0-20</td>
	  </tr>
	</table>
	<table><tr id="header"> <td width="40%" rowspan="2">Student Name</td>
	  <td width="20%" colspan="2">English</td>
	  <td width="20%" colspan="2">Maths</td>
	  <td width="20%" colspan="2">Science</td>
	</tr>
	<tr id="header">
	  <td width="10%" colspan="1">2013-14</td>
	  <td width="10%" colspan="1">2014-15</td>
	  <td width="10%" colspan="1">2013-14</td>
	  <td width="10%" colspan="1">2014-15</td>
	  <td width="10%" colspan="1">2013-14</td>
	  <td width="10%" colspan="1">2014-15</td>
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
		    <div class="col-md-12 col-sm-6 text-center"></div>
		</div>
@stop
