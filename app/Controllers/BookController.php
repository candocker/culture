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

    public function epub()
    {
        $model = $this->getModelObj();
        $infos = $model->where(['extfield1' => ''])->limit(100)->get();
        foreach ($infos as $book) {
            $epubService = $this->getServiceObj('epub');
            $epubService->initBook();
            $epubService->renderBook($book);
            $epubService->renderMeta($book);
            $epubService->renderChapters($book->chapters);
            $result = $epubService->outputBook($book);
            $book->extfield1 = 'epub';
            $book->save();
        }
        return $this->success();
    }
}
