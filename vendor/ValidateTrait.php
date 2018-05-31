<?php
namespace vendor;

use Exception;

trait ValidateTrait
{
    /**
     * バリデーションする
     * @param Array $array バリデーションチェックする配列
     * @param Array option バリデーションの設定
     * 例) $options => ['id'       => ['int', 'alpha']]
     * 例) $options => [$array_key => [$valiation, $valiation]]
     * @return Array $error エラーの配列
     */
    public function validate($array, $options = [])
    {
        $error = [];
        // ユーザーの入力例
        foreach ($array as $array_key => $item) {
            // バリデーションの設定が抜けていないか
            if (isset($options[$array_key])) {
                // $valiation -> バリデーションの種類
                // $valiationに応じたバリデーションチェック。
                foreach ($options[$array_key] as $valiation) {
                    switch ($valiation) {
                        case 'int':
                            if (!ctype_digit($item)) {
                                $error[$array_key][] = 'int';
                            }
                            break;
                        case 'alpha':
                            if (!ctype_alnum($item)) {
                                $error[$array_key][] = 'alpha';
                            }
                            break;
                        default:
                            // (TODO)logの書き出し
                            // $option_key . 'というバリデーションは存在しません'
                            header("HTTP/1.1 500 Internal Server Error");
                            throw new Exception('500 Internal Server Error');
                    }
                }
            } else {
                // (TODO)logの書き出し
                // $array_key . 'というキーのバリデーションが設定されていません'
                header("HTTP/1.1 500 Internal Server Error");
                throw new Exception('500 Internal Server Error');
            }
        }

        // (TODO)エラーを投げるか、配列で返すか検討
        // エラーの表示
        if ($error) {
            foreach ($error as $key => $validates) {
                foreach ($validates as $validate) {
                    if ($validate == 'int') {
                        $message = $message . $key . "が数値ではありません\n";
                    } else {
                        $message = $message . $key . 'は' . $validate . "の規約に違反しています\n";
                    }
                }
            }
            throw new Exception($message);
        }
    }
}