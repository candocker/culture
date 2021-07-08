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
}
