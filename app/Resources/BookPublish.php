<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class BookPublish extends AbstractResource
{
    protected function _frontBaseArray()
    {
        $book = $this->resource->book;
        //$figureDatas = $book->figureDatas;

        $bookRepository = $this->getRepositoryObj('book');
        $bookResource = ['code' => '', 'baiduUrl' => '', 'description' => '', 'coverUrl' => ''];
        if (!empty($book)) {
            $bookResource = $this->getResourceObj($book, 'frontBase', 'book');
        }
        $result = [
            'book_code' => $this->book_code,
            'name' => $this->name,
            'author' => $this->author,
            'translator' => $this->translator,
            'nationality' => $this->nationality,
        ];
        $result = array_merge($result, $bookResource->toArray());
        $result['jsonStr'] = json_encode($result);
        return $result;
    }
}
