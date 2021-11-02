<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class BookSortCollection extends AbstractCollection
{
    protected function _frontInfoArray()
    {
        return $this->collection->toArray();
    }
}
