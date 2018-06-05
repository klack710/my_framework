<?php

namespace Model;

class Model
{
    protected $dbh;
    protected $table;

    public function __construct($table)
    {
        $this->dbh = getDbh();
        $this->table = $table;
    }

    /**
     * テンプレートを読み込み、クエリに応じた処理を行った上で
     * 画面に表示させる。
     *
     * @param array 読み込むカラム
     * @return boolean 画面に表示が出来たかどうか
     */
    public function select($column = [])
    {

        if ($column == []) {
            $sth = $this->dbh->prepare('SELECT * FROM ' . $this->table);
            $sth->execute();
        } else {
            // $column_count = count($column);
            // // columnの個数だけ?を増やす
            // $sth = $this->dbh->prepare('SELECT ? FROM ' . $this->table);
            // $sth->execute(array($column));
        }

        return $sth->fetchAll();
    }

}