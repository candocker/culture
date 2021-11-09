<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

class BookRequest extends AbstractRequest
{
    protected function _updateRule()
    {
        return [
            //'id' => ['bail', 'required'],
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

    public function filterDirtyData($data)
    {
        foreach (['creative'] as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
                $this->allowEmpty = true;
            }
        }
        return $data;
    }
}
