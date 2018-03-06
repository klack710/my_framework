<?php
if ($uri === '/obachan') {
    include 'answer/obachan.php';
} else if ($uri === '/hasumin') {
    include 'answer/hasumin.php';
} else {
    include 'answer/other.php';
}