<?php
// echo phpinfo();

require_once '../vendor/getUriWithoutQuery.php';
require_once '../vendor/getControllerPath.php';
require_once '../vendor/getDbh.php';
require_once '../vendor/instantiateController.php';

// テーブル作成用
// createTablePages();
// function createTablePages() {
//     $dbh = getDbh();
//     $dbh->exec('CREATE TABLE Pages (id int, name nchar(255), create_date datetime)');
// }

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

    // コントローラーのパスから、コントローラーのインスタンスを取得
    $controller = instantiateController($file_full_path);
    // .envから、DBハンドラを取得
    $dbh = getDbh();

    // DBハンドラ付きで、コントローラーのactionを動かす
    controllerActionWithDbh($controller, $dbh);
}


/**
 * コントローラーをDBのコネクション付きでインスタンス化し、
 * actionを動かす
 *
 * @param String $file_full_path コントローラーのフルパス
 * @param String $dbh データベースハンドル
 */
function controllerActionWithDbh($controller, $dbh)
{
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
