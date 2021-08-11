<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

use Framework\Baseapp\Repositories\AbstractRepository as AbstractRepositoryBase;

class AbstractRepository extends AbstractRepositoryBase
{
    public function getDefaultShowFields()
    {
        return array_merge(parent::getDefaultShowFields(), [
            //'user_id' => ['valueType' => 'common'],
        ]);
    }

    public function _readStatusKeyDatas()
    {
        return [
            0 => '阅读中',
            1 => '已阅',
        ];
    }

    protected function getAppcode()
    {
        return 'culture';
    }

    public function _categoryKeyDatas()
    {
        return $this->getPointCaches('category');
    }
}
