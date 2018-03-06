<?php
$uri = $_SERVER['REQUEST_URI'];
$query = $_SERVER['QUERY_STRING'];
$uri = str_replace('?' . $query, '', $uri);

include 'route/route.php';
