<?php

namespace ModuleCulture\Resources;

use Framework\Baseapp\Resources\AbstractResource;

class Book extends AbstractResource
{

    protected function _frontDetailArray()
    {
        $data = $this->_frontInfoArray();
        $chapters = $this->chapters;
        $cDatas = [];
        foreach ($chapters as $chapter) {
            $cDatas[] = [
                'id' => $chapter['id'],
                'name' => $chapter['name'],
                'serial' => $chapter['serial'],
            ];
        }
        $data['chapters'] = $cDatas;
        $data['chapterNum'] = count($cDatas);
        return $data;
    }

    protected function _frontInfoArray()
    {
        return [              
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'note' => $this->note,
            'description' => $this->discription,
            'author' => $this->authorInfo,
            'coverUrl' => '',
            'tag' => $this->formatTagDatas($this->tagInfos),
        ];
    }
}
