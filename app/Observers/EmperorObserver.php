<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Emperor;

class EmperorObserver
{
    public function saving(Emperor $model)
    {
        $model->afterSave();
        return true;
    }
}
