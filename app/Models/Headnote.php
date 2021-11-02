<?php

namespace ModuleCulture\Models;

class Headnote extends AbstractModel
{
    protected $table = 'headnote';
    protected $guarded = ['id'];

    /*public function rules()
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
    }*/
}
