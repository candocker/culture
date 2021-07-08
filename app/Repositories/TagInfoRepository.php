<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class TagInfoRepository extends AbstractRepository
{
    protected function _statusKeyDatas()
    {
        return [
        ];
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

	public function _info_typeKeyDatas()
	{
		return [
			'book' => '书籍',
			'chapter' => '段落内容',
			'author' => '作者',
		];
	}
}
