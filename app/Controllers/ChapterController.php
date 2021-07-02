<?php

namespace ModuleCulture\Controllers;

use Overtrue\Pinyin\Pinyin;

class ChapterController extends AbstractController
{
	use DealBookTrait;
	public function init()
	{
		parent::init();
		//$this->dealLuxun();
	}

	public function actionList()
	{
        $bookCode = $this->getInputParams('book_code');
        $book = $this->getPointModel('book')->getInfo($bookCode, 'code');
        if (empty($book)) {
            return $this->returnResult(['status' => 400, 'message' => '书籍不存在']);
        }   
		$provider = $this->_getProviderObj('chapter');
		$provider->sort = [
			'sortParam' => 'sortfield',
            'defaultOrder' => [
                'serial' => SORT_ASC,            
            ]
        ];

        if ($this->checkAjax()) {
			$return = $this->formatListDatas($provider);
            return $return;
        }   

        return $this->render('/scene/detail', ['info' => $info]);
	}

	public function actionShow($id = NULL)
	{
        $bookCode = $this->getInputParams('code');
        $book = $this->getPointModel('book')->getInfo($bookCode, 'code');
        if (empty($book)) {
            return $this->returnResult(['status' => 400, 'message' => '书籍不存在']);
        }   
        $serial = $this->getInputParams('id');
		$serial = empty($serial) ? 1 : $serial;
        $info = $this->model->getInfo(['book_code' => $bookCode, 'serial' => $serial]);
        if (empty($info) || $info['book_code'] != $bookCode) {
            return $this->returnResult(['status' => 400, 'message' => '段落不存在']);
        }   
		$datas = [
			'book' => $book->formatToArray(true),
			'chapter' => $info->_restBaseData('show'),
		];
		return ['status' => 200, 'message' => 'OK', 'datas' => $datas];
	}

	public function getModelCode()
	{
		return 'chapter';
	}
}
