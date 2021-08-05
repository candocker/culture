<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class ShelfBookCollection extends AbstractCollection
{
    protected function _frontListArray()
    {
        return $this->collection->toArray();
    }

    protected function _shelfListArray()
    {
        return $this->collection->toArray();
    }
}
