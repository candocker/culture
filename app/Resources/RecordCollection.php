<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class RecordCollection extends AbstractCollection
{
    protected function _frontListArray()
    {
        return $this->collection->toArray();
    }
}
