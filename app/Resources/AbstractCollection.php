<?php

namespace ModuleCulture\Resources;

use Framework\Baseapp\Resources\AbstractCollection as AbstractCollectionBase;

class AbstractCollection extends AbstractCollectionBase
{
    protected function getAppcode()
    {
        return 'culture';
    }
}
