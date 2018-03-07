<?php
require 'vender/showTemplate.php';

if ($uri === '/obachan') {
    $path = 'answer/obachan.php';
} else if ($uri === '/hasumin') {
    $path = 'answer/hasumin.php';
} else {
    $path = 'answer/other.php';
}
showTemplate($path);
