<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

class ChapterRecordRequest extends AbstractRequest
{
    protected function _recordRule()
    {
        $serial = $this->input('serial');
        return [
            'type' => ['bail', 'required', 'in:start,finish'],
            'serial' => ['bail', 'required', 'integer'],
            'book_code' => ['bail', 'required', 'string'],
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
