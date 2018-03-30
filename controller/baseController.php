<?php
namespace controller;

abstract class baseController
{
    abstract public function action();

    /**
     * 表示させるHTMLのテンプレートを文字列で読み込む
     *
     * @param String $path 読み込むファイルのパス
     * @return String $template
     */
    protected function loadTemplate($path)
    {
        $template = file_get_contents($path);

        // (TODO) 500系のエラー作成
        if ($template === false) {
            return '';
        }

        return $template;
    }

    /**
     * 表示させるHTMLのテンプレートの{{ somekey }}を
     * クエリのキーに応じて置き換える
     *
     * @param String $template テンプレートのhtml
     * @return String $template 置換後のテンプレートのhtml
     */
    protected function replaceTemplate($template)
    {
        $get_array = $_GET;

        foreach($get_array as $key => $item) {
            // {{ }}内のkeyの文字列を、itemに変える
            // keyが正しくない場合はそのまま
            // 例: {{ key }} → item
            // 例: {{ xxx }} → {{ xxx }}
            $pattern = '{{ ' . $key . ' }}';
            $template = str_replace($pattern, $item, $template);
        }
        //要らなくなった {{}}と、マッチしなかった{{ xxx }}を消す
        $pattern = '/{{.*}}/';
        $replacement = '';
        $template = preg_replace($pattern, $replacement , $template);

        //置換後のファイルを返す
        return $template;
    }

    /**
     * テンプレートを表示させる
     *
     * @param String $html 表示させるhtml文字列
     * @return boolean 表示に成功したかどうか
     */
    protected function showPage($html)
    {
        // (TODO) 500系のエラー
        if (is_string($html) === false) {
            return false;
        }
        // 画面の表示
        echo $html;
        return true;
    }
}