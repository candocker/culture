<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use Framework\Baseapp\Models\Interfaces\BaseModelEventsInterface;

class CategoryObserver
{
    public function saved(BaseModelEventsInterface $model)
    {
        $repository = $model->getRepositoryObj();
        $repository->cacheDatas();
        return true;
    }
}
