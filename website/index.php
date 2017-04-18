<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable = no" />
    <title>Lab Online Judge</title>
    <link type="text/css" rel="stylesheet" href="css/materialize.css" />
    <link type="text/css" rel="stylesheet" href="css/icon.css" />
    <link type="text/css" rel="stylesheet" href="css/common.css" />
</head>

<body>
    <header>
        <nav>
            <div class="nav-wrapper container">
                <a href="index.php" class="brand-logo">Kernighan &alefsym; Ritchie Creative Studio</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.php">题目列表</a></li>
                    <li><a href="me.html">我的成就</a></li>

<?php
    include_once('php/config.php');
    session_start();

    if (isset($_SESSION['userName']) && isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
        echo "<li><a href=\"revoke.html\">注销</a></li>";
    } else {
        echo "<li><a href=\"login.html\">登录</a></li>";
    }

?>



                </ul>
            </div>
        </nav>
    </header>
    <main class="container">
        <div class="row"></div>
        <div class="row">
            <div class="col s12 m8">
                <h5>题目列表</h5>
                <table class="highlight">
                    <tbody>

<?php

    include_once('php/connectDB.php');

    try {

        try {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();


			$problems = scandir("../problems");
			foreach ($problems as $pro) {
				$res_file = "../problems/$pro/description";
				if (file_exists($res_file) && (fileperms($res_file) & 0x0004)) {
					echo "<tr><td><a href=\"problem.php?problem=$pro\">$pro</a></td></tr>";
				}
			}

?>




                    </tbody>
                </table>
            </div>
            <div class="col s12 m4">
                <h6>提交动态</h6>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>用户</th><th>题目</th><th>结果</th>
                        </tr>
                    </thead>
                    <tbody>


<?php
            $stmt = $dbh->prepare("SELECT * FROM `judge` ORDER BY `time` DESC LIMIT 10");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                print('<tr><td>' . $row["user"] . '</td><td>' . $row["question"] . '</td><td>' . $row['result'] .'</td></tr>');
            }
            
            $dbh->commit();
        } catch(Exception $DBerror) {

        }
    } catch (Exception $e) {

    }
?>



                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">欢迎学弟学妹们</h5>
                    <p class="grey-text text-lighten-4">这个OJ是你们助教2015年的时候开始写的，我们那一届是第一波用户。一开始还是FTP上传，没五秒集体判一次，然后再等FTP下载成绩。有责任心的助教不断迭代这套系统，努力让它越来越好用。欢迎来给我们提供反馈呀！</p>
                    <p class="grey-text text-lighten-4 right">- By 15级的 Binary Bin 学长</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h6 class="white-text">我们使用了这些前端库：</h6>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="https://ace.c9.io">Ace</a></li>
                        <li><a class="grey-text text-lighten-3" href="http://materializecss.com">Materialize</a></li>
                        <li><a class="grey-text text-lighten-3" href="http://jquery.com">JQuery</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                Copyright © 2015 - 2020 Maxul Lee, Binary Bin. All rights reserved.
                <a class="grey-text text-lighten-4 right" href="https://forms.office.com/Pages/ResponsePage.aspx?id=YYn0zalXFEGXdnq1XqVeHGVixBuFLGZPrqmtuNI8RXFUQ1daREFQRDMwNFRWMUhGUlNLN0c1NDNSMS4u">提供建议</a>
            </div>
        </div>
    </footer>


    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function () {
        })
    </script>
</body>

</html>