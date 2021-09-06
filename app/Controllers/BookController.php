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
        return $this->success(['positionBooks' => $positionBooks, 'navBooks' => $navBooks]);
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
            $query = $query->orWhere('category_first', $category)->orWhere('category_second', $category)->orWhere('category_third', $category);
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
        $infos = $model->where(['extfield1' => ''])->limit(100)->get();
        //$infos = $model->where(['code' => 'zhongguozhexuejs'])->limit(100)->get();
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
