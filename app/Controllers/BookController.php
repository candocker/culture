<?php

namespace ModuleCulture\Controllers;

use Overtrue\Pinyin\Pinyin;

class BookController extends AbstractController
{
	use DealBookTrait;
	public function init()
	{
		parent::init();
		//$this->dealBook();exit();
	}

	public function actionIndexDatas()
	{
		$where = ['position' => ['hot', 'comment']];
		$positions = $this->model->positionInfos;
		$datas = [];
		foreach ($positions as $position => $pName) {
			$data['name'] = $pName;
			$bDatas = $this->model->getInfos(['where' => ['position' => $position], 'orderBy' => ['orderlist' => SORT_DESC], 'limit' => 10]);
			$data['books'] = $this->_formatListSimple($bDatas);
			$datas[$position] = $data;
		}
		return ['status' => 200, 'message' => 'OK', 'datas' => $datas];
	}

	public function getModelCode()
	{
		return 'book';
	}

	public function _getViewFields()
	{
		return ['code'];
	}
}
