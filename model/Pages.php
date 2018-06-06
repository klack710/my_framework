<?php

namespace model;

use model\Model;

class Pages extends Model
{
    public function idSelect()
    {
        return $this->select(['id']);
    }
}