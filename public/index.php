<?php
// echo phpinfo();

require_once '../vendor/getUriWithoutQuery.php';
require_once '../vendor/getControllerPath.php';
require_once '../vendor/instantiateController.php';

// テーブル作成用
// createTablePages();
// function createTablePages() {
//     $dbh = getDbh();
//     $dbh->exec('CREATE TABLE Pages (id int, name nchar(255), create_date datetime)');
// }

execController();

/**
 * URIに応じてコントローラーのexecを動かす
 */
function execController()
{
    // URIを取得
    $uri = getUriWithoutQuery();
    // route.phpから、URIに応じたコントローラーのパスを取得
    $file_full_path = getControllerPath($uri);

    // コントローラーのパスから、コントローラーのインスタンスを取得
    $controller = instantiateController($file_full_path);
    $controller->exec();
}
