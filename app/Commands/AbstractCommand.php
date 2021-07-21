<?php

declare(strict_types = 1);

namespace ModuleCulture\Commands;

use Framework\Baseapp\Commands\AbstractCommand as AbstractCommandBase;

abstract class AbstractCommand extends AbstractCommandBase
{

    protected function getAppcode()
    {
        return 'culture';
    }
}
