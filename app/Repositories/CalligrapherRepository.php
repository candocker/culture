<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class CalligrapherRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'code', 'name', 'thumb', 'title', 'dynasty', 'nickname', 'name_full', 'description', 'orderlist', 'birthday', 'deathday', 'status', 'created_at'],
            'listSearch' => ['id', 'name', 'dynasty'],
            'add' => ['name'],
            'update' => ['name'],
        ];
    }

    public function getShowFields()
    {
        return [
            'dynasty' => ['valueType' => 'key'],
            'thumb' => ['valueType' => 'callback', 'method' => 'tmpThumb', 'showType' => 'common'],
        ];
    }

    public function getSearchFields()
    {
        return [
            'dynasty' => ['type' => 'select'],
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
