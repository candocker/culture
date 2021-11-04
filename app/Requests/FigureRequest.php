<?php

declare(strict_types = 1);

namespace ModuleCulture\Requests;

class FigureRequest extends AbstractRequest
{
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

    public function getInputDatas($type)
    {
        $data = parent::getInputDatas($type);
        if (isset($data['othername'])) {
            unset($data['othername']);
        }
        return $data;
    }
}
