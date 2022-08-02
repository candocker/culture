<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class SeriesRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'name'],
            'listSearch' => ['id', 'name'],
            'add' => ['name'],
            'update' => ['name'],
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

    public function getSeriesDatas($pointCodes)
    {
        $pointSortStr = implode(',', $pointCodes);
        $infos = $this->whereIn('code', $pointCodes)->orderByRaw(\DB::raw("FIND_IN_SET(code, '{$pointSortStr}') asc"))->get();
        $datas = $this->getCollectionObj(null, ['resource' => $infos, 'scene' => 'frontInfo', 'repository' => $this, 'simpleResult' => true]);
        return $datas;
    }
}
