<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Emperor extends AbstractResource
{
    protected function _frontDetailArray()
    {
        $data = $this->_frontBaseArray();
        return $data;
    }

    protected function _frontBaseArray()
    {
        return [              
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'note' => $this->note,
            'description' => $this->description,
        ];
    }
}
