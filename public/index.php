<?php
// echo phpinfo();

action();

/**
 * URIに応じてコントローラーのacitonを動かす
 */
function action() {
    $uri = getUriWithoutQuery();
    $file_full_path = getControllerPath($uri);

    // コントローラーのactionを動かす
    controllerAction($file_full_path);
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
 * 動かすコントローラーを取得する
 *
 * @param String $uri URI
 * @return String $file_full_path コントローラーの書かれたファイルパス
 */
function getControllerPath($uri) {
    // route.phpから、routesの情報を取得する
    $routes = [];
    $routes_404 = '/controller/top/OtherController';
    require '../route/route.php';

    // routesから、コントローラーのパスを取得する
    if (array_key_exists($uri, $routes) && isset($routes[$uri][0])) {
        $file_full_path = $routes[$uri];
    } elseif (isset($routes_404[0])) {
        $file_full_path = $routes_404;
    } else {
        //(TODO) 404系エラー
        echo '404 not found';
        exit(1);
    }
    return $file_full_path;
}


/**
 * コントローラーをインスタンス化し、actionを動かす
 *
 * @param String $file_full_path コントローラーのフルパス
 * @param String $method_name メソッド名
 */
function controllerAction($file_full_path) {
    $controller_full_path = str_replace('/', '\\', $file_full_path);

    require_once '../' . $file_full_path . '.php';
    $controller = new $controller_full_path;
    $controller->action();
}
