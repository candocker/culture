<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Dynasty extends AbstractResource
{
    protected function _frontBaseArray()
    {
        $data = [
            'code' => $this->code,
            'name' => $this->wrapWiki($this->name),
            'begin_end' => $this->begin_end,
            'first_emperor' => $this->first_emperor,
            'description' => $this->textMore($this->code, $this->description),
            'colspan' => 1,
        ];
        return $data;
    }

}
