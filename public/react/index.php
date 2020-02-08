<?php

require_once "../lib/helpers.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php renderScrips() ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../assets/app.css">
</head>
<body>
    <div class="container" id="react-app"></div>
    <?php renderFooter() ?>
    <script type="text/javascript" src="/react/app.js"></script>
</body>
</html>
