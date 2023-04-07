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
            $bookResource = $bookResource->toArray();
        } else {
            \Log::debug('no-book-' . $this->book_code . '=' . $this->name);
        }
        $result = [
            'book_code' => $this->book_code,
            'name' => $this->name,
            'author' => $this->author,
            'translator' => $this->translator,
            'nationality' => $this->nationality,
        ];
        $result = array_merge($result, $bookResource);
        $result['jsonStr'] = json_encode($result);
        return $result;
    }
}
