<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <title><?php if (isset($title[0])) : ?><?= $title[0]?><?php else : ?>Ice PHP Framework<?php endif; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $Resource_Css[0] ?>
    <?= $Resource_Js[0] ?>
</head>
<body>
<div id="iceMessages" class='notifications top-right'></div>
<div id="icePreloader">
    <div id="blockG_1" class="preloaderBlock">
    </div>
    <div id="blockG_2" class="preloaderBlock">
    </div>
    <div id="blockG_3" class="preloaderBlock">
    </div>
</div>

<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<?= $Header[0] ?>

<div id="Layout_Main" class="container">
    <?= $main[0] ?>
</div>
<div class="footer">
    <div class="container" style="text-align: right; font-size: 24px;">
        Powered by <a href="http://iceframework.net"><strong>Ice</strong></a>
    </div>
</div>
</body>
</html>
