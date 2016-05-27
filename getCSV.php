<?php
	
	header("Content-type: text/plain")

	$url = 'http://makeadiff.in/apps/edsupport-assessment/public/manage/getcsv';
	$contents = load($url);

	print $contents;


?>
