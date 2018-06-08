<?php
namespace controller\top;

require_once __DIR__.'/../../model/Pages.php';
use model\Pages;
require_once __DIR__.'/../../model/Hasvars.php';
use model\Hasvars;
use controller\BaseWithMysqlController;

class ObachanController extends BaseWithMysqlController
{
    const HTML_PATH = '../answer/obachan.html';

    /**
     * テンプレートを読み込み、クエリに応じた処理を行った上で
     * 画面に表示させる。
     *
     * @return boolean 画面に表示が出来たかどうか
     */
    public function action()
    {
        $pages = new Pages($this->dbh);
        $pages->insert(['id' => 1, 'name' => 'Obachan', 'created_at' => date('Y-m-d H:i:s')])->execute();

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
            'id'     => ['int'],
        ]);

        $hasvars = new Hasvars($this->dbh);
        $result = $hasvars->getFirstDataFromId($requestdata['id']);

        // データの取得
        $pattern = ['id' => $result->id, 'value' => $result->hasvar];

        // テンプレートに書かれた{{}}を、クエリに応じて置き換える
        $replaced_template = $this->replaceTemplate($template, $pattern);

        return $this->showPage($replaced_template);
    }
}
