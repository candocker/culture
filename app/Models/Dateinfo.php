<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Dateinfo extends AbstractModel
{
    protected $table = 'dateinfo';
    protected $guarded = ['id'];

    public function recordDateinfo($type, $value, $infoType, $infoKey)
    {
        $formatedValue = explode('|', $value);
        if (count($formatedValue) != 3) {
            return true;
        }
        $date = trim($formatedValue[2]);
        $date = explode('/', $date);
        $updateData = [
            'era_type' => trim($formatedValue[0]),
            'accurate' => trim($formatedValue[1]),
            'year' => isset($date[0]) ? trim($date[0]) : 0,
            'month' => isset($date[1]) ? trim($date[1]) : 0,
            'day' => isset($date[2]) ? trim($date[2]) : 0,
        ];
        
        $data = ['type' => $type, 'info_type' => $infoType, 'info_key' => $infoKey];
        $exist = $this->where($data)->first();
        if ($exist) {
            foreach ($updateData as $field => $fValue) {
                $exist->$field = $fValue;
            }
            return $exist->save();
        }
        return $this->create(array_merge($data, $updateData));
    }
}
