<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Category;

class CategoryObserver
{
    public function saved(Category $model)
    {
        $repository = $model->getRepositoryObj();
        $repository->cacheDatas();
        return true;
    }
}
