<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Scholarism extends AbstractResource
{
    protected function _frontBaseArray()
    {
        $book = $this->book;
        //$figureDatas = $book->figureDatas;

        $bookRepository = $this->getRepositoryObj('book');
        $bookResource = ['code' => 'aaa', 'description' => ''];
        if (!empty($this->book)) {
            $bookResource = $this->getResourceObj('book', ['resource' => $this->book, 'scene' => 'frontBase', 'repository' => $bookRepository, 'simpleResult' => false])->toArray();
        }
        $result = [
            'book_code' => $this->book_code,
            'name' => $this->name,
            //'baidu_url' => 
        ];
        return array_merge($result, $bookResource);
        /*$chapters = $this->chapters;
        $cDatas = [];
        foreach ($chapters as $chapter) {
            $cDatas[] = [
                'id' => $chapter['id'],
                'name' => $chapter['name'],
                'serial' => $chapter['serial'],
            ];
        }
        $data['chapters'] = $cDatas;
        $data['chapterNum'] = count($cDatas);*/
        return $data;
    }
}
