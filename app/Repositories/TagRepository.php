<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class TagRepository extends AbstractRepository
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

	public function _statusKeyDatas()
	{
		return [
			'nav' => '导航标签',
			'hot' => '热门标签',
			'comment' => '推荐标签',
		];
	}
}
