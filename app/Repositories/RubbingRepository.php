<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class RubbingRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'name', 'title', 'thumb', 'calligrapher_code', 'dynasty', 'calligraphy_style', 'orderlist', 'page_number', 'word_number', 'description', 'width', 'height', 'status', 'created_at'],
            'listSearch' => ['id', 'name'],
            'add' => ['name'],
            'update' => ['name'],
        ];
    }

    public function getShowFields()
    {
        return [
            'dynasty' => ['valueType' => 'key'],
            'calligraphy_style' => ['valueType' => 'key'],
            'calligrapher_code' => ['valueType' => 'point', 'relate' => 'calligrapher'],
            'thumb' => ['valueType' => 'callback', 'method' => 'tmpThumb', 'showType' => 'common'],
        ];
    }

    public function getSearchFields()
    {
        return [
            //'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
        ];
    }

    public function getFormFields()
    {
        return [
            //'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
        ];
    }

    protected function _statusKeyDatas()
    {
        return [
            0 => '未激活',
            1 => '使用中',
            99 => '锁定',
        ];
    }
}
