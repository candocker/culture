<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class DateinfoRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'type', 'era_type', 'info_type', 'info_id', 'mark', 'year', 'month', 'day', 'created_at', 'status'],
            'listSearch' => ['id', 'type', 'era_type', 'mark', 'year', 'month', 'day', 'status'],
        ];
    }

    public function getShowFields()
    {
        return [
            'type' => ['valueType' => 'key'],
            'era_type' => ['valueType' => 'key'],
            'mark' => ['valueType' => 'key'],
        ];
    }

    public function getSearchFields()
    {
        return [
            'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
            'era_type' => ['type' => 'select', 'infos' => $this->getKeyValues('eraType')],
            'mark' => ['type' => 'select', 'infos' => $this->getKeyValues('mark')],
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
            'start' => '起始日期',
            'end' => '截止日期',
            'birthday' => '出生日期',
            'deathday' => '逝世日期',
        ];
    }

    protected function _eraTypeKeyDatas()
    {
        return [
            'ad' => '公元',
            'bc' => '公元前',
        ];
    }

    protected function _markKeyDatas()
    {
        return [
            '' => '',
            'unknown' => '未知',
            'probably' => '大概',
        ];
    }
}
