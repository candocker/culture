<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

class RecordRequest extends AbstractRequest
{
    protected function _myRecordRule()
    {
        return [
            'book_code' => ['bail', 'required', 'exists:culture.book,code'],
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
