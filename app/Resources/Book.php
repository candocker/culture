<?php

namespace ModuleCulture\Resources;

class Book extends AbstractResource
{
    protected function _frontBaseArray()
    {
        $author = $this->authorData();
        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'nameWiki' => $this->wrapWiki($this->name),
            'author' => $author ? $author['name'] : '',
            'authorWiki' => $author ? $author->wrapWiki() : '',
            'coverUrl' => $this->coverUrl,
            'coverUrlElem' => $this->wrapPicture($this->coverUrl, 'html'),
            'description' => $this->description,//$this->textMore($this->code, $this->description),
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
            'tag' => $this->formatTagDatas(),
        ];
    }
}
