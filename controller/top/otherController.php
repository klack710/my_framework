<?php
namespace controller\top;

use controller\BaseController;
require_once '../controller/BaseController.php';

class OtherController extends BaseController
{
    const HTML_PATH = '../answer/other.html';

    /**
     * テンプレートを読み込み、クエリに応じた処理を行った上で
     * 画面に表示させる。
     *
     * @return boolean 画面に表示が出来たかどうか
     */
    public function action()
    {
        /* SQL走らせる */
        $sth = $this->dbh->prepare("INSERT INTO Pages VALUES(?, ?, ?)");
        $sth->execute(array(1, 'Other', date('Y-m-d H:i:s')));
        $sth->execute(array(2, 'Action', date('Y-m-d H:i:s')));

        $template = $this->loadTemplate(self::HTML_PATH);

        // テンプレートに書かれた{{}}を、クエリに応じて置き換える
        $replaced_template = $this->replaceTemplate($template);

        return $this->showPage($replaced_template);
    }
}
