<?php

namespace ModuleCulture\Resources;

use Framework\Baseapp\Resources\AbstractResource;

class Chapter extends AbstractResource
{

    protected function _frontListArray()
    {
        return [              
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->authorInfo,
            'serial' => $this->serial,
            'content' => $this->getContent(),
        ];
    }

    protected function _frontDetailArray()
    {
        return $this->_frontListArray();
    }
}
