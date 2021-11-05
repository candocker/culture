<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Figure;

class FigureObserver
{
    public function saved(Figure $model)
    {
        $model->afterSave();
        return true;
    }
}
