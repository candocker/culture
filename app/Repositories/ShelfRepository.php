<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class ShelfRepository extends AbstractRepository
{
    public function getDefaultShelf($userId)
    {
        $where = ['user_id' => $userId, 'name' => 'defaultshelf'];
        $model = $this->getModelObj('shelf');
        $shelf = $model->where($where)->first();
        if (!empty($shelf)) {
            return $shelf;
        }
        return $model->create($where);
    }

    public function getMylist($userData)
    {
        $model = $this->model;
        $infos = $model->where(['user_id' => $userData['id']])->get();
        $infos = $infos->keyBy('name');
        $datas = [];
        $baseBooks = [];
        $shelfBookRepository = $this->getRepositoryObj('shelfBook');
        foreach ($infos as $name => $info) {
            if ($name == 'defaultshelf') {
                $baseBooks = $this->getCollectionObj($info->books, 'shelfList', 'shelfBook');
                $baseBooks = $baseBooks->toArray();
                continue;
            }
            $datas[] = [
                'shelf_id' => $info['id'],
                'type' => 2,
                'title' => $name,
                'itemList' => $this->getCollectionObj($info->books, 'shelfList', 'shelfBook'),
            ];
        }
        /*foreach ($baseBooks as $baseBook) {
            $bData = $baseBook->toArray();
            $bData['type'] = 1;
            $datas[] = $bData;
        }*/
        return array_merge($datas, $baseBooks);
        $infos = $this->getCollectionObj($infos, 'shelfList');
    }

    public function createData($name, $userId, $throw = true)
    {
        $exist = $this->model->where(['name' => $name, 'user_id' => $userId])->first();
        if (!empty($exist)) {
            if (empty($throw)) {
                return $exist;
            }
            throw $this->resource->throwException(400, '您指定的书架已存在，请重新命名');
        }
        $newData = [
            'name' => $name,
            'user_id' => $userId,
        ];
        $new = $this->model->create($newData);
        return $new;
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
