<?php

namespace ModuleCulture\Resources;

class BookRecordCollection extends AbstractCollection
{
    protected function _frontListArray()
    {
        return $this->collection->toArray();
    }
}
