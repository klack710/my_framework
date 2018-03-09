<?php

function showTemplate($path) {
    //テンプレートと、置換する配列読み込み
    $template = file_get_contents($path);
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

    //テンプレ表示
    echo $template;
}