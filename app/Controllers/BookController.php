<?php

namespace ModuleCulture\Controllers;

use Overtrue\Pinyin\Pinyin;

class BookController extends AbstractController
{
	use DealBookTrait;

	public function home()
	{
        $repository = $this->getRepositoryObj();
        $positionBooks = $repository->getPositionBooks();
        $navBooks = $repository->getNavBooks();
        $bannerInfos = $this->getServiceObj('infocms-fetchData')->getBannerInfos('book', 'home');
        return $this->success(['positionBooks' => $positionBooks, 'navBooks' => $navBooks, 'bannerInfos' => $bannerInfos]);
	}

	public function frontList()
	{
        $repository = $this->getRepositoryObj();
        $model = $this->getModelObj();
        $request = $this->getPointRequest();
        $where = [];
        $query = $model->query();
        $category = $request->input('category');
        $keyword = $request->input('keyword');
        if (!empty($category)) {
            $query = $query->where('category', $category);
        }
        if (!empty($keyword)) {
            $query = $query->where('name', 'like', "%{$keyword}%");
        }
        $infos = $query->get();
        $infos = $this->getCollectionObj(null, ['resource' => $infos, 'scene' => 'frontInfo', 'repository' => $repository, 'simpleResult' => true]);
        return $this->success(['books' => $infos, 'total' => count($infos)]);
	}

    public function epub()
    {
        $model = $this->getModelObj();
        //$infos = $model->where(['type' => 'epub', 'extfield1' => ''])->limit(100)->get();
        $infos = $model->whereIn('code', ['shijizhu'])->limit(100)->get();
        foreach ($infos as $book) {
            $epubService = $this->getServiceObj('epub');
            $epubService->initBook();
            $epubService->renderBook($book);
            $epubService->renderChapters($book->chapters);
            $epubService->renderMeta($book);
            $result = $epubService->outputBook($book);
            $book->extfield1 = 'epub';
            $book->save();
        }
        return $this->success();
    }
}
