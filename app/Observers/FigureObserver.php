<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Figure;

class FigureObserver
{
    public function saving(Figure $model)
    {
        $model->afterSave();
        return true;
    }
}
