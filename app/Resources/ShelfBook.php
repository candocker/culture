<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class ShelfBook extends AbstractResource
{
    protected function _frontListArray()
    {
        return [              
            'id' => $this->id,
            'shelf_id' => $this->shelf_id,
            'bookCode' => $this->book->code,
            'bookName' => $this->book->name,
            'author' => $this->book->authorInfo ? $this->book->authorInfo->name : '匿名',
            'cover' => $this->book->coverUrl,
            'created_at' => $this->created_at,
        ];
    }

    protected function _shelfListArray()
    {
        return [              
            'id' => $this->book->id,
            'shelf_id' => $this->shelf_id,
            'bookCode' => $this->book->code,
            'selected' => 0,
            'title' => $this->book->name,
            'author' => $this->book->authorInfo ? $this->book->authorInfo->name : '匿名',
            'cover' => $this->book->coverUrl,
            'type' => 1,
            'created_at' => $this->created_at,
        ];
    }
}
