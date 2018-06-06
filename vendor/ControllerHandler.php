<?php
class ControllerHandler {
    private $controller;

    public function __construct()
    {
        // 各コントローラーが扱うファイルを読み込ませる
        require_once __DIR__.'/../controller/BaseController.php';
        require_once __DIR__.'/../controller/BaseWithMysqlController.php';
        require_once __DIR__.'/../model/Model.php';

        // $_SERVER['REQUEST_URI']からURIを取得
        $uri = $this->getUriWithoutQuery();
        // route.phpから、URIに応じたコントローラーのパスを取得
        $file_full_path = $this->getControllerPath($uri);
        // コントローラーのパスから、コントローラーのインスタンスを取得
        $this->controller = $this->instantiateController($file_full_path);
    }

    public function execController()
    {
        $this->controller->exec();
    }

    /**
     * URLから、クエリを取り除いてURIのみ取得する
     *
     * @return String $uri クエリを取り除いたURIを取得する
     */
    private function getUriWithoutQuery()
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
    private function getControllerPath($uri)
    {
        // route.phpから、routesの情報を取得する
        $routes = [];
        $routes_404 = '/controller/top/OtherController';
        require_once __DIR__.'/../route/route.php';

        // routesから、コントローラーのパスを取得する
        if (array_key_exists($uri, $routes) && isset($routes[$uri])) {
            $file_full_path = $routes[$uri];
        } elseif (isset($routes_404)) {
            header("HTTP/1.1 404 Not Found");
            $file_full_path = $routes_404;
        } else {
            //(TODO) 404系エラー
            header("HTTP/1.1 404 Not Found");
            echo '404 not found';
            exit(1);
        }
        return $file_full_path;
    }


    /**
     * 指定したパスに応じて、
     * コントローラーをインスタンス化する
     *
     * @param String $file_full_path コントローラーのフルパス
     * @return Object $controller コントローラーのインスタンス
     */
    private function instantiateController($file_full_path)
    {
        // Controllerのパスはdirectory/file.phpではなく
        // directory\file.phpで指定する必要があるので置き換える
        $controller_full_path = str_replace('/', '\\', $file_full_path);

        require_once '../' . $file_full_path . '.php';
        $controller = new $controller_full_path;

        return $controller;
    }
}
