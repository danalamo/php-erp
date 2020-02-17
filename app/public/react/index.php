<?php

require_once "../lib/helpers.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php renderHeadPartial() ?>
</head>
<body>
    <div class="container" id="react-app"></div>
    <?php renderFooter() ?>
    <script type="text/javascript" src="/react/app.js"></script>
</body>
</html>
