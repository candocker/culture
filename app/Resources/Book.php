<?php

namespace ModuleCulture\Resources;

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
        $suffix = '?x-oss-process=image/resize,m_pad,h_350,w_250';
        return [              
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'note' => $this->note,
            'description' => $this->description,
            'author' => $this->authorInfo,
            'coverUrl' => $this->coverUrl . $suffix,
            'tag' => $this->formatTagDatas($this->tagInfos),
        ];
    }
}
