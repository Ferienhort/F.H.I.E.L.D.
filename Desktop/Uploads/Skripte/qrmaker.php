<?php

if(!isset($_GET[IID])){
    die("Ciaou");
}

$url=urlencode("http://link.kuume.at/kuume.php?IID=".$_GET[IID]);

$fetch="http://qrickit.com/api/qr?d=$url&e=m&t=g&qrsize=600";

usleep(2000);

header('Content-type:image/png');
readfile($fetch);