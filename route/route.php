<?php
require_once 'vendor/showTemplate.php';

if ($uri === '/obachan') {
    include 'controller/obachanController.php';
} else if ($uri === '/hasumin') {
    include 'controller/hasuminController.php';
} else {
    include 'controller/otherController.php';
}

