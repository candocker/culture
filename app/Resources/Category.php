<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Category extends AbstractResource
{
    protected function _frontInfoArray()
    {
        $url = $this->_repository->getAttachmentUrl(['info_table' => 'category', 'info_field' => 'thumb', 'info_id' => $this->code]);
        $suffix = '?x-oss-process=image/resize,m_pad,h_350,w_250';
        return [              
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'bookNum' => $this->book_num,
            'thumbUrl' => $url ? $url . $suffix : 'http://ossfile.canliang.wang/book/33532bc9-66f5-4d59-83c3-1d4b6f186096.jpg' . $suffix,
        ];
    }
}
