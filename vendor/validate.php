<?php
/**
 * バリデーションする
 *
 */
function validate($array, $options = [])
{
    foreach($array as $array_key => $item) {
        if (isset($options[$array_key])) {
            foreach ($options[$array_key] as $option_key => $option) {
                switch ($option_key) {
                    case 'int':
                        if (!ctype_digit($item)) {
                            throw new Exception($array_key.'が数値ではありません');
                        }
                        break;
                    case 'alpha':
                        if (!ctype_alnum($item)) {
                            throw new Exception($array_key.'が英数字ではありません');
                        }
                        break;
                }
            }
        }
    }
}