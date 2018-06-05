<?php
namespace controller\top;

use Exception;
use Model\Model;
use controller\BaseWithDbController;
require_once '../Model/model.php';
require_once '../controller/BaseWithDbController.php';

class HasuminController extends BaseWithDbController
{
    const HTML_PATH = '../answer/hasumin.html';

    /**
     * テンプレートを読み込み、クエリに応じた処理を行った上で
     * 画面に表示させる。
     *
     * @return boolean 画面に表示が出来たかどうか
     */
    public function action()
    {
        //なんのもでる？
        $users = new Model('Users');
        $select = $users->select();

        var_dump($select);

        /* SQL走らせる */
        $sth = $this->dbh->prepare("INSERT INTO Pages VALUES(?, ?, ?)");
        $sth->execute(array(1, 'Hasumin', date('Y-m-d H:i:s')));
        $sth->execute(array(2, 'Action', date('Y-m-d H:i:s')));

        $template = $this->loadTemplate(self::HTML_PATH);

        // テンプレートに書かれた{{}}を、クエリに応じて置き換える
        $replaced_template = $this->replaceTemplate($template);

        return $this->showPage($replaced_template);
    }

    /**
     * テンプレートを読み込み、クエリに応じた処理を行った上で
     * 画面に表示させる。
     *
     * @param Array $requestdata ユーザーのPOSTデータ
     * @return boolean 画面に表示が出来たかどうか
     */
    public function postAction($requestdata)
    {
        $template = $this->loadTemplate(self::HTML_PATH);

        //(TODO)第二引数でエラーを配列で返すように設定する
        $this->validate($requestdata, [
            'id'     => ['int', 'alpha'],
            'hasvar' => ['alpha']
        ]);

        /* SQL走らせる */
        $sth = $this->dbh->prepare("INSERT INTO Pages VALUES(?, ?, ?)");
        $sth->execute(array($requestdata['id'], $requestdata['hasvar'], date('Y-m-d H:i:s')));
        $sth->execute(array(2, 'postAction', date('Y-m-d H:i:s')));

        // データの取得
        $pattern = $requestdata;

        // テンプレートに書かれた{{}}を、クエリに応じて置き換える
        $replaced_template = $this->replaceTemplate($template, $pattern);

        return $this->showPage($replaced_template);
    }
}
