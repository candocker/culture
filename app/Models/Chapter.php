<?php

namespace ModuleCulture\Models;

class Chapter extends AbstractModel
{
    public function rules()
    {
        return [
			[['name'], 'required'],
            [['status'], 'default', 'value' => ''],
            [['description'], 'safe'],
        ];
    }

    protected function _getTemplatePointFields()
    {
        return [
            'plat' => ['type' => 'key'],
			'login_url' => ['type' => 'inline', 'method' => '_getLoginUrl', 'formatView' => 'raw'],
			'listNo' => [
				'updated_at', 'description'
			],
        ];
    }

	public function getContent()
	{
		return $this->getChapterFile($this);
	}

	public function _relateDataInfos()
	{
		return ['book'];
	}

	public function _sceneFields()
	{
		return [
			'show' => ['id', 'name', 'serial', 'content'],
			'ext' => ['content'],
			'list' => ['id', 'name', 'code', 'serial'],
			'listNo' => ['content'],
		];
	}
}
