<?php

namespace ModuleCulture\Models;

class Figure extends AbstractModel
{
    protected $table = 'figure';

    public function rules()
    {
        return [
			[['code', 'name'], 'required'],
            [['status'], 'default', 'value' => ''],
            [['deathday', 'birthday'], 'default', 'value' => 0],
			//[['birthday', 'deathday'], 'filter', 'filter' => function($value) {
				//return strtotime($value);
			//}],
            [['title', 'nickname', 'birthday', 'deathday', 'description'], 'safe'],
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
}
