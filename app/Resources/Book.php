<?php

namespace ModuleCulture\Resources;

class Book extends AbstractResource
{
    protected function _frontBaseArray()
    {
        $data = [
            'code' => $this->code,
            'name' => $this->wrapWiki($this->name),
            'coverUrl' => $this->wrapPicture($this->coverUrl, 'html'),
            'description' => $this->textMore($this->code, $this->description),
            'colspan' => 1,
        ];
        return $data;
    }

    protected function _frontDetailArray()
    {
        $data = $this->_frontInfoArray();
        $data['coverUrl'] = $this->wrapPicture($this->coverUrl, 'original');
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
            'description' => $this->description,
            'author' => $this->authorData(),//$this->authorInfo,
            'coverUrl' => $this->wrapPicture($this->coverUrl),
            'tag' => $this->formatTagDatas($this->tagInfos),
        ];
    }
}
