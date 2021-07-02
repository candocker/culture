<?php

namespace ModuleCulture\Models;

//use baseapp\models\TagInfoTrait;

class TagInfo extends AbstractModel
{
	//use TagInfoTrait;

	public function getInfoTypeInfos()
	{
		return [
			'book' => '书籍',
			'chapter' => '段落内容',
			'author' => '作者',
		];
	}
}
