<?php
// (TODO)コントローラー継承したい
require_once 'vendor/replaceTemplate.php';

//テンプレート読み込み
$template = file_get_contents('answer/obachan.php');
//テンプレートを置換
$html = replace_template($template);

echo $html;