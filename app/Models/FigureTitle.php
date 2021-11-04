<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class FigureTitle extends AbstractModel
{
    protected $table = 'figure_title';
    protected $guarded = ['id'];

    public function recordTitle($string, $figureCode = 'test')
    {
        $string = str_replace(['，', '：', '；'], [',', ':', ';'], $string);
        $titles = strpos($string, ';') !== false ? explode(';', $string) : [$string];
        print_r($titles);exit();
        foreach ($titles as $title) {
            if (strpos($title, ':') === false) {
                echo $title;
                continue;
            }
            list($type, $names) = explode($title, ':');
            $names = strpos($names, ',') !== false ? explode($names, ',') : [$names];
            foreach ($names as $name) {
                $this->createRecord($figureCode, $type, $name);
            }
        }
        return true;
    }

    protected function createRecord($figureCode, $type, $name)
    {
        var_dump($figureCode);
        var_dump($type);
        var_dump($name);
        exit();
    }
}
