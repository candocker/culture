<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Record extends AbstractResource
{
    protected function _frontListArray()
    {
        $base = $this->resource->toArray();
        return array_merge($base, [              
            'readStatus' => $this->getRepository()->getKeyValues('read_status', $this->read_status),
            'bookCode' => $this->book->code,
            'bookName' => $this->book->name,
            'chapterName' => $this->chapter->name,
            'author' => $this->book->authorInfo ? $this->book->authorInfo->name : '匿名',
            'cover' => $this->book->coverUrl,
        ]);
    }
}
