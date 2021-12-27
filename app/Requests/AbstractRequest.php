<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

use Framework\Baseapp\Requests\AbstractRequest as AbstractRequestBase;

class AbstractRequest extends AbstractRequestBase
{
    protected function getAppcode()
    {
        return 'culture';
    }
}
