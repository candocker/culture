<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class SeriesVolume extends AbstractResource
{
    protected function _frontInfoArray()
    {
        //$volumes = $this->volumes;
        //$vDatas = $this->getCollectionObj('seriesVolume', ['resource' => $volumes, 'scene' => 'frontInfo', 'repository' => $this->getRepositoryObj('seriesVolume'), 'simpleResult' => true]);
        $series = $this->series;
        $press = $this->getRepository()->getKeyValues('press', $this->press);
        $press = empty($press) ? $series->getRepositoryObj()->getKeyValues('press', $series->press) : $press;
        return [              
            'id' => $this->id,
            'name' => $this->name,
            'press' => $press,
            'series_code' => $this->series_code,
            'publish_at' => empty($this->publish_at) ? $series->publish_at : $this->publish_at,
            'description' => $this->description,
            'orderlist' => $this->orderlist,
            'book_num' => $this->book_num,

        ];
    }
}
