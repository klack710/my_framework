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
    $database = getEnvData('DB_DATABASE');
    $username = getEnvData('DB_USERNAME');
    $password = getEnvData('DB_PASSWORD');

    return [
        'database' => $database,
        'username' => $username,
        'password' => $password,
    ];
}

/**
 * .envを読み込み、DB接続に必要な情報を取得する
 * 例) DB_DATABASE   = db_name
 *     -> db_name
 *
 * @return String 条件にマッチした文字列
 */
function getEnvData($key)
{
    $env_path = '../.env';
    $env_string = file_get_contents($env_path);
    $pattern = '/' . $key .'\s*=\s*(.*)(\s|\z)/';
    preg_match($pattern ,$env_string, $data);

    return $data[1];
}