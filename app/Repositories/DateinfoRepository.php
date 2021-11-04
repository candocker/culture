<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class DateinfoRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'type', 'era_type', 'info_type', 'info_id', 'accurate', 'year', 'month', 'day', 'created_at', 'status'],
            'listSearch' => ['id', 'type', 'era_type', 'accurate', 'year', 'month', 'day', 'status'],
        ];
    }

    public function getShowFields()
    {
        return [
            'type' => ['valueType' => 'key'],
            'era_type' => ['valueType' => 'key'],
            'accurate' => ['valueType' => 'key'],
        ];
    }

    public function getSearchFields()
    {
        return [
            'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
            'era_type' => ['type' => 'select', 'infos' => $this->getKeyValues('eraType')],
            'accurate' => ['type' => 'select', 'infos' => $this->getKeyValues('accurate')],
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

    protected function _typeKeyDatas()
    {
        return [
            'birthday' => '出生日期',
            'deathday' => '逝世日期',
            'start' => '起始日期',
            'end' => '截止日期',
            'termstart' => '任期起始日期',
            'termend' => '任期截止日期',
            'termstart2' => '第一任期起始日期',
            'termend2' => '第二任期截止日期',
        ];
    }
}
