<!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style>
		table, th, td {
			border: 2px solid black;
			border-collapse: collapse;
			background: transparent;
			font-size: 20px;
			font-family: "Microsoft Yahei" sans-serif;
		}
		th, td {
			padding: 7px;
			text-align: center;
		}
		table tr:nth-child(odd) {
			background: #F4F4F4;
		}
		table td:nth-child(even) {
			color: #C00;
		}
		table tr:nth-child(1), #bar {
			background: #73B1E0;
			color: #FFF;
		}
	</style>
</head>

<body>
	<table width="100%">
		<tr>
			<th>已递交作业</th>
			<th>最终评判结果</th>
			<th>提交次数</th>
		</tr>

		<?php

		$problems = scandir("../../problems");

		foreach ($problems as $problem) {

			$status_path = "../../problem/$problem/result";
			
			if (file_exists($status_path))
			{
			$myfile = fopen($status_path, "r") or die("Unable to open $status_path!");

			while(!feof($myfile)) {

				$line = fgets($myfile);
				if (strpos($line, ",") == false)
					continue;

				$pos = strrpos($line, ",");
				$status = trim(substr($line, $pos+1));
				$user = trim(substr($line, 0, $pos-1));

				if (strlen($user) < 13)
					continue;

				$times[$user]++;

				if (isset($score[$user]) && strlen($score[$user]) > 20)
					continue;
				$score[$user] = $status;
			}
			fclose($myfile);
		}

		// 2015211582-2015211670
		//for ($x = 2015211582; $x <= 2015211670; $x++) {
			$final_score = 0;

			foreach ($problems as $problem) {

				$file = $x . '-' . $problem;
				echo "<tr><td>" . $file . "</td><td>" . $score[$file] . "</td><td>";

				if (strlen($score[$file]) == 0)
					;
				else if (strpos($score[$file], "KB") == true)
					$final_score += 12.5;
				else
					$final_score += 10;

				if (isset($times[$file]))
					echo $times[$file] . "</td></tr>";
				else
					echo "0</td></tr>";
			}
			echo "<tr><th>$x</th><th>$final_score</th><th> </th></tr>";
		}
		?>

	</table>
</body>

</html>
