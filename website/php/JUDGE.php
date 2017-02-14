<!DOCTYPE>

<html lang="zh">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/shCore.css">
	<link rel="stylesheet" type="text/css" href="../css/shCoreMidnight.css">
	<link rel="stylesheet" type="text/css" href="../css/bupt.css">
	
</head>

<body>

	<div id="main-container" class="container">
		<pre>
			<?php

			$student = $_POST['student'];
			$chapter = $_POST['chapter'];
			$code = $_POST['code'];

			if (!ctype_digit($student) || strlen($student) != 10) {
				echo "<h3>请输入学号—_—</h3>";
				return;
			}
			if (!isset($chapter)) {
				echo "<h3>请选择题号—_—</h3>";
				return;
			}
			if (empty(trim($code))) {
				echo "<h3>请填写代码—_—</h3>";
				return;
			}

			if (isset($student) && isset($chapter) && isset($code)) {
				// generate valid file name
				$file_name = "../../submit/$student-$chapter.c";
				$src_name = "../../problems/$chapter/template.c";

				if (file_exists($src_name)) {
					shell_exec("cat $src_name > $file_name");
				} else {
					shell_exec(":> $file_name");
				}
				// try to write the file
				$mycfile = fopen($file_name, "a") or die("Unable to open $file_name!");
				fwrite($mycfile, $code);
				fclose($mycfile);

				// check
				$cmd = "bash ../../core/src/LabOJ.sh $file_name ../../problems/$chapter";
				// get stderr and remove the source file
				$cmd = $cmd . ' 2>&1';
				// get the result
				$output = shell_exec($cmd);

				echo "<h3>$output</h3>";
			}

			?>
		</pre>
	</div>
	
</body>

</html>

