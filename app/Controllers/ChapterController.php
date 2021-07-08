<?php

namespace ModuleCulture\Controllers;

use Overtrue\Pinyin\Pinyin;

class ChapterController extends AbstractController
{
    public function detail()
    {
        $repository = $this->getRepositoryObj();
        $info = $this->getPointChapter($repository);
        $resource = $this->getResourceObj(null, ['resource' => $info, 'scene' => 'frontDetail', 'repository' => $repository, 'simpleResult' => false]);
        $book = $info->book;
        $bookData = $this->getResourceObj('book', ['resource' => $book, 'scene' => 'frontDetail', 'repository' => $repository, 'simpleResult' => false]);
        return $this->success(['chapter' => $resource, 'book' => $bookData]);
    }

    public function epub()
    {
        $book = [];
        $epubService = $this->getServiceObj('epub');
        $epubService->initBook();
        $epubService->renderBook($book);
        $epubService->renderMeta($book);
        $epubService->renderChapters($book);
        return $epubService->outputBook();
    }

    public function getPointChapter($repository)
    {
        $request = $this->getPointRequest('', $repository);
        $params = $request->all();

        $serial = $this->getInputParams('serial');
		$serial = empty($serial) ? 1 : $serial;
        $info = $repository->findWhere(['book_code' => $params['code'], 'serial' => $serial]);
        if (empty($info)) {
            $this->resource->throwException('参数有误');
        }
        return $info;
        //$info = $this->getPointInfo($repository, $request, false);
    }

	/*public function actionList()
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
    }*/
}
