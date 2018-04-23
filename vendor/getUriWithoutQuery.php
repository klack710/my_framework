<?php
/**
 * URLから、クエリを取り除いてURIのみ取得する
 *
 * @return String $uri クエリを取り除いたURIを取得する
 */
function getUriWithoutQuery()
{
    $uri = $_SERVER['REQUEST_URI'];
    $query = $_SERVER['QUERY_STRING'];
    $uri = str_replace('?' . $query, '', $uri);
    return $uri;
}
