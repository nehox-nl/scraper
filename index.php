<?php
// Includes
include('include/simple_html_dom.php');

// Get raw HTML from source
$html1 = file_get_html('https://www.tsviewer.com/index.php?page=userhistory&ID=1083286');
$html2 = file_get_html('https://www.tsviewer.com/index.php?page=ts_viewer&ID=1083286');

// Create empty arrays
$ar_uniqueUsersLastWeek = array();
$ar_uptime = array();

// Find the DIV tag with the subsection class || Unique Users Last Week || index[0] = Unique players last week
foreach($html1->find('div[class="subsection"]') as $element)
		array_push($ar_uniqueUsersLastWeek,$element);
// Find the DIV with the ID leftPanel || Total Unique Users ||
foreach($html2->find('span[id=virtualserver_client_connections]') as $element)
		echo $element . "test1<br>";
		//array_push($ar_uniqueUsersLastWeek,$element);
// Find the DIV with the ID leftPanel || Total Channels ||
foreach($html2->find('span[id=virtualserver_channelsonline]') as $element)
		echo $element->span . "test2<br>";
// Find the DIV with the ID leftPanel || Uptime || index[21] = uptime % last week. 
foreach($html2->find('span') as $element)
		array_push($ar_uptime, $element);

// Filter everything except the numbers for Unique Users Last Week
	$uniqueUsersLastWeek = preg_replace("/[^0-9]+/", "", $ar_uniqueUsersLastWeek[0]);
// Filter everything except the numbers for Unique Users Last Week
	$uniqueUsers = preg_replace("/[^0-9.]+/", "", "Unique total users: 2134"); // Dummy value
// Filter everything except the numbers for Unique Users Last Week
	$channels = preg_replace("/[^0-9]+/", "", "total channels: 117"); // Dummy value
// Filter everything except the numbers for Unique Users Last Week
	$uptime = preg_replace("/[^0-9.]+/", "", $ar_uptime[21]);

// Write data to CSV (.txt) file
$dataFile = fopen("output/data.txt", "w") or die("Unable to open file!");
	$txt =	$uniqueUsersLastWeek . "," . 
			$uniqueUsers . ",". 
			$channels . "," . 
			$uptime;
	fwrite($dataFile, $txt);
fclose($dataFile); 

// Print output (DEBUGGING)
echo("Data written to file.");
echo("<br><br>");
echo("Unique users last week: <b>" 	. $uniqueUsersLastWeek . "</b>");
echo("<br>");
echo("Unique users total: <b>" 		. $uniqueUsers . "</b>");
echo("<br>");
echo("Total channels: <b>" 			. $channels . "</b>");
echo("<br>");
echo("Uptime last week: <b>" 		. $uptime . "% </b>");
?>