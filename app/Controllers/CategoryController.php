<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class CategoryController extends AbstractController
{
    public function cache()
    {
        $this->getRepositoryObj()->cacheDatas();
        return $this->success([]);
    }
}
