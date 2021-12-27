<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class FigureResumeRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'figure_code', 'name', 'title', 'start', 'end', 'period', 'term', 'party', 'description', 'status'],
            'listSearch' => ['id', 'name', 'figure_code'],
            'add' => ['figure_code', 'type', 'name', 'title', 'start', 'end', 'period', 'term', 'party', 'description', 'status', 'content'],
            'update' => ['figure_code', 'type', 'name', 'title', 'start', 'end', 'period', 'term', 'party', 'description', 'status', 'content'],
        ];
    }

    public function getShowFields()
    {
        return [
            'type' => ['valueType' => 'key'],
            'start' => ['valueType' => 'extinfo', 'extType' => 'dateinfo'],
            'end' => ['valueType' => 'extinfo', 'extType' => 'dateinfo'],
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
            'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
            'start' => ['type' => 'dateinfo', 'accurateInfos' => $this->getKeyValues('accurate'), 'eraInfos' => $this->getKeyValues('eraType')],
            'end' => ['type' => 'dateinfo', 'accurateInfos' => $this->getKeyValues('accurate'), 'eraInfos' => $this->getKeyValues('eraType')],
            'figure_code' => ['type' => 'selectSearch', 'require' => ['add'], 'searchResource' => 'figure'],
        ];
    }

    public function getSearchDealFields()
    {
        return [
            'figure_code' => ['type' => 'relate', 'elem' => 'figure', 'operator' => 'like', 'field' => 'name'],
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
            'emperor' => '皇帝',
            'tyrant' => '权臣/僭主',
            'usapresident' => '美国总统',
            'leader' => '领袖',
            '' => '其他',
        ];
    }
}
