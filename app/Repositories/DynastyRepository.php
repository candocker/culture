<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class DynastyRepository extends AbstractRepository
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

    public function getDetail($code)
    {
        $model = $this->getModelObj();
        $info = $model->where(['code' => $code])->first();
        $emperors = $info->emperors;
        $emperors = $this->getModelObj('emperor')->limit(10)->get();
        $emperorDatas = $this->getCollectionObj($emperors, 'frontDetail', 'emperor');

        $resource = $this->getResourceObj($info, 'frontDetail');
        return ['base' => $resource, 'emperorDatas' => $emperorDatas];
    }
}
