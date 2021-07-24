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
        $url = $this->_repository->getAttachmentUrl(['info_table' => 'book', 'info_field' => 'cover', 'info_id' => $this->code]);
        return [              
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'note' => $this->note,
            'description' => $this->discription,
            'author' => $this->authorInfo,
            'coverUrl' => $url ? $url . '?x-oss-process=image/resize,m_pad,h_350,w_250' : '',
            'tag' => $this->formatTagDatas($this->tagInfos),
        ];
    }
}
