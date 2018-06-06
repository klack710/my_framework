<?php
namespace vendor;

use PDO;

trait GetPdoObjectTrait
{
    /**
     * Mysqlに接続したPDOのデータベースハンドルを取得する
     *
     * @return Object $dbh PDO
     */
    public function getConnectedMysqlDbh()
    {
        $env_data = $this->getDbConnectionData();
        try {
            $dbh = new PDO('mysql:host=mysql;dbname=' . $env_data['database'],
                    $env_data['username'],
                    $env_data['password'],
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        return $dbh;
    }


    /**
     * データベースに接続するための情報を取得する
     *
     * @return Array .envにあったデータベースの接続するための情報
     */
    private function getDbConnectionData()
    {
        $database = $this->getEnvData('DB_DATABASE');
        $username = $this->getEnvData('DB_USERNAME');
        $password = $this->getEnvData('DB_PASSWORD');

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
    private function getEnvData($key)
    {
        $env_path = '../.env';
        $env_string = file_get_contents($env_path);
        $pattern = '/' . $key .'\s*=\s*(.*)(\s|\z)/';
        preg_match($pattern ,$env_string, $data);

        return $data[1];
    }
}