<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class AffairRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'name', 'title', 'brief', 'created_at', 'updated_at', 'status'],
            'listSearch' => ['id', 'name', 'title', 'created_at', 'updated_at', 'status'],
            'add' => ['name', 'title', 'brief', 'status', 'content'],
            'update' => ['name', 'title', 'brief', 'status', 'content'],
        ];
    }

    public function getShowFields()
    {
        return [
            //'type' => ['valueType' => 'key'],
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
