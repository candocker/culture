<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Scholarism extends AbstractResource
{
    protected function _frontDetailArray()
    {
        $data = $this->_frontInfoArray();
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

    protected function _frontInfoArray()
    {
        return [              
            'id' => $this->id,
            'book_code' => $this->book_code,
            'name' => $this->name,
            'book' => $this->getResourceObj('book', ['resource' => $this->book, 'scene' => 'frontDetail', 'repository' => $this->getRepositoryObj('book'), 'simpleResult' => false])->toArray(),
        ];
    }
}
