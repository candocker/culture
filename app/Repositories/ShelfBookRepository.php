<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class ShelfBookRepository extends AbstractRepository
{
    public function updataShelf($params)
    {
        $userData = $this->resource->getCurrentUser();
        $userId = $userData['id'];
        $this->model->whereHas('shelf', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->withTrashed()->delete();
        //print_r($params);
        foreach ($params as $param) {
            $shelf = $this->_formatShelf($param, $userId);
            if (empty($shelf)) {
                continue;
            }
            $type = $param['type'];
            $items = $type == 1 ? [$param] : $param['itemList'];
            foreach ($items as $item) {
                $this->_updataBook($shelf, $item['id'], $userId);
            }
        }
        return true;
    }

    protected function _formatShelf($param, $userId)
    {
        $shelfId = $param['shelf_id'];
        if (empty($shelfId)) {
            return false;
        }
        if ($shelfId == -2) {
            return $this->getRepositoryObj('shelf')-> getDefaultShelf($userId);
        }
        if ($shelfId == -1) {
            $name = $param['title'];
            return $this->getRepositoryObj('shelf')->createData($name, $userId, false);
        }
        $shelf = $this->getModelObj('shelf')->where(['id' => $shelfId, 'user_id' => $userId])->first();
        if (isset($param['is_delete']) && $param['is_delete']) {
            if (!empty($shelf)) {
                $shelf->delete();
                $this->getModelObj('shelfBook')->where(['shelf_id' => $shelf->id])->forceDelete();
            }
            return $this->getRepositoryObj('shelf')-> getDefaultShelf($userId);
        }
        if ($shelf && isset($param['title']) && $shelf->name != $param['title']) {
            $shelf->name = $param['title'];
            $shelf->save();
        }
        return $shelf;
    }

    protected function _updataBook($shelf, $bookId, $userId)
    {
        $book = $this->getModelObj('book')->where(['id' => $bookId])->first();
        if (empty($book)) {
            return ;
        }
        $model = $this->getModelObj('shelfBook');
        $exist = $model->where(['book_code'=> $book['code'], 'shelf_id' => $shelf->id])->withTrashed()->first();
        if ($exist) {
            $exist->restore();
            return true;
        }
        $newData = [
            'book_code' => $book['code'],
            'shelf_id' => $shelf['id'],
        ];
        $model->create($newData);
        return true;
    }

    public function record($bookCode, $type)
    {
        $userData = $this->resource->getCurrentUser();
        $userId = $userData['id'];
        $exist = $this->model->where(['book_code' => $bookCode])->whereHas('shelf', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->withTrashed()->first();
        if ($exist) {
            $type == 'remove' && $exist->delete();
            $type == 'add' && $exist->restore();
            return true;
        }
        if ($type == 'removel') {
            return true;
        }
        $defaultShelf = $this->getRepositoryObj('shelf')->getDefaultShelf($userId);
        $newData = [
            'book_code' => $bookCode,
            'shelf_id' => $defaultShelf->id,
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
