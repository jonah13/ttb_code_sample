<?php
//var_dump($headers);
//var_dump($data);
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename.".csv");

$output = fopen("php://output", 'w');

if(isset($headers)){
  if(is_array($headers)){
  fputcsv($output, $headers);
  }
}		

if(isset($data)){	 
  if(is_array($data)){
	  foreach ($data as $key=>$value) {
		 				$data[$key] = preg_replace('/^\s+|\n|\r|\s+$/m', '', $value);
		}
    foreach ($data as $fields) {
    				fputcsv($output, $fields);
		}
	}
}		
exit();