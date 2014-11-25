<head>
    <meta charset="utf-8">
    <meta name="author" content="Owen Chris Tyler">
    <meta name="description" content="Everything you need to know about your northern vermont mountains">

    <link href="style.css" type="text/css" rel="stylesheet" />

    <title>Burlington area ski and snowboard scene.</title>

    <?php
    $domain = "http://";
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS']) {
                $domain = "https://";
            }
        }
    $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
    $domain .= $server;
    $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
    $path_parts = pathinfo($phpSelf);
    ?>

</head>

<?php
    print '<body id="' . $path_parts['filename'] . '">';
    include "header.php";
    include "nav.php";
    ?>