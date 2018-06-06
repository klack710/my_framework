<?php
namespace controller;

use Exception;

require_once __DIR__.'/BaseController.php';
use controller\BaseController;

require_once '../vendor/GetPdoObjectTrait.php';
use vendor\GetPdoObjectTrait;


abstract class BaseWithMysqlController extends BaseController
{
    use GetPdoObjectTrait;
    protected $dbh;

    public function __construct()
    {
        $this->dbh = $this->getConnectedMysqlDbh();
    }

    /**
     * index.phpが呼び出すメソッド。コントローラーの扱いが決まる
     * このコントローラーでは、DBの接続・コミット・ロールバックを行い、
     * switchActionを呼び出す。
     */
    public function exec()
    {
        // DBに接続後、actionがエラー無く動けばコミット
        // エラーが出たらロールバックしてエラーメッセージを表示
        try {
            $this->dbh->beginTransaction();
            $this->switchAction();
            $this->dbh->commit();
        } catch (Exception $e) {
            $this->dbh->rollback();

            // (TODO)サーバーエラーと表示させて、エラー内容を表示させない
            // 現在はデバッグのためにエラーメッセージを表示
            header("HTTP/1.1 500 Internal Server Error");
            exit($e->getMessage());
        }
    }
}