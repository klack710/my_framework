<?php
namespace controller;

use Exception;
use controller\BaseController;
require_once '../vendor/getDbh.php';
require_once '../controller/BaseController.php';

abstract class BaseWithDbController extends BaseController
{
    protected $dbh;

    public function __construct()
    {
        $this->dbh = getDbh();
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
            exit($e->getMessage());
        }
    }
}