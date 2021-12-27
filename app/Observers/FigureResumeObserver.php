<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\FigureResume;

class FigureResumeObserver
{
    public function saved(FigureResume $model)
    {
        $model->afterSave();
        return true;
    }
}
