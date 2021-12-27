<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class DiagramRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'name', 'title', 'sort', 'code', 'orderlist', 'created_at', 'visit_num', 'favour_num', 'status'],
            'view' => ['id', 'name', 'title', 'sort', 'code', 'orderlist', 'created_at', 'visit_num', 'favour_num', 'status', 'content'],
            'listSearch' => ['id', 'name', 'title', 'sort', 'code', 'created_at', 'status'],
            'add' => ['name', 'title', 'sort', 'code', 'orderlist', 'description', 'status', 'content'],
            'update' => ['name', 'title', 'sort', 'code', 'orderlist', 'description', 'status', 'content'],
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
