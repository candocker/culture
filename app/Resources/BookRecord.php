<?php

namespace ModuleCulture\Resources;

class BookRecord extends AbstractResource
{
    protected function _frontListArray()
    {
        $base = $this->resource->toArray();
        return array_merge($base, [              
            'readStatus' => $this->getRepository()->getKeyValues('read_status', $this->read_status),
            'bookCode' => $this->book->code,
            'bookName' => $this->book->name,
            'author' => $this->book->authorInfo ? $this->book->authorInfo->name : '匿名',
            'cover' => $this->book->coverUrl,
        ]);
    }
}
