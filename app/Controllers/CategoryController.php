<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class CategoryController extends AbstractController
{
	public function home()
	{
        $repository = $this->getRepositoryObj();
        $categories = $repository->all();
        $infos = $this->getCollectionObj(null, ['resource' => $categories, 'scene' => 'frontInfo', 'repository' => $repository, 'simpleResult' => true]);
        return $this->success($infos);
	}

    public function cache()
    {
        $this->getRepositoryObj()->cacheDatas();
        return $this->success([]);
    }
}
