<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class ShelfRepository extends AbstractRepository
{
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
                $baseBooks = $this->getCollectionObj('shelfBook', ['resource' => $info->books, 'scene' => 'shelfList', 'repository' => $shelfBookRepository]);
                continue;
            }
            $datas[] = [
                'shelf_id' => $info['id'],
                'type' => 2,
                'title' => $name,
                'itemList' => $this->getCollectionObj('shelfBook', ['resource' => $info->books, 'scene' => 'shelfList', 'repository' => $shelfBookRepository])
            ];
        }
        /*foreach ($baseBooks as $baseBook) {
            $bData = $baseBook->toArray();
            $bData['type'] = 1;
            $datas[] = $bData;
        }*/
        return array_merge($datas, $baseBooks->toArray());
        $infos = $this->getCollectionObj(null, ['resource' => $infos, 'scene' => 'shelfList', 'repository' => $this]);
    }

    public function createData($data, $userData)
    {
        $exist = $this->model->where(['name' => $data['name'], 'user_id' => $userData['id']])->first();
        if (!empty($exist)) {
            throw $this->resource->throwException(400, '您指定的书架已存在，请重新命名');
        }
        $newData = [
            'name' => $data['name'],
            'user_id' => $userData['id'],
        ];
        $this->model->create($newData);
        return true;
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
