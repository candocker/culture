<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

class ShelfBookRequest extends AbstractRequest
{
    protected function _recordRule()
    {
        return [
            'book_code' => ['bail', 'required', 'exists:culture.book,code'],
            'type' => ['bail', 'required', 'in:add,remove'],
        ];
    }

    protected function _updateRule()
    {
        return [
            'id' => ['bail', 'required', 'exists'],
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
