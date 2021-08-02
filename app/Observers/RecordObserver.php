<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use Framework\Baseapp\Models\Interfaces\BaseModelEventsInterface;

class RecordObserver
{
    public function created(BaseModelEventsInterface $model)
    {
        $model->onCreated();
    }

    public function updated(BaseModelEventsInterface $model)
    {
        $model->onUpdated();
    }
}
