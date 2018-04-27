<?php
/**
 * PDOのデータベースハンドルを取得する
 *
 * @return Object $dbh PDO
 */
function getDbh()
{
    $env_data = getDbConnectionData();
    try {
        $dbh = new PDO('mysql:host=mysql;dbname=' . $env_data['database'],
                $env_data['username'],
                $env_data['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    return $dbh;
}


/**
 * データベースに接続するための情報を取得する
 *
 * @return Array .envにあったデータベースの接続するための情報
 */
function getDbConnectionData()
{
    // .envを読み込み、DB接続に必要な情報を取得する
    // 例) DB_DATABASE   = db_name
    //     -> db_name
    $env_path = '../.env';
    $env_string = file_get_contents($env_path);
    preg_match('/DB_DATABASE\s*=\s*(.*)(\s|\z)/' ,$env_string, $database);
    preg_match('/DB_USERNAME\s*=\s*(.*)(\s|\z)/' ,$env_string, $username);
    preg_match('/DB_PASSWORD\s*=\s*(.*)(\s|\z)/' ,$env_string, $password);

    return [
        'database' => $database[1],
        'username' => $username[1],
        'password' => $password[1],
    ];
}