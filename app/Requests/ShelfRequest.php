<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

class ShelfRequest extends AbstractRequest
{
    protected function _createRule()
    {
        return [
            'name' => ['bail', 'required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            //'name' => '名称',
        ];
    }

    public function messages(): array
    {
        return [
            //'name.required' => '请填写名称',
        ];
    }
}
