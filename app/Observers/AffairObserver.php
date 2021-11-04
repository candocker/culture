<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Affair;

class AffairObserver
{
    public function saving(Affair $model)
    {
        $model->afterSave();
        return true;
    }
}
