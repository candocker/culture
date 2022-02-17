<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Graphic extends AbstractResource
{
    protected function _frontDetailArray()
    {
        $data = $this->_viewArray();
        $data['tableData'] = $this->getTableDatas();
        return $data;
    }

    public function getTableDatas()
    {
        $sort = $this->sort;
        $code = $this->code;
        //echo $sort . '--' . $code;
    }
}
