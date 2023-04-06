<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class BookSortController extends AbstractController
{
	public function home()
	{
        $repository = $this->getRepositoryObj();
        $categories = $repository->query()->orderBy('orderlist', 'desc')->get();
        $infos = $this->getCollectionObj($categories, 'frontInfo');
        return $this->success($infos);
	}

    public function cache()
    {
        $this->getRepositoryObj()->cacheDatas();
        return $this->success([]);
    }
}
