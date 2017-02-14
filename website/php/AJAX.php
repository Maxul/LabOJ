<?php

function wrap($status) {
	switch ($status[0]) {
		case 'A': return '<span class="status-ac">' . $status . '</span>';
		case 'P': return '<span class="status-pe">' . $status . '</span>';
		case 'M': return '<span class="status-mle">' . $status . '</span>';
		case 'T': return '<span class="status-tle">' . $status . '</span>';
		case 'W': return '<span class="status-wa">' . $status . '</span>';
		case 'R': return '<span class="status-re">' . $status . '</span>';
		case 'O': return '<span class="status-ole">' . $status . '</span>';
		case 'C': return '<span class="status-ce">' . $status . '</span>';

		default: break;
	}
}

$ret = array(
	'<span class="status-ac">Accepted</span>',
	'<span class="status-pe">Presentation Error</span>',
	'<span class="status-mle">Memory Limit Exceed</span>',
	'<span class="status-tle">Time Limit Exceed</span>',
	'<span class="status-wa">Wrong Answer</span>',
	'<span class="status-re">Runtime Error</span>',
	'<span class="status-ole">Output Limit Exceed</span>',
	'<span class="status-ce">Compile Error</span>',
	'System Error');

// get the q parameter from URL
$result = $_REQUEST["query"];
$problem = $_REQUEST["text"];

if ($problem != "") {
	$des_path = "../../problems/$problem/description";

	if (file_exists($des_path) && (fileperms($des_path) & 0x0004)) {
		echo "<center><h2>$problem</h2></center>";
		echo "<pre><h3>" . file_get_contents($des_path) . "</h3></pre>";
	}
}

// lookup all hints from array if $result is different from "" 
if ($result != "" && $result !== "choose one") {
	$status_path = "../../problems/$result/result";
	$myfile = fopen($status_path, "r") or die("Unable to open $status_path!");

	echo "<tr><td>User</td><td>Result</td></tr>";
	
	while(!feof($myfile)) {
		$line = fgets($myfile);
		if (strpos($line, "\t") == false)
			continue;

		$pos = strrpos($line, "\t");
		$status = trim(substr($line, $pos+1));
		$user = trim(substr($line, 0, $pos-1));
		$users[$user] = $status;
	}
	fclose($myfile);

	asort($users);
	foreach ($users as $key => $value) {
		echo "<tr><td>" . $key . "</td><td>" . wrap($value) . "</td></tr>";
	}
}

?>
