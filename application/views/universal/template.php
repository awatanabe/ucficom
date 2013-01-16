<?= doctype("html5") ?>
<html>

<head>
    <!-- Load inuit.css CSS Framework -->
    <link href="/css/inuit/css/inuit.css" rel="stylesheet" type="text/css">
    <link href="/css/igloos.css" rel="stylesheet">
    <!-- Load general style sheet -->
    <link href="/css/styles.css" rel="stylesheet" type="text/css">
    <!-- Load favicon -->
    <link rel="icon" type="image/png" href="/images/ficom.ico">
    <!-- Load jquery library and javascript files
    <script src="/javascript/jquery-1.7.2.min.js"></script>
    <script src="/javascript/loader.js"></script>-->
    <title>FiCom Web Portal</title>
</head>

<body class="wrapper">
    <!-- Header area -->
    <div id="banner">
        <?= $banner ?>
    </div>
    <?= $message ?>
    <div id="content">
        <?= $content ?>
    </div>
    <br>    
</body>
</html>