<?php

namespace model;

use PDO;

class Model
{
    protected $dbh;
    protected $table_name;
    protected $sql = '';
    protected $param = [];

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
        // class名をnamespaceを取り除いて取得
        $this->table_name = basename(strtr(get_class($this), '\\', '/'));
    }

    /**
     * sqlにselect文を加える
     *
     * @param array 読み込むカラム
     */
    public function select($columns = ['*'], $where = [])
    {
        $this->sql = 'SELECT ' . implode($columns, ', ') . ' FROM ' . $this->table_name;

        return $this;
    }

    public function insert($data = [])
    {
        $this->sql = 'INSERT INTO ' . $this->table_name . ' (' . implode(array_keys($data), ', ') . ')';
        //prepareの名前パラメータマークに加工する
        $data_for_param = [];
        foreach($data as $key => $data) {
            $data_for_param[':insert_'.$key ] = $data;
        }
        //名前パラメータマークをSQLに追加
        $this->sql .= ' VALUES(' . implode(array_keys($data_for_param), ', ') .')';
        $this->param = array_merge($this->param, $data_for_param);

        return $this;
    }

    public function where($column, $compare_tag, $param)
    {
        //prepareの名前パラメータマークに加工する
        //名前がかぶらないように、sqlの長さでラベル付けする
        $data_for_param = [':where_'.strlen($this->sql) => $param];
        $this->sql .= ' WHERE ' . $column . ' ' .  $compare_tag . ' ' . key($data_for_param);
        $this->param = array_merge($this->param, $data_for_param);

        return $this;
    }

    public function execute()
    {
        $sth = $this->dbh->prepare($this->sql);
        $sth->execute($this->param);
        // 動作をしたら初期化
        $this->sql = '';
        $this->param = [];
    }

    public function get()
    {
        $sth = $this->dbh->prepare($this->sql);
        $sth->execute($this->param);
        // 動作をしたら初期化
        $this->sql = '';
        $this->param = [];
        return $sth->fetchAll(PDO::FETCH_CLASS);
    }
}