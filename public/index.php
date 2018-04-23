<?php
// echo phpinfo();

action();

/**
 * URIに応じてコントローラーのacitonを動かす
 */
function action()
{
    // URIを取得
    $uri = getUriWithoutQuery();
    // route.phpから、URIに応じたコントローラーのパスを取得
    $file_full_path = getControllerPath($uri);
    // .envから、DBハンドラを取得
    $dbh = getDbh();

    // dbh付きで、コントローラーのactionを動かす
    controllerActionWithDbh($file_full_path, $dbh);
}

/**
 * URLから、クエリを取り除いてURIのみ取得する
 *
 * @return String $uri クエリを取り除いたURIを取得する
 */
function getUriWithoutQuery()
{
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
function getControllerPath($uri)
{
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
function controllerAction($file_full_path)
{
    $controller_full_path = str_replace('/', '\\', $file_full_path);
    require_once '../' . $file_full_path . '.php';
    $controller = new $controller_full_path;
    $controller->action();
}


/**
 * コントローラーをDBのコネクション付きでインスタンス化し、
 * actionを動かす
 *
 * @param String $file_full_path コントローラーのフルパス
 * @param String $dbh データベースハンドル
 */
function controllerActionWithDbh($file_full_path, $dbh)
{
    $controller_full_path = str_replace('/', '\\', $file_full_path);

    require_once '../' . $file_full_path . '.php';
    $controller = new $controller_full_path;

    // DBに接続後、actionがエラー無く動けばコミット
    // エラーが出たらロールバックしてエラーメッセージを表示
    try {
        $controller->connectionDb($dbh);
        $controller->action();
        $controller->commit();
    } catch (PDOException $e) {
        $controller->rollback();
        exit($e->getMessage());
    }
}

/**
 * PDOのデータベースハンドルを取得する
 *
 * @return Object $dbh PDO
 */
function getDbh()
{
    $env_data = getDbConnectionData();
    try {
        $dbh = new PDO('mysql:host=mysql;dbname=' . $env_data['database'],
                $env_data['username'],
                $env_data['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    return $dbh;
}


/**
 * データベースに接続するための情報を取得する
 *
 * @return Array .envにあったデータベースの接続するための情報
 */
function getDbConnectionData()
{
    // .envを読み込み、DB接続に必要な情報を取得する
    // 例) DB_DATABASE   = db_name
    //     -> db_name
    $env_path = '../.env';
    $env_string = file_get_contents($env_path);
    preg_match('/DB_DATABASE\s*=\s(.*)(\s|\z)/' ,$env_string, $database);
    preg_match('/DB_USERNAME\s*=\s(.*)(\s|\z)/' ,$env_string, $username);
    preg_match('/DB_PASSWORD\s*=\s(.*)(\s|\z)/' ,$env_string, $password);

    return [
        'database' => $database[1],
        'username' => $username[1],
        'password' => $password[1],
    ];
}