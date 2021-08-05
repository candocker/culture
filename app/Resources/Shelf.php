<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Shelf extends AbstractResource
{
    protected function _frontListArray()
    {
        return [              
            'id' => $this->id,
            'bookCode' => $this->book->code,
            'bookName' => $this->book->name,
            'author' => $this->book->authorInfo ? $this->book->authorInfo->name : '匿名',
            'cover' => $this->book->coverUrl,
            'created_at' => $this->created_at,
        ];
    }
}
