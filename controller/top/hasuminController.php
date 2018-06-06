<?php
namespace controller\top;

require_once __DIR__.'/../../model/Pages.php';
use model\Pages;
require_once __DIR__.'/../../model/Hasvars.php';
use model\Hasvars;
use controller\BaseWithMysqlController;

class HasuminController extends BaseWithMysqlController
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
        $Pages = new Pages($this->dbh);
        $select = $Pages->select()->where('id', '=', 5)->get();

        $Pages->insert(['id' => 5, 'name' => 'Hasumin', 'created_at' => date('Y-m-d H:i:s')])->execute();
        $Pages->insert(['id' => 5, 'name' => 'Hasumin', 'created_at' => date('Y-m-d H:i:s')])->execute();

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
            'hasvar' => ['alpha']
        ]);

        $Hasvars = new Hasvars($this->dbh);
        $Hasvars->insert(['hasvar' => $requestdata['hasvar'], 'created_at' => date('Y-m-d H:i:s')])->execute();

        // データの取得
        $pattern = $requestdata;

        // テンプレートに書かれた{{}}を、クエリに応じて置き換える
        $replaced_template = $this->replaceTemplate($template, $pattern);

        return $this->showPage($replaced_template);
    }
}
