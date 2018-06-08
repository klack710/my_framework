<?php

namespace Model;

use Model\Model;

class Hasvars extends Model
{
    public function getFirstDataFromId($id)
    {
        $data = $this->select()->where('id', '=', $id)->get();
        return $data[0];
    }
}