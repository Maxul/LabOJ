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
                <a href="index.html" class="brand-logo">Kernighan &alefsym; Ritchie Creative Studio</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.html">题目列表</a></li>
                    <li><a href="me.html">我的成就</a></li>
                    <li><a href="revoke.html">注销</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container">
        <div class="row">
            <div class="col s12 m8">
                <h5>某个问题</h5>




<?php


    include_once('php/Parsedown.php');

    $Parsedown = new Parsedown();
    echo $Parsedown->text(file_get_contents("Parsedown.md"));
?>





            </div>
            <div class="col s12 m4">
                <h6>提交动态</h6>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>用户</th><th>通过率</th><th>最晚提交时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Alita</td><td>33%</td><td>2017-06-12 13:14:15</td></tr>
                        <tr><td>Odd</td><td>24%</td><td>2017-06-12 13:14:15</td></tr>
                        <tr><td>Uric</td><td>10%</td><td>2017-06-12 13:14:15</td></tr>
                        <tr><td>Jeremy</td><td>10%</td><td>2017-06-12 13:14:15</td></tr>
                        <tr><td>Yumi</td><td>10%</td><td>2017-06-12 13:14:15</td></tr>
                        <tr><td>Xana</td><td>0%</td><td>2017-06-12 13:14:15</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                Copyright © 2015 - 2020 Maxul Lee, Binary Bin. All rights reserved.
                <a class="grey-text text-lighten-4 right" href="#!">提供建议</a>
            </div>
        </div>
    </footer>


    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function () {
        })
    </script>
</body>

</html>