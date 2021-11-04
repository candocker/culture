<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class FigureTitleRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'figure_code', 'type', 'title', 'description', 'created_at', 'status'],
            'listSearch' => ['id', 'type', 'title'],
        ];
    }

    public function getShowFields()
    {
        return [
            'type' => ['valueType' => 'key'],
        ];
    }

    public function getSearchFields()
    {
        return [
            'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
        ];
    }

    public function getFormFields()
    {
        return [
            //'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
        ];
    }

    protected function _typeKeyDatas()
    {
        return [
            0 => '未激活',
            1 => '使用中',
            99 => '锁定',
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
