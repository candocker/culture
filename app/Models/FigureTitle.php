<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FigureTitle extends AbstractModel
{
    use SoftDeletes;
    protected $table = 'figure_title';
    protected $guarded = ['id'];

    public function recordTitle($string, $figureCode)
    {
        $this->where('figure_code', $figureCode)->delete();
        $string = str_replace(['，', '：', '；'], [',', ':', ';'], $string);
        $titles = strpos($string, ';') !== false ? explode(';', $string) : [$string];
        foreach ($titles as $title) {
            if (strpos($title, ':') === false) {
                continue;
            }
            list($type, $names) = explode(':', $title);
            $names = strpos($names, ',') !== false ? explode(',', $names) : [$names];
            foreach ($names as $name) {
                $this->createRecord($figureCode, $type, $name);
            }
        }
        return true;
    }

    protected function createRecord($figureCode, $type, $name)
    {
        $data = ['type' => $type, 'title' => $name, 'figure_code' => $figureCode];
        $exist = $this->withTrashed()->where($data)->first();
        if ($exist) {
            return $exist->trashed() ? $exist->restore() : true;
        }

        return $this->create($data);
    }
}
