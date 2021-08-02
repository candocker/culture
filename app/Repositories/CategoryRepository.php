<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class CategoryRepository extends AbstractRepository
{
    public function cacheDatas()
    {
        $datas = $this->findWhere(['status' => 1]);
        $datas = $datas->keyBy('code');
        $keyValues = $datas->map(function ($value, $key) {
            return $value['name'];
        });
        $this->setPointCaches('category', $datas->toArray());
        $this->setPointCaches('category', $keyValues->toArray(), 'tree');
        return $datas;
    }

    protected function _sceneFields()
    {
        return [
            'list' => ['code', 'name', 'book_num', 'thumb', 'orderlist', 'description', 'status'],
            'listSearch' => ['code', 'name'],
            'add' => ['code', 'name', 'thumb', 'orderlist', 'description', 'status'],
            'update' => ['code', 'name', 'thumb', 'orderlist', 'description', 'status'],
        ];
    }

    public function getShowFields()
    {
        return [
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

    protected function _getFieldOptions()
    {
        return [
            'book_num' => ['name' => '图书数量'],
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
