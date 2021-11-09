<?php

declare(strict_types = 1);

namespace ModuleCulture\Observers;

use ModuleCulture\Models\Book;

class BookObserver
{
    public function saved(Book $model)
    {
        $model->afterSave();
        return true;
    }
}
