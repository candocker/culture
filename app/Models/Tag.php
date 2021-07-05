<?php

namespace ModuleCulture\Models;

//use baseapp\models\TagTrait;

class Tag extends AbstractModel
{
    protected $table = 'tag';
	//use TagTrait;

	public function getStatusInfos()
	{
		return [
			'nav' => '导航标签',
			'hot' => '热门标签',
			'comment' => '推荐标签',
		];
	}

	public function getBookDatas($where, $number = 10)
	{
		$tags = $this->getPointModel('tag-culture')->getInfos(['where' => $where, 'orderBy' => ['orderlist' => SORT_DESC], 'indexBy' => 'code']);
		$datas = [];
		foreach ($tags as $code => $tag) {
			$datas[$code] = $tag->toArray();
			$datas[$code]['books'] = $this->getPointModel('book')->getDatasByTagCode($tag['code'], 10);
		}
		return $datas;
	}
}
