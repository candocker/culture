<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class BookPublishCollection extends AbstractCollection
{
    protected function _frontBaseArray()
    {
        return $this->collection->toArray();
    }
}
