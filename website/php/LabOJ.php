<!DOCTYPE html>

<html lang="zh">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/shCore.css">
	<link rel="stylesheet" type="text/css" href="../css/shCoreMidnight.css">
	<link rel="stylesheet" type="text/css" href="../css/bupt.css">

	<title>Lab Online Judge</title>

</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top clearfix" id="navigation">
		<ul>
			<li id="bold"><a href="#">Kernighan &alefsym; Ritchie Creative Studio</a></li>
			<li><a href="#submit">Submit</a></li>
			<li><a href="#query">Query</a></li>
			<li><a href="#reference">Refer</a></li>
		</ul>
	</nav>

	<hr>

	<div id="main-container" class="container">
		
		<form action="JUDGE.php" method="POST" enctype="multipart/form-data">
			<h1>Problem Set</h1>
			<br>
			<select onclick="displayProblem(this.value)" class="selectpicker" name="chapter" id="select">
				<option selected disabled>Problem Set</option>
				<optgroup label="C Lab 2018"></optgroup>
				<?php
				$problems = scandir("../../problems");
				foreach ($problems as $problem) {
					$res_file = "../../problems/$problem/result";
					if (file_exists($res_file) && (fileperms($res_file) & 0x0006)) {
						echo "<option>$problem</option>";
					}
				}
				?>
			</select>
			<input type="text" id="myNum" placeholder="学号" required="true" class="form-control" name="student" maxlength="10">

			<span id="txtProblem"></span>
			
			<hr id="submit"><br>
			<h1>Your Solution</h1>

			<textarea id="editor" required="true"></textarea>
			<textarea name="code" id="code" style="display:none" required="true"></textarea>
			<center>
				<input id="bold2" class="btn btn-info navbar-btn" type="submit" value="提交">
			</center>
		</form>

		<hr id="query"><br>
		<h1>Final Results</h1>
		<form>
			<select onclick="displayResult(this.value)" class="selectpicker" name="chapter" id="select">
				<option selected disabled>choose one</option>
				<?php
				$problems = scandir("../../problems");
				foreach ($problems as $pro) {
					$res_file = "../../problems/$pro/result";
					if (file_exists($res_file) && (fileperms($res_file) & 0x0004)) {
						echo "<option>$pro</option>";
					}
				}
				?>
			</select>
		</form>
		<table width="100%" id="txtResult"></table>

		<hr id="reference"><br>
		<h1>Possible solutions</h1>
		<hr>

	</div>

	<nav class="navbar-fixed-bottom">
		<footer>Copyright © 2015 - 2020 Maxul Lee.<br>All rights reserved.</footer>
	</nav>

	<script src="../js/jquery.js"></script>
	<script src="../js/shCore.js"></script>
	<script src="../js/shBrushCpp.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/ace.js"></script>

	<script>

		var editor = ace.edit("editor");
		var textarea = $('#code');

		editor.setTheme("ace/theme/textmate");
		editor.session.setMode("ace/mode/c_cpp");
		editor.setAutoScrollEditorIntoView(true);
		editor.setOption("maxLines", 18);
		editor.setOption("minLines", 18);
		editor.setFontSize("20px");

		editor.on('change', function () {
			textarea.val(editor.getValue());
		});

		textarea.val(editor.getValue());

		SyntaxHighlighter.all();

		function displayResult(str) {
			if (str.length == 0) { 
				document.getElementById("txtResult").innerHTML = "";
				return;
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("txtResult").innerHTML = xmlhttp.responseText;
					}
				};
				xmlhttp.open("POST", "AJAX.php?query=" + str, true);
				xmlhttp.send();
			}
		}

		function displayProblem(str) {
			if (str.length == 0) { 
				document.getElementById("txtProblem").innerHTML = "";
				return;
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("txtProblem").innerHTML = xmlhttp.responseText;
					}
				};
				xmlhttp.open("POST", "AJAX.php?text=" + str, true);
				xmlhttp.send();
			}
		}

		$("#myNum").keypress(function(event) {
			var keyCode = event.which;
			if ((48 <= keyCode && keyCode <=57) || keyCode == 8) {
				return true;
			} else {
				return false;
			}
		});

	</script>
	
</body>

</html>

