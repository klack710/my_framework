<?php

function showTemplate($path) {

//テンプレートと、置換する配列読み込み
$template = file_get_contents($path);
$get_array = $_GET;

foreach($get_array as $key => $item) {
    // {{ }}内のkeyの文字列を、itemに変える
    // key以外の文字列はそのまま
    // 例: {{ key aaa }}→ {{ item aaa }}
    $pattern = '/({{.*)( ' . $key . ' )+(.*}})/';
    $replacement = '\1 ' . $item . ' \3';
    $temp = '';
    // keyが見つからなくなるまで置換
    while ($temp != $template) {
        $temp = $template;
        $template = preg_replace($pattern, $replacement, $template);
    }
}
//要らなくなった {{}}を消す
$pattern = '/{{(.*)}}/';
$replacement = '\1';
$template = preg_replace($pattern, $replacement , $template);

//テンプレ表示
echo $template;
}