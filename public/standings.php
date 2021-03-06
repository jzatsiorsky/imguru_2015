<?php

   // configuration
    require("../includes/config.php");

	// Cite this code!!!

	// Set your CSV feed
	$feed = 'https://spreadsheets.google.com/tq?tqx=out:csv&key=0AgMRlqC2ExQudHAyX0sycXdac2dxb0pWSTlndS1RRGc';
	 
	// Arrays we'll use later
	$keys = array();
	$newArray = array();
	 
	// Function to convert CSV into associative array
	function csvToArray($file, $delimiter) { 
	  if (($handle = fopen($file, 'r')) !== FALSE) { 
		$i = 0; 
		while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
		  for ($j = 0; $j < count($lineArray); $j++) { 
		    $arr[$i][$j] = $lineArray[$j]; 
		  } 
		  $i++; 
		} 
		fclose($handle); 
	  } 
	  return $arr; 
	} 
	 
	// Do it
	$data = csvToArray($feed, ',');
	 
	// Set number of elements (minus 1 because we shift off the first row)
	$count = count($data) - 1;
	 
	//Use first row for names  
	$labels = array_shift($data);  
	 
	foreach ($labels as $label) {
	  $keys[] = $label;
	}
	 
	// Add Ids, just in case we want them later
	$keys[] = 'id';
	 
	for ($i = 0; $i < $count; $i++) {
	  $data[$i][] = $i;
	}
	 
	// Bring it all together
	for ($j = 0; $j < $count; $j++) {
	  $d = array_combine($keys, $data[$j]);
	  $newArray[$j] = $d;
	}

	// Obtain a list of columns
	foreach ($newArray as $key => $row) {
		$rank[$key]  = $row['Rank'];
	}


	// Add $data as the last parameter, to sort by the common key
	array_multisort($rank, SORT_ASC, $newArray);

	// Render page
	render("standings_form.php", ["rankings" => $newArray, "title"=>"Standings"]);

 
?>
