<?php

namespace Model;

use Model\Model;

class Pages extends Model
{
    public function idSelect()
    {
        return $this->select(['id']);
    }
}