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
            'year' => isset($date[0]) ? intval(trim($date[0])) : 0,
            'month' => isset($date[1]) ? intval(trim($date[1])) : 0,
            'day' => isset($date[2]) ? intval(trim($date[2])) : 0,
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

    public function formatDateinfo($type = 'source')
    {
        if ($type == 'source') {
            return $this->era_type . '|' . $this->accurate . '|' . $this->year . '/' . $this->month . '/' . $this->day;
        }
        $repository = $this->getRepositoryObj('dateinfo');
        $accurateInfos = $repository->getKeyValues('accurate');
        $eraInfos = $repository->getKeyValues('eraType');
        if (in_array($this->accurate, ['running', 'unknown'])) {
            return $accurateInfos[$this->accurate];
        }
        $eraStr = $this->era_type != '' ? $eraInfos[$this->era_type] . ' ' : '';
        $dateStr = $this->year . '/' . $this->month . '/' . $this->day;
        $accurateStr = empty($this->accurate) ? '' : " ( {$accurateInfos[$this->accurate]} )";
        return $eraStr . $dateStr . $accurateStr;
    }
}
