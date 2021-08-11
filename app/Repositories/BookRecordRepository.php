<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class BookRecordRepository extends AbstractRepository
{
    public function getMyRecord($userData)
    {
        $model = $this->model;
        $infos = $model->where(['user_id' => $userData['id']])->get();
        return $this->getCollectionObj(null, ['resource' => $infos, 'scene' => 'frontList', 'repository' => $this]);
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

    public function getFormFields()
    {
        return [
        ];
    }

    public function getSearchFields()
    {
        return [
        ];
    }

    public function getSearchDealFields()
    {
        return [
        ];
    }

    public function _getFieldOptions()
    {
        return [
        ];
    }

    protected function _statusKeyDatas()
    {
        return [
        ];
    }
}
