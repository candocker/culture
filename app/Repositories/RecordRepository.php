<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class RecordRepository extends AbstractRepository
{
    public function getMyRecords($book)
    {
        $datas = [];
        $userData = $this->resource->getCurrentUser();
        $infos = $this->model->where(['book_code' => $book->code, 'user_id' => $userData['id']])->get();
        return $this->getCollectionObj($infos, 'frontList');
    }

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
}
