<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Scholarism extends AbstractResource
{
    protected function _frontDetailArray()
    {
        $book = $this->book;
        $figureDatas = $book->figureDatas;

        $bookRepository = $this->getRepositoryObj('book');
        $bookResource = $this->getResourceObj('book', ['resource' => $this->book, 'scene' => 'frontBase', 'repository' => $bookRepository, 'simpleResult' => false]);
        print_r($bookResource->toArray());exit();
        $result = [
            'book_code' => $book['code'],
            'name' => $this->name,
            //'baidu_url' => 
        ];
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
