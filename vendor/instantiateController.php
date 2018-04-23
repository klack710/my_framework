<?php

/**
 * 指定したパスに応じて、
 * コントローラーをインスタンス化する
 *
 * @param String $file_full_path コントローラーのフルパス
 * @return Object $controller コントローラーのインスタンス
 */
function instantiateController($file_full_path)
{
    // Controllerのパスはdirectory/file.phpではなく
    // directory\file.phpで指定する必要があるので置き換える
    $controller_full_path = str_replace('/', '\\', $file_full_path);

    require_once '../' . $file_full_path . '.php';
    $controller = new $controller_full_path;

    return $controller;
}
