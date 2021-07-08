<?php

namespace ModuleCulture\Resources;

use Framework\Baseapp\Resources\AbstractCollection;

class BookCollection extends AbstractCollection
{

    protected function _frontInfoArray()
    {
        return $this->collection->toArray();
    }
}
