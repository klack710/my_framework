<?php
// echo phpinfo();

action();

/**
 * URIに応じてコントローラーのメソッドを動かす
 */
function action() {
    $uri = getUriWithoutQuery();
    list($file_full_path, $method_name) = getControllerPathAndMethodName($uri);

    // コントローラーのメソッドを動かす
    controllerAction($file_full_path, $method_name);
}

/**
 * URLから、クエリを取り除いてURIのみ取得する
 *
 * @return String $uri クエリを取り除いたURIを取得する
 */
function getUriWithoutQuery() {
    $uri = $_SERVER['REQUEST_URI'];
    $query = $_SERVER['QUERY_STRING'];
    $uri = str_replace('?' . $query, '', $uri);
    return $uri;
}


/**
 * URIとルートファイルから、
 * 動かすコントローラーとメソッドを取得する
 *
 * @param String $uri URI
 * @return String $file_full_path コントローラーの書かれたファイルパス
 * @return String $method_name コントローラーで動かすメソッド名
 */
function getControllerPathAndMethodName($uri) {
    // route.phpから、routesの情報を取得する
    $routes = [];
    $routes_404 = ['controller/top/OtherController', 'action'];
    require 'route/route.php';

    // routesから、コントローラーのパスとメソッド名を取得する
    if (array_key_exists($uri, $routes) && isset($routes[$uri][0]) && isset($routes[$uri][1])) {
        $file_full_path = $routes[$uri][0];
        $method_name    = $routes[$uri][1];
    } elseif (isset($routes_404[0]) && isset($routes_404[1])) {
        $file_full_path = $routes_404[0];
        $method_name    = $routes_404[1];
    } else {
        //(TODO) 404系エラー
        echo '404 not found';
        exit(1);
    }
    return [$file_full_path, $method_name];
}


/**
 * コントローラーをインスタンス化し、メソッドを動かす
 *
 * @param String $file_full_path コントローラーのフルパス
 * @param String $method_name メソッド名
 */
function controllerAction($file_full_path, $method_name) {
    $controller_full_path = str_replace('/', '\\', $file_full_path);

    require_once $file_full_path . '.php';
    $controller = new $controller_full_path;
    $controller->$method_name();
}
