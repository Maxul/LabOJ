<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable = no" />


    <?php
    include_once('php/config.php');
    session_start();

    $pro = $_GET['problem'];
    echo "<title>$pro | Lab Online Judge</title>";
?>


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




                <?php
    echo "<h5>$pro</h5>";
    include_once('php/Parsedown.php');

    $Parsedown = new Parsedown();

    $description = "../problems/$pro/description";
    echo $Parsedown->text(file_get_contents($description));
?>


            </div>
            <div class="col s12 m4">
                <h6>提交动态</h6>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>用户</th>
                            <th>通过率</th>
                            <th>最晚提交时间</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
    include_once('php/connectDB.php');

    try {
        if (!isset($_GET['problem']) || empty($_GET['problem'])) {
			throw new Exception('Bad request');
		}

        try {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();

            $stmt = $dbh->prepare("SELECT * FROM `userpassrate` WHERE question = :question ORDER BY passRate DESC LIMIT 10");
            $stmt->bindParam(":question", $_GET['problem']);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                print('<tr><td>' . $row["user"] . '</td><td>' . $row["passRate"] . '</td><td>' . $row['time'] .'</td></tr>');
            }

?>



                    </tbody>
                </table>
                <h6>我的通过率


                    <?php
            $stmt = $dbh->prepare("SELECT * FROM `userpassrate` WHERE question = :question AND user = :user");
            $stmt->bindParam(":question", $_GET['problem']);
            $stmt->bindParam(":user", $_SESSION['userID']);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            print($rows['passRate']);
?>



                </h6>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>时间</th>
                            <th>结果</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
            $stmt = $dbh->prepare("SELECT * FROM `judge` WHERE question = :question AND user = :user ORDER BY `time` DESC");
            $stmt->bindParam(":question", $_GET['problem']);
            $stmt->bindParam(":user", $_SESSION['userID']);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                print('<tr><td>' . $row['time'] . '</td><td>' . $row['result'] . '</td></tr>');
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
    <div id="footer-placeholder"></div>

    <div id="result-modal" class="modal">
        <div class="modal-content">
            <h4>评测结果</h4>
            <div id="preloader" class="center-align">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
            <pre id="result-wrapper" class="hide">
                <code id="result-area"></code>
            </pre>
            <a href="#!" class="modal-action modal-close btn">好</a>
        </div>
    </div>

    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <h5 id="code-section-toggle" class="white-text">提交代码</h5>
                <div id="code-section">
                    <textarea id="editor" required="true"></textarea>
                    <textarea name="code" id="code" style="display:none" required="true"></textarea>
                    <a id="submit-code" class="btn">提交</a>
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
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/ace.js"></script>
    <script>
        function getArgs() {
            var args = {};
            var match = null;
            var search = decodeURIComponent(location.search.substring(1));
            var reg = /(?:([^&]+)=([^&]+))/g;
            while ((match = reg.exec(search)) !== null) {
                args[match[1]] = match[2];
            }
            return args;
        }
        $(document).ready(function () {
            $('.modal').modal();
            $("#code-section").hide();
            $("#footer-placeholder").css({
                "width": "100%",
                "height": $("footer").css("height")
            });
            $("#code-section-toggle").click(function () {
                $("#code-section").animate({height: 'toggle'}, 250, function () {
                    $("#footer-placeholder").css({
                        "width": "100%",
                        "height": $("footer").css("height")
                    });
                });
            });

            var editor = ace.edit("editor");
            var textarea = $('#code');

            editor.setTheme("ace/theme/textmate");
            editor.session.setMode("ace/mode/c_cpp");
            editor.setAutoScrollEditorIntoView(true);
            editor.setOption("maxLines", 7);
            editor.setOption("minLines", 7);
            editor.setFontSize("20px");

            editor.on('change', function () {
                textarea.val(editor.getValue());
            });

            textarea.val(editor.getValue());
            var chapter = getArgs().problem;
            $("#submit-code").click(function () {
                $('#result-modal').modal('open');
                $("#preloader").removeClass("hide");
                $("#result-wrapper").addClass("hide");
                $.post('php/judgeX.php', { chapter: chapter, code: textarea.val() }, function (data) {
                    $("#preloader").addClass("hide");
                    $("#result-area").html("\n" + data);
                    $("#result-wrapper").removeClass("hide");
                });
            });

            $("footer").css({
                "position": "fixed",
                "bottom": "0px",
                "width": "100%"
            });
        })
    </script>
</body>

</html>