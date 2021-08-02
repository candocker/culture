<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Record;

class RecordObserver
{
    public function created(Record $model)
    {
        $model->onCreated();
    }

    public function updated(Record $model)
    {
        $model->onUpdated();
    }
}
