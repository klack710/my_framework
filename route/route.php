<?php
namespace route;

$routes = [
    '/obachan' => ['controller/top/ObachanController', 'action'],
    '/hasumin' => ['controller/top/HasuminController', 'action'],
];

$routes_404 = ['controller/top/OtherController', 'action'];